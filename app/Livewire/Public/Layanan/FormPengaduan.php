<?php

namespace App\Livewire\Public\Layanan;

use App\Enums\StatusPermohonan;
use App\Models\MasterLayanan;
use App\Models\Permohonan;
use App\Services\WorkflowService;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

#[Layout('layouts.public')]
class FormPengaduan extends Component
{
    use WithFileUploads;

    public $nama_pelapor;
    public $nik;
    public $nomor_kontak;
    public $detail_aduan;
    public $bukti_lampiran;
    public $kartu_identitas;

    public $isSuccess = false;
    public $trackingNumber = '';

    protected $rules = [
        'nama_pelapor' => 'nullable|string|max:255',
        'nik' => 'required|string|digits:16',
        'nomor_kontak' => 'required|string|max:20',
        'detail_aduan' => 'required|string',
        'bukti_lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf,mp4|max:10240', // Max 10MB
        'kartu_identitas' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120', // Max 5MB
    ];

    public function submit(WorkflowService $workflowService)
    {
        $this->validate();

        // Cari atau buat master layanan 'Pengaduan'
        $layanan = MasterLayanan::firstOrCreate(
            ['nama_layanan' => 'Pengaduan Pelanggaran'],
            ['kategori' => 'Pengaduan', 'sla_hari' => 3, 'is_active' => true]
        );

        $path = null;
        if ($this->bukti_lampiran) {
            $path = $this->bukti_lampiran->store('lampiran_pengaduan', 'public');
        }
        $pathKtp = $this->kartu_identitas->store('lampiran_identitas', 'public');

        $payload = [
            'nama_pelapor' => $this->nama_pelapor ?: 'Anonim',
            'nik' => $this->nik,
            'nomor_kontak' => $this->nomor_kontak,
            'detail_aduan' => $this->detail_aduan,
            'lampiran_path' => $path,
            'kartu_identitas_path' => $pathKtp,
            'tipe_form' => 'Pengaduan'
        ];

        $permohonan = $workflowService->ajukanPermohonan($layanan->id, $payload, null, 'ADU');

        $this->trackingNumber = $permohonan->tracking_number;
        $this->isSuccess = true;
    }

    public function render()
    {
        return view('livewire.public.layanan.form-pengaduan');
    }
}
