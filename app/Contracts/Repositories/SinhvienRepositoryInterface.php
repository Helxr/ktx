<?php

namespace App\Contracts\Repositories;

use App\Models\Sinhvien;
use Illuminate\Database\Eloquent\Collection;

interface SinhvienRepositoryInterface
{
    /**
     * Tìm sinh viên theo ID.
     */
    public function findById(int $id): ?Sinhvien;

    /**
     * Tìm sinh viên theo user_id.
     */
    public function findByUserId(int $userId): ?Sinhvien;

    /**
     * Lấy tất cả sinh viên đang ở trong phòng.
     */
    public function findByPhongId(int $phongId): Collection;

    /**
     * Đếm số sinh viên đang ở trong phòng.
     */
    public function countByPhongId(int $phongId): int;

    /**
     * Lấy tất cả sinh viên (có thể eager load relations).
     */
    public function all(array $with = []): Collection;
}

