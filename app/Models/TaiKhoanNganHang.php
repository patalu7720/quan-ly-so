<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaiKhoanNganHang extends Model
{
    use HasFactory;

    protected $table = 'tai_khoan_ngan_hang';

    public $fillable = [
        'cong_ty_chi_nhanh',
        'noi_dia_xuat_khau',
        'so_tai_khoan_tv',
        'chu_tai_khoan_tv',
        'so_tai_khoan_ta',
        'chu_tai_khoan_ta'
    ];
}
