<?php

declare(strict_types=1);

namespace App\Services\Admin;

use App\Enums\BedStatus;
use App\Enums\ContractStatus;
use App\Events\GiuongStatusChanged;
use App\Contracts\Admin\HopdongServiceInterface;
use App\Models\Hopdong;
use App\Models\Phong;
use App\Models\Sinhvien;
use App\Traits\HoTroNghiepVu;
use App\Traits\PhanHoiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class HopdongService implements HopdongServiceInterface
{
    use HoTroNghiepVu, PhanHoiService;

    public function lietKeHopDongAdmin(Request $request): array
    {
        $tuKhoa = $request->query('q', '');
        $trangThai = $request->query('trangthai', 'Tất cả');
        $contracts = Hopdong::when($tuKhoa, function ($q) use ($tuKhoa) {
            $q->whereHas('sinhvien', fn($sq) => $sq->where('masinhvien', 'like', "%{$tuKhoa}%"));
        })->when($trangThai !== 'Tất cả', function ($q) use ($trangThai) {
            $q->where('trang_thai', $trangThai);
        })->with(['sinhvien.taikhoan', 'phong'])->orderByDesc('created_at')->paginate(20);

        return ['hopdong' => $contracts, 'tuKhoa' => $tuKhoa, 'trangThai' => $trangThai];
    }

    public function lietKeHopDongSinhVien(): array
    {
        $sinhvien = Sinhvien::where('user_id', Auth::id())->first();
        if (!$sinhvien) return ['hopdong' => collect()];
        return ['hopdong' => Hopdong::where('sinhvien_id', $sinhvien->id)->with('phong')->orderByDesc('created_at')->get()];
    }

    public function layChiTietHopDong(int $id): array
    {
        $hopdong = Hopdong::with(['sinhvien.taikhoan', 'phong'])->find($id);
        return $hopdong ? ['hopdong' => $hopdong] : $this->traVeLoi('Không tìm thấy hợp đồng.');
    }

    public function taoHopDong(array $data): array
    {
        try {
            return DB::transaction(function () use ($data) {
                $sinhvien = Sinhvien::where('id', (int)$data['sinhvien_id'])->lockForUpdate()->first();
                $phong = Phong::where('id', (int)$data['phong_id'])->lockForUpdate()->first();
                if (!$sinhvien || !$phong) return ['success' => false, 'message' => 'Thiếu dữ liệu.'];

                $check = $this->validateNewContract($sinhvien, $phong);
                if (!$check['success']) return $check;

                $contract = Hopdong::create(['sinhvien_id' => $sinhvien->id, 'phong_id' => $phong->id, 'ngay_bat_dau' => $data['ngay_bat_dau'], 'ngay_ket_thuc' => $data['ngay_ket_thuc'], 'giaphong_luc_ky' => (int)$phong->giaphong, 'trang_thai' => ContractStatus::Active->value]);
                $sinhvien->update(['phong_id' => $phong->id, 'ngay_vao' => $data['ngay_bat_dau'], 'ngay_het_han' => $data['ngay_ket_thuc']]);
                return ['success' => true, 'message' => 'Thành công.', 'contract' => $contract];
            });
        } catch (\Throwable $e) { return ['success' => false, 'message' => $e->getMessage()]; }
    }

    private function validateNewContract($sinhvien, $phong)
    {
        if ($sinhvien->phong_id) return ['success' => false, 'message' => 'Đã có phòng.'];
        if (Hopdong::where('sinhvien_id', $sinhvien->id)->where('trang_thai', ContractStatus::Active->value)->exists()) return ['success' => false, 'message' => 'Đang có hợp đồng.'];
        if ($phong->dango >= $phong->succhuamax) return ['success' => false, 'message' => 'Phòng đầy.'];
        if ($phong->gioitinh && $phong->gioitinh !== ($sinhvien->taikhoan->gioitinh ?? null)) return ['success' => false, 'message' => 'Giới tính không hợp.'];
        return ['success' => true];
    }

    public function giaHanHopDong(int $contractId, string $newEndDate, string $currentEndDate): array
    {
        $hopdong = Hopdong::find($contractId);
        if (!$hopdong) return ['success' => false, 'message' => 'Không tìm thấy.'];
        if (strtotime($newEndDate) <= strtotime($currentEndDate)) return ['success' => false, 'message' => 'Ngày mới không hợp lệ.'];

        $phong = $hopdong->phong; $sinhvien = $hopdong->sinhvien;
        if ($phong->fresh()->dango >= (int)$phong->succhuamax) return ['success' => false, 'message' => 'Phòng đầy.'];

        $hopdong->update(['ngay_ket_thuc' => $newEndDate]);
        if ($sinhvien?->phong_id === $phong->id) $sinhvien->update(['ngay_het_han' => $newEndDate]);
        return ['success' => true, 'message' => 'Gia hạn thành công.'];
    }

    public function thanhLyHopDong(int $contractId): array
    {
        try {
            return DB::transaction(function () use ($contractId) {
                $hopdong = Hopdong::find($contractId);
                if (!$hopdong || $hopdong->trang_thai === ContractStatus::Terminated->value) return ['success' => false, 'message' => 'Lỗi.'];
                
                $sinhvien = $hopdong->sinhvien;
                $hopdong->update(['trang_thai' => ContractStatus::Terminated->value]);
                if ($sinhvien) {
                    $pid = $sinhvien->phong_id;
                    $sinhvien->update(['phong_id' => null, 'ngay_vao' => null, 'ngay_het_han' => null]);
                    if ($pid) Event::dispatch(new GiuongStatusChanged((int)$pid, null, BedStatus::Available, BedStatus::Occupied, 'Thanh lý'));
                }
                return ['success' => true, 'message' => 'Thành công.'];
            });
        } catch (\Throwable $e) { return ['success' => false, 'message' => $e->getMessage()]; }
    }
}
