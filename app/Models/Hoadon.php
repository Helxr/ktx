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
    
    public static function trangThaiQuaHan(): string
    {
        return \App\Enums\InvoiceStatus::Overdue->value;
    }

    public static function trangThaiChuaThanhToan(): string
    {
        return \App\Enums\InvoiceStatus::Pending->value;
    }


    private const ALLOWED_TRANSITIONS = [
        'pending_confirmation' => [
            'pending',
        ],
        'pending' => [
            'paid',
            'overdue',
        ],
        'overdue' => [
            'paid',
        ],
        'paid' => [],
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
        'trangthaithanhtoan' => \App\Enums\InvoiceStatus::class,
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

    public function canTransitionTo(string|InvoiceStatus $targetState): bool
    {
        $currentState = $this->trangthaithanhtoan instanceof InvoiceStatus 
            ? $this->trangthaithanhtoan->value 
            : $this->trangthaithanhtoan;

        $targetValue = $targetState instanceof InvoiceStatus 
            ? $targetState->value 
            : $targetState;

        if (! array_key_exists($currentState, self::ALLOWED_TRANSITIONS)) {
            return false;
        }

        return in_array($targetValue, self::ALLOWED_TRANSITIONS[$currentState], true);
    }

    public function transitionTo(string|InvoiceStatus $targetState): bool
    {
        $targetValue = $targetState instanceof InvoiceStatus 
            ? $targetState->value 
            : $targetState;

        if (! $this->canTransitionTo($targetValue)) {
            return false;
        }

        return $this->update([
            'trangthaithanhtoan' => $targetValue,
        ]);
    }
}
