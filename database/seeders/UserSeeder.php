<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@ktx.test',
            'password' => Hash::make('12345678'),
            'vaitro' => 'admin',
            'gioitinh' => 'Nam',
        ]);

        User::create([
            'name' => 'sinhvien 1',
            'email' => 'sv1@ktx.test',
            'password' => Hash::make('12345678'),
            'vaitro' => 'sinhvien',
            'gioitinh' => 'Nam',
        ]);
        User::create([
            'name' => 'sinhvien 2',
            'email' => 'sv2@ktx.test',
            'password' => Hash::make('12345678'),
            'vaitro' => 'sinhvien',
            'gioitinh' => 'Nữ',
        ]);
        User::create([
            'name' => 'sinhvien 3',
            'email' => 'sv3@ktx.test',
            'password' => Hash::make('12345678'),
            'vaitro' => 'sinhvien',
            'gioitinh' => 'Nam',
        ]);
        User::create([
            'name' => 'sinhvien 4',
            'email' => 'sv4@ktx.test',
            'password' => Hash::make('12345678'),
            'vaitro' => 'sinhvien',
            'gioitinh' => 'Nữ',
        ]);
        User::create([
            'name' => 'sinhvien 5',
            'email' => 'sv5@ktx.test',
            'password' => Hash::make('12345678'),
            'vaitro' => 'sinhvien',
            'gioitinh' => 'Nam',
        ]);
    }
}
