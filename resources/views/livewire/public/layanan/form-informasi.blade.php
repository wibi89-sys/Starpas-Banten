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
        <div class="mb-8 border-b border-gray-200 pb-5">
            <h2 class="text-2xl font-bold text-kanwil-blue">Permintaan Informasi Publik</h2>
            <p class="mt-2 text-sm text-gray-500">Ajukan permintaan data, dokumen, atau informasi publik. Lampirkan foto KTP/Identitas Anda sebagai syarat administrasi.</p>
        </div>

        <form wire:submit="submit" class="space-y-6">
            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                <div>
                    <label for="nama_pemohon" class="block text-sm font-medium text-gray-700">Nama Lengkap Pemohon *</label>
                    <div class="mt-1">
                        <input type="text" wire:model="nama_pemohon" id="nama_pemohon" class="shadow-sm focus:ring-kanwil-gold focus:border-kanwil-gold block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Sesuai KTP">
                    </div>
                    @error('nama_pemohon') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="nomor_identitas" class="block text-sm font-medium text-gray-700">NIK / Nomor Identitas *</label>
                    <div class="mt-1">
                        <input type="text" wire:model="nomor_identitas" id="nomor_identitas" class="shadow-sm focus:ring-kanwil-gold focus:border-kanwil-gold block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Contoh: 3671xxxxxxxxxxxx">
                    </div>
                    @error('nomor_identitas') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label for="jenis_informasi" class="block text-sm font-medium text-gray-700">Jenis Informasi yang Diminta *</label>
                <div class="mt-1">
                    <input type="text" wire:model="jenis_informasi" id="jenis_informasi" class="shadow-sm focus:ring-kanwil-gold focus:border-kanwil-gold block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Contoh: Salinan Dokumen DIPA Tahun 2026">
                </div>
                @error('jenis_informasi') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="alasan_permintaan" class="block text-sm font-medium text-gray-700">Tujuan / Alasan Permintaan *</label>
                <div class="mt-1">
                    <textarea id="alasan_permintaan" wire:model="alasan_permintaan" rows="4" class="shadow-sm focus:ring-kanwil-gold focus:border-kanwil-gold block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Jelaskan secara jelas tujuan Anda meminta informasi tersebut..."></textarea>
                </div>
                @error('alasan_permintaan') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="lampiran_identitas" class="block text-sm font-medium text-gray-700">Upload Foto KTP / Identitas (Maks 5MB) *</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-kanwil-gold transition bg-gray-50">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600 justify-center">
                            <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-kanwil-blue hover:text-kanwil-blue-light focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-kanwil-gold px-1">
                                <span>Upload identitas</span>
                                <input id="file-upload" wire:model="lampiran_identitas" type="file" class="sr-only">
                            </label>
                            <p class="pl-1">atau drag & drop</p>
                        </div>
                        <p class="text-xs text-gray-500">JPG, PNG, PDF up to 5MB</p>
                    </div>
                </div>
                <!-- Loading indicator for upload -->
                <div wire:loading wire:target="lampiran_identitas" class="text-sm text-kanwil-gold mt-2">Uploading...</div>
                
                @if ($lampiran_identitas)
                    <div class="mt-2 text-sm text-green-600 font-medium border border-green-200 bg-green-50 p-2 rounded">
                        File terpilih: {{ $lampiran_identitas->getClientOriginalName() }}
                    </div>
                @endif
                @error('lampiran_identitas') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="pt-5 border-t border-gray-200 flex justify-end">
                <button type="submit" wire:loading.attr="disabled" class="inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-sm font-bold rounded-md text-white bg-kanwil-blue hover:bg-kanwil-blue-light focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-kanwil-blue transition disabled:opacity-50">
                    <span wire:loading.remove wire:target="submit">Kirim Permintaan</span>
                    <span wire:loading wire:target="submit">Memproses...</span>
                </button>
            </div>
        </form>
    @endif
</div>
