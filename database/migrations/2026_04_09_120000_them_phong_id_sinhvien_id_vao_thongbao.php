<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('thongbao', function (Blueprint $table) {
            if (! Schema::hasColumn('thongbao', 'phong_id')) {
                $table->foreignId('phong_id')->nullable()->after('doituong')->constrained('phong')->nullOnDelete();
            }

            if (! Schema::hasColumn('thongbao', 'sinhvien_id')) {
                $table->foreignId('sinhvien_id')->nullable()->after('phong_id')->constrained('sinhvien')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('thongbao', function (Blueprint $table) {
            if (Schema::hasColumn('thongbao', 'sinhvien_id')) {
                $table->dropConstrainedForeignId('sinhvien_id');
            }

            if (Schema::hasColumn('thongbao', 'phong_id')) {
                $table->dropConstrainedForeignId('phong_id');
            }
        });
    }
};
