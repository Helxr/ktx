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
        $dangky = Dangky::create([
            'ho_ten' => 'Nguyễn Văn A',
            'email' => 'nguyenvana@example.com',
            'so_dien_thoai' => '0912345678',
            'so_cccd' => '123456789',
            'phong_id' => 1,
            'trang_thai' => 'cho_xu_ly',
            'loai_dang_ky' => 'guest',
            'lookup_token' => 'test-token',
        ]);

        $this->assertNotNull($dangky->so_dien_thoai_blind_index);
        $this->assertNotNull($dangky->so_cccd_blind_index);
        $this->assertEquals(hash('sha256', '0912345678'), $dangky->so_dien_thoai_blind_index);
        $this->assertEquals(hash('sha256', '123456789'), $dangky->so_cccd_blind_index);
    }

    public function test_tim_kiem_bang_so_dien_thoai_tren_du_lieu_ma_hoa()
    {
        // Tạo dữ liệu test
        Dangky::create([
            'ho_ten' => 'Nguyễn Văn A',
            'email' => 'nguyenvana@example.com',
            'so_dien_thoai' => '0912345678',
            'so_cccd' => '123456789',
            'phong_id' => 1,
            'trang_thai' => 'cho_xu_ly',
            'loai_dang_ky' => 'guest',
            'lookup_token' => 'test-token-1',
        ]);

        Dangky::create([
            'ho_ten' => 'Trần Thị B',
            'email' => 'tranthib@example.com',
            'so_dien_thoai' => '0987654321',
            'so_cccd' => '987654321',
            'phong_id' => 2,
            'trang_thai' => 'cho_xu_ly',
            'loai_dang_ky' => 'guest',
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
