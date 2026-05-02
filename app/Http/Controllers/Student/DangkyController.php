<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Contracts\Admin\DangkyServiceInterface;
use App\Http\Requests\Student\LuuDangKyMoiRequest;
use App\Http\Requests\Student\YeuCauDoiPhongRequest;
use Illuminate\Http\Request;

class DangkyController extends Controller
{
    public function __construct(
        private readonly DangkyServiceInterface $dangkyService
    ) {}

    /**
     * Gửi đăng ký phòng mới.
     */
    public function luuDangKySinhVien(LuuDangKyMoiRequest $request)
    {
        $result = $this->dangkyService->luuDangKySinhVien($request->validated());
        return redirect()->back()->with(['toast_loai' => $result['toast_loai'], 'toast_noidung' => $result['toast_noidung']]);
    }

    /**
     * Gửi yêu cầu trả phòng.
     */
    public function yeuCauTraPhong()
    {
        $result = $this->dangkyService->yeuCauTraPhong();
        return redirect()->back()->with(['toast_loai' => $result['toast_loai'], 'toast_noidung' => $result['toast_noidung']]);
    }

    /**
     * Gửi yêu cầu đổi phòng.
     */
    public function yeuCauDoiPhong(YeuCauDoiPhongRequest $request)
    {
        $result = $this->dangkyService->yeuCauDoiPhong($request->validated());
        return redirect()->back()->with(['toast_loai' => $result['toast_loai'], 'toast_noidung' => $result['toast_noidung']]);
    }
}
