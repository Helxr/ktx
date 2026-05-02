<?php

namespace Tests\Unit;

use App\Models\Dangky;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlindIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_blind_index_tao_tu_dong_khi_luu_dangky()
    {
        $phong = \App\Models\Phong::create(['tenphong' => 'P101', 'giaphong' => 1000, 'soluongtoida' => 4, 'gioitinh' => 'Nam']);
        $dangky = Dangky::create([
            'ho_ten' => 'Nguyễn Văn A',
            'email' => 'nguyenvana@example.com',
            'so_dien_thoai' => '0912345678',
            'so_cccd' => '123456789',
            'phong_id' => $phong->id,
            'trangthai' => \App\Enums\RegistrationStatus::Pending,
            'loaidangky' => \App\Enums\RegistrationType::Rental,
            'lookup_token' => 'test-token',
        ]);

        $this->assertNotNull($dangky->so_dien_thoai_blind_index);
        $this->assertNotNull($dangky->so_cccd_blind_index);
        $this->assertEquals(hash('sha256', '0912345678'), $dangky->so_dien_thoai_blind_index);
        $this->assertEquals(hash('sha256', '123456789'), $dangky->so_cccd_blind_index);
    }

    public function test_tim_kiem_bang_so_dien_thoai_tren_du_lieu_ma_hoa()
    {
        $phong1 = \App\Models\Phong::create(['tenphong' => 'P101', 'giaphong' => 1000, 'soluongtoida' => 4, 'gioitinh' => 'Nam']);
        $phong2 = \App\Models\Phong::create(['tenphong' => 'P102', 'giaphong' => 1000, 'soluongtoida' => 4, 'gioitinh' => 'Nam']);
        // Tạo dữ liệu test
        Dangky::create([
            'ho_ten' => 'Nguyễn Văn A',
            'email' => 'nguyenvana@example.com',
            'so_dien_thoai' => '0912345678',
            'so_cccd' => '123456789',
            'phong_id' => $phong1->id,
            'trangthai' => \App\Enums\RegistrationStatus::Pending,
            'loaidangky' => \App\Enums\RegistrationType::Rental,
            'lookup_token' => 'test-token-1',
        ]);

        Dangky::create([
            'ho_ten' => 'Trần Thị B',
            'email' => 'tranthib@example.com',
            'so_dien_thoai' => '0987654321',
            'so_cccd' => '987654321',
            'phong_id' => $phong2->id,
            'trangthai' => \App\Enums\RegistrationStatus::Pending,
            'loaidangky' => \App\Enums\RegistrationType::Rental,
            'lookup_token' => 'test-token-2',
        ]);

        // Tìm kiếm bằng SĐT
        $result = Dangky::findBySoDienThoai('0912345678')->first();

        $this->assertNotNull($result);
        $this->assertEquals('Nguyễn Văn A', $result->ho_ten);
        $this->assertEquals('0912345678', $result->so_dien_thoai);

        // Tìm kiếm bằng CCCD
        $resultCccd = Dangky::findBySoCccd('987654321')->first();

        $this->assertNotNull($resultCccd);
        $this->assertEquals('Trần Thị B', $resultCccd->ho_ten);
        $this->assertEquals('987654321', $resultCccd->so_cccd);
    }
}
