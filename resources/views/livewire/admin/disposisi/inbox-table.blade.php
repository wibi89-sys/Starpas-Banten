<div>
    <x-slot name="header">
        Inbox Disposisi & Riwayat Permohonan
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6">
        {{-- KARTU UTAMA TABEL INBOX & RIWAYAT --}}
        <div class="bg-white shadow rounded-2xl border-t-4 border-kanwil-gold overflow-hidden">
            {{-- HEADER BAGIAN ATAS --}}
            <div class="p-4 sm:p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h3 class="text-xl font-black text-kanwil-blue">Daftar Permohonan & Kotak Masuk</h3>
                    <p class="text-xs text-gray-500 mt-0.5">
                        Kelola alur disposisi, tindak lanjuti tugas aktif, dan review riwayat penyelesaian berkas
                    </p>
                </div>

                {{-- PENCARIAN & FILTER STATUS CEPAT --}}
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full md:w-auto">
                    <div class="relative w-full sm:w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari Resi / Pemohon..." class="block w-full pl-9 pr-3 py-2 rounded-xl border-gray-200 shadow-sm focus:border-kanwil-gold focus:ring focus:ring-kanwil-gold text-xs transition">
                    </div>

                    <select wire:model.live="statusFilter" class="rounded-xl border-gray-200 shadow-sm focus:border-kanwil-gold focus:ring focus:ring-kanwil-gold text-xs py-2 px-3 text-gray-700 font-semibold transition">
                        <option value="">-- Semua Status --</option>
                        <option value="verification">Verifikasi</option>
                        <option value="disposition">Disposisi</option>
                        <option value="processing">Diproses</option>
                        <option value="review">Review Pimpinan</option>
                        <option value="completed">Selesai</option>
                        <option value="revision">Revisi</option>
                        <option value="rejected">Ditolak</option>
                    </select>
                </div>
            </div>

            {{-- TAB NAVIGATION (SEMUA | PERLU TINDAK LANJUT | RIWAYAT SELESAI) --}}
            <div class="bg-gray-50/80 px-4 sm:px-6 border-b border-gray-200">
                <nav class="flex space-x-3 sm:space-x-6 overflow-x-auto py-2" aria-label="Tabs">
                    {{-- Tab 1: Semua --}}
                    <button wire:click="setTab('all')" type="button" class="whitespace-nowrap py-2.5 px-3 border-b-2 font-bold text-xs flex items-center gap-2 transition cursor-pointer {{ $activeTab === 'all' ? 'border-kanwil-blue text-kanwil-blue' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        <svg width="16" height="16" class="w-4 h-4 {{ $activeTab === 'all' ? 'text-kanwil-blue' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                        <span>Semua Permohonan</span>
                        <span class="ml-1 px-2 py-0.5 text-[10px] rounded-full font-black {{ $activeTab === 'all' ? 'bg-blue-100 text-kanwil-blue' : 'bg-gray-200 text-gray-700' }}">
                            {{ $totalCount }}
                        </span>
                    </button>

                    {{-- Tab 2: Perlu Tindak Lanjut --}}
                    <button wire:click="setTab('pending')" type="button" class="whitespace-nowrap py-2.5 px-3 border-b-2 font-bold text-xs flex items-center gap-2 transition cursor-pointer {{ $activeTab === 'pending' ? 'border-amber-500 text-amber-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        <svg width="16" height="16" class="w-4 h-4 {{ $activeTab === 'pending' ? 'text-amber-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        <span>Perlu Tindak Lanjut</span>
                        <span class="ml-1 px-2 py-0.5 text-[10px] rounded-full font-black {{ $pendingCount > 0 ? 'bg-amber-100 text-amber-800 border border-amber-300' : 'bg-gray-200 text-gray-700' }}">
                            {{ $pendingCount }}
                        </span>
                    </button>

                    {{-- Tab 3: Riwayat Selesai --}}
                    <button wire:click="setTab('completed')" type="button" class="whitespace-nowrap py-2.5 px-3 border-b-2 font-bold text-xs flex items-center gap-2 transition cursor-pointer {{ $activeTab === 'completed' ? 'border-emerald-600 text-emerald-800' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        <svg width="16" height="16" class="w-4 h-4 {{ $activeTab === 'completed' ? 'text-emerald-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Riwayat Selesai (Review)</span>
                        <span class="ml-1 px-2 py-0.5 text-[10px] rounded-full font-black {{ $completedCount > 0 ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : 'bg-gray-200 text-gray-700' }}">
                            {{ $completedCount }}
                        </span>
                    </button>
                </nav>
            </div>

            {{-- TABEL DATA PERMOHONAN --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50/75">
                        <tr>
                            <th scope="col" class="px-6 py-3.5 text-left text-[11px] font-black text-gray-500 uppercase tracking-wider">No. Resi & Waktu</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-[11px] font-black text-gray-500 uppercase tracking-wider">Pemohon</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-[11px] font-black text-gray-500 uppercase tracking-wider">Layanan</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-[11px] font-black text-gray-500 uppercase tracking-wider">Tujuan Disposisi</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-[11px] font-black text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3.5 text-right text-[11px] font-black text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse ($permohonans as $p)
                            @php
                                $lastDisposisi = $p->disposisis->last();
                                $statusVal = $p->status->value;
                                
                                $badgeClass = match($statusVal) {
                                    'completed'    => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                                    'processing'   => 'bg-blue-100 text-blue-800 border-blue-300',
                                    'disposition'  => 'bg-amber-100 text-amber-800 border-amber-300',
                                    'verification' => 'bg-indigo-100 text-indigo-800 border-indigo-300',
                                    'review'       => 'bg-purple-100 text-purple-800 border-purple-300',
                                    'revision'     => 'bg-orange-100 text-orange-800 border-orange-300',
                                    'rejected'     => 'bg-rose-100 text-rose-800 border-rose-300',
                                    default        => 'bg-gray-100 text-gray-800 border-gray-300',
                                };
                            @endphp
                            <tr class="hover:bg-blue-50/40 transition">
                                {{-- NO RESI & TANGGAL --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-mono font-black text-sm text-kanwil-blue">{{ $p->tracking_number }}</div>
                                    <div class="text-[11px] text-gray-400 font-semibold mt-0.5">
                                        {{ $p->tanggal_pengajuan ? $p->tanggal_pengajuan->format('d/m/Y') : $p->created_at->format('d/m/Y') }}
                                        &bull; {{ $p->created_at->format('H:i') }} WIB
                                    </div>
                                </td>

                                {{-- PEMOHON --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900 truncate max-w-xs">{{ $p->nama_pemohon }}</div>
                                    <div class="text-[11px] text-gray-500 truncate max-w-xs">{{ $p->payload_data['nomor_kontak'] ?? ($p->user->email ?? '-') }}</div>
                                </td>

                                {{-- LAYANAN --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-xs font-semibold text-gray-800 truncate max-w-xs" title="{{ $p->layanan->nama_layanan ?? '-' }}">
                                        {{ $p->layanan->nama_layanan ?? '-' }}
                                    </div>
                                    <div class="text-[10px] text-gray-400 uppercase tracking-wider font-bold">
                                        {{ $p->layanan->jenis_layanan ?? 'Pelayanan' }}
                                    </div>
                                </td>

                                {{-- TUJUAN DISPOSISI --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($lastDisposisi)
                                        @if($lastDisposisi->keBidang)
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-bold bg-sky-50 text-sky-800 border border-sky-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-sky-500 flex-shrink-0"></span>
                                                <span class="truncate max-w-[170px]" title="{{ $lastDisposisi->keBidang->nama_bidang }}">{{ $lastDisposisi->keBidang->nama_bidang }}</span>
                                            </span>
                                        @elseif($lastDisposisi->keUpt)
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 flex-shrink-0"></span>
                                                <span class="truncate max-w-[170px]" title="{{ $lastDisposisi->keUpt->nama_upt }}">{{ $lastDisposisi->keUpt->nama_upt }}</span>
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-400">-</span>
                                        @endif
                                    @else
                                        <span class="text-[11px] text-gray-400 font-semibold italic bg-gray-50 px-2 py-0.5 rounded border border-gray-150">Belum didisposisi</span>
                                    @endif
                                </td>

                                {{-- STATUS BADGE --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-black rounded-full border shadow-sm {{ $badgeClass }}">
                                        {{ $p->status->label() }}
                                    </span>
                                </td>

                                {{-- TOMBOL AKSI --}}
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    @if($statusVal === 'completed')
                                        <button wire:click="openAction({{ $p->id }})" class="inline-flex items-center gap-1.5 text-emerald-700 bg-emerald-50 hover:bg-emerald-600 hover:text-white border border-emerald-200 px-3.5 py-1.5 rounded-lg shadow-sm text-xs font-bold transition transform hover:-translate-y-0.5 cursor-pointer" title="Lihat hasil dan review riwayat tindak lanjut">
                                            <svg width="14" height="14" class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            <span>Lihat / Review</span>
                                        </button>
                                    @elseif($statusVal === 'rejected')
                                        <button wire:click="openAction({{ $p->id }})" class="inline-flex items-center gap-1.5 text-gray-700 bg-gray-100 hover:bg-gray-200 border border-gray-300 px-3.5 py-1.5 rounded-lg shadow-sm text-xs font-bold transition cursor-pointer">
                                            <svg width="14" height="14" class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <span>Lihat Detail</span>
                                        </button>
                                    @else
                                        <button wire:click="openAction({{ $p->id }})" class="inline-flex items-center gap-1.5 text-white bg-kanwil-blue hover:bg-kanwil-blue-light px-3.5 py-1.5 rounded-lg shadow-sm text-xs font-bold transition transform hover:-translate-y-0.5 cursor-pointer">
                                            <svg width="14" height="14" class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                            <span>Tindak Lanjut</span>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-14 text-center text-gray-500">
                                    <div class="max-w-md mx-auto">
                                        <div class="h-16 w-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3 text-gray-400">
                                            @if($activeTab === 'pending')
                                                <svg class="h-8 w-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            @else
                                                <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                                </svg>
                                            @endif
                                        </div>

                                        @if($activeTab === 'pending')
                                            <h4 class="text-base font-bold text-gray-900">Semua Tugas Sudah Ditindaklanjuti!</h4>
                                            <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                                                Tidak ada permohonan yang sedang menunggu tindakan Anda saat ini. Anda dapat meninjau berkas yang telah tuntas pada tab <span class="font-bold text-emerald-700">Riwayat Selesai</span>.
                                            </p>
                                            <button wire:click="setTab('completed')" type="button" class="mt-4 inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 text-xs font-bold rounded-lg border border-emerald-200 transition">
                                                <span>Buka Tab Riwayat Selesai ({{ $completedCount }}) &rarr;</span>
                                            </button>
                                        @elseif($activeTab === 'completed')
                                            <h4 class="text-base font-bold text-gray-900">Belum Ada Riwayat Permohonan Selesai</h4>
                                            <p class="text-xs text-gray-500 mt-1">
                                                Belum ada permohonan pada tahap ini yang telah diselesaikan.
                                            </p>
                                        @else
                                            <h4 class="text-base font-bold text-gray-900">Kotak Masuk Kosong</h4>
                                            <p class="text-xs text-gray-500 mt-1">
                                                Belum ada permohonan yang tercatat sesuai kriteria pencarian Anda.
                                            </p>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- PAGINATION --}}
            <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100">
                {{ $permohonans->links() }}
            </div>
        </div>
    </div>
</div>
