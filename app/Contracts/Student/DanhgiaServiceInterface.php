<?php

namespace App\Contracts\Student;

use Illuminate\Http\Request;

interface DanhgiaServiceInterface
{
    /**
     * Lấy danh sách đánh giá của một phòng.
     */
    public function getRoomReviews(int $phongId): array;

    /**
     * Gửi đánh giá mới (Sinh viên).
     */
    public function storeReview(array $data): array;

    /**
     * Lấy thông tin form đánh giá (Sinh viên).
     */
    public function getReviewFormContext(): array;
}
