<?php

namespace App\Contracts\Core;

use Illuminate\Http\Request;

interface TienIchServiceInterface
{
    /**
     * Lay cau hinh he thong.
     */
    public function layCauHinh(): array;

    /**
     * Cap nhat cau hinh.
     */
    public function capNhatCauHinh(array $data): void;

    /**
     * Lay danh sach thong bao.
     */
    public function danhSachThongBao(string $target = 'all'): array;

    /**
     * Gui thong bao.
     */
    public function guiThongBao(array $data): void;

    /**
     * Danh sach lien he (Admin).
     */
    public function danhSachLienHe(Request $request): array;

    /**
     * Cap nhat trang thai lien he.
     */
    public function capNhatTrangThaiLienHe(int $id, string $status, ?string $note = null): void;
}
