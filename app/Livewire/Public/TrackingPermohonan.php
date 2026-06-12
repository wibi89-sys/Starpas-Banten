<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Permohonan;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;

#[Layout('layouts.public-clean')]
class TrackingPermohonan extends Component
{
    #[Validate('required|string|min:5')]
    public string $trackingNumber = '';

    public ?Permohonan $permohonan = null;
    public bool $isSearched = false;

    public function mount()
    {
        $code = request()->query('code');
        if ($code) {
            $this->trackingNumber = $code;
            $this->search();
        }
    }

    public function search()
    {
        $this->validate();
        $this->isSearched = true;

        $this->permohonan = Permohonan::with(['layanan', 'timelines' => function($q) {
            $q->orderBy('created_at', 'desc');
        }])->where('tracking_number', trim($this->trackingNumber))->first();
    }

    public function render()
    {
        return view('livewire.public.tracking-permohonan');
    }
}
