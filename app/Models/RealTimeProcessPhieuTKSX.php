<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealTimeProcessPhieuTKSX extends Model
{
    use HasFactory;

    protected $table = 'realtime_phieu_tksx';

    public $timestamps = false;

    protected $fillable = [

        'so_phieu',
        'proccess',
        'username'

    ];
}
