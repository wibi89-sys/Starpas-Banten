@php
    use App\Models\Permohonan;
    use App\Enums\StatusPermohonan;
    $totalPermohonan = Permohonan::count();
    $pending = Permohonan::whereIn('status', [StatusPermohonan::VERIFICATION, StatusPermohonan::DISPOSITION])->count();
    $selesai = Permohonan::where('status', StatusPermohonan::COMPLETED)->count();
    $ditolak = Permohonan::where('status', StatusPermohonan::REJECTED)->count();
    $recentPermohonans = Permohonan::with(['layanan'])->latest()->take(5)->get();
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Command Center') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Welcome Banner -->
            <div class="bg-gradient-to-r from-[#0B2B5E] to-[#1E3A8A] rounded-2xl shadow-xl overflow-hidden relative">
                <!-- Decorative background elements -->
                <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-white opacity-10 blur-2xl"></div>
                <div class="absolute bottom-0 right-32 -mb-16 w-40 h-40 rounded-full bg-kanwil-gold opacity-20 blur-xl"></div>
                
                <div class="relative p-6 sm:p-8 md:p-10 text-white flex flex-col md:flex-row items-center justify-between z-10">
                    <div class="mb-6 md:mb-0 text-center md:text-left">
                        <p class="text-blue-200 font-medium tracking-wider text-xs sm:text-sm uppercase mb-1">
                            {{ now()->translatedFormat('l, d F Y') }}
                        </p>
                        <h3 class="text-xl sm:text-2xl md:text-3xl font-extrabold mb-2">
                            Selamat Bertugas, {{ Auth::user()->name }}!
                        </h3>
                        <p class="text-blue-100 max-w-xl text-sm sm:text-base">
                            Pantau permohonan masyarakat, disposisikan tugas, dan kendalikan seluruh layanan Starpas Banten dari satu layar.
                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="h-16 w-16 sm:h-20 sm:w-20 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center border border-white/30 shadow-lg">
                            <svg class="w-8 h-8 sm:w-10 sm:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card 1 -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-6 hover:shadow-lg transition duration-300 transform hover:-translate-y-1 relative overflow-hidden group">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-50 rounded-full group-hover:scale-150 transition duration-500 ease-in-out"></div>
                    <div class="relative z-10">
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <p class="text-xs sm:text-sm font-bold text-gray-500 uppercase tracking-wide">Total Permohonan</p>
                                <h4 class="text-2xl sm:text-3xl font-black text-gray-900 mt-1">{{ number_format($totalPermohonan) }}</h4>
                            </div>
                            <div class="h-10 w-10 sm:h-12 sm:w-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                        </div>
                        <div class="flex items-center text-xs sm:text-sm text-gray-400">
                            Total seluruh permohonan masuk
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-6 hover:shadow-lg transition duration-300 transform hover:-translate-y-1 relative overflow-hidden group">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-yellow-50 rounded-full group-hover:scale-150 transition duration-500 ease-in-out"></div>
                    <div class="relative z-10">
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <p class="text-xs sm:text-sm font-bold text-gray-500 uppercase tracking-wide">Menunggu (Pending)</p>
                                <h4 class="text-2xl sm:text-3xl font-black text-kanwil-gold mt-1">{{ number_format($pending) }}</h4>
                            </div>
                            <div class="h-10 w-10 sm:h-12 sm:w-12 rounded-xl bg-yellow-100 text-yellow-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                        <div class="flex items-center text-xs sm:text-sm text-gray-400">
                            Menunggu tindak lanjut
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-6 hover:shadow-lg transition duration-300 transform hover:-translate-y-1 relative overflow-hidden group">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-green-50 rounded-full group-hover:scale-150 transition duration-500 ease-in-out"></div>
                    <div class="relative z-10">
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <p class="text-xs sm:text-sm font-bold text-gray-500 uppercase tracking-wide">Selesai / Disetujui</p>
                                <h4 class="text-2xl sm:text-3xl font-black text-gray-900 mt-1">{{ number_format($selesai) }}</h4>
                            </div>
                            <div class="h-10 w-10 sm:h-12 sm:w-12 rounded-xl bg-green-100 text-green-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5 mt-4">
                            <div class="bg-green-500 h-2.5 rounded-full" style="width: {{ ($totalPermohonan > 0 ? round(($selesai / $totalPermohonan) * 100) : 0) . '%' }}"></div>
                        </div>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-6 hover:shadow-lg transition duration-300 transform hover:-translate-y-1 relative overflow-hidden group">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-red-50 rounded-full group-hover:scale-150 transition duration-500 ease-in-out"></div>
                    <div class="relative z-10">
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <p class="text-xs sm:text-sm font-bold text-gray-500 uppercase tracking-wide">Ditolak / Revisi</p>
                                <h4 class="text-2xl sm:text-3xl font-black text-gray-900 mt-1">{{ number_format($ditolak) }}</h4>
                            </div>
                            <div class="h-10 w-10 sm:h-12 sm:w-12 rounded-xl bg-red-100 text-red-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                        <div class="flex items-center text-xs sm:text-sm text-gray-400">
                            Butuh perhatian khusus
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
                <!-- Recent Activities Table -->
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-100 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
                        <h3 class="text-base sm:text-lg font-bold text-kanwil-blue">Aktivitas Permohonan Terkini</h3>
                        <a href="{{ route('admin.inbox') }}" wire:navigate class="text-sm font-semibold text-kanwil-gold hover:text-yellow-600 transition self-start sm:self-auto">Lihat Semua &rarr;</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50/50">
                                <tr>
                                    <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Pemohon</th>
                                    <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider hidden sm:table-cell">Layanan</th>
                                    <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-4 sm:px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Waktu</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($recentPermohonans as $p)
                                    @php
                                        $namaPemohon = $p->nama_pemohon;
                                        $initial = strtoupper(substr($namaPemohon, 0, 1));
                                        $statusLabel = $p->status->label();
                                        $statusClass = match($p->status) {
                                            \App\Enums\StatusPermohonan::COMPLETED => 'bg-green-100 text-green-800 border-green-200',
                                            \App\Enums\StatusPermohonan::REJECTED  => 'bg-red-100 text-red-800 border-red-200',
                                            \App\Enums\StatusPermohonan::REVISION  => 'bg-orange-100 text-orange-800 border-orange-200',
                                            \App\Enums\StatusPermohonan::PROCESSING, \App\Enums\StatusPermohonan::REVIEW => 'bg-blue-100 text-kanwil-blue border-blue-200',
                                            default => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                        };
                                    @endphp
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="h-9 w-9 sm:h-10 sm:w-10 rounded-full bg-blue-100 flex items-center justify-center text-kanwil-blue font-bold flex-shrink-0 text-sm">{{ $initial }}</div>
                                                <div class="ml-3 sm:ml-4 min-w-0">
                                                    <div class="text-sm font-bold text-gray-900 truncate">{{ $namaPemohon }}</div>
                                                    <div class="text-xs sm:text-sm text-gray-500 truncate">{{ $p->tracking_number }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                                            <div class="text-sm text-gray-900 font-medium">{{ $p->layanan->nama_layanan ?? '-' }}</div>
                                        </td>
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                            <span class="px-2.5 sm:px-3 py-0.5 sm:py-1 inline-flex text-xs leading-5 font-bold rounded-full border {{ $statusClass }}">
                                                {{ $statusLabel }}
                                            </span>
                                        </td>
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-right text-xs sm:text-sm text-gray-500">
                                            {{ $p->created_at->diffForHumans() }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                                            <svg class="mx-auto h-10 w-10 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            <p class="text-sm font-medium">Belum ada permohonan masuk</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Quick Actions / Menu Cepat -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-6">
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-4 sm:mb-6">Akses Cepat</h3>
                    
                    <div class="space-y-3 sm:space-y-4">
                        <a href="{{ route('admin.inbox') }}" wire:navigate class="group flex items-center p-3 sm:p-4 bg-gray-50 border border-gray-100 rounded-xl hover:bg-kanwil-blue hover:border-kanwil-blue transition duration-200">
                            <div class="h-9 w-9 sm:h-10 sm:w-10 rounded-full bg-white text-kanwil-blue flex items-center justify-center shadow-sm group-hover:scale-110 transition duration-200 flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                            </div>
                            <div class="ml-3 sm:ml-4 min-w-0">
                                <p class="text-sm font-bold text-gray-900 group-hover:text-white transition truncate">Cek Kotak Masuk</p>
                                <p class="text-xs text-gray-500 group-hover:text-blue-100 transition truncate">Lihat permohonan baru</p>
                            </div>
                        </a>

                        <a href="{{ route('profile') }}" wire:navigate class="group flex items-center p-3 sm:p-4 bg-gray-50 border border-gray-100 rounded-xl hover:bg-kanwil-blue hover:border-kanwil-blue transition duration-200">
                            <div class="h-9 w-9 sm:h-10 sm:w-10 rounded-full bg-white text-kanwil-blue flex items-center justify-center shadow-sm group-hover:scale-110 transition duration-200 flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <div class="ml-3 sm:ml-4 min-w-0">
                                <p class="text-sm font-bold text-gray-900 group-hover:text-white transition truncate">Profil Saya</p>
                                <p class="text-xs text-gray-500 group-hover:text-blue-100 transition truncate">Ubah sandi & data diri</p>
                            </div>
                        </a>

                        <a href="{{ url('/') }}" wire:navigate class="group flex items-center p-3 sm:p-4 bg-gray-50 border border-gray-100 rounded-xl hover:bg-kanwil-gold hover:border-kanwil-gold transition duration-200">
                            <div class="h-9 w-9 sm:h-10 sm:w-10 rounded-full bg-white text-kanwil-gold flex items-center justify-center shadow-sm group-hover:scale-110 transition duration-200 flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            </div>
                            <div class="ml-3 sm:ml-4 min-w-0">
                                <p class="text-sm font-bold text-gray-900 group-hover:text-white transition truncate">Lihat Portal Publik</p>
                                <p class="text-xs text-gray-500 group-hover:text-yellow-100 transition truncate">Kembali ke halaman depan</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>
