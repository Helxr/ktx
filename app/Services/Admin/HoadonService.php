<?php

namespace App\Services\Admin;

use App\Contracts\Admin\HoadonServiceInterface;
use App\Enums\InvoiceStatus;
use App\Models\Cauhinh;
use App\Models\Hoadon;
use App\Models\Phong;
use App\Models\Sinhvien;
use App\Notifications\HoadonMoiNotification;
use App\Traits\PhanHoiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HoadonService implements HoadonServiceInterface
{
    use PhanHoiService;
    private const DEFAULT_ELECTRICITY_RATE = 3500;
    private const DEFAULT_WATER_RATE = 15000;

    public function layBangGia(): array
    {
        return [
            'dongiadien' => (int) $this->layGiaTuCauhinh('gia_dien', (string) self::DEFAULT_ELECTRICITY_RATE),
            'dongianuoc' => (int) $this->layGiaTuCauhinh('gia_nuoc', (string) self::DEFAULT_WATER_RATE),
        ];
    }

    public function lietKeHoaDonAdmin(Request $request): array
    {
        return [
            'danhsachhoadon' => Hoadon::with('phong')->orderByDesc('created_at')->paginate(20)->withQueryString(),
            'danhsachphong' => Phong::all(),
            'dongiadien' => $this->layBangGia()['dongiadien'],
            'dongianuoc' => $this->layBangGia()['dongianuoc'],
        ];
    }

    public function layHoaDonSinhVien(): array
    {
        $sinhvien = Sinhvien::where('user_id', Auth::id())->first();
        if (!$sinhvien || !$sinhvien->phong_id) return ['error' => 'Bạn chưa có phòng.'];

        $lichSu = Hoadon::where('phong_id', $sinhvien->phong_id)->orderByDesc('nam')->orderByDesc('thang')->paginate(12);
        
        return [
            'hoadon' => $lichSu,
            'thongKe' => $this->layThongKeTaiChinhSinhVien($sinhvien->phong_id)
        ];
    }

    public function layChiTietHoaDonSinhVien(int $id): array
    {
        $sinhvien = Sinhvien::where('user_id', Auth::id())->first();
        $hoadon = Hoadon::where('id', $id)->where('phong_id', $sinhvien?->phong_id)->with('phong')->first();
        if (!$hoadon) return ['error' => 'Không tìm thấy hóa đơn.'];

        $soNguoi = Sinhvien::where('phong_id', $sinhvien->phong_id)->count();
        return [
            'hoadon' => $hoadon,
            'soNguoiTrongPhong' => $soNguoi,
            'chiTietTien' => [
                'tien_phong' => round($hoadon->tienphong / max(1, $soNguoi)),
                'tien_dien' => round($hoadon->tiendien / max(1, $soNguoi)),
                'tien_nuoc' => round($hoadon->tiennuoc / max(1, $soNguoi)),
                'phi_dich_vu' => round($hoadon->phidichvu / max(1, $soNguoi)),
                'tong_tien' => round($hoadon->tongtien / max(1, $soNguoi)),
            ]
        ];
    }

    public function xacNhanThanhToan(int $id): array
    {
        $hoadon = Hoadon::find($id);
        if (!$hoadon) return $this->traVeLoi('Không tìm thấy hóa đơn.');
        if (!$hoadon->transitionTo(InvoiceStatus::Paid->value)) return $this->traVeLoi('Không thể xác nhận.');

        return $this->traVeThanhCong('Xác nhận thanh toán thành công.');
    }

    public function xacNhanViPham(int $id): array
    {
        $sinhvien = Sinhvien::where('user_id', Auth::id())->first();
        $hoadon = Hoadon::where('id', $id)->where('sinhvien_id', $sinhvien?->id)->first();
        if (!$hoadon) return $this->traVeLoi('Không tìm thấy hóa đơn.');
        if (!$hoadon->transitionTo(InvoiceStatus::Pending->value)) return $this->traVeLoi('Không thể xác nhận.');

        return $this->traVeThanhCong('Đã xác nhận lỗi. Hãy thanh toán hóa đơn này.');
    }

    public function xuLyHoaDon(array $data): array
    {
        // Existing logic... (simplified for migration)
        $phong = Phong::find($data['phong_id']);
        $bangGia = $this->layBangGia();
        
        $tiendien = ($data['chisodienmoi'] - $data['chisodiencu']) * $bangGia['dongiadien'];
        $tiennuoc = ($data['chisonuocmoi'] - $data['chisonuoccu']) * $bangGia['dongianuoc'];
        $tongtien = $phong->giaphong + $tiendien + $tiennuoc;

        $hoadon = Hoadon::updateOrCreate([
            'phong_id' => $data['phong_id'],
            'thang' => $data['thang'],
            'nam' => $data['nam'],
        ], [
            'chisodiencu' => $data['chisodiencu'],
            'chisodienmoi' => $data['chisodienmoi'],
            'chisonuoccu' => $data['chisonuoccu'],
            'chisonuocmoi' => $data['chisonuocmoi'],
            'tienphong' => $phong->giaphong,
            'tiendien' => $tiendien,
            'tiennuoc' => $tiennuoc,
            'tongtien' => $tongtien,
            'ngayxuat' => now()->format('Y-m-d'),
            'trangthaithanhtoan' => InvoiceStatus::Pending->value,
            'loai_hoadon' => Hoadon::LOAI_MONTHLY,
        ]);

        $this->thongBaoPhong($phong->id, $hoadon);
        return $this->traVeThanhCong('Xử lý hóa đơn thành công.');
    }

    public function taoHoaDonTheChan(Sinhvien $sinhvien): Hoadon
    {
        $amount = (int) $this->layGiaTuCauhinh('phi_the_chan', '1000000');
        return Hoadon::create([
            'sinhvien_id' => $sinhvien->id, 'phong_id' => $sinhvien->phong_id,
            'thang' => now()->month, 'nam' => now()->year, 'tongtien' => $amount,
            'loai_hoadon' => Hoadon::LOAI_DEPOSIT, 'trangthaithanhtoan' => InvoiceStatus::Pending->value,
            'ngayxuat' => now()->format('Y-m-d'),
        ]);
    }

    public function taoHoaDonHangThang(Sinhvien $sinhvien, int $month, int $year, ?string $startDate = null): Hoadon
    {
        $finalPrice = $startDate ? $this->tinhTienPhongTheoNgay((int)$sinhvien->phong->giaphong, $startDate) : (int)$sinhvien->phong->giaphong;
        return Hoadon::create([
            'sinhvien_id' => $sinhvien->id, 'phong_id' => $sinhvien->phong_id,
            'thang' => $month, 'nam' => $year, 'tongtien' => $finalPrice, 'tienphong' => $finalPrice,
            'loai_hoadon' => Hoadon::LOAI_MONTHLY, 'trangthaithanhtoan' => InvoiceStatus::Pending->value,
            'ngayxuat' => now()->format('Y-m-d'),
        ]);
    }

    public function taoHoaDonPhat(Sinhvien $sinhvien, int $amount, string $reason): Hoadon
    {
        return Hoadon::create([
            'sinhvien_id' => $sinhvien->id, 'phong_id' => $sinhvien->phong_id,
            'thang' => now()->month, 'nam' => now()->year, 'tongtien' => $amount,
            'loai_hoadon' => Hoadon::LOAI_PENALTY, 'trangthaithanhtoan' => InvoiceStatus::PendingConfirmation->value,
            'ngayxuat' => now()->format('Y-m-d'),
            'ghichu' => $reason
        ]);
    }

    public function tinhTienPhongTheoNgay(int $baseRoomFee, string $startDate): int
    {
        $start = \Illuminate\Support\Carbon::parse($startDate);
        $daysInMonth = $start->daysInMonth;
        $remainingDays = $daysInMonth - $start->day + 1;
        return (int) round(($baseRoomFee / $daysInMonth) * $remainingDays);
    }

    private function layThongKeTaiChinhSinhVien(int $phongId): array
    {
        $stats = Hoadon::where('phong_id', $phongId)->get();
        return [
            'tong_hoa_don' => $stats->count(),
            'da_thanh_toan' => $stats->where('trangthaithanhtoan', InvoiceStatus::Paid->value)->count(),
            'chua_thanh_toan' => $stats->where('trangthaithanhtoan', InvoiceStatus::Pending->value)->count(),
            'tong_tien_da_tra' => $stats->where('trangthaithanhtoan', InvoiceStatus::Paid->value)->sum('tongtien'),
        ];
    }

    private function thongBaoPhong(int $phongId, Hoadon $hoadon): void
    {
        $students = Sinhvien::where('phong_id', $phongId)->with('taikhoan')->get();
        foreach ($students as $s) {
            if ($s->taikhoan) $s->taikhoan->notify(new HoadonMoiNotification($hoadon));
        }
    }

    private function layGiaTuCauhinh(string $key, string $defaultValue): string
    {
        $c = Cauhinh::where('ten', $key)->first();
        return $c ? $c->giatri : $defaultValue;
    }
}
