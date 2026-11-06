<div>
    @if($isSuccess)
        {{-- ================= SUCCESS RECEIPT SCREEN ================= --}}
        <div class="py-6 sm:py-10 text-center animate-fade-in">
            <div class="mx-auto flex items-center justify-center h-20 w-20 sm:h-24 sm:w-24 rounded-3xl bg-gradient-to-tr from-rose-500 to-amber-500 text-white shadow-xl shadow-rose-500/25 mb-6 animate-bounce-short">
                <svg class="h-10 w-10 sm:h-12 sm:w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-rose-100 text-rose-800 mb-3">
                <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                Laporan Pengaduan Diterima
            </div>

            <h2 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight mb-2">Pengaduan Berhasil Dikirim!</h2>
            <p class="text-xs sm:text-sm text-gray-600 max-w-lg mx-auto mb-6 leading-relaxed">
                Terima kasih atas laporan Anda. Laporan telah kami terima dan akan ditelaah oleh tim pemeriksa Kanwil Kemenkumham / Ditjenpas Banten. Identitas Anda dijamin kerahasiaannya.
            </p>
            
            {{-- Tiket Resi Tracking dengan 1-Tap Copy --}}
            <div x-data="{ copied: false }" class="bg-gradient-to-br from-rose-50 via-slate-50 to-amber-50 border-2 border-dashed border-rose-300 rounded-2xl p-5 sm:p-7 max-w-md mx-auto mb-6 text-center shadow-md relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-24 h-24 bg-rose-200/40 rounded-full blur-xl pointer-events-none"></div>
                
                <p class="text-[11px] font-black uppercase tracking-widest text-rose-700 mb-1">Nomor Resi / Kode Pengaduan</p>
                <p class="text-2xl sm:text-3xl font-mono font-black text-gray-900 tracking-wider mb-4 select-all">{{ $trackingNumber }}</p>
                
                <div class="flex items-center justify-center gap-2">
                    <button type="button" @click="navigator.clipboard.writeText('{{ $trackingNumber }}'); copied = true; setTimeout(() => copied = false, 2500)" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold transition shadow-sm cursor-pointer" :class="copied ? 'bg-rose-600 text-white' : 'bg-white hover:bg-rose-50 text-rose-700 border border-rose-200'">
                        <svg x-show="!copied" class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                        <svg x-show="copied" class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        <span x-text="copied ? 'Resi Berhasil Disalin!' : 'Salin Nomor Resi'"></span>
                    </button>
                </div>
            </div>
            
            <div class="bg-rose-50/70 border border-rose-200 rounded-xl p-4 max-w-md mx-auto mb-8 text-left flex items-start gap-3">
                <svg class="w-5 h-5 text-rose-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                <div class="text-xs text-rose-950 leading-relaxed">
                    <p class="font-bold mb-0.5">Perlindungan Pelapor (*Whistleblower*):</p>
                    <p class="text-rose-800">Laporan Anda ditangani secara rahasia dan independen. Progres penanganan akan diupdate langsung via sistem dan WhatsApp Anda.</p>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 max-w-md mx-auto">
                <a href="{{ url('/') }}" wire:navigate class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-slate-900 hover:bg-slate-800 shadow-md transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <span>Lacak Pengaduan di Beranda</span>
                </a>
            </div>
        </div>
    @else
        {{-- ================= FORMULIR PENGISIAN ================= --}}
        <form wire:submit="submit" class="w-full">
            {{-- Header Form --}}
            <div class="border-b border-gray-150 pb-5 mb-6">
                <div class="flex items-center gap-3">
                    <div class="h-11 w-11 rounded-2xl bg-rose-500/10 text-rose-600 border border-rose-500/20 flex items-center justify-center shadow-sm flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-wider bg-rose-100 text-rose-800">
                                Saluran Resmi Pengaduan
                            </span>
                            <span class="text-[11px] text-gray-400 font-semibold hidden sm:inline">&bull; Terlindungi & Rahasia</span>
                        </div>
                        <h2 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight mt-0.5">Formulir Layanan Pengaduan</h2>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-2 leading-relaxed">
                    Sampaikan laporan penyimpangan, ketidaksesuaian prosedur, atau aspirasi perbaikan layanan Pemasyarakatan secara aman.
                </p>
            </div>

            <div class="space-y-6">
                {{-- INFO KERAHASIAAN PELAPOR --}}
                <div class="bg-amber-50/70 border border-amber-200/90 rounded-2xl p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    <div class="text-xs text-amber-950 leading-relaxed">
                        <span class="font-black">Jaminan Kerahasiaan Pelapor:</span>
                        <span class="text-amber-800"> Nama dapat dikosongkan jika ingin melapor secara anonim. NIK dan KTP hanya digunakan sistem internal untuk verifikasi keaslian laporan guna mencegah laporan palsu/spam.</span>
                    </div>
                </div>

                {{-- BAGIAN 1: IDENTITAS PELAPOR --}}
                <div class="bg-gray-50/80 rounded-2xl p-4 sm:p-5 border border-gray-200/90 space-y-4">
                    <div class="flex items-center gap-2 border-b border-gray-200/70 pb-3">
                        <span class="flex items-center justify-center w-6 h-6 rounded-full bg-rose-600 text-white text-xs font-black">1</span>
                        <h3 class="text-xs sm:text-sm font-black uppercase tracking-wider text-rose-900">Identitas Pelapor</h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="nama_pelapor" class="block text-xs font-bold text-gray-700 mb-1.5">
                                Nama Pelapor <span class="text-gray-400 font-normal">(Opsional / Boleh Dikosongkan)</span>
                            </label>
                            <input type="text" wire:model="nama_pelapor" id="nama_pelapor" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 text-xs sm:text-sm py-2.5 px-3.5 transition" placeholder="Tuliskan nama atau kosongkan untuk Anonim">
                            @error('nama_pelapor') <span class="text-red-500 text-xs mt-1 block font-semibold">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="nik" class="block text-xs font-bold text-gray-700 mb-1.5">
                                NIK (Nomor Induk Kependudukan) <span class="text-red-500">*</span>
                            </label>
                            <input type="text" wire:model="nik" id="nik" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 text-xs sm:text-sm py-2.5 px-3.5 transition font-mono" placeholder="16 Digit NIK sesuai KTP" maxlength="16">
                            @error('nik') <span class="text-red-500 text-xs mt-1 block font-semibold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="nomor_kontak" class="block text-xs font-bold text-gray-700 mb-1.5">
                                Nomor WhatsApp Aktif <span class="text-red-500">*</span>
                            </label>
                            <input type="text" wire:model="nomor_kontak" id="nomor_kontak" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 text-xs sm:text-sm py-2.5 px-3.5 transition font-mono" placeholder="08xxxxxxxxxx">
                            <p class="text-[11px] text-gray-500 mt-1 font-medium">
                                <span class="text-emerald-600 font-bold">📲 WhatsApp:</span> Format diawali 08/62 untuk penerimaan notifikasi status penanganan.
                            </p>
                            @error('nomor_kontak') <span class="text-red-500 text-xs mt-1 block font-semibold">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5 flex items-center justify-between">
                                <span>Upload Kartu Identitas (KTP) <span class="text-red-500">*</span></span>
                                <span class="text-[10px] text-gray-400">PDF/JPG &bull; Maks 5MB</span>
                            </label>
                            <div class="flex items-center border border-gray-300 rounded-xl overflow-hidden bg-white hover:bg-gray-50/50 transition focus-within:ring-2 focus-within:ring-rose-500 focus-within:border-rose-500">
                                <label for="ktp-upload" class="cursor-pointer bg-gray-100 hover:bg-gray-200 text-gray-700 px-3.5 py-2.5 text-xs font-bold border-r border-gray-200 transition select-none shrink-0 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                    <span>Pilih KTP</span>
                                    <input id="ktp-upload" wire:model="kartu_identitas" type="file" accept="image/*,application/pdf" class="hidden">
                                </label>
                                <span class="text-xs text-gray-600 px-3 truncate flex-1 font-medium">
                                    @if ($kartu_identitas)
                                        <span class="text-emerald-700 font-bold">✓ {{ $kartu_identitas->getClientOriginalName() }}</span>
                                    @else
                                        Belum ada file
                                    @endif
                                </span>
                            </div>
                            <div wire:loading wire:target="kartu_identitas" class="text-xs text-rose-600 font-bold mt-1.5 flex items-center gap-1">
                                <svg class="animate-spin h-3.5 w-3.5" viewBox="0 0 24 24" fill="none"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                                Mengunggah KTP...
                            </div>
                            @error('kartu_identitas') <span class="text-red-500 text-xs mt-1 block font-semibold">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                {{-- BAGIAN 2: DETAIL LAPORAN PENGADUAN --}}
                <div class="bg-gray-50/80 rounded-2xl p-4 sm:p-5 border border-gray-200/90 space-y-4">
                    <div class="flex items-center gap-2 border-b border-gray-200/70 pb-3">
                        <span class="flex items-center justify-center w-6 h-6 rounded-full bg-rose-600 text-white text-xs font-black">2</span>
                        <h3 class="text-xs sm:text-sm font-black uppercase tracking-wider text-rose-900">Uraian & Lokasi Pengaduan</h3>
                    </div>

                    <div>
                        <label for="tujuan_satuan_kerja" class="block text-xs font-bold text-gray-700 mb-1.5">
                            Tujuan Unit / Satuan Kerja yang Diadukan <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="tujuan_satuan_kerja" id="tujuan_satuan_kerja" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 text-xs sm:text-sm py-2.5 px-3.5 transition font-semibold">
                            <option value="">-- Pilih Kanwil atau UPT yang Dituju --</option>
                            <option value="kanwil">🏢 Kantor Wilayah Ditjenpas Banten (Tingkat Wilayah)</option>
                            @foreach($upts as $upt)
                                @if($upt->is_active)
                                    <option value="upt:{{ $upt->id }}">🏛️ {{ $upt->nama_upt }} ({{ $upt->jenis_upt }})</option>
                                @endif
                            @endforeach
                        </select>
                        <p class="text-[11px] text-gray-500 mt-1">Pilih unit terkait agar disposisi tindak lanjut ditujukan tepat sasaran.</p>
                        @error('tujuan_satuan_kerja') <span class="text-red-500 text-xs mt-1 block font-semibold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="detail_aduan" class="block text-xs font-bold text-gray-700 mb-1.5">
                            Detail Kronologi Pengaduan <span class="text-red-500">*</span>
                        </label>
                        <textarea id="detail_aduan" wire:model="detail_aduan" rows="5" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 text-xs sm:text-sm py-2.5 px-3.5 transition leading-relaxed" placeholder="Uraikan secara jelas: Apa yang terjadi, kapan waktu kejadian, di mana lokasi tepatnya, siapa saja oknum atau pihak yang terlibat, dan kronologinya..."></textarea>
                        @error('detail_aduan') <span class="text-red-500 text-xs mt-1 block font-semibold">{{ $message }}</span> @enderror
                    </div>

                    {{-- Upload Bukti Lampiran (Opsional) --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5 flex items-center justify-between">
                            <span>Bukti Pendukung / Lampiran <span class="text-gray-400 font-normal">(Opsional)</span></span>
                            <span class="text-[10px] text-gray-400">Foto, Video, PDF &bull; Maks 10MB</span>
                        </label>
                        <div class="flex items-center border border-gray-300 rounded-xl overflow-hidden bg-white hover:bg-gray-50/50 transition focus-within:ring-2 focus-within:ring-rose-500 focus-within:border-rose-500">
                            <label for="file-upload" class="cursor-pointer bg-gray-100 hover:bg-gray-200 text-gray-700 px-3.5 py-2.5 text-xs font-bold border-r border-gray-200 transition select-none shrink-0 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                <span>Pilih Bukti</span>
                                <input id="file-upload" wire:model="bukti_lampiran" type="file" accept="image/*,video/*,application/pdf" class="hidden">
                            </label>
                            <span class="text-xs text-gray-600 px-3 truncate flex-1 font-medium">
                                @if ($bukti_lampiran)
                                    <span class="text-emerald-700 font-bold">✓ {{ $bukti_lampiran->getClientOriginalName() }}</span>
                                @else
                                    Tidak ada berkas bukti (opsional)
                                @endif
                            </span>
                        </div>
                        <div wire:loading wire:target="bukti_lampiran" class="text-xs text-rose-600 font-bold mt-1.5 flex items-center gap-1">
                            <svg class="animate-spin h-3.5 w-3.5" viewBox="0 0 24 24" fill="none"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                            Mengunggah bukti lampiran...
                        </div>
                        @error('bukti_lampiran') <span class="text-red-500 text-xs mt-1 block font-semibold">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- TOMBOL SUBMIT DENGAN IKON PESAWAT KERTAS MENGHADAP KE KANAN --}}
                <div class="pt-2">
                    <button type="submit" wire:loading.attr="disabled" class="group relative w-full overflow-hidden rounded-2xl py-4 px-6 font-black text-sm tracking-wide text-white transition duration-300 disabled:opacity-50 disabled:cursor-not-allowed bg-gradient-to-r from-rose-700 via-rose-600 to-amber-700 shadow-lg shadow-rose-900/25 hover:shadow-xl hover:shadow-rose-900/30 hover:-translate-y-0.5 active:translate-y-0 cursor-pointer">
                        <span class="relative z-10 flex items-center justify-center gap-2.5">
                            <span wire:loading.remove wire:target="submit" class="flex items-center gap-2.5">
                                <span>Kirim Laporan Pengaduan</span>
                                {{-- Ikon Paper Airplane Menghadap ke Kanan (Forward) --}}
                                <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                </svg>
                            </span>
                            <span wire:loading wire:target="submit" class="flex items-center gap-2">
                                <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/></svg>
                                Sedang Mengirim Pengaduan...
                            </span>
                        </span>
                        <div class="absolute inset-0 -translate-x-full group-hover:translate-x-0 bg-gradient-to-r from-transparent via-white/10 to-transparent transition-transform duration-700 ease-out"></div>
                    </button>

                    <p class="text-[11px] text-gray-400 text-center mt-3 flex items-center justify-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        <span>Sistem Pengaduan Terpadu STARPAS &bull; Terjaga, Rahasia & Akuntabel.</span>
                    </p>
                </div>
            </div>
        </form>
    @endif
</div>
