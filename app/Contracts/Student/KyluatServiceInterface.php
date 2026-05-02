<?php

namespace App\Contracts\Student;

use Illuminate\Http\Request;

interface KyluatServiceInterface
{
    /**
     * Danh sách kỷ luật (Admin).
     */
    public function listKyluatAdmin(Request $request): array;

    /**
     * Danh sách kỷ luật của sinh viên.
     */
    public function listKyluatStudent(): array;

    /**
     * Lưu kỷ luật.
     */
    public function saveKyluat(array $data, ?int $id = null): array;

    /**
     * Xóa kỷ luật.
     */
    public function deleteKyluat(int $id): array;
}
