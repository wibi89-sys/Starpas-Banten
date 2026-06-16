<?php

namespace App\Livewire\Admin\Disposisi;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Permohonan;
use App\Enums\StatusPermohonan;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class InboxTable extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openAction($id)
    {
        return $this->redirectRoute('admin.inbox.detail', ['permohonan' => $id], navigate: true);
    }

    public function render()
    {
        $user = auth()->user();
        $query = Permohonan::query()->with(['layanan', 'user']);

        if ($user->hasRole('Super Admin')) {
            // Can see all
        } elseif ($user->hasRole('Admin Pelayanan')) {
            $query->where('status', StatusPermohonan::VERIFICATION);
        } elseif ($user->hasRole('Pejabat Disposisi')) {
            $query->where('status', StatusPermohonan::DISPOSITION);
        } elseif ($user->hasRole('Admin Bidang')) {
            $query->whereIn('status', [StatusPermohonan::PROCESSING, StatusPermohonan::REVISION])
                  ->whereHas('disposisis', function ($q) use ($user) {
                      $q->where('ke_bidang_id', $user->bidang_id);
                  });
        } elseif ($user->hasRole('Operator UPT')) {
            $query->whereIn('status', [StatusPermohonan::PROCESSING, StatusPermohonan::REVISION])
                  ->whereHas('disposisis', function ($q) use ($user) {
                      $q->where('ke_upt_id', $user->upt_id);
                  });
        } elseif ($user->hasRole('Reviewer') || $user->hasRole('Pimpinan')) {
            $query->where('status', StatusPermohonan::REVIEW);
        } else {
            // Publik sees their own
            $query->where('user_id', $user->id);
        }

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('tracking_number', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function($q) {
                      $q->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        return view('livewire.admin.disposisi.inbox-table', [
            'permohonans' => $query->latest()->paginate(10)
        ]);
    }
}
