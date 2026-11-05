<?php

namespace App\Livewire\Admin\Disposisi;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Permohonan;
use App\Services\WorkflowService;
use App\Enums\StatusPermohonan;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class ActionDetail extends Component
{
    use WithFileUploads;

    public Permohonan $permohonan;
    public $catatan = '';
    public $actionType = ''; 
    
    public $tujuan_bidang_id = null;
    public $tujuan_upt_id = null;

    // Dokumen Surat Jawaban / Persetujuan (Opsional)
    public $nomor_surat_jawaban = '';
    public $perihal_surat_jawaban = '';
    public $tanggal_surat_jawaban = '';
    public $file_surat_jawaban = null;

    public function mount(Permohonan $permohonan)
    {
        $this->permohonan = $permohonan;
        $this->nomor_surat_jawaban = $permohonan->nomor_surat_jawaban ?? '';
        $this->perihal_surat_jawaban = $permohonan->perihal_surat_jawaban ?? ($permohonan->layanan->nama_layanan ?? '');
        $this->tanggal_surat_jawaban = $permohonan->tanggal_surat_jawaban ? $permohonan->tanggal_surat_jawaban->format('Y-m-d') : now()->format('Y-m-d');
    }

    public function clearFile()
    {
        $this->file_surat_jawaban = null;
    }

    public function processAction(WorkflowService $workflow)
    {
        $this->validate([
            'actionType' => 'required',
            'catatan' => 'required|min:5'
        ]);

        $user = auth()->user();

        if ($this->actionType === 'approve') {
            $nextStatus = match ($this->permohonan->status) {
                StatusPermohonan::VERIFICATION => StatusPermohonan::DISPOSITION,
                StatusPermohonan::DISPOSITION => StatusPermohonan::PROCESSING,
                // Alur Ringkas: Pelaksana (Diproses) langsung menyelesaikan permohonan
                StatusPermohonan::PROCESSING => StatusPermohonan::COMPLETED,
                StatusPermohonan::REVIEW => StatusPermohonan::COMPLETED,
                default => StatusPermohonan::COMPLETED
            };

            if ($this->permohonan->status === StatusPermohonan::DISPOSITION) {
                $this->validate([
                    'tujuan_bidang_id' => 'required_without:tujuan_upt_id',
                    'tujuan_upt_id' => 'required_without:tujuan_bidang_id',
                ], [
                    'tujuan_bidang_id.required_without' => 'Pilih salah satu Tim Tujuan atau UPT Tujuan.',
                    'tujuan_upt_id.required_without' => 'Pilih salah satu Tim Tujuan atau UPT Tujuan.'
                ]);

                // Create PermohonanDisposisi
                $workflow->disposisi(
                    $this->permohonan,
                    $user->id,
                    $this->tujuan_bidang_id ? (int)$this->tujuan_bidang_id : null,
                    $this->tujuan_upt_id ? (int)$this->tujuan_upt_id : null,
                    $this->catatan
                );

                // Update status to processing
                $workflow->updateStatus($this->permohonan, StatusPermohonan::PROCESSING, "Disposisi dikirim ke pelaksana.", $user->id);
                session()->flash('success', 'Permohonan berhasil didisposisikan ke pelaksana.');
            } elseif ($nextStatus === StatusPermohonan::COMPLETED) {
                // Validasi data surat (bersifat opsional)
                $this->validate([
                    'file_surat_jawaban'    => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
                    'nomor_surat_jawaban'   => 'nullable|string|max:100',
                    'perihal_surat_jawaban' => 'nullable|string|max:255',
                    'tanggal_surat_jawaban' => 'nullable|date',
                ], [
                    'file_surat_jawaban.mimes' => 'Format file harus PDF, DOC, DOCX, JPG, JPEG, atau PNG.',
                    'file_surat_jawaban.max'   => 'Ukuran file maksimal adalah 10MB.',
                ]);

                $storedPath = null;
                $originalName = null;

                if ($this->file_surat_jawaban) {
                    $originalName = $this->file_surat_jawaban->getClientOriginalName();
                    $extension = $this->file_surat_jawaban->getClientOriginalExtension();
                    $storedName = 'Surat_' . $this->permohonan->tracking_number . '_' . time() . '.' . $extension;
                    $storedPath = $this->file_surat_jawaban->storeAs('surat_jawaban', $storedName, 'public');
                }

                $workflow->updateStatus(
                    $this->permohonan,
                    StatusPermohonan::COMPLETED,
                    $this->catatan,
                    $user->id,
                    $storedPath,
                    [
                        'nomor_surat_jawaban'   => $this->nomor_surat_jawaban ?: null,
                        'perihal_surat_jawaban' => $this->perihal_surat_jawaban ?: null,
                        'tanggal_surat_jawaban' => $this->tanggal_surat_jawaban ?: null,
                    ],
                    $storedPath,
                    $originalName
                );

                session()->flash('success', 'Permohonan berhasil diselesaikan dan status telah diperbarui.');
            } else {
                $workflow->updateStatus($this->permohonan, $nextStatus, $this->catatan, $user->id);
                session()->flash('success', 'Permohonan berhasil disetujui / diteruskan.');
            }
            
        } elseif ($this->actionType === 'reject') {
            $workflow->updateStatus($this->permohonan, StatusPermohonan::REJECTED, $this->catatan, $user->id);
            session()->flash('error', 'Permohonan ditolak.');
            
        } elseif ($this->actionType === 'revise') {
            $workflow->updateStatus($this->permohonan, StatusPermohonan::REVISION, $this->catatan, $user->id);
            session()->flash('warning', 'Permohonan dikembalikan untuk revisi.');
        }

        return $this->redirectRoute('admin.inbox', navigate: true);
    }

    public function render()
    {
        $bidangs = \App\Models\MasterBidang::all();
        $upts = \App\Models\MasterUpt::where('is_active', true)->get();
        
        return view('livewire.admin.disposisi.action-detail', compact('bidangs', 'upts'));
    }
}
