<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaiKhoanNganHangNgoaiLe extends Model
{
    use HasFactory;

    protected $table = 'tai_khoan_ngan_hang_ngoai_le';

    public $fillable = [
        'cong_ty_chi_nhanh',
        'noi_dia_xuat_khau',
        'ma_khach_hang',
        'so_tai_khoan_tv',
        'chu_tai_khoan_tv',
        'so_tai_khoan_ta',
        'chu_tai_khoan_ta'
    ];

}
