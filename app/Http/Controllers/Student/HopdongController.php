<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Contracts\Admin\HopdongServiceInterface;

class HopdongController extends Controller
{
    public function __construct(
        private readonly HopdongServiceInterface $hopdongService
    ) {}

    public function index()
    {
        $duLieuHopDong = $this->hopdongService->lietKeHopDongSinhVien();
        return view('student.hopdong.index', $duLieuHopDong);
    }

    public function show(int $id)
    {
        $ketQua = $this->hopdongService->layChiTietHopDong($id);
        if (isset($ketQua['toast_loai']) && $ketQua['toast_loai'] === 'loi') {
            return redirect()->route('student.hopdongcuatoi')->with($ketQua);
        }

        $duLieuHopDong = $this->hopdongService->lietKeHopDongSinhVien();
        return view('student.hopdong.index', array_merge($duLieuHopDong, ['hopdongChiTiet' => $ketQua['hopdong'] ?? null]));
    }
}
