package com.starpas.banten

import android.annotation.SuppressLint
import android.app.Activity
import android.app.NotificationChannel
import android.app.NotificationManager
import android.content.Intent
import android.content.pm.PackageManager
import android.graphics.Bitmap
import android.net.ConnectivityManager
import android.net.NetworkCapabilities
import android.net.Uri
import android.os.Build
import android.os.Bundle
import android.os.Environment
import android.provider.MediaStore
import android.view.View
import android.view.WindowManager
import android.webkit.CookieManager
import android.webkit.PermissionRequest
import android.webkit.ValueCallback
import android.webkit.WebChromeClient
import android.webkit.WebResourceError
import android.webkit.WebResourceRequest
import android.webkit.WebSettings
import android.webkit.WebView
import android.webkit.WebViewClient
import android.widget.FrameLayout
import android.widget.ProgressBar
import android.widget.Toast
import androidx.activity.OnBackPressedCallback
import androidx.appcompat.app.AppCompatActivity
import androidx.core.app.ActivityCompat
import androidx.core.content.ContextCompat
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout

class MainActivity : AppCompatActivity() {

    private lateinit var webView: WebView
    private lateinit var progressBar: ProgressBar
    private lateinit var swipeRefresh: SwipeRefreshLayout
    private lateinit var errorView: View
    private var filePathCallback: ValueCallback<Array<Uri>>? = null
    private val FILE_REQUEST_CODE = 1001
    private val PERMISSION_REQUEST_CODE = 2001

    @SuppressLint("SetJavaScriptEnabled")
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)

        // Edge-to-edge with status bar matching STARPAS emerald
        window.setFlags(
            WindowManager.LayoutParams.FLAG_LAYOUT_NO_LIMITS,
            WindowManager.LayoutParams.FLAG_LAYOUT_NO_LIMITS
        )

        setContentView(R.layout.activity_main)

        webView = findViewById(R.id.webview)
        progressBar = findViewById(R.id.progressBar)
        swipeRefresh = findViewById(R.id.swipeRefresh)
        errorView = findViewById(R.id.errorView)

        setupWebView()
        setupSwipeRefresh()
        setupBackNavigation()
        requestNotificationPermission()
        createNotificationChannel()

        // Load the app URL or handle deep link
        val targetUrl = intent?.data?.toString() ?: getString(R.string.base_url)
        loadUrl(targetUrl)
    }

    @SuppressLint("SetJavaScriptEnabled")
    private fun setupWebView() {
        webView.settings.apply {
            javaScriptEnabled = true
            domStorageEnabled = true
            databaseEnabled = true
            cacheMode = WebSettings.LOAD_DEFAULT
            setSupportMultipleWindows(true)
            allowFileAccess = true
            allowContentAccess = true
            mediaPlaybackRequiresUserGesture = false
            // Enable DOM cache and app cache for offline mode
            databaseEnabled = true
            domStorageEnabled = true
            // Disable text selection to feel more native (input/textarea still selectable)
            isAllowFileAccessFromFileURLs = false
            isAllowUniversalAccessFromFileURLs = false
            // Better HTTPS handling
            mixedContentMode = WebSettings.MIXED_CONTENT_COMPATIBILITY_MODE
            useWideViewPort = true
            loadWithOverviewMode = true
            builtInZoomControls = false
            displayZoomControls = false
            setSupportZoom(false)
            // User agent: identify as STARPAS Android app for backend analytics
            userAgentString = "$userAgentString STARPASAndroid/1.0"
        }

        // Cookie sync for session-based auth
        CookieManager.getInstance().apply {
            setAcceptCookie(true)
            setAcceptThirdPartyCookies(webView, true)
            flush()
        }

        // JavaScript Bridge for native features
        webView.addJavascriptInterface(AndroidBridge(this), "AndroidBridge")

        // Inject custom CSS/JS on every page load for native-like feel
        webView.setWebViewClient(object : WebViewClient() {
            override fun onPageStarted(view: WebView?, url: String?, favicon: Bitmap?) {
                super.onPageStarted(view, url, favicon)
                progressBar.visibility = View.VISIBLE
                errorView.visibility = View.GONE
            }

            override fun onPageFinished(view: WebView?, url: String?) {
                super.onPageFinished(view, url)
                progressBar.visibility = View.GONE
                swipeRefresh.isRefreshing = false
                injectNativeStyles(view)
            }

            override fun onReceivedError(
                view: WebView?,
                request: WebResourceRequest?,
                error: WebResourceError?
            ) {
                super.onReceivedError(view, request, error)
                if (request?.isForMainFrame == true) {
                    showError(getString(R.string.error_connection))
                }
            }

            override fun shouldOverrideUrlLoading(
                view: WebView?,
                request: WebResourceRequest?
            ): Boolean {
                val url = request?.url?.toString() ?: return false
                val baseUrl = getString(R.string.base_url)

                // Open external links (different host) in browser
                return if (url.startsWith(baseUrl) ||
                    url.contains("starpas.banten.go.id") ||
                    url.contains("starpas-dev.banten.go.id") ||
                    url.startsWith("tel:") ||
                    url.startsWith("mailto:") ||
                    url.startsWith("whatsapp:") ||
                    url.contains("wa.me/") ||
                    url.contains("api.whatsapp.com")) {
                    // Stay in app
                    false
                } else {
                    // External link - open in browser
                    try {
                        startActivity(Intent(Intent.ACTION_VIEW, Uri.parse(url)))
                    } catch (e: Exception) {
                        Toast.makeText(this@MainActivity, "Tidak bisa membuka link", Toast.LENGTH_SHORT).show()
                    }
                    true
                }
            }
        })

        // Handle file upload (for lampiran perizinan)
        webView.webChromeClient = object : WebChromeClient() {
            override fun onShowFileChooser(
                webView: WebView?,
                filePathCallback: ValueCallback<Array<Uri>>?,
                fileChooserParams: FileChooserParams?
            ): Boolean {
                this@MainActivity.filePathCallback?.onReceiveValue(null)
                this@MainActivity.filePathCallback = filePathCallback
                val intent = fileChooserParams?.createIntent()
                    ?: Intent(Intent.ACTION_GET_CONTENT).apply {
                        type = "*/*"
                        addCategory(Intent.CATEGORY_OPENABLE)
                    }
                try {
                    startActivityForResult(intent, FILE_REQUEST_CODE)
                } catch (e: Exception) {
                    this@MainActivity.filePathCallback = null
                    Toast.makeText(this@MainActivity, "File picker tidak tersedia", Toast.LENGTH_SHORT).show()
                    return false
                }
                return true
            }

            override fun onPermissionRequest(request: PermissionRequest?) {
                request?.grant(request.resources)
            }

            override fun onProgressChanged(view: WebView?, newProgress: Int) {
                super.onProgressChanged(view, newProgress)
                if (newProgress in 1..99) {
                    progressBar.progress = newProgress
                } else {
                    progressBar.visibility = View.GONE
                }
            }
        }

        // Allow downloads
        webView.setDownloadListener { url, userAgent, contentDisposition, mimetype, contentLength ->
            try {
                val i = Intent(Intent.ACTION_VIEW)
                i.data = Uri.parse(url)
                startActivity(i)
            } catch (e: Exception) {
                Toast.makeText(this, "Tidak bisa download file", Toast.LENGTH_SHORT).show()
            }
        }
    }

    private fun setupSwipeRefresh() {
        swipeRefresh.setColorSchemeResources(
            R.color.starpas_green_emerald,
            R.color.starpas_gold,
            R.color.starpas_blue
        )
        swipeRefresh.setOnRefreshListener {
            webView.reload()
        }
    }

    private fun setupBackNavigation() {
        onBackPressedDispatcher.addCallback(this, object : OnBackPressedCallback(true) {
            override fun handleOnBackPressed() {
                if (webView.canGoBack()) {
                    webView.goBack()
                } else {
                    // Minimize app instead of closing
                    moveTaskToBack(true)
                }
            }
        })
    }

    private fun loadUrl(url: String) {
        if (isNetworkAvailable()) {
            errorView.visibility = View.GONE
            webView.visibility = View.VISIBLE
            webView.loadUrl(url)
        } else {
            showError(getString(R.string.error_no_internet))
        }
    }

    private fun isNetworkAvailable(): Boolean {
        val cm = getSystemService(CONNECTIVITY_SERVICE) as ConnectivityManager
        val network = cm.activeNetwork ?: return false
        val capabilities = cm.getNetworkCapabilities(network) ?: return false
        return capabilities.hasCapability(NetworkCapabilities.NET_CAPABILITY_INTERNET) &&
                capabilities.hasCapability(NetworkCapabilities.NET_CAPABILITY_VALIDATED)
    }

    private fun showError(message: String) {
        webView.visibility = View.GONE
        errorView.visibility = View.VISIBLE
        val errorText = errorView.findViewById<android.widget.TextView>(R.id.errorText)
        errorText?.text = message
        val retryButton = errorView.findViewById<android.widget.Button>(R.id.retryButton)
        retryButton?.setOnClickListener { loadUrl(getString(R.string.base_url)) }
    }

    private fun injectNativeStyles(view: WebView?) {
        val css = """
            (function() {
                // Apply safe-area padding for Android 15+ gesture bar
                var style = document.createElement('style');
                style.innerHTML = `
                    body {
                        padding-top: env(safe-area-inset-top) !important;
                        padding-bottom: env(safe-area-inset-bottom) !important;
                        padding-left: env(safe-area-inset-left) !important;
                        padding-right: env(safe-area-inset-right) !important;
                    }
                    /* Disable callout and selection for native feel */
                    body, div, span, p, h1, h2, h3, h4, h5, h6 {
                        -webkit-touch-callout: none;
                        -webkit-user-select: none;
                        user-select: none;
                    }
                    /* Allow text selection in form fields */
                    input, textarea, [contenteditable="true"] {
                        -webkit-user-select: text;
                        user-select: text;
                    }
                    /* Add indicator that this is running in Android app */
                    .starpas-android-indicator { display: block !important; }
                `;
                if (!document.getElementById('starpas-android-styles')) {
                    style.id = 'starpas-android-styles';
                    document.head.appendChild(style);
                }

                // Set viewport with viewport-fit=cover if not already set
                var viewport = document.querySelector('meta[name="viewport"]');
                if (viewport) {
                    if (!viewport.content.includes('viewport-fit=cover')) {
                        viewport.content = viewport.content + ', viewport-fit=cover';
                    }
                } else {
                    var newViewport = document.createElement('meta');
                    newViewport.name = 'viewport';
                    newViewport.content = 'width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover';
                    document.head.appendChild(newViewport);
                }
            })();
        """.trimIndent()
        view?.evaluateJavascript(css, null)
    }

    private fun requestNotificationPermission() {
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.TIRAMISU) {
            if (ContextCompat.checkSelfPermission(
                    this,
                    android.Manifest.permission.POST_NOTIFICATIONS
                ) != PackageManager.PERMISSION_GRANTED
            ) {
                ActivityCompat.requestPermissions(
                    this,
                    arrayOf(android.Manifest.permission.POST_NOTIFICATIONS),
                    PERMISSION_REQUEST_CODE
                )
            }
        }
    }

    private fun createNotificationChannel() {
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O) {
            val channel = NotificationChannel(
                CHANNEL_ID,
                getString(R.string.notification_channel_name),
                NotificationManager.IMPORTANCE_DEFAULT
            ).apply {
                description = getString(R.string.notification_channel_description)
                enableVibration(true)
            }
            val manager = getSystemService(NotificationManager::class.java)
            manager?.createNotificationChannel(channel)
        }
    }

    override fun onActivityResult(requestCode: Int, resultCode: Int, data: Intent?) {
        super.onActivityResult(requestCode, resultCode, data)
        if (requestCode == FILE_REQUEST_CODE) {
            filePathCallback?.let { callback ->
                val results: Array<Uri>? = if (resultCode == Activity.RESULT_OK && data != null) {
                    val uris = mutableListOf<Uri>()
                    data.data?.let { uris.add(it) }
                    data.clipData?.let { clipData ->
                        for (i in 0 until clipData.itemCount) {
                            clipData.getItemAt(i).uri?.let { uris.add(it) }
                        }
                    }
                    if (uris.isEmpty()) null else uris.toTypedArray()
                } else null
                callback.onReceiveValue(results)
                filePathCallback = null
            }
        }
    }

    override fun onRequestPermissionsResult(
        requestCode: Int,
        permissions: Array<out String>,
        grantResults: IntArray
    ) {
        super.onRequestPermissionsResult(requestCode, permissions, grantResults)
        if (requestCode == PERMISSION_REQUEST_CODE) {
            // Notification permission result - proceed regardless
            // (user can grant/deny without breaking the app)
        }
    }

    override fun onResume() {
        super.onResume()
        webView.onResume()
    }

    override fun onPause() {
        super.onPause()
        webView.onPause()
    }

    override fun onDestroy() {
        webView.destroy()
        super.onDestroy()
    }

    companion object {
        const val CHANNEL_ID = "starpas_notifications"
    }
}
