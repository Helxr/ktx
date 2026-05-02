<?php

namespace App\Services\Shared;

use App\Contracts\Shared\VatTuPhongServiceInterface;
use App\Models\Vattu;

class VatTuPhongService implements VatTuPhongServiceInterface
{
    public function store(array $data, int $phongId): array
    {
        Vattu::create(array_merge($data, ['phong_id' => $phongId]));

        return ['success' => true, 'message' => 'Them vat tu thanh cong.'];
    }

    public function update(array $data, int $phongId, int $vattuId): array
    {
        $vattu = Vattu::where('phong_id', $phongId)->find($vattuId);
        if (! $vattu) {
            return ['success' => false, 'message' => 'Khong tim thay vat tu can cap nhat.'];
        }

        $vattu->update($data);

        return ['success' => true, 'message' => 'Cap nhat vat tu thanh cong.'];
    }

    public function destroy(int $phongId, int $vattuId): array
    {
        $vattu = Vattu::where('phong_id', $phongId)->find($vattuId);
        if (! $vattu) {
            return ['success' => false, 'message' => 'Khong tim thay vat tu can xoa.'];
        }

        $vattu->delete();

        return ['success' => true, 'message' => 'Xoa vat tu thanh cong.'];
    }
}

