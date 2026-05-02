<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblLog extends Model
{
    protected $table = 'tbl_logs';

    protected $fillable = [
        'user_id',
        'hanh_dong',
        'ten_model',
        'id_ban_ghi',
        'du_lieu_cu',
        'du_lieu_moi',
    ];

    protected $casts = [
        'du_lieu_cu' => 'array',
        'du_lieu_moi' => 'array',
    ];
}
