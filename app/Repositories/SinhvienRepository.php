<?php

namespace App\Repositories;

use App\Models\Sinhvien;
use App\Contracts\Repositories\SinhvienRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class SinhvienRepository implements SinhvienRepositoryInterface
{
    /**
     * Tìm sinh viên theo ID.
     */
    public function findById(int $id): ?Sinhvien
    {
        return Sinhvien::find($id);
    }

    /**
     * Tìm sinh viên theo user_id.
     */
    public function findByUserId(int $userId): ?Sinhvien
    {
        return Sinhvien::where('user_id', $userId)->first();
    }

    /**
     * Lấy tất cả sinh viên đang ở trong phòng.
     */
    public function findByPhongId(int $phongId): Collection
    {
        return Sinhvien::where('phong_id', $phongId)->get();
    }

    /**
     * Đếm số sinh viên đang ở trong phòng.
     */
    public function countByPhongId(int $phongId): int
    {
        return Sinhvien::where('phong_id', $phongId)->count();
    }

    /**
     * Lấy tất cả sinh viên (có thể eager load relations).
     */
    public function all(array $with = []): Collection
    {
        return Sinhvien::with($with)->get();
    }
}

