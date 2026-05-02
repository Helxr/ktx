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
        Schema::table('hoadon', function (Blueprint $table) {
            // Thêm các cột tài chính tách biệt
            $table->unsignedInteger('tienphong')->default(0)->after('chisonuocmoi')->comment('Tiền phòng cố định');
            $table->unsignedInteger('tiendien')->default(0)->after('tienphong')->comment('Tiền điện (theo chỉ số)');
            $table->unsignedInteger('tiennuoc')->default(0)->after('tiendien')->comment('Tiền nước (theo chỉ số)');
            $table->unsignedInteger('phidichvu')->default(0)->after('tiennuoc')->comment('Phí dịch vụ khác');
        });

        // Cập nhật dữ liệu cũ từ tongtien sang tienphong (giả định tất cả là tiền phòng)
        DB::statement('UPDATE hoadon SET tienphong = tongtien WHERE tongtien > 0');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hoadon', function (Blueprint $table) {
            $table->dropColumn(['tienphong', 'tiendien', 'tiennuoc', 'phidichvu']);
        });
    }
};
