<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('permohonans', function (Blueprint $table) {
            $table->string('file_surat_jawaban')->nullable()->after('sla_deadline');
            $table->string('nomor_surat_jawaban')->nullable()->after('file_surat_jawaban');
            $table->string('perihal_surat_jawaban')->nullable()->after('nomor_surat_jawaban');
            $table->date('tanggal_surat_jawaban')->nullable()->after('perihal_surat_jawaban');
        });

        Schema::table('permohonan_timelines', function (Blueprint $table) {
            $table->string('lampiran_file')->nullable()->after('catatan');
            $table->string('nama_lampiran')->nullable()->after('lampiran_file');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permohonans', function (Blueprint $table) {
            $table->dropColumn([
                'file_surat_jawaban',
                'nomor_surat_jawaban',
                'perihal_surat_jawaban',
                'tanggal_surat_jawaban'
            ]);
        });

        Schema::table('permohonan_timelines', function (Blueprint $table) {
            $table->dropColumn(['lampiran_file', 'nama_lampiran']);
        });
    }
};
