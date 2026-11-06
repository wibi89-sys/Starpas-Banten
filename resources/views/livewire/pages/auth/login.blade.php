<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <!-- Title inside card -->
    <div class="mb-6 text-center sm:text-left border-b border-gray-150 pb-4">
        <h2 class="text-xl sm:text-2xl font-black text-kanwil-blue tracking-tight">Masuk Akun Petugas</h2>
        <p class="text-xs text-gray-500 mt-1">Masukkan email & kata sandi dinas Anda untuk mengakses Command Center</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="space-y-4">
        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                Alamat Email Kedinasan
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                </div>
                {{-- text-base di mobile mencegah auto-zoom iOS Safari --}}
                <input wire:model="form.email" id="email" type="email" name="email" required autofocus autocomplete="username"
                       class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-kanwil-blue focus:ring-kanwil-blue text-base sm:text-sm py-3 pl-10 pr-3.5 transition"
                       placeholder="nama@kemenkumham.go.id">
            </div>
            <x-input-error :messages="$errors->get('form.email')" class="mt-1.5" />
        </div>

        <!-- Password dengan Toggle Show/Hide Password -->
        <div x-data="{ showPassword: false }">
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                    Kata Sandi
                </label>
                @if (Route::has('password.request'))
                    <a class="text-xs font-semibold text-kanwil-blue hover:underline" href="{{ route('password.request') }}" wire:navigate>
                        Lupa Sandi?
                    </a>
                @endif
            </div>

            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                
                {{-- Dynamic Input Type (Password / Text) --}}
                <input wire:model="form.password" id="password" :type="showPassword ? 'text' : 'password'" name="password" required autocomplete="current-password"
                       class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-kanwil-blue focus:ring-kanwil-blue text-base sm:text-sm py-3 pl-10 pr-11 transition"
                       placeholder="••••••••">

                {{-- Eye Toggle Button --}}
                <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition p-1 focus:outline-none" :title="showPassword ? 'Sembunyikan sandi' : 'Tampilkan sandi'">
                    <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('form.password')" class="mt-1.5" />
        </div>

        <!-- Remember Me Checkbox -->
        <div class="flex items-center justify-between pt-1">
            <label for="remember" class="inline-flex items-center cursor-pointer select-none">
                <input wire:model="form.remember" id="remember" type="checkbox" class="w-4 h-4 rounded border-gray-300 text-kanwil-blue shadow-sm focus:ring-kanwil-blue" name="remember">
                <span class="ms-2 text-xs font-semibold text-gray-600">Ingat sesi saya di perangkat ini</span>
            </label>
        </div>

        <!-- Submit Button (Full Width, Mobile-First) -->
        <div class="pt-3">
            <button type="submit" wire:loading.attr="disabled" class="group relative w-full overflow-hidden rounded-2xl py-3.5 px-4 font-black text-sm tracking-wide text-white transition duration-200 disabled:opacity-50 bg-gradient-to-r from-[#0B2B5E] via-[#153a7a] to-[#1E3A8A] hover:from-[#09234d] hover:to-[#172e6f] shadow-lg shadow-blue-950/25 active:scale-[0.99] cursor-pointer flex items-center justify-center gap-2">
                <span wire:loading.remove wire:target="login" class="inline-flex items-center gap-2">
                    <span>Masuk ke Command Center</span>
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </span>
                <span wire:loading wire:target="login" class="inline-flex items-center gap-2">
                    <svg class="animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                    <span>Memverifikasi Akun...</span>
                </span>
            </button>
        </div>

        <!-- Secondary Option: Kembali ke Beranda Tracking -->
        <div class="pt-4 border-t border-gray-150 text-center">
            <p class="text-xs text-gray-500">
                Bukan petugas Kanwil? 
                <a href="{{ url('/') }}" wire:navigate class="font-bold text-emerald-700 hover:text-emerald-800 hover:underline inline-flex items-center gap-1">
                    <span>Lacak status permohonan masyarakat</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </p>
        </div>
    </form>
</div>
