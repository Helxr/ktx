<?php

namespace App\Enums;

enum ContractStatus: string
{
    case Active  = 'active';
    case Expired = 'expired';
    case Terminated = 'terminated';

    public function label(): string
    {
        return match($this) {
            self::Active  => 'Đang hiệu lực',
            self::Expired => 'Hết hạn',
            self::Terminated => 'Đã thanh lý',
        };
    }

    public static function values(): array
    {
        return array_map(static fn (self $case) => $case->value, self::cases());
    }
}

