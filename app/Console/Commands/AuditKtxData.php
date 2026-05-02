<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sinhvien;
use App\Models\Phong;
use App\Models\Hopdong;
use Illuminate\Support\Facades\Crypt;

class AuditKtxData extends Command
{
    protected $signature = 'ktx:audit';
    protected $description = 'Kiểm tra tính toàn vẹn dữ liệu toàn hệ thống';

    public function handle()
    {
        $this->info("--- BẮT ĐẦU KIỂM TRA HỆ THỐNG KTX ---");
        $errors = 0;

        // 1. Kiểm tra Occupancy (Lấp đầy)
        // Lưu ý: Sử dụng tên bảng/cột theo STANDARDS.md nếu đã migration xong
        // Ở đây giả định cấu trúc cơ bản của Laravel
        try {
            $totalBedsOccupied = Phong::sum('so_luong_hien_tai') ?? 0;
            $activeContracts = Hopdong::where('trang_thai', 'active')->count();
            
            if ($totalBedsOccupied !== $activeContracts) {
                $this->error("[LỖI] Mất đồng bộ: DB ghi nhận $totalBedsOccupied giường có người, nhưng chỉ có $activeContracts hợp đồng đang hoạt động!");
                $errors++;
            } else {
                $this->line("✓ Tính toàn vẹn cư trú: ĐỒNG BỘ");
            }
        } catch (\Exception $e) {
            $this->warn("[BỎ QUA] Chưa có bảng Phong hoặc Hopdong để kiểm tra lấp đầy.");
        }

        // 2. Kiểm tra Bảo mật PII
        try {
            $unencryptedCount = 0;
            $sinhviens = Sinhvien::all();
            foreach ($sinhviens as $sv) {
                try {
                    Crypt::decryptString($sv->getRawOriginal('cccd'));
                } catch (\Exception $e) {
                    $unencryptedCount++;
                }
            }
            
            if ($unencryptedCount > 0) {
                $this->warn("[CẢNH BÁO] Có $unencryptedCount sinh viên chưa được mã hóa PII! Cần chạy ktx:encrypt-pii ngay.");
                $errors++;
            } else {
                $this->line("✓ Bảo mật PII: AN TOÀN");
            }
        } catch (\Exception $e) {
            $this->warn("[BỎ QUA] Chưa có bảng Sinhvien để kiểm tra bảo mật.");
        }

        // 3. Kiểm tra Cấu trúc Phòng (KTX Phương Đông - 8 giường)
        try {
            $invalidRooms = Phong::where('suc_chua', '!=', 8)->count();
            if ($invalidRooms > 0) {
                $this->warn("[CẢNH BÁO] Phát hiện $invalidRooms phòng không đúng chuẩn 8 giường của KTX Phương Đông.");
                $errors++;
            }
        } catch (\Exception $e) {
            // Skip if table doesn't exist
        }

        if ($errors === 0) {
            $this->info("--- HỆ THỐNG HOÀN HẢO: KHÔNG PHÁT HIỆN LỖI ---");
        } else {
            $this->error("--- PHÁT HIỆN $errors VẤN ĐỀ CẦN XỬ LÝ ---");
        }
    }
}
