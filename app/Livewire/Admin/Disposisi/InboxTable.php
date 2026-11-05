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
    public $activeTab = 'all'; // 'all', 'pending', 'completed'
    public $statusFilter = '';

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingActiveTab()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function openAction($id)
    {
        return $this->redirectRoute('admin.inbox.detail', ['permohonan' => $id], navigate: true);
    }

    protected function getScopedQuery($user)
    {
        $query = Permohonan::query()->with([
            'layanan',
            'user',
            'disposisis.keBidang',
            'disposisis.keUpt'
        ]);

        if ($user->hasRole('Super Admin')) {
            // Super Admin dapat melihat seluruh permohonan
        } elseif ($user->hasRole('Admin Bidang')) {
            // Admin Tim / Bidang: melihat seluruh permohonan yang pernah didisposisikan ke tim/bidangnya
            $query->whereHas('disposisis', function ($q) use ($user) {
                $q->where('ke_bidang_id', $user->bidang_id);
            });
        } elseif ($user->hasRole('Operator UPT')) {
            // Operator UPT: melihat seluruh permohonan yang pernah didisposisikan ke satuannya (UPT)
            $query->whereHas('disposisis', function ($q) use ($user) {
                $q->where('ke_upt_id', $user->upt_id);
            });
        } elseif ($user->hasRole('Pejabat Disposisi')) {
            // Pejabat Disposisi: melihat permohonan tahap disposisi atau yang pernah didisposisikan / ditindaklanjuti
            $query->where(function ($q) use ($user) {
                $q->where('status', StatusPermohonan::DISPOSITION)
                  ->orWhereHas('disposisis', function ($dq) use ($user) {
                      $dq->where('dari_user_id', $user->id);
                  })
                  ->orWhereIn('status', [
                      StatusPermohonan::PROCESSING,
                      StatusPermohonan::COMPLETED,
                      StatusPermohonan::REVISION,
                      StatusPermohonan::REJECTED
                  ]);
            });
        } elseif ($user->hasRole('Reviewer') || $user->hasRole('Pimpinan')) {
            // Pimpinan & Reviewer: dapat melihat seluruh permohonan yang aktif maupun sudah selesai ditindaklanjuti untuk direview
            $query->whereIn('status', [
                StatusPermohonan::REVIEW,
                StatusPermohonan::PROCESSING,
                StatusPermohonan::COMPLETED,
                StatusPermohonan::DISPOSITION,
                StatusPermohonan::REVISION,
                StatusPermohonan::REJECTED
            ]);
        } elseif ($user->hasRole('Admin Pelayanan')) {
            // Admin Pelayanan: dapat melihat verifikasi dan seluruh riwayat permohonan
        } else {
            // Publik melihat permohonannya sendiri
            $query->where('user_id', $user->id);
        }

        return $query;
    }

    public function render()
    {
        $user = auth()->user();
        $baseQuery = $this->getScopedQuery($user);

        // Hitung counter untuk setiap tab berdasarkan scope peran pengguna
        $totalCount = (clone $baseQuery)->count();

        $pendingQuery = (clone $baseQuery)->where(function ($q) use ($user) {
            if ($user->hasRole('Admin Pelayanan')) {
                $q->where('status', StatusPermohonan::VERIFICATION);
            } elseif ($user->hasRole('Pejabat Disposisi')) {
                $q->where('status', StatusPermohonan::DISPOSITION);
            } elseif ($user->hasRole('Admin Bidang') || $user->hasRole('Operator UPT')) {
                $q->whereIn('status', [StatusPermohonan::PROCESSING, StatusPermohonan::REVISION]);
            } elseif ($user->hasRole('Reviewer') || $user->hasRole('Pimpinan')) {
                $q->whereIn('status', [StatusPermohonan::REVIEW, StatusPermohonan::PROCESSING]);
            } else {
                $q->whereNotIn('status', [StatusPermohonan::COMPLETED, StatusPermohonan::REJECTED]);
            }
        });
        $pendingCount = $pendingQuery->count();

        $completedCount = (clone $baseQuery)->where('status', StatusPermohonan::COMPLETED)->count();

        // Terapkan filter tab aktif
        $query = clone $baseQuery;

        if ($this->activeTab === 'pending') {
            $query = $pendingQuery;
        } elseif ($this->activeTab === 'completed') {
            $query->where('status', StatusPermohonan::COMPLETED);
        }

        // Terapkan filter status spesifik jika dipilih oleh pengguna
        if (!empty($this->statusFilter)) {
            $query->where('status', $this->statusFilter);
        }

        // Terapkan pencarian (No Tracking atau Nama Pemohon)
        if (!empty($this->search)) {
            $searchTerm = '%' . $this->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('tracking_number', 'like', $searchTerm)
                  ->orWhereHas('user', function($uq) use ($searchTerm) {
                      $uq->where('name', 'like', $searchTerm);
                  })
                  ->orWhere('payload_data->nama_lengkap', 'like', $searchTerm)
                  ->orWhere('payload_data->nama_pelapor', 'like', $searchTerm)
                  ->orWhere('payload_data->nama_pemohon', 'like', $searchTerm);
            });
        }

        return view('livewire.admin.disposisi.inbox-table', [
            'permohonans'    => $query->latest()->paginate(10),
            'totalCount'     => $totalCount,
            'pendingCount'   => $pendingCount,
            'completedCount' => $completedCount,
        ]);
    }
}
