<?php

namespace App\Services\Core;

use App\Contracts\Core\TrangChuServiceInterface;
use App\Models\Cauhinh;
use App\Models\Lienhe;
use App\Models\Phong;
use App\Models\Thongbao;
use Illuminate\Support\Facades\DB;

class TrangChuService implements TrangChuServiceInterface
{
    public function layDuLieuTrangChu(): array
    {
        $phongList = Phong::all();
        $tongCho = $phongList->sum('dango');

        return [
            'tongPhong' => $phongList->count(),
            'tongCho' => $tongCho,
            'tongConTrong' => $phongList->sum('succhuamax') - $tongCho,
            'phongHoanToanTrong' => Phong::whereDoesntHave('danhsachsinhvien')->count(),
            'phongConCho' => Phong::whereColumn('dango', '<', 'succhuamax')->count(),
            'giaTrungBinh' => $phongList->avg('giaphong') ?? 1200000,
            'sinhVienDangO' => $tongCho,
            'soTang' => $phongList->pluck('tang')->unique()->count(),
            'phongList' => $phongList,
            'cauhinh' => Cauhinh::pluck('giatri', 'ten')->toArray(),
        ];
    }

    public function guiLienHe(array $data): bool
    {
        DB::transaction(function () use ($data) {
            Lienhe::create([...$data, 'trang_thai' => Lienhe::TRANG_THAI_CHUA_XU_LY]);
            Thongbao::create([
                'tieude' => 'Liên hệ mới từ landing page',
                'noidung' => "Họ tên: {$data['ho_ten']} | Email: {$data['email']} | Nội dung: {$data['noi_dung']}",
                'doituong' => 'admin',
                'ngaydang' => now(),
            ]);
        });
        return true;
    }
}
