<?php

namespace App\Observers;

use App\Models\Hopdong;
use App\Services\Core\KiemToanService;
use Illuminate\Support\Facades\Auth;

class HopdongObserver
{
    protected KiemToanService $kiemToanService;

    public function __construct(KiemToanService $kiemToanService)
    {
        $this->kiemToanService = $kiemToanService;
    }

    /**
     * Handle the Hopdong "created" event.
     */
    public function created(Hopdong $hopdong): void
    {
        $this->kiemToanService->ghiNhatKy(
            'create',
            'Hopdong',
            $hopdong->id,
            null,
            $hopdong->toArray()
        );
    }

    /**
     * Handle the Hopdong "updated" event.
     */
    public function updated(Hopdong $hopdong): void
    {
        // Log nếu trạng thái thay đổi
        if ($hopdong->isDirty('trang_thai')) {
            $this->kiemToanService->ghiNhatKyThayDoiTrangThaiHopDong(
                $hopdong->id,
                $hopdong->getOriginal('trang_thai'),
                $hopdong->trang_thai
            );
        }
    }

    /**
     * Handle the Hopdong "deleted" event.
     */
    public function deleted(Hopdong $hopdong): void
    {
        $this->kiemToanService->ghiNhatKy(
            'delete',
            'Hopdong',
            $hopdong->id,
            $hopdong->toArray(),
            null
        );
    }

    /**
     * Handle the Hopdong "restored" event.
     */
    public function restored(Hopdong $hopdong): void
    {
        $this->kiemToanService->ghiNhatKy(
            'restore',
            'Hopdong',
            $hopdong->id,
            null,
            $hopdong->toArray()
        );
    }

    /**
     * Handle the Hopdong "force deleted" event.
     */
    public function forceDeleted(Hopdong $hopdong): void
    {
        $this->kiemToanService->ghiNhatKy(
            'force_delete',
            'Hopdong',
            $hopdong->id,
            $hopdong->toArray(),
            null
        );
    }
}
