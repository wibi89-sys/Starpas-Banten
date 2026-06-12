@php
    $settings = \App\Models\AppSetting::getSettings();
@endphp

@if($settings && $settings->logo_path)
    <img src="{{ asset('storage/' . $settings->logo_path) }}" alt="{{ $settings->nama_instansi }}" {{ $attributes->merge(['class' => 'object-contain']) }}>
@else
    <!-- Default Kemenimipas SVG Logo -->
    <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" {{ $attributes }}>
        <circle cx="50" cy="50" r="46" stroke="#D97706" stroke-width="4" fill="#0B2B5E" />
        <circle cx="50" cy="50" r="42" stroke="#F59E0B" stroke-width="1.5" />
        <circle cx="50" cy="50" r="28" stroke="#D97706" stroke-width="2" />
        <path d="M50 24 L52 29 L48 29 Z" fill="#F59E0B" />
        <path d="M50 28 C47 28 45 31 45 34 C45 38 48 40 50 42 C52 40 55 38 55 34 C55 31 53 28 50 28 Z" fill="#F59E0B" />
        <path d="M44 32 C38 31 30 35 24 42 C29 42 34 39 40 36 C42 35 43 34 44 32 Z" fill="#FBBF24" />
        <path d="M43 35 C36 35 29 40 25 47 C30 46 36 43 41 39 C42 38 42 37 43 35 Z" fill="#FBBF24" />
        <path d="M43 38 C37 40 31 45 28 53 C32 50 37 47 41 43 C42 42 42 41 43 38 Z" fill="#FBBF24" />
        <path d="M56 32 C62 31 70 35 76 42 C71 42 66 39 60 36 C58 35 57 34 56 32 Z" fill="#FBBF24" />
        <path d="M57 35 C64 35 71 40 75 47 C70 46 64 43 59 39 C58 38 58 37 57 35 Z" fill="#FBBF24" />
        <path d="M57 38 C63 40 69 45 72 53 C68 50 63 47 59 43 C58 42 58 41 57 38 Z" fill="#FBBF24" />
        <path d="M47 38 H53 V44 C53 47 50 49 50 49 C50 49 47 47 47 44 Z" fill="#B91C1C" stroke="#FBBF24" stroke-width="1" />
        <polygon points="50,40 51,42 53,42 51.5,43 52,45 50,44 48,45 48.5,43 47,42 49,42" fill="#FBBF24" />
        <path d="M47 48 L46 64 C46 66 48 68 50 68 C52 68 54 66 54 64 L53 48 Z" fill="#FBBF24" />
        <path d="M36 66 C42 68 48 68 50 68 C52 68 58 68 64 66 L66 69 C58 71 52 71 50 71 C48 71 42 71 34 69 Z" fill="#F1F5F9" stroke="#D97706" stroke-width="0.5" />
    </svg>
@endif
