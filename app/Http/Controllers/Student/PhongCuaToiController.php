<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Contracts\Student\PhongSinhvienServiceInterface;

class PhongCuaToiController extends Controller
{
    public function __construct(
        private readonly PhongSinhvienServiceInterface $roomService
    ) {}

    /**
     * Trang tổng quan phòng của sinh viên.
     */
    public function index()
    {
        $data = $this->roomService->layThongTinPhongToi();
        if (isset($data['error'])) {
            return redirect()->route('student.trangchu')->with(['toast_loai' => 'loi', 'toast_noidung' => $data['error']]);
        }
        return view('student.phongcuatoi.index', $data);
    }
}
