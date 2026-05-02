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
        Schema::create('baohong', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sinhvien_id')->constrained('sinhvien')->cascadeOnDelete();
            $table->foreignId('phong_id')->constrained('phong')->cascadeOnDelete();
            $table->text('mota');
            $table->string('anhminhhoa')->nullable();
            $table->string('trangthai')->default('Chờ sửa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baohong');
    }
};
