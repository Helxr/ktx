<?php

namespace App\Contracts\Student;

use Illuminate\Http\Request;

interface BaohongServiceInterface
{
    /**
     * Lấy danh sách báo hỏng của sinh viên hiện tại.
     */
    public function getStudentMaintenanceRequests(): array;

    /**
     * Tạo báo hỏng mới (Student).
     */
    public function storeMaintenance(array $data, ?object $file): array;

    /**
     * Lấy danh sách báo hỏng cho Admin.
     */
    public function listMaintenanceRequestsAdmin(Request $request): array;

    /**
     * Cập nhật trạng thái báo hỏng (Admin).
     */
    public function updateMaintenance(int $id, array $data): array;
}
