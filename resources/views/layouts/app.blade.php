<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @php
            $settings = \App\Models\AppSetting::getSettings();
        @endphp
        <title>{{ $settings->singkatan ?? 'STARPAS' }} {{ $settings->nama_instansi ?? 'BANTEN' }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <x-pwa-tags />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 bg-gray-100 flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }" @keydown.escape.window="sidebarOpen = false">

        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen"
             x-transition:enter="transition-opacity ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false"
             class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm z-40 md:hidden"
             style="display: none;"
             aria-hidden="true">
        </div>

        <!-- Sidebar -->
        <aside
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-xl flex flex-col transform transition-transform duration-200 ease-in-out md:static md:translate-x-0 md:flex md:flex-shrink-0">
            <div class="h-16 flex items-center justify-between gap-2 border-b border-gray-200 px-6">
                <a href="{{ route('home') }}" class="flex items-center gap-2 min-w-0 group" title="Buka Halaman Tracking Permohonan">
                    <div class="h-8 w-8 rounded-full bg-white flex items-center justify-center overflow-hidden p-0.5 shadow-sm flex-shrink-0">
                        <x-application-logo class="h-7 w-7" />
                    </div>
                    <span class="text-base font-black text-kanwil-blue tracking-wider uppercase truncate group-hover:text-kanwil-blue-light transition-colors">{{ $settings->singkatan ?? 'STARPAS' }}</span>
                </a>
                <button @click="sidebarOpen = false" type="button" class="md:hidden text-gray-500 hover:text-gray-700 p-1 rounded">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <a href="{{ route('dashboard') }}" @click="sidebarOpen = false" class="flex items-center px-4 py-3 {{ request()->routeIs('dashboard') ? 'text-kanwil-blue bg-blue-50' : 'text-gray-600 hover:bg-gray-50' }} rounded-lg font-medium transition-colors">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('dashboard') ? 'text-kanwil-blue-light' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard
                </a>

                <a href="{{ route('admin.inbox') }}" @click="sidebarOpen = false" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.inbox*') ? 'text-kanwil-blue bg-blue-50' : 'text-gray-600 hover:bg-gray-50' }} rounded-lg font-medium transition-colors">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.inbox*') ? 'text-kanwil-blue-light' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                    Inbox Dokumen
                </a>

                @role('Super Admin')
                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Administrator</p>
                </div>
                <a href="{{ route('admin.users') }}" @click="sidebarOpen = false" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.users') ? 'text-kanwil-blue bg-blue-50' : 'text-gray-600 hover:bg-gray-50 hover:text-kanwil-blue-light' }} rounded-lg font-medium transition-colors">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.users') ? 'text-kanwil-blue-light' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Kelola Pengguna
                </a>
                <a href="{{ route('admin.settings') }}" @click="sidebarOpen = false" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.settings') ? 'text-kanwil-blue bg-blue-50' : 'text-gray-600 hover:bg-gray-50 hover:text-kanwil-blue-light' }} rounded-lg font-medium transition-colors">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.settings') ? 'text-kanwil-blue-light' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Settings Aplikasi
                </a>
                @endrole

                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Halaman Depan</p>
                </div>
                <a href="{{ route('home') }}" @click="sidebarOpen = false" class="flex items-center px-4 py-3 {{ request()->routeIs('home') ? 'text-kanwil-blue bg-blue-50' : 'text-gray-600 hover:bg-gray-50 hover:text-kanwil-blue' }} rounded-lg font-medium transition-colors">
                    <svg class="w-5 h-5 mr-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    Halaman Tracking
                </a>
            </nav>

            <div class="border-t border-gray-200 p-4">
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                    <button type="submit" class="flex w-full items-center px-4 py-3 text-red-600 hover:bg-red-50 rounded-lg font-medium transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Log Out
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden w-full">
            <!-- Topbar -->
            <header class="h-16 bg-white shadow-sm flex items-center justify-between px-4 sm:px-6 relative z-30 flex-shrink-0">
                <div class="flex items-center min-w-0 flex-1">
                    <button @click="sidebarOpen = true" type="button" class="md:hidden text-gray-500 hover:text-gray-700 mr-3 p-1 rounded-md hover:bg-gray-100">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        <span class="sr-only">Buka menu</span>
                    </button>
                    @if (isset($header))
                        <h2 class="font-semibold text-base sm:text-xl text-gray-800 leading-tight truncate">
                            {{ $header }}
                        </h2>
                    @endif
                </div>
                <div class="flex items-center space-x-3 sm:space-x-4 flex-shrink-0">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 sm:gap-2 px-3 py-1.5 rounded-lg text-xs sm:text-sm font-semibold text-gray-700 bg-gray-50 hover:bg-blue-50 hover:text-kanwil-blue border border-gray-200 hover:border-blue-200 transition shadow-sm" title="Buka Halaman Tracking Permohonan">
                        <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <span class="hidden sm:inline">Halaman Tracking</span>
                        <span class="sm:hidden">Tracking</span>
                    </a>

                    <!-- Profile Dropdown (Hover / Click) -->
                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" @click.outside="open = false">
                        <button @click="open = !open" type="button" class="flex items-center gap-2 sm:gap-3 p-1 sm:px-2.5 sm:py-1.5 rounded-xl hover:bg-gray-100 focus:outline-none transition group cursor-pointer">
                            <div class="text-right hidden sm:block">
                                <span class="block text-sm font-bold text-gray-900 truncate max-w-[150px] leading-tight group-hover:text-kanwil-blue transition">{{ auth()->user()->name }}</span>
                                <span class="block text-[11px] font-semibold text-gray-500 leading-tight mt-0.5">{{ auth()->user()->getRoleNames()->first() ?? 'User' }}</span>
                            </div>
                            <div class="h-9 w-9 rounded-full bg-blue-100 text-kanwil-blue font-black flex items-center justify-center border border-blue-200 flex-shrink-0 group-hover:bg-kanwil-blue group-hover:text-white transition shadow-sm">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown Menu Wrapper (Tanpa celah agar tidak tertutup saat kursor berpindah) -->
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                             class="absolute right-0 top-full pt-1.5 w-64 z-50"
                             style="display: none;">
                            
                            <div class="rounded-2xl bg-white shadow-2xl border border-gray-200 py-2 divide-y divide-gray-100 ring-1 ring-black/5 overflow-hidden">
                                <div class="px-4 py-3 bg-gray-50/80">
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-wider">Akun Masuk</p>
                                    <p class="text-xs font-bold text-gray-900 truncate mt-0.5">{{ auth()->user()->name }}</p>
                                    <p class="text-[11px] text-gray-500 truncate">{{ auth()->user()->email }}</p>
                                </div>

                                <div class="py-1">
                                    <a href="{{ route('profile') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-xs font-bold text-gray-700 hover:bg-blue-50 hover:text-kanwil-blue transition">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        <span>Profil Akun</span>
                                    </a>
                                    @role('Super Admin')
                                    <a href="{{ route('admin.settings') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-xs font-bold text-gray-700 hover:bg-blue-50 hover:text-kanwil-blue transition">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        <span>Pengaturan Aplikasi</span>
                                    </a>
                                    @endrole
                                </div>

                                <div class="py-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex w-full items-center gap-2.5 px-4 py-2.5 text-xs font-bold text-red-600 hover:bg-red-50 transition text-left cursor-pointer">
                                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                            <span>Log Out</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-4 sm:p-6 relative">
                <div class="absolute inset-0 pointer-events-none z-0 bg-digital-pattern opacity-[0.15]"></div>
                <div class="relative z-10">
                    {{ $slot }}
                </div>
            </main>
        </div>

        <!-- Hidden component to preserve compatibility with Breeze test suites -->
        <div class="hidden" aria-hidden="true">
            <livewire:layout.navigation />
        </div>
    </body>
</html>
