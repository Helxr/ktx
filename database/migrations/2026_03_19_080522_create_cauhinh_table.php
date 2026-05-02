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
        Schema::create('cauhinh', function (Blueprint $table) {
            $table->id();
            $table->string('ten')->unique();
            $table->string('giatri');
            $table->timestamps();
        });

        // Nạp config mặc định
        DB::table('cauhinh')->insert([
            ['ten' => 'gia_dien', 'giatri' => '3500', 'created_at' => now(), 'updated_at' => now()],
            ['ten' => 'gia_nuoc', 'giatri' => '15000', 'created_at' => now(), 'updated_at' => now()],
            ['ten' => 'hotline', 'giatri' => '0900000000', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cauhinh');
    }
};
