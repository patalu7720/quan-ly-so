<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhieuTKSXFDY extends Model
{
    use HasFactory;

    protected $table = 'phieu_tksx_fdy';

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
        'is_delete',

        'new',
        'new_at',
        'khst_approved',
        'khst_approved_at',
        'qa_approved',
        'qa_approved_at',
        'sale_approved',
        'sale_approved_at',
        'sm_approved',
        'sm_approved_at',
        'finish',
        'finish_at',

    ];
}
