# STARPAS Banten - Android WebView App

Aplikasi Android native yang membungkus website Laravel STARPAS Banten sebagai
hybrid app. Backend tetap menggunakan Laravel yang sudah ada — tidak ada modifikasi
backend yang diperlukan untuk MVP ini.

## Tech Stack

- **Language:** Kotlin
- **Min SDK:** API 26 (Android 8.0 Oreo)
- **Target SDK:** API 34 (Android 14)
- **Build:** Gradle 8.7 + Kotlin DSL
- **Architecture:** Single-Activity WebView + JavaScript Bridge
- **Notifications:** Firebase Cloud Messaging (FCM)
- **Auth:** Session-based (cookie sync dengan Laravel)
- **Offline:** Service Worker (sudah ada di PWA Laravel)

## Project Structure

```
android/
├── app/
│   ├── build.gradle.kts                # App build config
│   ├── proguard-rules.pro              # R8/ProGuard rules
│   ├── google-services.json.placeholder # Replace with real Firebase config
│   └── src/main/
│       ├── AndroidManifest.xml         # Permissions & activity declarations
│       ├── java/com/starpas/banten/
│       │   ├── MainActivity.kt         # WebView + back navigation + file upload
│       │   ├── AndroidBridge.kt        # JS interop (share, clipboard, WA, etc)
│       │   ├── AppFirebaseMessagingService.kt  # FCM push handler
│       │   └── FcmTokenStore.kt        # Token persistence
│       └── res/
│           ├── drawable/               # Splash, icons, vectors
│           ├── layout/                 # activity_main.xml, view_error.xml
│           ├── mipmap-*/               # App icons (adaptive + density)
│           ├── values/                 # colors, strings, themes
│           └── xml/                    # network_security_config.xml
├── build.gradle.kts                    # Project-level build
├── settings.gradle.kts                 # Gradle settings
├── gradle.properties                   # Gradle JVM & AndroidX config
└── gradle/wrapper/                     # Gradle wrapper
```

## Setup untuk Development

### 1. Persiapan Environment

- Install **Android Studio** (versi Hedgehog atau lebih baru): https://developer.android.com/studio
- Install **JDK 17** (Android Studio sudah include)
- Pastikan **Android SDK** dengan API 26 - API 34 terinstall

### 2. Konfigurasi Firebase (untuk Push Notification)

1. Buka [Firebase Console](https://console.firebase.google.com/)
2. Buat project baru (atau gunakan existing) dengan nama `STARPAS Banten`
3. Tambah **Android app** dengan package name: `com.starpas.banten`
4. Download `google-services.json`
5. Taruh file di `android/app/google-services.json` (replace file placeholder)
6. Sync project di Android Studio (File → Sync Project with Gradle Files)

### 3. Konfigurasi URL Backend

Edit `android/app/build.gradle.kts`:

```kotlin
defaultConfig {
    // Replace dengan URL production Laravel Anda
    buildConfigField("String", "BASE_URL", "\"https://starpas.banten.go.id\"")
}
```

Atau edit `android/app/src/main/res/values/strings.xml`:

```xml
<string name="base_url" translatable="false">https://starpas.banten.go.id</string>
```

### 4. Buka di Android Studio

```bash
# Dari root project (Starpas-Banten/)
# Android Studio -> File -> Open -> Pilih folder android/
```

Tunggu Gradle sync selesai. Lalu Run app ke emulator/device.

## Build APK Release

### Debug APK (untuk testing internal)

```bash
cd android/
./gradlew assembleDebug
# Output: app/build/outputs/apk/debug/app-debug.apk
```

### Release APK (untuk distribusi)

```bash
cd android/
./gradlew assembleRelease
# Output: app/build/outputs/apk/release/app-release.apk
```

Release APK menggunakan debug signing config sebagai default. **Untuk distribusi resmi:**
1. Generate keystore: `keytool -genkey -v -keystore starpas-release.keystore -alias starpas -keyalg RSA -keysize 2048 -validity 10000`
2. Update `app/build.gradle.kts` dengan signing config production
3. Sign APK: `./gradlew assembleRelease`

### Build AAB untuk Google Play

```bash
./gradlew bundleRelease
# Output: app/build/outputs/bundle/release/app-release.aab
```

## Fitur Aplikasi

### Yang Sudah Diimplementasi

- **WebView utama** dengan JavaScript, DOM storage, dan file access enabled
- **Cookie sync** untuk session-based auth (login di web tetap berlaku)
- **JavaScript Bridge** (`window.AndroidBridge.*`) dengan methods:
  - `showToast(message)` - native toast
  - `shareTracking(trackingNumber, baseUrl)` - share via WhatsApp, SMS, dll
  - `copyToClipboard(text, label)` - copy ke clipboard
  - `openWhatsApp(phoneNumber, message)` - buka WA dengan template
  - `getFcmToken()` - ambil FCM token untuk dikirim ke server
  - `getDeviceInfo()` - info device untuk analytics
  - `vibrate(ms)` - haptic feedback
  - `downloadFile(url, filename)` - download PDF/dokumen
- **File upload** (lampiran permohonan) via native file picker
- **FCM push notifications** dengan notif channel & deep link
- **Offline detection** + halaman error dengan tombol retry
- **Pull-to-refresh** (swipe down untuk reload)
- **Back button** - history.back() jika bisa, minimize app jika tidak
- **External link** handling - buka di browser jika link keluar dari domain STARPAS
- **Deep linking** - tracking URLs langsung terbuka di app
- **Safe area** untuk Android 15+ gesture bar
- **Custom splash screen** dengan logo STARPAS

### JavaScript Usage (dari Laravel Blade/JS)

```javascript
// Share tracking number
window.AndroidBridge.shareTracking('PRZ-2506-0001', 'https://starpas.banten.go.id');

// Copy ke clipboard
window.AndroidBridge.copyToClipboard('PRZ-2506-0001');

// Buka WhatsApp admin
window.AndroidBridge.openWhatsApp('6281234567890', 'Halo, saya ingin bertanya tentang permohonan PRZ-2506-0001');

// Get FCM token (kirim ke server setelah login)
const token = window.AndroidBridge.getFcmToken();
if (token) {
    fetch('/api/user/fcm-token', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ token: token })
    });
}

// Vibrate on button click
window.AndroidBridge.vibrate(50);
```

## Integrasi dengan Laravel Backend

### Rekomendasi (Tanpa Modifikasi Backend)

WebView sudah otomatis load URL Laravel production. Tidak perlu API endpoints baru.

### Opsional: Tambah FCM Token Registration Endpoint

Tambah di `routes/api.php` (perlu install `laravel/sanctum` dulu):

```php
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/user/fcm-token', function (Request $request) {
        $request->user()->update(['fcm_token' => $request->token]);
        return response()->json(['success' => true]);
    });
});
```

Tambah migration untuk kolom `fcm_token` di `users` table:

```bash
php artisan make:migration add_fcm_token_to_users_table
```

```php
Schema::table('users', function (Blueprint $table) {
    $table->text('fcm_token')->nullable();
});
```

### Opsional: Kirim Push dari Laravel

Install package Firebase Admin SDK untuk PHP:

```bash
composer require kreait/laravel-firebase
```

Tambah service provider, lalu buat `app/Services/FirebaseNotificationService.php`
untuk mengirim notif saat status permohonan berubah.

## Testing

### Manual Test Plan

| No | Skenario | Expected Result |
|----|----------|-----------------|
| 1 | Buka app pertama kali | Splash → load home (/) |
| 2 | Tap "Login" | WebView navigasi ke /login, form tampil |
| 3 | Login berhasil | Redirect ke /dashboard dengan session cookie |
| 4 | Tap "Cek Tracking" | Halaman tracking tampil |
| 5 | Input kode tracking valid | Hasil tracking tampil dengan timeline |
| 6 | Tap tombol "Bagikan" (jika ada) | Native share sheet muncul |
| 7 | Buka form Perizinan | Form tampil, bisa input |
| 8 | Tap "Upload Lampiran" | Native file picker Android muncul |
| 9 | Pilih file PDF/gambar | File terupload, form submit sukses |
| 10 | Matikan WiFi/data | Halaman error tampil, retry button muncul |
| 11 | Nyalakan internet, tap retry | WebView reload dengan sukses |
| 12 | Tap back button saat di sub-page | Kembali ke page sebelumnya |
| 13 | Tap back button di home | App minimize ke background |
| 14 | Kirim push dari Laravel | Notifikasi muncul di tray |
| 15 | Tap notifikasi tracking update | App buka dengan deep link ke tracking |

## Troubleshooting

### WebView tidak bisa load URL

- Cek `network_security_config.xml` - HTTPS only by default
- Untuk dev dengan HTTP, tambahkan domain ke `domain-config` cleartextTrafficPermitted
- Pastikan `usesCleartextTraffic` di Manifest atau `base-config` di network config

### FCM token null

- Pastikan `google-services.json` valid dan sudah di-sync
- Cek Firebase project sudah enable Cloud Messaging
- Verifikasi package name di Firebase Console sama dengan `applicationId` di `build.gradle.kts`

### App crash saat upload file

- Tambahkan `<uses-permission android:name="android.permission.READ_EXTERNAL_STORAGE"/>` di AndroidManifest (sudah ada, max SDK 32)

### Build error "Could not find google-services.json"

- Pastikan `google-services.json` ada di `android/app/` (bukan `android/`)
- Pastikan tidak ke-commit ke git (tambahkan ke `.gitignore`)

## Deployment Checklist

- [ ] Replace `google-services.json` dengan config Firebase production
- [ ] Update `BASE_URL` di build.gradle.kts ke URL production
- [ ] Generate release keystore (jangan commit ke git)
- [ ] Update `app_name` dan `applicationId` jika perlu rename package
- [ ] Test di Android 8.0, 10, 12, 14 (multiple API levels)
- [ ] Test di device low-end (RAM 2GB) - pastikan WebView tidak lag
- [ ] Test offline mode
- [ ] Test push notification end-to-end
- [ ] Sign APK dan upload ke Play Store / distribusi internal
- [ ] Update Laravel production URL di CORS / trusted proxies

## Catatan Keamanan

- HTTPS only di production (lihat `network_security_config.xml`)
- Cleartext hanya untuk localhost / IP private (development)
- File upload lewat `WebChromeClient.onShowFileChooser` - tidak auto-grant akses
- Cookie di-encrypt oleh `CookieManager` Android
- `webView.addJavascriptInterface` aman karena hanya `AndroidBridge` yang ter-expose
- Tidak ada eval() dari input user

## Lisensi & Kredit

Aplikasi Android ini membungkus website Laravel STARPAS Banten yang dibangun
oleh Kantor Wilayah Ditjenpas Banten.

Logo dan brand STARPAS adalah hak cipta Ditjenpas / Kemenimipas.
