<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('hoadon')->where('trangthaithanhtoan', 'Chờ xác nhận')->update(['trangthaithanhtoan' => 'pending_confirmation']);
        DB::table('hoadon')->where('trangthaithanhtoan', 'Chưa thanh toán')->update(['trangthaithanhtoan' => 'pending']);
        DB::table('hoadon')->where('trangthaithanhtoan', 'Đã thanh toán')->update(['trangthaithanhtoan' => 'paid']);
        DB::table('hoadon')->where('trangthaithanhtoan', 'Quá hạn')->update(['trangthaithanhtoan' => 'overdue']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('hoadon')->where('trangthaithanhtoan', 'pending_confirmation')->update(['trangthaithanhtoan' => 'Chờ xác nhận']);
        DB::table('hoadon')->where('trangthaithanhtoan', 'pending')->update(['trangthaithanhtoan' => 'Chưa thanh toán']);
        DB::table('hoadon')->where('trangthaithanhtoan', 'paid')->update(['trangthaithanhtoan' => 'Đã thanh toán']);
        DB::table('hoadon')->where('trangthaithanhtoan', 'overdue')->update(['trangthaithanhtoan' => 'Quá hạn']);
    }
};
