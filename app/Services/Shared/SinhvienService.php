<?php

namespace App\Services\Shared;

use App\Contracts\Shared\SinhvienServiceInterface;
use App\Enums\ContractStatus;
use App\Models\Hopdong;
use App\Models\Phong;
use App\Models\Sinhvien;
use App\Traits\PhanHoiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SinhvienService implements SinhvienServiceInterface
{
    use PhanHoiService;

    public function listStudents(Request $request): array
    {
        $tuKhoa = $request->query('q', '');
        $students = Sinhvien::when($tuKhoa, fn($q) => $q->where('masinhvien', 'like', '%'.trim($tuKhoa).'%'))
            ->with(['taikhoan', 'phong'])
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        return [
            'danhsachsinhvien' => $students,
            'danhsachphong' => Phong::all(),
            'tuKhoa' => $tuKhoa,
        ];
    }

    public function updateStudent(int $id, array $data): array
    {
        $sinhvien = Sinhvien::find($id);
        if (!$sinhvien) return $this->traVeLoi('Không tìm thấy sinh viên.');

        $taiKhoan = $sinhvien->taikhoan;
        if (!$taiKhoan) return $this->traVeLoi('Không tìm thấy tài khoản.');

        DB::transaction(function () use ($taiKhoan, $sinhvien, $data) {
            $taiKhoan->update(['name' => $data['name'], 'gioitinh' => $data['gioitinh']]);
            $sinhvien->update(['masinhvien' => $data['masinhvien'], 'lop' => $data['lop'], 'sodienthoai' => $data['sodienthoai']]);
        });

        return $this->traVeThanhCong('Cập nhật thành công.');
    }

    public function assignRoom(int $id, ?int $phongId): array
    {
        try {
            return DB::transaction(function () use ($id, $phongId) {
                $sinhvien = Sinhvien::where('id', $id)->lockForUpdate()->first();
                if (!$sinhvien) throw new \Exception('Không tìm thấy sinh viên.');

                if ($phongId === null || $phongId === 0) {
                    $this->terminateActiveContracts($sinhvien->id);
                    $sinhvien->update(['phong_id' => null]);
                    return $this->traVeThanhCong('Cập nhật thành công.');
                }

                $phong = Phong::where('id', $phongId)->lockForUpdate()->first();
                if (!$phong) throw new \Exception('Phòng không tồn tại.');
                if ((int)$sinhvien->phong_id === (int)$phong->id) return $this->traVeThanhCong('Đang ở đúng phòng.');

                $this->terminateActiveContracts($sinhvien->id);

                if (Sinhvien::where('phong_id', $phong->id)->count() >= (int)$phong->soluongtoida) {
                    throw new \Exception('Phòng đã đủ người.');
                }

                if ($phong->gioitinh && $phong->gioitinh !== ($sinhvien->taikhoan->gioitinh ?? null)) {
                    throw new \Exception('Giới tính không phù hợp.');
                }

                $sinhvien->update(['phong_id' => $phong->id]);
                return $this->traVeThanhCong('Chuyển phòng thành công.');
            });
        } catch (\Throwable $e) {
            return $this->traVeLoi($e->getMessage());
        }
    }

    public function removeFromRoom(int $id): array
    {
        try {
            return DB::transaction(function () use ($id) {
                $sinhvien = Sinhvien::where('id', $id)->lockForUpdate()->first();
                if (!$sinhvien) throw new \Exception('Không tìm thấy sinh viên.');

                $this->terminateActiveContracts($sinhvien->id);
                $sinhvien->update(['phong_id' => null, 'ngay_vao' => null, 'ngay_het_han' => null]);

                return $this->traVeThanhCong('Rời phòng thành công.');
            });
        } catch (\Throwable $e) {
            return $this->traVeLoi($e->getMessage());
        }
    }

    private function terminateActiveContracts(int $sinhvienId)
    {
        Hopdong::where('sinhvien_id', $sinhvienId)->where('trang_thai', ContractStatus::Active)->update(['trang_thai' => ContractStatus::Terminated]);
    }
}
