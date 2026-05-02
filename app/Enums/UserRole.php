<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Student = 'student';
    case Manager = 'manager';

    public function label(): string
    {
        return match($this) {
            self::Admin => 'Quản trị viên',
            self::Student => 'Sinh viên',
            self::Manager => 'Quản lý',
        };
    }

    public static function values(): array
    {
        return array_map(static fn (self $case) => $case->value, self::cases());
    }
}
