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
        if (!Schema::hasColumn('kyluat', 'mucdo')) {
            Schema::table('kyluat', function (Blueprint $table) {
                $table->enum('mucdo', ['Nhe', 'Trung binh', 'Nang'])->default('Nhe')->after('noidung');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('kyluat', 'mucdo')) {
            Schema::table('kyluat', function (Blueprint $table) {
                $table->dropColumn('mucdo');
            });
        }
    }
};
