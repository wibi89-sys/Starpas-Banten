<?php

namespace App\Enums;

enum StatusPermohonan: string
{
    case DRAFT = 'draft';
    case VERIFICATION = 'verification';
    case DISPOSITION = 'disposition';
    case PROCESSING = 'processing';
    case REVIEW = 'review';
    case COMPLETED = 'completed';
    case REJECTED = 'rejected';
    case REVISION = 'revision';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::VERIFICATION => 'Verifikasi',
            self::DISPOSITION => 'Disposisi',
            self::PROCESSING => 'Diproses',
            self::REVIEW => 'Review Pimpinan',
            self::COMPLETED => 'Selesai',
            self::REJECTED => 'Ditolak',
            self::REVISION => 'Revisi',
        };
    }
}
