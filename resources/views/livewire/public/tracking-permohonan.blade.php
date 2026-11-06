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
                <div class="flex items-center gap-2 sm:gap-3 flex-wrap justify-end">
                    <a href="{{ url('/dashboard') }}" class="inline-flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-2 rounded-lg text-xs sm:text-sm font-bold text-gray-900 bg-white hover:bg-slate-50 transition shadow-md">
                        <svg class="w-4 h-4 text-gray-900 flex-shrink-0" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Dashboard
                    </a>
                    @auth
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" title="Log Out" class="inline-flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-2 rounded-lg text-xs sm:text-sm font-bold text-white bg-red-600/85 hover:bg-red-600 border border-red-400/40 transition shadow-md">
                                <svg class="w-4 h-4 text-white flex-shrink-0" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                <span>Logout</span>
                            </button>
                        </form>
                    @else
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-2 rounded-lg text-xs sm:text-sm font-bold text-gray-900 bg-white hover:bg-slate-50 transition shadow-md">
                                <svg class="w-4 h-4 text-gray-900 flex-shrink-0" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                Login
                            </a>
                        @endif
                    @endauth
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

                    <h1 class="text-5xl sm:text-7xl md:text-8xl font-black tracking-tight leading-none mb-3 font-display">
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
                    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-5 sm:p-8 border border-gray-100 relative text-gray-800 animate-float">
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
        @php
            $currentStatus = $permohonan->status->value;
            $isCompleted = $currentStatus === 'completed';
            $isRejected = $currentStatus === 'rejected';
            $isRevision = $currentStatus === 'revision';
            
            // Tentukan nomor tahapan aktif (1-5)
            $stepIndex = match($currentStatus) {
                'draft' => 1,
                'verification' => 2,
                'revision' => 2,
                'disposition' => 3,
                'processing', 'review' => 4,
                'completed' => 5,
                'rejected' => 2,
                default => 1,
            };

            // Progress percentage for mobile progress bar
            $progressPercent = match($currentStatus) {
                'draft' => 15,
                'verification' => 30,
                'revision' => 30,
                'disposition' => 55,
                'processing' => 75,
                'review' => 85,
                'completed' => 100,
                'rejected' => 30,
                default => 20,
            };

            // Label dinamis sesuai jenis layanan
            $tipeForm = $permohonan->payload_data['tipe_form'] ?? null;
            $namaLayanan = $permohonan->layanan->nama_layanan ?? 'Layanan Publik';
            
            if (str_contains(strtolower($namaLayanan), 'pengaduan') || $tipeForm === 'Pengaduan') {
                $kategoriBadge = 'Layanan Pengaduan';
                $timelineTitle = 'Riwayat Penanganan Laporan';
                $subTimelineTitle = 'Jejak langkah tindak lanjut pengaduan oleh pejabat / tim teknis';
            } elseif (str_contains(strtolower($namaLayanan), 'informasi') || $tipeForm === 'Informasi') {
                $kategoriBadge = 'Layanan Informasi';
                $timelineTitle = 'Progres Permintaan Informasi Publik';
                $subTimelineTitle = 'Alur pemrosesan permohonan data oleh PPID / Satuan Kerja';
            } else {
                $kategoriBadge = 'Layanan Perizinan';
                $timelineTitle = 'Riwayat Progres & Alur Tindak Lanjut';
                $subTimelineTitle = 'Jejak tahapan verifikasi berkas, disposisi, hingga penetapan izin';
            }

            // Nama pemohon disamarkan dengan sopan demi privasi publik
            $namaRaw = $permohonan->nama_pemohon;
            if ($namaRaw && strlen(trim($namaRaw)) > 2) {
                $words = explode(' ', trim($namaRaw));
                $maskedWords = array_map(function($w) {
                    $len = mb_strlen($w);
                    if ($len <= 2) return $w;
                    return mb_substr($w, 0, 1) . str_repeat('•', min(4, $len - 1));
                }, $words);
                $namaMasked = implode(' ', $maskedWords);
            } else {
                $namaMasked = $namaRaw ?: 'Masyarakat Umum';
            }

            // Asal Instansi / Kampus / Lembaga Pemohon
            $asalInstansi = $permohonan->payload_data['instansi'] 
                ?? ($permohonan->payload_data['instansi_asal'] ?? null);

            // UPT Tujuan / Lokasi Satker yang Dituju
            $tujuanSatker = $permohonan->payload_data['tujuan_label'] 
                ?? 'Kantor Wilayah Ditjenpas Banten';

            // Periode Rencana Kegiatan (Jika ada)
            $periodeKegiatan = null;
            if (!empty($permohonan->payload_data['tanggal_mulai'])) {
                $tglMulai = \Carbon\Carbon::parse($permohonan->payload_data['tanggal_mulai'])->translatedFormat('d M Y');
                $tglSelesai = !empty($permohonan->payload_data['tanggal_selesai']) 
                    ? \Carbon\Carbon::parse($permohonan->payload_data['tanggal_selesai'])->translatedFormat('d M Y')
                    : 'Selesai';
                $periodeKegiatan = "{$tglMulai} s/d {$tglSelesai}";
            }

            // Ringkasan Uraian / Perihal
            $perihalSingkat = $permohonan->payload_data['uraian'] 
                ?? ($permohonan->payload_data['detail_aduan'] 
                ?? ($permohonan->payload_data['uraian_informasi'] 
                ?? ($permohonan->payload_data['perihal'] ?? null)));
        @endphp

        <div id="tracking-result-section" class="max-w-4xl w-full mx-auto px-4 sm:px-6 lg:px-8 -mt-10 mb-16 relative z-20 scroll-mt-24">
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-150 text-gray-800 animate-fade-in-up">
                
                <!-- 1. Header Card: Kode Resi + 1-Tap Copy + Status Utama -->
                <div class="px-5 sm:px-8 py-5 sm:py-6 flex flex-col sm:flex-row justify-between sm:items-center gap-4 bg-gradient-to-r from-slate-50 via-gray-50 to-emerald-50/40 border-b border-gray-150" x-data="{ copied: false }">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="text-[11px] font-black tracking-wider uppercase text-gray-400">Kode Tracking Permohonan</span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-gray-200/80 text-gray-700">Resmi</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <p class="text-2xl sm:text-3xl font-mono font-black text-[#071d24] tracking-wide">{{ $permohonan->tracking_number }}</p>
                            <!-- 1-Tap Copy Button -->
                            <button type="button" 
                                @click="navigator.clipboard.writeText('{{ $permohonan->tracking_number }}'); copied = true; setTimeout(() => copied = false, 2500)"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold transition shadow-xs border"
                                :class="copied ? 'bg-emerald-500 text-white border-emerald-600' : 'bg-white hover:bg-gray-100 text-gray-700 border-gray-200'"
                                :title="copied ? 'Berhasil disalin!' : 'Salin Kode Tracking'">
                                <template x-if="!copied">
                                    <span class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg>
                                        <span class="hidden sm:inline">Salin</span>
                                    </span>
                                </template>
                                <template x-if="copied">
                                    <span class="flex items-center gap-1.5 font-bold">
                                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                                        <span>Tersalin!</span>
                                    </span>
                                </template>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 self-start sm:self-center">
                        <!-- Status Badge Pill -->
                        @if($isCompleted)
                            <span class="px-3.5 py-1.5 inline-flex items-center gap-1.5 text-xs font-black rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200 uppercase tracking-wider shadow-xs">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                {{ $permohonan->status->label() }}
                            </span>
                        @elseif($isRevision)
                            <span class="px-3.5 py-1.5 inline-flex items-center gap-1.5 text-xs font-black rounded-full bg-amber-100 text-amber-800 border border-amber-200 uppercase tracking-wider shadow-xs">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                {{ $permohonan->status->label() }}
                            </span>
                        @elseif($isRejected)
                            <span class="px-3.5 py-1.5 inline-flex items-center gap-1.5 text-xs font-black rounded-full bg-rose-100 text-rose-800 border border-rose-200 uppercase tracking-wider shadow-xs">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                {{ $permohonan->status->label() }}
                            </span>
                        @else
                            <span class="px-3.5 py-1.5 inline-flex items-center gap-1.5 text-xs font-black rounded-full bg-emerald-50 text-[#0d5240] border border-emerald-200 uppercase tracking-wider shadow-xs">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                                {{ $permohonan->status->label() }}
                            </span>
                        @endif

                        <!-- Close Button -->
                        <button type="button" wire:click="$set('isSearched', false)" class="text-xs font-bold text-gray-400 hover:text-red-500 transition px-3 py-1.5 rounded-xl border border-gray-200 hover:border-red-200 bg-white">
                            Tutup
                        </button>
                    </div>
                </div>

                <!-- 2. Visual Milestone Stepper (5 Tahapan) -->
                <div class="px-5 sm:px-8 py-6 bg-slate-50/60 border-b border-gray-150">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <span class="text-xs font-black uppercase tracking-wider text-gray-500">Alur Tahapan Penanganan</span>
                            <p class="text-xs text-gray-400 hidden sm:block">Pemantauan progres layanan transparan & real-time</p>
                        </div>
                        <div class="text-right">
                            <span class="text-xs font-mono font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-100">
                                @if($isCompleted)
                                    100% Selesai
                                @elseif($isRevision)
                                    Perlu Revisi
                                @elseif($isRejected)
                                    Ditolak
                                @else
                                    Tahap {{ $stepIndex }} dari 5
                                @endif
                            </span>
                        </div>
                    </div>

                    <!-- Desktop & Tablet Stepper (Horizontal) -->
                    <div class="hidden sm:block">
                        <div class="grid grid-cols-5 relative">
                            <!-- Background Connecting Line -->
                            <div class="absolute top-4 left-6 right-6 h-0.5 bg-gray-200 -z-0"></div>
                            
                            <!-- Active Colored Line Fill -->
                            <div class="absolute top-4 left-6 h-0.5 bg-gradient-to-r {{ $isRevision ? 'from-emerald-500 to-amber-500' : ($isRejected ? 'from-emerald-500 to-rose-500' : 'from-emerald-500 to-[#0d5240]') }} -z-0 transition-all duration-500"
                                style="width: {{ $isCompleted ? 'calc(100% - 3rem)' : ($stepIndex === 1 ? '10%' : ($stepIndex === 2 ? '30%' : ($stepIndex === 3 ? '55%' : ($stepIndex === 4 ? '78%' : '100%')))) }};">
                            </div>

                            @php
                                $steps = [
                                    1 => ['title' => 'Pengajuan', 'desc' => 'Diterima sistem'],
                                    2 => ['title' => 'Verifikasi', 'desc' => 'Pengecekan berkas'],
                                    3 => ['title' => 'Disposisi', 'desc' => 'Arahan pimpinan/tim'],
                                    4 => ['title' => 'Tindak Lanjut', 'desc' => 'Kajian & proses'],
                                    5 => ['title' => 'Selesai', 'desc' => 'Hasil diterbitkan'],
                                ];
                            @endphp

                            @foreach($steps as $num => $step)
                                @php
                                    $isPast = $stepIndex > $num || $isCompleted;
                                    $isCurrent = $stepIndex === $num && !$isCompleted;
                                @endphp
                                <div class="relative z-10 flex flex-col items-center text-center px-1">
                                    <!-- Node Circle -->
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs transition duration-300 shadow-sm
                                        @if($isPast)
                                            bg-emerald-600 text-white ring-4 ring-emerald-50
                                        @elseif($isCurrent && $isRevision)
                                            bg-amber-500 text-white ring-4 ring-amber-100 animate-pulse
                                        @elseif($isCurrent && $isRejected)
                                            bg-rose-600 text-white ring-4 ring-rose-100
                                        @elseif($isCurrent)
                                            bg-[#0d5240] text-white ring-4 ring-emerald-100 animate-pulse
                                        @else
                                            bg-white text-gray-400 border-2 border-gray-200
                                        @endif
                                    ">
                                        @if($isPast)
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                        @elseif($isCurrent && $isRevision)
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                        @elseif($isCurrent && $isRejected)
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                        @elseif($isCurrent)
                                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
                                        @else
                                            <span>{{ $num }}</span>
                                        @endif
                                    </div>

                                    <!-- Label -->
                                    <span class="mt-2 text-xs font-extrabold {{ $isCurrent ? 'text-[#0d5240]' : ($isPast ? 'text-gray-800' : 'text-gray-400') }}">
                                        {{ $step['title'] }}
                                    </span>
                                    <span class="text-[10px] text-gray-400 leading-tight">
                                        {{ $step['desc'] }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Mobile Native Stepper (Zero Horizontal Scroll) -->
                    <div class="block sm:hidden space-y-3">
                        <div class="w-full bg-gray-200 h-2.5 rounded-full overflow-hidden shadow-inner">
                            <div class="h-full rounded-full transition-all duration-500 {{ $isRevision ? 'bg-amber-500' : ($isRejected ? 'bg-rose-500' : 'bg-gradient-to-r from-emerald-500 to-[#0d5240]') }}"
                                style="width: {{ $progressPercent }}%;"></div>
                        </div>
                        <div class="grid grid-cols-5 gap-1 text-center">
                            @foreach($steps as $num => $step)
                                @php
                                    $isPast = $stepIndex > $num || $isCompleted;
                                    $isCurrent = $stepIndex === $num && !$isCompleted;
                                @endphp
                                <div class="flex flex-col items-center">
                                    <span class="w-2 h-2 rounded-full mb-1 {{ $isPast ? 'bg-emerald-600' : ($isCurrent ? 'bg-[#0d5240] ring-2 ring-emerald-200' : 'bg-gray-300') }}"></span>
                                    <span class="text-[9px] font-bold tracking-tight truncate w-full {{ $isCurrent ? 'text-[#0d5240]' : ($isPast ? 'text-gray-700' : 'text-gray-400') }}">
                                        {{ $step['title'] }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- 3. Ringkasan Informasi Pengajuan (Rich Summary Grid) -->
                <div class="px-5 sm:px-8 py-5 sm:py-6 border-b border-gray-150 bg-white">
                    <dl class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                        <!-- Layanan -->
                        <div class="bg-gray-50/80 rounded-2xl p-3.5 border border-gray-150">
                            <dt class="text-[10px] font-black text-gray-400 uppercase tracking-wider flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                <span>Jenis Layanan</span>
                            </dt>
                            <dd class="mt-1 text-xs sm:text-sm font-black text-gray-900 leading-snug">
                                {{ $permohonan->layanan->nama_layanan }}
                            </dd>
                            <span class="inline-block mt-1 text-[10px] font-bold text-slate-500">
                                {{ $kategoriBadge }}
                            </span>
                        </div>

                        <!-- Pemohon / Pelapor -->
                        <div class="bg-gray-50/80 rounded-2xl p-3.5 border border-gray-150 flex flex-col justify-between">
                            <div>
                                <dt class="text-[10px] font-black text-gray-400 uppercase tracking-wider flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    <span>Nama Pemohon</span>
                                </dt>
                                <dd class="mt-1 text-xs sm:text-sm font-black text-gray-900 truncate">
                                    {{ $namaMasked }}
                                </dd>
                            </div>
                            <div class="mt-1 pt-1 border-t border-gray-200/50">
                                @if($asalInstansi)
                                    <span class="text-[10px] font-bold text-sky-800 truncate block" title="{{ $asalInstansi }}">
                                        🎓 Asal: {{ $asalInstansi }}
                                    </span>
                                @else
                                    <span class="text-[10px] font-semibold text-emerald-700 block">
                                        Privasi terlindungi
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Tujuan / Satker -->
                        <div class="bg-gray-50/80 rounded-2xl p-3.5 border border-gray-150 flex flex-col justify-between">
                            <div>
                                <dt class="text-[10px] font-black text-gray-400 uppercase tracking-wider flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    <span>Satker / UPT Tujuan</span>
                                </dt>
                                <dd class="mt-1 text-xs sm:text-sm font-black text-[#0d5240] leading-snug">
                                    {{ $tujuanSatker }}
                                </dd>
                            </div>
                            <div class="mt-1 pt-1 border-t border-gray-200/50">
                                <span class="text-[10px] font-bold text-slate-500 block">
                                    🏛️ Lokasi Pelaksanaan / Instansi
                                </span>
                            </div>
                        </div>

                        <!-- Tanggal Masuk -->
                        <div class="bg-gray-50/80 rounded-2xl p-3.5 border border-gray-150 flex flex-col justify-between">
                            <div>
                                <dt class="text-[10px] font-black text-gray-400 uppercase tracking-wider flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span>Tanggal Masuk</span>
                                </dt>
                                <dd class="mt-1 text-xs sm:text-sm font-bold text-gray-900">
                                    {{ $permohonan->tanggal_pengajuan->translatedFormat('d F Y') }}
                                </dd>
                            </div>
                            <div class="mt-1 pt-1 border-t border-gray-200/50">
                                <span class="text-[10px] font-mono text-gray-400 block">
                                    {{ $permohonan->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    </dl>

                    @if($periodeKegiatan || $perihalSingkat)
                        <div class="mt-4 p-3.5 bg-slate-50 rounded-xl border border-dashed border-gray-200 space-y-1.5">
                            @if($periodeKegiatan)
                                <div class="flex items-center gap-2 text-xs text-gray-700">
                                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-wider">Periode Rencana:</span>
                                    <span class="font-bold text-[#0d5240] font-mono">📅 {{ $periodeKegiatan }}</span>
                                </div>
                            @endif
                            @if($perihalSingkat)
                                <div>
                                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-wider block mb-0.5">Inti Pengajuan / Perihal</span>
                                    <p class="text-xs text-gray-700 leading-relaxed italic line-clamp-2">
                                        "{{ $perihalSingkat }}"
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- 4. Kotak Hasil Akhir / Surat Keputusan (Jika Selesai) -->
                @if($isCompleted)
                    <div class="px-5 sm:px-8 py-6 bg-gradient-to-br from-emerald-50 via-teal-50 to-green-50 border-b border-emerald-200">
                        @if($permohonan->file_surat_jawaban)
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-emerald-600 text-white flex items-center justify-center flex-shrink-0 shadow-md shadow-emerald-600/30">
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <div class="space-y-1">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-black uppercase tracking-wider bg-emerald-200 text-emerald-900">
                                            Dokumen Resmi Terbit
                                        </span>
                                        <h4 class="text-lg font-black text-emerald-950 font-display">Surat Persetujuan / Dokumen Hasil Pelayanan</h4>
                                        <div class="text-xs text-emerald-800/90 font-medium space-y-0.5 pt-1">
                                            @if($permohonan->nomor_surat_jawaban)
                                                <p><span class="font-bold text-emerald-950">Nomor Surat:</span> {{ $permohonan->nomor_surat_jawaban }}</p>
                                            @endif
                                            @if($permohonan->perihal_surat_jawaban)
                                                <p><span class="font-bold text-emerald-950">Perihal:</span> {{ $permohonan->perihal_surat_jawaban }}</p>
                                            @endif
                                            @if($permohonan->tanggal_surat_jawaban)
                                                <p><span class="font-bold text-emerald-950">Tanggal Ditetapkan:</span> {{ $permohonan->tanggal_surat_jawaban->translatedFormat('d F Y') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="{{ asset('storage/' . $permohonan->file_surat_jawaban) }}" target="_blank" download class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-6 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs uppercase tracking-wider rounded-xl shadow-lg shadow-emerald-600/30 transition transform hover:-translate-y-0.5">
                                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        <span>Unduh Dokumen Resmi</span>
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="flex items-start gap-4">
                                <div class="w-11 h-11 rounded-2xl bg-emerald-600 text-white flex items-center justify-center flex-shrink-0 shadow-sm">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <div>
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-black uppercase tracking-wider bg-emerald-200 text-emerald-900">
                                        Layanan Selesai
                                    </span>
                                    <h4 class="text-base font-black text-emerald-950 font-display mt-0.5">Permohonan Telah Dituntaskan</h4>
                                    <p class="text-xs text-emerald-800/90 mt-1">Layanan atau pengaduan Anda telah selesai ditindaklanjuti dan dikonfirmasi oleh petugas berwenang Kanwil Ditjenpas Banten.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                @elseif($isRevision)
                    <div class="px-5 sm:px-8 py-5 bg-amber-50 border-b border-amber-200 flex items-start gap-4">
                        <div class="w-10 h-10 rounded-2xl bg-amber-500 text-white flex items-center justify-center flex-shrink-0 shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <div>
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-black uppercase tracking-wider bg-amber-200 text-amber-900">
                                Perlu Revisi / Perbaikan
                            </span>
                            <h4 class="text-base font-black text-amber-950 font-display mt-0.5">Permohonan Memerlukan Kelengkapan Berkas</h4>
                            <p class="text-xs text-amber-900/90 mt-1">Petugas telah memeriksa usulan Anda dan mencatat hal-hal yang perlu disesuaikan. Silakan cermati catatan pada riwayat tindak lanjut di bawah.</p>
                        </div>
                    </div>
                @elseif($isRejected)
                    <div class="px-5 sm:px-8 py-5 bg-rose-50 border-b border-rose-200 flex items-start gap-4">
                        <div class="w-10 h-10 rounded-2xl bg-rose-600 text-white flex items-center justify-center flex-shrink-0 shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </div>
                        <div>
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-black uppercase tracking-wider bg-rose-200 text-rose-900">
                                Tidak Disetujui
                            </span>
                            <h4 class="text-base font-black text-rose-950 font-display mt-0.5">Permohonan Belum Dapat Diproses</h4>
                            <p class="text-xs text-rose-900/90 mt-1">Berdasarkan hasil verifikasi dan regulasi yang berlaku, permohonan ini belum memenuhi persyaratan. Uraian lengkap dapat dibaca pada riwayat tindak lanjut di bawah.</p>
                        </div>
                    </div>
                @endif

                <!-- 5. Riwayat Progres & Alur Tindak Lanjut (Feed Timeline) -->
                <div class="px-5 sm:px-8 py-6 sm:py-8 bg-white">
                    <div class="flex items-center justify-between mb-8 pb-4 border-b border-gray-150">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-[#0d5240] border border-emerald-100 flex items-center justify-center font-bold shadow-xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-base font-black text-gray-900 font-display tracking-tight">{{ $timelineTitle }}</h4>
                                <p class="text-xs text-gray-500">{{ $subTimelineTitle }}</p>
                            </div>
                        </div>
                        <span class="text-xs font-bold text-gray-500 font-mono bg-gray-100 px-3 py-1 rounded-full">
                            {{ count($permohonan->timelines) }} Riwayat
                        </span>
                    </div>

                    <div class="flow-root">
                        <ul role="list" class="-mb-8">
                            @foreach($permohonan->timelines as $index => $timeline)
                            <li>
                                <div class="relative pb-8">
                                    @if(!$loop->last)
                                    <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                    @endif
                                    <div class="relative flex items-start space-x-4">
                                        <!-- Node Icon -->
                                        <div class="flex-shrink-0">
                                            <span class="h-10 w-10 rounded-2xl flex items-center justify-center ring-4 ring-white shadow-sm transition
                                                {{ $loop->first ? 'bg-[#0d5240] text-white shadow-emerald-900/20' : 'bg-slate-100 text-slate-500 border border-slate-200' }}">
                                                @if($loop->first)
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                @else
                                                    <span class="w-2.5 h-2.5 rounded-full bg-slate-400"></span>
                                                @endif
                                            </span>
                                        </div>

                                        <!-- Card Info -->
                                        <div class="min-w-0 flex-1 pt-0.5">
                                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1 sm:gap-4">
                                                <div>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-black uppercase tracking-wider
                                                        {{ $loop->first ? 'bg-emerald-100 text-[#0d5240]' : 'bg-gray-100 text-gray-700' }}">
                                                        Tahap: {{ $timeline->status_baru->label() }}
                                                    </span>
                                                </div>
                                                <div class="text-left sm:text-right text-[11px] text-gray-400 font-mono">
                                                    <span>{{ $timeline->created_at->translatedFormat('d M Y, H:i') }} WIB</span>
                                                    <span class="text-gray-300"> &bull; </span>
                                                    <span class="font-bold text-gray-500">{{ $timeline->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>

                                            @if($timeline->catatan)
                                            <div class="mt-2.5 text-xs sm:text-sm text-gray-700 bg-slate-50/90 p-4 rounded-2xl border border-gray-150 leading-relaxed relative">
                                                <p class="italic text-gray-800 font-normal">
                                                    "{{ $timeline->catatan }}"
                                                </p>
                                                <div class="mt-2 pt-2 border-t border-gray-200/60 flex items-center justify-between text-[11px] text-gray-400">
                                                    <span class="font-semibold text-gray-500 flex items-center gap-1">
                                                        <svg class="w-3.5 h-3.5 text-emerald-600 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                                        Catatan Resmi Petugas
                                                    </span>
                                                </div>
                                            </div>
                                            @endif

                                            @if($timeline->lampiran_file)
                                            <div class="mt-2.5">
                                                <a href="{{ asset('storage/' . $timeline->lampiran_file) }}" target="_blank" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs text-emerald-800 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 font-bold transition shadow-2xs">
                                                    <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                    <span>Unduh Berkas: {{ $timeline->nama_lampiran ?? 'Dokumen Pendukung' }}</span>
                                                </a>
                                            </div>
                                            @endif
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
