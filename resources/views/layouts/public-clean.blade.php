<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @php
            $settings = \App\Models\AppSetting::getSettings();
        @endphp
        
        <title>{{ $settings->singkatan ?? 'STARPAS' }} {{ $settings->nama_instansi ?? 'BANTEN' }} - Lacak Status</title>

        <!-- PWA and Icons -->
        <x-pwa-tags />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900|outfit:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 bg-gray-50 h-full flex flex-col justify-between relative">
        <!-- Digital Pattern Overlay -->
        <div class="absolute inset-0 pointer-events-none z-0 bg-digital-pattern opacity-100"></div>
        <div class="relative z-10 flex flex-col justify-between h-full w-full">
            {{ $slot }}
        </div>
    </body>
</html>
