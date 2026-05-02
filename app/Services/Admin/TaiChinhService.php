<?php

namespace App\Services\Admin;

use App\Contracts\Admin\TaiChinhServiceInterface;
use App\Models\Hoadon;
use App\Models\Phong;
use App\Models\Thongbao;
use App\Traits\PhanHoiService;
use App\Traits\ThoatKyTuLike;
use Illuminate\Http\Request;

class TaiChinhService implements TaiChinhServiceInterface
{
    use PhanHoiService, ThoatKyTuLike;

    public function lietKeCongNo(Request $request): array
    {
        $tuKhoa = $request->query('q', '');

        $data = Hoadon::where('trangthaithanhtoan', Hoadon::trangThaiQuaHan())
            ->when($tuKhoa, function ($q) use ($tuKhoa) {
                $escapedTuKhoa = $this->thoatKyTuLike($tuKhoa);
                $q->whereHas('sinhvien', fn ($sq) => $sq->where('masinhvien', 'like', "%{$escapedTuKhoa}%"));
            })
            ->with(['sinhvien.taikhoan', 'phong'])
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        return ['hoadons' => $data, 'tuKhoa' => $tuKhoa];
    }

    public function layBaoCaoNoDong(Request $request): array
    {
        $raw = $this->lietKeCongNo($request);
        $hoaDons = collect($raw['hoadons']->items());

        $grouped = $hoaDons->groupBy('phong_id')->map(function ($items, $phongId) {
            $sinhviens = $items->pluck('sinhvien')->filter()->unique('id')->values();
            $phong = $items->first()->phong ?? null;

            return [
                'phong' => $phong,
                'sinhvien' => $sinhviens,
                'hoadon' => $items->values(),
                'tongtien' => (int) $items->sum('tongtien'),
            ];
        });

        $thongKe = [
            'tong_phong_no' => $grouped->count(),
            'tong_sinh_vien_no' => $grouped->pluck('sinhvien')->flatten(1)->unique('id')->count(),
            'so_hoa_don_qua_han' => $hoaDons->count(),
            'tong_tien_no' => (int) $hoaDons->sum('tongtien'),
        ];

        return [
            'congnoTheoPhong' => $grouped,
            'thongke' => $thongKe,
            'ngayQuaHan' => 0,
        ];
    }

    public function nhacNo(int $invoiceId): array
    {
        try {
            $hoadon = Hoadon::with('sinhvien')->find($invoiceId);
            if (! $hoadon) {
                return $this->traVeLoi('Không tìm thấy hóa đơn.');
            }

            Thongbao::create([
                'tieude' => 'Nhắc nhở thanh toán công nợ',
                'noidung' => "Yêu cầu sinh viên thanh toán hóa đơn #{$hoadon->id} trị giá " . number_format((int) $hoadon->tongtien) . 'đ.',
                'doituong' => 'sinhvien',
                'sinhvien_id' => $hoadon->sinhvien_id,
                'ngaydang' => now(),
            ]);

            return $this->traVeThanhCong('Đã gửi thông báo nhắc nợ.');
        } catch (\Throwable $e) {
            return $this->traVeLoi($e->getMessage());
        }
    }

    public function nhacNoTheoPhong(int $phongId): array
    {
        $invoiceIds = Hoadon::query()
            ->where('phong_id', $phongId)
            ->where('trangthaithanhtoan', Hoadon::trangThaiQuaHan())
            ->pluck('id');

        if ($invoiceIds->isEmpty()) {
            return $this->traVeLoi('Không có hóa đơn quá hạn để gửi nhắc nợ.');
        }

        foreach ($invoiceIds as $invoiceId) {
            $this->nhacNo((int) $invoiceId);
        }

        return $this->traVeThanhCong('Đã gửi thông báo nhắc nợ cho phòng.');
    }
}
