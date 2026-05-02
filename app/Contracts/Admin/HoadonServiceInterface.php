<?php

namespace App\Contracts\Admin;

use App\Models\Hoadon;
use App\Models\Sinhvien;
use Illuminate\Http\Request;

interface HoadonServiceInterface
{
    /**
     * Xử lý hóa đơn hàng tháng (điện, nước, phòng).
     */
    public function xuLyHoaDon(array $data): array;

    /**
     * Tạo hóa đơn tiền cọc.
     */
    public function taoHoaDonTheChan(Sinhvien $sinhvien): Hoadon;

    /**
     * Tạo hóa đơn hàng tháng cho sinh viên.
     */
    public function taoHoaDonHangThang(Sinhvien $sinhvien, int $month, int $year, ?string $startDate = null): Hoadon;

    /**
     * Tạo hóa đơn phạt/bồi thường.
     */
    public function taoHoaDonPhat(Sinhvien $sinhvien, int $amount, string $reason): Hoadon;

    /**
     * Tính tiền phòng Pro-rata.
     */
    public function tinhTienPhongTheoNgay(int $baseRoomFee, string $startDate): int;

    /**
     * Lấy danh sách hóa đơn cho Admin.
     */
    public function lietKeHoaDonAdmin(Request $request): array;

    /**
     * Lấy danh sách hóa đơn của sinh viên.
     */
    public function layHoaDonSinhVien(): array;

    /**
     * Xem chi tiết hóa đơn sinh viên.
     */
    public function layChiTietHoaDonSinhVien(int $id): array;

    /**
     * Xác nhận thanh toán hóa đơn.
     */
    public function xacNhanThanhToan(int $id): array;

    /**
     * Sinh viên xác nhận lỗi/phạt.
     */
    public function xacNhanViPham(int $id): array;

    /**
     * Lấy bảng giá hiện tại.
     */
    public function layBangGia(): array;
}
