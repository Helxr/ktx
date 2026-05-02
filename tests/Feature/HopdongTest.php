<?php

namespace Tests\Feature;

use App\Models\Dangky;
use App\Models\Hopdong;
use App\Models\Phong;
use App\Models\Sinhvien;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HopdongTest extends TestCase
{
    use RefreshDatabase;

    private function taoAdmin(): User
    {
        return User::factory()->create([
            'name' => 'Admin Test',
            'email' => 'admin@example.com',
            'vaitro' => 'admin',
            'gioitinh' => 'Nam',
        ]);
    }

    private function taoSinhVienVaPhong(): array
    {
        $phong = Phong::create([
            'tenphong' => 'A101',
            'giaphong' => 2000000,
            'soluongtoida' => 4,
            'mota' => 'Phòng test',
            'gioitinh' => 'Nam',
        ]);

        $user = User::factory()->create([
            'name' => 'SV Test',
            'email' => 'svtest@example.com',
            'vaitro' => 'sinhvien',
            'gioitinh' => 'Nam',
        ]);

        $sinhvien = Sinhvien::create([
            'user_id' => $user->id,
            'masinhvien' => 'SV001',
            'lop' => 'CNTT1',
            'sodienthoai' => '0123456789',
            'phong_id' => null,
        ]);

        return compact('phong', 'sinhvien', 'user');
    }

    public function test_admin_duyet_dangky_tao_hopdong()
    {
        $admin = $this->taoAdmin();
        $data = $this->taoSinhVienVaPhong();

        Dangky::create([
            'sinhvien_id' => $data['sinhvien']->id,
            'phong_id' => $data['phong']->id,
            'loaidangky' => Dangky::LOAI_THUE_PHONG,
            'trangthai' => Dangky::TRANGTHAI_CHO_XU_LY,
            'ghichu' => null,
        ]);

        $ngayHetHan = now()->addMonths(6)->format('Y-m-d');

        $response = $this->actingAs($admin)->post(route('admin.xulyduyetdangky', 1), ['ngay_het_han' => $ngayHetHan]);

        $response->assertRedirect();

        $this->assertDatabaseHas('hopdong', [
            'sinhvien_id' => $data['sinhvien']->id,
            'phong_id' => $data['phong']->id,
            'trang_thai' => Hopdong::TRANGTHAI_DANG_HIEU_LUC,
        ]);

        $this->assertDatabaseHas('sinhvien', [
            'id' => $data['sinhvien']->id,
            'phong_id' => $data['phong']->id,
            'ngay_het_han' => $ngayHetHan,
        ]);
    }

    public function test_admin_giahan_hopdong()
    {
        $admin = $this->taoAdmin();
        $data = $this->taoSinhVienVaPhong();

        $hopdong = Hopdong::create([
            'sinhvien_id' => $data['sinhvien']->id,
            'phong_id' => $data['phong']->id,
            'ngay_bat_dau' => now()->format('Y-m-d'),
            'ngay_ket_thuc' => now()->addMonths(3)->format('Y-m-d'),
            'giaphong_luc_ky' => 2000000,
            'trang_thai' => Hopdong::TRANGTHAI_DANG_HIEU_LUC,
        ]);

        $data['sinhvien']->update(['phong_id' => $data['phong']->id]);

        $ngayKetThucMoi = now()->addMonths(5)->format('Y-m-d');

        $response = $this->actingAs($admin)->post(route('admin.hopdong.giahan', $hopdong->id), ['ngay_ket_thuc' => $ngayKetThucMoi]);
        $response->assertRedirect();

        $this->assertDatabaseHas('hopdong', [
            'id' => $hopdong->id,
            'ngay_ket_thuc' => $ngayKetThucMoi,
        ]);
        $this->assertDatabaseHas('sinhvien', [
            'id' => $data['sinhvien']->id,
            'ngay_het_han' => $ngayKetThucMoi,
        ]);
    }

    public function test_admin_thanhly_hopdong_va_giai_phong()
    {
        $admin = $this->taoAdmin();
        $data = $this->taoSinhVienVaPhong();

        $hopdong = Hopdong::create([
            'sinhvien_id' => $data['sinhvien']->id,
            'phong_id' => $data['phong']->id,
            'ngay_bat_dau' => now()->subMonths(3)->format('Y-m-d'),
            'ngay_ket_thuc' => now()->addMonths(2)->format('Y-m-d'),
            'giaphong_luc_ky' => 2000000,
            'trang_thai' => Hopdong::TRANGTHAI_DANG_HIEU_LUC,
        ]);
        $data['sinhvien']->update(['phong_id' => $data['phong']->id, 'ngay_vao' => now()->subMonths(3)->format('Y-m-d'), 'ngay_het_han' => now()->addMonths(2)->format('Y-m-d')]);

        $response = $this->actingAs($admin)->post(route('admin.hopdong.thanhly', $hopdong->id));
        $response->assertRedirect();

        $this->assertDatabaseHas('hopdong', [
            'id' => $hopdong->id,
            'trang_thai' => Hopdong::TRANGTHAI_DA_THANH_LY,
        ]);

        $this->assertDatabaseHas('sinhvien', [
            'id' => $data['sinhvien']->id,
            'phong_id' => null,
            'ngay_vao' => null,
            'ngay_het_han' => null,
        ]);
    }

    public function test_admin_chuyen_phong_cap_nhat_hopdong_da_thanh_ly()
    {
        $admin = $this->taoAdmin();
        $data = $this->taoSinhVienVaPhong();

        $phong2 = Phong::create([
            'tenphong' => 'A102',
            'giaphong' => 2300000,
            'soluongtoida' => 4,
            'mota' => 'Phòng test 2',
            'gioitinh' => 'Nam',
        ]);

        $hopdong = Hopdong::create([
            'sinhvien_id' => $data['sinhvien']->id,
            'phong_id' => $data['phong']->id,
            'ngay_bat_dau' => now()->subMonths(3)->format('Y-m-d'),
            'ngay_ket_thuc' => now()->addMonths(2)->format('Y-m-d'),
            'giaphong_luc_ky' => 2000000,
            'trang_thai' => Hopdong::TRANGTHAI_DANG_HIEU_LUC,
        ]);

        $data['sinhvien']->update(['phong_id' => $data['phong']->id]);

        $response = $this->actingAs($admin)->post(route('admin.chuyenphong', $data['sinhvien']->id), ['phong_id' => $phong2->id]);
        $response->assertRedirect();

        $this->assertDatabaseHas('hopdong', [
            'id' => $hopdong->id,
            'trang_thai' => Hopdong::TRANGTHAI_DA_THANH_LY,
        ]);

        $this->assertDatabaseHas('sinhvien', [
            'id' => $data['sinhvien']->id,
            'phong_id' => $phong2->id,
        ]);
    }
}
