<?php

namespace Database\Seeders;

use App\Models\Phong;
use Illuminate\Database\Seeder;

class PhongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Phong::create([
            'tenphong' => 'a101',
            'tang' => 1,
            'giaphong' => 800000,
            'soluongtoida' => 8,
            'succhuamax' => 8,
            'dango' => 0,
            'mota' => 'Phòng tiêu chuẩn',
            'gioitinh' => 'Nam',
        ]);
        Phong::create([
            'tenphong' => 'a102',
            'tang' => 1,
            'giaphong' => 800000,
            'soluongtoida' => 8,
            'succhuamax' => 8,
            'dango' => 0,
            'mota' => 'Phòng tiêu chuẩn',
            'gioitinh' => 'Nữ',
        ]);
        Phong::create([
            'tenphong' => 'a103',
            'tang' => 1,
            'giaphong' => 850000,
            'soluongtoida' => 8,
            'succhuamax' => 8,
            'dango' => 0,
            'mota' => 'Phòng có cửa sổ lớn',
            'gioitinh' => 'Nam',
        ]);
        Phong::create([
            'tenphong' => 'a104',
            'tang' => 1,
            'giaphong' => 850000,
            'soluongtoida' => 8,
            'succhuamax' => 8,
            'dango' => 0,
            'mota' => 'Phòng có cửa sổ lớn',
            'gioitinh' => 'Nữ',
        ]);
        Phong::create([
            'tenphong' => 'b201',
            'tang' => 2,
            'giaphong' => 900000,
            'soluongtoida' => 8,
            'succhuamax' => 8,
            'dango' => 0,
            'mota' => 'Phòng 8 người',
            'gioitinh' => 'Nam',
        ]);
        Phong::create([
            'tenphong' => 'b202',
            'tang' => 2,
            'giaphong' => 900000,
            'soluongtoida' => 8,
            'succhuamax' => 8,
            'dango' => 0,
            'mota' => 'Phòng 8 người',
            'gioitinh' => 'Nữ',
        ]);
        Phong::create([
            'tenphong' => 'b203',
            'tang' => 2,
            'giaphong' => 950000,
            'soluongtoida' => 8,
            'succhuamax' => 8,
            'dango' => 0,
            'mota' => 'Phòng thoáng',
            'gioitinh' => 'Nam',
        ]);
        Phong::create([
            'tenphong' => 'c301',
            'tang' => 3,
            'giaphong' => 1000000,
            'soluongtoida' => 8,
            'succhuamax' => 8,
            'dango' => 0,
            'mota' => 'Phòng 8 người',
            'gioitinh' => 'Nữ',
        ]);
        Phong::create([
            'tenphong' => 'c302',
            'tang' => 3,
            'giaphong' => 1000000,
            'soluongtoida' => 8,
            'succhuamax' => 8,
            'dango' => 0,
            'mota' => 'Phòng 8 người',
            'gioitinh' => 'Nam',
        ]);
        Phong::create([
            'tenphong' => 'c303',
            'tang' => 3,
            'giaphong' => 1100000,
            'soluongtoida' => 8,
            'succhuamax' => 8,
            'dango' => 0,
            'mota' => 'Phòng 8 người, gần cầu thang',
            'gioitinh' => 'Nữ',
        ]);
    }
}
