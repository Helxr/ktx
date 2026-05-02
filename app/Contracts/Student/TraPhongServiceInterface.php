<?php

namespace App\Contracts\Student;

interface TraPhongServiceInterface
{
    /**
     * Xử lý thủ tục trả phòng (Checkout) cho sinh viên
     */
    public function xuLyTraPhong(int $sinhvienId): array;
}
