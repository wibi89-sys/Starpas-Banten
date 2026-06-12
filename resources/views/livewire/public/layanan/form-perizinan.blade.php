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
        <div class="mb-8 border-b border-gray-200 pb-5">
            <h2 class="text-2xl font-bold text-kanwil-blue">Formulir Perizinan & Magang</h2>
            <p class="mt-2 text-sm text-gray-500">Silakan isi formulir di bawah ini dengan data yang valid. Tanda asterisk (*) menandakan kolom wajib diisi.</p>
        </div>

        <form wire:submit="submit" class="space-y-6">
            <div>
                <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap *</label>
                <div class="mt-1">
                    <input type="text" wire:model="nama_lengkap" id="nama_lengkap" class="shadow-sm focus:ring-kanwil-gold focus:border-kanwil-gold block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Contoh: Budi Santoso">
                </div>
                @error('nama_lengkap') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="nik" class="block text-sm font-medium text-gray-700">NIK (Nomor Induk Kependudukan) *</label>
                <div class="mt-1">
                    <input type="text" wire:model="nik" id="nik" class="shadow-sm focus:ring-kanwil-gold focus:border-kanwil-gold block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Contoh: 3674012345678901" maxlength="16">
                </div>
                @error('nik') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="instansi" class="block text-sm font-medium text-gray-700">Asal Instansi / Universitas *</label>
                <div class="mt-1">
                    <input type="text" wire:model="instansi" id="instansi" class="shadow-sm focus:ring-kanwil-gold focus:border-kanwil-gold block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Contoh: Universitas Sultan Ageng Tirtayasa">
                </div>
                @error('instansi') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="tujuan" class="block text-sm font-medium text-gray-700">Tujuan Kegiatan *</label>
                <div class="mt-1">
                    <textarea id="tujuan" wire:model="tujuan" rows="4" class="shadow-sm focus:ring-kanwil-gold focus:border-kanwil-gold block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Jelaskan secara singkat tujuan magang atau penelitian Anda..."></textarea>
                </div>
                @error('tujuan') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
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
                <label for="lampiran_proposal" class="block text-sm font-medium text-gray-700">Lampiran Proposal (PDF/DOC, Maks 5MB) *</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-kanwil-gold transition bg-gray-50">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600 justify-center">
                            <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-kanwil-blue hover:text-kanwil-blue-light focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-kanwil-gold px-1">
                                <span>Upload file</span>
                                <input id="file-upload" wire:model="lampiran_proposal" type="file" class="sr-only">
                            </label>
                            <p class="pl-1">atau drag & drop</p>
                        </div>
                        <p class="text-xs text-gray-500">PDF, DOC, DOCX up to 5MB</p>
                    </div>
                </div>
                <!-- Loading indicator for upload -->
                <div wire:loading wire:target="lampiran_proposal" class="text-sm text-kanwil-gold mt-2">Uploading...</div>
                
                @if ($lampiran_proposal)
                    <div class="mt-2 text-sm text-green-600 font-medium border border-green-200 bg-green-50 p-2 rounded">
                        File terpilih: {{ $lampiran_proposal->getClientOriginalName() }}
                    </div>
                @endif
                @error('lampiran_proposal') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="pt-5 border-t border-gray-200 flex justify-end">
                <button type="submit" wire:loading.attr="disabled" class="inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-sm font-bold rounded-md text-white bg-kanwil-gold hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-kanwil-gold transition disabled:opacity-50">
                    <span wire:loading.remove wire:target="submit">Kirim Permohonan</span>
                    <span wire:loading wire:target="submit">Memproses...</span>
                </button>
            </div>
        </form>
    @endif
</div>
