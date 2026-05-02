<?php

namespace App\Observers;

use App\Models\Hoadon;
use App\Services\Core\KiemToanService;

class HoadonObserver
{
    protected KiemToanService $kiemToanService;

    public function __construct(KiemToanService $kiemToanService)
    {
        $this->kiemToanService = $kiemToanService;
    }

    /**
     * Handle the Hoadon "created" event.
     */
    public function created(Hoadon $hoadon): void
    {
        $this->kiemToanService->ghiNhatKy(
            'create',
            'Hoadon',
            $hoadon->id,
            null,
            $hoadon->toArray()
        );
    }

    /**
     * Handle the Hoadon "updated" event.
     */
    public function updated(Hoadon $hoadon): void
    {
        // Log nếu trạng thái thanh toán thay đổi
        if ($hoadon->isDirty('trangthaithanhtoan')) {
            $this->kiemToanService->ghiNhatKyThayDoiTrangThaiThanhToanHoaDon(
                $hoadon->id,
                $hoadon->getOriginal('trangthaithanhtoan'),
                $hoadon->trangthaithanhtoan
            );
        }
    }

    /**
     * Handle the Hoadon "deleted" event.
     */
    public function deleted(Hoadon $hoadon): void
    {
        $this->kiemToanService->ghiNhatKy(
            'delete',
            'Hoadon',
            $hoadon->id,
            $hoadon->toArray(),
            null
        );
    }

    /**
     * Handle the Hoadon "restored" event.
     */
    public function restored(Hoadon $hoadon): void
    {
        $this->kiemToanService->ghiNhatKy(
            'restore',
            'Hoadon',
            $hoadon->id,
            null,
            $hoadon->toArray()
        );
    }

    /**
     * Handle the Hoadon "force deleted" event.
     */
    public function forceDeleted(Hoadon $hoadon): void
    {
        $this->kiemToanService->ghiNhatKy(
            'force_delete',
            'Hoadon',
            $hoadon->id,
            $hoadon->toArray(),
            null
        );
    }
}
