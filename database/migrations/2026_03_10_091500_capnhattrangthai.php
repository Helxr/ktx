<?php

use App\Enums\RegistrationStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Chuyen cac gia tri trang thai cu (khong dau) sang tieng Viet co dau.
     */
    public function up(): void
    {
        // Dang ky
        DB::table('dangky')->where('trangthai', 'choxuly')->update(['trangthai' => RegistrationStatus::Pending->value]);
        DB::table('dangky')->where('trangthai', 'duyet')->update(['trangthai' => RegistrationStatus::Approved->value]);
        DB::table('dangky')->where('trangthai', 'tuchoi')->update(['trangthai' => RegistrationStatus::Rejected->value]);

        // Hoa don
        DB::table('hoadon')->where('trangthaithanhtoan', 'chuathanhtoan')->update(['trangthaithanhtoan' => 'Chưa thanh toán']);
        DB::table('hoadon')->where('trangthaithanhtoan', 'dathanhtoan')->update(['trangthaithanhtoan' => 'Đã thanh toán']);

        // Bao hong
        DB::table('baohong')->where('trangthai', 'chosua')->update(['trangthai' => 'Chờ sửa']);
        DB::table('baohong')->where('trangthai', 'daxong')->update(['trangthai' => 'Đã xong']);

        DB::statement("ALTER TABLE `dangky` MODIFY `trangthai` VARCHAR(255) NOT NULL DEFAULT '" . RegistrationStatus::Pending->value . "'");
        DB::statement("ALTER TABLE `hoadon` MODIFY `trangthaithanhtoan` VARCHAR(255) NOT NULL DEFAULT 'Chưa thanh toán'");
        DB::statement("ALTER TABLE `baohong` MODIFY `trangthai` VARCHAR(255) NOT NULL DEFAULT 'Chờ sửa'");
    }

    /**
     * Rollback ve gia tri cu (khong dau).
     */
    public function down(): void
    {
        DB::table('dangky')->where('trangthai', RegistrationStatus::Pending->value)->update(['trangthai' => 'choxuly']);
        DB::table('dangky')->where('trangthai', RegistrationStatus::Approved->value)->update(['trangthai' => 'duyet']);
        DB::table('dangky')->where('trangthai', RegistrationStatus::Rejected->value)->update(['trangthai' => 'tuchoi']);

        DB::table('hoadon')->where('trangthaithanhtoan', 'Chưa thanh toán')->update(['trangthaithanhtoan' => 'chuathanhtoan']);
        DB::table('hoadon')->where('trangthaithanhtoan', 'Đã thanh toán')->update(['trangthaithanhtoan' => 'dathanhtoan']);

        DB::table('baohong')->where('trangthai', 'Chờ sửa')->update(['trangthai' => 'chosua']);
        DB::table('baohong')->where('trangthai', 'Đã xong')->update(['trangthai' => 'daxong']);

        DB::statement("ALTER TABLE `dangky` MODIFY `trangthai` VARCHAR(255) NOT NULL DEFAULT 'choxuly'");
        DB::statement("ALTER TABLE `hoadon` MODIFY `trangthaithanhtoan` VARCHAR(255) NOT NULL DEFAULT 'chuathanhtoan'");
        DB::statement("ALTER TABLE `baohong` MODIFY `trangthai` VARCHAR(255) NOT NULL DEFAULT 'chosua'");
    }
};

