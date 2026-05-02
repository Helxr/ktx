<?php

namespace App\Traits;

trait PhanHoiService
{
    /**
     * Trả về kết quả thành công kèm dữ liệu bổ sung
     *
     * @param string $noidung Nội dung thông báo thành công
     * @param array $data Dữ liệu bổ sung (như token, id...)
     * @return array Mảng kết quả với cấu trúc chuẩn
     */
    protected function traVeThanhCong(string $noidung, array $data = []): array
    {
        return array_merge([
            'toast_loai' => 'thanhcong',
            'toast_noidung' => $noidung,
            'loi' => [],
        ], $data);
    }

    /**
     * Trả về kết quả lỗi kèm chi tiết
     *
     * @param string $noidung Nội dung thông báo lỗi
     * @param array $errors Mảng chi tiết lỗi (nếu có)
     * @return array Mảng kết quả với cấu trúc chuẩn
     */
    protected function traVeLoi(string $noidung, array $errors = []): array
    {
        return [
            'toast_loai' => 'loi',
            'toast_noidung' => $noidung,
            'loi' => $errors,
        ];
    }
}
