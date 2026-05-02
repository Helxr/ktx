<?php

namespace App\Contracts\Shared;

use Illuminate\Http\Request;

interface SinhvienServiceInterface
{
    /**
     * Lấy danh sách sinh viên.
     */
    public function listStudents(Request $request): array;

    /**
     * Cập nhật thông tin sinh viên.
     */
    public function updateStudent(int $id, array $data): array;

    /**
     * Xếp phòng cho sinh viên.
     */
    public function assignRoom(int $id, ?int $phongId): array;

    /**
     * Cho sinh viên rời phòng.
     */
    public function removeFromRoom(int $id): array;
}
