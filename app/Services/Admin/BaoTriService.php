<?php

namespace App\Services\Admin;

use App\Contracts\Admin\BaoTriServiceInterface;
use App\Models\Lichsubaotri;
use App\Models\Phong;
use App\Models\Vattu;
use App\Traits\PhanHoiService;
use App\Traits\ThoatKyTuLike;
use Illuminate\Http\Request;

class BaoTriService implements BaoTriServiceInterface
{
    use PhanHoiService, ThoatKyTuLike;

    public function lietKeBaoTri(Request $request): array
    {
        $tuKhoa = $request->query('q', '');
        $data = Lichsubaotri::when($tuKhoa, function ($q) use ($tuKhoa) {
            $escapedTuKhoa = $this->thoatKyTuLike($tuKhoa);
            $q->whereHas('phong', fn($pq) => $pq->where('tenphong', 'like', "%{$escapedTuKhoa}%"));
        })->with(['phong', 'vattu'])->orderByDesc('ngaybaotri')->paginate(20);

        return [
            'baotri' => $data,
            'tuKhoa' => $tuKhoa,
            'phongs' => Phong::all(),
            'vattus' => Vattu::all(),
        ];
    }

    public function luuBaoTri(array $data, ?int $id = null): array
    {
        try {
            $lichsu = $id ? Lichsubaotri::find($id) : new Lichsubaotri();
            if ($id && !$lichsu) return $this->traVeLoi('Không tìm thấy bản ghi.');

            $lichsu->fill($data)->save();
            return $this->traVeThanhCong('Thao tác thành công.');
        } catch (\Throwable $e) {
            return $this->traVeLoi($e->getMessage());
        }
    }

    public function xoaBaoTri(int $id): array
    {
        try {
            $lichsu = Lichsubaotri::find($id);
            if (!$lichsu) return $this->traVeLoi('Không tìm thấy bản ghi.');
            $lichsu->delete();
            return $this->traVeThanhCong('Xóa thành công.');
        } catch (\Throwable $e) {
            return $this->traVeLoi($e->getMessage());
        }
    }

    public function hoanThanhBaoTri(int $id): array
    {
        try {
            $lichsu = Lichsubaotri::find($id);
            if (!$lichsu) return $this->traVeLoi('Không tìm thấy bản ghi.');
            $lichsu->update(['trangthai' => 'Đã hoàn thành']);
            return $this->traVeThanhCong('Đã hoàn thành bảo trì.');
        } catch (\Throwable $e) {
            return $this->traVeLoi($e->getMessage());
        }
    }
}
