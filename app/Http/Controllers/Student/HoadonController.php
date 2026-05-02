<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Contracts\Admin\HoadonServiceInterface;
use Illuminate\Http\Request;

class HoadonController extends Controller
{
    public function __construct(
        private readonly HoadonServiceInterface $hoadonService
    ) {}

    public function layHoaDonSinhVien()
    {
        $data = $this->hoadonService->layHoaDonSinhVien();
        if (isset($data['error'])) {
            return redirect()->back()->with(['toast_loai' => 'loi', 'toast_noidung' => $data['error']]);
        }
        return view('student.phongcuatoi.lichSuHoaDon', $data);
    }

    public function layChiTietHoaDonSinhVien(int $id)
    {
        $data = $this->hoadonService->layChiTietHoaDonSinhVien($id);
        if (isset($data['error'])) {
            return redirect()->back()->with(['toast_loai' => 'loi', 'toast_noidung' => $data['error']]);
        }
        return view('student.phongcuatoi.chiTietHoaDon', $data);
    }

    public function xacNhanViPham(int $id)
    {
        $result = $this->hoadonService->xacNhanViPham($id);
        return redirect()->back()->with(['toast_loai' => $result['toast_loai'], 'toast_noidung' => $result['toast_noidung']]);
    }
}
