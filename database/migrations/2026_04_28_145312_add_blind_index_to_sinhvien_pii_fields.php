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
        Schema::table('sinhvien', function (Blueprint $table) {
            $table->string('sodienthoai_blind_index')->nullable()->index();
            $table->string('so_cccd_blind_index')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sinhvien', function (Blueprint $table) {
            $table->dropIndex(['sodienthoai_blind_index']);
            $table->dropIndex(['so_cccd_blind_index']);
            $table->dropColumn(['sodienthoai_blind_index', 'so_cccd_blind_index']);
        });
    }
};
