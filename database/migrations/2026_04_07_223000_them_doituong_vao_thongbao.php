<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('thongbao', 'doituong')) {
            Schema::table('thongbao', function (Blueprint $table) {
                $table->enum('doituong', ['sinhvien', 'admin', 'tatca'])->default('tatca')->after('noidung');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('thongbao', 'doituong')) {
            Schema::table('thongbao', function (Blueprint $table) {
                $table->dropColumn('doituong');
            });
        }
    }
};
