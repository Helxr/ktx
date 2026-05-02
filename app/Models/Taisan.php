<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Taisan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'taisan';

    protected $fillable = [
        'phong_id',
        'tentaisan',
        'soluong',
        'tinhtrang',
    ];

    public function phong(): BelongsTo
    {
        return $this->belongsTo(Phong::class, 'phong_id');
    }
}
