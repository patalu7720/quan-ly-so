<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhieuTKSX extends Model
{
    use HasFactory;

    public $table = 'phieu_tksx';

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
        'qa_kien_nghi',

        'status',
        'updated_user',
        'created_user',
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

        'note_reject',
        'reject',
        'reject_at'

    ];
}
