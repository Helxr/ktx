<?php

declare(strict_types=1);

namespace App\Traits;

use App\Enums\BedStatus;
use App\Enums\RegistrationStatus;
use App\Models\Dangky;
use App\Models\Sinhvien;

/**
 * Trait cung cấp logic tính toán trạng thái giường theo Option A
 * (không có bảng giuong riêng – suy diễn từ dangky + sinhvien).
 *
 * Sử dụng trong: LandingController, PhongController, Admin views.
 */
trait HasBedStatus
{
    /**
     * Tính trạng thái của một giường cụ thể trong một phòng.
     *
     * Logic ưu tiên:
     *   1. Nếu có Sinhvien đang ở giường đó → OCCUPIED
     *   2. Nếu có Dangky PENDING hoặc APPROVED_PENDING_PAYMENT cho giường đó → PENDING
     *   3. Còn lại → AVAILABLE
     */
    protected function calculateBedStatus(int $phongId, int $giuongNo): BedStatus
    {
        // 1. Check sinh viên đang chiếm giường này
        // (giuong_no stored on Dangky that is COMPLETED and linked to a student)
        $occupiedByStudent = Sinhvien::where('phong_id', $phongId)
            ->where('giuong_no', $giuongNo)
            ->exists();

        if ($occupiedByStudent) {
            return BedStatus::Occupied;
        }

        // 2. Check đơn đang chờ (Soft Lock)
        $hasPendingRegistration = Dangky::where('phong_id', $phongId)
            ->where('giuong_no', $giuongNo)
            ->whereIn('trangthai', [
                RegistrationStatus::Pending->value,
                RegistrationStatus::ApprovedPendingPayment->value,
            ])
            ->where(function ($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>', now());
            })
            ->exists();

        if ($hasPendingRegistration) {
            return BedStatus::Pending;
        }

        return BedStatus::Available;
    }

    /**
     * Lấy map trạng thái cho tất cả giường trong một phòng.
     *
     * @return array<int, BedStatus>  key = giuong_no (1-based)
     */
    protected function calculateAllBedStatuses(int $phongId, int $sucChuaMax): array
    {
        $result = [];
        for ($i = 1; $i <= $sucChuaMax; $i++) {
            $result[$i] = $this->calculateBedStatus($phongId, $i);
        }

        return $result;
    }

    /**
     * Đếm số giường còn trống trong một phòng.
     */
    protected function countAvailableBeds(int $phongId, int $sucChuaMax): int
    {
        $statuses = $this->calculateAllBedStatuses($phongId, $sucChuaMax);

        return count(array_filter(
            $statuses,
            static fn (BedStatus $s) => $s === BedStatus::Available
        ));
    }
}
