<?php

namespace App\Models;

use App\Enums\RegistrationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Dangky extends Model
{
    use HasFactory;

    protected $table = 'dangky';

    public const LOAI_THUE_PHONG = 'Thuê phòng';
    public const LOAI_TRA_PHONG = 'Trả phòng';
    public const LOAI_DOI_PHONG = 'Doi phong';

    public static function trangThaiChoXuLy(): string
    {
        return RegistrationStatus::Pending->value;
    }

    public static function trangThaiDaDuyet(): string
    {
        return RegistrationStatus::Approved->value;
    }

    public static function trangThaiTuChoi(): string
    {
        return RegistrationStatus::Rejected->value;
    }

    private const ALLOWED_TRANSITIONS = [
        'Chờ xử lý' => [
            'Chờ thanh toán',
            'Từ chối',
        ],
        'Chờ thanh toán' => [
            'Hoàn tất',
            'Từ chối',
        ],
        'Đã duyệt' => [
            'Hoàn tất',
        ],
        'Hoàn tất' => [],
        'Từ chối' => [],
    ];

    protected $fillable = [
        'sinhvien_id',
        'phong_id',
        'giuong_no',
        'ho_ten',
        'email',
        'so_dien_thoai',
        'so_cccd',
        'anh_the_path',
        'anh_cccd_path',
        'lookup_token',
        'loaidangky',
        'trangthai',
        'ghichu',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function getHoTenAttribute($value)
    {
        if (empty($value)) return $value;
        try {
            return decrypt($value);
        } catch (\Exception $e) {
            return $value;
        }
    }

    public function getEmailAttribute($value)
    {
        if (empty($value)) return $value;
        try {
            return decrypt($value);
        } catch (\Exception $e) {
            return $value;
        }
    }

    public function getSoDienThoaiAttribute($value)
    {
        if (empty($value)) return $value;
        try {
            return decrypt($value);
        } catch (\Exception $e) {
            return $value;
        }
    }

    public function getSoCccdAttribute($value)
    {
        if (empty($value)) return $value;
        try {
            return decrypt($value);
        } catch (\Exception $e) {
            return $value;
        }
    }

    public function setHoTenAttribute($value)
    {
        $this->attributes['ho_ten'] = !empty($value) ? encrypt($value) : $value;
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = !empty($value) ? encrypt($value) : $value;
    }

    public function setSoDienThoaiAttribute($value)
    {
        $this->attributes['so_dien_thoai'] = !empty($value) ? encrypt($value) : $value;
    }

    public function setSoCccdAttribute($value)
    {
        $this->attributes['so_cccd'] = !empty($value) ? encrypt($value) : $value;
    }

    protected $hidden = [
        'so_dien_thoai',
        'so_cccd',
        'so_dien_thoai_blind_index',
        'so_cccd_blind_index',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->isDirty('so_dien_thoai') && !empty($model->so_dien_thoai)) {
                $normalized = self::normalizePhoneNumber($model->so_dien_thoai);
                $model->so_dien_thoai_blind_index = hash('sha256', $normalized);
            }
            if ($model->isDirty('so_cccd') && !empty($model->so_cccd)) {
                $normalized = self::normalizeCccd($model->so_cccd);
                $model->so_cccd_blind_index = hash('sha256', $normalized);
            }
        });
    }

    private static function normalizePhoneNumber(string $phone): string
    {
        return preg_replace('/[^0-9]/', '', $phone);
    }

    private static function normalizeCccd(string $cccd): string
    {
        return preg_replace('/[^0-9]/', '', $cccd);
    }

    public function sinhvien(): BelongsTo
    {
        return $this->belongsTo(Sinhvien::class, 'sinhvien_id');
    }

    public function phong(): BelongsTo
    {
        return $this->belongsTo(Phong::class, 'phong_id');
    }

    public function scopeFindBySoDienThoai($query, $soDienThoai)
    {
        $normalized = self::normalizePhoneNumber($soDienThoai);
        return $query->where('so_dien_thoai_blind_index', hash('sha256', $normalized));
    }

    public function scopeFindBySoCccd($query, $soCccd)
    {
        $normalized = self::normalizeCccd($soCccd);
        return $query->where('so_cccd_blind_index', hash('sha256', $normalized));
    }

    public function canTransitionTo(string $targetState): bool
    {
        $currentState = $this->normalizeState($this->trangthai);
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
            'trangthai' => $targetState,
            'ghichu' => $note,
        ]);
    }

    private function normalizeState(string $state): string
    {
        return match ($state) {
            'Cho xu ly' => self::trangThaiChoXuLy(),
            'Cho thanh toan' => RegistrationStatus::ApprovedPendingPayment->value,
            'Da duyet' => self::trangThaiDaDuyet(),
            'Hoan tat' => RegistrationStatus::Completed->value,
            'Tu choi' => self::trangThaiTuChoi(),
            default => $state,
        };
    }
}
