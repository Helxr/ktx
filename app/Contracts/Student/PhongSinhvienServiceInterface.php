<?php

namespace App\Contracts\Student;

interface PhongSinhvienServiceInterface
{
    /**
     * Lấy toàn bộ dữ liệu cho trang Phòng Của Tôi.
     */
    public function layThongTinPhongToi(): array;
}
