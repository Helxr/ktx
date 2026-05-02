<?php

namespace App\Services\Student;

use App\Contracts\Student\BaohongServiceInterface;
use App\Models\Baohong;
use App\Models\Phong;
use App\Models\Sinhvien;
use App\Enums\MaintenanceStatus;
use App\Traits\PhanHoiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class BaohongService implements BaohongServiceInterface
{
    use PhanHoiService;

    public function getStudentMaintenanceRequests(): array
    {
        $sinhvien = Sinhvien::where('user_id', Auth::id())->first();
        if (!$sinhvien) return ['danhsachbaohong' => collect()];

        return [
            'danhsachbaohong' => Baohong::where('sinhvien_id', $sinhvien->id)
                ->with('phong')
                ->orderByDesc('created_at')
                ->get()
        ];
    }

    public function storeMaintenance(array $data, ?object $file): array
    {
        try {
            $sinhvien = Sinhvien::where('user_id', Auth::id())->first();
            if (!$sinhvien) return ['success' => false, 'message' => 'Không tìm thấy thông tin sinh viên.'];
            if (!$sinhvien->phong_id) return ['success' => false, 'message' => 'Bạn chưa được xếp phòng.'];

            $imagePath = $this->handleImageUpload($file);

            Baohong::create([
                'sinhvien_id' => $sinhvien->id,
                'phong_id' => (int) $sinhvien->phong_id,
                'mota' => $data['mota'],
                'noidung' => $data['noidung'] ?? null,
                'anhminhhoa' => $imagePath,
                'trangthai' => MaintenanceStatus::PENDING->value,
            ]);

            return ['success' => true, 'message' => 'Gửi báo hỏng thành công.'];
        } catch (\Throwable $e) {
            Log::error("Store maintenance failed: " . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function listMaintenanceRequestsAdmin(Request $request): array
    {
        $status = $request->query('status', 'Tất cả');
        $requests = Baohong::when($status !== 'Tất cả', fn($q) => $q->where('trangthai', $status))
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        return [
            'danhsachbaohong' => $requests,
            'danhsachsinhvien' => Sinhvien::all(),
            'danhsachphong' => Phong::all(),
            'status' => $status,
        ];
    }

    public function updateMaintenance(int $id, array $data): array
    {
        try {
            $baohong = Baohong::find($id);
            if (!$baohong) return ['success' => false, 'message' => 'Không tìm thấy báo hỏng.'];

            return DB::transaction(function () use ($baohong, $data) {
                $isFault = (bool) ($data['do_sinh_vien_gay_ra'] ?? false);
                $fee = (int) ($data['phi_boi_thuong'] ?? 0);

                $oldData = $baohong->toArray();
                $baohong->update([
                    'trangthai' => $data['trangthai'],
                    'ngayhen' => $data['ngayhen'] ?? $baohong->ngayhen,
                    'noidung' => $data['noidung'] ?? $baohong->noidung,
                    'do_sinh_vien_gay_ra' => $isFault,
                    'phi_boi_thuong' => $fee,
                ]);

                $this->auditLog('Cap nhat trang thai bao hong', 'Baohong', $baohong->id, $oldData, $baohong->toArray());

                if ($data['trangthai'] === MaintenanceStatus::COMPLETED->value && $isFault && $fee > 0) {
                    $this->taoHoaDonPhat($baohong, $fee);
                }

                $this->notifyStudent($baohong);

                return ['success' => true, 'message' => 'Cập nhật thành công.'];
            });
        } catch (\Throwable $e) {
            Log::error("Update maintenance failed: " . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    private function handleImageUpload(?object $file): ?string
    {
        if (!$file) return null;
        $dir = public_path('anhbaohong');
        File::ensureDirectoryExists($dir);
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move($dir, $fileName);
        return 'anhbaohong/' . $fileName;
    }

    private function auditLog(string $action, string $model, int $id, array $old, array $new): void
    {
        \App\Models\TblLog::create([
            'user_id' => auth()->id() ?? 0,
            'hanh_dong' => $action,
            'ten_model' => $model,
            'id_ban_ghi' => $id,
            'du_lieu_cu' => $old,
            'du_lieu_moi' => $new,
        ]);
    }

    private function taoHoaDonPhat(object $baohong, int $fee): void
    {
        $sinhvien = Sinhvien::find($baohong->sinhvien_id);
        if ($sinhvien) {
            app(\App\Services\Admin\HoadonService::class)->taoHoaDonPhat(
                $sinhvien, (int)$fee, "Bồi thường hư hỏng: " . ($baohong->tieude ?? 'Thiết bị KTX')
            );
        }
    }

    private function notifyStudent(object $baohong): void
    {
        $sinhvien = Sinhvien::with('taikhoan')->find($baohong->sinhvien_id);
        if ($sinhvien?->taikhoan) {
            $sinhvien->taikhoan->notify(new \App\Notifications\TrangThaiBaohongNotification(
                $baohong, 
                $baohong->trangthai ?? 'Chưa xác định'
            ));
        }
    }
}
