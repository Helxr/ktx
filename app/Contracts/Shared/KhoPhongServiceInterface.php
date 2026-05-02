<?php

namespace App\Contracts\Shared;

use Illuminate\Http\Request;

interface KhoPhongServiceInterface
{
    /**
     * Lấy dữ liệu sơ đồ KTX (Map).
     */
    public function layBanDoKyTucXa(Request $request): array;

    /**
     * Kiểm tra tình trạng giường trong phòng.
     */
    public function layTrangThaiGiuong(int $phongId): array;

    /**
     * Thống kê tổng quan giường toàn KTX.
     */
    public function layThongKeCoSo(): array;
}
