<?php

namespace Database\Seeders;

use App\Models\Phong;
use App\Models\Sinhvien;
use App\Models\User;
use Illuminate\Database\Seeder;

class SinhvienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $phongdau = Phong::all()->first();

        $sv1 = User::where('email', 'sv1@ktx.test')->first();
        $sv2 = User::where('email', 'sv2@ktx.test')->first();
        $sv3 = User::where('email', 'sv3@ktx.test')->first();
        $sv4 = User::where('email', 'sv4@ktx.test')->first();
        $sv5 = User::where('email', 'sv5@ktx.test')->first();

        if ($sv1) {
            Sinhvien::create([
                'user_id' => $sv1->id,
                'masinhvien' => 'sv0001',
                'lop' => 'ctk42',
                'sodienthoai' => '0900000001',
                'phong_id' => $phongdau?->id,
            ]);
        }

        if ($sv2) {
            Sinhvien::create([
                'user_id' => $sv2->id,
                'masinhvien' => 'sv0002',
                'lop' => 'ctk42',
                'sodienthoai' => '0900000002',
                'phong_id' => null,
            ]);
        }

        if ($sv3) {
            Sinhvien::create([
                'user_id' => $sv3->id,
                'masinhvien' => 'sv0003',
                'lop' => 'ctk43',
                'sodienthoai' => '0900000003',
                'phong_id' => null,
            ]);
        }

        if ($sv4) {
            Sinhvien::create([
                'user_id' => $sv4->id,
                'masinhvien' => 'sv0004',
                'lop' => 'ctk43',
                'sodienthoai' => '0900000004',
                'phong_id' => null,
            ]);
        }

        if ($sv5) {
            Sinhvien::create([
                'user_id' => $sv5->id,
                'masinhvien' => 'sv0005',
                'lop' => 'ctk44',
                'sodienthoai' => '0900000005',
                'phong_id' => null,
            ]);
        }
    }
}
