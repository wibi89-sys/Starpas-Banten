<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('app_settings', function (Blueprint $table) {
            $table->boolean('whatsapp_notif_enabled')->default(false)->after('warna_tema');
            $table->string('fonnte_token')->nullable()->after('whatsapp_notif_enabled');
        });
    }

    public function down(): void
    {
        Schema::table('app_settings', function (Blueprint $table) {
            $table->dropColumn(['whatsapp_notif_enabled', 'fonnte_token']);
        });
    }
};
