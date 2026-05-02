<?php

namespace App\Enums;

enum DisciplineLevel: string
{
    case Low = 'low';
    case Medium = 'medium';
    case High = 'high';

    public function label(): string
    {
        return match ($this) {
            self::Low => 'Nhẹ',
            self::Medium => 'Trung bình',
            self::High => 'Nặng',
        };
    }

    public static function values(): array
    {
        return array_map(static fn (self $case) => $case->value, self::cases());
    }
}
