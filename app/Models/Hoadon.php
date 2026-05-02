<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hoadon extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'hoadon';

    // Phân loại hóa đơn
    public const LOAI_MONTHLY  = 'monthly';   // Hóa đơn tháng thường
    public const LOAI_DEPOSIT  = 'deposit';   // Phí thế chân
    public const LOAI_PENALTY  = 'penalty';   // Phí bồi thường lỗi thiết bị

    public const TRANGTHAI_QUA_HAN = 'Quá hạn';

    public static function trangThaiChuaThanhToan(): string
    {
        return 'Chưa thanh toán';
    }

    public static function trangThaiDaThanhToan(): string
    {
        return 'Đã thanh toán';
    }

    public static function trangThaiQuaHan(): string
    {
        return 'Quá hạn';
    }

    private const ALLOWED_TRANSITIONS = [
        'Chờ xác nhận' => [
            'Chưa thanh toán',
        ],
        'Chưa thanh toán' => [
            'Đã thanh toán',
            'Quá hạn',
        ],
        'Quá hạn' => [
            'Đã thanh toán',
        ],
        'Đã thanh toán' => [],
    ];

    protected $fillable = [
        'phong_id',
        'sinhvien_id',
        'loai_hoadon',
        'thang',
        'nam',
        'chisodiencu',
        'chisodienmoi',
        'chisonuoccu',
        'chisonuocmoi',
        'tongtien',
        'tienphong',
        'tiendien',
        'tiennuoc',
        'phidichvu',
        'trangthaithanhtoan',
        'ngayxuat',
        'calculation_details',
    ];

    protected $casts = [
        'calculation_details' => 'array',
    ];

    public function phong(): BelongsTo
    {
        return $this->belongsTo(Phong::class, 'phong_id');
    }

    public function sinhvien(): BelongsTo
    {
        return $this->belongsTo(Sinhvien::class, 'sinhvien_id');
    }

    public function canTransitionTo(string $targetState): bool
    {
        $currentState = $this->normalizeState($this->trangthaithanhtoan);
        $targetState = $this->normalizeState($targetState);

        if (! array_key_exists($currentState, self::ALLOWED_TRANSITIONS)) {
            return false;
        }

        return in_array($targetState, self::ALLOWED_TRANSITIONS[$currentState], true);
    }

    public function transitionTo(string $targetState): bool
    {
        $targetState = $this->normalizeState($targetState);

        if (! $this->canTransitionTo($targetState)) {
            return false;
        }

        return $this->update([
            'trangthaithanhtoan' => $targetState,
        ]);
    }

    private function normalizeState(string $state): string
    {
        return match ($state) {
            'Chua thanh toan' => self::trangThaiChuaThanhToan(),
            'Da thanh toan' => self::trangThaiDaThanhToan(),
            'Qua han' => self::TRANGTHAI_QUA_HAN,
            default => $state,
        };
    }
}
