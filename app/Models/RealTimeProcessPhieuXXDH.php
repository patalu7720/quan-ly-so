<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealTimeProcessPhieuXXDH extends Model
{
    use HasFactory;

    protected $table = 'realtime_phieu_xxdh';

    public $timestamps = false;

    protected $fillable = [

        'so_phieu',
        'proccess',
        'username'

    ];
}
