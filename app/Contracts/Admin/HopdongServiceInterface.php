<?php

namespace App\Contracts\Admin;

use Illuminate\Http\Request;

interface HopdongServiceInterface
{
    /**
     * Create a new contract.
     * 
     * @param array $data Validated contract data (sinhvien_id, phong_id, ngay_bat_dau, ngay_ket_thuc)
     * @return array ['success' => bool, 'message' => string, 'contract' => Hopdong|null]
     */
    public function taoHopDong(array $data): array;

    /**
     * Extend a contract.
     * 
     * @param int $contractId
     * @param string $newEndDate (Y-m-d format)
     * @param string $currentEndDate (for validation)
     * @return array ['success' => bool, 'message' => string]
     */
    /**
     * Danh sách hợp đồng (Admin).
     */
    public function lietKeHopDongAdmin(Request $request): array;

    /**
     * Danh sách hợp đồng của sinh viên.
     */
    public function lietKeHopDongSinhVien(): array;

    /**
     * Lấy chi tiết hợp đồng.
     */
    public function layChiTietHopDong(int $id): array;

    public function giaHanHopDong(int $contractId, string $newEndDate, string $currentEndDate): array;

    public function thanhLyHopDong(int $contractId): array;
}
