<?php

namespace App\Rules;

class CommonRules
{
    /**
     * Validation rule cho phong_id
     */
    public static function phongId(): array
    {
        return ['required', 'numeric', 'exists:phong,id'];
    }

    /**
     * Validation rule cho sinhvien_id
     */
    public static function sinhvienId(): array
    {
        return ['required', 'numeric', 'exists:sinhvien,id'];
    }

    /**
     * Validation rule cho phong_moi_id (dùng khi đổi phòng)
     */
    public static function phongMoiId(): array
    {
        return ['required', 'numeric', 'exists:phong,id'];
    }
}
