<?php

namespace App\Services\Student;

use App\Contracts\Student\PhongSinhvienServiceInterface;
use App\Models\Danhgia;
use App\Models\Hoadon;
use App\Models\Hopdong;
use App\Models\Phong;
use App\Models\Sinhvien;
use App\Models\Taisan;
use App\Models\Thongbao;
use App\Models\Vattu;
use Illuminate\Support\Facades\Auth;

class PhongSinhvienService implements PhongSinhvienServiceInterface
{
    public function layThongTinPhongToi(): array
    {
        $sinhvien = Sinhvien::where('user_id', Auth::id())->with(['taikhoan', 'phong'])->first();
        if (!$sinhvien) return ['error' => 'Không tìm thấy thông tin sinh viên.'];

        if (!$sinhvien->phong_id) {
            return [
                'sinhvien' => $sinhvien,
                'coPhong' => false,
                'danhsachphongtrong' => $this->layDanhSachPhongPhuHop($sinhvien),
            ];
        }

        $phong = Phong::with(['danhsachtaisan', 'danhsachvattu'])->find($sinhvien->phong_id);
        $banCungPhong = Sinhvien::where('phong_id', $sinhvien->phong_id)->where('id', '<>', $sinhvien->id)->with('taikhoan')->get();
        $hopdong = Hopdong::where('sinhvien_id', $sinhvien->id)->where('trang_thai', Hopdong::trangThaiDangHieuLuc())->first();
        $hoadon = Hoadon::where('phong_id', $sinhvien->phong_id)->where('trangthaithanhtoan', Hoadon::trangThaiChuaThanhToan())->orderByDesc('created_at')->get();

        return [
            'sinhvien' => $sinhvien, 'coPhong' => true, 'phong' => $phong, 'banCungPhong' => $banCungPhong,
            'hopdongHienTai' => $hopdong, 'hoadonChuaThanhToan' => $hoadon, 'tongNo' => $hoadon->sum('tongtien'),
            'taisan' => Taisan::where('phong_id', $sinhvien->phong_id)->get(),
            'vattu' => Vattu::where('phong_id', $sinhvien->phong_id)->get(),
            'daDanhGia' => Danhgia::where('sinhvien_id', $sinhvien->id)->where('phong_id', $sinhvien->phong_id)->whereYear('ngaydanhgia', now()->year)->whereMonth('ngaydanhgia', now()->month)->exists(),
            'diemTrungBinh' => round(Danhgia::where('phong_id', $sinhvien->phong_id)->avg('diem') ?? 0, 1),
            'thongbaoMoiNhat' => Thongbao::where('doituong', 'sinhvien')->orWhereNull('doituong')->orderByDesc('ngaydang')->limit(5)->get(),
            'canhBaoHetHan' => $this->layCanhBaoHetHan($hopdong),
        ];
    }

    private function layCanhBaoHetHan($hopdong)
    {
        if (!$hopdong || !$hopdong->ngay_ket_thuc) return null;
        $diff = now()->diffInDays(\Illuminate\Support\Carbon::parse($hopdong->ngay_ket_thuc), false);
        if ($diff > 30 || $diff < 0) return null;
        return [
            'so_ngay_con_lai' => $diff,
            'ngay_het_han' => \Illuminate\Support\Carbon::parse($hopdong->ngay_ket_thuc)->format('d/m/Y'),
            'muc_do' => $diff <= 7 ? 'nguy_hiểm' : ($diff <= 15 ? 'cảnh_báo' : 'thông_báo'),
        ];
    }

    private function layDanhSachPhongPhuHop($sinhvien)
    {
        $gioitinh = $sinhvien->taikhoan->gioitinh ?? null;
        return Phong::when($gioitinh, fn($q) => $q->where('gioitinh', $gioitinh))
            ->withCount('danhsachsinhvien')->get()
            ->filter(fn($p) => $p->danhsachsinhvien_count < (int)$p->succhuamax)
            ->take(5);
    }
}
