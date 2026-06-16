<div>
    @if($isSuccess)
        <div class="text-center py-10">
            <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-green-100 mb-6">
                <svg class="h-16 w-16 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Pengaduan Berhasil Dikirim!</h2>
            <p class="text-lg text-gray-600 mb-8">Terima kasih atas laporan Anda. Identitas Anda (jika disembunyikan) akan kami jaga kerahasiaannya.</p>
            
            <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-xl p-6 max-w-sm mx-auto mb-8">
                <p class="text-sm text-gray-500 uppercase tracking-wider mb-1">Nomor Resi / Tracking Number</p>
                <p class="text-2xl font-mono font-bold text-kanwil-blue">{{ $trackingNumber }}</p>
            </div>
            
            <p class="text-sm text-gray-500 mb-6">
                Harap simpan nomor resi di atas untuk melacak tindak lanjut dari laporan pengaduan Anda.
            </p>
            
            <a href="{{ url('/') }}" wire:navigate class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-kanwil-blue hover:bg-kanwil-blue-light transition">
                Kembali ke Beranda
            </a>
        </div>
    @else
        <form wire:submit="submit" class="max-w-3xl">
            <h2 class="text-2xl font-bold text-gray-900 border-b-2 border-gray-300 pb-2">Formulir - Layanan Pengaduan</h2>
            <p class="mt-2 text-sm text-gray-500">Laporkan indikasi pelanggaran atau sampaikan keluhan Anda terkait layanan kami.</p>

            <div class="space-y-6 mt-6">
                <div>
                    <label for="nama_pelapor" class="block text-sm font-medium text-gray-700">Nama Pelapor</label>
                    <div class="mt-1">
                        <input type="text" wire:model="nama_pelapor" id="nama_pelapor" class="shadow-sm focus:ring-kanwil-gold focus:border-kanwil-gold block w-full sm:text-sm border-gray-300 rounded-md py-2.5" placeholder="Contoh: Budi Santoso">
                    </div>
                    @error('nama_pelapor') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="nik" class="block text-sm font-medium text-gray-700">NIK (Nomor Induk Kependudukan) *</label>
                    <div class="mt-1">
                        <input type="text" wire:model="nik" id="nik" class="shadow-sm focus:ring-kanwil-gold focus:border-kanwil-gold block w-full sm:text-sm border-gray-300 rounded-md py-2.5" placeholder="Contoh: 3674012345678901" maxlength="16">
                    </div>
                    @error('nik') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="nomor_kontak" class="block text-sm font-medium text-gray-700">Nomor HP (WhatsApp Aktif) *</label>
                    <div class="mt-1">
                        <input type="text" wire:model="nomor_kontak" id="nomor_kontak" class="shadow-sm focus:ring-kanwil-gold focus:border-kanwil-gold block w-full sm:text-sm border-gray-300 rounded-md py-2.5" placeholder="Contoh: 081234567890">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">* Gunakan format angka saja diawali dengan 08 atau 62 (Contoh: 081234567890) agar notifikasi WhatsApp dapat terkirim dengan benar.</p>
                    @error('nomor_kontak') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        <span class="text-red-600">
                            <svg class="inline w-4 h-4 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </span>
                        Upload Kartu Identitas (KTP/KTM, Maks 5MB, Wajib)
                    </label>
                    <div class="mt-2">
                        <label for="ktp-upload" class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-kanwil-gold">
                            <span>Pilih File</span>
                            <input id="ktp-upload" wire:model="kartu_identitas" type="file" accept="image/*,application/pdf" class="sr-only">
                        </label>
                        <span class="inline-flex items-center px-4 py-2 border border-l-0 border-gray-300 rounded-r-md text-sm text-gray-500 bg-gray-50">
                            @if ($kartu_identitas)
                                <span class="truncate max-w-[150px]">{{ $kartu_identitas->getClientOriginalName() }}</span>
                            @else
                                <span>Tidak ada file yang dipilih</span>
                            @endif
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">JPG, JPEG, PNG, PDF up to 5MB</p>
                    <div wire:loading wire:target="kartu_identitas" class="text-sm text-kanwil-gold mt-2">Uploading Kartu Identitas...</div>
                    @error('kartu_identitas') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="tujuan_satuan_kerja" class="block text-sm font-medium text-gray-700">Tujuan Pengaduan (Kanwil / UPT) *</label>
                    <div class="mt-1">
                        <select wire:model="tujuan_satuan_kerja" id="tujuan_satuan_kerja" class="shadow-sm focus:ring-kanwil-gold focus:border-kanwil-gold block w-full sm:text-sm border-gray-300 rounded-md py-2.5">
                            <option value="">-- Pilih Kanwil atau UPT tujuan pengaduan --</option>
                            <option value="kanwil">Kanwil Ditjenpas Banten</option>
                            @foreach($upts as $upt)
                                @if($upt->is_active)
                                    <option value="upt:{{ $upt->id }}">{{ $upt->nama_upt }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Pilih unit yang dituju agar pengaduan Anda dapat diteruskan ke pihak yang berwenang menindaklanjuti.</p>
                    @error('tujuan_satuan_kerja') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="detail_aduan" class="block text-sm font-medium text-gray-700">Detail Pengaduan *</label>
                    <div class="mt-1">
                        <textarea id="detail_aduan" wire:model="detail_aduan" rows="5" class="shadow-sm focus:ring-kanwil-gold focus:border-kanwil-gold block w-full sm:text-sm border-gray-300 rounded-md py-2.5" placeholder="Jelaskan secara rinci kronologi kejadian, tempat, waktu, dan siapa saja yang terlibat..."></textarea>
                    </div>
                    @error('detail_aduan') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        <span class="text-red-600">
                            <svg class="inline w-4 h-4 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                        </span>
                        Bukti Lampiran (Foto/Video/PDF, Opsional, Maks 10MB)
                    </label>
                    <div class="mt-2">
                        <label for="file-upload" class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-kanwil-gold">
                            <span>Pilih File</span>
                            <input id="file-upload" wire:model="bukti_lampiran" type="file" accept="image/*,video/*,application/pdf" class="sr-only">
                        </label>
                        <span class="inline-flex items-center px-4 py-2 border border-l-0 border-gray-300 rounded-r-md text-sm text-gray-500 bg-gray-50">
                            @if ($bukti_lampiran)
                                <span class="truncate max-w-[150px]">{{ $bukti_lampiran->getClientOriginalName() }}</span>
                            @else
                                <span>Tidak ada file yang dipilih</span>
                            @endif
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">JPG, PNG, PDF, MP4 up to 10MB</p>
                    <div wire:loading wire:target="bukti_lampiran" class="text-sm text-kanwil-gold mt-2">Uploading...</div>
                    @error('bukti_lampiran') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

            <div class="pt-2">
                <button type="submit" wire:loading.attr="disabled" disabled class="group relative w-full overflow-hidden rounded-xl py-4 px-6 font-extrabold text-sm tracking-wide text-white transition duration-300 disabled:cursor-not-allowed bg-gradient-to-br from-amber-400 via-kanwil-gold to-yellow-600 shadow-lg shadow-kanwil-gold/30 hover:shadow-xl hover:shadow-kanwil-gold/40 hover:-translate-y-0.5">
                    <span class="relative z-10 flex items-center justify-center gap-2.5">
                        <span wire:loading.remove wire:target="submit" class="flex items-center gap-2.5">
                            Kirim Pengaduan
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
