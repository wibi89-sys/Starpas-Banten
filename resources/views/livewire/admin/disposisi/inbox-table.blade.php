<div>
    <x-slot name="header">
        Inbox Disposisi & Permohonan
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6">
        <div class="bg-white shadow rounded-lg p-6 border-t-4 border-kanwil-gold">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                <h3 class="text-xl font-bold text-kanwil-blue">Daftar Kotak Masuk</h3>
                <div class="w-full sm:w-72">
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari No. Resi / Pemohon..." class="block w-full rounded-md border-gray-300 shadow-sm focus:border-kanwil-gold-light focus:ring-kanwil-gold-light sm:text-sm transition">
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-blue-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-kanwil-blue uppercase tracking-wider">No. Resi</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-kanwil-blue uppercase tracking-wider">Pemohon</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-kanwil-blue uppercase tracking-wider">Layanan</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-kanwil-blue uppercase tracking-wider">Tanggal</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-kanwil-blue uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-kanwil-blue uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($permohonans as $p)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">{{ $p->tracking_number }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $p->nama_pemohon }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $p->layanan->nama_layanan ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $p->tanggal_pengajuan?->format('d M Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-blue-100 text-kanwil-blue border border-blue-200">
                                        {{ $p->status->label() }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button wire:click="openAction({{ $p->id }})" class="text-white bg-kanwil-blue hover:bg-kanwil-blue-light px-4 py-1.5 rounded-md shadow-sm text-xs font-medium transition transform hover:-translate-y-0.5">
                                        Tindak Lanjut
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Kotak Masuk Kosong</h3>
                                    <p class="mt-1 text-sm text-gray-500">Belum ada permohonan yang perlu Anda tindak lanjuti saat ini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4 border-t border-gray-100 pt-4">
                {{ $permohonans->links() }}
            </div>
        </div>
    </div>
</div>
