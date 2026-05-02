<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Danhgia extends Model
{
    use HasFactory;

    protected $table = 'danhgia';

    protected $fillable = [
        'sinhvien_id',
        'phong_id',
        'diem',
        'noidung',
        'ngaydanhgia',
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
