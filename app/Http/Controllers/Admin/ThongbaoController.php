<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\Shared\ThongbaoServiceInterface;
use Illuminate\Http\Request;

class ThongbaoController extends Controller
{
    public function __construct(
        private readonly ThongbaoServiceInterface $thongbaoService
    ) {}

    public function index()
    {
        $duLieuThongBao = $this->thongbaoService->indexForAdmin();
        return view('admin.thongbao.danhsach', $duLieuThongBao);
    }

    public function store(Request $request)
    {
        $duLieu = $request->validate([
            'tieude' => ['required', 'string', 'max:255'],
            'noidung' => ['required', 'string'],
            'doituong' => ['nullable', 'in:sinhvien,admin,tatca'],
            'ngaydang' => ['nullable', 'date'],
        ]);

        $ketQua = $this->thongbaoService->store($duLieu);
        return redirect()->back()->with(['toast_loai' => $ketQua['toast_loai'], 'toast_noidung' => $ketQua['toast_noidung']]);
    }

    public function update(Request $request, int $id)
    {
        $duLieu = $request->validate([
            'tieude' => ['required', 'string', 'max:255'],
            'noidung' => ['required', 'string'],
            'doituong' => ['nullable', 'in:sinhvien,admin,tatca'],
            'ngaydang' => ['nullable', 'date'],
        ]);

        $ketQua = $this->thongbaoService->update($id, $duLieu);
        return redirect()->back()->with(['toast_loai' => $ketQua['toast_loai'], 'toast_noidung' => $ketQua['toast_noidung']]);
    }

    public function destroy(int $id)
    {
        $ketQua = $this->thongbaoService->destroy($id);
        return redirect()->back()->with(['toast_loai' => $ketQua['toast_loai'], 'toast_noidung' => $ketQua['toast_noidung']]);
    }
}
