<?php

namespace App\Observers;

use App\Models\Danhgia;
use App\Services\Core\KiemToanService;

class DanhgiaObserver
{
    protected KiemToanService $kiemToanService;

    public function __construct(KiemToanService $kiemToanService)
    {
        $this->kiemToanService = $kiemToanService;
    }

    public function created(Danhgia $danhgia): void
    {
        $this->kiemToanService->ghiNhatKy(
            'create',
            'Danhgia',
            $danhgia->id,
            null,
            $danhgia->toArray()
        );
    }

    public function updated(Danhgia $danhgia): void
    {
        $this->kiemToanService->ghiNhatKy(
            'update',
            'Danhgia',
            $danhgia->id,
            $danhgia->getOriginal(),
            $danhgia->toArray()
        );
    }

    public function deleted(Danhgia $danhgia): void
    {
        $this->kiemToanService->ghiNhatKy(
            'delete',
            'Danhgia',
            $danhgia->id,
            $danhgia->toArray(),
            null
        );
    }

    public function restored(Danhgia $danhgia): void
    {
        $this->kiemToanService->ghiNhatKy(
            'restore',
            'Danhgia',
            $danhgia->id,
            null,
            $danhgia->toArray()
        );
    }
}
