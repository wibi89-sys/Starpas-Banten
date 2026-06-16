<div class="min-h-screen flex flex-col justify-between bg-transparent" x-data="{ isSearched: @entangle('isSearched') }" x-effect="if (isSearched) { setTimeout(() => { document.getElementById('tracking-result-section')?.scrollIntoView({ behavior: 'smooth' }) }, 150) }">
    <!-- Style block for animations -->
    <style>
        @keyframes scan {
            0% { left: 0%; opacity: 0; }
            10% { opacity: 0.8; }
            90% { opacity: 0.8; }
            100% { left: 100%; opacity: 0; }
        }
        .scanner-bar {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, transparent, #10B981, transparent);
            box-shadow: 0 0 8px #10B981;
            animation: scan 3s linear infinite;
            pointer-events: none;
        }
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 5px rgba(16, 185, 129, 0.1), 0 0 10px rgba(16, 185, 129, 0.05); }
            50% { box-shadow: 0 0 15px rgba(16, 185, 129, 0.3), 0 0 25px rgba(16, 185, 129, 0.15); }
        }
        .animate-glow-container {
            animation: pulse-glow 3s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }
        .animate-float {
            animation: float 4s ease-in-out infinite;
        }
        .font-display {
            font-family: 'Outfit', sans-serif;
        }
    </style>

    @php
        $settings = \App\Models\AppSetting::getSettings();
    @endphp

    <!-- Top Header & Hero wrapped in green-teal gradient -->
    <div class="bg-gradient-to-r from-[#0a483a] via-[#09594b] to-[#0d364f] text-white relative z-10 overflow-hidden flex-shrink-0">
        <!-- Digital Pattern Overlay khusus untuk hero gelap: mint + gold -->
        <div class="absolute inset-0 pointer-events-none z-0 bg-hero-pattern opacity-[0.15]"></div>

        <!-- Top Header -->
        <header class="bg-transparent border-b border-white/5 py-4 relative z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <!-- Left Brand -->
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-full bg-white flex items-center justify-center shadow-lg overflow-hidden p-0.5">
                        <x-application-logo class="h-9 w-9" />
                    </div>
                    <div>
                        <span class="block text-sm font-black text-white tracking-widest uppercase leading-none font-display">{{ $settings->singkatan ?? 'STARPAS' }}</span>
                        <span class="block text-[10px] font-bold text-slate-300 uppercase mt-0.5 font-display">{{ $settings->nama_instansi ?? 'Kanwil Ditjenpas Banten' }}</span>
                    </div>
                </div>

                <!-- Right Action -->
                <div>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-bold text-gray-900 bg-white hover:bg-slate-50 transition shadow-md">
                                <svg class="w-4 h-4 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-bold text-gray-900 bg-white hover:bg-slate-50 transition shadow-md">
                                <svg class="w-4 h-4 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                Login
                            </a>
                        @endauth
                    @endif
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="pt-12 pb-24 lg:pb-36 px-4 relative z-10">
            <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <!-- Left Side Content -->
                <div class="lg:col-span-7 flex flex-col justify-center text-left order-2">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 border border-white/10 text-xs font-semibold text-slate-200 w-fit mb-6 shadow-sm">
                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        Lacak Progress Permohonan Anda
                    </div>
                    
                    @php
                        $instansi = $settings->nama_instansi ?? 'Kanwil Ditjenpas Banten';
                        if ($instansi === 'Kanwil Ditjenpas Banten') {
                            $instansiHtml = 'Kanwil <span class="text-amber-400">Ditjenpas</span> Banten';
                        } else {
                            $instansiHtml = e($instansi);
                        }
                    @endphp

                    <h1 class="text-6xl sm:text-7xl md:text-8xl font-black tracking-tight leading-none mb-3 font-display">
                        <span class="bg-clip-text text-transparent bg-gradient-to-r from-white via-white to-emerald-300">
                            {{ $settings->singkatan ?? 'STARPAS' }}
                        </span>
                    </h1>
                    
                    <div class="flex items-center gap-3 border-l-2 border-amber-400 pl-4 py-1 mb-4">
                        <p class="text-base sm:text-lg md:text-xl text-amber-400 font-extrabold tracking-wider uppercase font-display">
                            {{ $settings->deskripsi ?? 'Sistem Terpadu Aksi Responsif' }}
                        </p>
                    </div>

                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-white/90 tracking-wide mb-6 font-display leading-tight">
                        {!! $instansiHtml !!}
                    </h2>
                    
                    <p class="text-sm text-slate-200 font-bold tracking-wide mb-6 max-w-xl">
                        Silahkan pilih layanan yang akan anda gunakan,
                    </p>
 
                    <!-- Compact Services Cards Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-2">
                        <!-- Layanan 1 -->
                        <div class="bg-sky-950/40 backdrop-blur-md border border-sky-500/30 hover:border-sky-400/60 rounded-2xl p-5 hover:scale-[1.02] hover:shadow-2xl hover:shadow-sky-500/5 transition-all duration-300 flex flex-col justify-between text-white group relative overflow-hidden">
                            <!-- Top glow decorative effect -->
                            <div class="absolute -top-12 -right-12 h-24 w-24 rounded-full bg-sky-500/10 blur-xl group-hover:bg-sky-500/20 transition duration-300"></div>
                            
                            <div>
                                <div class="h-10 w-10 rounded-xl bg-sky-500/20 text-sky-400 border border-sky-500/30 flex items-center justify-center mb-4 shadow-sm group-hover:scale-110 transition duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-base sm:text-lg font-black text-white mb-2 tracking-wide leading-snug font-display group-hover:text-sky-300 transition duration-200">Layanan Perizinan</h3>
                                <p class="text-[11px] text-slate-300/95 leading-relaxed mb-5">Pengajuan izin penelitian, magang, kunjungan khusus, dan perizinan dinas secara online.</p>
                            </div>
                            <a href="{{ route('layanan.perizinan') }}" wire:navigate class="w-full text-center inline-flex items-center justify-center px-4 py-2.5 bg-sky-500 hover:bg-sky-600 text-white text-xs font-black rounded-xl transition duration-300 shadow-md shadow-sky-500/20 hover:shadow-sky-500/30">
                                Isi Formulir
                            </a>
                        </div>

                        <!-- Layanan 2 -->
                        <div class="bg-rose-950/40 backdrop-blur-md border border-rose-500/30 hover:border-rose-400/60 rounded-2xl p-5 hover:scale-[1.02] hover:shadow-2xl hover:shadow-rose-500/5 transition-all duration-300 flex flex-col justify-between text-white group relative overflow-hidden">
                            <!-- Top glow decorative effect -->
                            <div class="absolute -top-12 -right-12 h-24 w-24 rounded-full bg-rose-500/10 blur-xl group-hover:bg-rose-500/20 transition duration-300"></div>

                            <div>
                                <div class="h-10 w-10 rounded-xl bg-rose-500/20 text-rose-400 border border-rose-500/30 flex items-center justify-center mb-4 shadow-sm group-hover:scale-110 transition duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-base sm:text-lg font-black text-white mb-2 tracking-wide leading-snug font-display group-hover:text-rose-300 transition duration-200">Layanan Pengaduan</h3>
                                <p class="text-[11px] text-slate-300/95 leading-relaxed mb-5">Saluran resmi pengaduan masyarakat, pelaporan penyimpangan, serta aspirasi perbaikan.</p>
                            </div>
                            <a href="{{ route('layanan.pengaduan') }}" wire:navigate class="w-full text-center inline-flex items-center justify-center px-4 py-2.5 bg-rose-500 hover:bg-rose-600 text-white text-xs font-black rounded-xl transition duration-300 shadow-md shadow-rose-500/20 hover:shadow-rose-500/30">
                                Buat Laporan
                            </a>
                        </div>

                        <!-- Layanan 3 -->
                        <div class="bg-amber-950/40 backdrop-blur-md border border-amber-500/30 hover:border-amber-400/60 rounded-2xl p-5 hover:scale-[1.02] hover:shadow-2xl hover:shadow-amber-500/5 transition-all duration-300 flex flex-col justify-between text-white group relative overflow-hidden">
                            <!-- Top glow decorative effect -->
                            <div class="absolute -top-12 -right-12 h-24 w-24 rounded-full bg-amber-500/10 blur-xl group-hover:bg-amber-500/20 transition duration-300"></div>

                            <div>
                                <div class="h-10 w-10 rounded-xl bg-amber-500/20 text-amber-400 border border-amber-500/30 flex items-center justify-center mb-4 shadow-sm group-hover:scale-110 transition duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-base sm:text-lg font-black text-white mb-2 tracking-wide leading-snug font-display group-hover:text-amber-300 transition duration-200">Layanan Informasi</h3>
                                <p class="text-[11px] text-slate-300/95 leading-relaxed mb-5">Permohonan data publik, informasi regulasi pemasyarakatan, serta salinan dokumen resmi.</p>
                            </div>
                            <a href="{{ route('layanan.informasi') }}" wire:navigate class="w-full text-center inline-flex items-center justify-center px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-black rounded-xl transition duration-300 shadow-md shadow-amber-500/20 hover:shadow-amber-500/30">
                                Minta Informasi
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Side Form Card (Overlapping wave divider) -->
                <div class="lg:col-span-5 flex justify-center -mb-20 lg:-mb-36 relative z-20 -translate-y-8 lg:-translate-y-20 order-1">
                    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8 border border-gray-100 relative text-gray-800 animate-float">
                        <div class="flex justify-center mb-6">
                            <div class="h-14 w-14 rounded-full bg-emerald-50 border border-emerald-100 flex items-center justify-center shadow-inner">
                                <svg class="w-6 h-6 text-[#0d5240]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>

                        <h3 class="text-xl font-bold text-gray-900 text-center mb-1">Tracking Layanan Anda</h3>
                        <p class="text-xs text-gray-500 text-center mb-6">Masukkan kode tracking untuk melihat status permohonan Anda</p>

                        <!-- Tracking Input Group with animations -->
                        <form wire:submit="search">
                            <div class="relative w-full mb-4 animate-glow-container rounded-lg">
                                <!-- Animated Border Blur -->
                                <div class="absolute inset-0 rounded-lg bg-gradient-to-r from-emerald-500 to-teal-500 opacity-20 blur-sm pointer-events-none"></div>
                                
                                <div class="relative flex items-center bg-white border border-gray-200 rounded-lg overflow-hidden focus-within:border-emerald-500 focus-within:ring-1 focus-within:ring-emerald-500 shadow-sm">
                                    <!-- Barcode Icon -->
                                    <div class="pl-3 pr-2 text-gray-400 pointer-events-none">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5h2v14H3V5zm4 0h1v14H7V5zm3 0h3v14h-3V5zm5 0h1v14h-1V5zm3 0h3v14h-3V5z"></path>
                                        </svg>
                                    </div>
                                    
                                    <!-- Input -->
                                    <input type="text" wire:model="trackingNumber" id="tracking_code" placeholder="CONTOH: TRK-A3F7K9M2" class="w-full border-0 focus:ring-0 text-sm font-bold tracking-wider py-3.5 text-gray-700 placeholder-gray-400 uppercase focus:outline-none">
                                    
                                    <!-- Scanning laser bar -->
                                    <div class="scanner-bar"></div>
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-[#0d5240] hover:bg-[#083b2e] text-white font-extrabold py-3.5 rounded-lg flex items-center justify-center gap-2 transition duration-200 shadow-md">
                                <span wire:loading wire:target="search" class="inline-flex items-center gap-2">
                                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Memproses...
                                </span>
                                <span wire:loading.remove wire:target="search" class="inline-flex items-center gap-2">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    Cari Sekarang
                                </span>
                            </button>
                        </form>
                        
                        @error('trackingNumber') <span class="text-red-500 text-xs mt-2 block font-semibold">{{ $message }}</span> @enderror

                        <!-- Invalid/Not Found Alert inside card -->
                        @if($isSearched && !$permohonan)
                            <div class="mt-4 bg-red-50 border-l-4 border-red-500 p-3.5 rounded-r-lg text-red-700 text-xs font-semibold flex gap-2">
                                <svg class="h-4 w-4 text-red-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.415 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                                <span>Nomor tracking tidak ditemukan. Periksa kembali.</span>
                            </div>
                        @endif

                        <p class="text-[10px] text-gray-500 font-semibold mt-4 flex gap-1.5 items-start">
                            <span class="text-emerald-700 mt-0.5">ⓘ</span>
                            <span>Kode tracking dapat dilihat pada surat tanda terima atau konfirmasi dari petugas.</span>
                        </p>
                    </div>
                </div>

            </div>
        </section>
    </div>

    <!-- Wave SVG Divider -->
    <div class="relative w-full z-10 pointer-events-none -mt-[59px] flex-shrink-0">
        <svg class="relative block w-full h-[60px] {{ ($isSearched && $permohonan) ? 'text-gray-50' : 'text-[#071d24]' }}" viewBox="0 0 1440 74" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0 24C240 70 480 74 720 48C960 22 1200 -26 1440 10V74H0V24Z" fill="currentColor"/>
        </svg>
    </div>

    <!-- Results Section (appears directly below the wave divider on the same page) -->
    @if($isSearched && $permohonan)
        <div id="tracking-result-section" class="max-w-4xl w-full mx-auto px-4 sm:px-6 lg:px-8 -mt-10 mb-16 relative z-20 scroll-mt-24">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-150 text-gray-800 animate-fade-in-up">
                <!-- Header of results card -->
                <div class="px-6 py-5 flex flex-col sm:flex-row justify-between sm:items-center gap-4 bg-gray-50 border-b border-gray-150">
                    <div>
                        <h3 class="text-xs text-gray-400 uppercase tracking-wider font-bold">Nomor Resi / Tracking</h3>
                        <p class="text-2xl font-mono font-black text-[#071d24] mt-1 tracking-wide">{{ $permohonan->tracking_number }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="px-3.5 py-1.5 inline-flex text-xs leading-5 font-extrabold rounded-full bg-emerald-50 text-[#0d5240] border border-emerald-100 uppercase tracking-wider">
                            {{ $permohonan->status->label() }}
                        </span>
                        <!-- Close results button -->
                        <button type="button" wire:click="$set('isSearched', false)" class="text-xs font-bold text-gray-400 hover:text-red-500 transition px-2.5 py-1.5 rounded-lg border border-gray-200 hover:border-red-200">
                            Tutup Hasil
                        </button>
                    </div>
                </div>
                
                <!-- Details Grid -->
                <div class="px-6 py-5 border-b border-gray-150 bg-white">
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-xs font-bold text-gray-400 uppercase">Jenis Layanan</dt>
                            <dd class="mt-1 text-sm font-black text-gray-800">{{ $permohonan->layanan->nama_layanan }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-bold text-gray-400 uppercase">Tanggal Pengajuan</dt>
                            <dd class="mt-1 text-sm font-bold text-gray-800">{{ $permohonan->tanggal_pengajuan->translatedFormat('d F Y') }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Document Timeline -->
                <div class="px-6 py-6 bg-white">
                    <h4 class="text-xs font-black text-gray-400 uppercase tracking-wider mb-6">Timeline Perjalanan Dokumen</h4>
                    <div class="flow-root">
                        <ul role="list" class="-mb-8">
                            @foreach($permohonan->timelines as $index => $timeline)
                            <li>
                                <div class="relative pb-8">
                                    @if(!$loop->last)
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                    @endif
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white {{ $loop->first ? 'bg-[#0d5240] text-white shadow-md' : 'bg-gray-200 text-gray-500' }}">
                                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm font-bold text-gray-900">
                                                    Status berubah menjadi <span class="text-[#071d24] font-black">{{ $timeline->status_baru->label() }}</span>
                                                </p>
                                                @if($timeline->catatan)
                                                <p class="mt-2 text-xs text-gray-600 bg-gray-50 p-3 rounded-lg border border-gray-100 italic leading-relaxed">
                                                    "{{ $timeline->catatan }}"
                                                </p>
                                                @endif
                                            </div>
                                            <div class="text-right text-xs whitespace-nowrap text-gray-500 font-semibold font-mono">
                                                <time datetime="{{ $timeline->created_at }}">{{ $timeline->created_at->diffForHumans() }}</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif





    <!-- Footer -->
    <footer class="bg-[#071d24] text-slate-300 py-8 text-center border-t border-white/5 relative z-10 w-full mt-auto flex-shrink-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs font-semibold text-slate-400">
            <p>&copy; {{ date('Y') }} Kantor Wilayah Ditjenpas Banten</p>
            <div class="flex gap-4">
                <span class="text-slate-500">STARPAS v2.0</span>
                <a href="https://banten.kemenkumham.go.id/" target="_blank" class="hover:text-emerald-400 transition">Portal Kanwil</a>
            </div>
        </div>
    </footer>

    <!-- Javascript Typewriter Animation for input placeholder -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const input = document.getElementById('tracking_code');
            if (!input) return;
            const placeholders = [
                'CONTOH: TRK-A3F7K9M2',
                'CONTOH: PRZ-20260612',
                'CONTOH: PGD-8371C8F4',
                'CONTOH: INF-4412B9D3'
            ];
            let index = 0;
            let charIndex = 0;
            let currentText = '';
            let isDeleting = false;
            
            function type() {
                const fullText = placeholders[index];
                if (isDeleting) {
                    currentText = fullText.substring(0, charIndex - 1);
                    charIndex--;
                } else {
                    currentText = fullText.substring(0, charIndex + 1);
                    charIndex++;
                }
                
                input.setAttribute('placeholder', currentText);
                
                let typeSpeed = 100;
                if (isDeleting) {
                    typeSpeed /= 2;
                }
                
                if (!isDeleting && currentText === fullText) {
                    typeSpeed = 2000; // Hold
                    isDeleting = true;
                } else if (isDeleting && currentText === '') {
                    isDeleting = false;
                    index = (index + 1) % placeholders.length;
                    typeSpeed = 500; // Hold
                }
                
                setTimeout(type, typeSpeed);
            }
            
            setTimeout(type, 1000);
        });
    </script>
</div>
