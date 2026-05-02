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
        Schema::create('tbl_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('hanh_dong'); // create/update/delete
            $table->string('ten_model'); // Model name
            $table->unsignedBigInteger('id_ban_ghi'); // Record ID
            $table->json('du_lieu_cu')->nullable(); // Old data
            $table->json('du_lieu_moi')->nullable(); // New data
            $table->timestamps();
            
            $table->index(['ten_model', 'id_ban_ghi']);
            $table->index('user_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_logs');
    }
};
