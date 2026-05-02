<?php

namespace App\Services\Core;

use App\Contracts\Core\TruyVanPhongServiceInterface;
use App\Models\Phong;
use App\Models\Sinhvien;
use App\Models\Dangky;
use App\Enums\RegistrationStatus;
use App\Traits\PhanHoiService;
use App\Traits\ThoatKyTuLike;
use Illuminate\Http\Request;

class TruyVanPhongService implements TruyVanPhongServiceInterface
{
    use PhanHoiService, ThoatKyTuLike;

    public function lietKePhongChoAdmin(Request $request): array
    {
        $tuKhoa = $request->query('q', '');
        $tangLoc = $request->query('tang', '');
        $viewMode = $request->query('view', 'table');

        $escapedTuKhoa = $this->thoatKyTuLike(trim($tuKhoa));
        $danhsachphong = Phong::withCount('danhsachsinhvien')
            ->when($tuKhoa, function ($query) use ($escapedTuKhoa) {
                return $query->where('tenphong', 'like', '%'.$escapedTuKhoa.'%');
            })
            ->when($tangLoc, function ($query) use ($tangLoc) {
                return $query->where('tang', $tangLoc);
            })
            ->orderBy('tang')
            ->orderBy('tenphong')
            ->paginate(20)
            ->withQueryString();

        $soluongdango_theophong = $danhsachphong->pluck('so_nguoi_dang_o', 'id')->toArray();
        $phongTheoTang = $danhsachphong->groupBy('tang');
        $danhsachtang = Phong::select('tang')->distinct()->orderBy('tang')->pluck('tang');

        return compact('danhsachphong', 'phongTheoTang', 'soluongdango_theophong', 'tuKhoa', 'tangLoc', 'danhsachtang', 'viewMode');
    }

    public function lietKePhongCongKhai(Request $request): array
    {
        $tuKhoa = $request->query('q', '');
        $tangLoc = $request->query('tang', '');
        $gioiTinhLoc = $request->query('gioitinh', '');

        $escapedTuKhoaCK = $this->thoatKyTuLike(trim($tuKhoa));
        $danhsachphong = Phong::withCount('danhsachsinhvien')
            ->when($tuKhoa, function ($query) use ($escapedTuKhoaCK) {
                return $query->where('tenphong', 'like', '%'.$escapedTuKhoaCK.'%');
            })
            ->when($tangLoc, function ($query) use ($tangLoc) {
                return $query->where('tang', $tangLoc);
            })
            ->when($gioiTinhLoc, function ($query) use ($gioiTinhLoc) {
                return $query->where('gioitinh', $gioiTinhLoc);
            })
            ->orderBy('tang')
            ->orderBy('tenphong')
            ->get();

        $phongIds = $danhsachphong->pluck('id');
        $bedStatuses = $this->layTrangThaiGiuongHangLoat($phongIds);

        $soluongdango_theophong = $danhsachphong->pluck('so_nguoi_dang_o', 'id')->toArray();
        $phongTheoTang = $danhsachphong->groupBy('tang');
        $danhsachtang = Phong::select('tang')->distinct()->orderBy('tang')->pluck('tang');

        return compact('danhsachphong', 'phongTheoTang', 'soluongdango_theophong', 'tuKhoa', 'tangLoc', 'gioiTinhLoc', 'danhsachtang', 'bedStatuses');
    }

    public function lietKePhongChoSinhVien(Request $request): array
    {
        $tuKhoa = $request->query('q', '');
        $sinhvien = Sinhvien::where('user_id', auth()->id())->first();
        $gioitinhSinhvien = optional($sinhvien?->taikhoan)->gioitinh ?? null;

        $escapedTuKhoaSV = $this->thoatKyTuLike(trim($tuKhoa));
        $danhsachphong = Phong::withCount('danhsachsinhvien')
            ->when($tuKhoa, function ($query) use ($escapedTuKhoaSV) {
                return $query->where('tenphong', 'like', '%'.$escapedTuKhoaSV.'%');
            })
            ->when($gioitinhSinhvien, function ($query) use ($gioitinhSinhvien) {
                return $query->where('gioitinh', $gioitinhSinhvien);
            })
            ->get();

        $soluongdango_theophong = $danhsachphong->pluck('so_nguoi_dang_o', 'id')->toArray();
        $danhsachphongtrong = $danhsachphong->filter(fn($phong) => $phong->so_nguoi_dang_o < (int)$phong->succhuamax);

        return ['danhsachphongtrong' => $danhsachphongtrong, 'soluongdango_theophong' => $soluongdango_theophong, 'tuKhoa' => $tuKhoa];
    }

    public function layChiTietPhong(int $id): array
    {
        $phong = Phong::find($id);
        if (!$phong) return ['error' => 'Không tìm thấy phòng.'];

        return [
            'phong' => $phong,
            'taisan' => $phong->danhsachtaisan()->get(),
            'vattu' => $phong->danhsachvattu()->get()
        ];
    }

    private function layTrangThaiGiuongHangLoat(iterable $phongIds): array
    {
        $sinhvienBeds = Sinhvien::whereIn('phong_id', $phongIds)->get()->groupBy('phong_id');
        $dangkyBeds = Dangky::whereIn('phong_id', $phongIds)
            ->whereIn('trangthai', [RegistrationStatus::Pending->value, RegistrationStatus::ApprovedPendingPayment->value])
            ->get()
            ->groupBy('phong_id');

        $statuses = [];
        foreach ($phongIds as $id) {
            $svBeds = $sinhvienBeds->get($id, collect())->pluck('giuong_no')->toArray();
            $dkBeds = $dangkyBeds->get($id, collect())->pluck('giuong_no')->toArray();
            $beds = [];
            for ($i = 1; $i <= 8; $i++) {
                if (in_array($i, $svBeds)) $beds[$i] = 'OCCUPIED';
                elseif (in_array($i, $dkBeds)) $beds[$i] = 'PENDING';
                else $beds[$i] = 'AVAILABLE';
            }
            $statuses[$id] = $beds;
        }
        return $statuses;
    }
}
