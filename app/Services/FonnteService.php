<?php

namespace App\Services;

use App\Models\AppSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteService
{
    protected ?string $token;
    protected bool $enabled;

    public function __construct()
    {
        $settings = AppSetting::getSettings();
        $this->token = $settings->fonnte_token ?? null;
        $this->enabled = (bool) ($settings->whatsapp_notif_enabled ?? false);
    }

    /**
     * Kirim pesan WhatsApp via Fonnte API.
     *
     * @param  string  $target  Nomor HP tujuan (format: 08xxx atau 628xxx)
     * @param  string  $message Isi pesan
     * @return bool
     */
    public function send(string $target, string $message): bool
    {
        if (!$this->enabled || empty($this->token)) {
            Log::info('[Fonnte] Notifikasi WA dilewati (nonaktif atau token kosong).', compact('target'));
            return false;
        }

        // Normalisasi nomor: ganti 0 awal menjadi 62
        $target = $this->normalizePhone($target);

        if (empty($target)) {
            Log::warning('[Fonnte] Nomor telepon tidak valid, pesan tidak dikirim.');
            return false;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token,
            ])->post('https://api.fonnte.com/send', [
                'target'  => $target,
                'message' => $message,
            ]);

            if ($response->successful() && ($response->json('status') === true || $response->json('status') === 'true')) {
                Log::info('[Fonnte] WA berhasil dikirim.', ['target' => $target]);
                return true;
            }

            Log::warning('[Fonnte] Respon tidak sukses.', [
                'target'   => $target,
                'response' => $response->json(),
            ]);
            return false;

        } catch (\Throwable $e) {
            Log::error('[Fonnte] Error saat mengirim WA: ' . $e->getMessage(), ['target' => $target]);
            return false;
        }
    }

    /**
     * Normalisasi nomor HP Indonesia ke format 628xxx.
     */
    protected function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/\D/', '', $phone); // Hapus karakter non-angka

        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        } elseif (str_starts_with($phone, '8')) {
            $phone = '62' . $phone;
        }

        // Validasi minimal 10 digit
        if (strlen($phone) < 10) {
            return '';
        }

        return $phone;
    }
}
