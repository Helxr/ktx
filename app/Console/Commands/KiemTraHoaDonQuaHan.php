<?php

namespace App\Console\Commands;

use App\Enums\InvoiceStatus;
use App\Models\Hoadon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class KiemTraHoaDonQuaHan extends Command
{
    protected $signature = 'hoadon:kiem-tra-qua-han';

    protected $description = 'Tự động chuyển hóa đơn chưa thanh toán quá 30 ngày sang trạng thái quá hạn';

    public function handle(): int
    {
        try {
            $soLuong = Hoadon::where('trangthaithanhtoan', InvoiceStatus::Pending->value)
                ->whereDate('ngayxuat', '<=', now()->subDays(30))
                ->update(['trangthaithanhtoan' => InvoiceStatus::Overdue->value]);

            $this->info("Đã chuyển {$soLuong} hóa đơn sang trạng thái quá hạn.");
            Log::info("hoadon:kiem-tra-qua-han — {$soLuong} hóa đơn đã quá hạn.");

            return Command::SUCCESS;
        } catch (\Throwable $e) {
            Log::error('hoadon:kiem-tra-qua-han thất bại: ' . $e->getMessage());
            $this->error('Lỗi: ' . $e->getMessage());

            return Command::FAILURE;
        }
    }
}
