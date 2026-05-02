<?php

namespace App\Observers;

use App\Models\Vattu;
use App\Services\Core\KiemToanService;

class VattuObserver
{
    protected KiemToanService $kiemToanService;

    public function __construct(KiemToanService $kiemToanService)
    {
        $this->kiemToanService = $kiemToanService;
    }

    public function created(Vattu $vattu): void
    {
        $this->kiemToanService->ghiNhatKy(
            'create',
            'Vattu',
            $vattu->id,
            null,
            $vattu->toArray()
        );
    }

    public function updated(Vattu $vattu): void
    {
        $this->kiemToanService->ghiNhatKy(
            'update',
            'Vattu',
            $vattu->id,
            $vattu->getOriginal(),
            $vattu->toArray()
        );
    }

    public function deleted(Vattu $vattu): void
    {
        $this->kiemToanService->ghiNhatKy(
            'delete',
            'Vattu',
            $vattu->id,
            $vattu->toArray(),
            null
        );
    }

    public function restored(Vattu $vattu): void
    {
        $this->kiemToanService->ghiNhatKy(
            'restore',
            'Vattu',
            $vattu->id,
            null,
            $vattu->toArray()
        );
    }
}
