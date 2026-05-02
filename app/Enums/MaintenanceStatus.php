<?php

namespace App\Enums;

enum MaintenanceStatus: string
{
    case PENDING = 'Chờ sửa';
    case SCHEDULED = 'Đã hẹn';
    case IN_PROGRESS = 'Đang sửa';
    case COMPLETED = 'Đã xong';

    public static function values(): array
    {
        return array_map(static fn (self $case) => $case->value, self::cases());
    }
}
