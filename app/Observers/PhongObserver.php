<?php

namespace App\Observers;

use App\Models\Phong;
use App\Services\Core\KiemToanService;

class PhongObserver
{
    protected KiemToanService $kiemToanService;

    public function __construct(KiemToanService $kiemToanService)
    {
        $this->kiemToanService = $kiemToanService;
    }

    public function created(Phong $phong): void
    {
        $this->kiemToanService->ghiNhatKy(
            'create',
            'Phong',
            $phong->id,
            null,
            $phong->toArray()
        );
    }

    public function updated(Phong $phong): void
    {
        $this->kiemToanService->ghiNhatKy(
            'update',
            'Phong',
            $phong->id,
            $phong->getOriginal(),
            $phong->toArray()
        );
    }

    public function deleted(Phong $phong): void
    {
        $this->kiemToanService->ghiNhatKy(
            'delete',
            'Phong',
            $phong->id,
            $phong->toArray(),
            null
        );
    }

    public function restored(Phong $phong): void
    {
        $this->kiemToanService->ghiNhatKy(
            'restore',
            'Phong',
            $phong->id,
            null,
            $phong->toArray()
        );
    }
}
