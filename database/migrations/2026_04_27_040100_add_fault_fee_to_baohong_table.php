<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Thêm:
     *   - do_sinh_vien_gay_ra: Admin đánh dấu lỗi do SV gây ra
     *   - phi_boi_thuong: Mức phí bồi thường (VNĐ)
     */
    public function up(): void
    {
        Schema::table('baohong', function (Blueprint $table) {
            $table->boolean('do_sinh_vien_gay_ra')->default(false)->after('noidung');
            $table->unsignedBigInteger('phi_boi_thuong')->nullable()->after('do_sinh_vien_gay_ra');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('baohong', function (Blueprint $table) {
            $table->dropColumn(['do_sinh_vien_gay_ra', 'phi_boi_thuong']);
        });
    }
};
