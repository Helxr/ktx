<?php

namespace App\Contracts\Admin;

use Illuminate\Http\Request;

interface TaiChinhServiceInterface
{
    /**
     * Danh sach cong no (hoa don qua han).
     */
    public function lietKeCongNo(Request $request): array;

    /**
     * Bao cao cong no theo phong cho giao dien Admin.
     */
    public function layBaoCaoNoDong(Request $request): array;

    /**
     * Gui thong bao nhac no theo mot hoa don.
     */
    public function nhacNo(int $invoiceId): array;

    /**
     * Gui thong bao nhac no cho tat ca hoa don qua han cua mot phong.
     */
    public function nhacNoTheoPhong(int $phongId): array;
}
