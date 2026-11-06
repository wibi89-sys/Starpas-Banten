<div>
    @if($isSuccess)
        {{-- ================= SUCCESS RECEIPT SCREEN ================= --}}
        <div class="py-6 sm:py-10 text-center animate-fade-in">
            <div class="mx-auto flex items-center justify-center h-20 w-20 sm:h-24 sm:w-24 rounded-3xl bg-gradient-to-tr from-emerald-500 to-teal-400 text-white shadow-xl shadow-emerald-500/25 mb-6 animate-bounce-short">
                <svg class="h-10 w-10 sm:h-12 sm:w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-emerald-100 text-emerald-800 mb-3">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                Permohonan Berhasil Dikirim
            </div>

            <h2 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight mb-2">Permohonan Izin / Magang Diterima!</h2>
            <p class="text-xs sm:text-sm text-gray-600 max-w-lg mx-auto mb-6 leading-relaxed">
                Terima kasih, berkas permohonan Anda telah berhasil dicatat ke dalam sistem STARPAS Kanwil Ditjenpas Banten dan siap diverifikasi oleh petugas pelayanan.
            </p>
            
            {{-- Tiket Resi Tracking dengan 1-Tap Copy --}}
            <div x-data="{ copied: false }" class="bg-gradient-to-br from-blue-50 via-slate-50 to-emerald-50 border-2 border-dashed border-blue-300 rounded-2xl p-5 sm:p-7 max-w-md mx-auto mb-6 text-center shadow-md relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-24 h-24 bg-blue-200/40 rounded-full blur-xl pointer-events-none"></div>
                
                <p class="text-[11px] font-black uppercase tracking-widest text-blue-700 mb-1">Nomor Resi / Kode Tracking</p>
                <p class="text-2xl sm:text-3xl font-mono font-black text-gray-900 tracking-wider mb-4 select-all">{{ $trackingNumber }}</p>
                
                <div class="flex items-center justify-center gap-2">
                    <button type="button" @click="navigator.clipboard.writeText('{{ $trackingNumber }}'); copied = true; setTimeout(() => copied = false, 2500)" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold transition shadow-sm cursor-pointer" :class="copied ? 'bg-emerald-600 text-white' : 'bg-white hover:bg-blue-50 text-blue-700 border border-blue-200'">
                        <svg x-show="!copied" class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                        <svg x-show="copied" class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        <span x-text="copied ? 'Resi Berhasil Disalin!' : 'Salin Nomor Resi'"></span>
                    </button>
                </div>
            </div>
            
            <div class="bg-emerald-50/70 border border-emerald-200 rounded-xl p-4 max-w-md mx-auto mb-8 text-left flex items-start gap-3">
                <svg class="w-5 h-5 text-emerald-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div class="text-xs text-emerald-900 leading-relaxed">
                    <p class="font-bold mb-0.5">Notifikasi WhatsApp Dikirim:</p>
                    <p class="text-emerald-800">Bukti tanda terima dan link pemantauan progres permohonan telah dikirimkan secara otomatis ke nomor WhatsApp Anda.</p>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 max-w-md mx-auto">
                <a href="{{ url('/') }}" wire:navigate class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-kanwil-blue hover:bg-kanwil-blue-light shadow-md shadow-blue-900/20 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <span>Lacak Progres di Beranda</span>
                </a>
            </div>
        </div>
    @else
        {{-- ================= FORMULIR PENGISIAN ================= --}}
        <form wire:submit="submit" class="w-full">
            {{-- Header Form --}}
            <div class="border-b border-gray-150 pb-5 mb-6">
                <div class="flex items-center gap-3">
                    <div class="h-11 w-11 rounded-2xl bg-sky-500/10 text-sky-600 border border-sky-500/20 flex items-center justify-center shadow-sm flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-wider bg-sky-100 text-sky-800">
                                Layanan Resmi
                            </span>
                            <span class="text-[11px] text-gray-400 font-semibold hidden sm:inline">&bull; Bebas Biaya (Gratis)</span>
                        </div>
                        <h2 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight mt-0.5">Formulir Permohonan Perizinan</h2>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-2 leading-relaxed">
                    Ajukan izin magang/PKL, izin riset/penelitian, atau kunjungan kedinasan pada Kanwil Kemenkumham & UPT Pemasyarakatan se-Banten.
                </p>
            </div>

            <div class="space-y-6">
                {{-- BAGIAN 1: IDENTITAS PEMOHON --}}
                <div class="bg-gray-50/80 rounded-2xl p-4 sm:p-5 border border-gray-200/90 space-y-4">
                    <div class="flex items-center gap-2 border-b border-gray-200/70 pb-3">
                        <span class="flex items-center justify-center w-6 h-6 rounded-full bg-kanwil-blue text-white text-xs font-black">1</span>
                        <h3 class="text-xs sm:text-sm font-black uppercase tracking-wider text-kanwil-blue">Data Diri & Instansi Pemohon</h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="nama_lengkap" class="block text-xs font-bold text-gray-700 mb-1.5">
                                Nama Lengkap Pemohon <span class="text-red-500">*</span>
                            </label>
                            <input type="text" wire:model="nama_lengkap" id="nama_lengkap" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-kanwil-blue focus:ring-kanwil-blue text-xs sm:text-sm py-2.5 px-3.5 transition" placeholder="Contoh: Muhammad Farhan">
                            @error('nama_lengkap') <span class="text-red-500 text-xs mt-1 block font-semibold">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="instansi" class="block text-xs font-bold text-gray-700 mb-1.5">
                                Instansi / Perguruan Tinggi / Asal <span class="text-red-500">*</span>
                            </label>
                            <input type="text" wire:model="instansi" id="instansi" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-kanwil-blue focus:ring-kanwil-blue text-xs sm:text-sm py-2.5 px-3.5 transition" placeholder="Contoh: Universitas Sultan Ageng Tirtayasa">
                            @error('instansi') <span class="text-red-500 text-xs mt-1 block font-semibold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="nomor_identitas" class="block text-xs font-bold text-gray-700 mb-1.5">
                                Nomor Identitas (NIK / KTM / Paspor) <span class="text-red-500">*</span>
                            </label>
                            <input type="text" wire:model="nomor_identitas" id="nomor_identitas" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-kanwil-blue focus:ring-kanwil-blue text-xs sm:text-sm py-2.5 px-3.5 transition" placeholder="Nomor KTP atau Kartu Tanda Mahasiswa">
                            @error('nomor_identitas') <span class="text-red-500 text-xs mt-1 block font-semibold">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="nomor_kontak" class="block text-xs font-bold text-gray-700 mb-1.5">
                                Nomor WhatsApp Aktif <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" wire:model="nomor_kontak" id="nomor_kontak" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-kanwil-blue focus:ring-kanwil-blue text-xs sm:text-sm py-2.5 px-3.5 transition font-mono" placeholder="08xxxxxxxxxx">
                            </div>
                            <p class="text-[11px] text-gray-500 mt-1 flex items-center gap-1 font-medium">
                                <span class="text-emerald-600 font-bold">📲 Penting:</span> Diawali 08/62 untuk pengiriman resi & status persetujuan via WhatsApp.
                            </p>
                            @error('nomor_kontak') <span class="text-red-500 text-xs mt-1 block font-semibold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="alamat_lengkap" class="block text-xs font-bold text-gray-700 mb-1.5">
                            Alamat Lengkap Tempat Tinggal / Domisili <span class="text-red-500">*</span>
                        </label>
                        <textarea id="alamat_lengkap" wire:model="alamat_lengkap" rows="2" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-kanwil-blue focus:ring-kanwil-blue text-xs sm:text-sm py-2.5 px-3.5 transition" placeholder="Tuliskan jalan, nomor, RT/RW, kelurahan, kecamatan, kota..."></textarea>
                        @error('alamat_lengkap') <span class="text-red-500 text-xs mt-1 block font-semibold">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- BAGIAN 2: RINCIAN PERIZINAN --}}
                <div class="bg-gray-50/80 rounded-2xl p-4 sm:p-5 border border-gray-200/90 space-y-4">
                    <div class="flex items-center gap-2 border-b border-gray-200/70 pb-3">
                        <span class="flex items-center justify-center w-6 h-6 rounded-full bg-kanwil-blue text-white text-xs font-black">2</span>
                        <h3 class="text-xs sm:text-sm font-black uppercase tracking-wider text-kanwil-blue">Rincian Rencana Kegiatan</h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="jenis_perizinan" class="block text-xs font-bold text-gray-700 mb-1.5">
                                Jenis Perizinan yang Diajukan <span class="text-red-500">*</span>
                            </label>
                            <select wire:model="jenis_perizinan" id="jenis_perizinan" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-kanwil-blue focus:ring-kanwil-blue text-xs sm:text-sm py-2.5 px-3.5 transition font-semibold">
                                <option value="">-- Pilih Jenis Perizinan --</option>
                                <option value="Magang / PKL">Magang / PKL</option>
                                <option value="Penelitian">Penelitian / Riset Tugas Akhir</option>
                                <option value="Kunjungan Dinas">Kunjungan Dinas / Studi Banding</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            @error('jenis_perizinan') <span class="text-red-500 text-xs mt-1 block font-semibold">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="nomor_surat" class="block text-xs font-bold text-gray-700 mb-1.5">
                                Nomor Surat Pengantar dari Kampus/Instansi <span class="text-red-500">*</span>
                            </label>
                            <input type="text" wire:model="nomor_surat" id="nomor_surat" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-kanwil-blue focus:ring-kanwil-blue text-xs sm:text-sm py-2.5 px-3.5 transition" placeholder="Contoh: 123/UN.1/FT/PKL/2026">
                            @error('nomor_surat') <span class="text-red-500 text-xs mt-1 block font-semibold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="uraian" class="block text-xs font-bold text-gray-700 mb-1.5">
                            Uraian Ringkas (Lokasi UPT, Waktu Pelaksanaan & Judul/Tujuan) <span class="text-red-500">*</span>
                        </label>
                        <textarea id="uraian" wire:model="uraian" rows="3" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-kanwil-blue focus:ring-kanwil-blue text-xs sm:text-sm py-2.5 px-3.5 transition" placeholder="Jelaskan UPT yang dituju (misal: Lapas Kelas IIA Serang), rentang tanggal pelaksanaan, serta topik riset/magang..."></textarea>
                        @error('uraian') <span class="text-red-500 text-xs mt-1 block font-semibold">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- BAGIAN 3: UNGGAH DOKUMEN PERSYARATAN --}}
                <div class="bg-gray-50/80 rounded-2xl p-4 sm:p-5 border border-gray-200/90 space-y-4">
                    <div class="flex items-center gap-2 border-b border-gray-200/70 pb-3">
                        <span class="flex items-center justify-center w-6 h-6 rounded-full bg-kanwil-blue text-white text-xs font-black">3</span>
                        <h3 class="text-xs sm:text-sm font-black uppercase tracking-wider text-kanwil-blue">Unggah Dokumen Berkas</h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        {{-- Upload 1: Kartu Identitas --}}
                        <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm flex flex-col justify-between">
                            <div>
                                <label class="block text-xs font-bold text-gray-800 mb-1 flex items-center justify-between">
                                    <span>Kartu Identitas (KTP/KTM) <span class="text-red-500">*</span></span>
                                    <span class="text-[10px] font-semibold text-gray-400">PDF, JPG, PNG &bull; Maks 5MB</span>
                                </label>
                                <p class="text-[11px] text-gray-500 mb-3">Unggah scan identitas diri yang masih berlaku.</p>
                            </div>

                            <div>
                                <div class="flex items-center border border-gray-300 rounded-xl overflow-hidden bg-gray-50/50 hover:bg-white transition focus-within:ring-2 focus-within:ring-sky-500 focus-within:border-sky-500">
                                    <label class="cursor-pointer bg-white hover:bg-gray-100 text-gray-700 px-3.5 py-2.5 text-xs font-bold border-r border-gray-200 transition select-none shrink-0 flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-sky-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                        <span>Pilih File</span>
                                        <input id="kartu_identitas" wire:model="kartu_identitas" type="file" accept="image/*,application/pdf" class="hidden">
                                    </label>
                                    <span class="text-xs text-gray-600 px-3 truncate flex-1 font-medium">
                                        @if ($kartu_identitas)
                                            <span class="text-emerald-700 font-bold">✓ {{ $kartu_identitas->getClientOriginalName() }}</span>
                                        @else
                                            Belum ada file
                                        @endif
                                    </span>
                                </div>
                                <div wire:loading wire:target="kartu_identitas" class="text-xs text-sky-600 font-bold mt-1.5 flex items-center gap-1">
                                    <svg class="animate-spin h-3.5 w-3.5" viewBox="0 0 24 24" fill="none"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                                    Mengunggah Kartu Identitas...
                                </div>
                                @error('kartu_identitas') <span class="text-red-500 text-xs mt-1 block font-semibold">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        {{-- Upload 2: Surat Pengantar --}}
                        <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm flex flex-col justify-between">
                            <div>
                                <label class="block text-xs font-bold text-gray-800 mb-1 flex items-center justify-between">
                                    <span>Surat Pengantar Resmi <span class="text-red-500">*</span></span>
                                    <span class="text-[10px] font-semibold text-gray-400">PDF Saja &bull; Maks 5MB</span>
                                </label>
                                <p class="text-[11px] text-gray-500 mb-3">Surat bertandatangan & cap kampus/instansi.</p>
                            </div>

                            <div>
                                <div class="flex items-center border border-gray-300 rounded-xl overflow-hidden bg-gray-50/50 hover:bg-white transition focus-within:ring-2 focus-within:ring-sky-500 focus-within:border-sky-500">
                                    <label class="cursor-pointer bg-white hover:bg-gray-100 text-gray-700 px-3.5 py-2.5 text-xs font-bold border-r border-gray-200 transition select-none shrink-0 flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-sky-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                        <span>Pilih File</span>
                                        <input id="surat_pengantar" wire:model="surat_pengantar" type="file" accept="application/pdf" class="hidden">
                                    </label>
                                    <span class="text-xs text-gray-600 px-3 truncate flex-1 font-medium">
                                        @if ($surat_pengantar)
                                            <span class="text-emerald-700 font-bold">✓ {{ $surat_pengantar->getClientOriginalName() }}</span>
                                        @else
                                            Belum ada file
                                        @endif
                                    </span>
                                </div>
                                <div wire:loading wire:target="surat_pengantar" class="text-xs text-sky-600 font-bold mt-1.5 flex items-center gap-1">
                                    <svg class="animate-spin h-3.5 w-3.5" viewBox="0 0 24 24" fill="none"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                                    Mengunggah Surat Pengantar...
                                </div>
                                @error('surat_pengantar') <span class="text-red-500 text-xs mt-1 block font-semibold">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TOMBOL SUBMIT DENGAN IKON PESAWAT KERTAS MENGHADAP KE KANAN --}}
                <div class="pt-2">
                    <button type="submit" wire:loading.attr="disabled" class="group relative w-full overflow-hidden rounded-2xl py-4 px-6 font-black text-sm tracking-wide text-white transition duration-300 disabled:opacity-50 disabled:cursor-not-allowed bg-gradient-to-r from-[#0d5240] via-[#09594b] to-[#0d364f] shadow-lg shadow-emerald-950/25 hover:shadow-xl hover:shadow-emerald-900/30 hover:-translate-y-0.5 active:translate-y-0 cursor-pointer">
                        <span class="relative z-10 flex items-center justify-center gap-2.5">
                            <span wire:loading.remove wire:target="submit" class="flex items-center gap-2.5">
                                <span>Kirim Permohonan Perizinan</span>
                                {{-- Ikon Paper Airplane Menghadap ke Kanan (Forward) --}}
                                <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                </svg>
                            </span>
                            <span wire:loading wire:target="submit" class="flex items-center gap-2">
                                <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/></svg>
                                Sedang Mengirim Permohonan...
                            </span>
                        </span>
                        <div class="absolute inset-0 -translate-x-full group-hover:translate-x-0 bg-gradient-to-r from-transparent via-white/10 to-transparent transition-transform duration-700 ease-out"></div>
                    </button>

                    <p class="text-[11px] text-gray-400 text-center mt-3 flex items-center justify-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        <span>Data Anda terlindungi & diproses sesuai SOP pelayanan Kantor Wilayah Ditjenpas Banten.</span>
                    </p>
                </div>
            </div>
        </form>
    @endif
</div>
