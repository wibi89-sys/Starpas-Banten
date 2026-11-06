@php 
    $settings = \App\Models\AppSetting::getSettings(); 
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $settings?->singkatan ?? 'STARPAS' }} {{ $settings?->nama_instansi ?? 'BANTEN' }} - Autentikasi Masuk</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- PWA Meta Tags & Manifest -->
        <x-pwa-tags />

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-slate-50 selection:bg-kanwil-blue-light selection:text-white min-h-full flex flex-col justify-between relative overflow-x-hidden">
        <!-- Digital Pattern Overlay -->
        <div class="fixed inset-0 pointer-events-none z-0 bg-digital-pattern opacity-[0.12]"></div>
        
        <!-- Subtle Background Glow -->
        <div class="fixed top-0 left-1/2 -translate-x-1/2 w-full max-w-4xl h-96 bg-gradient-to-b from-blue-100/40 via-teal-50/20 to-transparent blur-3xl pointer-events-none z-0"></div>

        <!-- Top Mini Bar (Kembali ke Beranda / Tracking) -->
        <header class="relative z-20 w-full pt-[max(0.75rem,env(safe-area-inset-top))] px-4 sm:px-6">
            <div class="max-w-md mx-auto flex items-center justify-between py-2">
                <a href="{{ url('/') }}" wire:navigate class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-500 hover:text-kanwil-blue transition px-3 py-1.5 rounded-xl hover:bg-white/80 border border-transparent hover:border-gray-200">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>Halaman Publik</span>
                </a>

                <div class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-blue-100 text-kanwil-blue border border-blue-200 shadow-xs">
                    <span>Portal Petugas</span>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="relative z-10 flex-1 flex flex-col items-center justify-center px-4 py-6 sm:py-10">
            <div class="w-full sm:max-w-md space-y-4">
                <!-- Branding Header -->
                <div class="text-center">
                    <a href="{{ url('/') }}" wire:navigate class="inline-block group mb-3">
                        <div class="h-16 w-16 sm:h-20 sm:w-20 mx-auto rounded-3xl bg-white flex items-center justify-center shadow-xl shadow-blue-900/10 border border-gray-150 p-2 group-hover:scale-105 transition-transform duration-300">
                            <x-application-logo class="h-12 w-12 sm:h-14 sm:w-14" />
                        </div>
                    </a>
                    <h1 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight uppercase">
                        {{ $settings->singkatan ?? 'STARPAS' }}
                    </h1>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mt-0.5">
                        {{ $settings->nama_instansi ?? 'Kanwil Ditjenpas Banten' }}
                    </p>
                </div>

                <!-- Main Login Card -->
                <div class="bg-white shadow-2xl rounded-2xl sm:rounded-3xl border-t-4 border-kanwil-gold p-6 sm:p-8 relative overflow-hidden">
                    {{ $slot }}
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="relative z-10 text-center py-4 pb-[max(1rem,env(safe-area-inset-bottom))] text-[11px] font-medium text-gray-400">
            &copy; {{ date('Y') }} Kantor Wilayah Ditjenpas Banten &bull; STARPAS v2.0
        </footer>
    </body>
</html>
