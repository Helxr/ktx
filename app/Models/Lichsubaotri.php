<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lichsubaotri extends Model
{
    use HasFactory;

    protected $table = 'lichsubaotri';

    protected $fillable = [
        'vattu_id',
        'phong_id',
        'ngaybaotri',
        'noidung',
        'chiphi',
        'donvithuchien',
        'nguoithuchien',
        'trangthai',
    ];

    public function vattu(): BelongsTo
    {
        return $this->belongsTo(Vattu::class, 'vattu_id');
    }

    public function phong(): BelongsTo
    {
        return $this->belongsTo(Phong::class, 'phong_id');
    }
}
