<?php

namespace App\Observers;

use App\Models\Kyluat;
use App\Services\Core\KiemToanService;

class KyluatObserver
{
    protected KiemToanService $kiemToanService;

    public function __construct(KiemToanService $kiemToanService)
    {
        $this->kiemToanService = $kiemToanService;
    }

    public function created(Kyluat $kyluat): void
    {
        $this->kiemToanService->ghiNhatKy(
            'create',
            'Kyluat',
            $kyluat->id,
            null,
            $kyluat->toArray()
        );
    }

    public function updated(Kyluat $kyluat): void
    {
        $this->kiemToanService->ghiNhatKy(
            'update',
            'Kyluat',
            $kyluat->id,
            $kyluat->getOriginal(),
            $kyluat->toArray()
        );
    }

    public function deleted(Kyluat $kyluat): void
    {
        $this->kiemToanService->ghiNhatKy(
            'delete',
            'Kyluat',
            $kyluat->id,
            $kyluat->toArray(),
            null
        );
    }

    public function restored(Kyluat $kyluat): void
    {
        $this->kiemToanService->ghiNhatKy(
            'restore',
            'Kyluat',
            $kyluat->id,
            null,
            $kyluat->toArray()
        );
    }
}
