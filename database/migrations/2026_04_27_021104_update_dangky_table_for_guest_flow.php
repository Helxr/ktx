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
        Schema::table('dangky', function (Blueprint $table) {
            $table->foreignId('sinhvien_id')->nullable()->change();
            
            // Guest PII (Encrypted)
            $table->text('ho_ten')->nullable()->after('sinhvien_id');
            $table->text('email')->nullable()->after('ho_ten');
            $table->text('so_dien_thoai')->nullable()->after('email');
            $table->text('so_cccd')->nullable()->after('so_dien_thoai');
            
            // Assets
            $table->string('anh_the_path')->nullable()->after('so_cccd');
            $table->string('anh_cccd_path')->nullable()->after('anh_the_path');
            
            // Logistics
            $table->string('lookup_token')->nullable()->unique()->after('anh_cccd_path');
            $table->integer('giuong_no')->nullable()->after('phong_id');
            $table->timestamp('expires_at')->nullable()->after('ghichu');
        });
    }

    public function down(): void
    {
        Schema::table('dangky', function (Blueprint $table) {
            $table->foreignId('sinhvien_id')->nullable(false)->change();
            $table->dropColumn([
                'ho_ten',
                'email',
                'so_dien_thoai',
                'so_cccd',
                'anh_the_path',
                'anh_cccd_path',
                'lookup_token',
                'giuong_no',
                'expires_at'
            ]);
        });
    }
};
