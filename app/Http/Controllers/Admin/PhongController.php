<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\Core\TruyVanPhongServiceInterface;
use App\Contracts\Shared\TaiSanPhongServiceInterface;
use App\Contracts\Shared\KhoPhongServiceInterface;
use App\Contracts\Shared\NghiepVuPhongServiceInterface;
use App\Contracts\Shared\VatTuPhongServiceInterface;
use App\Http\Requests\Admin\LuuPhongRequest;
use App\Http\Requests\Admin\CapNhatPhongRequest;
use Illuminate\Http\Request;

class PhongController extends Controller
{
    public function __construct(
        private readonly TruyVanPhongServiceInterface $truyVanPhongService,
        private readonly NghiepVuPhongServiceInterface $nghiepVuPhongService,
        private readonly KhoPhongServiceInterface $khoPhongService,
        private readonly TaiSanPhongServiceInterface $taiSanPhongService,
        private readonly VatTuPhongServiceInterface $vatTuPhongService,
    ) {}

    public function index(Request $request)
    {
        $data = $this->truyVanPhongService->lietKePhongChoAdmin($request);
        return view('admin.phong.danhsach', $data);
    }

    public function show(int $id)
    {
        $data = $this->truyVanPhongService->layChiTietPhong($id);
        if (isset($data['error'])) {
            return redirect()->back()->with(['toast_loai' => 'loi', 'toast_noidung' => $data['error']]);
        }

        return view('admin.phong.chitiet', $data);
    }

    public function store(LuuPhongRequest $request)
    {
        $result = $this->nghiepVuPhongService->luuPhong($request->validated());
        return redirect()->back()->with(['toast_loai' => $result['success'] ? 'thanhcong' : 'loi', 'toast_noidung' => $result['message']]);
    }

    public function update(CapNhatPhongRequest $request, int $id)
    {
        $result = $this->nghiepVuPhongService->capNhatPhong($id, $request->validated());
        return redirect()->back()->with(['toast_loai' => $result['success'] ? 'thanhcong' : 'loi', 'toast_noidung' => $result['message']]);
    }

    public function destroy(int $id)
    {
        $result = $this->nghiepVuPhongService->xoaPhong($id);
        return redirect()->back()->with(['toast_loai' => $result['success'] ? 'thanhcong' : 'loi', 'toast_noidung' => $result['message']]);
    }

    public function map(Request $request)
    {
        $data = $this->khoPhongService->layBanDoKyTucXa($request);
        return view('admin.phong.map', $data);
    }

    public function storeAsset(Request $request, int $id)
    {
        $duLieu = $request->validate([
            'tentaisan' => ['required', 'string', 'max:100'],
            'soluong' => ['required', 'integer', 'min:1'],
            'tinhtrang' => ['required', 'string', 'max:100'],
        ]);

        $result = $this->taiSanPhongService->store($duLieu, $id);

        return redirect()->back()->with([
            'toast_loai' => $result['success'] ? 'thanhcong' : 'loi',
            'toast_noidung' => $result['message'],
        ]);
    }

    public function updateAsset(Request $request, int $id, int $taisanId)
    {
        $duLieu = $request->validate([
            'tentaisan' => ['required', 'string', 'max:100'],
            'soluong' => ['required', 'integer', 'min:1'],
            'tinhtrang' => ['required', 'string', 'max:100'],
        ]);

        $result = $this->taiSanPhongService->update($duLieu, $id, $taisanId);

        return redirect()->back()->with([
            'toast_loai' => $result['success'] ? 'thanhcong' : 'loi',
            'toast_noidung' => $result['message'],
        ]);
    }

    public function destroyAsset(int $id, int $taisanId)
    {
        $result = $this->taiSanPhongService->destroy($id, $taisanId);

        return redirect()->back()->with([
            'toast_loai' => $result['success'] ? 'thanhcong' : 'loi',
            'toast_noidung' => $result['message'],
        ]);
    }

    public function storeSupply(Request $request, int $id)
    {
        $duLieu = $request->validate([
            'tenvattu' => ['required', 'string', 'max:100'],
            'soluong' => ['required', 'integer', 'min:1'],
            'tinhtrang' => ['required', 'string', 'max:100'],
            'mota' => ['nullable', 'string', 'max:500'],
            'ngaymua' => ['nullable', 'date'],
            'thoigianbaohanh' => ['nullable', 'string', 'max:100'],
        ]);

        $result = $this->vatTuPhongService->store($duLieu, $id);

        return redirect()->back()->with([
            'toast_loai' => $result['success'] ? 'thanhcong' : 'loi',
            'toast_noidung' => $result['message'],
        ]);
    }

    public function updateSupply(Request $request, int $id, int $vattuId)
    {
        $duLieu = $request->validate([
            'tenvattu' => ['required', 'string', 'max:100'],
            'soluong' => ['required', 'integer', 'min:1'],
            'tinhtrang' => ['required', 'string', 'max:100'],
            'mota' => ['nullable', 'string', 'max:500'],
            'ngaymua' => ['nullable', 'date'],
            'thoigianbaohanh' => ['nullable', 'string', 'max:100'],
        ]);

        $result = $this->vatTuPhongService->update($duLieu, $id, $vattuId);

        return redirect()->back()->with([
            'toast_loai' => $result['success'] ? 'thanhcong' : 'loi',
            'toast_noidung' => $result['message'],
        ]);
    }

    public function destroySupply(int $id, int $vattuId)
    {
        $result = $this->vatTuPhongService->destroy($id, $vattuId);

        return redirect()->back()->with([
            'toast_loai' => $result['success'] ? 'thanhcong' : 'loi',
            'toast_noidung' => $result['message'],
        ]);
    }
}
