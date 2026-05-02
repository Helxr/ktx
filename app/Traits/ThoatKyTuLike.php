<?php

namespace App\Traits;

trait ThoatKyTuLike
{
    protected function thoatKyTuLike(string $giaTri): string
    {
        return str_replace(['%', '_'], ['\%', '\_'], $giaTri);
    }
}
