<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Enums\BedStatus;
use App\Events\GiuongStatusChanged;
use App\Models\Phong;
use App\Models\Sinhvien;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

/**
 * Listener đồng bộ lại số lượng chỗ trống (phong.dango) mỗi khi
 * trạng thái giường thay đổi.
 *
 * Chạy SYNCHRONOUSLY (không implement ShouldQueue) để đảm bảo
 * Landing Page luôn hiển thị dữ liệu chính xác ngay lập tức.
 */
final class SyncRoomAvailability
{
    /**
     * Xử lý sự kiện GiuongStatusChanged.
     * Re-count trực tiếp từ DB thay vì increment/decrement để tránh race condition.
     */
    public function handle(GiuongStatusChanged $event): void
    {
        $phong = Phong::find($event->phongId);

        if (! $phong) {
            Log::warning('[SyncRoomAvailability] Phòng không tồn tại.', [
                'phong_id' => $event->phongId,
            ]);
            return;
        }

        // Đếm chính xác số SV đang ở từ bảng sinhvien
        $actualCount = Sinhvien::where('phong_id', $event->phongId)
            ->withoutTrashed()
            ->count();

        $phong->update(['dango' => $actualCount]);

        Log::info('[SyncRoomAvailability] Sync dango thành công.', [
            'phong_id'        => $event->phongId,
            'giuong_no'       => $event->giuongNo,
            'previous_status' => $event->previousStatus->value,
            'new_status'      => $event->newStatus->value,
            'new_dango'       => $actualCount,
            'reason'          => $event->reason,
        ]);
    }
}
