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
        Schema::create('vattu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('phong_id')->constrained('phong')->cascadeOnDelete()->comment('Phòng chứa vật tư');
            $table->string('tenvattu')->comment('Tên vật tư: Giuong, Tu, May lanh...');
            $table->unsignedInteger('soluong')->default(1)->comment('Số lượng vật tư');
            $table->string('tinhtrang')->default('Hoat dong tot')->comment('Tình trạng: Hoat dong tot, Can sua, Can thay');
            $table->text('mota')->nullable()->comment('Mô tả chi tiết');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vattu');
    }
};
