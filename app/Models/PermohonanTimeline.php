<?php

namespace App\Models;

use App\Enums\StatusPermohonan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PermohonanTimeline extends Model
{
    protected $fillable = [
        'permohonan_id', 'status_sebelumnya', 'status_baru', 'catatan', 'user_id'
    ];

    protected $casts = [
        'status_sebelumnya' => StatusPermohonan::class,
        'status_baru' => StatusPermohonan::class,
    ];

    public function permohonan(): BelongsTo
    {
        return $this->belongsTo(Permohonan::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
