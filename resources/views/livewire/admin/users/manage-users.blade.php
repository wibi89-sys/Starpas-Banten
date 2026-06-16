<div>
    <x-slot name="header">
        Kelola Pengguna Sistem
    </x-slot>

    <div class="max-w-6xl mx-auto space-y-6">

        {{-- Flash Messages --}}
        @if (session()->has('success'))
            <div class="p-4 bg-green-50 border-l-4 border-green-500 text-green-800 rounded-r-lg shadow-sm flex items-center gap-2">
                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="p-4 bg-red-50 border-l-4 border-red-500 text-red-800 rounded-r-lg shadow-sm flex items-center gap-2">
                <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('error') }}
            </div>
        @endif

        {{-- Header Card --}}
        <div class="bg-white shadow rounded-xl p-6 border-t-4 border-kanwil-gold">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Daftar Pengguna</h2>
                    <p class="text-sm text-gray-500 mt-1">Kelola akun dan hak akses semua pengguna sistem.</p>
                </div>
                <button wire:click="openCreate" id="btn-tambah-user"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-kanwil-gold hover:bg-yellow-600 text-white text-sm font-bold rounded-lg shadow transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Pengguna
                </button>
            </div>

            {{-- Search --}}
            <div class="mt-5">
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input wire:model.live.debounce.300ms="search" type="text" id="search-user"
                        placeholder="Cari nama atau email..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-kanwil-gold focus:border-kanwil-gold">
                </div>
            </div>
        </div>

        {{-- Users Table --}}
        <div class="bg-white shadow rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Pengguna</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Bergabung</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="h-9 w-9 rounded-full bg-kanwil-gold/10 border border-kanwil-gold/30 flex items-center justify-center font-bold text-kanwil-gold text-sm flex-shrink-0">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-900">{{ $user->name }}</p>
                                            @if($user->id === auth()->id())
                                                <span class="text-xs text-kanwil-gold font-medium">(Anda)</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $user->email }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1.5">
                                        @php
                                            $userRoles = $user->getRoleNames();
                                        @endphp
                                        @forelse($userRoles as $roleName)
                                            @php
                                                $roleColor = match($roleName) {
                                                    'Super Admin'       => 'bg-purple-100 text-purple-800 border-purple-200',
                                                    'Admin Pelayanan'   => 'bg-blue-100 text-blue-800 border-blue-200',
                                                    'Pejabat Disposisi' => 'bg-amber-100 text-amber-800 border-amber-200',
                                                    'Admin Bidang'      => 'bg-green-100 text-green-800 border-green-200',
                                                    'Operator UPT'      => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                                                    'Reviewer'          => 'bg-teal-100 text-teal-800 border-teal-200',
                                                    'Pimpinan'          => 'bg-rose-100 text-rose-800 border-rose-200',
                                                    'Publik'            => 'bg-gray-100 text-gray-800 border-gray-200',
                                                    default             => 'bg-gray-50 text-gray-600 border-gray-200',
                                                };
                                            @endphp
                                            <div class="inline-flex flex-col gap-0.5">
                                                <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $roleColor }}">
                                                    {{ $roleName }}
                                                </span>
                                                @if($roleName === 'Admin Bidang' && $user->bidang)
                                                    <span class="text-[10px] text-gray-500 font-medium pl-1">
                                                        📍 {{ $user->bidang->nama_bidang }}
                                                    </span>
                                                @endif
                                                @if($roleName === 'Operator UPT' && $user->upt)
                                                    <span class="text-[10px] text-gray-500 font-medium pl-1">
                                                        🏢 {{ $user->upt->nama_upt }}
                                                    </span>
                                                @endif
                                            </div>
                                        @empty
                                            <span class="text-xs text-gray-400 italic">Tidak ada role</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->created_at->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button wire:click="openEdit({{ $user->id }})"
                                            class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </button>
                                        @if($user->id !== auth()->id())
                                            <button wire:click="confirmDelete({{ $user->id }})"
                                                class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                    <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <p class="font-medium">Tidak ada pengguna ditemukan</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($users->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- ===== MODAL CREATE / EDIT ===== --}}
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4"
             x-data>
            <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" wire:click="$set('showModal', false)"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg z-10 overflow-hidden flex flex-col max-h-[90vh]">
                {{-- Modal Header --}}
                <div class="bg-gradient-to-r from-kanwil-gold to-yellow-500 px-6 py-5 text-white flex-shrink-0">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold">
                            {{ $isEditing ? 'Edit Pengguna' : 'Tambah Pengguna Baru' }}
                        </h3>
                        <button wire:click="$set('showModal', false)" class="p-1 rounded-full hover:bg-white/20 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>

                {{-- Modal Body & Form --}}
                <form wire:submit="save" class="flex flex-col flex-1 overflow-hidden">
                    <div class="p-6 space-y-5 overflow-y-auto flex-1">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap *</label>
                            <input wire:model="name" id="input-name" type="text"
                                class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-kanwil-gold focus:border-kanwil-gold"
                                placeholder="Contoh: Budi Santoso">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                            <input wire:model="email" type="email"
                                class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-kanwil-gold focus:border-kanwil-gold"
                                placeholder="Contoh: budi@kanwil.go.id">
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Password {{ $isEditing ? '(Kosongkan jika tidak diubah)' : '*' }}
                            </label>
                            <input wire:model="password" type="password"
                                class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-kanwil-gold focus:border-kanwil-gold"
                                placeholder="{{ $isEditing ? 'Isi untuk mengganti password' : 'Min. 8 karakter' }}">
                            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                            <input wire:model="password_confirmation" type="password"
                                class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-kanwil-gold focus:border-kanwil-gold"
                                placeholder="Ulangi password">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Level / Hak Akses *</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 p-4 bg-gray-50 border border-gray-200 rounded-xl max-h-60 overflow-y-auto shadow-inner">
                                @foreach($roles as $role)
                                    <label class="flex items-start gap-3 p-2.5 rounded-lg hover:bg-white transition cursor-pointer select-none hover:shadow-sm border border-transparent hover:border-gray-200">
                                        <input type="checkbox" wire:model.live="selectedRoles" value="{{ $role->name }}"
                                            class="mt-0.5 h-4.5 w-4.5 rounded border-gray-300 text-kanwil-blue focus:ring-kanwil-blue transition">
                                        <span class="text-sm font-bold text-gray-700">{{ $role->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('selectedRoles') <p class="text-red-500 text-xs mt-1 block">{{ $message }}</p> @enderror
                        </div>

                        @if(in_array('Admin Bidang', $selectedRoles))
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Tim Penugasan *</label>
                                <select wire:model="selectedBidangId"
                                    class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-kanwil-gold focus:border-kanwil-gold">
                                    <option value="">— Pilih Tim —</option>
                                    @foreach($bidangs as $bidang)
                                        <option value="{{ $bidang->id }}">{{ $bidang->nama_bidang }}</option>
                                    @endforeach
                                </select>
                                @error('selectedBidangId') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        @endif

                        @if(in_array('Operator UPT', $selectedRoles))
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih UPT Penugasan *</label>
                                <select wire:model="selectedUptId"
                                    class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-kanwil-gold focus:border-kanwil-gold">
                                    <option value="">— Pilih UPT —</option>
                                    @foreach($upts as $upt)
                                        <option value="{{ $upt->id }}">{{ $upt->nama_upt }}</option>
                                    @endforeach
                                </select>
                                @error('selectedUptId') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        @endif
                    </div>

                    <div class="px-6 py-4 bg-gray-50 flex justify-end gap-3 border-t border-gray-100 rounded-b-2xl flex-shrink-0">
                        <button type="button" wire:click="$set('showModal', false)"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                            Batal
                        </button>
                        <button type="submit" wire:loading.attr="disabled"
                            class="px-5 py-2 text-sm font-bold text-white bg-kanwil-gold hover:bg-yellow-600 rounded-lg shadow transition disabled:opacity-50 flex items-center gap-2">
                            <svg wire:loading wire:target="save" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                            <span wire:loading.remove wire:target="save">{{ $isEditing ? 'Simpan Perubahan' : 'Buat Pengguna' }}</span>
                            <span wire:loading wire:target="save">Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- ===== MODAL DELETE KONFIRMASI ===== --}}
    @if($showDeleteModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" wire:click="$set('showDeleteModal', false)"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm z-10 p-6 text-center">
                <div class="h-16 w-16 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M12 3a9 9 0 100 18A9 9 0 0012 3z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Hapus Pengguna?</h3>
                <p class="text-sm text-gray-600 mb-6">
                    Anda akan menghapus akun <span class="font-bold text-red-600">{{ $deletingUserName }}</span> secara permanen. Tindakan ini tidak dapat dibatalkan.
                </p>
                <div class="flex gap-3 justify-center">
                    <button wire:click="$set('showDeleteModal', false)"
                        class="px-5 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                        Batal
                    </button>
                    <button wire:click="deleteUser" wire:loading.attr="disabled"
                        class="px-5 py-2 text-sm font-bold text-white bg-red-600 hover:bg-red-700 rounded-lg shadow transition disabled:opacity-50">
                        <span wire:loading.remove wire:target="deleteUser">Ya, Hapus</span>
                        <span wire:loading wire:target="deleteUser">Menghapus...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
