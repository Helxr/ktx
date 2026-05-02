<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Contracts\Core\TruyVanPhongServiceInterface;
use App\Contracts\Student\PhongSinhvienServiceInterface;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PhongController extends Controller
{
    public function __construct(
        private readonly TruyVanPhongServiceInterface $truyVanPhongService,
        private readonly PhongSinhvienServiceInterface $roomService,
    ) {}

    /**
     * Danh sách phòng trống phù hợp giới tính cho sinh viên.
     */
    public function index(Request $request)
    {
        $data = $this->truyVanPhongService->lietKePhongChoSinhVien($request);
        return view('student.phong.danhsach', [
            'danhsachphong' => $data['danhsachphongtrong'],
            'soluongdango_theophong' => $data['soluongdango_theophong'],
            'tuKhoa' => $data['tuKhoa'],
        ]);
    }

    /**
     * Xem tài sản phòng đang ở.
     */
    public function myRoomAssets(): View
    {
        $duLieuPhong = $this->roomService->layThongTinPhongToi();

        return view('student.taisanphong', [
            'phong' => $duLieuPhong['phong'] ?? null,
            'taisan' => $duLieuPhong['taisan'] ?? collect(),
        ]);
    }
}
