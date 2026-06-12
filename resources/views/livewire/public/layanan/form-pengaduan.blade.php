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
        <div class="mb-8 border-b border-gray-200 pb-5">
            <h2 class="text-2xl font-bold text-kanwil-blue">Laporan Pengaduan Masyarakat</h2>
            <p class="mt-2 text-sm text-gray-500">Laporkan indikasi pelanggaran atau sampaikan keluhan Anda terkait layanan kami. Anda dapat melaporkan secara anonim (mengosongkan nama).</p>
        </div>

        <form wire:submit="submit" class="space-y-6">
            <div>
                <label for="nama_pelapor" class="block text-sm font-medium text-gray-700">Nama Pelapor (Kosongkan jika ingin anonim)</label>
                <div class="mt-1">
                    <input type="text" wire:model="nama_pelapor" id="nama_pelapor" class="shadow-sm focus:ring-kanwil-gold focus:border-kanwil-gold block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Contoh: Budi Santoso (Atau biarkan kosong)">
                </div>
                @error('nama_pelapor') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="nik" class="block text-sm font-medium text-gray-700">NIK (Nomor Induk Kependudukan) *</label>
                <div class="mt-1">
                    <input type="text" wire:model="nik" id="nik" class="shadow-sm focus:ring-kanwil-gold focus:border-kanwil-gold block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Contoh: 3674012345678901" maxlength="16">
                </div>
                @error('nik') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="nomor_kontak" class="block text-sm font-medium text-gray-700">Nomor Kontak / WhatsApp *</label>
                <div class="mt-1">
                    <input type="text" wire:model="nomor_kontak" id="nomor_kontak" class="shadow-sm focus:ring-kanwil-gold focus:border-kanwil-gold block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Contoh: 081234567890">
                </div>
                @error('nomor_kontak') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="kartu_identitas" class="block text-sm font-medium text-gray-700">Upload Kartu Identitas (KTP/KTM, Maks 5MB) *</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-kanwil-gold transition bg-gray-50">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600 justify-center">
                            <label for="ktp-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-kanwil-blue hover:text-kanwil-blue-light focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-kanwil-gold px-1">
                                <span>Upload KTP</span>
                                <input id="ktp-upload" wire:model="kartu_identitas" type="file" class="sr-only">
                            </label>
                            <p class="pl-1">atau drag & drop</p>
                        </div>
                        <p class="text-xs text-gray-500">JPG, JPEG, PNG, PDF up to 5MB</p>
                    </div>
                </div>
                <!-- Loading indicator for upload -->
                <div wire:loading wire:target="kartu_identitas" class="text-sm text-kanwil-gold mt-2">Uploading KTP...</div>
                
                @if ($kartu_identitas)
                    <div class="mt-2 text-sm text-green-600 font-medium border border-green-200 bg-green-50 p-2 rounded">
                        File terpilih: {{ $kartu_identitas->getClientOriginalName() }}
                    </div>
                @endif
                @error('kartu_identitas') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="detail_aduan" class="block text-sm font-medium text-gray-700">Detail Pengaduan *</label>
                <div class="mt-1">
                    <textarea id="detail_aduan" wire:model="detail_aduan" rows="5" class="shadow-sm focus:ring-kanwil-gold focus:border-kanwil-gold block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Jelaskan secara rinci kronologi kejadian, tempat, waktu, dan siapa saja yang terlibat..."></textarea>
                </div>
                @error('detail_aduan') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="bukti_lampiran" class="block text-sm font-medium text-gray-700">Bukti Lampiran (Foto/Video/PDF, Opsional, Maks 10MB)</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-kanwil-gold transition bg-gray-50">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600 justify-center">
                            <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-kanwil-blue hover:text-kanwil-blue-light focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-kanwil-gold px-1">
                                <span>Upload bukti</span>
                                <input id="file-upload" wire:model="bukti_lampiran" type="file" class="sr-only">
                            </label>
                            <p class="pl-1">atau drag & drop</p>
                        </div>
                        <p class="text-xs text-gray-500">JPG, PNG, PDF, MP4 up to 10MB</p>
                    </div>
                </div>
                <!-- Loading indicator for upload -->
                <div wire:loading wire:target="bukti_lampiran" class="text-sm text-kanwil-gold mt-2">Uploading...</div>
                
                @if ($bukti_lampiran)
                    <div class="mt-2 text-sm text-green-600 font-medium border border-green-200 bg-green-50 p-2 rounded">
                        File terpilih: {{ $bukti_lampiran->getClientOriginalName() }}
                    </div>
                @endif
                @error('bukti_lampiran') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="pt-5 border-t border-gray-200 flex justify-end">
                <button type="submit" wire:loading.attr="disabled" class="inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-sm font-bold rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition disabled:opacity-50">
                    <span wire:loading.remove wire:target="submit">Kirim Pengaduan</span>
                    <span wire:loading wire:target="submit">Memproses...</span>
                </button>
            </div>
        </form>
    @endif
</div>
