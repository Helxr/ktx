<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kyluat extends Model
{
    use HasFactory;

    protected $table = 'kyluat';

    protected $fillable = [
        'sinhvien_id',
        'noidung',
        'ngayvipham',
        'mucdo',
    ];

    public function sinhvien(): BelongsTo
    {
        return $this->belongsTo(Sinhvien::class, 'sinhvien_id');
    }
}
