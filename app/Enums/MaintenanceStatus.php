<?php

namespace App\Enums;

enum MaintenanceStatus: string
{
    case Pending    = 'pending';
    case Scheduled  = 'scheduled';
    case InProgress = 'in_progress';
    case Completed  = 'completed';

    public function label(): string
    {
        return match($this) {
            self::Pending    => 'Chờ sửa',
            self::Scheduled  => 'Đã hẹn',
            self::InProgress => 'Đang sửa',
            self::Completed  => 'Đã xong',
        };
    }

    public static function values(): array
    {
        return array_map(static fn (self $case) => $case->value, self::cases());
    }
}
