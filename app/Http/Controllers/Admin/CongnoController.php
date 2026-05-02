<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\Admin\TaiChinhServiceInterface;
use Illuminate\Http\Request;

class CongnoController extends Controller
{
    public function __construct(
        private readonly TaiChinhServiceInterface $taiChinhService
    ) {}

    public function index(Request $request)
    {
        $duLieuBaoCao = $this->taiChinhService->layBaoCaoNoDong($request);
        return view('admin.congno.danhsach', $duLieuBaoCao);
    }

    public function update(int $phongId)
    {
        $ketQua = $this->taiChinhService->nhacNoTheoPhong($phongId);

        return redirect()->back()->with([
            'toast_loai' => $ketQua['toast_loai'],
            'toast_noidung' => $ketQua['toast_noidung'],
        ]);
    }
}
