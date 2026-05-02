<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\Core\TienIchServiceInterface;
use App\Http\Requests\Admin\CapNhatTrangThaiLienHeRequest;
use Illuminate\Http\Request;

class LienheController extends Controller
{
    public function __construct(
        private readonly TienIchServiceInterface $tienIchService
    ) {}

    public function index(Request $request)
    {
        $duLieuLienHe = $this->tienIchService->danhSachLienHe($request);
        return view('admin.lienhe.danhsach', $duLieuLienHe);
    }

    public function update(CapNhatTrangThaiLienHeRequest $request, int $id)
    {
        $duLieu = $request->validated();

        $this->tienIchService->capNhatTrangThaiLienHe($id, $duLieu['trang_thai'], $duLieu['ghi_chu_admin'] ?? null);

        return redirect()->back()->with([
            'toast_loai' => 'thanhcong',
            'toast_noidung' => 'Cap nhat trang thai lien he thanh cong.',
        ]);
    }
}
