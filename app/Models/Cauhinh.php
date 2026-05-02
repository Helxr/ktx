<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cauhinh extends Model
{
    use HasFactory;

    protected $table = 'cauhinh';

    protected $fillable = [
        'ten',
        'giatri',
    ];
}
