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
        Schema::create('hoadon', function (Blueprint $table) {
            $table->id();
            $table->foreignId('phong_id')->constrained('phong')->cascadeOnDelete();
            $table->unsignedTinyInteger('thang');
            $table->unsignedSmallInteger('nam');
            $table->unsignedInteger('chisodiencu')->default(0);
            $table->unsignedInteger('chisodienmoi')->default(0);
            $table->unsignedInteger('chisonuoccu')->default(0);
            $table->unsignedInteger('chisonuocmoi')->default(0);
            $table->unsignedInteger('tongtien')->default(0);
            $table->string('trangthaithanhtoan')->default('Chưa thanh toán');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hoadon');
    }
};
