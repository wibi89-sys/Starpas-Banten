<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class AppSetting extends Model
{
    protected $fillable = [
        'nama_instansi', 'singkatan', 'deskripsi', 'logo_path', 'favicon_path',
        'alamat', 'kontak', 'email', 'warna_tema',
        'whatsapp_notif_enabled', 'fonnte_token',
    ];

    public static function getSettings()
    {
        // Auto-link storage on load if it doesn't exist
        if (!file_exists(public_path('storage'))) {
            try {
                \Illuminate\Support\Facades\Artisan::call('storage:link');
            } catch (\Exception $e) {
                // Ignore failure if environment restricts command execution
            }
        }

        return Cache::rememberForever('app_settings', function () {
            $settings = self::first();
            
            if (!$settings) {
                $settings = self::create([
                    'nama_instansi' => 'Kanwil Ditjenpas Banten',
                    'singkatan' => 'STARPAS',
                    'deskripsi' => 'Sistem Terpadu Aksi Responsif',
                    'warna_tema' => '#105132'
                ]);
            } else {
                // Self-healing check: Update to new default values if old defaults are present
                if ($settings->nama_instansi === 'Starpas Banten' || empty($settings->singkatan)) {
                    $settings->update([
                        'nama_instansi' => 'Kanwil Ditjenpas Banten',
                        'singkatan' => 'STARPAS',
                        'deskripsi' => 'Sistem Terpadu Aksi Responsif',
                        'warna_tema' => '#105132'
                    ]);
                }
            }
            
            return $settings;
        });
    }

    protected static function booted()
    {
        static::saved(function () {
            Cache::forget('app_settings');
        });
    }
}
