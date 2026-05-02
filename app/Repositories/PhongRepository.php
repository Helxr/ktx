<?php

namespace App\Repositories;

use App\Models\Phong;
use App\Contracts\Repositories\PhongRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PhongRepository implements PhongRepositoryInterface
{
    /**
     * Tìm phòng theo ID.
     */
    public function findById(int $id): ?Phong
    {
        return Phong::find($id);
    }

    /**
     * Lấy tất cả phòng, tùy chọn eager load.
     */
    public function all(array $with = []): Collection
    {
        return Phong::with($with)->get();
    }

    /**
     * Lấy danh sách phòng theo bộ lọc.
     *
     * @param array $filters ['q' => string, 'tang' => int|string, 'gioitinh' => string]
     * @param array $with Relations to eager load
     */
    public function filter(array $filters = [], array $with = []): Collection
    {
        return Phong::with($with)
            ->when($filters['q'] ?? null, function ($query, $q) {
                $escaped = str_replace(['%', '_'], ['\%', '\_'], trim($q));
                return $query->where('tenphong', 'like', '%'.$escaped.'%');
            })
            ->when($filters['tang'] ?? null, function ($query, $tang) {
                return $query->where('tang', $tang);
            })
            ->when($filters['gioitinh'] ?? null, function ($query, $gioitinh) {
                return $query->where('gioitinh', $gioitinh);
            })
            ->orderBy('tang')
            ->orderBy('tenphong')
            ->get();
    }

    /**
     * Tổng sức chứa của tất cả phòng.
     */
    public function tongSucChua(): int
    {
        return (int) Phong::sum('succhuamax');
    }

    /**
     * Tổng số sinh viên đang ở (sum of dango — cached by SinhvienObserver).
     */
    public function tongDangO(): int
    {
        return (int) Phong::sum('dango');
    }

    /**
     * Số phòng còn chỗ (dango < succhuamax).
     */
    public function demPhongConCho(): int
    {
        return Phong::whereColumn('dango', '<', 'succhuamax')->count();
    }

    /**
     * Số phòng hoàn toàn trống (dango = 0).
     */
    public function demPhongTrong(): int
    {
        return Phong::where('dango', 0)->count();
    }
}

