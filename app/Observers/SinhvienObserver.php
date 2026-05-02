<?php

namespace App\Observers;

use App\Models\Phong;
use App\Models\Sinhvien;
use App\Services\Core\KiemToanService;

class SinhvienObserver
{
    protected KiemToanService $kiemToanService;

    public function __construct(KiemToanService $kiemToanService)
    {
        $this->kiemToanService = $kiemToanService;
    }

    /**
     * Handle the Sinhvien "created" event.
     */
    public function created(Sinhvien $sinhvien): void
    {
        if ($sinhvien->phong_id) {
            $this->syncRoomOccupancy((int) $sinhvien->phong_id);
        }
        
        $this->kiemToanService->ghiNhatKy(
            'create',
            'Sinhvien',
            $sinhvien->id,
            null,
            $sinhvien->toArray()
        );
    }

    /**
     * Handle the Sinhvien "updated" event.
     */
    public function updated(Sinhvien $sinhvien): void
    {
        if ($sinhvien->wasChanged('phong_id')) {
            $oldRoomId = $sinhvien->getOriginal('phong_id');
            $newRoomId = $sinhvien->phong_id;

            if ($oldRoomId) {
                $this->syncRoomOccupancy((int) $oldRoomId);
            }

            if ($newRoomId) {
                $this->syncRoomOccupancy((int) $newRoomId);
            }

            // Log chuyển phòng
            if ($oldRoomId && $newRoomId && $oldRoomId != $newRoomId) {
                $this->kiemToanService->ghiNhatKyDoiPhong($sinhvien->id, (int) $oldRoomId, (int) $newRoomId);
            }
        }
    }

    /**
     * Handle the Sinhvien "deleted" event.
     */
    public function deleted(Sinhvien $sinhvien): void
    {
        $phongId = $sinhvien->phong_id ?? $sinhvien->getOriginal('phong_id');
        if ($phongId) {
            $this->syncRoomOccupancy((int) $phongId);
        }
        
        $this->kiemToanService->ghiNhatKy(
            'delete',
            'Sinhvien',
            $sinhvien->id,
            $sinhvien->toArray(),
            null
        );
    }

    /**
     * Handle the Sinhvien "restored" event.
     */
    public function restored(Sinhvien $sinhvien): void
    {
        if ($sinhvien->phong_id) {
            $this->syncRoomOccupancy((int) $sinhvien->phong_id);
        }
        
        $this->kiemToanService->ghiNhatKy(
            'restore',
            'Sinhvien',
            $sinhvien->id,
            null,
            $sinhvien->toArray()
        );
    }

    /**
     * Synchronize actual occupancy count (dango) for a specific room.
     * Đếm trực tiếp từ bảng sinhvien để đảm bảo tính chính xác.
     */
    private function syncRoomOccupancy(int $roomId): void
    {
        if ($roomId <= 0) {
            return;
        }

        // Đếm sinh viên thực tế từ bảng sinhvien (chỉ sinh viên đang hoạt động)
        $occupancy = Sinhvien::where('phong_id', $roomId)->withoutTrashed()->count();
        Phong::where('id', $roomId)->update(['dango' => $occupancy]);
    }
}
