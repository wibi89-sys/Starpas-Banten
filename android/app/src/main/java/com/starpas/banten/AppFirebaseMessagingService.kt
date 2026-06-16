package com.starpas.banten

import android.app.NotificationManager
import android.app.PendingIntent
import android.content.Context
import android.content.Intent
import androidx.core.app.NotificationCompat
import com.google.firebase.messaging.FirebaseMessagingService
import com.google.firebase.messaging.RemoteMessage
import kotlinx.coroutines.CoroutineScope
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.launch

/**
 * Receives FCM messages from Firebase.
 * Handles both notification messages (displayed in system tray)
 * and data messages (silent, processed in-app).
 */
class AppFirebaseMessagingService : FirebaseMessagingService() {

    override fun onNewToken(token: String) {
        super.onNewToken(token)
        // Save token to local storage; send to server via API on next app launch
        FcmTokenStore.saveToken(this, token)
    }

    override fun onMessageReceived(remoteMessage: RemoteMessage) {
        super.onMessageReceived(remoteMessage)

        // Display notification
        remoteMessage.notification?.let { notification ->
            showNotification(
                title = notification.title ?: getString(R.string.notification_title_default),
                body = notification.body ?: "",
                data = remoteMessage.data
            )
        }

        // Handle silent data messages (e.g. tracking updates)
        if (remoteMessage.data.isNotEmpty()) {
            handleDataMessage(remoteMessage.data)
        }
    }

    private fun showNotification(title: String, body: String, data: Map<String, String>) {
        val intent = Intent(this, MainActivity::class.java).apply {
            flags = Intent.FLAG_ACTIVITY_CLEAR_TOP or Intent.FLAG_ACTIVITY_SINGLE_TOP
            // Pass tracking number as deep link if present
            data["tracking_number"]?.let { tracking ->
                putExtra("tracking_number", tracking)
            }
        }
        val pendingIntent = PendingIntent.getActivity(
            this, 0, intent,
            PendingIntent.FLAG_UPDATE_CURRENT or PendingIntent.FLAG_IMMUTABLE
        )

        val notification = NotificationCompat.Builder(this, MainActivity.CHANNEL_ID)
            .setContentTitle(title)
            .setContentText(body)
            .setSmallIcon(R.mipmap.ic_launcher)
            .setAutoCancel(true)
            .setContentIntent(pendingIntent)
            .setPriority(NotificationCompat.PRIORITY_DEFAULT)
            .build()

        val manager = getSystemService(Context.NOTIFICATION_SERVICE) as NotificationManager
        manager.notify(System.currentTimeMillis().toInt(), notification)
    }

    private fun handleDataMessage(data: Map<String, String>) {
        // If the WebView is in foreground, broadcast to it for live update
        if (data["type"] == "tracking_update" && data["tracking_number"] != null) {
            val trackingNumber = data["tracking_number"]
            // Send to WebView via broadcast or evaluate Javascript
            // (Implementation requires WebView instance reference; placeholder for now)
        }
    }
}
