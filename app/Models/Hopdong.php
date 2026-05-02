<?php

namespace App\Models;

use App\Enums\ContractStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hopdong extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'hopdong';

    public static function trangThaiDangHieuLuc(): string
    {
        return ContractStatus::Active->value;
    }

    public static function trangThaiHetHan(): string
    {
        return ContractStatus::Expired->value;
    }

    public static function trangThaiDaThanhLy(): string
    {
        return ContractStatus::Terminated->value;
    }

    private const ALLOWED_TRANSITIONS = [
        'Dang hieu luc' => [
            'Het han',
            'Da thanh ly',
        ],
        'Het han' => [
            'Da thanh ly',
        ],
        'Da thanh ly' => [],
    ];

    protected $fillable = [
        'sinhvien_id',
        'phong_id',
        'ngay_bat_dau',
        'ngay_ket_thuc',
        'giaphong_luc_ky',
        'trang_thai',
        'ghichu',
    ];

    public function sinhvien(): BelongsTo
    {
        return $this->belongsTo(Sinhvien::class, 'sinhvien_id');
    }

    public function phong(): BelongsTo
    {
        return $this->belongsTo(Phong::class, 'phong_id');
    }

    public function canTransitionTo(string $targetState): bool
    {
        $currentState = $this->normalizeState($this->trang_thai);
        $targetState = $this->normalizeState($targetState);

        if (! array_key_exists($currentState, self::ALLOWED_TRANSITIONS)) {
            return false;
        }

        return in_array($targetState, self::ALLOWED_TRANSITIONS[$currentState], true);
    }

    public function transitionTo(string $targetState, ?string $note = null): bool
    {
        $targetState = $this->normalizeState($targetState);

        if (! $this->canTransitionTo($targetState)) {
            return false;
        }

        return $this->update([
            'trang_thai' => $targetState,
            'ghichu' => $note,
        ]);
    }

    private function normalizeState(string $state): string
    {
        return match ($state) {
            'Dang hieu luc' => self::trangThaiDangHieuLuc(),
            'Het han' => self::trangThaiHetHan(),
            'Da thanh ly' => self::trangThaiDaThanhLy(),
            default => $state,
        };
    }
}
