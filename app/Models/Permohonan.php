<?php

namespace App\Models;

use App\Enums\StatusPermohonan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Permohonan extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'tracking_number', 'user_id', 'master_layanan_id', 
        'status', 'payload_data', 'tanggal_pengajuan', 'sla_deadline',
        'file_surat_jawaban', 'nomor_surat_jawaban', 'perihal_surat_jawaban', 'tanggal_surat_jawaban'
    ];

    protected $casts = [
        'status' => StatusPermohonan::class,
        'payload_data' => 'array',
        'tanggal_pengajuan' => 'date',
        'sla_deadline' => 'date',
        'tanggal_surat_jawaban' => 'date',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }

    public function getNamaPemohonAttribute(): string
    {
        return $this->payload_data['nama_lengkap']
            ?? $this->payload_data['nama_pelapor']
            ?? $this->payload_data['nama_pemohon']
            ?? ($this->user->name ?? 'Anonim');
    }

    public function getFileSuratJawabanUrlAttribute(): ?string
    {
        return $this->file_surat_jawaban ? asset('storage/' . $this->file_surat_jawaban) : null;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function layanan(): BelongsTo
    {
        return $this->belongsTo(MasterLayanan::class, 'master_layanan_id');
    }

    public function timelines(): HasMany
    {
        return $this->hasMany(PermohonanTimeline::class);
    }

    public function disposisis(): HasMany
    {
        return $this->hasMany(PermohonanDisposisi::class);
    }
}
