<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vattu extends Model
{
    use HasFactory;

    protected $table = 'vattu';

    protected $fillable = [
        'phong_id',
        'tenvattu',
        'soluong',
        'tinhtrang',
        'mota',
        'ngaymua',
        'thoigianbaohanh',
    ];

    public function phong(): BelongsTo
    {
        return $this->belongsTo(Phong::class, 'phong_id');
    }

    public function danhsachlichsubaotri(): HasMany
    {
        return $this->hasMany(Lichsubaotri::class, 'vattu_id');
    }
}
