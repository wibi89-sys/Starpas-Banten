<?php

namespace App\Livewire\Public\Layanan;

use App\Models\MasterLayanan;
use App\Models\MasterUpt;
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
    public $tujuan_satuan_kerja = '';
    public $detail_aduan;
    public $bukti_lampiran;
    public $kartu_identitas;

    public $isSuccess = false;
    public $trackingNumber = '';

    protected function rules(): array
    {
        return [
            'nama_pelapor' => 'nullable|string|max:255',
            'nik' => 'required|string|digits:16',
            'nomor_kontak' => ['required', 'string', 'max:20', 'regex:/^(08|62)\d{8,13}$/'],
            'tujuan_satuan_kerja' => ['required', 'string', function ($attribute, $value, $fail) {
                if ($value !== 'kanwil' && !preg_match('/^upt:\d+$/', $value)) {
                    $fail('Tujuan pengaduan tidak valid.');
                }
            }],
            'detail_aduan' => 'required|string',
            'bukti_lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf,mp4|max:10240', // Max 10MB
            'kartu_identitas' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120', // Max 5MB
        ];
    }

    protected $messages = [
        'nomor_kontak.regex' => 'Nomor HP harus diawali 08 atau 62 dan hanya berisi angka.',
        'tujuan_satuan_kerja.required' => 'Pilih tujuan pengaduan (Kanwil atau UPT).',
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

        $tujuanTipe = $this->tujuan_satuan_kerja === 'kanwil' ? 'kanwil' : 'upt';
        $tujuanUptId = $tujuanTipe === 'upt' ? (int) substr($this->tujuan_satuan_kerja, 4) : null;
        $tujuanLabel = $tujuanTipe === 'kanwil'
            ? 'Kanwil Ditjenpas Banten'
            : (MasterUpt::find($tujuanUptId)?->nama_upt ?? 'UPT');

        $payload = [
            'nama_pelapor' => $this->nama_pelapor ?: 'Anonim',
            'nik' => $this->nik,
            'nomor_kontak' => $this->nomor_kontak,
            'tujuan_tipe' => $tujuanTipe,
            'tujuan_upt_id' => $tujuanUptId,
            'tujuan_label' => $tujuanLabel,
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
        $upts = MasterUpt::where('is_active', true)->orderBy('nama_upt')->get();

        return view('livewire.public.layanan.form-pengaduan', [
            'upts' => $upts,
        ]);
    }
}
