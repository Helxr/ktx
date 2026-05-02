<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\Student\DanhgiaServiceInterface;
use Illuminate\Http\Request;

class DanhgiaController extends Controller
{
    public function __construct(
        private readonly DanhgiaServiceInterface $danhgiaService
    ) {}

    public function listReviews(Request $request, int $phongId)
    {
        $data = $this->danhgiaService->getRoomReviews($phongId);
        if (isset($data['error'])) {
            return redirect()->back()->with(['toast_loai' => 'loi', 'toast_noidung' => $data['error']]);
        }
        return view('admin.phong.chitiet', $data);
    }
}
