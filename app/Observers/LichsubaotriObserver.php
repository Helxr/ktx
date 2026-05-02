<?php

namespace App\Observers;

use App\Models\Lichsubaotri;
use App\Services\Core\KiemToanService;

class LichsubaotriObserver
{
    protected KiemToanService $kiemToanService;

    public function __construct(KiemToanService $kiemToanService)
    {
        $this->kiemToanService = $kiemToanService;
    }

    public function created(Lichsubaotri $lichsubaotri): void
    {
        $this->kiemToanService->ghiNhatKy(
            'create',
            'Lichsubaotri',
            $lichsubaotri->id,
            null,
            $lichsubaotri->toArray()
        );
    }

    public function updated(Lichsubaotri $lichsubaotri): void
    {
        $this->kiemToanService->ghiNhatKy(
            'update',
            'Lichsubaotri',
            $lichsubaotri->id,
            $lichsubaotri->getOriginal(),
            $lichsubaotri->toArray()
        );
    }

    public function deleted(Lichsubaotri $lichsubaotri): void
    {
        $this->kiemToanService->ghiNhatKy(
            'delete',
            'Lichsubaotri',
            $lichsubaotri->id,
            $lichsubaotri->toArray(),
            null
        );
    }

    public function restored(Lichsubaotri $lichsubaotri): void
    {
        $this->kiemToanService->ghiNhatKy(
            'restore',
            'Lichsubaotri',
            $lichsubaotri->id,
            null,
            $lichsubaotri->toArray()
        );
    }
}
