<?php

namespace App\Services\Shared;

use App\Contracts\Shared\TaiSanPhongServiceInterface;
use App\Models\Taisan;

class TaiSanPhongService implements TaiSanPhongServiceInterface
{
    public function store(array $data, int $phongId): array
    {
        Taisan::create([
            'phong_id' => $phongId,
            'tentaisan' => $data['tentaisan'],
            'soluong' => $data['soluong'],
            'tinhtrang' => $data['tinhtrang'],
        ]);

        return ['success' => true, 'message' => 'Them tai san thanh cong.'];
    }

    public function update(array $data, int $phongId, int $taisanId): array
    {
        $taisan = Taisan::where('phong_id', $phongId)->find($taisanId);
        if (! $taisan) {
            return ['success' => false, 'message' => 'Khong tim thay tai san can cap nhat.'];
        }

        $taisan->update($data);

        return ['success' => true, 'message' => 'Cap nhat tai san thanh cong.'];
    }

    public function destroy(int $phongId, int $taisanId): array
    {
        $taisan = Taisan::where('phong_id', $phongId)->find($taisanId);
        if (! $taisan) {
            return ['success' => false, 'message' => 'Khong tim thay tai san can xoa.'];
        }

        $taisan->delete();

        return ['success' => true, 'message' => 'Xoa tai san thanh cong.'];
    }
}

