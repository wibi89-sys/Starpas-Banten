<?php

namespace App\Livewire\Public\Layanan;

use App\Enums\StatusPermohonan;
use App\Models\MasterLayanan;
use App\Models\MasterUpt;
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
    public $nomor_identitas;
    public $instansi;
    public $alamat_lengkap;
    public $nomor_kontak;
    public $tujuan_satuan_kerja = '';
    public $nomor_surat;
    public $jenis_perizinan;
    public $tanggal_mulai;
    public $tanggal_selesai;
    public $uraian;
    public $kartu_identitas;
    public $surat_pengantar;

    public $isSuccess = false;
    public $trackingNumber = '';

    protected $rules = [
        'nama_lengkap' => 'required|string|max:255',
        'nomor_identitas' => 'required|string|max:50',
        'instansi' => 'required|string|max:255',
        'alamat_lengkap' => 'required|string',
        'nomor_kontak' => 'required|string|max:20',
        'tujuan_satuan_kerja' => 'required|string',
        'nomor_surat' => 'required|string|max:255',
        'jenis_perizinan' => 'required|string',
        'tanggal_mulai' => 'nullable|date',
        'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
        'uraian' => 'required|string',
        'kartu_identitas' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120', // Maks 5MB
        'surat_pengantar' => 'required|file|mimes:pdf|max:5120', // Hanya PDF, Maks 5MB
    ];

    protected $messages = [
        'tujuan_satuan_kerja.required' => 'Pilih Kantor Wilayah atau UPT Pemasyarakatan yang dituju.',
        'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus sama atau setelah tanggal mulai.',
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
        $pathKtp = $this->kartu_identitas->store('lampiran_identitas', 'public');
        $pathSurat = $this->surat_pengantar->store('lampiran_permohonan', 'public');

        $tujuanTipe = str_starts_with($this->tujuan_satuan_kerja, 'upt:') ? 'upt' : 'kanwil';
        $tujuanUptId = $tujuanTipe === 'upt' ? (int) substr($this->tujuan_satuan_kerja, 4) : null;
        $tujuanLabel = $tujuanTipe === 'kanwil'
            ? 'Kantor Wilayah Ditjenpas Banten'
            : (MasterUpt::find($tujuanUptId)?->nama_upt ?? 'UPT Pemasyarakatan');

        $payload = [
            'nama_lengkap' => $this->nama_lengkap,
            'nomor_identitas' => $this->nomor_identitas,
            'instansi' => $this->instansi, // Asal instansi / kampus / sekolah pemohon
            'alamat_lengkap' => $this->alamat_lengkap,
            'nomor_kontak' => $this->nomor_kontak,
            'tujuan_tipe' => $tujuanTipe,
            'tujuan_upt_id' => $tujuanUptId,
            'tujuan_label' => $tujuanLabel, // Satker / UPT Tujuan Permohonan
            'nomor_surat' => $this->nomor_surat,
            'jenis_perizinan' => $this->jenis_perizinan,
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_selesai' => $this->tanggal_selesai,
            'uraian' => $this->uraian,
            'kartu_identitas_path' => $pathKtp,
            'lampiran_path' => $pathSurat,
            'tipe_form' => 'Perizinan'
        ];

        $permohonan = $workflowService->ajukanPermohonan($layanan->id, $payload, null, 'PRZ');

        $this->trackingNumber = $permohonan->tracking_number;
        $this->isSuccess = true;
    }

    public function render()
    {
        $upts = MasterUpt::where('is_active', true)->orderBy('nama_upt')->get();
        return view('livewire.public.layanan.form-perizinan', [
            'upts' => $upts
        ]);
    }
}
