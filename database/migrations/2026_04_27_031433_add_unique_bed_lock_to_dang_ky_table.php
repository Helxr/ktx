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
            // MySQL trick: Create a virtual column that only has a value when registration is ACTIVE
            // This prevents duplicate active registrations for the same room-bed combination.
            $table->string('active_bed_lock')->nullable()
                ->virtualAs("IF(trangthai IN ('pending', 'approved_pending_payment'), CONCAT(phong_id, '-', giuong_no), NULL)")
                ->after('giuong_no');
            
            $table->unique('active_bed_lock', 'unique_active_registration_per_bed');
        });
    }

    public function down(): void
    {
        Schema::table('dangky', function (Blueprint $table) {
            $table->dropUnique('unique_active_registration_per_bed');
            $table->dropColumn('active_bed_lock');
        });
    }
};
