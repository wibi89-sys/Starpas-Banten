<div>
    <x-slot name="header">
        Pengaturan Aplikasi
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        @if (session()->has('message'))
            <div class="p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg shadow-sm">
                {{ session('message') }}
            </div>
        @endif

        {{-- ===== TAB NAVIGATION ===== --}}
        <div class="border-b border-gray-200 mb-6 bg-white shadow-sm rounded-xl p-1.5 flex flex-wrap gap-2">
            <button wire:click="setTab('general')" class="flex-1 text-center px-4 py-2.5 rounded-lg text-sm font-bold transition flex items-center justify-center gap-2 {{ $tab === 'general' ? 'bg-kanwil-blue text-white shadow' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span>Aplikasi & WA</span>
            </button>
            <button wire:click="setTab('upt')" class="flex-1 text-center px-4 py-2.5 rounded-lg text-sm font-bold transition flex items-center justify-center gap-2 {{ $tab === 'upt' ? 'bg-kanwil-blue text-white shadow' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                <span>Kelola UPT</span>
            </button>
            <button wire:click="setTab('roles')" class="flex-1 text-center px-4 py-2.5 rounded-lg text-sm font-bold transition flex items-center justify-center gap-2 {{ $tab === 'roles' ? 'bg-kanwil-blue text-white shadow' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 8a6 6 0 01-7.743 5.743L11 21H9v-2H7v-2H5a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 15z"/></svg>
                <span>Kelola Level User</span>
            </button>
            <button wire:click="setTab('bidang')" class="flex-1 text-center px-4 py-2.5 rounded-lg text-sm font-bold transition flex items-center justify-center gap-2 {{ $tab === 'bidang' ? 'bg-kanwil-blue text-white shadow' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                <span>Kelola Tim</span>
            </button>
        </div>

        {{-- ===== TAB 1: GENERAL APP SETTING & WA ===== --}}
        @if ($tab === 'general')
            <div class="bg-white shadow rounded-lg p-6">
                <form wire:submit.prevent="save">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Instansi</label>
                            <input type="text" wire:model="nama_instansi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-kanwil-blue-light focus:ring-kanwil-blue-light sm:text-sm">
                            @error('nama_instansi') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Singkatan</label>
                            <input type="text" wire:model="singkatan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-kanwil-blue-light focus:ring-kanwil-blue-light sm:text-sm">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Deskripsi Singkat</label>
                            <textarea wire:model="deskripsi" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-kanwil-blue-light focus:ring-kanwil-blue-light sm:text-sm"></textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                            <textarea wire:model="alamat" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-kanwil-blue-light focus:ring-kanwil-blue-light sm:text-sm"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kontak (WA/Telp)</label>
                            <input type="text" wire:model="kontak" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-kanwil-blue-light focus:ring-kanwil-blue-light sm:text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email Utama</label>
                            <input type="email" wire:model="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-kanwil-blue-light focus:ring-kanwil-blue-light sm:text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Warna Tema (Hex)</label>
                            <input type="text" wire:model="warna_tema" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-kanwil-blue-light focus:ring-kanwil-blue-light sm:text-sm">
                            <p class="text-xs text-gray-500 mt-1">Gunakan kode hex, contoh: #105132</p>
                        </div>

                        <div class="md:col-span-2 border-t border-gray-150 pt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Logo Instansi</label>
                            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                                <div class="h-20 w-20 rounded-lg bg-gray-50 border border-gray-200 flex items-center justify-center overflow-hidden shadow-inner p-2">
                                    @if ($logo)
                                        <img src="{{ $logo->temporaryUrl() }}" class="h-full w-full object-contain">
                                    @elseif ($existingLogo)
                                        <img src="{{ asset('storage/' . $existingLogo) }}" class="h-full w-full object-contain">
                                    @else
                                        <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400">
                                            <circle cx="50" cy="50" r="46" stroke="#D97706" stroke-width="4" fill="#0B2B5E" />
                                            <circle cx="50" cy="50" r="42" stroke="#F59E0B" stroke-width="1.5" />
                                            <circle cx="50" cy="50" r="28" stroke="#D97706" stroke-width="2" />
                                            <path d="M50 24 L52 29 L48 29 Z" fill="#F59E0B" />
                                            <path d="M50 28 C47 28 45 31 45 34 C45 38 48 40 50 42 C52 40 55 38 55 34 C55 31 53 28 50 28 Z" fill="#F59E0B" />
                                            <path d="M44 32 C38 31 30 35 24 42 C29 42 34 39 40 36 C42 35 43 34 44 32 Z" fill="#FBBF24" />
                                            <path d="M43 35 C36 35 29 40 25 47 C30 46 36 43 41 39 C42 38 42 37 43 35 Z" fill="#FBBF24" />
                                            <path d="M43 38 C37 40 31 45 28 53 C32 50 37 47 41 43 C42 42 42 41 43 38 Z" fill="#FBBF24" />
                                            <path d="M56 32 C62 31 70 35 76 42 C71 42 66 39 60 36 C58 35 57 34 56 32 Z" fill="#FBBF24" />
                                            <path d="M57 35 C64 35 71 40 75 47 C70 46 64 43 59 39 C58 38 58 37 57 35 Z" fill="#FBBF24" />
                                            <path d="M57 38 C63 40 69 45 72 53 C68 50 63 47 59 43 C58 42 58 41 57 38 Z" fill="#FBBF24" />
                                            <path d="M47 38 H53 V44 C53 47 50 49 50 49 C50 49 47 47 47 44 Z" fill="#B91C1C" stroke="#FBBF24" stroke-width="1" />
                                            <polygon points="50,40 51,42 53,42 51.5,43 52,45 50,44 48,45 48.5,43 47,42 49,42" fill="#FBBF24" />
                                            <path d="M47 48 L46 64 C46 66 48 68 50 68 C52 68 54 66 54 64 L53 48 Z" fill="#FBBF24" />
                                            <path d="M36 66 C42 68 48 68 50 68 C52 68 58 68 64 66 L66 69 C58 71 52 71 50 71 C48 71 42 71 34 69 Z" fill="#F1F5F9" stroke="#D97706" stroke-width="0.5" />
                                        </svg>
                                    @endif
                                </div>
                                <div class="flex-1 space-y-2">
                                    <div class="flex items-center gap-2">
                                        <input type="file" wire:model="logo" id="logo-picker" class="hidden" accept="image/*">
                                        <label for="logo-picker" class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-kanwil-blue-light">
                                            Pilih File Logo
                                        </label>
                                        @if ($existingLogo)
                                            <button type="button" wire:click="deleteLogo" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-red-700 bg-red-50 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                Hapus Logo Custom
                                            </button>
                                        @endif
                                    </div>
                                    <p class="text-xs text-gray-500">Format: PNG, JPG, JPEG, SVG. Maksimal 2MB. Jika kosong, logo default Kemenimipas akan digunakan.</p>
                                    @error('logo') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ===== SECTION: INTEGRASI WHATSAPP FONNTE ===== --}}
                    <div class="mt-8 border-t border-gray-200 pt-6">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="h-10 w-10 rounded-xl bg-green-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-gray-900">Integrasi WhatsApp (Fonnte)</h3>
                                <p class="text-xs text-gray-500">Notifikasi otomatis ke pemohon saat status berubah</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Toggle aktif --}}
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-200">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Aktifkan Notifikasi WA</p>
                                    <p class="text-xs text-gray-500 mt-0.5">Kirim WA otomatis saat ada permohonan baru atau update status</p>
                                </div>
                                <button type="button" wire:click="$toggle('whatsapp_notif_enabled')"
                                    class="relative inline-flex h-7 w-12 items-center rounded-full transition-colors duration-200 focus:outline-none {{ $whatsapp_notif_enabled ? 'bg-green-500' : 'bg-gray-300' }}">
                                    <span class="inline-block h-5 w-5 transform rounded-full bg-white shadow transition-transform duration-200 {{ $whatsapp_notif_enabled ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                </button>
                            </div>

                            {{-- Token input --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Token API Fonnte</label>
                                <div class="relative" x-data="{ showToken: false }">
                                    <input wire:model="fonnte_token"
                                        :type="showToken ? 'text' : 'password'"
                                        class="block w-full rounded-lg border-gray-300 shadow-sm text-sm pr-10 focus:border-green-500 focus:ring-green-500"
                                        placeholder="Isi token dari dashboard Fonnte">
                                    <button type="button" @click="showToken = !showToken"
                                        class="absolute inset-y-0 right-0 px-3 text-gray-400 hover:text-gray-600">
                                        <svg x-show="!showToken" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <svg x-show="showToken" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                    </button>
                                </div>
                                <p class="text-xs text-gray-400 mt-1">Dapatkan token dari <a href="https://fonnte.com" target="_blank" class="text-green-600 hover:underline">fonnte.com</a></p>
                                @error('fonnte_token') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        {{-- Test WA --}}
                        <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-xl">
                            <p class="text-sm font-semibold text-green-800 mb-3">🧪 Uji Kirim Pesan WhatsApp</p>
                            <div class="flex gap-3">
                                <input wire:model="test_wa_target" type="text"
                                    placeholder="Nomor HP tujuan (contoh: 081234567890)"
                                    class="flex-1 rounded-lg border-green-300 text-sm focus:border-green-500 focus:ring-green-500">
                                <button type="button" wire:click="testWa" wire:loading.attr="disabled"
                                    class="px-4 py-2 text-sm font-bold text-white bg-green-600 hover:bg-green-700 rounded-lg shadow transition disabled:opacity-50 whitespace-nowrap flex items-center gap-2">
                                    <svg wire:loading wire:target="testWa" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                                    <span wire:loading.remove wire:target="testWa">Kirim Test WA</span>
                                    <span wire:loading wire:target="testWa">Mengirim...</span>
                                </button>
                            </div>
                            @error('test_wa_target') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                            <p class="text-xs text-green-600 mt-2">⚠️ Simpan token terlebih dahulu atau isi token di atas sebelum mengirim test.</p>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-kanwil-blue hover:bg-kanwil-blue-light focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-kanwil-blue-light">
                            <svg wire:loading wire:target="save" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Simpan Pengaturan
                        </button>
                    </div>
                </form>
            </div>
        @endif

        {{-- ===== TAB 2: KELOLA UPT ===== --}}
        @if ($tab === 'upt')
            <div class="space-y-6">
                @if (session()->has('message_upt'))
                    <div class="p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg shadow-sm">
                        {{ session('message_upt') }}
                    </div>
                @endif

                <div class="bg-white shadow rounded-lg p-6 border-t-4 border-kanwil-gold">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Pengelolaan UPT</h2>
                            <p class="text-sm text-gray-500 mt-1">Kelola daftar Unit Pelaksana Teknis tujuan disposisi permohonan layanan.</p>
                        </div>
                        <button wire:click="openCreateUpt"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-kanwil-gold hover:bg-yellow-600 text-white text-sm font-bold rounded-lg shadow transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Tambah UPT
                        </button>
                    </div>

                    {{-- Search --}}
                    <div class="mt-5">
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <input wire:model.live.debounce.300ms="searchUpt" type="text"
                                placeholder="Cari nama, jenis, atau alamat UPT..."
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-kanwil-gold focus:border-kanwil-gold">
                        </div>
                    </div>
                </div>

                {{-- UPT Table --}}
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama UPT</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Jenis UPT</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Alamat</th>
                                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Status Aktif</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($upts as $upt)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-bold text-gray-900 block">{{ $upt->nama_upt }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold border bg-blue-100 text-kanwil-blue border-blue-200 shadow-sm">
                                                {{ $upt->jenis_upt }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate" title="{{ $upt->alamat }}">
                                            {{ $upt->alamat ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <button type="button" wire:click="toggleUptActive({{ $upt->id }})"
                                                class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200 focus:outline-none {{ $upt->is_active ? 'bg-green-500' : 'bg-gray-300' }}">
                                                <span class="inline-block h-4 w-4 transform rounded-full bg-white shadow transition-transform duration-200 {{ $upt->is_active ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                            </button>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                            <div class="flex items-center justify-end gap-2">
                                                <button wire:click="openEditUpt({{ $upt->id }})" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                </button>
                                                <button wire:click="confirmDeleteUpt({{ $upt->id }})" class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                            <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                            <p class="font-medium">Tidak ada data UPT ditemukan</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        {{-- ===== TAB 3: KELOLA LEVEL USER ===== --}}
        @if ($tab === 'roles')
            <div class="space-y-6">
                @if (session()->has('message_role'))
                    <div class="p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg shadow-sm">
                        {{ session('message_role') }}
                    </div>
                @endif
                @if (session()->has('error_role'))
                    <div class="p-4 bg-red-50 border-l-4 border-red-500 text-red-800 rounded-r-lg shadow-sm flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ session('error_role') }}
                    </div>
                @endif

                <div class="bg-white shadow rounded-lg p-6 border-t-4 border-kanwil-gold">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Level & Hak Akses User (Role)</h2>
                            <p class="text-sm text-gray-500 mt-1">Mengelola tingkat level dan wewenang pengguna dalam sistem.</p>
                        </div>
                        <button wire:click="openCreateRole"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-kanwil-gold hover:bg-yellow-600 text-white text-sm font-bold rounded-lg shadow transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Tambah Level
                        </button>
                    </div>

                    {{-- Search --}}
                    <div class="mt-5">
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <input wire:model.live.debounce.300ms="searchRole" type="text"
                                placeholder="Cari level user..."
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-kanwil-gold focus:border-kanwil-gold">
                        </div>
                    </div>
                </div>

                {{-- Table Roles --}}
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Level (Role)</th>
                                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Jumlah Pengguna</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($roles as $role)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-bold text-gray-900">{{ $role->name }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-semibold text-gray-700">
                                            <span class="inline-flex items-center justify-center px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-kanwil-blue-light border border-blue-200 shadow-sm">
                                                {{ $role->user_count }} Pengguna
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                            <div class="flex items-center justify-end gap-2">
                                                <button wire:click="openEditRole({{ $role->id }})" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                </button>
                                                <button wire:click="confirmDeleteRole({{ $role->id }})" class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 text-center text-gray-400">
                                            <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                            <p class="font-medium">Tidak ada level user ditemukan</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        {{-- ===== TAB 4: KELOLA TIM ===== --}}
        @if ($tab === 'bidang')
            <div class="space-y-6">
                @if (session()->has('message_bidang'))
                    <div class="p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg shadow-sm">
                        {{ session('message_bidang') }}
                    </div>
                @endif

                <div class="bg-white shadow rounded-lg p-6 border-t-4 border-kanwil-gold">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Pengelolaan Tim</h2>
                            <p class="text-sm text-gray-500 mt-1">Kelola daftar Tim Kanwil Ditjenpas Banten.</p>
                        </div>
                        <button wire:click="openCreateBidang"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-kanwil-gold hover:bg-yellow-600 text-white text-sm font-bold rounded-lg shadow transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Tambah Tim
                        </button>
                    </div>

                    {{-- Search --}}
                    <div class="mt-5">
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <input wire:model.live.debounce.300ms="searchBidang" type="text"
                                placeholder="Cari nama atau deskripsi tim..."
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-kanwil-gold focus:border-kanwil-gold">
                        </div>
                    </div>
                </div>

                {{-- Tim Table --}}
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Tim</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Deskripsi</th>
                                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Status Aktif</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($bidangs as $bidang)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-bold text-gray-900 block">{{ $bidang->nama_bidang }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate" title="{{ $bidang->deskripsi }}">
                                            {{ $bidang->deskripsi ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <button type="button" wire:click="toggleBidangActive({{ $bidang->id }})"
                                                class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200 focus:outline-none {{ $bidang->is_active ? 'bg-green-500' : 'bg-gray-300' }}">
                                                <span class="inline-block h-4 w-4 transform rounded-full bg-white shadow transition-transform duration-200 {{ $bidang->is_active ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                            </button>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                            <div class="flex items-center justify-end gap-2">
                                                <button wire:click="openEditBidang({{ $bidang->id }})" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                </button>
                                                <button wire:click="confirmDeleteBidang({{ $bidang->id }})" class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                                            <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                            <p class="font-medium">Tidak ada data tim ditemukan</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- ==========================================
         MODALS AREA
         ========================================== --}}

    {{-- ===== MODAL CRUD UPT ===== --}}
    @if($showUptModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" wire:click="$set('showUptModal', false)"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg z-10 overflow-hidden flex flex-col max-h-[90vh]">
                <div class="bg-gradient-to-r from-kanwil-gold to-yellow-500 px-6 py-5 text-white flex-shrink-0">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold">
                            {{ $editingUptId ? 'Edit UPT' : 'Tambah UPT Baru' }}
                        </h3>
                        <button wire:click="$set('showUptModal', false)" class="p-1 rounded-full hover:bg-white/20 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>

                <form wire:submit.prevent="saveUpt" class="flex flex-col flex-1 overflow-hidden">
                    <div class="p-6 space-y-5 overflow-y-auto flex-1">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama UPT *</label>
                            <input wire:model="upt_nama" type="text"
                                class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-kanwil-gold focus:border-kanwil-gold"
                                placeholder="Contoh: Lapas Kelas IIA Serang">
                            @error('upt_nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis UPT *</label>
                            <select wire:model="upt_jenis"
                                class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-kanwil-gold focus:border-kanwil-gold">
                                <option value="">— Pilih Jenis UPT —</option>
                                <option value="Lapas">Lapas</option>
                                <option value="Rutan">Rutan</option>
                                <option value="Bapas">Bapas</option>
                                <option value="Rupbasan">Rupbasan</option>
                                <option value="Kanim">Kanim</option>
                                <option value="Kanwil">Kanwil</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            @error('upt_jenis') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat UPT</label>
                            <textarea wire:model="upt_alamat" rows="3"
                                class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-kanwil-gold focus:border-kanwil-gold"
                                placeholder="Tuliskan alamat lengkap UPT..."></textarea>
                            @error('upt_alamat') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-medium text-gray-700">Status Aktif</span>
                            <button type="button" wire:click="$toggle('upt_is_active')"
                                class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200 focus:outline-none {{ $upt_is_active ? 'bg-green-500' : 'bg-gray-300' }}">
                                <span class="inline-block h-4 w-4 transform rounded-full bg-white shadow transition-transform duration-200 {{ $upt_is_active ? 'translate-x-6' : 'translate-x-1' }}"></span>
                            </button>
                        </div>
                    </div>

                    <div class="px-6 py-4 bg-gray-50 flex justify-end gap-3 border-t border-gray-100 rounded-b-2xl flex-shrink-0">
                        <button type="button" wire:click="$set('showUptModal', false)"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-5 py-2 text-sm font-bold text-white bg-kanwil-gold hover:bg-yellow-600 rounded-lg shadow transition">
                            Simpan UPT
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- ===== MODAL CONFIRM DELETE UPT ===== --}}
    @if($showDeleteUptModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" wire:click="$set('showDeleteUptModal', false)"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm z-10 p-6 text-center">
                <div class="h-16 w-16 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M12 3a9 9 0 100 18A9 9 0 0012 3z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Hapus UPT?</h3>
                <p class="text-sm text-gray-600 mb-6">
                    Anda akan menghapus data UPT <span class="font-bold text-red-600">{{ $deletingUptName }}</span> secara permanen. Tindakan ini tidak dapat dibatalkan.
                </p>
                <div class="flex gap-3 justify-center">
                    <button wire:click="$set('showDeleteUptModal', false)"
                        class="px-5 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                        Batal
                    </button>
                    <button wire:click="deleteUpt"
                        class="px-5 py-2 text-sm font-bold text-white bg-red-600 hover:bg-red-700 rounded-lg shadow transition">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- ===== MODAL CRUD ROLE ===== --}}
    @if($showRoleModal)
         <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
             <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" wire:click="$set('showRoleModal', false)"></div>
             <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md z-10 overflow-hidden flex flex-col max-h-[90vh]">
                 <div class="bg-gradient-to-r from-kanwil-gold to-yellow-500 px-6 py-5 text-white flex-shrink-0">
                     <div class="flex items-center justify-between">
                         <h3 class="text-lg font-bold">
                             {{ $editingRoleId ? 'Edit Level User' : 'Tambah Level User Baru' }}
                         </h3>
                         <button wire:click="$set('showRoleModal', false)" class="p-1 rounded-full hover:bg-white/20 transition">
                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                         </button>
                     </div>
                 </div>

                 <form wire:submit.prevent="saveRole" class="flex flex-col flex-1 overflow-hidden">
                     <div class="p-6 space-y-5 overflow-y-auto flex-1">
                         <div>
                             <label class="block text-sm font-medium text-gray-700 mb-1">Nama Level (Role) *</label>
                             <input wire:model="role_name" type="text"
                                 class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-kanwil-gold focus:border-kanwil-gold"
                                 placeholder="Contoh: Admin Pelayanan">
                             @error('role_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                         </div>
                     </div>

                     <div class="px-6 py-4 bg-gray-50 flex justify-end gap-3 border-t border-gray-100 rounded-b-2xl flex-shrink-0">
                         <button type="button" wire:click="$set('showRoleModal', false)"
                             class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                             Batal
                         </button>
                         <button type="submit"
                             class="px-5 py-2 text-sm font-bold text-white bg-kanwil-gold hover:bg-yellow-600 rounded-lg shadow transition">
                             Simpan Level
                         </button>
                     </div>
                 </form>
             </div>
         </div>
     @endif

    {{-- ===== MODAL CONFIRM DELETE ROLE ===== --}}
    @if($showDeleteRoleModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" wire:click="$set('showDeleteRoleModal', false)"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm z-10 p-6 text-center">
                <div class="h-16 w-16 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M12 3a9 9 0 100 18A9 9 0 0012 3z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Hapus Level User?</h3>
                <p class="text-sm text-gray-600 mb-6">
                    Anda akan menghapus level <span class="font-bold text-red-600">{{ $deletingRoleName }}</span> secara permanen. Tindakan ini tidak dapat dibatalkan.
                </p>
                <div class="flex gap-3 justify-center">
                    <button wire:click="$set('showDeleteRoleModal', false)"
                        class="px-5 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                        Batal
                    </button>
                    <button wire:click="deleteRole"
                        class="px-5 py-2 text-sm font-bold text-white bg-red-600 hover:bg-red-700 rounded-lg shadow transition">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- ===== MODAL CRUD TIM ===== --}}
    @if($showBidangModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" wire:click="$set('showBidangModal', false)"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg z-10 overflow-hidden flex flex-col max-h-[90vh]">
                <div class="bg-gradient-to-r from-kanwil-gold to-yellow-500 px-6 py-5 text-white flex-shrink-0">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold">
                            {{ $editingBidangId ? 'Edit Tim' : 'Tambah Tim Baru' }}
                        </h3>
                        <button wire:click="$set('showBidangModal', false)" class="p-1 rounded-full hover:bg-white/20 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>

                <form wire:submit.prevent="saveBidang" class="flex flex-col flex-1 overflow-hidden">
                    <div class="p-6 space-y-5 overflow-y-auto flex-1">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Tim *</label>
                            <input wire:model="bidang_nama" type="text"
                                class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-kanwil-gold focus:border-kanwil-gold"
                                placeholder="Contoh: Tim Pelayanan Tahanan">
                            @error('bidang_nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                            <textarea wire:model="bidang_deskripsi" rows="3"
                                class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-kanwil-gold focus:border-kanwil-gold"
                                placeholder="Tuliskan deskripsi tim..."></textarea>
                            @error('bidang_deskripsi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-medium text-gray-700">Status Aktif</span>
                            <button type="button" wire:click="$toggle('bidang_is_active')"
                                class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200 focus:outline-none {{ $bidang_is_active ? 'bg-green-500' : 'bg-gray-300' }}">
                                <span class="inline-block h-4 w-4 transform rounded-full bg-white shadow transition-transform duration-200 {{ $bidang_is_active ? 'translate-x-6' : 'translate-x-1' }}"></span>
                            </button>
                        </div>
                    </div>

                    <div class="px-6 py-4 bg-gray-50 flex justify-end gap-3 border-t border-gray-100 rounded-b-2xl flex-shrink-0">
                        <button type="button" wire:click="$set('showBidangModal', false)"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-5 py-2 text-sm font-bold text-white bg-kanwil-gold hover:bg-yellow-600 rounded-lg shadow transition">
                            Simpan Tim
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- ===== MODAL CONFIRM DELETE TIM ===== --}}
    @if($showDeleteBidangModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" wire:click="$set('showDeleteBidangModal', false)"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm z-10 p-6 text-center">
                <div class="h-16 w-16 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M12 3a9 9 0 100 18A9 9 0 0012 3z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Hapus Tim?</h3>
                <p class="text-sm text-gray-600 mb-6">
                    Anda akan menghapus data tim <span class="font-bold text-red-600">{{ $deletingBidangName }}</span> secara permanen. Tindakan ini tidak dapat dibatalkan.
                </p>
                <div class="flex gap-3 justify-center">
                    <button wire:click="$set('showDeleteBidangModal', false)"
                        class="px-5 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                        Batal
                    </button>
                    <button wire:click="deleteBidang"
                        class="px-5 py-2 text-sm font-bold text-white bg-red-600 hover:bg-red-700 rounded-lg shadow transition">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>


