<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\MasterLayanan;
use App\Models\Permohonan;
use App\Enums\StatusPermohonan;
use App\Services\WorkflowService;
use App\Services\FonnteService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class PermohonanTindakLanjutTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Role::firstOrCreate(['name' => 'Super Admin']);
        Role::firstOrCreate(['name' => 'Admin Bidang']);
    }

    public function test_permohonan_can_be_completed_with_optional_surat_document(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $user->assignRole('Admin Bidang');

        $layanan = MasterLayanan::create([
            'nama_layanan' => 'Layanan Perizinan Riset',
            'kategori'     => 'perizinan',
            'sla_hari'     => 3,
            'is_active'    => true,
        ]);

        $permohonan = Permohonan::create([
            'tracking_number'   => 'PRZ-2611-0001',
            'master_layanan_id' => $layanan->id,
            'status'            => StatusPermohonan::PROCESSING,
            'payload_data'      => [
                'nama_pemohon' => 'Budi Santoso',
                'nomor_kontak' => '081234567890'
            ],
            'tanggal_pengajuan' => now(),
        ]);

        $fakePdf = UploadedFile::fake()->create('surat_izin_riset.pdf', 500, 'application/pdf');
        $storedPath = $fakePdf->storeAs('surat_jawaban', 'surat_test.pdf', 'public');

        $fonnteMock = $this->createMock(FonnteService::class);
        $workflow = new WorkflowService($fonnteMock);

        $workflow->updateStatus(
            $permohonan,
            StatusPermohonan::COMPLETED,
            'Permohonan telah disetujui dan surat diterbitkan.',
            $user->id,
            $storedPath,
            [
                'nomor_surat_jawaban'   => 'W12.PAS.UM.01.01-999',
                'perihal_surat_jawaban' => 'Persetujuan Izin Riset',
                'tanggal_surat_jawaban' => '2026-11-05',
            ],
            $storedPath,
            'surat_izin_riset.pdf'
        );

        $permohonan->refresh();

        $this->assertEquals(StatusPermohonan::COMPLETED, $permohonan->status);
        $this->assertEquals('surat_jawaban/surat_test.pdf', $permohonan->file_surat_jawaban);
        $this->assertEquals('W12.PAS.UM.01.01-999', $permohonan->nomor_surat_jawaban);
        $this->assertEquals('Persetujuan Izin Riset', $permohonan->perihal_surat_jawaban);
        $this->assertNotNull($permohonan->file_surat_jawaban_url);

        $latestTimeline = $permohonan->timelines()->latest('id')->first();
        $this->assertNotNull($latestTimeline);
        $this->assertEquals(StatusPermohonan::COMPLETED, $latestTimeline->status_baru);
        $this->assertEquals('surat_jawaban/surat_test.pdf', $latestTimeline->lampiran_file);
        $this->assertEquals('surat_izin_riset.pdf', $latestTimeline->nama_lampiran);
    }

    public function test_permohonan_can_be_completed_without_document_for_direct_confirmation(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Admin Bidang');

        $layanan = MasterLayanan::create([
            'nama_layanan' => 'Pengaduan Pelayanan',
            'kategori'     => 'pengaduan',
            'sla_hari'     => 1,
            'is_active'    => true,
        ]);

        $permohonan = Permohonan::create([
            'tracking_number'   => 'PGD-2611-0002',
            'master_layanan_id' => $layanan->id,
            'status'            => StatusPermohonan::PROCESSING,
            'payload_data'      => [
                'nama_pelapor' => 'Siti Aminah',
                'nomor_kontak' => '089876543210'
            ],
            'tanggal_pengajuan' => now(),
        ]);

        $fonnteMock = $this->createMock(FonnteService::class);
        $workflow = new WorkflowService($fonnteMock);

        // Diselesaikan langsung dengan konfirmasi tanpa file surat
        $workflow->updateStatus(
            $permohonan,
            StatusPermohonan::COMPLETED,
            'Pengaduan telah diklarifikasi dan diselesaikan secara langsung dengan pelapor.',
            $user->id
        );

        $permohonan->refresh();

        $this->assertEquals(StatusPermohonan::COMPLETED, $permohonan->status);
        $this->assertNull($permohonan->file_surat_jawaban);
        $this->assertNull($permohonan->nomor_surat_jawaban);
    }
}

