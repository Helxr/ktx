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
        Schema::table('phong', function (Blueprint $table) {
            $table->unsignedTinyInteger('tang')->default(1)->after('tenphong')->comment('Tầng của phòng');
            $table->unsignedInteger('succhua')->default(0)->after('soluongtoida')->comment('Sức chứa hiện tại đang ở');
            $table->unsignedInteger('succhuamax')->default(8)->after('succhua')->comment('Sức chứa tối đa (thay thế soluongtoida)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('phong', function (Blueprint $table) {
            $table->dropColumn(['tang', 'succhua', 'succhuamax']);
        });
    }
};
