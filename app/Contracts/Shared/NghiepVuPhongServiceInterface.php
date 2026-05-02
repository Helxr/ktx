<?php

namespace App\Contracts\Shared;

use Illuminate\Http\Request;

interface NghiepVuPhongServiceInterface
{
    /**
     * Thêm phòng mới.
     */
    public function luuPhong(array $data): array;

    /**
     * Cập nhật thông tin phòng.
     */
    public function capNhatPhong(int $id, array $data): array;

    /**
     * Xóa phòng.
     */
    public function xoaPhong(int $id): array;
}
