package com.starpas.banten

import android.content.Context
import android.content.SharedPreferences
import com.google.android.gms.tasks.Tasks
import com.google.firebase.messaging.FirebaseMessaging
import kotlinx.coroutines.runBlocking
import kotlinx.coroutines.tasks.await

/**
 * SharedPreferences-backed store for the FCM token.
 * Token persists across app launches.
 */
object FcmTokenStore {
    private const val PREF_NAME = "starpas_fcm"
    private const val KEY_TOKEN = "fcm_token"
    private const val KEY_TOKEN_SAVED_AT = "fcm_token_saved_at"

    fun saveToken(context: Context, token: String) {
        val prefs: SharedPreferences = context.getSharedPreferences(PREF_NAME, Context.MODE_PRIVATE)
        prefs.edit()
            .putString(KEY_TOKEN, token)
            .putLong(KEY_TOKEN_SAVED_AT, System.currentTimeMillis())
            .apply()
    }

    fun getToken(context: Context): String? {
        val prefs: SharedPreferences = context.getSharedPreferences(PREF_NAME, Context.MODE_PRIVATE)
        return prefs.getString(KEY_TOKEN, null)
    }

    /**
     * Synchronous fetch from cache only. Returns null if no token saved.
     * Use fetchTokenAsync() to actually call Firebase.
     */
    fun getTokenSync(context: Context): String? = getToken(context)

    /**
     * Asynchronously fetch a fresh token from Firebase and save it locally.
     * If a token is already saved and recent (< 30 days), returns the cached one.
     */
    suspend fun fetchTokenAsync(context: Context): String? {
        val prefs: SharedPreferences = context.getSharedPreferences(PREF_NAME, Context.MODE_PRIVATE)
        val savedAt = prefs.getLong(KEY_TOKEN_SAVED_AT, 0L)
        val savedToken = prefs.getString(KEY_TOKEN, null)
        val thirtyDaysMs = 30L * 24 * 60 * 60 * 1000
        if (savedToken != null && System.currentTimeMillis() - savedAt < thirtyDaysMs) {
            return savedToken
        }
        return try {
            val token = FirebaseMessaging.getInstance().token.await()
            saveToken(context, token)
            token
        } catch (e: Exception) {
            null
        }
    }

    fun clearToken(context: Context) {
        val prefs: SharedPreferences = context.getSharedPreferences(PREF_NAME, Context.MODE_PRIVATE)
        prefs.edit().clear().apply()
    }
}
