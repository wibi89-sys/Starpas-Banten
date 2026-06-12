# Add project specific ProGuard rules here.
# You can control the set of applied configuration files using the
# proguardFiles setting in build.gradle.
#
# For more details, see
#   http://developer.android.com/guide/developing/tools/proguard.html

# If your project uses WebView with JS interfaces
-keepclassmembers class com.starpas.banten.** {
    @android.webkit.JavascriptInterface <methods>;
}

# Keep WebView and JavaScript bridge classes
-keep class com.starpas.banten.MainActivity { *; }
-keep class com.starpas.banten.AndroidBridge { *; }
-keep class com.starpas.banten.FcmService { *; }
-keep class com.starpas.banten.AppFirebaseMessagingService { *; }

# Firebase
-keep class com.google.firebase.** { *; }
-dontwarn com.google.firebase.**

# Coroutines
-keepnames class kotlinx.coroutines.internal.MainDispatcherFactory {}
-keepnames class kotlinx.coroutines.CoroutineExceptionHandler {}
-keepclassmembernames class kotlinx.** {
    volatile <fields>;
}
