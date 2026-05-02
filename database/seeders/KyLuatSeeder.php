<?php

namespace Database\Seeders;

use App\Models\Kyluat;
use App\Models\Sinhvien;
use App\Enums\DisciplineLevel;
use Illuminate\Database\Seeder;

class KyLuatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sinhVien = Sinhvien::first();

        if ($sinhVien) {
            Kyluat::create([
                'sinhvien_id' => $sinhVien->id,
                'noidung' => 'Sử dụng thiết bị điện công suất lớn trái quy định (Bếp điện)',
                'ngayvipham' => now()->subDays(5),
                'mucdo' => DisciplineLevel::Medium->value,
            ]);

            Kyluat::create([
                'sinhvien_id' => $sinhVien->id,
                'noidung' => 'Về muộn sau 23h không có lý do chính đáng',
                'ngayvipham' => now()->subDays(2),
                'mucdo' => DisciplineLevel::Low->value,
            ]);
        }
    }
}
