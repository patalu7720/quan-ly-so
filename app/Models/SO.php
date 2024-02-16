<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SO extends Model
{
    use HasFactory;

    protected $table = 'so';

    protected $fillable = [

        'so',
        'hop_dong',
        'phieu_xxdh',
        'status_phieu_xxdh',
        'phieu_tksx',
        'status_phieu_tksx',
        'booking',
        'chung_tu_hai_quan',
        'phieu_xuat_kho',
        'co',
        'to_khai_xuat_hang',
        'tai_lieu_co_dinh'

    ];
}
