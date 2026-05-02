<?php

namespace App\Traits;

use App\Enums\ContractStatus;
use App\Models\Hopdong;
use App\Models\Phong;
use App\Models\Sinhvien;

trait HoTroNghiepVu
{
    /**
     * Cập nhật mật độ phòng (dango) cho danh sách phòng
     *
     * @param array $idPhong Danh sách ID phòng cần cập nhật
     * @return void
     */
    protected function capNhatMatDoPhong(array $idPhong): void
    {
        $idPhongHopLe = array_unique(
            array_filter(
                array_map(static fn ($id) => (int) $id, $idPhong),
                static fn (int $id) => $id > 0
            )
        );

        foreach ($idPhongHopLe as $id) {
            $soLuongSinhVien = Sinhvien::where('phong_id', $id)->count();
            Phong::where('id', $id)->update(['dango' => $soLuongSinhVien]);
        }
    }

    /**
     * Chấm dứt tất cả hợp đồng hiện tại của sinh viên
     *
     * @param int $idSinhVien ID sinh viên
     * @return int Số lượng hợp đồng đã chấm dứt
     */
    protected function chamDutHopDongHienTai(int $idSinhVien): int
    {
        return Hopdong::where('sinhvien_id', $idSinhVien)
            ->where('trang_thai', ContractStatus::Active->value)
            ->update(['trang_thai' => ContractStatus::Terminated->value]);
    }
}
