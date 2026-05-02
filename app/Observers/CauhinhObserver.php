<?php

namespace App\Observers;

use App\Models\Cauhinh;
use App\Services\Core\KiemToanService;

class CauhinhObserver
{
    protected KiemToanService $kiemToanService;

    public function __construct(KiemToanService $kiemToanService)
    {
        $this->kiemToanService = $kiemToanService;
    }

    public function created(Cauhinh $cauhinh): void
    {
        $this->kiemToanService->ghiNhatKy(
            'create',
            'Cauhinh',
            $cauhinh->id,
            null,
            $cauhinh->toArray()
        );
    }

    public function updated(Cauhinh $cauhinh): void
    {
        $this->kiemToanService->ghiNhatKy(
            'update',
            'Cauhinh',
            $cauhinh->id,
            $cauhinh->getOriginal(),
            $cauhinh->toArray()
        );
    }

    public function deleted(Cauhinh $cauhinh): void
    {
        $this->kiemToanService->ghiNhatKy(
            'delete',
            'Cauhinh',
            $cauhinh->id,
            $cauhinh->toArray(),
            null
        );
    }

    public function restored(Cauhinh $cauhinh): void
    {
        $this->kiemToanService->ghiNhatKy(
            'restore',
            'Cauhinh',
            $cauhinh->id,
            null,
            $cauhinh->toArray()
        );
    }
}
