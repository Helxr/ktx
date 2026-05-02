<?php

namespace App\Enums;

enum RegistrationType: string
{
    case Rental = 'rental';
    case Return = 'return';
    case Change = 'change';

    public function label(): string
    {
        return match($this) {
            self::Rental => 'Thuê phòng',
            self::Return => 'Trả phòng',
            self::Change => 'Đổi phòng',
        };
    }

    public static function values(): array
    {
        return array_map(static fn (self $case) => $case->value, self::cases());
    }
}
