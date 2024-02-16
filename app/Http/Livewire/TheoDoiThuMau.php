<?php

namespace App\Http\Livewire;

use App\Mail\TheoDoiThuMauMail;
use App\Models\BenB;
use App\Models\TheoDoiThuMau as ModelsTheoDoiThuMau;
use App\Models\TheoDoiThuMauLog;
use App\Models\User;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;

class TheoDoiThuMau extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'page' => ['except' => 1],
    ];

    public $soPhieuTimKiem, $tenKhachHangTimKiem, $radioTimKiem;

    public ModelsTheoDoiThuMau $theoDoiThuMauModel;

    public $theoDoiThuMauLog;

    public $danhSachKhachHang;

    public $soPhieu, $state;

    protected $rules = [
        'theoDoiThuMauModel.ngay' => 'string',
        'theoDoiThuMauModel.ma_khach_hang' => 'string',
        'theoDoiThuMauModel.ten_khach_hang' => 'string',
        'theoDoiThuMauModel.dia_chi' => 'string',
        'theoDoiThuMauModel.loai_soi' => 'string',
        'theoDoiThuMauModel.lot' => 'string',
        'theoDoiThuMauModel.so_luong' => 'string',
        'theoDoiThuMauModel.ngay_giao' => 'string',
        'theoDoiThuMauModel.san_pham_cua_khach_hang' => 'string',
        'theoDoiThuMauModel.phan_loai_khach_hang' => 'string',
        'theoDoiThuMauModel.may_det' => 'string',
        'theoDoiThuMauModel.cau_truc_det' => 'string',
        'theoDoiThuMauModel.trang_thai' => 'string',
        'theoDoiThuMauModel.so_luong_tiem_nang' => 'string',
        'theoDoiThuMauModel.du_kien' => 'string',
        'theoDoiThuMauModel.sale_kien_nghi' => 'string',
        'theoDoiThuMauModel.qa_kien_nghi' => 'string',
        'theoDoiThuMauModel.thong_so_ky_thuat' => 'string',
        'theoDoiThuMauModel.ket_qua_det_vo' => 'string',
        'theoDoiThuMauModel.ket_qua_det_vai' => 'string',
        'theoDoiThuMauModel.ngay_giao_hang' => 'string',
        'theoDoiThuMauModel.ngay_nhan_vai_mau' => 'string',
        'theoDoiThuMauModel.ket_qua_thu_mau' => 'string',
        'theoDoiThuMauModel.don_hang_thuc_te' => 'string',
        'theoDoiThuMauModel.phan_hoi_khach_hang' => 'string',
    ];

    public function mount(){

        $this->state = 'main';
        $this->radioTimKiem = 'choDuyet';
        session()->forget('main');

    }

    public function resetInputField(){

    }

    public function create(){

        $this->state = 'create';
        $this->theoDoiThuMauModel = new ModelsTheoDoiThuMau();
        $this->theoDoiThuMauModel->ngay = Carbon::now()->isoFormat('YYYY-MM-DD');
        $this->theoDoiThuMauModel->ngay_giao = Carbon::now()->isoFormat('YYYY-MM-DD');

    }

    public function store()
    {
        DB::transaction(function(){

            $soPhieu = IdGenerator::generate(['table' => 'theo_doi_thu_maus', 'field' => 'so_phieu', 'length' => '8', 'prefix' => 'TDTM', 'reset_on_prefix_change' => true]);

            $benB = BenB::where('ma_khach_hang', $this->theoDoiThuMauModel->ma_khach_hang)->first();
    
            $this->theoDoiThuMauModel->so_phieu = $soPhieu;
            $this->theoDoiThuMauModel->ten_khach_hang = $benB->ten_tv;
            $this->theoDoiThuMauModel->status = 'Mới';
            $this->theoDoiThuMauModel->created_user = auth()->user()->username;
            $this->theoDoiThuMauModel->updated_user = auth()->user()->username;
            $this->theoDoiThuMauModel->sale_tao = auth()->user()->username;
            $this->theoDoiThuMauModel->sale_tao_at = Carbon::now();
            $this->theoDoiThuMauModel->save();
    
            $log = new TheoDoiThuMauLog();
            $log->so_phieu = $this->theoDoiThuMauModel->so_phieu;
            $log->ngay = $this->theoDoiThuMauModel->ngay;
            $log->ma_khach_hang = $this->theoDoiThuMauModel->ma_khach_hang;
            $log->ten_khach_hang = $this->theoDoiThuMauModel->ten_khach_hang;
            $log->dia_chi = $this->theoDoiThuMauModel->dia_chi;
            $log->loai_soi = $this->theoDoiThuMauModel->loai_soi;
            $log->lot = $this->theoDoiThuMauModel->lot;
            $log->so_luong = $this->theoDoiThuMauModel->so_luong;
            $log->ngay_giao = $this->theoDoiThuMauModel->ngay_giao;
            $log->san_pham_cua_khach_hang = $this->theoDoiThuMauModel->san_pham_cua_khach_hang;
            $log->phan_loai_khach_hang = $this->theoDoiThuMauModel->phan_loai_khach_hang;
            $log->may_det = $this->theoDoiThuMauModel->may_det;
            $log->cau_truc_det = $this->theoDoiThuMauModel->cau_truc_det;
            $log->trang_thai = $this->theoDoiThuMauModel->trang_thai;
            $log->so_luong_tiem_nang = $this->theoDoiThuMauModel->so_luong_tiem_nang;
            $log->du_kien = $this->theoDoiThuMauModel->du_kien;
            $log->sale_kien_nghi = $this->theoDoiThuMauModel->sale_kien_nghi;
            $log->qa_kien_nghi = $this->theoDoiThuMauModel->qa_kien_nghi;
            $log->thong_so_ky_thuat = $this->theoDoiThuMauModel->thong_so_ky_thuat;
            $log->ket_qua_det_vo = $this->theoDoiThuMauModel->ket_qua_det_vo;
            $log->ket_qua_det_vai = $this->theoDoiThuMauModel->ket_qua_det_vai;
            $log->ngay_giao_hang = $this->theoDoiThuMauModel->ngay_giao_hang;
            $log->ngay_nhan_vai_mau = $this->theoDoiThuMauModel->ngay_nhan_vai_mau;
            $log->ket_qua_thu_mau = $this->theoDoiThuMauModel->ket_qua_thu_mau;
            $log->don_hang_thuc_te = $this->theoDoiThuMauModel->don_hang_thuc_te;
            $log->phan_hoi_khach_hang = $this->theoDoiThuMauModel->phan_hoi_khach_hang;
            $log->status = 'Mới';
            $log->created_user = $this->theoDoiThuMauModel->created_user;
            $log->updated_user = $this->theoDoiThuMauModel->updated_user;
            $log->save();
    
            $arrayMail = [
                'Mới',
                $soPhieu,
                $this->theoDoiThuMauModel->ten_khach_hang,
            ];
    
            $user = User::permission('sm_duyet_tdtm')->first();
    
            flash()->addSuccess('Tạo phiếu thành công.');
            $this->emit('closeModal');
            $this->state = 'main';
            // Mail::to($user->email)->send(new TheoDoiThuMauMail($arrayMail));

        });
    }

    public function show($soPhieu){

        $this->state = 'show';
        $this->soPhieu = $soPhieu;

    }

    public function edit($soPhieu){

        $this->state = 'edit';
        $this->soPhieu = $soPhieu;

    }

    public function update(){

        DB::transaction(function(){

            $this->theoDoiThuMauModel->save();

            $log = new TheoDoiThuMauLog();
            $log->so_phieu = $this->theoDoiThuMauModel->so_phieu;
            $log->ngay = $this->theoDoiThuMauModel->ngay;
            $log->ma_khach_hang = $this->theoDoiThuMauModel->ma_khach_hang;
            $log->ten_khach_hang = $this->theoDoiThuMauModel->ten_khach_hang;
            $log->dia_chi = $this->theoDoiThuMauModel->dia_chi;
            $log->loai_soi = $this->theoDoiThuMauModel->loai_soi;
            $log->lot = $this->theoDoiThuMauModel->lot;
            $log->so_luong = $this->theoDoiThuMauModel->so_luong;
            $log->ngay_giao = $this->theoDoiThuMauModel->ngay_giao;
            $log->san_pham_cua_khach_hang = $this->theoDoiThuMauModel->san_pham_cua_khach_hang;
            $log->phan_loai_khach_hang = $this->theoDoiThuMauModel->phan_loai_khach_hang;
            $log->may_det = $this->theoDoiThuMauModel->may_det;
            $log->cau_truc_det = $this->theoDoiThuMauModel->cau_truc_det;
            $log->trang_thai = $this->theoDoiThuMauModel->trang_thai;
            $log->so_luong_tiem_nang = $this->theoDoiThuMauModel->so_luong_tiem_nang;
            $log->du_kien = $this->theoDoiThuMauModel->du_kien;
            $log->sale_kien_nghi = $this->theoDoiThuMauModel->sale_kien_nghi;
            $log->qa_kien_nghi = $this->theoDoiThuMauModel->qa_kien_nghi;
            $log->thong_so_ky_thuat = $this->theoDoiThuMauModel->thong_so_ky_thuat;
            $log->ket_qua_det_vo = $this->theoDoiThuMauModel->ket_qua_det_vo;
            $log->ket_qua_det_vai = $this->theoDoiThuMauModel->ket_qua_det_vai;
            $log->ngay_giao_hang = $this->theoDoiThuMauModel->ngay_giao_hang;
            $log->ngay_nhan_vai_mau = $this->theoDoiThuMauModel->ngay_nhan_vai_mau;
            $log->ket_qua_thu_mau = $this->theoDoiThuMauModel->ket_qua_thu_mau;
            $log->don_hang_thuc_te = $this->theoDoiThuMauModel->don_hang_thuc_te;
            $log->phan_hoi_khach_hang = $this->theoDoiThuMauModel->phan_hoi_khach_hang;
            $log->status = 'Cập nhật';
            $log->created_user = $this->theoDoiThuMauModel->created_user;
            $log->updated_user = $this->theoDoiThuMauModel->updated_user;
            $log->save();
    
            flash()->addSuccess('Cập nhật phiếu thành công.');
            $this->emit('closeModal');
            $this->state = 'main';

        });

    }

    public function timKiem(){

        $this->state = 'timKiem';

    }

    public function delete($soPhieu){

        $this->state = 'delete';
        $this->soPhieu = $soPhieu;

    }

    public function destroy(){

        DB::transaction(function(){

            $item = ModelsTheoDoiThuMau::where('so_phieu', $this->soPhieu)->first();
    
            $log = new TheoDoiThuMauLog();
            $log->so_phieu = $item->so_phieu;
            $log->ngay = $item->ngay;
            $log->ma_khach_hang = $item->ma_khach_hang;
            $log->ten_khach_hang = $item->ten_khach_hang;
            $log->dia_chi = $item->dia_chi;
            $log->loai_soi = $item->loai_soi;
            $log->lot = $item->lot;
            $log->so_luong = $item->so_luong;
            $log->ngay_giao = $item->ngay_giao;
            $log->san_pham_cua_khach_hang = $item->san_pham_cua_khach_hang;
            $log->phan_loai_khach_hang = $item->phan_loai_khach_hang;
            $log->may_det = $item->may_det;
            $log->cau_truc_det = $item->cau_truc_det;
            $log->trang_thai = $item->trang_thai;
            $log->so_luong_tiem_nang = $item->so_luong_tiem_nang;
            $log->du_kien = $item->du_kien;
            $log->sale_kien_nghi = $item->sale_kien_nghi;
            $log->qa_kien_nghi = $item->qa_kien_nghi;
            $log->thong_so_ky_thuat = $item->thong_so_ky_thuat;
            $log->ket_qua_det_vo = $item->ket_qua_det_vo;
            $log->ket_qua_det_vai = $item->ket_qua_det_vai;
            $log->ngay_giao_hang = $item->ngay_giao_hang;
            $log->ngay_nhan_vai_mau = $item->ngay_nhan_vai_mau;
            $log->ket_qua_thu_mau = $item->ket_qua_thu_mau;
            $log->don_hang_thuc_te = $item->don_hang_thuc_te;
            $log->phan_hoi_khach_hang = $item->phan_hoi_khach_hang;
            $log->status = 'Xóa';
            $log->created_user = $item->created_user;
            $log->updated_user = $item->updated_user;
            $log->save();
    
            $item->delete();
    
            flash()->addSuccess('Cập nhật phiếu thành công.');
            $this->emit('closeModal');
            $this->state = 'main';

        });

    }

    public function approveModal($soPhieu){

        $this->state = 'approve';
        $this->soPhieu = $soPhieu;

    }

    public function approve(){

        DB::transaction(function(){

            if ($this->theoDoiThuMauModel->status == 'Mới') {

                $this->theoDoiThuMauModel->sm_duyet = auth()->user()->username;
                $this->theoDoiThuMauModel->sm_duyet_at = Carbon::now();
                $this->theoDoiThuMauModel->updated_user = auth()->user()->username;
                $this->theoDoiThuMauModel->status = 'SM đã duyệt';
                $this->theoDoiThuMauModel->save();

                $log = new TheoDoiThuMauLog();
                $log->so_phieu = $this->theoDoiThuMauModel->so_phieu;
                $log->ngay = $this->theoDoiThuMauModel->ngay;
                $log->ma_khach_hang = $this->theoDoiThuMauModel->ma_khach_hang;
                $log->ten_khach_hang = $this->theoDoiThuMauModel->ten_khach_hang;
                $log->dia_chi = $this->theoDoiThuMauModel->dia_chi;
                $log->loai_soi = $this->theoDoiThuMauModel->loai_soi;
                $log->lot = $this->theoDoiThuMauModel->lot;
                $log->so_luong = $this->theoDoiThuMauModel->so_luong;
                $log->ngay_giao = $this->theoDoiThuMauModel->ngay_giao;
                $log->san_pham_cua_khach_hang = $this->theoDoiThuMauModel->san_pham_cua_khach_hang;
                $log->phan_loai_khach_hang = $this->theoDoiThuMauModel->phan_loai_khach_hang;
                $log->may_det = $this->theoDoiThuMauModel->may_det;
                $log->cau_truc_det = $this->theoDoiThuMauModel->cau_truc_det;
                $log->trang_thai = $this->theoDoiThuMauModel->trang_thai;
                $log->so_luong_tiem_nang = $this->theoDoiThuMauModel->so_luong_tiem_nang;
                $log->du_kien = $this->theoDoiThuMauModel->du_kien;
                $log->sale_kien_nghi = $this->theoDoiThuMauModel->sale_kien_nghi;
                $log->qa_kien_nghi = $this->theoDoiThuMauModel->qa_kien_nghi;
                $log->thong_so_ky_thuat = $this->theoDoiThuMauModel->thong_so_ky_thuat;
                $log->ket_qua_det_vo = $this->theoDoiThuMauModel->ket_qua_det_vo;
                $log->ket_qua_det_vai = $this->theoDoiThuMauModel->ket_qua_det_vai;
                $log->ngay_giao_hang = $this->theoDoiThuMauModel->ngay_giao_hang;
                $log->ngay_nhan_vai_mau = $this->theoDoiThuMauModel->ngay_nhan_vai_mau;
                $log->ket_qua_thu_mau = $this->theoDoiThuMauModel->ket_qua_thu_mau;
                $log->don_hang_thuc_te = $this->theoDoiThuMauModel->don_hang_thuc_te;
                $log->phan_hoi_khach_hang = $this->theoDoiThuMauModel->phan_hoi_khach_hang;
                $log->status = 'Duyệt';
                $log->created_user = $this->theoDoiThuMauModel->created_user;
                $log->updated_user = $this->theoDoiThuMauModel->updated_user;
                $log->save();
    
                $arrayMail = [
                    'SM đã duyệt',
                    $this->theoDoiThuMauModel->so_phieu,
                    $this->theoDoiThuMauModel->ten_khach_hang,
                ];
    
                Mail::to('qa@century.vn')->send(new TheoDoiThuMauMail($arrayMail));
    
            }elseif ($this->theoDoiThuMauModel->status == 'SM đã duyệt'){
    
                $this->theoDoiThuMauModel->qa_duyet = auth()->user()->username;
                $this->theoDoiThuMauModel->qa_duyet_at = Carbon::now();
                $this->theoDoiThuMauModel->updated_user = auth()->user()->username;
                $this->theoDoiThuMauModel->status = 'QA đã duyệt';
                $this->theoDoiThuMauModel->save();

                $log = new TheoDoiThuMauLog();
                $log->so_phieu = $this->theoDoiThuMauModel->so_phieu;
                $log->ngay = $this->theoDoiThuMauModel->ngay;
                $log->ma_khach_hang = $this->theoDoiThuMauModel->ma_khach_hang;
                $log->ten_khach_hang = $this->theoDoiThuMauModel->ten_khach_hang;
                $log->dia_chi = $this->theoDoiThuMauModel->dia_chi;
                $log->loai_soi = $this->theoDoiThuMauModel->loai_soi;
                $log->lot = $this->theoDoiThuMauModel->lot;
                $log->so_luong = $this->theoDoiThuMauModel->so_luong;
                $log->ngay_giao = $this->theoDoiThuMauModel->ngay_giao;
                $log->san_pham_cua_khach_hang = $this->theoDoiThuMauModel->san_pham_cua_khach_hang;
                $log->phan_loai_khach_hang = $this->theoDoiThuMauModel->phan_loai_khach_hang;
                $log->may_det = $this->theoDoiThuMauModel->may_det;
                $log->cau_truc_det = $this->theoDoiThuMauModel->cau_truc_det;
                $log->trang_thai = $this->theoDoiThuMauModel->trang_thai;
                $log->so_luong_tiem_nang = $this->theoDoiThuMauModel->so_luong_tiem_nang;
                $log->du_kien = $this->theoDoiThuMauModel->du_kien;
                $log->sale_kien_nghi = $this->theoDoiThuMauModel->sale_kien_nghi;
                $log->qa_kien_nghi = $this->theoDoiThuMauModel->qa_kien_nghi;
                $log->thong_so_ky_thuat = $this->theoDoiThuMauModel->thong_so_ky_thuat;
                $log->ket_qua_det_vo = $this->theoDoiThuMauModel->ket_qua_det_vo;
                $log->ket_qua_det_vai = $this->theoDoiThuMauModel->ket_qua_det_vai;
                $log->ngay_giao_hang = $this->theoDoiThuMauModel->ngay_giao_hang;
                $log->ngay_nhan_vai_mau = $this->theoDoiThuMauModel->ngay_nhan_vai_mau;
                $log->ket_qua_thu_mau = $this->theoDoiThuMauModel->ket_qua_thu_mau;
                $log->don_hang_thuc_te = $this->theoDoiThuMauModel->don_hang_thuc_te;
                $log->phan_hoi_khach_hang = $this->theoDoiThuMauModel->phan_hoi_khach_hang;
                $log->status = 'Duyệt';
                $log->created_user = $this->theoDoiThuMauModel->created_user;
                $log->updated_user = $this->theoDoiThuMauModel->updated_user;
                $log->save();
    
                $arrayMail = [
                    'QA đã duyệt',
                    $this->theoDoiThuMauModel->so_phieu,
                    $this->theoDoiThuMauModel->ten_khach_hang,
                ];
    
                Mail::to('khth@century.vn')->send(new TheoDoiThuMauMail($arrayMail));
    
            }elseif ($this->theoDoiThuMauModel->status == 'QA đã duyệt'){
    
                $this->theoDoiThuMauModel->khst_duyet = auth()->user()->username;
                $this->theoDoiThuMauModel->khst_duyet_at = Carbon::now();
                $this->theoDoiThuMauModel->updated_user = auth()->user()->username;
                $this->theoDoiThuMauModel->status = 'KHST đã duyệt';
                $this->theoDoiThuMauModel->save();

                $log = new TheoDoiThuMauLog();
                $log->so_phieu = $this->theoDoiThuMauModel->so_phieu;
                $log->ngay = $this->theoDoiThuMauModel->ngay;
                $log->ma_khach_hang = $this->theoDoiThuMauModel->ma_khach_hang;
                $log->ten_khach_hang = $this->theoDoiThuMauModel->ten_khach_hang;
                $log->dia_chi = $this->theoDoiThuMauModel->dia_chi;
                $log->loai_soi = $this->theoDoiThuMauModel->loai_soi;
                $log->lot = $this->theoDoiThuMauModel->lot;
                $log->so_luong = $this->theoDoiThuMauModel->so_luong;
                $log->ngay_giao = $this->theoDoiThuMauModel->ngay_giao;
                $log->san_pham_cua_khach_hang = $this->theoDoiThuMauModel->san_pham_cua_khach_hang;
                $log->phan_loai_khach_hang = $this->theoDoiThuMauModel->phan_loai_khach_hang;
                $log->may_det = $this->theoDoiThuMauModel->may_det;
                $log->cau_truc_det = $this->theoDoiThuMauModel->cau_truc_det;
                $log->trang_thai = $this->theoDoiThuMauModel->trang_thai;
                $log->so_luong_tiem_nang = $this->theoDoiThuMauModel->so_luong_tiem_nang;
                $log->du_kien = $this->theoDoiThuMauModel->du_kien;
                $log->sale_kien_nghi = $this->theoDoiThuMauModel->sale_kien_nghi;
                $log->qa_kien_nghi = $this->theoDoiThuMauModel->qa_kien_nghi;
                $log->thong_so_ky_thuat = $this->theoDoiThuMauModel->thong_so_ky_thuat;
                $log->ket_qua_det_vo = $this->theoDoiThuMauModel->ket_qua_det_vo;
                $log->ket_qua_det_vai = $this->theoDoiThuMauModel->ket_qua_det_vai;
                $log->ngay_giao_hang = $this->theoDoiThuMauModel->ngay_giao_hang;
                $log->ngay_nhan_vai_mau = $this->theoDoiThuMauModel->ngay_nhan_vai_mau;
                $log->ket_qua_thu_mau = $this->theoDoiThuMauModel->ket_qua_thu_mau;
                $log->don_hang_thuc_te = $this->theoDoiThuMauModel->don_hang_thuc_te;
                $log->phan_hoi_khach_hang = $this->theoDoiThuMauModel->phan_hoi_khach_hang;
                $log->status = 'Duyệt';
                $log->created_user = $this->theoDoiThuMauModel->created_user;
                $log->updated_user = $this->theoDoiThuMauModel->updated_user;
                $log->save();
    
                $arrayMail = [
                    'KHST đã duyệt',
                    $this->theoDoiThuMauModel->so_phieu,
                    $this->theoDoiThuMauModel->ten_khach_hang,
                ];
    
                $user = User::where('username', $this->theoDoiThuMauModel->created_user)->first();
    
                Mail::to($user->email)->send(new TheoDoiThuMauMail($arrayMail));
    
            }elseif ($this->theoDoiThuMauModel->status == 'KHST đã duyệt'){
    
                $this->theoDoiThuMauModel->finish = auth()->user()->username;
                $this->theoDoiThuMauModel->finish_at = Carbon::now();
                $this->theoDoiThuMauModel->updated_user = auth()->user()->username;
                $this->theoDoiThuMauModel->status = 'Finish';
                $this->theoDoiThuMauModel->save();

                $log = new TheoDoiThuMauLog();
                $log->so_phieu = $this->theoDoiThuMauModel->so_phieu;
                $log->ngay = $this->theoDoiThuMauModel->ngay;
                $log->ma_khach_hang = $this->theoDoiThuMauModel->ma_khach_hang;
                $log->ten_khach_hang = $this->theoDoiThuMauModel->ten_khach_hang;
                $log->dia_chi = $this->theoDoiThuMauModel->dia_chi;
                $log->loai_soi = $this->theoDoiThuMauModel->loai_soi;
                $log->lot = $this->theoDoiThuMauModel->lot;
                $log->so_luong = $this->theoDoiThuMauModel->so_luong;
                $log->ngay_giao = $this->theoDoiThuMauModel->ngay_giao;
                $log->san_pham_cua_khach_hang = $this->theoDoiThuMauModel->san_pham_cua_khach_hang;
                $log->phan_loai_khach_hang = $this->theoDoiThuMauModel->phan_loai_khach_hang;
                $log->may_det = $this->theoDoiThuMauModel->may_det;
                $log->cau_truc_det = $this->theoDoiThuMauModel->cau_truc_det;
                $log->trang_thai = $this->theoDoiThuMauModel->trang_thai;
                $log->so_luong_tiem_nang = $this->theoDoiThuMauModel->so_luong_tiem_nang;
                $log->du_kien = $this->theoDoiThuMauModel->du_kien;
                $log->sale_kien_nghi = $this->theoDoiThuMauModel->sale_kien_nghi;
                $log->qa_kien_nghi = $this->theoDoiThuMauModel->qa_kien_nghi;
                $log->thong_so_ky_thuat = $this->theoDoiThuMauModel->thong_so_ky_thuat;
                $log->ket_qua_det_vo = $this->theoDoiThuMauModel->ket_qua_det_vo;
                $log->ket_qua_det_vai = $this->theoDoiThuMauModel->ket_qua_det_vai;
                $log->ngay_giao_hang = $this->theoDoiThuMauModel->ngay_giao_hang;
                $log->ngay_nhan_vai_mau = $this->theoDoiThuMauModel->ngay_nhan_vai_mau;
                $log->ket_qua_thu_mau = $this->theoDoiThuMauModel->ket_qua_thu_mau;
                $log->don_hang_thuc_te = $this->theoDoiThuMauModel->don_hang_thuc_te;
                $log->phan_hoi_khach_hang = $this->theoDoiThuMauModel->phan_hoi_khach_hang;
                $log->status = 'Duyệt';
                $log->created_user = $this->theoDoiThuMauModel->created_user;
                $log->updated_user = $this->theoDoiThuMauModel->updated_user;
                $log->save();
    
            }
    
            flash()->addSuccess('Duyệt phiếu thành công.');
            $this->emit('closeModal');
            $this->state = 'main';

        });
    }

    public function render()
    {
        if($this->state == 'main' || $this->state == 'timKiem'){

            $queryString = ModelsTheoDoiThuMau::query();

            $queryString->where(function($query){

                $query->whereRaw("'" . $this->soPhieuTimKiem . "' = ''");
                $query->orWhere('so_phieu', $this->soPhieuTimKiem);
    
            });

            $queryString->where(function($query){

                $query->whereRaw("'" . $this->tenKhachHangTimKiem . "' = ''");
                $query->orWhere('ten_khach_hang', 'like', '%' . $this->tenKhachHangTimKiem . '%');
    
            });

            if (auth()->user()->hasPermissionTo('create_tdtm')) {
                if ($this->radioTimKiem == 'choDuyet') {
                    $queryString->where('created_user', auth()->user()->username);
                    $queryString->where('status', '!=', 'Finish');
                }elseif ($this->radioTimKiem == 'daDuyet'){dd(1);
                    $queryString->where('created_user', auth()->user()->username);
                    $queryString->where('status', 'Finish');
                }
            }elseif (auth()->user()->hasPermissionTo('sm_duyet_tdtm')) {
                if ($this->radioTimKiem == 'choDuyet') {
                    $queryString->where('status', 'Mới');
                }elseif ($this->radioTimKiem == 'daDuyet'){
                    $queryString->where('sm_duyet', auth()->user()->username);
                }
            }elseif (auth()->user()->hasPermissionTo('qa_duyet_tdtm')) {
                if ($this->radioTimKiem == 'choDuyet') {
                    $queryString->where('status', 'SM đã duyệt');
                }elseif ($this->radioTimKiem == 'daDuyet'){
                    $queryString->where('qa_duyet', auth()->user()->username);
                }
            }elseif (auth()->user()->hasPermissionTo('khst_duyet_tdtm')) {
                if ($this->radioTimKiem == 'choDuyet') {
                    $queryString->where('status', 'QA đã duyệt');
                }elseif ($this->radioTimKiem == 'daDuyet'){
                    $queryString->where('khst_duyet', auth()->user()->username);
                }
            }
    
            session(['main' => $queryString->paginate(15)]);

        }elseif($this->state == 'create'){

            $this->danhSachKhachHang = BenB::all();

        }elseif($this->state == 'show'){

            $this->theoDoiThuMauModel = ModelsTheoDoiThuMau::where('so_phieu', $this->soPhieu)->first();
            $this->theoDoiThuMauLog = TheoDoiThuMauLog::where('so_phieu', $this->soPhieu)->get();

        }elseif($this->state == 'edit'){

            $this->danhSachKhachHang = BenB::all();
            $this->theoDoiThuMauModel = ModelsTheoDoiThuMau::where('so_phieu', $this->soPhieu)->first();

        }elseif($this->state == 'delete'){

            $this->theoDoiThuMauModel = ModelsTheoDoiThuMau::where('so_phieu', $this->soPhieu)->first();

        }elseif($this->state == 'approve'){

            $this->theoDoiThuMauModel = ModelsTheoDoiThuMau::where('so_phieu', $this->soPhieu)->first();

        }

        return view('livewire.theo-doi-thu-mau');
    }
}
