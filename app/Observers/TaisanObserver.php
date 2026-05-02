<?php

namespace App\Observers;

use App\Models\Taisan;
use App\Services\Core\KiemToanService;

class TaisanObserver
{
    protected KiemToanService $kiemToanService;

    public function __construct(KiemToanService $kiemToanService)
    {
        $this->kiemToanService = $kiemToanService;
    }

    public function created(Taisan $taisan): void
    {
        $this->kiemToanService->ghiNhatKy(
            'create',
            'Taisan',
            $taisan->id,
            null,
            $taisan->toArray()
        );
    }

    public function updated(Taisan $taisan): void
    {
        $this->kiemToanService->ghiNhatKy(
            'update',
            'Taisan',
            $taisan->id,
            $taisan->getOriginal(),
            $taisan->toArray()
        );
    }

    public function deleted(Taisan $taisan): void
    {
        $this->kiemToanService->ghiNhatKy(
            'delete',
            'Taisan',
            $taisan->id,
            $taisan->toArray(),
            null
        );
    }

    public function restored(Taisan $taisan): void
    {
        $this->kiemToanService->ghiNhatKy(
            'restore',
            'Taisan',
            $taisan->id,
            null,
            $taisan->toArray()
        );
    }
}
