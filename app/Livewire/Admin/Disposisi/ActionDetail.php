<?php

namespace App\Livewire\Admin\Disposisi;

use Livewire\Component;
use App\Models\Permohonan;
use App\Services\WorkflowService;
use App\Enums\StatusPermohonan;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class ActionDetail extends Component
{
    public Permohonan $permohonan;
    public $catatan = '';
    public $actionType = ''; 
    
    public $tujuan_bidang_id = null;
    public $tujuan_upt_id = null;

    public function mount(Permohonan $permohonan)
    {
        $this->permohonan = $permohonan;
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
                StatusPermohonan::PROCESSING => StatusPermohonan::REVIEW,
                StatusPermohonan::REVIEW => StatusPermohonan::COMPLETED,
                default => StatusPermohonan::COMPLETED
            };

            if ($this->permohonan->status === StatusPermohonan::DISPOSITION) {
                $this->validate([
                    'tujuan_bidang_id' => 'required_without:tujuan_upt_id',
                    'tujuan_upt_id' => 'required_without:tujuan_bidang_id',
                ], [
                    'tujuan_bidang_id.required_without' => 'Pilih salah satu Bidang Tujuan atau UPT Tujuan.',
                    'tujuan_upt_id.required_without' => 'Pilih salah satu Bidang Tujuan atau UPT Tujuan.'
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
        $upts = \App\Models\MasterUpt::all();
        
        return view('livewire.admin.disposisi.action-detail', compact('bidangs', 'upts'));
    }
}
