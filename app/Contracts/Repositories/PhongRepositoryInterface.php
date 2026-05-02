<?php

namespace App\Contracts\Repositories;

use App\Models\Phong;
use Illuminate\Database\Eloquent\Collection;

interface PhongRepositoryInterface
{
    /**
     * Tìm phòng theo ID.
     */
    public function findById(int $id): ?Phong;

    /**
     * Lấy tất cả phòng, tùy chọn eager load.
     */
    public function all(array $with = []): Collection;

    /**
     * Lấy danh sách phòng theo bộ lọc.
     *
     * @param array $filters ['q' => string, 'tang' => int, 'gioitinh' => string]
     * @param array $with Relations to eager load
     */
    public function filter(array $filters = [], array $with = []): Collection;

    /**
     * Tổng sức chứa của tất cả phòng.
     */
    public function tongSucChua(): int;

    /**
     * Tổng số sinh viên đang ở (sum of dango).
     */
    public function tongDangO(): int;

    /**
     * Số phòng còn chỗ (dango < succhuamax).
     */
    public function demPhongConCho(): int;

    /**
     * Số phòng hoàn toàn trống (dango = 0).
     */
    public function demPhongTrong(): int;
}

