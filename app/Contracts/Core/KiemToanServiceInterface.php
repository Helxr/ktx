<?php

namespace App\Contracts\Core;

interface KiemToanServiceInterface
{
    /**
     * Log một hành động thay đổi
     */
    public function ghiNhatKy(string $hanhDong, string $tenModel, int $idBanGhi, ?array $duLieuCu = null, ?array $duLieuMoi = null): void;

    /**
     * Log thay đổi trạng thái hợp đồng
     */
    public function ghiNhatKyThayDoiTrangThaiHopDong(int $hopdongId, string $trangThaiCu, string $trangThaiMoi): void;

    /**
     * Log thay đổi trạng thái thanh toán hóa đơn
     */
    public function ghiNhatKyThayDoiTrangThaiThanhToanHoaDon(int $hoadonId, string $trangThaiCu, string $trangThaiMoi): void;

    /**
     * Log chuyển phòng sinh viên
     */
    public function ghiNhatKyDoiPhong(int $sinhvienId, int $phongCu, int $phongMoi): void;

    /**
     * Log gia hạn hợp đồng
     */
    public function ghiNhatKyGiaHanHopDong(int $hopdongId, string $ngayKetThucCu, string $ngayKetThucMoi): void;
}
