<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HopDong extends Model
{
    use HasFactory;

    protected $table = 'hop_dong';

    protected $fillable = [
        'sohd',
        'loaihopdong',
        'so_tdg',
        'ngaylaphd',
        'ngayhethanhd',

        'bena',
        'dai_dien_ben_a',
        'benb',

        'sotaikhoan',
        'chutaikhoan',

        'sotaikhoan_ta',
        'chutaikhoan_ta',
        
        'tygia',
        'chatluong',
        'donggoi',
        'thoigianthanhtoan',
        'phuongthucthanhtoan',
        'diadiemgiaohang',
        'diachi_diadiemgiaohang',
        'thoigiangiaohang',
        'phuongthucgiaohang',
        'giaohangtungphan',
        'phivanchuyen',

        'chatluong_ta',
        'donggoi_ta',
        'vat',
        'thoigianthanhtoan_ta',
        'phuongthucthanhtoan_ta',
        'diadiemgiaohang_ta',
        'diachi_diadiemgiaohang_ta',
        'phuongthucgiaohang_ta',
        'phivanchuyen_ta',

        'soluongbanin',

        'cpt',
        'po',

        'trungchuyen',
        'loadingport',
        'dischargport',

        'tinhtrang',
        'ly_do_reject',
        'username_approve',

        'username',
    ];
}
