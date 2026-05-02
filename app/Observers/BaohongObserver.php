<?php

namespace App\Observers;

use App\Models\Baohong;
use App\Services\Core\KiemToanService;

class BaohongObserver
{
    protected KiemToanService $kiemToanService;

    public function __construct(KiemToanService $kiemToanService)
    {
        $this->kiemToanService = $kiemToanService;
    }

    public function created(Baohong $baohong): void
    {
        $this->kiemToanService->ghiNhatKy(
            'create',
            'Baohong',
            $baohong->id,
            null,
            $baohong->toArray()
        );
    }

    public function updated(Baohong $baohong): void
    {
        $this->kiemToanService->ghiNhatKy(
            'update',
            'Baohong',
            $baohong->id,
            $baohong->getOriginal(),
            $baohong->toArray()
        );
    }

    public function deleted(Baohong $baohong): void
    {
        $this->kiemToanService->ghiNhatKy(
            'delete',
            'Baohong',
            $baohong->id,
            $baohong->toArray(),
            null
        );
    }

    public function restored(Baohong $baohong): void
    {
        $this->kiemToanService->ghiNhatKy(
            'restore',
            'Baohong',
            $baohong->id,
            null,
            $baohong->toArray()
        );
    }
}
