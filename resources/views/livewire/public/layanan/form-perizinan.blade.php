<div>
    @if($isSuccess)
        <div class="text-center py-10">
            <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-green-100 mb-6">
                <svg class="h-16 w-16 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Permohonan Berhasil Diajukan!</h2>
            <p class="text-lg text-gray-600 mb-8">Terima kasih, permohonan izin/magang Anda telah kami terima.</p>
            
            <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-xl p-6 max-w-sm mx-auto mb-8">
                <p class="text-sm text-gray-500 uppercase tracking-wider mb-1">Nomor Resi / Tracking Number</p>
                <p class="text-2xl font-mono font-bold text-kanwil-blue">{{ $trackingNumber }}</p>
            </div>
            
            <p class="text-sm text-gray-500 mb-6">
                Harap simpan nomor resi di atas untuk melacak status permohonan Anda melalui menu "Lacak Status".
            </p>
            
            <a href="{{ url('/') }}" wire:navigate class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-kanwil-blue hover:bg-kanwil-blue-light transition">
                Kembali ke Beranda
            </a>
        </div>
    @else
        <form wire:submit="submit" class="max-w-3xl">
            <h2 class="text-2xl font-bold text-gray-900 border-b-2 border-gray-300 pb-2">Formulir - Layanan Perizinan</h2>

            <div class="space-y-6 mt-6">
            <!-- Row 1: Nama Lengkap & Instansi/Asal -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="nama_lengkap" class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap</label>
                    <input type="text" wire:model="nama_lengkap" id="nama_lengkap" class="shadow-sm focus:ring-kanwil-blue focus:border-kanwil-blue block w-full sm:text-sm border-gray-300 rounded-md py-2.5" placeholder="">
                    @error('nama_lengkap') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="instansi" class="block text-sm font-semibold text-gray-700 mb-1.5">Instansi/Asal</label>
                    <input type="text" wire:model="instansi" id="instansi" class="shadow-sm focus:ring-kanwil-blue focus:border-kanwil-blue block w-full sm:text-sm border-gray-300 rounded-md py-2.5" placeholder="Contoh: Universitas Terbuka / Masyarakat Umum">
                    @error('instansi') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Row 2: Alamat Lengkap -->
            <div>
                <label for="alamat_lengkap" class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat Lengkap</label>
                <textarea id="alamat_lengkap" wire:model="alamat_lengkap" rows="3" class="shadow-sm focus:ring-kanwil-blue focus:border-kanwil-blue block w-full sm:text-sm border-gray-300 rounded-md" placeholder=""></textarea>
                @error('alamat_lengkap') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Row 3: Nomor HP (WhatsApp Aktif) & Nomor Identitas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="nomor_identitas" class="block text-sm font-semibold text-gray-700 mb-1.5">Nomor Identitas</label>
                    <input type="text" wire:model="nomor_identitas" id="nomor_identitas" class="shadow-sm focus:ring-kanwil-blue focus:border-kanwil-blue block w-full sm:text-sm border-gray-300 rounded-md py-2.5" placeholder="Contoh: NIK, KTM, atau Paspor">
                    @error('nomor_identitas') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="nomor_kontak" class="block text-sm font-semibold text-gray-700 mb-1.5">Nomor HP (WhatsApp Aktif)</label>
                    <input type="text" wire:model="nomor_kontak" id="nomor_kontak" class="shadow-sm focus:ring-kanwil-blue focus:border-kanwil-blue block w-full sm:text-sm border-gray-300 rounded-md py-2.5" placeholder="08xxxxxxxxxx">
                    <p class="text-[11px] text-gray-500 mt-1 font-medium leading-normal">
                        * Gunakan format angka saja diawali dengan 08 atau 62 (Contoh: 081234567890) agar notifikasi WhatsApp dapat terkirim dengan benar.
                    </p>
                    @error('nomor_kontak') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Box: Detail Perizinan -->
            <div class="border border-gray-200 rounded-xl p-5 bg-white space-y-5 shadow-sm">
                <h3 class="text-sm font-extrabold text-[#1e3a8a] flex items-center gap-2 border-b border-gray-100 pb-3">
                    <svg class="w-4 h-4 text-[#1e3a8a]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Detail Perizinan
                </h3>

                <div>
                    <label for="nomor_surat" class="block text-sm text-gray-600 mb-1.5">Nomor Surat Pengantar Instansi/Kampus</label>
                    <input type="text" wire:model="nomor_surat" id="nomor_surat" class="shadow-sm focus:ring-kanwil-blue focus:border-kanwil-blue block w-full sm:text-sm border-gray-300 rounded-md py-2.5" placeholder="">
                    @error('nomor_surat') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="jenis_perizinan" class="block text-sm text-gray-600 mb-1.5">Jenis Perizinan</label>
                    <select wire:model="jenis_perizinan" id="jenis_perizinan" class="shadow-sm focus:ring-kanwil-blue focus:border-kanwil-blue block w-full sm:text-sm border-gray-300 rounded-md py-2.5">
                        <option value="">-- Pilih Jenis Perizinan --</option>
                        <option value="Magang / PKL">Magang / PKL</option>
                        <option value="Penelitian">Penelitian</option>
                        <option value="Kunjungan Dinas">Kunjungan Dinas</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                    @error('jenis_perizinan') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="uraian" class="block text-sm text-gray-600 mb-1.5">Uraian Ringkas (Lokasi & Waktu Pelaksanaan)</label>
                    <textarea id="uraian" wire:model="uraian" rows="3" class="shadow-sm focus:ring-kanwil-blue focus:border-kanwil-blue block w-full sm:text-sm border-gray-300 rounded-md" placeholder=""></textarea>
                    @error('uraian') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- File 1: Upload Kartu Identitas -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        <span class="text-red-600">
                            <svg class="inline w-4 h-4 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </span>
                        Upload Kartu Identitas (KTP/KTM/Paspor, Maks 5MB, Wajib)
                    </label>
                    <div class="mt-2">
                        <label class="cursor-pointer bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2.5 text-sm border-r border-gray-300 font-medium transition select-none flex-shrink-0">
                            Pilih File
                            <input id="kartu_identitas" wire:model="kartu_identitas" type="file" accept="image/*,application/pdf" class="hidden">
                        </label>
                        <span class="text-sm text-gray-500 px-3 truncate">
                            @if ($kartu_identitas)
                                {{ $kartu_identitas->getClientOriginalName() }}
                            @else
                                Tidak ada file yang dipilih
                            @endif
                        </span>
                    </div>
                    <div wire:loading wire:target="kartu_identitas" class="text-sm text-kanwil-gold mt-2">Uploading Kartu Identitas...</div>
                    @error('kartu_identitas') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- File 2: Upload Surat Pengantar -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        <span class="text-red-600">
                            <svg class="inline w-4 h-4 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13.586a2 2 0 00-2.828-2.828l-.683.683z"/></svg>
                        </span>
                        Upload Surat Pengantar (PDF saja, Wajib)
                    </label>
                    <div class="mt-2">
                        <label class="cursor-pointer bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2.5 text-sm border-r border-gray-300 font-medium transition select-none flex-shrink-0">
                            Pilih File
                            <input id="surat_pengantar" wire:model="surat_pengantar" type="file" accept="application/pdf" class="hidden">
                        </label>
                        <span class="text-sm text-gray-500 px-3 truncate">
                            @if ($surat_pengantar)
                                {{ $surat_pengantar->getClientOriginalName() }}
                            @else
                                Tidak ada file yang dipilih
                            @endif
                        </span>
                    </div>
                    <div wire:loading wire:target="surat_pengantar" class="text-sm text-kanwil-gold mt-2">Uploading Surat Pengantar...</div>
                    @error('surat_pengantar') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Submit Button (Full width, Gold background, Paper plane icon) -->
            <div class="pt-2">
                <button type="submit" wire:loading.attr="disabled" disabled class="group relative w-full overflow-hidden rounded-xl py-4 px-6 font-extrabold text-sm tracking-wide text-white transition duration-300 disabled:cursor-not-allowed bg-gradient-to-br from-amber-400 via-kanwil-gold to-yellow-600 shadow-lg shadow-kanwil-gold/30 hover:shadow-xl hover:shadow-kanwil-gold/40 hover:-translate-y-0.5">
                    <span class="relative z-10 flex items-center justify-center gap-2.5">
                        <span wire:loading.remove wire:target="submit" class="flex items-center gap-2.5">
                            Kirim Permohonan Perizinan
                            <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        </span>
                        <span wire:loading wire:target="submit" class="flex items-center gap-2">
                            <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/></svg>
                            Memproses...
                        </span>
                    </span>
                    <div class="absolute inset-0 -translate-x-full group-hover:translate-x-0 bg-gradient-to-r from-transparent via-white/10 to-transparent transition-transform duration-700 ease-out"></div>
                </button>
            </div>
        </form>
    @endif
</div>
