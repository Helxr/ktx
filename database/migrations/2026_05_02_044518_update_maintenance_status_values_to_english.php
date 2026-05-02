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
        DB::table('baohong')->where('trangthai', 'Chờ sửa')->update(['trangthai' => 'pending']);
        DB::table('baohong')->where('trangthai', 'Đã hẹn')->update(['trangthai' => 'scheduled']);
        DB::table('baohong')->where('trangthai', 'Đang sửa')->update(['trangthai' => 'in_progress']);
        DB::table('baohong')->where('trangthai', 'Đã xong')->update(['trangthai' => 'completed']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('baohong')->where('trangthai', 'pending')->update(['trangthai' => 'Chờ sửa']);
        DB::table('baohong')->where('trangthai', 'scheduled')->update(['trangthai' => 'Đã hẹn']);
        DB::table('baohong')->where('trangthai', 'in_progress')->update(['trangthai' => 'Đang sửa']);
        DB::table('baohong')->where('trangthai', 'completed')->update(['trangthai' => 'Đã xong']);
    }
};
