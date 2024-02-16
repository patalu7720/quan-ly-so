<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhieuTKSXLog extends Model
{
    use HasFactory;

    public $table = 'phieu_tksx_log';

    public $fillable = [

        'so_phieu',
        'so',
        'sale',
        'may',
        'quy_cach',
        'ma',
        'ngay',
        'thong_tin_doi_ma',
        'mau_ong',
        'soi',
        'ma_cu_moi',
        'quy_cach_poy',
        'ma_poy',
        'quy_cach_dty',
        'ma_dty',
        'khach_hang',
        'loai_hang',
        'so_luong_don_hang',
        'ghi_chu_so_luong',
        'dieu_kien_khach_hang', 
        'lot_sale',
        'qa_kien_nghi',
        'ly_do_rollback',
        'note_reject',
        
        'status',
        'updated_user',
        'created_user',
        'status_log',
        'is_delete'

    ];
}
