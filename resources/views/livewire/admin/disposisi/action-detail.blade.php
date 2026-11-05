<div>
    <x-slot name="header">
        Detail Permohonan: {{ $permohonan->tracking_number }}
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6 pb-12">
        {{-- TOMBOL KEMBALI KE INBOX & RIWAYAT --}}
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.inbox') }}" wire:navigate class="inline-flex items-center gap-2 text-xs font-bold text-kanwil-blue hover:text-blue-800 bg-white hover:bg-gray-50 border border-gray-200 px-3.5 py-2 rounded-xl shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span>Kembali ke Kotak Masuk & Riwayat</span>
            </a>
            
            <span class="text-xs text-gray-500 font-medium hidden sm:inline">
                STARPAS Kanwil Ditjenpas Banten
            </span>
        </div>

        {{-- FLASH ALERTS --}}
        @if (session()->has('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-xl shadow-sm">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <p class="text-green-800 font-bold text-sm">{{ session('success') }}</p>
                </div>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl shadow-sm">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    <p class="text-red-800 font-bold text-sm">{{ session('error') }}</p>
                </div>
            </div>
        @endif
        @if (session()->has('warning'))
            <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-r-xl shadow-sm">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-yellow-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <p class="text-yellow-800 font-bold text-sm">{{ session('warning') }}</p>
                </div>
            </div>
        @endif

        {{-- 1. INFORMASI UTAMA PERMOHONAN --}}
        <div class="bg-white shadow rounded-2xl p-6 sm:p-8 border-t-4 border-kanwil-gold">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b pb-4 mb-6">
                <div>
                    <span class="text-xs font-black uppercase tracking-wider text-kanwil-gold">STARPAS Kanwil Ditjenpas Banten</span>
                    <h3 class="text-2xl font-black text-kanwil-blue">Detail Permohonan Pelayanan</h3>
                </div>
                <div class="flex items-center gap-2">
                    <span class="px-4 py-1.5 inline-flex text-xs font-black rounded-full uppercase tracking-wider shadow-sm border {{ $permohonan->status->value === 'completed' ? 'bg-emerald-100 text-emerald-800 border-emerald-300' : ($permohonan->status->value === 'rejected' ? 'bg-rose-100 text-rose-800 border-rose-300' : 'bg-blue-100 text-kanwil-blue border-blue-200') }}">
                        Status: {{ $permohonan->status->label() }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-150">
                    <p class="text-xs text-gray-400 font-black uppercase tracking-wider mb-1">Nomor Tracking</p>
                    <p class="font-mono font-black text-gray-900 text-base">{{ $permohonan->tracking_number }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-150">
                    <p class="text-xs text-gray-400 font-black uppercase tracking-wider mb-1">Pemohon</p>
                    <p class="font-bold text-gray-900 text-base truncate" title="{{ $permohonan->nama_pemohon }}">{{ $permohonan->nama_pemohon }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ $permohonan->payload_data['nomor_kontak'] ?? '-' }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-150">
                    <p class="text-xs text-gray-400 font-black uppercase tracking-wider mb-1">Jenis Layanan</p>
                    <p class="font-bold text-gray-900 text-base truncate" title="{{ $permohonan->layanan->nama_layanan ?? '-' }}">{{ $permohonan->layanan->nama_layanan ?? '-' }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-150">
                    <p class="text-xs text-gray-400 font-black uppercase tracking-wider mb-1">Tanggal Diajukan</p>
                    <p class="font-bold text-gray-900 text-base">{{ $permohonan->tanggal_pengajuan?->format('d/m/Y') ?? $permohonan->created_at->format('d/m/Y') }}</p>
                </div>
            </div>

            {{-- DOKUMEN SURAT KEPUTUSAN / PERSETUJUAN RESMI (JIKA SUDAH ADA) --}}
            @if($permohonan->file_surat_jawaban || $permohonan->nomor_surat_jawaban)
                <div class="mt-6 p-5 bg-emerald-50/80 rounded-xl border-2 border-emerald-300">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-lg bg-emerald-600 text-white flex items-center justify-center flex-shrink-0 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-base font-black text-emerald-950">Dokumen Surat Persetujuan / Jawaban Resmi</h4>
                                <div class="mt-1 text-xs text-emerald-800 space-y-0.5">
                                    @if($permohonan->nomor_surat_jawaban)
                                        <p><span class="font-bold">Nomor Surat:</span> {{ $permohonan->nomor_surat_jawaban }}</p>
                                    @endif
                                    @if($permohonan->perihal_surat_jawaban)
                                        <p><span class="font-bold">Perihal:</span> {{ $permohonan->perihal_surat_jawaban }}</p>
                                    @endif
                                    @if($permohonan->tanggal_surat_jawaban)
                                        <p><span class="font-bold">Tanggal Ditetapkan:</span> {{ $permohonan->tanggal_surat_jawaban->format('d F Y') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if($permohonan->file_surat_jawaban)
                            <a href="{{ asset('storage/' . $permohonan->file_surat_jawaban) }}" target="_blank" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-black rounded-lg shadow transition flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                <span>Unduh Surat Resmi</span>
                            </a>
                        @endif
                    </div>
                </div>
            @endif

            {{-- 2. RINCIAN DATA PENGAJUAN (PAYLOAD DARI PEMOHON) --}}
            <div class="mt-8 pt-6 border-t border-gray-200">
                <h4 class="text-lg font-black text-kanwil-blue mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-kanwil-blue" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Berkas & Isian Formulir Pemohon
                </h4>
                <div class="bg-gray-50 p-5 rounded-xl border border-gray-200">
                    @if($permohonan->payload_data)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($permohonan->payload_data as $key => $value)
                                @if($key !== 'tipe_form')
                                    <div class="bg-white p-3.5 rounded-lg border border-gray-150 shadow-sm flex flex-col justify-between">
                                        <dt class="text-[11px] font-black text-gray-400 uppercase tracking-wider">{{ str_replace('_', ' ', $key) }}</dt>
                                        <dd class="mt-1 text-sm font-semibold text-gray-800 break-words">
                                            @if(is_string($value) && (str_starts_with($value, 'lampiran_') || str_starts_with($value, 'bukti_') || str_ends_with(strtolower($value), '.pdf') || str_ends_with(strtolower($value), '.jpg') || str_ends_with(strtolower($value), '.jpeg') || str_ends_with(strtolower($value), '.png')))
                                                <a href="{{ asset('storage/' . $value) }}" target="_blank" class="inline-flex items-center gap-1.5 text-blue-600 hover:text-blue-800 font-bold hover:underline transition">
                                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                    <span>Lihat / Unduh Berkas Persyaratan</span>
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
                        <p class="text-sm text-gray-500">Tidak ada isian tambahan.</p>
                    @endif
                </div>
            </div>

            {{-- 3. INFORMASI DISPOSISI & INSTRUKSI PIMPINAN (JIKA ADA) --}}
            @if($permohonan->disposisis && $permohonan->disposisis->count() > 0)
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h4 class="text-lg font-black text-kanwil-blue mb-4 flex items-center gap-2">
                        <svg width="20" height="20" class="w-5 h-5 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                        Instruksi & Arahan Disposisi Pimpinan
                    </h4>
                    
                    <div class="space-y-3">
                        @foreach($permohonan->disposisis as $disp)
                            <div class="bg-amber-50/70 border border-amber-200 rounded-xl p-4 sm:p-5">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-3 border-b border-amber-200/80 mb-3">
                                    <div class="flex items-center gap-2">
                                        <span class="px-2.5 py-1 text-[11px] font-black rounded-md bg-amber-600 text-white uppercase tracking-wider">
                                            Disposisi
                                        </span>
                                        <span class="text-xs font-bold text-gray-800">
                                            Dari: <span class="text-amber-900">{{ $disp->dariUser->name ?? 'Pejabat Disposisi' }}</span>
                                        </span>
                                    </div>
                                    <span class="text-[11px] text-gray-500 font-semibold">
                                        {{ $disp->created_at->format('d F Y, H:i') }} WIB
                                    </span>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs mb-3">
                                    <div>
                                        <span class="text-gray-500 font-bold">Ditujukan Kepada:</span>
                                        @if($disp->keBidang)
                                            <span class="ml-1 font-black text-sky-800 bg-sky-100 px-2.5 py-0.5 rounded border border-sky-200">
                                                {{ $disp->keBidang->nama_bidang }}
                                            </span>
                                        @elseif($disp->keUpt)
                                            <span class="ml-1 font-black text-amber-900 bg-amber-100 px-2.5 py-0.5 rounded border border-amber-300">
                                                {{ $disp->keUpt->nama_upt }}
                                            </span>
                                        @else
                                            <span class="ml-1 font-bold text-gray-600">-</span>
                                        @endif
                                    </div>
                                </div>

                                @if($disp->catatan)
                                    <div class="bg-white p-3 rounded-lg border border-amber-200 text-xs text-gray-800">
                                        <span class="font-bold text-amber-900 block mb-1">Catatan / Arahan Khusus:</span>
                                        <p class="leading-relaxed font-sans italic">"{{ $disp->catatan }}"</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- 4. RIWAYAT LENGKAP JEJAK TINDAK LANJUT (AUDIT TRAIL / TIMELINE) --}}
            @if($permohonan->timelines && $permohonan->timelines->count() > 0)
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h4 class="text-lg font-black text-kanwil-blue mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-kanwil-blue" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Riwayat Jejak Tindak Lanjut (*Audit Trail*)
                    </h4>
                    <div class="space-y-3">
                        @foreach($permohonan->timelines as $timeline)
                            @php
                                $roleName = $timeline->user ? ($timeline->user->getRoleNames()->first() ?? 'Petugas') : 'Sistem';
                                $isCompletedStep = $timeline->status_baru->value === 'completed';
                                $isReviewStep = str_starts_with($timeline->catatan ?? '', 'Catatan Review Pimpinan:');
                            @endphp
                            <div class="bg-gray-50 p-4 rounded-xl border {{ $isCompletedStep ? 'border-emerald-300 bg-emerald-50/40' : ($isReviewStep ? 'border-purple-300 bg-purple-50/40' : 'border-gray-200') }} flex flex-col sm:flex-row sm:items-start justify-between gap-3 text-xs">
                                <div class="space-y-1.5 flex-1">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="font-black px-2.5 py-0.5 rounded border {{ $isCompletedStep ? 'bg-emerald-600 text-white border-emerald-600' : ($isReviewStep ? 'bg-purple-600 text-white border-purple-600' : 'bg-white text-gray-900 border-gray-200') }}">
                                            {{ $isReviewStep ? 'Review Pimpinan' : $timeline->status_baru->label() }}
                                        </span>
                                        <span class="text-gray-500 font-medium">
                                            oleh <span class="font-bold text-gray-900">{{ $timeline->user->name ?? 'Sistem' }}</span>
                                            <span class="text-gray-400">({{ $roleName }})</span>
                                        </span>
                                    </div>

                                    @if($timeline->catatan)
                                        <p class="text-gray-800 bg-white p-3 rounded-lg border border-gray-150 leading-relaxed font-sans shadow-sm">
                                            {{ $timeline->catatan }}
                                        </p>
                                    @endif

                                    @if($timeline->lampiran_file)
                                        <div class="pt-1">
                                            <a href="{{ asset('storage/' . $timeline->lampiran_file) }}" target="_blank" class="inline-flex items-center gap-1.5 text-kanwil-blue font-bold hover:underline bg-white px-3 py-1.5 rounded border border-blue-200 shadow-sm">
                                                <svg class="w-3.5 h-3.5 text-kanwil-blue" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                                <span>Lampiran: {{ $timeline->nama_lampiran ?? 'Unduh Berkas' }}</span>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                                <span class="text-gray-400 font-semibold whitespace-nowrap text-[11px] self-start">
                                    {{ $timeline->created_at->format('d/m/Y H:i') }} WIB
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- 5. KEPUTUSAN AKHIR / REVIEW PIMPINAN / FORMULIR TINDAK LANJUT --}}
            <div class="mt-8 pt-6 border-t border-gray-200">
                @if($permohonan->status->value === 'completed')
                    {{-- KONDISI A: PERMOHONAN TELAH SELESAI DITINDAKLANJUTI --}}
                    <div class="bg-gradient-to-r from-emerald-50 to-teal-50 border-2 border-emerald-300 rounded-2xl p-6 sm:p-7 shadow-sm space-y-5">
                        <div class="flex items-start gap-4">
                            <div class="h-12 w-12 rounded-xl bg-emerald-600 text-white flex items-center justify-center flex-shrink-0 shadow-md">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <span class="text-[10px] font-black uppercase tracking-wider text-emerald-800 bg-emerald-200/70 px-2.5 py-0.5 rounded-full">
                                    Tuntas & Telah Ditindaklanjuti
                                </span>
                                <h4 class="text-xl font-black text-emerald-950 mt-1">Permohonan Ini Telah Selesai</h4>
                                <p class="text-xs text-emerald-800 mt-1 leading-relaxed">
                                    Tindak lanjut oleh operator / admin tim telah selesai dituntaskan. Seluruh riwayat, berkas formulir, dokumen hasil persetujuan, dan catatan koordinasi dapat direview pada bagian di atas.
                                </p>
                            </div>
                        </div>

                        {{-- FORM TAMBAH CATATAN EVALUASI / REVIEW PIMPINAN --}}
                        @if($this->canUserReview())
                            <div class="bg-white/80 rounded-xl p-4 border border-emerald-200 space-y-3">
                                <h5 class="text-xs font-black uppercase tracking-wider text-kanwil-blue flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-kanwil-blue" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Tambah Catatan Evaluasi / Review Pimpinan
                                </h5>
                                <p class="text-[11px] text-gray-500">
                                    Sebagai Pimpinan atau Reviewer, Anda dapat membubuhkan catatan evaluasi, supervisi, atau masukan internal yang akan tersimpan permanen pada riwayat permohonan ini.
                                </p>
                                
                                <form wire:submit="addReviewNote" class="space-y-3">
                                    <textarea wire:model="catatanReview" rows="2" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-kanwil-gold focus:ring focus:ring-kanwil-gold text-xs transition" placeholder="Tuliskan catatan evaluasi atau konfirmasi review pimpinan di sini..."></textarea>
                                    @error('catatanReview') <span class="text-red-500 text-xs block font-semibold">{{ $message }}</span> @enderror
                                    
                                    <div class="flex justify-end">
                                        <button type="submit" wire:loading.attr="disabled" class="inline-flex items-center gap-1.5 px-4 py-2 bg-kanwil-blue hover:bg-kanwil-blue-light text-white text-xs font-bold rounded-lg shadow-sm transition cursor-pointer">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                                            <span wire:loading.remove wire:target="addReviewNote">Simpan Catatan Review</span>
                                            <span wire:loading wire:target="addReviewNote">Menyimpan...</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif

                        <div class="pt-2 flex justify-end">
                            <a href="{{ route('admin.inbox') }}" wire:navigate class="inline-flex items-center gap-2 px-5 py-2.5 bg-white hover:bg-gray-100 text-gray-800 text-xs font-bold rounded-xl border border-gray-200 shadow-sm transition">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                <span>Kembali ke Kotak Masuk & Riwayat</span>
                            </a>
                        </div>
                    </div>

                @elseif($permohonan->status->value === 'rejected')
                    {{-- KONDISI B: STATUS DITOLAK --}}
                    <div class="bg-rose-50 border-2 border-rose-300 rounded-2xl p-6 shadow-sm space-y-4">
                        <div class="flex items-start gap-4">
                            <div class="h-10 w-10 rounded-xl bg-rose-600 text-white flex items-center justify-center flex-shrink-0 shadow-md">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-black text-rose-950">Permohonan Ditolak</h4>
                                <p class="text-xs text-rose-800 mt-1">
                                    Permohonan ini telah ditolak. Alasan penolakan telah tercatat pada riwayat di atas dan telah dinotifikasikan kepada pemohon.
                                </p>
                            </div>
                        </div>
                        <div class="flex justify-end pt-2">
                            <a href="{{ route('admin.inbox') }}" wire:navigate class="px-4 py-2 bg-white text-gray-700 text-xs font-bold rounded-xl border border-gray-200 shadow-sm">
                                Kembali ke Kotak Masuk
                            </a>
                        </div>
                    </div>

                @else
                    {{-- KONDISI C: PERMOHONAN MASIH AKTIF BERJALAN --}}
                    @if($this->canUserProcess())
                        {{-- USER MEMILIKI HAK MEMPROSES TAHAP INI --}}
                        <h4 class="text-lg font-black text-kanwil-blue mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-kanwil-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                            Formulir Aksi Tindak Lanjut
                        </h4>
                        
                        <form wire:submit="processAction" class="bg-gray-50 p-6 rounded-2xl border border-gray-200 space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Tentukan Tindakan</label>
                                <select wire:model.live="actionType" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-kanwil-gold focus:ring focus:ring-kanwil-gold focus:ring-opacity-50 py-3 text-sm font-semibold transition">
                                    <option value="">-- Pilih Tindakan --</option>
                                    @if($permohonan->status->value === 'verification')
                                        <option value="approve">✅ Setujui Verifikasi (Lanjutkan ke Disposisi)</option>
                                    @elseif($permohonan->status->value === 'disposition')
                                        <option value="approve">✅ Kirim Disposisi ke Tim / UPT Pelaksana</option>
                                    @elseif($permohonan->status->value === 'processing' || $permohonan->status->value === 'review')
                                        <option value="approve">✅ Selesaikan Permohonan (Terbitkan Keputusan/Konfirmasi Selesai)</option>
                                    @else
                                        <option value="approve">✅ Setujui / Teruskan</option>
                                    @endif
                                    <option value="revise">⚠️ Kembalikan (Revisi / Lengkapi Berkas)</option>
                                    <option value="reject">❌ Tolak Permohonan</option>
                                </select>
                                @error('actionType') <span class="text-red-500 text-xs mt-1 block font-semibold">{{ $message }}</span> @enderror
                            </div>

                            {{-- PILIHAN DISPOSISI (JIKA STATUS DISPOSISI) --}}
                            @if($permohonan->status->value === 'disposition' && $actionType === 'approve')
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4 bg-blue-50/70 rounded-xl border border-blue-200">
                                    <div>
                                        <label class="block text-xs font-black uppercase tracking-wider text-gray-700 mb-2">Disposisi ke Tim (Internal Kanwil)</label>
                                        <select wire:model="tujuan_bidang_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-kanwil-gold focus:ring focus:ring-kanwil-gold py-2.5 text-sm transition">
                                            <option value="">-- Pilih Tim Internal --</option>
                                            @foreach($bidangs as $bidang)
                                                <option value="{{ $bidang->id }}">{{ $bidang->nama_bidang }}</option>
                                            @endforeach
                                        </select>
                                        @error('tujuan_bidang_id') <span class="text-red-500 text-xs mt-1 block font-semibold">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <div>
                                        <label class="block text-xs font-black uppercase tracking-wider text-gray-700 mb-2">ATAU Disposisi ke UPT (Satuan Kerja)</label>
                                        <select wire:model="tujuan_upt_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-kanwil-gold focus:ring focus:ring-kanwil-gold py-2.5 text-sm transition">
                                            <option value="">-- Pilih UPT Pelaksana --</option>
                                            @foreach($upts as $upt)
                                                <option value="{{ $upt->id }}">{{ $upt->nama_upt }}</option>
                                            @endforeach
                                        </select>
                                        @error('tujuan_upt_id') <span class="text-red-500 text-xs mt-1 block font-semibold">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            @endif

                            {{-- DOKUMEN SURAT PERSETUJUAN / JAWABAN (MUNCUL SAAT STATUS PROCESSING -> SELESAI) --}}
                            @if(($permohonan->status->value === 'processing' || $permohonan->status->value === 'review') && $actionType === 'approve')
                                <div class="p-5 bg-amber-50/60 rounded-xl border border-amber-200 space-y-4">
                                    <div class="flex items-start gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-amber-500 text-white flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                        <div>
                                            <h5 class="text-sm font-black text-gray-900">Dokumen Surat Persetujuan / Hasil Pelayanan (Opsional)</h5>
                                            <p class="text-xs text-gray-600 mt-0.5">
                                                Kosongkan bagian ini jika permohonan/pengaduan diselesaikan cukup dengan konfirmasi langsung tanpa menerbitkan surat dinas resmi.
                                            </p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                                        <div>
                                            <label class="block text-xs font-bold text-gray-700 mb-1">Nomor Surat Dinas (Opsional)</label>
                                            <input type="text" wire:model="nomor_surat_jawaban" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-kanwil-gold focus:ring focus:ring-kanwil-gold text-xs py-2" placeholder="Contoh: W12.PAS.UM.01.01-1234">
                                            @error('nomor_surat_jawaban') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>

                                        <div>
                                            <label class="block text-xs font-bold text-gray-700 mb-1">Perihal Surat (Opsional)</label>
                                            <input type="text" wire:model="perihal_surat_jawaban" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-kanwil-gold focus:ring focus:ring-kanwil-gold text-xs py-2" placeholder="Perihal Surat / Jawaban">
                                            @error('perihal_surat_jawaban') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>

                                        <div>
                                            <label class="block text-xs font-bold text-gray-700 mb-1">Tanggal Surat (Opsional)</label>
                                            <input type="date" wire:model="tanggal_surat_jawaban" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-kanwil-gold focus:ring focus:ring-kanwil-gold text-xs py-2">
                                            @error('tanggal_surat_jawaban') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    {{-- FILE UPLOAD --}}
                                    <div class="pt-2 border-t border-amber-200/80">
                                        <label class="block text-xs font-bold text-gray-700 mb-1">Unggah Berkas Surat Persetujuan / Hasil Tindak Lanjut (Opsional)</label>
                                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                                            <label class="cursor-pointer inline-flex items-center gap-2 px-4 py-2 bg-white hover:bg-gray-50 border border-gray-300 rounded-lg text-xs font-bold text-gray-700 shadow-sm transition">
                                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                                <span>Pilih Berkas (.pdf, .doc, .docx, .jpg)</span>
                                                <input type="file" wire:model="file_surat_jawaban" class="hidden" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                            </label>
                                            
                                            <span wire:loading wire:target="file_surat_jawaban" class="text-xs text-blue-600 font-bold animate-pulse flex items-center gap-1.5">
                                                <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                                Mengunggah berkas...
                                            </span>

                                            @if($file_surat_jawaban)
                                                <div class="flex items-center gap-2 bg-emerald-100 text-emerald-800 px-3 py-1.5 rounded-lg text-xs font-bold border border-emerald-200">
                                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                                                    <span class="truncate max-w-xs">{{ $file_surat_jawaban->getClientOriginalName() }}</span>
                                                    <button type="button" wire:click="clearFile" class="text-red-500 hover:text-red-700 ml-1" title="Batalkan berkas">&times;</button>
                                                </div>
                                            @endif
                                        </div>
                                        <p class="text-[11px] text-gray-500 mt-1.5">Maksimal ukuran file: 10MB. Berkas ini nantinya dapat diunduh langsung oleh pemohon.</p>
                                        @error('file_surat_jawaban') <span class="text-red-500 text-xs mt-1 block font-semibold">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            @endif

                            {{-- CATATAN TINDAK LANJUT --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    Catatan Tindak Lanjut / Keterangan Penyelesaian
                                    <span class="text-red-500">*</span>
                                </label>
                                <textarea wire:model="catatan" rows="4" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-kanwil-gold focus:ring focus:ring-kanwil-gold text-sm transition" placeholder="Tuliskan hasil koordinasi, uraian penyelesaian pengaduan, atau instruksi tindak lanjut..."></textarea>
                                @error('catatan') <span class="text-red-500 text-xs mt-1 block font-semibold">{{ $message }}</span> @enderror
                            </div>
                            
                            {{-- TOMBOL AKSI --}}
                            <div class="pt-4 flex flex-wrap justify-end gap-3 border-t border-gray-200">
                                <a href="{{ route('admin.inbox') }}" wire:navigate class="inline-flex justify-center items-center py-2.5 px-6 border border-gray-300 shadow-sm text-sm font-bold rounded-xl text-gray-700 bg-white hover:bg-gray-100 transition">
                                    Kembali ke Inbox
                                </a>
                                <button type="submit" wire:loading.attr="disabled" class="inline-flex justify-center items-center gap-2 py-2.5 px-6 border border-transparent shadow-md text-sm font-bold rounded-xl text-white bg-kanwil-blue hover:bg-kanwil-blue-light focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-kanwil-blue transition disabled:opacity-50 cursor-pointer">
                                    <svg wire:loading class="animate-spin -ml-1 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                    <span wire:loading.remove>Simpan & Tuntaskan Tindakan</span>
                                    <span wire:loading>Memproses...</span>
                                </button>
                            </div>
                        </form>
                    @else
                        {{-- USER SEDANG DALAM MODE REVIEW / BUKAN GILIRAN TUGASNYA --}}
                        <div class="bg-blue-50/70 border border-blue-200 rounded-2xl p-5 flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-100 text-kanwil-blue flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h5 class="text-sm font-bold text-kanwil-blue">Mode Tinjau (*Review Only*)</h5>
                                <p class="text-xs text-gray-600 mt-1 leading-relaxed">
                                    Permohonan ini saat ini berada pada tahap status <span class="font-bold text-gray-900">{{ $permohonan->status->label() }}</span>. Anda dapat meninjau seluruh data dan berkas di atas. Tindakan pemrosesan tahap ini ditujukan untuk petugas terkait.
                                </p>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
