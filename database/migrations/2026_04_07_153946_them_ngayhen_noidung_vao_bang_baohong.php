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
        Schema::table('baohong', function (Blueprint $table) {
            $table->date('ngayhen')->nullable()->after('trangthai')->comment('Ngày hẹn sửa chữa');
            $table->text('noidung')->nullable()->after('ngayhen')->comment('Nội dung chi tiết sửa chữa');
            $table->string('trangthai')->default('Cho sua')->change()->comment('Trang thai: Cho sua, Da hen, Dang sua, Hoan thanh');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('baohong', function (Blueprint $table) {
            $table->dropColumn(['ngayhen', 'noidung']);
        });
    }
};
