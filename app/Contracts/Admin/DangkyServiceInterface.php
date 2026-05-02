<?php

namespace App\Contracts\Admin;

use Illuminate\Http\Request;

interface DangkyServiceInterface
{
    /**
     * Gửi đăng ký phòng mới (Sinh viên).
     */
    public function luuDangKySinhVien(array $data): array;

    /**
     * Gửi yêu cầu trả phòng (Sinh viên).
     */
    public function yeuCauTraPhong(): array;

    /**
     * Gửi yêu cầu đổi phòng (Sinh viên).
     */
    public function yeuCauDoiPhong(array $data): array;

    /**
     * Lấy danh sách đăng ký cho Admin.
     */
    public function lietKeDangKyAdmin(Request $request): array;

    /**
     * Duyệt đăng ký (Admin).
     */
    public function duyetDangKy(int $id, ?string $ngayHetHan = null): array;

    /**
     * Từ chối đăng ký (Admin).
     */
    public function tuChoiDangKy(int $id, ?string $reason): array;

    /**
     * Duyệt hồ sơ (Admin).
     */
    public function duyetHoSo(int $id): array;

    /**
     * Xác nhận thanh toán (Admin).
     */
    public function xacNhanThanhToan(int $id): array;

    /**
     * Đăng ký cho khách (Guest).
     */
    public function luuDangkyKhach(array $data): array;

    /**
     * Du lieu form dang ky cho khach.
     */
    public function layDuLieuFormDangKyKhach(int $phongId, ?int $giuongNo = null): array;

    /**
     * Tra cuu ho so dang ky theo token.
     */
    public function layDuLieuTraCuuKhach(?string $token): array;
}
