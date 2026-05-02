<?php

namespace App\Contracts\Core;

interface TrangChuServiceInterface
{
    /**
     * Lấy dữ liệu cho trang Landing.
     */
    public function layDuLieuTrangChu(): array;

    /**
     * Lưu thông tin liên hệ.
     */
    public function guiLienHe(array $data): bool;
}
