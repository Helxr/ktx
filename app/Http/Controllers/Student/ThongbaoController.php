<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Contracts\Shared\ThongbaoServiceInterface;
use Illuminate\Http\Request;

class ThongbaoController extends Controller
{
    public function __construct(
        private readonly ThongbaoServiceInterface $thongbaoService
    ) {}

    public function index(Request $request)
    {
        $duLieuThongBao = $this->thongbaoService->indexForStudent($request);
        return view('student.thongbao.danhsach', $duLieuThongBao);
    }

    public function show(int $id)
    {
        $ketQua = $this->thongbaoService->showForStudent($id);
        if (isset($ketQua['toast_loai']) && $ketQua['toast_loai'] === 'loi') {
            return redirect()->route('student.thongbao')->with($ketQua);
        }

        return view('student.thongbao.chitiet', $ketQua);
    }
}
