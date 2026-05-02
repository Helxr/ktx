<?php

namespace App\Observers;

use App\Models\Thongbao;
use App\Services\Core\KiemToanService;

class ThongbaoObserver
{
    protected KiemToanService $kiemToanService;

    public function __construct(KiemToanService $kiemToanService)
    {
        $this->kiemToanService = $kiemToanService;
    }

    public function created(Thongbao $thongbao): void
    {
        $this->kiemToanService->ghiNhatKy(
            'create',
            'Thongbao',
            $thongbao->id,
            null,
            $thongbao->toArray()
        );
    }

    public function updated(Thongbao $thongbao): void
    {
        $this->kiemToanService->ghiNhatKy(
            'update',
            'Thongbao',
            $thongbao->id,
            $thongbao->getOriginal(),
            $thongbao->toArray()
        );
    }

    public function deleted(Thongbao $thongbao): void
    {
        $this->kiemToanService->ghiNhatKy(
            'delete',
            'Thongbao',
            $thongbao->id,
            $thongbao->toArray(),
            null
        );
    }

    public function restored(Thongbao $thongbao): void
    {
        $this->kiemToanService->ghiNhatKy(
            'restore',
            'Thongbao',
            $thongbao->id,
            null,
            $thongbao->toArray()
        );
    }
}
