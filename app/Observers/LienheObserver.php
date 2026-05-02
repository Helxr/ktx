<?php

namespace App\Observers;

use App\Models\Lienhe;
use App\Services\Core\KiemToanService;

class LienheObserver
{
    protected KiemToanService $kiemToanService;

    public function __construct(KiemToanService $kiemToanService)
    {
        $this->kiemToanService = $kiemToanService;
    }

    public function created(Lienhe $lienhe): void
    {
        $this->kiemToanService->ghiNhatKy(
            'create',
            'Lienhe',
            $lienhe->id,
            null,
            $lienhe->toArray()
        );
    }

    public function updated(Lienhe $lienhe): void
    {
        $this->kiemToanService->ghiNhatKy(
            'update',
            'Lienhe',
            $lienhe->id,
            $lienhe->getOriginal(),
            $lienhe->toArray()
        );
    }

    public function deleted(Lienhe $lienhe): void
    {
        $this->kiemToanService->ghiNhatKy(
            'delete',
            'Lienhe',
            $lienhe->id,
            $lienhe->toArray(),
            null
        );
    }

    public function restored(Lienhe $lienhe): void
    {
        $this->kiemToanService->ghiNhatKy(
            'restore',
            'Lienhe',
            $lienhe->id,
            null,
            $lienhe->toArray()
        );
    }
}
