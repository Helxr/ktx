<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lienhe extends Model
{
    use HasFactory;

    public const TRANG_THAI_CHUA_XU_LY = 'Chưa xử lý';
    public const TRANG_THAI_DA_XU_LY = 'Đã xử lý';

    protected $table = 'lienhe';

    protected $fillable = [
        'ho_ten',
        'email',
        'noi_dung',
        'trang_thai',
        'ghi_chu_admin',
    ];
}
