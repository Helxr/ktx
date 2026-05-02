<?php

namespace App\Contracts\Core;

use Illuminate\Http\Request;

interface TruyVanPhongServiceInterface
{
    /**
     * Danh sách phòng cho admin.
     */
    public function lietKePhongChoAdmin(Request $request): array;

    /**
     * Danh sách phòng công khai cho khách.
     */
    public function lietKePhongCongKhai(Request $request): array;

    /**
     * Danh sách phòng cho sinh viên chọn.
     */
    public function lietKePhongChoSinhVien(Request $request): array;

    /**
     * Lấy chi tiết một phòng.
     */
    public function layChiTietPhong(int $id): array;
}
