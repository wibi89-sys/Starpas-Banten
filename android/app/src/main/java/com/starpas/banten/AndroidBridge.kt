package com.starpas.banten

import android.content.ClipData
import android.content.ClipboardManager
import android.content.Context
import android.content.Intent
import android.net.Uri
import android.os.Build
import android.os.Environment
import android.webkit.JavascriptInterface
import android.widget.Toast
import androidx.core.content.FileProvider
import java.io.File
import java.io.FileOutputStream
import java.net.URL
import java.util.concurrent.Executors

/**
 * Bridge between JavaScript in WebView and native Android features.
 * Accessible from JavaScript as `window.AndroidBridge`.
 *
 * Methods are exposed via @JavascriptInterface and must be public.
 */
class AndroidBridge(private val context: Context) {

    /**
     * Show a native toast message from JavaScript.
     * @param message The message to display
     */
    @JavascriptInterface
    fun showToast(message: String) {
        Toast.makeText(context, message, Toast.LENGTH_SHORT).show()
    }

    /**
     * Share a tracking number with native share sheet.
     * Opens WhatsApp, SMS, or any shareable app.
     * @param trackingNumber The tracking number (e.g. "PRZ-2506-0001")
     * @param baseUrl The base URL of the application
     */
    @JavascriptInterface
    fun shareTracking(trackingNumber: String, baseUrl: String) {
        val trackUrl = "$baseUrl/tracking?code=$trackingNumber"
        val message = context.getString(R.string.share_tracking_template, trackingNumber, trackUrl)
        val intent = Intent(Intent.ACTION_SEND).apply {
            type = "text/plain"
            putExtra(Intent.EXTRA_SUBJECT, "Tracking STARPAS: $trackingNumber")
            putExtra(Intent.EXTRA_TEXT, message)
        }
        val chooser = Intent.createChooser(intent, context.getString(R.string.share_chooser_title))
        chooser.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK)
        context.startActivity(chooser)
    }

    /**
     * Copy text to system clipboard.
     * @param text The text to copy
     * @param label Optional label for the clipboard entry
     */
    @JavascriptInterface
    fun copyToClipboard(text: String, label: String = "STARPAS") {
        val clipboard = context.getSystemService(Context.CLIPBOARD_SERVICE) as ClipboardManager
        val clip = ClipData.newPlainText(label, text)
        clipboard.setPrimaryClip(clip)
        Toast.makeText(context, "Disalin: $text", Toast.LENGTH_SHORT).show()
    }

    /**
     * Open WhatsApp with a pre-filled message to admin/operator.
     * @param phoneNumber Phone number in international format (e.g. "6281234567890")
     * @param message Pre-filled message
     */
    @JavascriptInterface
    fun openWhatsApp(phoneNumber: String, message: String = "") {
        try {
            val url = if (message.isNotEmpty()) {
                "https://wa.me/$phoneNumber?text=${Uri.encode(message)}"
            } else {
                "https://wa.me/$phoneNumber"
            }
            val intent = Intent(Intent.ACTION_VIEW, Uri.parse(url))
            intent.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK)
            context.startActivity(intent)
        } catch (e: Exception) {
            Toast.makeText(context, "WhatsApp tidak terinstall", Toast.LENGTH_SHORT).show()
        }
    }

    /**
     * Get the FCM token. Returns empty string if not yet available.
     * Should be called from JavaScript after login to register the token on server.
     */
    @JavascriptInterface
    fun getFcmToken(): String {
        return FcmTokenStore.getTokenSync(context) ?: ""
    }

    /**
     * Get device info as JSON string for backend analytics.
     */
    @JavascriptInterface
    fun getDeviceInfo(): String {
        val manufacturer = Build.MANUFACTURER ?: ""
        val model = Build.MODEL ?: ""
        val osVersion = Build.VERSION.RELEASE ?: ""
        val sdkInt = Build.VERSION.SDK_INT
        return """{"manufacturer":"$manufacturer","model":"$model","os":"Android $osVersion","sdk":$sdkInt}"""
    }

    /**
     * Show or hide the native loading indicator.
     * @param show true to show, false to hide
     */
    @JavascriptInterface
    fun setLoading(show: Boolean) {
        // Implemented in MainActivity by toggling ProgressBar visibility
        // Bridge is for future expansion; for now handled in WebChromeClient
    }

    /**
     * Trigger device vibration for tactile feedback (e.g. button presses).
     * @param milliseconds Duration of vibration
     */
    @JavascriptInterface
    fun vibrate(milliseconds: Long = 50) {
        try {
            val vibrator = if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.S) {
                val vibratorManager = context.getSystemService(Context.VIBRATOR_MANAGER_SERVICE)
                        as android.os.VibratorManager
                vibratorManager.defaultVibrator
            } else {
                @Suppress("DEPRECATION")
                context.getSystemService(Context.VIBRATOR_SERVICE) as android.os.Vibrator
            }
            vibrator.vibrate(android.os.VibrationEffect.createOneShot(
                milliseconds,
                android.os.VibrationEffect.DEFAULT_AMPLITUDE
            ))
        } catch (e: Exception) {
            // Vibration not available, ignore
        }
    }

    /**
     * Download a file from URL and save to device Downloads folder.
     * Used for downloading official documents (e.g. PDF SK).
     */
    @JavascriptInterface
    fun downloadFile(url: String, filename: String) {
        val executor = Executors.newSingleThreadExecutor()
        executor.execute {
            try {
                val connection = URL(url).openConnection()
                connection.connect()
                val input = connection.getInputStream()

                val downloadsDir = Environment.getExternalStoragePublicDirectory(
                    Environment.DIRECTORY_DOWNLOADS
                )
                val file = File(downloadsDir, filename)
                val output = FileOutputStream(file)
                input.copyTo(output)
                output.close()
                input.close()

                // Notify via toast on UI thread
                android.os.Handler(context.mainLooper).post {
                    Toast.makeText(
                        context,
                        "File tersimpan: ${file.absolutePath}",
                        Toast.LENGTH_LONG
                    ).show()
                }
            } catch (e: Exception) {
                android.os.Handler(context.mainLooper).post {
                    Toast.makeText(
                        context,
                        "Gagal download: ${e.message}",
                        Toast.LENGTH_SHORT
                    ).show()
                }
            }
        }
    }
}
