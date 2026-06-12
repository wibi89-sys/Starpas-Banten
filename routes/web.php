<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Users\ManageUsers;

Route::get('/', \App\Livewire\Public\TrackingPermohonan::class)->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/tracking', function () {
    $code = request()->query('code');
    return redirect()->route('home', ['code' => $code]);
})->name('tracking');

// Public Layanan Forms
Route::get('/layanan/perizinan', \App\Livewire\Public\Layanan\FormPerizinan::class)->name('layanan.perizinan');
Route::get('/layanan/pengaduan', \App\Livewire\Public\Layanan\FormPengaduan::class)->name('layanan.pengaduan');
Route::get('/layanan/informasi', \App\Livewire\Public\Layanan\FormInformasi::class)->name('layanan.informasi');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/inbox', \App\Livewire\Admin\Disposisi\InboxTable::class)->name('inbox');
    Route::get('/inbox/{permohonan}', \App\Livewire\Admin\Disposisi\ActionDetail::class)->name('inbox.detail');
    Route::get('/settings', \App\Livewire\Admin\Settings\ManageSettings::class)->name('settings')->middleware('role:Super Admin');
    Route::get('/users', ManageUsers::class)->name('users')->middleware('role:Super Admin');
});

require __DIR__.'/auth.php';
