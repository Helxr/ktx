<?php

namespace App\Console\Commands;

use App\Enums\ContractStatus;
use App\Models\Hopdong;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class KiemTraHopDongHetHan extends Command
{
    protected $signature = 'hopdong:kiem-tra-het-han';

    protected $description = 'Tự động chuyển trạng thái hợp đồng hết hạn sang expired';

    public function handle(): int
    {
        try {
            $soLuong = Hopdong::where('trang_thai', ContractStatus::Active->value)
                ->whereDate('ngay_ket_thuc', '<', now())
                ->update(['trang_thai' => ContractStatus::Expired->value]);

            $this->info("Đã chuyển {$soLuong} hợp đồng sang trạng thái hết hạn.");
            Log::info("hopdong:kiem-tra-het-han — {$soLuong} hợp đồng đã hết hạn.");

            return Command::SUCCESS;
        } catch (\Throwable $e) {
            Log::error('hopdong:kiem-tra-het-han thất bại: ' . $e->getMessage());
            $this->error('Lỗi: ' . $e->getMessage());

            return Command::FAILURE;
        }
    }
}
