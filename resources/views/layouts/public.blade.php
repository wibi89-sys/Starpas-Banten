<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @php
            $settings = \App\Models\AppSetting::getSettings();
        @endphp
        <title>{{ $settings->singkatan ?? 'STARPAS' }} {{ $settings->nama_instansi ?? 'BANTEN' }} - Layanan Publik</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
        <x-pwa-tags />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-50 selection:bg-kanwil-blue-light selection:text-white relative">
        <!-- Digital Pattern Overlay -->
        <div class="absolute inset-0 pointer-events-none z-0 bg-digital-pattern opacity-[0.15]"></div>

        <!-- Top Navbar -->
        <header class="bg-white border-b border-gray-200 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex justify-between items-center">
                <a href="{{ url('/') }}" wire:navigate class="flex items-center gap-3 group">
                    <!-- Dynamic Logo -->
                    <div class="h-9 w-9 rounded-full bg-white flex items-center justify-center shadow-md overflow-hidden p-0.5">
                        <x-application-logo class="h-8 w-8" />
                    </div>
                    <span class="text-xl font-bold text-gray-900 tracking-tight uppercase group-hover:text-kanwil-blue transition">
                        {{ $settings->singkatan ?? 'STARPAS' }} {{ $settings->nama_instansi ?? 'BANTEN' }}
                    </span>
                </a>
                <a href="{{ url('/') }}" wire:navigate class="text-sm font-medium text-gray-500 hover:text-kanwil-blue transition flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Beranda
                </a>
            </div>
        </header>

        <div class="min-h-screen pt-8 pb-16 flex flex-col items-center relative z-10">
            <div class="w-full sm:max-w-3xl mt-6 px-6 py-8 bg-white shadow-lg sm:rounded-xl border-t-4 border-kanwil-gold">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
