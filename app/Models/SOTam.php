<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SOTam extends Model
{
    use HasFactory;

    protected $table = 'so_tam';

    protected $fillable = [

        'so_tam',
        'so_chinh_thuc',
        'ma_khach_hang',
        'ten_khach_hang',
        'so_phieu_xxdh',
        'so_phieu_tksx',
        'created_user',
        'updated_user',

    ];
}
