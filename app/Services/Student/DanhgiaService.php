<?php

namespace App\Services\Student;

use App\Contracts\Student\DanhgiaServiceInterface;
use App\Models\Danhgia;
use App\Models\Phong;
use App\Models\Sinhvien;
use App\Traits\PhanHoiService;
use Illuminate\Support\Facades\Auth;

class DanhgiaService implements DanhgiaServiceInterface
{
    use PhanHoiService;

    public function getRoomReviews(int $phongId): array
    {
        $phong = Phong::find($phongId);
        if (!$phong) return ['error' => 'Không tìm thấy phòng.'];

        $reviews = Danhgia::where('phong_id', $phongId)
            ->with('sinhvien.taikhoan')
            ->orderByDesc('ngaydanhgia')
            ->paginate(10);

        return [
            'phong' => $phong,
            'danhsachdanhgia' => $reviews,
            'diemTrungBinh' => round(Danhgia::where('phong_id', $phongId)->avg('diem') ?? 0, 1),
        ];
    }

    public function storeReview(array $data): array
    {
        try {
            $sinhvien = Sinhvien::where('user_id', Auth::id())->first();
            if (!$sinhvien || !$sinhvien->phong_id) return $this->traVeLoi('Bạn chưa có phòng để đánh giá.');

            if ($this->hasReviewedThisMonth($sinhvien)) {
                return $this->traVeLoi('Bạn đã đánh giá phòng trong tháng này rồi.');
            }

            Danhgia::create([
                'sinhvien_id' => $sinhvien->id,
                'phong_id' => $sinhvien->phong_id,
                'diem' => $data['diem'],
                'noidung' => $data['noidung'] ?? null,
                'ngaydanhgia' => now()->format('Y-m-d'),
            ]);

            return $this->traVeThanhCong('Cảm ơn bạn đã đánh giá phòng!');
        } catch (\Throwable $e) {
            return $this->traVeLoi('Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function getReviewFormContext(): array
    {
        $sinhvien = Sinhvien::where('user_id', Auth::id())->first();
        if (!$sinhvien || !$sinhvien->phong_id) return ['error' => 'Bạn chưa có phòng để đánh giá.'];

        return [
            'phong' => Phong::find($sinhvien->phong_id),
            'daDanhGia' => $this->hasReviewedThisMonth($sinhvien),
        ];
    }

    private function hasReviewedThisMonth($sinhvien): bool
    {
        return Danhgia::where('sinhvien_id', $sinhvien->id)
            ->where('phong_id', $sinhvien->phong_id)
            ->whereYear('ngaydanhgia', now()->year)
            ->whereMonth('ngaydanhgia', now()->month)
            ->exists();
    }
}
