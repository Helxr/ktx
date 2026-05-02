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
        Schema::create('danhgia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sinhvien_id')->constrained('sinhvien')->onDelete('cascade');
            $table->foreignId('phong_id')->constrained('phong')->onDelete('cascade');
            $table->tinyInteger('diem')->unsigned()->comment('Diem danh gia 1-5');
            $table->text('noidung')->nullable();
            $table->date('ngaydanhgia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('danhgia');
    }
};
