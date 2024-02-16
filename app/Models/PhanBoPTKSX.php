<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhanBoPTKSX extends Model
{
    use HasFactory;

    protected $table = 'phan_bo_ptksx';

    protected $fillable = [

        'name',
        'email',
        'nha_may'

    ];
}
