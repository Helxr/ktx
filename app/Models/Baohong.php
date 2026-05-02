<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Baohong extends Model
{
    use HasFactory;

    protected $table = 'baohong';

    protected $fillable = [
        'sinhvien_id',
        'phong_id',
        'mota',
        'anhminhhoa',
        'trangthai',
        'ngayhen',
        'noidung',
        'do_sinh_vien_gay_ra',
        'phi_boi_thuong',
    ];

    protected $casts = [
        'do_sinh_vien_gay_ra' => 'boolean',
    ];

    public function sinhvien(): BelongsTo
    {
        return $this->belongsTo(Sinhvien::class, 'sinhvien_id');
    }

    public function phong(): BelongsTo
    {
        return $this->belongsTo(Phong::class, 'phong_id');
    }
}
