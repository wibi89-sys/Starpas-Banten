@php
    $pwaTags_settings = \App\Models\AppSetting::getSettings();
    $faviconUrl = ($pwaTags_settings && $pwaTags_settings->logo_path)
        ? asset('storage/' . $pwaTags_settings->logo_path)
        : '/icon-192x192.png';
    $themeColor = ($pwaTags_settings && $pwaTags_settings->warna_tema)
        ? $pwaTags_settings->warna_tema
        : '#105132';
@endphp

<!-- PWA & Favicon Tags -->
<link rel="manifest" href="/manifest.json">
<meta name="theme-color" content="{{ $themeColor }}">
<link rel="icon" type="image/png" href="{{ $faviconUrl }}">
<link rel="shortcut icon" href="{{ $faviconUrl }}">
<link rel="apple-touch-icon" href="{{ $faviconUrl }}">

<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/sw.js')
                .then(registration => {
                    console.log('SW registered:', registration.scope);
                })
                .catch(error => {
                    console.log('SW registration failed:', error);
                });
        });
    }
</script>
