<?php

namespace App\Enums;

enum InvoiceStatus: string
{
    case PendingConfirmation = 'pending_confirmation';
    case Pending = 'pending';
    case Paid = 'paid';
    case Overdue = 'overdue';

    public function label(): string
    {
        return match($this) {
            self::PendingConfirmation => 'Chờ xác nhận',
            self::Pending => 'Chưa thanh toán',
            self::Paid => 'Đã thanh toán',
            self::Overdue => 'Quá hạn',
        };
    }

    public static function values(): array
    {
        return array_map(static fn (self $case) => $case->value, self::cases());
    }
}
