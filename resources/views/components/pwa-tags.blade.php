@php
    $pwaTags_settings = \App\Models\AppSetting::getSettings();
    $faviconUrl = ($pwaTags_settings && $pwaTags_settings->logo_path)
        ? asset('storage/' . $pwaTags_settings->logo_path)
        : '/icon-192x192.png';
    $themeColor = ($pwaTags_settings && $pwaTags_settings->warna_tema)
        ? $pwaTags_settings->warna_tema
        : '#1e3a8a';
    $appName = $pwaTags_settings->singkatan ?? 'STARPAS';
@endphp

<!-- PWA Web Manifest & Theme -->
<link rel="manifest" href="/manifest.json">
<meta name="theme-color" content="{{ $themeColor }}">
<meta name="color-scheme" content="light">

<!-- Favicon & Standard Icons -->
<link rel="icon" type="image/png" href="{{ $faviconUrl }}">
<link rel="shortcut icon" href="{{ $faviconUrl }}">

<!-- iOS (Apple Safari) PWA Meta & Icons -->
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="{{ $appName }}">
<link rel="apple-touch-icon" href="{{ $faviconUrl }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ $faviconUrl }}">
<link rel="apple-touch-icon" sizes="152x152" href="{{ $faviconUrl }}">
<link rel="apple-touch-icon" sizes="120x120" href="{{ $faviconUrl }}">

<!-- Windows / IE Tile Meta -->
<meta name="msapplication-TileColor" content="{{ $themeColor }}">
<meta name="msapplication-TileImage" content="{{ $faviconUrl }}">

<!-- Service Worker Registration -->
<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/sw.js')
                .then(registration => {
                    console.log('STARPAS PWA SW registered:', registration.scope);
                })
                .catch(error => {
                    console.log('STARPAS PWA SW registration failed:', error);
                });
        });
    }
</script>
