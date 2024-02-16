<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanPhamLog extends Model
{
    use HasFactory;

    protected $table = 'san_pham_log';

    protected $fillable = [

        'sohd',
        
        'quycach1',
        'soluong1',
        'dongia1',

        'quycach2',
        'soluong2',
        'dongia2',
        
        'quycach3',
        'soluong3',
        'dongia3',

        'quycach4',
        'soluong4',
        'dongia4',

        'quycach5',
        'soluong5',
        'dongia5',

        'quycach6',
        'soluong6',
        'dongia6',

        'quycach7',
        'soluong7',
        'dongia7',

        'quycach8',
        'soluong8',
        'dongia8',

        'quycach9',
        'soluong9',
        'dongia9',

        'quycach10',
        'soluong10',
        'dongia10',

        'quycach11',
        'soluong11',
        'dongia11',

        'quycach12',
        'soluong12',
        'dongia12',

        'quycach13',
        'soluong13',
        'dongia13',

        'quycach14',
        'soluong14',
        'dongia14',

        'quycach15',
        'soluong15',
        'dongia15',
        
        'trangthai',
        'username',
    ];
}
