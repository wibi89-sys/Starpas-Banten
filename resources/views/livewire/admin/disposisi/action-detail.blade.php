<div>
    <x-slot name="header">
        Detail Permohonan: {{ $permohonan->tracking_number }}
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        @if (session()->has('success'))
            <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-4">
                <p class="text-green-700 font-medium">{{ session('success') }}</p>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-4">
                <p class="text-red-700 font-medium">{{ session('error') }}</p>
            </div>
        @endif
        @if (session()->has('warning'))
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                <p class="text-yellow-700 font-medium">{{ session('warning') }}</p>
            </div>
        @endif

        <div class="bg-white shadow rounded-xl p-8 border-t-4 border-kanwil-gold">
            <h3 class="text-2xl font-bold text-kanwil-blue mb-6 border-b pb-4">Informasi Dokumen</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                    <p class="text-sm text-gray-500 font-medium mb-1">Pemohon</p>
                    <p class="font-bold text-gray-900 text-lg">{{ $permohonan->nama_pemohon }}</p>
                    <p class="text-sm text-gray-500">{{ $permohonan->user->email ?? '' }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                    <p class="text-sm text-gray-500 font-medium mb-1">Layanan</p>
                    <p class="font-bold text-gray-900 text-lg">{{ $permohonan->layanan->nama_layanan ?? '-' }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                    <p class="text-sm text-gray-500 font-medium mb-1">Tanggal Pengajuan</p>
                    <p class="font-bold text-gray-900 text-lg">{{ $permohonan->tanggal_pengajuan?->format('d F Y') }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                    <p class="text-sm text-gray-500 font-medium mb-1">Status Saat Ini</p>
                    <span class="px-4 py-1.5 inline-flex text-sm leading-5 font-bold rounded-full bg-blue-100 text-kanwil-blue border border-blue-200">
                        {{ $permohonan->status->label() }}
                    </span>
                </div>
            </div>

            <!-- Dynamic Payload Data Section -->
            <div class="mt-8 pt-8 border-t">
                <h4 class="text-xl font-bold text-kanwil-blue mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-kanwil-blue" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7"></path>
                    </svg>
                    Detail Data Pengajuan
                </h4>
                <div class="bg-gray-50 p-6 rounded-xl border border-gray-150">
                    @if($permohonan->payload_data)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($permohonan->payload_data as $key => $value)
                                @if($key !== 'tipe_form')
                                    <div class="bg-white p-4 rounded-lg border border-gray-100 shadow-sm flex flex-col justify-between">
                                        <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ str_replace('_', ' ', $key) }}</dt>
                                        <dd class="mt-2 text-sm font-bold text-gray-800 break-words">
                                            @if(is_string($value) && (str_starts_with($value, 'lampiran_') || str_starts_with($value, 'bukti_') || str_ends_with(strtolower($value), '.pdf') || str_ends_with(strtolower($value), '.jpg') || str_ends_with(strtolower($value), '.jpeg') || str_ends_with(strtolower($value), '.png')))
                                                <a href="{{ asset('storage/' . $value) }}" target="_blank" class="inline-flex items-center gap-1.5 text-kanwil-blue-light hover:text-kanwil-blue hover:underline transition">
                                                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                    <span>Unduh / Buka Berkas</span>
                                                </a>
                                            @else
                                                {{ is_array($value) ? json_encode($value) : $value }}
                                            @endif
                                        </dd>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500">Tidak ada data tambahan dalam pengajuan ini.</p>
                    @endif
                </div>
            </div>
            
            <div class="mt-8 pt-8">
                <h4 class="text-xl font-bold text-kanwil-blue mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    Form Tindak Lanjut / Disposisi
                </h4>
                
                <form wire:submit="processAction" class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Tentukan Aksi</label>
                            <select wire:model.live="actionType" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-kanwil-gold focus:ring focus:ring-kanwil-gold focus:ring-opacity-50 py-3 transition">
                                <option value="">-- Pilih Tindakan --</option>
                                <option value="approve">✅ Setujui / Teruskan (Proses Selanjutnya)</option>
                                <option value="revise">⚠️ Kembalikan (Revisi Dokumen)</option>
                                <option value="reject">❌ Tolak Permohonan</option>
                            </select>
                            @error('actionType') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        @if($permohonan->status->value === 'disposition' && $actionType === 'approve')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4 bg-blue-50/50 rounded-lg border border-blue-100">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Disposisi ke Tim (Internal Kanwil)</label>
                                    <select wire:model="tujuan_bidang_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-kanwil-gold focus:ring focus:ring-kanwil-gold focus:ring-opacity-50 py-3 transition">
                                        <option value="">-- Pilih Tim --</option>
                                        @foreach($bidangs as $bidang)
                                            <option value="{{ $bidang->id }}">{{ $bidang->nama_bidang }}</option>
                                        @endforeach
                                    </select>
                                    @error('tujuan_bidang_id') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">ATAU Disposisi ke UPT (Satuan Kerja)</label>
                                    <select wire:model="tujuan_upt_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-kanwil-gold focus:ring focus:ring-kanwil-gold focus:ring-opacity-50 py-3 transition">
                                        <option value="">-- Pilih UPT --</option>
                                        @foreach($upts as $upt)
                                            <option value="{{ $upt->id }}">{{ $upt->nama_upt }}</option>
                                        @endforeach
                                    </select>
                                    @error('tujuan_upt_id') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        @endif

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Catatan / Instruksi Disposisi</label>
                            <textarea wire:model="catatan" rows="4" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-kanwil-gold focus:ring focus:ring-kanwil-gold focus:ring-opacity-50 transition" placeholder="Tuliskan catatan disposisi, instruksi untuk bawahan, atau alasan penolakan..."></textarea>
                            @error('catatan') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="pt-4 flex flex-wrap justify-end gap-4 border-t border-gray-200 mt-6 pt-6">
                            <a href="{{ route('admin.inbox') }}" wire:navigate class="inline-flex justify-center items-center py-2.5 px-6 border border-gray-300 shadow-sm text-sm font-bold rounded-lg text-gray-700 bg-white hover:bg-gray-100 transition">
                                Kembali
                            </a>
                            <button type="submit" class="inline-flex justify-center items-center py-2.5 px-6 border border-transparent shadow-md text-sm font-bold rounded-lg text-white bg-kanwil-blue hover:bg-kanwil-blue-light focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-kanwil-blue transition transform hover:-translate-y-0.5">
                                Simpan Tindakan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
