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
    public $instansi_asal;
    public $nomor_identitas;
    public $alamat_lengkap;
    public $nomor_hp;
    public $jenis_informasi;
    public $tujuan_penggunaan;
    public $lampiran_surat_permohonan;
    public $lampiran_ktp;

    public $isSuccess = false;
    public $trackingNumber = '';

    protected function rules(): array
    {
        return [
            'nama_pemohon' => 'required|string|max:255',
            'instansi_asal' => 'required|string|max:255',
            'nomor_identitas' => 'required|string|max:16|digits:16',
            'alamat_lengkap' => 'required|string|max:500',
            'nomor_hp' => ['required', 'string', 'max:20', 'regex:/^(08|62)\d{8,13}$/'],
            'jenis_informasi' => 'required|string|max:255',
            'tujuan_penggunaan' => 'required|string|max:255',
            'lampiran_surat_permohonan' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'lampiran_ktp' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ];
    }

    protected $messages = [
        'nomor_hp.regex' => 'Nomor HP harus diawali 08 atau 62 dan hanya berisi angka.',
    ];

    public function submit(WorkflowService $workflowService)
    {
        $this->validate();

        // Cari atau buat master layanan 'Informasi'
        $layanan = MasterLayanan::firstOrCreate(
            ['nama_layanan' => 'Permintaan Informasi Publik'],
            ['kategori' => 'Informasi', 'sla_hari' => 7, 'is_active' => true]
        );

        $pathSurat = $this->lampiran_surat_permohonan->store('lampiran_permohonan', 'public');
        $pathKtp = $this->lampiran_ktp->store('lampiran_identitas', 'public');

        $payload = [
            'nama_lengkap' => $this->nama_pemohon,
            'instansi_asal' => $this->instansi_asal,
            'nik' => $this->nomor_identitas,
            'alamat_lengkap' => $this->alamat_lengkap,
            'nomor_hp' => $this->nomor_hp,
            'uraian_informasi' => $this->jenis_informasi,
            'tujuan_penggunaan' => $this->tujuan_penggunaan,
            'lampiran_surat_path' => $pathSurat,
            'lampiran_ktp_path' => $pathKtp,
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
