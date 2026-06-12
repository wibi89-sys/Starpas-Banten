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
class FormInformasi extends Component
{
    use WithFileUploads;

    public $nama_pemohon;
    public $nomor_identitas;
    public $jenis_informasi;
    public $alasan_permintaan;
    public $lampiran_identitas;

    public $isSuccess = false;
    public $trackingNumber = '';

    protected $rules = [
        'nama_pemohon' => 'required|string|max:255',
        'nomor_identitas' => 'required|string|max:50',
        'jenis_informasi' => 'required|string|max:255',
        'alasan_permintaan' => 'required|string',
        'lampiran_identitas' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120', // Max 5MB
    ];

    public function submit(WorkflowService $workflowService)
    {
        $this->validate();

        // Cari atau buat master layanan 'Informasi'
        $layanan = MasterLayanan::firstOrCreate(
            ['nama_layanan' => 'Permintaan Informasi Publik'],
            ['kategori' => 'Informasi', 'sla_hari' => 7, 'is_active' => true]
        );

        $path = $this->lampiran_identitas->store('lampiran_identitas', 'public');

        $payload = [
            'nama_pemohon' => $this->nama_pemohon,
            'nomor_identitas' => $this->nomor_identitas,
            'jenis_informasi' => $this->jenis_informasi,
            'alasan_permintaan' => $this->alasan_permintaan,
            'lampiran_path' => $path,
            'tipe_form' => 'Informasi'
        ];

        $permohonan = $workflowService->ajukanPermohonan($layanan->id, $payload, null, 'INFO');

        $this->trackingNumber = $permohonan->tracking_number;
        $this->isSuccess = true;
    }

    public function render()
    {
        return view('livewire.public.layanan.form-informasi');
    }
}
