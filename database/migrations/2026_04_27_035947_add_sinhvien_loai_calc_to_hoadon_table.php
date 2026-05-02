<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Thêm:
     *   - sinhvien_id: cho hóa đơn cá nhân (deposit, phí bồi thường)
     *   - loai_hoadon: phân loại hóa đơn
     *   - calculation_details: JSON lưu công thức tính toán để giải trình
     */
    public function up(): void
    {
        Schema::table('hoadon', function (Blueprint $table) {
            $table->unsignedBigInteger('sinhvien_id')->nullable()->after('phong_id');
            $table->string('loai_hoadon', 50)->default('monthly')->after('sinhvien_id');
            $table->json('calculation_details')->nullable()->after('tongtien');

            $table->foreign('sinhvien_id')
                  ->references('id')
                  ->on('sinhvien')
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hoadon', function (Blueprint $table) {
            $table->dropForeign(['sinhvien_id']);
            $table->dropColumn(['sinhvien_id', 'loai_hoadon', 'calculation_details']);
        });
    }
};
