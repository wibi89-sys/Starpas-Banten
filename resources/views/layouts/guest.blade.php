@php $settings = \App\Models\AppSetting::getSettings(); @endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $settings?->singkatan ?? config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 relative">
            <!-- Digital Pattern Overlay -->
            <div class="absolute inset-0 pointer-events-none z-0 bg-digital-pattern opacity-100"></div>

            <div class="relative z-10 w-full flex flex-col sm:justify-center items-center">
                <div>
                    <a href="/" wire:navigate>
                        <div class="w-20 h-20 flex items-center justify-center">
                            @if($settings && $settings->logo_path)
                                <img src="{{ asset('storage/' . $settings->logo_path) }}"
                                     alt="{{ $settings->nama_instansi }}"
                                     class="w-20 h-20 object-contain">
                            @else
                                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                            @endif
                        </div>
                    </a>
                </div>

                <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
