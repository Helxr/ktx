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
        Schema::table('dangky', function (Blueprint $table) {
            $table->string('so_dien_thoai_blind_index')->nullable()->index();
            $table->string('so_cccd_blind_index')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dangky', function (Blueprint $table) {
            $table->dropIndex(['so_dien_thoai_blind_index']);
            $table->dropIndex(['so_cccd_blind_index']);
            $table->dropColumn(['so_dien_thoai_blind_index', 'so_cccd_blind_index']);
        });
    }
};
