<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Contracts\Student\BaohongServiceInterface;
use Illuminate\Http\Request;

class BaohongController extends Controller
{
    public function __construct(
        private readonly BaohongServiceInterface $baohongService
    ) {}

    public function lietKeBaoHongSinhVien()
    {
        $data = $this->baohongService->getStudentMaintenanceRequests();
        return view('student.baohong.danhsach', $data);
    }

    public function luuBaoHong(Request $request)
    {
        $dulieu = $request->validate([
            'mota' => ['required'],
            'noidung' => ['nullable', 'string'],
            'anhminhhoa' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $result = $this->baohongService->storeMaintenance($dulieu, $request->file('anhminhhoa'));

        return redirect()->back()->with([
            'toast_loai' => $result['success'] ? 'thanhcong' : 'loi',
            'toast_noidung' => $result['message']
        ]);
    }
}
