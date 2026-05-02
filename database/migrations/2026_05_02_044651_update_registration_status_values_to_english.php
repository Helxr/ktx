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
        DB::table('dangky')->where('trangthai', 'Chờ xử lý')->update(['trangthai' => 'pending']);
        DB::table('dangky')->where('trangthai', 'Chờ thanh toán')->update(['trangthai' => 'approved_pending_payment']);
        DB::table('dangky')->where('trangthai', 'Đã duyệt')->update(['trangthai' => 'approved']);
        DB::table('dangky')->where('trangthai', 'Hoàn tất')->update(['trangthai' => 'completed']);
        DB::table('dangky')->where('trangthai', 'Từ chối')->update(['trangthai' => 'rejected']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('dangky')->where('trangthai', 'pending')->update(['trangthai' => 'Chờ xử lý']);
        DB::table('dangky')->where('trangthai', 'approved_pending_payment')->update(['trangthai' => 'Chờ thanh toán']);
        DB::table('dangky')->where('trangthai', 'approved')->update(['trangthai' => 'Đã duyệt']);
        DB::table('dangky')->where('trangthai', 'completed')->update(['trangthai' => 'Hoàn tất']);
        DB::table('dangky')->where('trangthai', 'rejected')->update(['trangthai' => 'Từ chối']);
    }
};
