<?php

namespace App\Contracts\Admin;

interface BangDieuKhienServiceInterface
{
    /**
     * Lấy toàn bộ dữ liệu thống kê cho Dashboard Admin.
     */
    public function layDuLieuBangDieuKhienAdmin(): array;

    /**
     * Lấy dữ liệu thống kê cho Dashboard Sinh viên.
     */
    public function layDuLieuBangDieuKhienSinhVien(): array;
}
