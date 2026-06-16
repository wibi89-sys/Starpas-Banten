<div>
    @if($isSuccess)
        <div class="text-center py-10">
            <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-green-100 mb-6">
                <svg class="h-16 w-16 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Permintaan Berhasil Diajukan!</h2>
            <p class="text-lg text-gray-600 mb-8">Terima kasih, permohonan informasi publik Anda akan segera kami proses.</p>

            <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-xl p-6 max-w-sm mx-auto mb-8">
                <p class="text-sm text-gray-500 uppercase tracking-wider mb-1">Nomor Resi / Tracking Number</p>
                <p class="text-2xl font-mono font-bold text-kanwil-blue">{{ $trackingNumber }}</p>
            </div>

            <p class="text-sm text-gray-500 mb-6">
                Harap simpan nomor resi di atas untuk melacak status permintaan informasi Anda melalui menu "Lacak Status".
            </p>

            <a href="{{ url('/') }}" wire:navigate class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-kanwil-blue hover:bg-kanwil-blue-light transition">
                Kembali ke Beranda
            </a>
        </div>
    @else
        <form wire:submit="submit" class="max-w-3xl">
            <h2 class="text-2xl font-bold text-gray-900 border-b-2 border-gray-300 pb-2">Formulir - Layanan Informasi</h2>

            <div class="space-y-6 mt-6">
                {{-- Row 1: Nama Lengkap | Instansi/Asal --}}
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div>
                        <label for="nama_pemohon" class="block text-sm font-medium text-gray-700">Nama Lengkap *</label>
                        <div class="mt-1">
                            <input type="text" wire:model="nama_pemohon" id="nama_pemohon"
                                class="shadow-sm focus:ring-kanwil-gold focus:border-kanwil-gold block w-full sm:text-sm border-gray-300 rounded-md"
                                placeholder="Sesuai KTP">
                        </div>
                        @error('nama_pemohon') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="instansi_asal" class="block text-sm font-medium text-gray-700">Instansi/Asal</label>
                        <div class="mt-1">
                            <input type="text" wire:model="instansi_asal" id="instansi_asal"
                                class="shadow-sm focus:ring-kanwil-gold focus:border-kanwil-gold block w-full sm:text-sm border-gray-300 rounded-md"
                                placeholder="Contoh: Universitas Terbuka / Masyarakat Umum">
                        </div>
                        @error('instansi_asal') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Row 2: NIK | Upload KTP --}}
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div>
                        <label for="nomor_identitas" class="block text-sm font-medium text-gray-700">Nomor Induk Kependudukan (NIK) *</label>
                        <div class="mt-1">
                            <input type="text" wire:model="nomor_identitas" id="nomor_identitas"
                                class="shadow-sm focus:ring-kanwil-gold focus:border-kanwil-gold block w-full sm:text-sm border-gray-300 rounded-md"
                                placeholder="Masukkan 16 Digit NIK" maxlength="16">
                        </div>
                        @error('nomor_identitas') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            <span class="text-red-600">
                                <svg class="inline w-4 h-4 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </span>
                            Upload KTP Asli (PDF/PNG/JPG, Wajib)
                        </label>
                        <div class="mt-2">
                            <label for="ktp-upload" class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-kanwil-gold">
                                <span>Pilih File</span>
                                <input id="ktp-upload" wire:model="lampiran_ktp" type="file" accept=".pdf,.jpg,.jpeg,.png" class="sr-only">
                            </label>
                            <span class="inline-flex items-center px-4 py-2 border border-l-0 border-gray-300 rounded-r-md text-sm text-gray-500 bg-gray-50">
                                @if($lampiran_ktp)
                                    <span class="truncate max-w-[150px]">{{ $lampiran_ktp->getClientOriginalName() }}</span>
                                @else
                                    <span>Tidak ada file yang dipilih</span>
                                @endif
                            </span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">JPG, JPEG, PNG, PDF up to 5MB</p>
                        @error('lampiran_ktp') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Alamat Lengkap --}}
                <div>
                    <label for="alamat_lengkap" class="block text-sm font-medium text-gray-700">Alamat Lengkap *</label>
                    <div class="mt-1">
                        <textarea id="alamat_lengkap" wire:model="alamat_lengkap" rows="2"
                            class="shadow-sm focus:ring-kanwil-gold focus:border-kanwil-gold block w-full sm:text-sm border-gray-300 rounded-md"
                            placeholder="Jl. ..."></textarea>
                    </div>
                    @error('alamat_lengkap') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Nomor HP --}}
                <div>
                    <label for="nomor_hp" class="block text-sm font-medium text-gray-700">Nomor HP (WhatsApp Aktif) *</label>
                    <div class="mt-1">
                        <input type="text" wire:model="nomor_hp" id="nomor_hp"
                            class="shadow-sm focus:ring-kanwil-gold focus:border-kanwil-gold block w-full sm:text-sm border-gray-300 rounded-md"
                            placeholder="08xxxxxxxxxx">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">* Gunakan format angka saja diawali dengan 08 atau 62 (Contoh: 081234567890) agar notifikasi WhatsApp dapat terkirim dengan benar.</p>
                    @error('nomor_hp') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Section: Detail Permintaan Informasi --}}
                <div class="border border-gray-200 rounded-lg p-5">
                    <h3 class="text-base font-semibold text-green-700 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Detail Permintaan Informasi
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <label for="jenis_informasi" class="block text-sm font-medium text-gray-700">Uraian Informasi / Data yang Diminta</label>
                            <div class="mt-1">
                                <textarea id="jenis_informasi" wire:model="jenis_informasi" rows="4"
                                    class="shadow-sm focus:ring-kanwil-gold focus:border-kanwil-gold block w-full sm:text-sm border-gray-300 rounded-md"
                                    placeholder="Jelaskan informasi atau data yang Anda butuhkan..."></textarea>
                            </div>
                            @error('jenis_informasi') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="tujuan_penggunaan" class="block text-sm font-medium text-gray-700">Tujuan Penggunaan Informasi</label>
                            <div class="mt-1">
                                <input type="text" wire:model="tujuan_penggunaan" id="tujuan_penggunaan"
                                    class="shadow-sm focus:ring-kanwil-gold focus:border-kanwil-gold block w-full sm:text-sm border-gray-300 rounded-md"
                                    placeholder="Misalnya: Untuk keperluan penelitian">
                            </div>
                            @error('tujuan_penggunaan') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                {{-- Upload Surat Permohonan --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        <span class="text-red-600">
                            <svg class="inline w-4 h-4 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </span>
                        Upload Surat Permohonan Informasi (PDF/PNG/JPG, Wajib)
                    </label>
                    <div class="mt-2">
                        <label for="surat-upload" class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-kanwil-gold">
                            <span>Pilih File</span>
                            <input id="surat-upload" wire:model="lampiran_surat_permohonan" type="file" accept=".pdf,.jpg,.jpeg,.png" class="sr-only">
                        </label>
                        <span class="inline-flex items-center px-4 py-2 border border-l-0 border-gray-300 rounded-r-md text-sm text-gray-500 bg-gray-50">
                            @if($lampiran_surat_permohonan)
                                <span class="truncate max-w-[150px]">{{ $lampiran_surat_permohonan->getClientOriginalName() }}</span>
                            @else
                                <span>Tidak ada file yang dipilih</span>
                            @endif
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">JPG, JPEG, PNG, PDF up to 5MB</p>
                    @error('lampiran_surat_permohonan') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Submit --}}
                <div class="pt-2">
                    <button type="submit" wire:loading.attr="disabled" disabled class="group relative w-full overflow-hidden rounded-xl py-4 px-6 font-extrabold text-sm tracking-wide text-white transition duration-300 disabled:cursor-not-allowed bg-gradient-to-br from-amber-400 via-kanwil-gold to-yellow-600 shadow-lg shadow-kanwil-gold/30 hover:shadow-xl hover:shadow-kanwil-gold/40 hover:-translate-y-0.5">
                        <span class="relative z-10 flex items-center justify-center gap-2.5">
                            <span wire:loading.remove wire:target="submit" class="flex items-center gap-2.5">
                                Kirim Permintaan Informasi
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
            </div>
        </form>
    @endif
</div>
