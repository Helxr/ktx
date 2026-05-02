<?php

namespace App\Services\Core;

use App\Contracts\Core\KiemToanServiceInterface;
use App\Models\TblLog;
use Illuminate\Support\Facades\Auth;

class KiemToanService implements KiemToanServiceInterface
{
    /**
     * Log một hành động thay đổi
     */
    public function ghiNhatKy(string $hanhDong, string $tenModel, int $idBanGhi, ?array $duLieuCu = null, ?array $duLieuMoi = null): void
    {
        TblLog::create([
            'user_id' => Auth::id(),
            'hanh_dong' => $hanhDong, // create/update/delete
            'ten_model' => $tenModel,
            'id_ban_ghi' => $idBanGhi,
            'du_lieu_cu' => $duLieuCu,
            'du_lieu_moi' => $duLieuMoi,
        ]);
    }

    /**
     * Log thay đổi trạng thái hợp đồng
     */
    public function ghiNhatKyThayDoiTrangThaiHopDong(int $hopdongId, string $trangThaiCu, string $trangThaiMoi): void
    {
        $this->ghiNhatKy(
            'update',
            'Hopdong',
            $hopdongId,
            ['trang_thai' => $trangThaiCu],
            ['trang_thai' => $trangThaiMoi]
        );
    }

    /**
     * Log thay đổi trạng thái thanh toán hóa đơn
     */
    public function ghiNhatKyThayDoiTrangThaiThanhToanHoaDon(int $hoadonId, string $trangThaiCu, string $trangThaiMoi): void
    {
        $this->ghiNhatKy(
            'update',
            'Hoadon',
            $hoadonId,
            ['trangthaithanhtoan' => $trangThaiCu],
            ['trangthaithanhtoan' => $trangThaiMoi]
        );
    }

    /**
     * Log chuyển phòng sinh viên
     */
    public function ghiNhatKyDoiPhong(int $sinhvienId, int $phongCu, int $phongMoi): void
    {
        $this->ghiNhatKy(
            'update',
            'Sinhvien',
            $sinhvienId,
            ['phong_id' => $phongCu],
            ['phong_id' => $phongMoi]
        );
    }

    /**
     * Log gia hạn hợp đồng
     */
    public function ghiNhatKyGiaHanHopDong(int $hopdongId, string $ngayKetThucCu, string $ngayKetThucMoi): void
    {
        $this->ghiNhatKy(
            'update',
            'Hopdong',
            $hopdongId,
            ['ngay_ket_thuc' => $ngayKetThucCu],
            ['ngay_ket_thuc' => $ngayKetThucMoi]
        );
    }
}
