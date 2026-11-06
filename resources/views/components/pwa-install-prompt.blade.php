@php
    $pwaPrompt_settings = \App\Models\AppSetting::getSettings();
    $appName = $pwaPrompt_settings->singkatan ?? 'STARPAS';
    $appLogo = ($pwaPrompt_settings && $pwaPrompt_settings->logo_path)
        ? asset('storage/' . $pwaPrompt_settings->logo_path)
        : '/icon-192x192.png';
@endphp

<div x-data="pwaInstallManager()" x-init="initPwa()" x-cloak>
    <!-- Android / Desktop Chrome Floating Install Pill -->
    <div x-show="showAndroidPrompt && !isDismissed" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-8 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-8 scale-95"
         class="fixed bottom-4 left-4 right-4 sm:left-auto sm:right-6 sm:w-96 z-50 bg-white/95 backdrop-blur-md border border-blue-200 shadow-2xl rounded-2xl p-3.5 flex items-center justify-between gap-3 text-gray-900"
         style="padding-bottom: max(0.875rem, env(safe-area-inset-bottom));">
        
        <div class="flex items-center gap-2.5 min-w-0">
            <div class="h-10 w-10 rounded-xl bg-white border border-gray-150 p-1 flex-shrink-0 shadow-sm flex items-center justify-center">
                <img src="{{ $appLogo }}" alt="{{ $appName }}" class="h-full w-full object-contain">
            </div>
            <div class="min-w-0">
                <p class="text-xs font-black text-gray-900 truncate leading-tight">Pasang Aplikasi {{ $appName }}</p>
                <p class="text-[11px] text-gray-500 truncate leading-tight mt-0.5">Akses cepat & pantau status permohonan</p>
            </div>
        </div>

        <div class="flex items-center gap-1.5 flex-shrink-0">
            <button @click="installApp()" type="button" class="px-3.5 py-1.5 bg-gradient-to-r from-kanwil-blue to-blue-700 hover:from-blue-900 hover:to-blue-800 text-white text-xs font-black rounded-xl shadow-md transition transform active:scale-95 cursor-pointer">
                Pasang
            </button>
            <button @click="dismissPrompt()" type="button" class="p-1.5 text-gray-400 hover:text-gray-600 rounded-lg transition" title="Tutup">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>

    <!-- iOS (iPhone / iPad) Safari Install Pill & Bottom Sheet Guide -->
    <div x-show="showIosPrompt && !isDismissed" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-8"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="fixed bottom-4 left-4 right-4 sm:left-auto sm:right-6 sm:w-96 z-50 bg-white/95 backdrop-blur-md border border-blue-200 shadow-2xl rounded-2xl p-3.5 flex items-center justify-between gap-3 text-gray-900"
         style="padding-bottom: max(0.875rem, env(safe-area-inset-bottom));">
        
        <div class="flex items-center gap-2.5 min-w-0 cursor-pointer" @click="showIosModal = true">
            <div class="h-10 w-10 rounded-xl bg-white border border-gray-150 p-1 flex-shrink-0 shadow-sm flex items-center justify-center">
                <img src="{{ $appLogo }}" alt="{{ $appName }}" class="h-full w-full object-contain">
            </div>
            <div class="min-w-0">
                <p class="text-xs font-black text-gray-900 truncate leading-tight">Pasang di Layar Utama iPhone</p>
                <p class="text-[11px] text-kanwil-blue font-bold flex items-center gap-1 mt-0.5">
                    <span>Lihat petunjuk instalasi</span>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </p>
            </div>
        </div>

        <div class="flex items-center gap-1 flex-shrink-0">
            <button @click="showIosModal = true" type="button" class="px-3 py-1.5 bg-blue-50 text-kanwil-blue border border-blue-200 text-xs font-bold rounded-xl transition cursor-pointer">
                Panduan
            </button>
            <button @click="dismissPrompt()" type="button" class="p-1.5 text-gray-400 hover:text-gray-600 rounded-lg transition" title="Tutup">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>

    <!-- iOS Step-by-Step Bottom Modal -->
    <div x-show="showIosModal"
         x-transition:enter="transition-opacity ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-end sm:items-center justify-center p-0 sm:p-4 bg-gray-900/60 backdrop-blur-sm"
         style="display: none;">
        
        <div @click.outside="showIosModal = false"
             class="bg-white w-full sm:max-w-md rounded-t-3xl sm:rounded-3xl shadow-2xl p-6 text-gray-900 relative"
             style="padding-bottom: max(1.5rem, env(safe-area-inset-bottom));">
            
            <div class="w-12 h-1.5 bg-gray-200 rounded-full mx-auto mb-4 sm:hidden"></div>

            <div class="flex items-center justify-between border-b border-gray-150 pb-3 mb-4">
                <div class="flex items-center gap-2.5">
                    <div class="h-9 w-9 rounded-xl bg-blue-50 border border-blue-150 flex items-center justify-center p-1">
                        <img src="{{ $appLogo }}" alt="{{ $appName }}" class="h-full w-full object-contain">
                    </div>
                    <div>
                        <h4 class="text-sm font-black text-gray-900 leading-tight">Pasang di iPhone / iPad</h4>
                        <p class="text-[11px] text-gray-500 leading-tight">{{ $appName }} Kanwil Ditjenpas Banten</p>
                    </div>
                </div>
                <button @click="showIosModal = false" type="button" class="text-gray-400 hover:text-gray-600 p-1 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <p class="text-xs text-gray-600 mb-5 leading-relaxed">
                Pasang aplikasi STARPAS ke layar utama iPhone Anda tanpa perlu App Store hanya dalam 2 langkah mudah:
            </p>

            <div class="space-y-4 text-xs font-semibold">
                <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-2xl border border-gray-200/80">
                    <div class="h-8 w-8 rounded-xl bg-blue-150 text-kanwil-blue flex items-center justify-center flex-shrink-0 font-black">
                        1
                    </div>
                    <div class="leading-relaxed">
                        <p class="font-bold text-gray-900 mb-0.5">Ketuk Ikon Bagikan (Share)</p>
                        <p class="text-gray-500">
                            Cari dan ketuk ikon <span class="inline-flex items-center px-1.5 py-0.5 rounded bg-gray-200 text-gray-800 font-bold">⎋ Bagikan</span> di bilah navigasi Safari bagian bawah layar.
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-2xl border border-gray-200/80">
                    <div class="h-8 w-8 rounded-xl bg-emerald-150 text-emerald-800 flex items-center justify-center flex-shrink-0 font-black">
                        2
                    </div>
                    <div class="leading-relaxed">
                        <p class="font-bold text-gray-900 mb-0.5">Pilih "Tambahkan ke Layar Utama"</p>
                        <p class="text-gray-500">
                            Gulir ke bawah pada menu pop-up lalu ketuk opsi <span class="inline-flex items-center px-1.5 py-0.5 rounded bg-gray-200 text-gray-800 font-bold">➕ Tambahkan ke Layar Utama</span> (Add to Home Screen).
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-3">
                <button @click="showIosModal = false; dismissPrompt()" type="button" class="w-full py-3 bg-kanwil-blue text-white rounded-xl text-xs font-bold hover:bg-blue-800 transition shadow-md">
                    Saya Mengerti
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function pwaInstallManager() {
        return {
            deferredPrompt: null,
            showAndroidPrompt: false,
            showIosPrompt: false,
            showIosModal: false,
            isDismissed: false,

            initPwa() {
                // Check if already in standalone PWA mode
                const isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;
                if (isStandalone) return;

                // Check if dismissed within last 3 days
                const lastDismissed = localStorage.getItem('starpas_pwa_dismissed');
                if (lastDismissed && (Date.now() - parseInt(lastDismissed)) < (3 * 24 * 60 * 60 * 1000)) {
                    this.isDismissed = true;
                    return;
                }

                // Android / Desktop beforeinstallprompt event
                window.addEventListener('beforeinstallprompt', (e) => {
                    e.preventDefault();
                    this.deferredPrompt = e;
                    this.showAndroidPrompt = true;
                });

                // Detect iOS Safari (not in standalone mode)
                const isIos = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
                const isSafari = /Safari/.test(navigator.userAgent) && !/Chrome|CriOS|FxiOS/.test(navigator.userAgent);
                if (isIos && isSafari && !isStandalone) {
                    // Show iOS prompt after 3 seconds so page loads first
                    setTimeout(() => {
                        this.showIosPrompt = true;
                    }, 3000);
                }
            },

            async installApp() {
                if (!this.deferredPrompt) return;
                this.deferredPrompt.prompt();
                const { outcome } = await this.deferredPrompt.userChoice;
                this.deferredPrompt = null;
                this.showAndroidPrompt = false;
            },

            dismissPrompt() {
                this.isDismissed = true;
                this.showAndroidPrompt = false;
                this.showIosPrompt = false;
                localStorage.setItem('starpas_pwa_dismissed', Date.now().toString());
            }
        };
    }
</script>
