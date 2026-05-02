<?php

namespace App\Services\Student;

use App\Contracts\Student\KyluatServiceInterface;
use App\Models\Kyluat;
use App\Models\Sinhvien;
use App\Traits\PhanHoiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KyluatService implements KyluatServiceInterface
{
    use PhanHoiService;

    public function listKyluatAdmin(Request $request): array
    {
        $tuKhoa = $request->query('q', '');
        $data = Kyluat::when($tuKhoa, function ($q) use ($tuKhoa) {
            $q->whereHas('sinhvien', fn($sq) => $sq->where('masinhvien', 'like', "%{$tuKhoa}%"));
        })->with(['sinhvien.taikhoan'])->orderByDesc('ngayvipham')->paginate(20);

        return ['kyluat' => $data, 'tuKhoa' => $tuKhoa, 'sinhviens' => Sinhvien::with('taikhoan')->get()];
    }

    public function listKyluatStudent(): array
    {
        $sinhvien = Sinhvien::where('user_id', Auth::id())->first();
        if (!$sinhvien) return ['kyluat' => collect()];
        return ['kyluat' => Kyluat::where('sinhvien_id', $sinhvien->id)->orderByDesc('ngayvipham')->get()];
    }

    public function saveKyluat(array $data, ?int $id = null): array
    {
        try {
            $kyLuat = $id ? Kyluat::find($id) : new Kyluat();
            if ($id && !$kyLuat) return $this->traVeLoi('Không tìm thấy bản ghi.');

            $kyLuat->fill($data)->save();
            return $this->traVeThanhCong('Thao tác thành công.');
        } catch (\Throwable $e) {
            return $this->traVeLoi($e->getMessage());
        }
    }

    public function deleteKyluat(int $id): array
    {
        try {
            $kyLuat = Kyluat::find($id);
            if (!$kyLuat) return $this->traVeLoi('Không tìm thấy bản ghi.');
            $kyLuat->delete();
            return $this->traVeThanhCong('Xóa thành công.');
        } catch (\Throwable $e) {
            return $this->traVeLoi($e->getMessage());
        }
    }
}
