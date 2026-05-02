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
        Schema::table('phong', function (Blueprint $table) {
            $table->string('gioitinh')->default('Nam')->after('mota');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('gioitinh')->default('Nam')->after('email');
        });

        Schema::table('sinhvien', function (Blueprint $table) {
            $table->date('ngay_vao')->nullable()->after('lop');
            $table->date('ngay_het_han')->nullable()->after('ngay_vao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('phong', function (Blueprint $table) {
            $table->dropColumn('gioitinh');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('gioitinh');
        });

        Schema::table('sinhvien', function (Blueprint $table) {
            $table->dropColumn(['ngay_vao', 'ngay_het_han']);
        });
    }
};
