<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;

class Sinhvien extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sinhvien';

    protected $fillable = [
        'user_id',
        'masinhvien',
        'lop',
        'sodienthoai',
        'so_cccd',
        'phong_id',
        'giuong_no',
        'ngay_vao',
        'ngay_het_han',
    ];

    protected $casts = [
        'ngay_vao' => 'date',
        'ngay_het_han' => 'date',
    ];

    public function getSodienthoaiAttribute($value)
    {
        if (empty($value)) return $value;
        try {
            return decrypt($value);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning("Lỗi giải mã sodienthoai cho Sinhvien ID: {$this->id}");
            return $value;
        }
    }

    public function getSoCccdAttribute($value)
    {
        if (empty($value)) return $value;
        try {
            return decrypt($value);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning("Lỗi giải mã so_cccd cho Sinhvien ID: {$this->id}");
            return $value;
        }
    }

    public function setSodienthoaiAttribute($value)
    {
        $this->attributes['sodienthoai'] = !empty($value) ? encrypt($value) : $value;
    }

    public function setSoCccdAttribute($value)
    {
        $this->attributes['so_cccd'] = !empty($value) ? encrypt($value) : $value;
    }

    protected $hidden = [
        'sodienthoai',
        'so_cccd',
        'sodienthoai_blind_index',
        'so_cccd_blind_index',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->isDirty('sodienthoai') && !empty($model->sodienthoai)) {
                $normalized = self::normalizePhoneNumber($model->sodienthoai);
                $model->sodienthoai_blind_index = hash('sha256', $normalized);
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

    public function scopeFindBySoDienThoai($query, $soDienThoai)
    {
        $normalized = self::normalizePhoneNumber($soDienThoai);
        return $query->where('sodienthoai_blind_index', hash('sha256', $normalized));
    }

    public function scopeFindBySoCccd($query, $soCccd)
    {
        $normalized = self::normalizeCccd($soCccd);
        return $query->where('so_cccd_blind_index', hash('sha256', $normalized));
    }

    public function taikhoan(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function phong(): BelongsTo
    {
        return $this->belongsTo(Phong::class, 'phong_id');
    }

    public function danhsachdangky(): HasMany
    {
        return $this->hasMany(Dangky::class, 'sinhvien_id');
    }

    public function danhsachbaohong(): HasMany
    {
        return $this->hasMany(Baohong::class, 'sinhvien_id');
    }

    public function danhsachhopdong(): HasMany
    {
        return $this->hasMany(Hopdong::class, 'sinhvien_id');
    }
}
