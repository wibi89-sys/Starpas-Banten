<?php

namespace App\Livewire\Admin\Disposisi;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Permohonan;
use App\Models\PermohonanTimeline;
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

    // Catatan Review Tambahan (Untuk Pimpinan / Reviewer / Super Admin)
    public $catatanReview = '';

    public function mount(Permohonan $permohonan)
    {
        $this->permohonan = $permohonan->load([
            'layanan',
            'user',
            'timelines.user',
            'disposisis.keBidang',
            'disposisis.keUpt',
            'disposisis.dariUser'
        ]);

        $this->nomor_surat_jawaban = $permohonan->nomor_surat_jawaban ?? '';
        $this->perihal_surat_jawaban = $permohonan->perihal_surat_jawaban ?? ($permohonan->layanan->nama_layanan ?? '');
        $this->tanggal_surat_jawaban = $permohonan->tanggal_surat_jawaban ? $permohonan->tanggal_surat_jawaban->format('Y-m-d') : now()->format('Y-m-d');
    }

    public function clearFile()
    {
        $this->file_surat_jawaban = null;
    }

    /**
     * Memeriksa apakah user yang sedang login berhak mengeksekusi aksi proses pada status saat ini.
     */
    public function canUserProcess(): bool
    {
        $user = auth()->user();
        if (!$user) return false;

        if ($user->hasRole('Super Admin')) {
            return true;
        }

        $status = $this->permohonan->status;

        // Permohonan yang sudah tuntas/ditolak tidak memerlukan formulir pemrosesan lagi
        if ($status === StatusPermohonan::COMPLETED || $status === StatusPermohonan::REJECTED) {
            return false;
        }

        if ($status === StatusPermohonan::VERIFICATION) {
            return $user->hasRole('Admin Pelayanan');
        }

        if ($status === StatusPermohonan::DISPOSITION) {
            return $user->hasRole('Pejabat Disposisi') || $user->hasRole('Pimpinan');
        }

        if ($status === StatusPermohonan::PROCESSING || $status === StatusPermohonan::REVISION) {
            if ($user->hasRole('Admin Bidang')) {
                return $this->permohonan->disposisis()->where('ke_bidang_id', $user->bidang_id)->exists();
            }
            if ($user->hasRole('Operator UPT')) {
                return $this->permohonan->disposisis()->where('ke_upt_id', $user->upt_id)->exists();
            }
            return false;
        }

        if ($status === StatusPermohonan::REVIEW) {
            return $user->hasRole('Pimpinan') || $user->hasRole('Reviewer');
        }

        return false;
    }

    /**
     * Memeriksa apakah user berhak memberikan catatan evaluasi review (Pimpinan / Reviewer / Super Admin).
     */
    public function canUserReview(): bool
    {
        $user = auth()->user();
        if (!$user) return false;

        return $user->hasRole('Pimpinan') || $user->hasRole('Reviewer') || $user->hasRole('Super Admin');
    }

    /**
     * Pimpinan atau Reviewer dapat menambahkan catatan evaluasi ke timeline kapan pun tanpa merusak status selesai.
     */
    public function addReviewNote()
    {
        if (!$this->canUserReview()) {
            session()->flash('error', 'Hanya Pimpinan, Reviewer, atau Super Admin yang dapat menambahkan catatan review.');
            return;
        }

        $this->validate([
            'catatanReview' => 'required|min:3'
        ], [
            'catatanReview.required' => 'Catatan review tidak boleh kosong.',
            'catatanReview.min'      => 'Catatan review minimal 3 karakter.'
        ]);

        $user = auth()->user();

        PermohonanTimeline::create([
            'permohonan_id'     => $this->permohonan->id,
            'status_sebelumnya' => $this->permohonan->status->value,
            'status_baru'       => $this->permohonan->status->value,
            'catatan'           => "Catatan Review Pimpinan: " . $this->catatanReview,
            'user_id'           => $user->id,
        ]);

        $this->catatanReview = '';
        $this->permohonan->load(['timelines.user']);
        session()->flash('success', 'Catatan evaluasi / review pimpinan berhasil ditambahkan ke riwayat permohonan.');
    }

    public function processAction(WorkflowService $workflow)
    {
        if (!$this->canUserProcess()) {
            session()->flash('error', 'Anda tidak memiliki hak akses untuk memproses tahap permohonan ini.');
            return;
        }

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
