<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\Admin\HopdongServiceInterface;
use Illuminate\Http\Request;

class HopdongController extends Controller
{
    public function __construct(
        private readonly HopdongServiceInterface $hopdongService
    ) {}

    public function index(Request $request)
    {
        $duLieuHopDong = $this->hopdongService->lietKeHopDongAdmin($request);
        return view('admin.hopdong.danhsach', $duLieuHopDong);
    }

    public function store(Request $request)
    {
        $duLieu = $request->validate([
            'sinhvien_id' => ['required', 'integer', 'exists:sinhvien,id'],
            'phong_id' => ['required', 'integer', 'exists:phong,id'],
            'ngay_bat_dau' => ['required', 'date'],
            'ngay_ket_thuc' => ['required', 'date', 'after:ngay_bat_dau'],
        ]);

        $ketQua = $this->hopdongService->taoHopDong($duLieu);

        return redirect()->back()->with([
            'toast_loai' => ($ketQua['success'] ?? false) ? 'thanhcong' : 'loi',
            'toast_noidung' => $ketQua['message'] ?? 'Khong the tao hop dong.',
        ]);
    }

    public function show(int $id)
    {
        $ketQua = $this->hopdongService->layChiTietHopDong($id);
        if (isset($ketQua['toast_loai']) && $ketQua['toast_loai'] === 'loi') {
            return redirect()->route('admin.quanlyhopdong')->with($ketQua);
        }

        $danhSach = $this->hopdongService->lietKeHopDongAdmin(request());
        return view('admin.hopdong.danhsach', array_merge($danhSach, ['hopdongChiTiet' => $ketQua['hopdong'] ?? null]));
    }

    public function extend(Request $request, int $id)
    {
        $dulieu = $request->validate([
            'ngay_ket_thuc_moi' => ['nullable', 'date', 'after:today'],
            'ngay_ket_thuc' => ['nullable', 'date', 'after:today'],
            'ngay_ket_thuc_cu' => ['nullable', 'date'],
        ]);

        $ngayMoi = $dulieu['ngay_ket_thuc_moi'] ?? $dulieu['ngay_ket_thuc'] ?? null;
        $ngayCu = $dulieu['ngay_ket_thuc_cu'] ?? optional($this->hopdongService->layChiTietHopDong($id)['hopdong'] ?? null)->ngay_ket_thuc;

        if (! $ngayMoi || ! $ngayCu) {
            return redirect()->back()->with(['toast_loai' => 'loi', 'toast_noidung' => 'Thieu du lieu gia han hop dong.']);
        }

        $ketQua = $this->hopdongService->giaHanHopDong($id, $ngayMoi, $ngayCu);
        $loai = ($ketQua['success'] ?? false) ? 'thanhcong' : 'loi';

        return redirect()->back()->with(['toast_loai' => $loai, 'toast_noidung' => $ketQua['message'] ?? 'Khong the gia han hop dong.']);
    }

    public function destroy(int $id)
    {
        $ketQua = $this->hopdongService->thanhLyHopDong($id);
        $loai = ($ketQua['success'] ?? false) ? 'thanhcong' : 'loi';

        return redirect()->back()->with(['toast_loai' => $loai, 'toast_noidung' => $ketQua['message'] ?? 'Khong the thanh ly hop dong.']);
    }

    public function downloadPDF(int $id)
    {
        $ketQua = $this->hopdongService->layChiTietHopDong($id);
        if (isset($ketQua['toast_loai']) && $ketQua['toast_loai'] === 'loi') {
            return redirect()->route('admin.quanlyhopdong')->with($ketQua);
        }

        return redirect()->route('admin.quanlyhopdong')->with([
            'toast_loai' => 'thongtin',
            'toast_noidung' => 'Chuc nang tai PDF hop dong se duoc bo sung o phase tiep theo.',
        ]);
    }
}
