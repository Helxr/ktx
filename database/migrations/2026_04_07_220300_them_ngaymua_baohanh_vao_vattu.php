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
        Schema::table('vattu', function (Blueprint $table) {
            $table->date('ngaymua')->nullable()->after('mota');
            $table->integer('thoigianbaohanh')->nullable()->after('ngaymua')->comment('Thoi gian bao hanh tinh bang thang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vattu', function (Blueprint $table) {
            $table->dropColumn(['ngaymua', 'thoigianbaohanh']);
        });
    }
};
