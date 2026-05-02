<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Trạng thái giường – nguồn sự thật cho màu sắc trên toàn UI.
 * AVAILABLE   → Xanh lá  (#10B981)
 * PENDING     → Vàng     (#F59E0B)  – Soft Lock: đang có đơn chờ
 * OCCUPIED    → Đỏ       (#EF4444)  – Sinh viên đang ở
 */
enum BedStatus: string
{
    case Available = 'available';
    case Pending   = 'pending';
    case Occupied  = 'occupied';

    public function label(): string
    {
        return match ($this) {
            self::Available => 'Còn trống',
            self::Pending   => 'Đang có người đặt',
            self::Occupied  => 'Đã có người ở',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Available => '#10B981',
            self::Pending   => '#F59E0B',
            self::Occupied  => '#EF4444',
        };
    }

    public function cssClass(): string
    {
        return match ($this) {
            self::Available => 'badge-available',
            self::Pending   => 'badge-pending',
            self::Occupied => 'badge-occupied',
        };
    }

    public static function values(): array
    {
        return array_map(static fn (self $case) => $case->value, self::cases());
    }
}
