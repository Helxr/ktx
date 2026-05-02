<?php

declare(strict_types=1);

namespace App\Events;

use App\Enums\BedStatus;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Event được bắn ra khi trạng thái giường thay đổi.
 * Triggers:
 *   - Khi đơn đăng ký được tạo mới (AVAILABLE → PENDING)
 *   - Khi đơn đăng ký hết hạn / bị từ chối (PENDING → AVAILABLE)
 *   - Khi confirmPayment hoàn tất (PENDING → OCCUPIED)
 *   - Khi hợp đồng kết thúc (OCCUPIED → AVAILABLE)
 */
final class GiuongStatusChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly int       $phongId,
        public readonly ?int      $giuongNo,
        public readonly BedStatus $newStatus,
        public readonly BedStatus $previousStatus,
        public readonly string    $reason = '',
    ) {}
}
