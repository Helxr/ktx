<?php

use App\Models\Lienhe;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('lienhe', 'trang_thai')) {
            Schema::table('lienhe', function (Blueprint $table) {
                $table->string('trang_thai', 30)
                    ->default(Lienhe::TRANG_THAI_CHUA_XU_LY)
                    ->after('noi_dung')
                    ->index();
            });
        }

        DB::table('lienhe')
            ->whereNull('trang_thai')
            ->update(['trang_thai' => Lienhe::TRANG_THAI_CHUA_XU_LY]);
    }

    public function down(): void
    {
        if (Schema::hasColumn('lienhe', 'trang_thai')) {
            Schema::table('lienhe', function (Blueprint $table) {
                $table->dropColumn('trang_thai');
            });
        }
    }
};

