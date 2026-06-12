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
class FormPerizinan extends Component
{
    use WithFileUploads;

    public $nama_lengkap;
    public $nik;
    public $instansi;
    public $tujuan;
    public $lampiran_proposal;
    public $kartu_identitas;

    public $isSuccess = false;
    public $trackingNumber = '';

    protected $rules = [
        'nama_lengkap' => 'required|string|max:255',
        'nik' => 'required|string|digits:16',
        'instansi' => 'required|string|max:255',
        'tujuan' => 'required|string',
        'lampiran_proposal' => 'required|file|mimes:pdf,doc,docx|max:5120', // Max 5MB
        'kartu_identitas' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120', // Max 5MB
    ];

    public function submit(WorkflowService $workflowService)
    {
        $this->validate();

        // Cari atau buat master layanan 'Perizinan'
        $layanan = MasterLayanan::firstOrCreate(
            ['nama_layanan' => 'Perizinan: Magang & Penelitian'],
            ['kategori' => 'Perizinan', 'sla_hari' => 5, 'is_active' => true]
        );

        // Upload files
        $path = $this->lampiran_proposal->store('lampiran_permohonan', 'public');
        $pathKtp = $this->kartu_identitas->store('lampiran_identitas', 'public');

        $payload = [
            'nama_lengkap' => $this->nama_lengkap,
            'nik' => $this->nik,
            'instansi' => $this->instansi,
            'tujuan' => $this->tujuan,
            'lampiran_path' => $path,
            'kartu_identitas_path' => $pathKtp,
            'tipe_form' => 'Perizinan'
        ];

        $permohonan = $workflowService->ajukanPermohonan($layanan->id, $payload, null, 'PRZ');

        $this->trackingNumber = $permohonan->tracking_number;
        $this->isSuccess = true;
    }

    public function render()
    {
        return view('livewire.public.layanan.form-perizinan');
    }
}
