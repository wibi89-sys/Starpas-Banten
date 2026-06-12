<?php

namespace App\Services;

use App\Models\Permohonan;
use App\Models\PermohonanTimeline;
use App\Models\PermohonanDisposisi;
use App\Models\MasterLayanan;
use App\Enums\StatusPermohonan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WorkflowService
{
    public function __construct(protected FonnteService $fonnte) {}

    /**
     * Generate Tracking Number.
     */
    public function generateTrackingNumber(string $prefix = 'STR'): string
    {
        $date = Carbon::now()->format('ym');
        $lastPermohonan = Permohonan::where('tracking_number', 'like', "{$prefix}-{$date}-%")->orderBy('id', 'desc')->first();

        if ($lastPermohonan) {
            $lastNumber = (int) substr($lastPermohonan->tracking_number, -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return "{$prefix}-{$date}-{$newNumber}";
    }

    /**
     * Create a new Permohonan and its initial timeline.
     */
    public function ajukanPermohonan(int $layananId, array $payload, ?int $userId = null, string $prefix = 'STR'): Permohonan
    {
        return DB::transaction(function () use ($layananId, $payload, $userId, $prefix) {
            $layanan = MasterLayanan::findOrFail($layananId);
            $trackingNumber = $this->generateTrackingNumber($prefix);

            $permohonan = Permohonan::create([
                'tracking_number'   => $trackingNumber,
                'user_id'           => $userId,
                'master_layanan_id' => $layananId,
                'status'            => StatusPermohonan::VERIFICATION,
                'payload_data'      => $payload,
                'tanggal_pengajuan' => Carbon::now(),
                'sla_deadline'      => Carbon::now()->addWeekdays($layanan->sla_hari),
            ]);

            $this->catatTimeline($permohonan, null, StatusPermohonan::VERIFICATION, 'Permohonan berhasil diajukan.', $userId);

            // Kirim notifikasi WA via Fonnte
            $nomorKontak = $payload['nomor_kontak'] ?? null;
            if ($nomorKontak) {
                $nama = $payload['nama_lengkap'] ?? $payload['nama_pelapor'] ?? $payload['nama_pemohon'] ?? 'Pemohon';
                $pesan = "✅ *Permohonan Diterima*\n\nYth. {$nama},\n\nPermohonan Anda telah kami terima dengan nomor resi:\n*{$trackingNumber}*\n\nGunakan nomor ini untuk memantau status permohonan Anda.\n\nTerima kasih,\n_STARPAS Kanwil Ditjenpas Banten_";
                $this->fonnte->send($nomorKontak, $pesan);
            }

            return $permohonan;
        });
    }

    /**
     * Update status and record timeline.
     */
    public function updateStatus(Permohonan $permohonan, StatusPermohonan $statusBaru, string $catatan, ?int $userId = null): Permohonan
    {
        return DB::transaction(function () use ($permohonan, $statusBaru, $catatan, $userId) {
            $statusLama = $permohonan->status;

            $permohonan->update([
                'status' => $statusBaru
            ]);

            $this->catatTimeline($permohonan, $statusLama, $statusBaru, $catatan, $userId);

            // Kirim notifikasi WA update status via Fonnte
            $payload = $permohonan->payload_data ?? [];
            $nomorKontak = $payload['nomor_kontak'] ?? null;
            if ($nomorKontak) {
                $nama = $payload['nama_lengkap'] ?? $payload['nama_pelapor'] ?? $payload['nama_pemohon'] ?? 'Pemohon';
                $statusLabel = $statusBaru->label();
                $pesan = "📋 *Update Status Permohonan*\n\nYth. {$nama},\n\nStatus permohonan *{$permohonan->tracking_number}* telah diperbarui:\n\n📌 Status: *{$statusLabel}*\n💬 Catatan: {$catatan}\n\nTerima kasih atas kepercayaan Anda.\n_STARPAS Kanwil Ditjenpas Banten_";
                $this->fonnte->send($nomorKontak, $pesan);
            }

            return $permohonan;
        });
    }

    /**
     * Dispose the permohonan to a Bidang or UPT.
     */
    public function disposisi(Permohonan $permohonan, int $dariUserId, ?int $keBidangId, ?int $keUptId, string $catatan): PermohonanDisposisi
    {
        return DB::transaction(function () use ($permohonan, $dariUserId, $keBidangId, $keUptId, $catatan) {

            $disposisi = PermohonanDisposisi::create([
                'permohonan_id'    => $permohonan->id,
                'dari_user_id'     => $dariUserId,
                'ke_bidang_id'     => $keBidangId,
                'ke_upt_id'        => $keUptId,
                'catatan'          => $catatan,
                'status_disposisi' => 'pending'
            ]);

            if ($permohonan->status !== StatusPermohonan::DISPOSITION) {
                $this->updateStatus($permohonan, StatusPermohonan::DISPOSITION, "Didisposisikan. Catatan: {$catatan}", $dariUserId);
            } else {
                $this->catatTimeline($permohonan, StatusPermohonan::DISPOSITION, StatusPermohonan::DISPOSITION, "Tambahan Disposisi. Catatan: {$catatan}", $dariUserId);
            }

            return $disposisi;
        });
    }

    /**
     * Internal function to record timeline.
     */
    protected function catatTimeline(Permohonan $permohonan, ?StatusPermohonan $statusLama, StatusPermohonan $statusBaru, string $catatan, ?int $userId = null): void
    {
        PermohonanTimeline::create([
            'permohonan_id'     => $permohonan->id,
            'status_sebelumnya' => $statusLama?->value,
            'status_baru'       => $statusBaru->value,
            'catatan'           => $catatan,
            'user_id'           => $userId,
        ]);
    }
}
