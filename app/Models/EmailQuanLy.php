<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailQuanLy extends Model
{
    use HasFactory;

    protected $table = 'email_quan_ly';

    protected $fillable = [

        'email',
        'chuc_vu'

    ];
}
