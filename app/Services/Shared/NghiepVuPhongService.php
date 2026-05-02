<?php

namespace App\Services\Shared;

use App\Contracts\Shared\NghiepVuPhongServiceInterface;
use App\Models\Phong;
use App\Models\Hopdong;
use App\Traits\PhanHoiService;
use Illuminate\Support\Facades\Log;

class NghiepVuPhongService implements NghiepVuPhongServiceInterface
{
    use PhanHoiService;

    public function luuPhong(array $data): array
    {
        try {
            $data['dango'] = 0;
            Phong::create($data);
            return ['success' => true, 'message' => 'Thêm phòng thành công.'];
        } catch (\Throwable $e) {
            Log::error("Store room failed: " . $e->getMessage());
            return ['success' => false, 'message' => 'Có lỗi xảy ra: ' . $e->getMessage()];
        }
    }

    public function capNhatPhong(int $id, array $data): array
    {
        try {
            $phong = Phong::find($id);
            if (!$phong) return ['success' => false, 'message' => 'Không tìm thấy phòng.'];

            $phong->update($data);
            return ['success' => true, 'message' => 'Cập nhật phòng thành công.'];
        } catch (\Throwable $e) {
            Log::error("Update room failed: " . $e->getMessage());
            return ['success' => false, 'message' => 'Có lỗi xảy ra: ' . $e->getMessage()];
        }
    }

    public function xoaPhong(int $id): array
    {
        try {
            $phong = Phong::find($id);
            if (!$phong) return ['success' => false, 'message' => 'Không tìm thấy phòng.'];

            if ($blockMessage = $this->kiemTraRanhBuocXoa($phong)) {
                return ['success' => false, 'message' => $blockMessage];
            }

            $phong->delete();
            return ['success' => true, 'message' => 'Xóa phòng thành công.'];
        } catch (\Throwable $e) {
            Log::error("Delete room failed: " . $e->getMessage());
            return ['success' => false, 'message' => 'Có lỗi xảy ra: ' . $e->getMessage()];
        }
    }

    private function kiemTraRanhBuocXoa(Phong $phong): ?string
    {
        if ($phong->dango > 0) {
            return 'Phòng vẫn còn sinh viên đang ở.';
        }
        if ($phong->danhsachhopdong()->where('trang_thai', Hopdong::trangThaiDangHieuLuc())->exists()) {
            return 'Phòng còn hợp đồng đang hiệu lực.';
        }
        if ($phong->danhsachhopdong()->exists() || $phong->danhsachhoadon()->exists()) {
            return 'Phòng đã có dữ liệu lịch sử, không thể xóa vật lý.';
        }
        return null;
    }
}
