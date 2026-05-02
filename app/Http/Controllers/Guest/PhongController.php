<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Contracts\Core\TruyVanPhongServiceInterface;
use Illuminate\Http\Request;

class PhongController extends Controller
{
    public function __construct(
        private readonly TruyVanPhongServiceInterface $truyVanPhongService,
    ) {}

    /**
     * Danh sách phòng công khai cho khách vãng lai.
     */
    public function index(Request $request)
    {
        $data = $this->truyVanPhongService->lietKePhongCongKhai($request);
        return view('landing.phong.danhsach', $data);
    }

    /**
     * Chi tiết tài sản phòng công khai.
     */
    public function assets(int $id)
    {
        $data = $this->truyVanPhongService->layChiTietPhong($id);
        return view('landing.phong.vattu', $data);
    }
}
