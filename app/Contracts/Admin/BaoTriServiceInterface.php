<?php

namespace App\Contracts\Admin;

use Illuminate\Http\Request;

interface BaoTriServiceInterface
{
    /**
     * Danh sách lịch sử bảo trì.
     */
    public function lietKeBaoTri(Request $request): array;

    /**
     * Lưu lịch sử bảo trì.
     */
    public function luuBaoTri(array $data, ?int $id = null): array;

    /**
     * Xóa lịch sử bảo trì.
     */
    public function xoaBaoTri(int $id): array;

    /**
     * Đánh dấu bảo trì đã hoàn thành.
     */
    public function hoanThanhBaoTri(int $id): array;
}
