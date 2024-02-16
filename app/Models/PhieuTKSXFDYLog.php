<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhieuTKSXFDYLog extends Model
{
    use HasFactory;

    protected $table = 'phieu_tksx_fdy_log';

    protected $fillable = [

        'so_phieu',
        'so',
        'line',
        'sale',
        'thong_tin_doi_ma',
        'ngay_du_dinh_thay_doi',
        'quy_cach_cu',
        'quy_cach_moi',
        'lot_cu',
        'lot_moi',
        'trong_luong_1',
        'trong_luong_2',
        'mau_ong_1',
        'mau_ong_2',
        'chip_1',
        'chip_2',
        'dau_1',
        'dau_2',
        'doan_1',
        'doan_2',
        'thong_tin_khac',
        'khach_hang',
        'so_luong',
        'ghi_chu',
        'qa_kien_nghi',
        'status',
        'created_user',
        'updated_user',
        'status_log',
        'is_delete'

    ];
}
