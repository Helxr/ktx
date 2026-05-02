<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('phong', function (Blueprint $table) {
            if (Schema::hasColumn('phong', 'succhua')) {
                $table->dropColumn('succhua');
            }
        });
    }

    public function down(): void
    {
        Schema::table('phong', function (Blueprint $table) {
            if (! Schema::hasColumn('phong', 'succhua')) {
                $table->unsignedInteger('succhua')
                    ->default(0)
                    ->after('soluongtoida')
                    ->comment('Suc chua hien tai dang o');
            }
        });
    }
};

