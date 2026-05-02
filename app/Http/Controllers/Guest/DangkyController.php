<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Contracts\Admin\DangkyServiceInterface;
use App\Http\Requests\Guest\LuuDangkyRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DangkyController extends Controller
{
    public function __construct(
        private readonly DangkyServiceInterface $dangkyService
    ) {}

    public function create(Request $request): View|RedirectResponse
    {
        $phongId = (int) $request->query('phong_id');
        $giuongNo = $request->query('giuong_no') !== null ? (int) $request->query('giuong_no') : null;

        if ($phongId <= 0) {
            return redirect()->route('public.danhsachphong')
                ->with('toast_loai', 'error')
                ->with('toast_noidung', 'Vui long chon phong truoc khi dang ky.');
        }

        $duLieu = $this->dangkyService->layDuLieuFormDangKyKhach($phongId, $giuongNo);
        if (($duLieu['success'] ?? false) === false) {
            return redirect()->route('public.danhsachphong')
                ->with('toast_loai', 'error')
                ->with('toast_noidung', $duLieu['toast_noidung'] ?? 'Khong tim thay phong.');
        }

        $viewDangKy = view()->exists('landing.phong.dangky') ? 'landing.phong.dangky' : 'landing.dangky';

        return view($viewDangKy, [
            'phong' => $duLieu['phong'],
            'giuong_no' => $duLieu['giuong_no'] ?? null,
        ]);
    }

    public function store(LuuDangkyRequest $request)
    {
        $dulieu = $request->validated();

        $result = $this->dangkyService->luuDangkyKhach($dulieu);

        return redirect()->back()->with([
            'toast_loai' => $result['toast_loai'],
            'toast_noidung' => $result['toast_noidung'],
        ]);
    }

    public function lookup(?string $token = null): View
    {
        $tokenTraCuu = $token ?: request()->query('token');
        $duLieu = $this->dangkyService->layDuLieuTraCuuKhach($tokenTraCuu);

        return view('landing.lookup', [
            'token' => $duLieu['token'] ?? $tokenTraCuu,
            'dangky' => $duLieu['dangky'] ?? null,
        ]);
    }
}
