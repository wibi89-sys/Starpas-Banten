<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PermohonanDisposisi extends Model
{
    protected $fillable = [
        'permohonan_id', 'dari_user_id', 'ke_bidang_id', 'ke_upt_id', 'catatan', 'status_disposisi'
    ];

    public function permohonan(): BelongsTo
    {
        return $this->belongsTo(Permohonan::class);
    }

    public function dariUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dari_user_id');
    }

    public function keBidang(): BelongsTo
    {
        return $this->belongsTo(MasterBidang::class, 'ke_bidang_id');
    }

    public function keUpt(): BelongsTo
    {
        return $this->belongsTo(MasterUpt::class, 'ke_upt_id');
    }
}
