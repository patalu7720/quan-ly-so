<?php

namespace App\Http\Livewire;

use App\Jobs\SendMailPhieuXXDHJob;
use App\Jobs\SendMailPhieuXXDHSaleToKhst;
use App\Mail\NewContractMail;
use App\Mail\PhieuXXDH as MailPhieuXXDH;
use App\Mail\PhieuXXDHSaleToKhst;
use App\Models\BenB;
use App\Models\EmailQuanLy;
use App\Models\LoaiHopDong;
use App\Models\LoaiMayDet;
use App\Models\PhanBoPTKSX;
use App\Models\PhieuTKSX;
use App\Models\PhieuXXDH as ModelsPhieuXXDH;
use App\Models\PhieuXXDHLog;
use App\Models\QuyCachPhieuXXDH;
use App\Models\QuyCachPhieuXXDHKHST;
use App\Models\QuyCachPhieuXXDHKHSTLog;
use App\Models\QuyCachPhieuXXDHLog;
use App\Models\RealTimeProcessPhieuXXDH;
use App\Models\SO;
use App\Models\SO7;
use App\Models\SOTam;
use App\Models\User;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpWord\TemplateProcessor;

class PhieuXXDH extends Component
{
    public $canhan_tatca, $phieuXXDHOld, $lichDuKien, $lichDuKienEdit;

    public $loaiDonHang,$soPhieu ,$donHangGRS, $donHangNonGRS, $donHangSXMoi ,$donHangLapLai ,$donHangTonKho ,$date ,$tenCongTy ,$soSO, $soSOTam, $soHD, $soHDTam ,$quyCachSuDung ,$soLuong ,$soCone;

    public $soKgCone, $qaKienNghi, $Line, $May, $ngayGiaoHang, $ngayBatDauGiao, $kieuMayDet, $lot, $thanhPhamCuaKhachHang, $phanAnhCuaKhachHang , $status, $phanHoiKHST, $phanHoiQA, $thongTinDongGoi;

    public $quyCachPhieuXXDHKHST, $quyCachSuDungKHST, $soLuongKHST, $lotKHST, $listThongTinDongGoi, $listPallet, $listRecycle, $pallet, $recycle;

    public $quyCachSuDungEdit, $soLuongEdit, $kieuMayDetEdit, $lotEdit;

    public $quyCachSuDungKHSTEdit, $soLuongKHSTEdit, $lotKHSTEdit;

    public $mailChinh, $mailPhu1, $mailPhu2;

    public $proccess;

    public $paginate;

    public $inputs = [], $i = 0;

    public $inputs_khst = [], $i_khst = 0;

    public $quyCachPhieuXXDH;

    public $capRollBack;

    public $search, $tuNgay, $denNgay;

    protected $search_result;

    public $cbCC, $cbTB2, $cbTB3;

    public $log;

    public $checkPhieuXXDHHasRollback;
    public $loaiDonHangLog;
    public $donHangGRSLog;
    public $donHangNonGRSLog;
    public $donHangSXMoiLog;
    public $donHangLapLaiLog;
    public $donHangTonKhoLog;
    public $dateLog;
    public $tenCongTyLog;
    public $soSOLog;
    public $soHDLog;
    public $soConeLog;
    public $soKgConeLog;
    public $qaKienNghiLog;
    public $LineLog;
    public $MayLog;
    public $ngayGiaoHangLog;
    public $ngayBatDauGiaoLog;
    public $kieuMayDetLog;
    public $thanhPhamCuaKhachHangLog;
    public $phanAnhCuaKhachHangLog;
    public $thongTinDongGoiLog;
    public $statusLog;
    public $phanHoiKHSTLog;
    public $phanHoiQALog;

    public $lyDoRollback;

    public $soConeEdit, $soKgConeEdit, $LineEdit, $MayEdit, $ngayGiaoHangEdit, $ngayBatDauGiaoEdit, $thanhPhamCuaKhachHangEdit, $phanAnhCuaKhachHangEdit;

    public $thongTinDongGoiEdit, $palletEdit, $recycleEdit;

    public $state;

    public $danhSachFile;

    public $soChinhThuc;

    public $danhSachLoaiMayDet;

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function mount(){

        $this->paginate = 15;
        $this->loaiDonHang = 'dht';
        $this->date = Carbon::now()->isoFormat('YYYY-MM-DD');

        $this->canhan_tatca = 'phieuDoiDuyet';
        
        if(Auth::user()->hasPermissionTo('phan_bo_pxxdh')){

            $this->canhan_tatca = 'phieuChuaPhanBo';

        }

        if(Auth::user()->hasPermissionTo('view_pxxdhs')){

            $this->canhan_tatca = 'tatca';

        }
    }

    public function resetInputField(){

        $this->deleteProccess($this->soPhieu);

        $this->soPhieu = '';
        $this->donHangGRS = 0;
        $this->donHangNonGRS = 0;
        $this->donHangSXMoi = 0;
        $this->donHangLapLai = 0;
        $this->donHangTonKho = 0;
        $this->date = '';
        $this->tenCongTy = '';

        $this->soSO = '';
        $this->soSOTam = '';
        $this->soHD = '';
        $this->soHDTam = '';
        
        $this->thanhPhamCuaKhachHang = '';
        $this->phanAnhCuaKhachHang = '';

        $this->loaiDonHang = 'dht';
        $this->inputs = [];
        $this->inputs_khst = [];
        $this->i = 0;
        $this->i_khst = 0;

        $this->quyCachSuDung = '';
        $this->soLuong = '';
        $this->lot = '';
        $this->kieuMayDet = '';

        $this->quyCachSuDungKHST = '';
        $this->soLuongKHST = '';
        $this->lotKHST = '';

        $this->proccess = '';

        $this->cbCC = 0;
        $this->cbTB2 = 0;
        $this->cbTB3 = 0;

        $this->thongTinDongGoi = '';
        $this->log = '';

        $this->lyDoRollback = '';

        $this->listThongTinDongGoi = null;
        $this->listPallet = null;
        $this->listRecycle = null;

        $this->lichDuKien = null;
        $this->lichDuKienEdit = null;

    }

    public function resetInputFieldView(){

        $this->soPhieu = '';
        $this->donHangGRS = 0;
        $this->donHangNonGRS = 0;
        $this->donHangSXMoi = 0;
        $this->donHangLapLai = 0;
        $this->donHangTonKho = 0;
        $this->date = '';
        $this->tenCongTy = '';
       
        $this->soSO = '';
        $this->soSOTam = '';
        $this->soHD = '';
        $this->soHDTam = '';
        
        // $this->soCone = '';
        // $this->soKgCone = '';
        // $this->qaKienNghi = '';
        // $this->Line = '';
        // $this->May = '';
        // $this->ngayGiaoHang = '';
        // $this->ngayBatDauGiao = '';
        // $this->thanhPhamCuaKhachHang = '';
        // $this->phanAnhCuaKhachHang = '';
        // $this->pallet = '';
        // $this->recycle = '';

        // $this->soConeEdit = '';
        // $this->soKgConeEdit = '';
        // $this->LineEdit = '';
        // $this->MayEdit = '';
        // $this->ngayGiaoHangEdit = '';
        // $this->ngayBatDauGiaoEdit = '';
        // $this->thanhPhamCuaKhachHangEdit = '';
        // $this->phanAnhCuaKhachHangEdit = '';
        // $this->palletEdit = '';
        // $this->recycleEdit = '';

        $this->loaiDonHang = 'dht';
        $this->inputs = [];
        $this->inputs_khst = [];
        $this->i = 0;
        $this->i_khst = 0;

        $this->quyCachSuDung = '';
        $this->soLuong = '';
        $this->lot = '';
        $this->kieuMayDet = '';

        $this->quyCachSuDungKHST = '';
        $this->soLuongKHST = '';
        $this->lotKHST = '';

        $this->proccess = '';

        $this->cbCC = 0;
        $this->cbTB2 = 0;
        $this->cbTB3 = 0;

        $this->thongTinDongGoi = '';
        $this->log = '';

        $this->lyDoRollback = '';

        $this->listThongTinDongGoi = null;
        $this->listPallet = null;
        $this->listRecycle = null;

    }

    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs ,$i);
    }

    public function remove($i)
    {
        unset($this->inputs[$i]);
    }

    public function addKHST($i_khst)
    {
        $i_khst = $i_khst + 1;
        $this->i_khst = $i_khst;
        array_push($this->inputs_khst ,$i_khst);
    }

    public function removeKHST($i_khst)
    {
        unset($this->inputs_khst[$i_khst]);
    }

    public function timThongTinSO(){

        $result =  SO7::select('NAME1')
        ->where('VBELN', $this->soSO)
        ->first();

        if($result != null){

            $this->tenCongTy = $result->NAME1;

        }else{

            $this->tenCongTy = '';

        }
        
    }

    public function addPhieuXXDH(){

        DB::transaction( function(){

            $this->soPhieu = IdGenerator::generate(['table' => 'phieu_xxdh', 'field' => 'so_phieu', 'length' => '14', 'prefix' => 'XXDH-' . Carbon::now()->isoFormat('DDMMYY') . '-','reset_on_prefix_change' => true]);

            $laySo = SO::where('so', trim($this->soSO))->first();

            if( $laySo != null ){

                if(!empty($laySo->phieu_xxdh)){

                    flash()->addFlash('error', 'Số SO đã được sử dụng','Thông báo');
                    return;

                }else{

                    $laySo->update([

                        'phieu_xxdh' => $this->soPhieu,
                        'status_phieu_xxdh' => '0',
                        'hop_dong' => $this->soHD

                    ]);

                }
                
            }else{

                $soTam = SOTam::where('so_tam', trim($this->soSO))->first();

                if($soTam != null){

                    $soTam->so_phieu_xxdh = $this->soPhieu;
                    $soTam->updated_user = auth()->user()->username;

                    $soTam->save();

                }

                SO::create([

                    'so' => trim($this->soSO),
                    'hop_dong' => $this->soHD,
                    'phieu_xxdh' => $this->soPhieu,
                    'status_phieu_xxdh' => '0',
    
                ]);

            }
            
            $arr_phieu_xxdh = [

                'so_phieu' => $this->soPhieu,
                'loai' => $this->loaiDonHang,
                'don_hang_grs' => $this->donHangGRS,
                'don_hang_non_grs' => $this->donHangNonGRS,
                'don_hang_sx_moi' => $this->donHangSXMoi,
                'don_hang_lap_lai' => $this->donHangLapLai,
                'don_hang_ton_kho' => $this->donHangTonKho,
                'date' => $this->date,
                'ten_cong_ty' => $this->tenCongTy,
                'so' => trim($this->soSO),
                'hop_dong' => $this->soHD,
                'mail_chinh' => $this->mailChinh,
                'mail_phu_1' => $this->mailPhu1,
                'mail_phu_2' => $this->mailPhu2,
                'status' => 'New',
                'new' => Auth::user()->username,
                'new_at' => Carbon::now(),
                'created_user' => Auth::user()->username,
                'updated_user' => Auth::user()->username,

            ];

            $PhieuXXDH = ModelsPhieuXXDH::create($arr_phieu_xxdh);

            $arr_phieu_xxdh = array_merge($arr_phieu_xxdh, [

                'status_log' => 'New',

            ]);

            $PhieuXXDHLog = PhieuXXDHLog::create($arr_phieu_xxdh);

            foreach (array_reverse($this->quyCachSuDung, true) as $key => $value) {

                QuyCachPhieuXXDH::create([

                    'phieu_xxdh_so_phieu_id' => $PhieuXXDH->id,
                    'quy_cach' => $this->quyCachSuDung[$key],
                    'so_luong' => $this->soLuong[$key],
                    'status' => 'Sale',

                ]);

                QuyCachPhieuXXDHLog::create([

                    'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                    'quy_cach' => $this->quyCachSuDung[$key],
                    'so_luong' => $this->soLuong[$key],
                    'status' => 'Sale',

                ]);
            }

            $cc = [];

            if($this->mailPhu1 != null){

                $cc = array_merge($cc, [

                    $this->mailPhu1,

                ]);

            }

            if($this->mailPhu2 != null){

                $cc = array_merge($cc, [

                    $this->mailPhu2

                ]);

            }

            Mail::to($this->mailChinh)
            ->cc($cc)
            ->send(new MailPhieuXXDH('New',$this->soPhieu, Auth::user()->username, $PhieuXXDH->created_at, ''));

            flash()->addFlash('success', 'Tạo thành công phiếu : ' . $this->soPhieu,'Thông báo');
            $this->resetInputField();
            $this->emit('addPhieuXXDHModal');

        });

    }

    public function viewPhieuXXDHModal($soPhieu){

        $this->soPhieu = $soPhieu;

        $phieuXXDH = ModelsPhieuXXDH::where('so_phieu', $soPhieu)->orderBy('id')->first();

        $this->soPhieu = $phieuXXDH->so_phieu;
        $this->loaiDonHang = $phieuXXDH->loai;
        $this->donHangGRS = $phieuXXDH->don_hang_grs;
        $this->donHangNonGRS = $phieuXXDH->don_hang_non_grs;
        $this->donHangSXMoi = $phieuXXDH->don_hang_sx_moi;
        $this->donHangLapLai = $phieuXXDH->don_hang_lap_lai;
        $this->donHangTonKho = $phieuXXDH->don_hang_ton_kho;

        if($phieuXXDH->date != '')
            $this->date = Carbon::create($phieuXXDH->date)->isoFormat('DD-MM-YYYY');
        else
            $this->date = $phieuXXDH->date;

        $this->tenCongTy = $phieuXXDH->ten_cong_ty;
        $this->soSO = $phieuXXDH->so;
        $this->soHD = $phieuXXDH->hop_dong;
        $this->soCone = $phieuXXDH->so_cone;
        $this->soKgCone = $phieuXXDH->so_kg_cone;
        $this->qaKienNghi = $phieuXXDH->qa_kien_nghi;
        $this->Line = $phieuXXDH->line;
        $this->May = $phieuXXDH->may;

        if($phieuXXDH->ngay_giao_hang != '')
            $this->ngayGiaoHang = Carbon::create($phieuXXDH->ngay_giao_hang)->isoFormat('DD-MM-YYYY');
        else
            $this->ngayGiaoHang = $phieuXXDH->ngay_giao_hang;

        if($phieuXXDH->ngay_bat_dau_giao != '')
            $this->ngayBatDauGiao = Carbon::create($phieuXXDH->ngay_bat_dau_giao)->isoFormat('DD-MM-YYYY');
        else
            $this->ngayBatDauGiao = $phieuXXDH->ngay_bat_dau_giao;

        $this->kieuMayDet = $phieuXXDH->kieu_may_det;
        $this->thanhPhamCuaKhachHang = $phieuXXDH->thanh_pham_cua_khach_hang;
        $this->phanAnhCuaKhachHang = $phieuXXDH->phan_anh_cua_khach_hang;
        $this->status = $phieuXXDH->status;
        $this->phanHoiKHST = $phieuXXDH->phan_hoi_khst;
        $this->thongTinDongGoi = $phieuXXDH->thong_tin_dong_goi;

        if($phieuXXDH->phan_bo_cc != ''){

            $this->cbCC = 1;

        }else{

            $this->cbCC = 0;

        }

        if($phieuXXDH->phan_bo_tb2 != ''){

            $this->cbTB2 = 1;

        }else{

            $this->cbTB2 = 0;

        }

        if($phieuXXDH->phan_bo_tb3 != ''){

            $this->cbTB3 = 1;

        } else{

            $this->cbTB3 = 0;

        }

        $this->phanHoiQA = $phieuXXDH->phan_hoi_qa;

        $this->quyCachPhieuXXDH = QuyCachPhieuXXDH::where('phieu_xxdh_so_phieu_id', $phieuXXDH->id)
        ->where('status', 'Sale')
        ->get();

        $this->quyCachPhieuXXDHKHST = QuyCachPhieuXXDH::where('phieu_xxdh_so_phieu_id', $phieuXXDH->id)
        ->where('status', 'KHST')
        ->get();

        $this->log = PhieuXXDHLog::where('so_phieu', $soPhieu)->get();

        $this->state = 'view';
    }

    public function editPhieuXXDHModal($soPhieu){

        $this->checkProccess($soPhieu, 'Edit', 'editPhieuXXDHModal');

        $this->soPhieu = $soPhieu;

        $phieuXXDH = ModelsPhieuXXDH::where('so_phieu', $soPhieu)->orderBy('id')->first();

        $this->loaiDonHang = $phieuXXDH->loai;
        $this->donHangGRS = $phieuXXDH->don_hang_grs;
        $this->donHangNonGRS = $phieuXXDH->don_hang_non_grs;
        $this->donHangSXMoi = $phieuXXDH->don_hang_sx_moi;
        $this->donHangLapLai = $phieuXXDH->don_hang_lap_lai;
        $this->donHangTonKho = $phieuXXDH->don_hang_ton_kho;
        $this->date = $phieuXXDH->date;
        $this->tenCongTy = $phieuXXDH->ten_cong_ty;
        $this->soSO = $phieuXXDH->so;
        $this->soSOTam = $phieuXXDH->so;
        $this->soHD = $phieuXXDH->hop_dong;
        $this->soHDTam = $phieuXXDH->hop_dong;
        // $this->soCone = $phieuXXDH->so_cone;
        // $this->soKgCone = $phieuXXDH->so_kg_cone;
        $this->qaKienNghi = $phieuXXDH->qa_kien_nghi;
        // $this->Line = $phieuXXDH->line;
        // $this->May = $phieuXXDH->may;
        // $this->ngayGiaoHang = $phieuXXDH->ngay_giao_hang;
        // $this->ngayBatDauGiao = $phieuXXDH->ngay_bat_dau_giao;
        // $this->kieuMayDet = $phieuXXDH->kieu_may_det;
        $this->thanhPhamCuaKhachHang = $phieuXXDH->thanh_pham_cua_khach_hang;
        $this->phanAnhCuaKhachHang = $phieuXXDH->phan_anh_cua_khach_hang;
        // $this->thongTinDongGoi = $phieuXXDH->thong_tin_dong_goi;
        $this->status = $phieuXXDH->status;
        $this->phanHoiKHST = $phieuXXDH->phan_hoi_khst;
        $this->phanHoiQA = $phieuXXDH->phan_hoi_qa;

        if($phieuXXDH->phan_bo_cc != ''){

            $this->cbCC = 1;

        }else{

            $this->cbCC = 0;

        }

        if($phieuXXDH->phan_bo_tb2 != ''){

            $this->cbTB2 = 1;

        }else{

            $this->cbTB2 = 0;

        }

        if($phieuXXDH->phan_bo_tb3 != ''){

            $this->cbTB3 = 1;

        } else{

            $this->cbTB3 = 0;

        }

        $this->quyCachPhieuXXDH = QuyCachPhieuXXDH::where('phieu_xxdh_so_phieu_id', $phieuXXDH->id)
        ->where('status', 'Sale')
        ->get();

        if($this->quyCachPhieuXXDH != null){

            foreach ($this->quyCachPhieuXXDH as $item) {

                $this->quyCachSuDungEdit[$item->id] = $item->quy_cach;
                $this->soLuongEdit[$item->id] = $item->so_luong;
                $this->kieuMayDetEdit[$item->id] = $item->kieu_may_det;
                $this->lotEdit[$item->id] = $item->lot;
                $this->soConeEdit[$item->id] = $item->so_cone;
                $this->soKgConeEdit[$item->id] = $item->so_kg_cone;
                $this->LineEdit[$item->id] = $item->line;
                $this->MayEdit[$item->id] = $item->may;
                $this->ngayGiaoHangEdit[$item->id] = $item->ngay_giao_hang;
                $this->ngayBatDauGiaoEdit[$item->id] = $item->ngay_bat_dau_giao;
                //$this->thanhPhamCuaKhachHangEdit[$item->id] = $item->thanh_pham_cua_khach_hang;
                //$this->phanAnhCuaKhachHangEdit[$item->id] = $item->phan_anh_cua_khach_hang;
                $this->thongTinDongGoiEdit[$item->id] = $item->thong_tin_dong_goi;
                $this->lichDuKienEdit[$item->id] = $item->lich_du_kien;
                $this->palletEdit[$item->id] = $item->pallet;
                $this->recycleEdit[$item->id] = $item->recycle;
    
            }

        }

        $this->quyCachPhieuXXDHKHST = QuyCachPhieuXXDH::where('phieu_xxdh_so_phieu_id', $phieuXXDH->id)
        ->where('status', 'KHST')
        ->get();

        if($this->quyCachPhieuXXDHKHST != null){

            foreach ($this->quyCachPhieuXXDHKHST as $item) {

                $this->quyCachSuDungKHSTEdit[$item->id] = $item->quy_cach;
                $this->soLuongKHSTEdit[$item->id] = $item->so_luong;
                $this->lotKHSTEdit[$item->id] = $item->lot;
    
            }

        }

        $this->danhSachLoaiMayDet = LoaiMayDet::all();

    }

    public function updatePhieuXXDH(){

        if($this->status == 'New'){

            if($this->soSOTam != $this->soSO){

                $laySo = SO::where('so', $this->soSO)->first();
    
                if($laySo != null){

                    if(!empty($laySo->phieu_xxdh)){

                        flash()->addFlash('error', 'Số SO đã được sử dụng','Thông báo');
                        return;
    
                    }else{
    
                        $laySo->update([
    
                            'phieu_xxdh' => $this->soPhieu,
                            'hop_dong' => $this->soHD
    
                        ]);
    
                    }
    
                }else{

                    $laySoTam = SO::where('so', $this->soSOTam)->first();

                    $laySoTam->update([
                        
                        'so' => $this->soSO,
                        'phieu_xxdh' => $this->soPhieu,
                        'hop_dong' => $this->soHD

                    ]);

                }
    
            }elseif($this->soHDTam != $this->soHD){

                $laySo = SO::where('so', $this->soSO)->first();

                if($laySo != null){

                    $laySo->update([

                        'hop_dong' => $this->soHD

                    ]);
    
                }

            }

            DB::transaction( function(){

                $updatePhieuXXDH = ModelsPhieuXXDH::where('so_phieu', $this->soPhieu)->first();

                $updatePhieuXXDH->loai = $this->loaiDonHang;
                $updatePhieuXXDH->don_hang_grs = $this->donHangGRS;
                $updatePhieuXXDH->don_hang_non_grs = $this->donHangNonGRS;
                $updatePhieuXXDH->don_hang_sx_moi = $this->donHangSXMoi;
                $updatePhieuXXDH->don_hang_lap_lai = $this->donHangLapLai;
                $updatePhieuXXDH->don_hang_ton_kho = $this->donHangTonKho;
                $updatePhieuXXDH->date = $this->date;
                $updatePhieuXXDH->ten_cong_ty = $this->tenCongTy;
                $updatePhieuXXDH->so = $this->soSO;
                $updatePhieuXXDH->hop_dong = $this->soHD;
                $updatePhieuXXDH->updated_user = Auth::user()->username;

                $updatePhieuXXDH->save();

                $arr = [

                    'so_phieu' => $updatePhieuXXDH->so_phieu,
                    'loai' => $updatePhieuXXDH->loai,
                    'don_hang_grs' => $updatePhieuXXDH->don_hang_grs,
                    'don_hang_non_grs' => $updatePhieuXXDH->don_hang_non_grs,
                    'don_hang_sx_moi' => $updatePhieuXXDH->don_hang_sx_moi,
                    'don_hang_lap_lai' => $updatePhieuXXDH->don_hang_lap_lai,
                    'don_hang_ton_kho' => $updatePhieuXXDH->don_hang_ton_kho,
                    'date' => $updatePhieuXXDH->date,
                    'ten_cong_ty' => $updatePhieuXXDH->ten_cong_ty,
                    'so' => $updatePhieuXXDH->so,
                    'hop_dong' => $updatePhieuXXDH->hop_dong,
                    // 'so_cone' => $updatePhieuXXDH->so_cone,
                    // 'so_kg_cone' => $updatePhieuXXDH->so_kg_cone,
                    // 'line' => $updatePhieuXXDH->line,
                    // 'may' => $updatePhieuXXDH->may,
                    // 'ngay_giao_hang' => $updatePhieuXXDH->ngay_giao_hang,
                    // 'ngay_bat_dau_giao' => $updatePhieuXXDH->ngay_bat_dau_giao,
                    'thanh_pham_cua_khach_hang' => $updatePhieuXXDH->thanh_pham_cua_khach_hang,
                    'phan_anh_cua_khach_hang' => $updatePhieuXXDH->phan_anh_cua_khach_hang,
                    // 'thong_tin_dong_goi' => $updatePhieuXXDH->thong_tin_dong_goi,
                    'phan_hoi_khst' => $updatePhieuXXDH->phan_hoi_khst,
                    'phan_hoi_qa' => $updatePhieuXXDH->phan_hoi_qa,
                    'phan_bo_cc' => $updatePhieuXXDH->phan_bo_cc,
                    'phan_bo_tb2' => $updatePhieuXXDH->phan_bo_tb2,
                    'phan_bo_tb3' => $updatePhieuXXDH->phan_bo_tb3,

                    'mail_chinh' => $updatePhieuXXDH->mail_chinh,
                    'mail_phu_1' => $updatePhieuXXDH->mail_phu_1,
                    'mail_phu_2' => $updatePhieuXXDH->mail_phu_2,
    
                    'status' => 'New',
                    'created_user' => $updatePhieuXXDH->created_user,
                    
                    'status_log' => 'Update',
                    'updated_user' => Auth::user()->username,
    
                ];

                $PhieuXXDHLog = PhieuXXDHLog::create($arr);

                foreach ($this->quyCachSuDungEdit as $key => $value) {

                    $update =  QuyCachPhieuXXDH::where('id' , $key)->first();
                    
                    $update->quy_cach = $this->quyCachSuDungEdit[$key];
                    $update->so_luong = $this->soLuongEdit[$key];

                    $update->update();

                    QuyCachPhieuXXDHLog::create([
                        
                        'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                        'quy_cach' => $update->quy_cach,
                        'so_luong' => $update->so_luong,
                        'status' => 'Sale'
    
                    ]);
                }



                if($this->quyCachSuDung != null){

                    foreach (array_reverse($this->quyCachSuDung, true) as $key => $value) {

                        QuyCachPhieuXXDH::create([
        
                            'phieu_xxdh_so_phieu_id' => $updatePhieuXXDH->id,
                            'quy_cach' => $this->quyCachSuDung[$key],
                            'so_luong' => $this->soLuong[$key],
                            'status' => 'Sale',
        
                        ]);
        
                        QuyCachPhieuXXDHLog::create([
        
                            'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                            'quy_cach' => $this->quyCachSuDung[$key],
                            'so_luong' => $this->soLuong[$key],
                            'status' => 'Sale',
        
                        ]);
                    }

                }

                if($this->quyCachSuDungKHST != null){

                    foreach ($this->quyCachSuDungKHST as $item) {

                        QuyCachPhieuXXDHLog::create([
        
                            'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                            'quy_cach' => $item->quy_cach,
                            'so_luong' => $item->so_luong,
                            'lot' => $item->lot,
                            'status' => $item->status,
        
                        ]);

                    }

                }

                

                flash()->addFlash('success', 'Sửa thành công phiếu : ' . $this->soPhieu,'Thông báo');
                $this->resetInputField();
                $this->emit('editPhieuXXDHModal');

            });

        }elseif($this->status == 'Sale APPROVED'){

            DB::transaction( function(){

                $updatePhieuXXDH = ModelsPhieuXXDH::where('so_phieu', $this->soPhieu)->first();

                // $updatePhieuXXDH->so_cone = $this->soCone;
                // $updatePhieuXXDH->so_kg_cone = $this->soKgCone;
                // $updatePhieuXXDH->line = $this->Line;
                // $updatePhieuXXDH->may = $this->May;
                // $updatePhieuXXDH->ngay_giao_hang = $this->ngayGiaoHang;
                // $updatePhieuXXDH->ngay_bat_dau_giao = $this->ngayBatDauGiao;
                $updatePhieuXXDH->thanh_pham_cua_khach_hang = $this->thanhPhamCuaKhachHang;
                $updatePhieuXXDH->phan_anh_cua_khach_hang = $this->phanAnhCuaKhachHang;
                // $updatePhieuXXDH->thong_tin_dong_goi = $this->thongTinDongGoi;
                $updatePhieuXXDH->updated_user = Auth::user()->username;

                $updatePhieuXXDH->save();

                $arr = [

                    'so_phieu' => $updatePhieuXXDH->so_phieu,
                    'loai' => $updatePhieuXXDH->loai,
                    'don_hang_grs' => $updatePhieuXXDH->don_hang_grs,
                    'don_hang_non_grs' => $updatePhieuXXDH->don_hang_non_grs,
                    'don_hang_sx_moi' => $updatePhieuXXDH->don_hang_sx_moi,
                    'don_hang_lap_lai' => $updatePhieuXXDH->don_hang_lap_lai,
                    'don_hang_ton_kho' => $updatePhieuXXDH->don_hang_ton_kho,
                    'date' => $updatePhieuXXDH->date,
                    'ten_cong_ty' => $updatePhieuXXDH->ten_cong_ty,
                    'so' => $updatePhieuXXDH->so,
                    'hop_dong' => $updatePhieuXXDH->hop_dong,
                    // 'so_cone' => $updatePhieuXXDH->so_cone,
                    // 'so_kg_cone' => $updatePhieuXXDH->so_kg_cone,
                    // 'line' => $updatePhieuXXDH->line,
                    // 'may' => $updatePhieuXXDH->may,
                    // 'ngay_giao_hang' => $updatePhieuXXDH->ngay_giao_hang,
                    // 'ngay_bat_dau_giao' => $updatePhieuXXDH->ngay_bat_dau_giao,
                    'thanh_pham_cua_khach_hang' => $updatePhieuXXDH->thanh_pham_cua_khach_hang,
                    'phan_anh_cua_khach_hang' => $updatePhieuXXDH->phan_anh_cua_khach_hang,
                    // 'thong_tin_dong_goi' => $updatePhieuXXDH->thong_tin_dong_goi,
                    'phan_hoi_khst' => $updatePhieuXXDH->phan_hoi_khst,
                    'phan_hoi_qa' => $updatePhieuXXDH->phan_hoi_qa,
                    'phan_bo_cc' => $updatePhieuXXDH->phan_bo_cc,
                    'phan_bo_tb2' => $updatePhieuXXDH->phan_bo_tb2,
                    'phan_bo_tb3' => $updatePhieuXXDH->phan_bo_tb3,

                    'mail_chinh' => $updatePhieuXXDH->mail_chinh,
                    'mail_phu_1' => $updatePhieuXXDH->mail_phu_1,
                    'mail_phu_2' => $updatePhieuXXDH->mail_phu_2,
    
                    'status' => 'Sale APPROVED',
                    'created_user' => $updatePhieuXXDH->created_user,
                    
                    'status_log' => 'Update',
                    'updated_user' => Auth::user()->username,
    
                ];

                $PhieuXXDHLog =  PhieuXXDHLog::create($arr);

                foreach ($this->quyCachSuDungEdit as $key => $value) {

                    $update =  QuyCachPhieuXXDH::where('id' , $key)->first();
                    
                    $update->kieu_may_det = $this->kieuMayDetEdit[$key];
                    $update->lot = $this->lotEdit[$key];

                    $update->so_cone = $this->soConeEdit[$key];
                    $update->so_kg_cone = $this->soKgConeEdit[$key];
                    $update->line = $this->LineEdit[$key];
                    $update->may = $this->MayEdit[$key];
                    $update->ngay_giao_hang = $this->ngayGiaoHangEdit[$key];
                    $update->ngay_bat_dau_giao = $this->ngayBatDauGiaoEdit[$key];
                    //$update->thanh_pham_cua_khach_hang = $this->thanhPhamCuaKhachHangEdit[$key];
                    //$update->phan_anh_cua_khach_hang = $this->phanAnhCuaKhachHangEdit[$key];
                    $update->thong_tin_dong_goi = $this->thongTinDongGoiEdit[$key];
                    $update->pallet = $this->palletEdit[$key];
                    $update->recycle = $this->recycleEdit[$key];

                    $update->update();

                    QuyCachPhieuXXDHLog::create([
                        
                        'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                        'quy_cach' => $update->quy_cach,
                        'so_luong' => $update->so_luong,
                        'kieu_may_det' => $update->kieu_may_det,
                        'lot' => $update->lot,
                        'so_cone' => $update->so_cone,
                        'so_kg_cone' => $update->so_kg_cone,
                        'line' => $update->line,
                        'may' => $update->may,
                        'ngay_giao_hang' => $update->ngay_giao_hang,
                        'ngay_bat_dau_giao' => $update->ngay_bat_dau_giao,
                        //'thanh_pham_cua_khach_hang' => $update->thanh_pham_cua_khach_hang,
                        //'phan_anh_cua_khach_hang' => $update->phan_anh_cua_khach_hang,
                        'thong_tin_dong_goi' => $update->thong_tin_dong_goi,
                        'pallet' => $update->pallet,
                        'recycle' => $update->recycle,
                        'status' => 'Sale'
    
                    ]);
                }

                if($this->quyCachSuDungKHST != null){

                    foreach ($this->quyCachSuDungKHST as $item) {

                        QuyCachPhieuXXDHLog::create([
        
                            'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                            'quy_cach' => $item->quy_cach,
                            'so_luong' => $item->so_luong,
                            'lot' => $item->lot,
                            'status' => $item->status,
        
                        ]);

                    }

                }

                flash()->addFlash('success', 'Sửa thành công phiếu : ' . $this->soPhieu,'Thông báo');
                $this->resetInputField();
                $this->emit('editPhieuXXDHModal');

            });

        }elseif($this->status == 'KHST APPROVED'){

            DB::transaction( function(){

                $updatePhieuXXDH = ModelsPhieuXXDH::where('so_phieu', $this->soPhieu)->first();

                $updatePhieuXXDH->phan_hoi_khst = $this->phanHoiKHST;

                $updatePhieuXXDH->save();

                $arr = [

                    'so_phieu' => $updatePhieuXXDH->so_phieu,
                    'loai' => $updatePhieuXXDH->loai,
                    'don_hang_grs' => $updatePhieuXXDH->don_hang_grs,
                    'don_hang_non_grs' => $updatePhieuXXDH->don_hang_non_grs,
                    'don_hang_sx_moi' => $updatePhieuXXDH->don_hang_sx_moi,
                    'don_hang_lap_lai' => $updatePhieuXXDH->don_hang_lap_lai,
                    'don_hang_ton_kho' => $updatePhieuXXDH->don_hang_ton_kho,
                    'date' => $updatePhieuXXDH->date,
                    'ten_cong_ty' => $updatePhieuXXDH->ten_cong_ty,
                    'so' => $updatePhieuXXDH->so,
                    'hop_dong' => $updatePhieuXXDH->hop_dong,
                    // 'so_cone' => $updatePhieuXXDH->so_cone,
                    // 'so_kg_cone' => $updatePhieuXXDH->so_kg_cone,
                    // 'line' => $updatePhieuXXDH->line,
                    // 'may' => $updatePhieuXXDH->may,
                    // 'ngay_giao_hang' => $updatePhieuXXDH->ngay_giao_hang,
                    // 'ngay_bat_dau_giao' => $updatePhieuXXDH->ngay_bat_dau_giao,
                    'thanh_pham_cua_khach_hang' => $updatePhieuXXDH->thanh_pham_cua_khach_hang,
                    'phan_anh_cua_khach_hang' => $updatePhieuXXDH->phan_anh_cua_khach_hang,
                    // 'thong_tin_dong_goi' => $updatePhieuXXDH->thong_tin_dong_goi,
                    'phan_hoi_khst' => $updatePhieuXXDH->phan_hoi_khst,
                    'phan_hoi_qa' => $updatePhieuXXDH->phan_hoi_qa,
                    'phan_bo_cc' => $updatePhieuXXDH->phan_bo_cc,
                    'phan_bo_tb2' => $updatePhieuXXDH->phan_bo_tb2,
                    'phan_bo_tb3' => $updatePhieuXXDH->phan_bo_tb3,

                    'mail_chinh' => $updatePhieuXXDH->mail_chinh,
                    'mail_phu_1' => $updatePhieuXXDH->mail_phu_1,
                    'mail_phu_2' => $updatePhieuXXDH->mail_phu_2,
    
                    'status' => 'KHST APPROVED',
                    'created_user' => $updatePhieuXXDH->created_user,
                    
                    'status_log' => 'Update',
                    'updated_user' => Auth::user()->username,
    
                ];

                $PhieuXXDHLog = PhieuXXDHLog::create($arr);

                foreach ($this->quyCachSuDungKHSTEdit as $key => $value) {

                    $update =  QuyCachPhieuXXDH::where('id' , $key)->first();
                    
                    $update->quy_cach = $this->quyCachSuDungKHSTEdit[$key];
                    $update->so_luong = $this->soLuongKHSTEdit[$key];
                    $update->lot = $this->lotKHSTEdit[$key];

                    $update->update();

                    QuyCachPhieuXXDHLog::create([
                        
                        'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                        'quy_cach' => $update->quy_cach,
                        'so_luong' => $update->so_luong,
                        'lot' => $update->lot,
                        'status' => 'KHST'
    
                    ]);
                }

                if($this->quyCachSuDungKHST != null){

                    foreach (array_reverse($this->quyCachSuDungKHST, true) as $key => $value) {

                        QuyCachPhieuXXDH::create([
        
                            'phieu_xxdh_so_phieu_id' => $updatePhieuXXDH->id,
                            'quy_cach' => $this->quyCachSuDungKHST[$key],
                            'so_luong' => $this->soLuongKHST[$key],
                            'lot' => $this->lotKHST[$key],
                            'status' => 'KHST',
        
                        ]);
        
                        QuyCachPhieuXXDHLog::create([
        
                            'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                            'quy_cach' => $this->quyCachSuDungKHST[$key],
                            'so_luong' => $this->soLuongKHST[$key],
                            'lot' => $this->lotKHST[$key],
                            'status' => 'KHST',
        
                        ]);
                    }

                }

                if($this->quyCachSuDung != null){

                    foreach ($this->quyCachSuDung as $item) {

                        QuyCachPhieuXXDHLog::create([
        
                            'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                            'quy_cach' => $item->quy_cach,
                            'so_luong' => $item->so_luong,
                            'kieu_may_det' => $item->kieu_may_det,
                            'lot' => $item->lot,
                            'line' => $item->line,
                            'may' => $item->may,
                            'ngay_giao_hang' => $item->ngay_giao_hang,
                            'ngay_bat_dau_giao' => $item->ngay_bat_dau_giao,
                            //'thanh_pham_cua_khach_hang' => $item->thanh_pham_cua_khach_hang,
                            //'phan_anh_cua_khach_hang' => $item->phan_anh_cua_khach_hang,
                            'thong_tin_dong_goi' => $item->thong_tin_dong_goi,
                            'pallet' => $item->pallet,
                            'recycle' => $item->recycle,
                            'status' => $item->status,
        
                        ]);

                    }

                }


                flash()->addFlash('success', 'Sửa thành công phiếu : ' . $this->soPhieu,'Thông báo');
                $this->resetInputField();
                $this->emit('editPhieuXXDHModal');

            });

        }elseif($this->status == 'QA APPROVED'){

            DB::transaction( function(){

                $updatePhieuXXDH = ModelsPhieuXXDH::where('so_phieu', $this->soPhieu)->first();

                $updatePhieuXXDH->phan_hoi_qa = $this->phanHoiQA;

                $updatePhieuXXDH->save();

                $arr = [

                    'so_phieu' => $updatePhieuXXDH->so_phieu,
                    'loai' => $updatePhieuXXDH->loai,
                    'don_hang_grs' => $updatePhieuXXDH->don_hang_grs,
                    'don_hang_non_grs' => $updatePhieuXXDH->don_hang_non_grs,
                    'don_hang_sx_moi' => $updatePhieuXXDH->don_hang_sx_moi,
                    'don_hang_lap_lai' => $updatePhieuXXDH->don_hang_lap_lai,
                    'don_hang_ton_kho' => $updatePhieuXXDH->don_hang_ton_kho,
                    'date' => $updatePhieuXXDH->date,
                    'ten_cong_ty' => $updatePhieuXXDH->ten_cong_ty,
                    'so' => $updatePhieuXXDH->so,
                    'hop_dong' => $updatePhieuXXDH->hop_dong,
                    // 'so_cone' => $updatePhieuXXDH->so_cone,
                    // 'so_kg_cone' => $updatePhieuXXDH->so_kg_cone,
                    // 'line' => $updatePhieuXXDH->line,
                    // 'may' => $updatePhieuXXDH->may,
                    // 'ngay_giao_hang' => $updatePhieuXXDH->ngay_giao_hang,
                    // 'ngay_bat_dau_giao' => $updatePhieuXXDH->ngay_bat_dau_giao,
                    'thanh_pham_cua_khach_hang' => $updatePhieuXXDH->thanh_pham_cua_khach_hang,
                    'phan_anh_cua_khach_hang' => $updatePhieuXXDH->phan_anh_cua_khach_hang,
                    // 'thong_tin_dong_goi' => $updatePhieuXXDH->thong_tin_dong_goi,
                    'phan_hoi_khst' => $updatePhieuXXDH->phan_hoi_khst,
                    'phan_hoi_qa' => $updatePhieuXXDH->phan_hoi_qa,
                    'phan_bo_cc' => $updatePhieuXXDH->phan_bo_cc,
                    'phan_bo_tb2' => $updatePhieuXXDH->phan_bo_tb2,
                    'phan_bo_tb3' => $updatePhieuXXDH->phan_bo_tb3,

                    'mail_chinh' => $updatePhieuXXDH->mail_chinh,
                    'mail_phu_1' => $updatePhieuXXDH->mail_phu_1,
                    'mail_phu_2' => $updatePhieuXXDH->mail_phu_2,
    
                    'status' => 'QA APPROVED',
                    'created_user' => $updatePhieuXXDH->created_user,
                    
                    'status_log' => 'Update',
                    'updated_user' => Auth::user()->username,
    
                ];

                $PhieuXXDHLog = PhieuXXDHLog::create($arr);

                if($this->quyCachSuDung != null){

                    foreach ($this->quyCachSuDung as $item) {

                        QuyCachPhieuXXDHLog::create([
        
                            'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                            'quy_cach' => $item->quy_cach,
                            'so_luong' => $item->so_luong,
                            'kieu_may_det' => $item->kieu_may_det,
                            'lot' => $item->lot,
                            'line' => $item->line,
                            'may' => $item->may,
                            'ngay_giao_hang' => $item->ngay_giao_hang,
                            'ngay_bat_dau_giao' => $item->ngay_bat_dau_giao,
                            //'thanh_pham_cua_khach_hang' => $item->thanh_pham_cua_khach_hang,
                            //'phan_anh_cua_khach_hang' => $item->phan_anh_cua_khach_hang,
                            'thong_tin_dong_goi' => $item->thong_tin_dong_goi,
                            'pallet' => $item->pallet,
                            'recycle' => $item->recycle,
                            'status' => $item->status,
        
                        ]);

                    }

                }

                if($this->quyCachSuDungKHST != null){

                    foreach ($this->quyCachSuDungKHST as $item) {

                        QuyCachPhieuXXDHLog::create([
        
                            'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                            'quy_cach' => $item->quy_cach,
                            'so_luong' => $item->so_luong,
                            'lot' => $item->lot,
                            'status' => $item->status,
        
                        ]);

                    }

                }


                flash()->addFlash('success', 'Sửa thành công phiếu : ' . $this->soPhieu,'Thông báo');
                $this->resetInputField();
                $this->emit('editPhieuXXDHModal');

            });

        }elseif($this->status == 'QA REQUESTED'){

            DB::transaction( function(){

                $updatePhieuXXDH = ModelsPhieuXXDH::where('so_phieu', $this->soPhieu)->first();

                $updatePhieuXXDH->qa_kien_nghi = $this->qaKienNghi;

                $updatePhieuXXDH->save();

                $arr = [

                    'so_phieu' => $updatePhieuXXDH->so_phieu,
                    'loai' => $updatePhieuXXDH->loai,
                    'don_hang_grs' => $updatePhieuXXDH->don_hang_grs,
                    'don_hang_non_grs' => $updatePhieuXXDH->don_hang_non_grs,
                    'don_hang_sx_moi' => $updatePhieuXXDH->don_hang_sx_moi,
                    'don_hang_lap_lai' => $updatePhieuXXDH->don_hang_lap_lai,
                    'don_hang_ton_kho' => $updatePhieuXXDH->don_hang_ton_kho,
                    'date' => $updatePhieuXXDH->date,
                    'ten_cong_ty' => $updatePhieuXXDH->ten_cong_ty,
                    'so' => $updatePhieuXXDH->so,
                    'hop_dong' => $updatePhieuXXDH->hop_dong,
                    // 'so_cone' => $updatePhieuXXDH->so_cone,
                    // 'so_kg_cone' => $updatePhieuXXDH->so_kg_cone,
                    // 'line' => $updatePhieuXXDH->line,
                    // 'may' => $updatePhieuXXDH->may,
                    // 'ngay_giao_hang' => $updatePhieuXXDH->ngay_giao_hang,
                    // 'ngay_bat_dau_giao' => $updatePhieuXXDH->ngay_bat_dau_giao,
                    'thanh_pham_cua_khach_hang' => $updatePhieuXXDH->thanh_pham_cua_khach_hang,
                    'phan_anh_cua_khach_hang' => $updatePhieuXXDH->phan_anh_cua_khach_hang,
                    // 'thong_tin_dong_goi' => $updatePhieuXXDH->thong_tin_dong_goi,
                    'phan_hoi_khst' => $updatePhieuXXDH->phan_hoi_khst,
                    'phan_hoi_qa' => $updatePhieuXXDH->phan_hoi_qa,
                    'phan_bo_cc' => $updatePhieuXXDH->phan_bo_cc,
                    'phan_bo_tb2' => $updatePhieuXXDH->phan_bo_tb2,
                    'phan_bo_tb3' => $updatePhieuXXDH->phan_bo_tb3,

                    'mail_chinh' => $updatePhieuXXDH->mail_chinh,
                    'mail_phu_1' => $updatePhieuXXDH->mail_phu_1,
                    'mail_phu_2' => $updatePhieuXXDH->mail_phu_2,
    
                    'status' => 'QA REQUESTED',
                    'created_user' => $updatePhieuXXDH->created_user,
                    
                    'status_log' => 'Update',
                    'updated_user' => Auth::user()->username,
    
                ];

                $PhieuXXDHLog = PhieuXXDHLog::create($arr);

                if($this->quyCachSuDung != null){

                    foreach ($this->quyCachSuDung as $item) {

                        QuyCachPhieuXXDHLog::create([
        
                            'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                            'quy_cach' => $item->quy_cach,
                            'so_luong' => $item->so_luong,
                            'kieu_may_det' => $item->kieu_may_det,
                            'lot' => $item->lot,
                            'line' => $item->line,
                            'may' => $item->may,
                            'ngay_giao_hang' => $item->ngay_giao_hang,
                            'ngay_bat_dau_giao' => $item->ngay_bat_dau_giao,
                            //'thanh_pham_cua_khach_hang' => $item->thanh_pham_cua_khach_hang,
                            //'phan_anh_cua_khach_hang' => $item->phan_anh_cua_khach_hang,
                            'thong_tin_dong_goi' => $item->thong_tin_dong_goi,
                            'pallet' => $item->pallet,
                            'recycle' => $item->recycle,
                            'status' => $item->status,
        
                        ]);

                    }

                }

                flash()->addFlash('success', 'Sửa thành công phiếu : ' . $this->soPhieu,'Thông báo');
                $this->resetInputField();
                $this->emit('editPhieuXXDHModal');

            });

        }

    }

    public function deletePhieuXXDHModal($soPhieu){

        $this->checkProccess($soPhieu, 'Delete', 'deletePhieuXXDHModal');

        $this->soPhieu = $soPhieu;

    }

    public function deletePhieuXXDH(){

        DB::transaction(function(){

            $deletePhieuXXDH = ModelsPhieuXXDH::where('so_phieu', $this->soPhieu)->first();

            $deletePhieuXXDH->is_delete = '1';
            $deletePhieuXXDH->updated_user = Auth::user()->username;

            $deletePhieuXXDH->save();

            $arr = [

                'so_phieu' => $deletePhieuXXDH->so_phieu,
                'loai' => $deletePhieuXXDH->loai,
                'don_hang_grs' => $deletePhieuXXDH->don_hang_grs,
                'don_hang_non_grs' => $deletePhieuXXDH->don_hang_non_grs,
                'don_hang_sx_moi' => $deletePhieuXXDH->don_hang_sx_moi,
                'don_hang_lap_lai' => $deletePhieuXXDH->don_hang_lap_lai,
                'don_hang_ton_kho' => $deletePhieuXXDH->don_hang_ton_kho,
                'date' => $deletePhieuXXDH->date,
                'ten_cong_ty' => $deletePhieuXXDH->ten_cong_ty,
                'so' => $deletePhieuXXDH->so,
                'hop_dong' => $deletePhieuXXDH->hop_dong,
                //'quy_cach_su_dung' => $deletePhieuXXDH->quy_cach_su_dung,
                //'so_luong' => $deletePhieuXXDH->so_luong,
                // 'so_cone' => $deletePhieuXXDH->so_cone,
                // 'so_kg_cone' => $deletePhieuXXDH->so_kg_cone,
                'qa_kien_nghi' => $deletePhieuXXDH->qa_kien_nghi,
                'phan_hoi_khst' => $deletePhieuXXDH->phan_hoi_khst,
                'phan_bo_cc' => $deletePhieuXXDH->phan_bo_cc,
                'phan_bo_tb2' => $deletePhieuXXDH->phan_bo_tb2,
                'phan_bo_tb3' => $deletePhieuXXDH->phan_bo_tb3,
                'phan_hoi_qa' => $deletePhieuXXDH->phan_hoi_qa,
                // 'line' => $deletePhieuXXDH->line,
                // 'may' => $deletePhieuXXDH->may,
                // 'ngay_giao_hang' => $deletePhieuXXDH->ngay_giao_hang,
                // 'ngay_bat_dau_giao' => $deletePhieuXXDH->ngay_bat_dau_giao,
                //'kieu_may_det' => $deletePhieuXXDH->kieu_may_det,
                'thanh_pham_cua_khach_hang' => $deletePhieuXXDH->thanh_pham_cua_khach_hang,
                'phan_anh_cua_khach_hang' => $deletePhieuXXDH->phan_anh_cua_khach_hang,
                // 'thong_tin_dong_goi' => $deletePhieuXXDH->thong_tin_dong_goi,
                'mail_chinh' => $deletePhieuXXDH->mailChinh,
                'mail_phu_1' => $deletePhieuXXDH->mailPhu1,
                'mail_phu_2' => $deletePhieuXXDH->mailPhu2,
                //'dieu_kien_cua_khach_hang' => $deletePhieuXXDH->dieu_kien_cua_khach_hang,

                'status' => $deletePhieuXXDH->status,
                'created_user' => $deletePhieuXXDH->created_user,

                'ly_do_rollback' => $deletePhieuXXDH->ly_do_rollback,
                
                'status_log' => 'Delete',
                'updated_user' => Auth::user()->username,

            ];

            PhieuXXDHLog::create($arr);

            SO::where('so', $deletePhieuXXDH->so)->update([

                'hop_dong' => null,
                'phieu_xxdh' => null,
                'status_phieu_xxdh' => null
                
            ]);

            flash()->addFlash('success', 'Xóa thành công phiếu : ' . $this->soPhieu,'Thông báo');
            $this->resetInputField();
            $this->emit('deletePhieuXXDHModal');

        });
    }

    public function approvePhieuXXDHModal($soPhieu){

        $this->checkProccess($soPhieu, 'Approve', 'approvePhieuXXDHModal');

        $this->soPhieu = $soPhieu;

        $phieuXXDH = ModelsPhieuXXDH::where('so_phieu', $soPhieu)->first();
        
        $this->loaiDonHang = $phieuXXDH->loai;
        $this->donHangGRS = $phieuXXDH->don_hang_grs;
        $this->donHangNonGRS = $phieuXXDH->don_hang_non_grs;
        $this->donHangSXMoi = $phieuXXDH->don_hang_sx_moi;
        $this->donHangLapLai = $phieuXXDH->don_hang_lap_lai;
        $this->donHangTonKho = $phieuXXDH->don_hang_ton_kho;
        $this->date = $phieuXXDH->date;
        $this->tenCongTy = $phieuXXDH->ten_cong_ty;
        $this->soSO = $phieuXXDH->so;
        $this->soHD = $phieuXXDH->hop_dong;
        $this->qaKienNghi = $phieuXXDH->qa_kien_nghi;
        $this->thanhPhamCuaKhachHang = $phieuXXDH->thanh_pham_cua_khach_hang;
        $this->phanAnhCuaKhachHang = $phieuXXDH->phan_anh_cua_khach_hang;
        $this->status = $phieuXXDH->status;
        $this->phanHoiKHST = $phieuXXDH->phan_hoi_khst;
        $this->phanHoiQA = $phieuXXDH->phan_hoi_qa;

        $phieuXXDHLog = PhieuXXDHLog::where('so_phieu', $soPhieu)
        ->where('status_log', 'Roll back')
        ->latest()->first();
        
        if($phieuXXDHLog != null){

            $this->checkPhieuXXDHHasRollback = '1';
            $this->loaiDonHangLog = $phieuXXDHLog->loai;
            $this->donHangGRSLog = $phieuXXDHLog->don_hang_grs;
            $this->donHangNonGRSLog = $phieuXXDHLog->don_hang_non_grs;
            $this->donHangSXMoiLog = $phieuXXDHLog->don_hang_sx_moi;
            $this->donHangLapLaiLog = $phieuXXDHLog->don_hang_lap_lai;
            $this->donHangTonKhoLog = $phieuXXDHLog->don_hang_ton_kho;
            $this->dateLog = $phieuXXDHLog->date;
            $this->tenCongTyLog = $phieuXXDHLog->ten_cong_ty;
            $this->soSOLog = $phieuXXDHLog->so;
            $this->soHDLog = $phieuXXDHLog->hop_dong;
            $this->soConeLog = $phieuXXDHLog->so_cone;
            $this->soKgConeLog = $phieuXXDHLog->so_kg_cone;
            $this->qaKienNghiLog = $phieuXXDHLog->qa_kien_nghi;
            $this->LineLog = $phieuXXDHLog->line;
            $this->MayLog = $phieuXXDHLog->may;
            $this->ngayGiaoHangLog = $phieuXXDHLog->ngay_giao_hang;
            $this->ngayBatDauGiaoLog = $phieuXXDHLog->ngay_bat_dau_giao;
            $this->kieuMayDetLog = $phieuXXDHLog->kieu_may_det;
            $this->thanhPhamCuaKhachHangLog = $phieuXXDHLog->thanh_pham_cua_khach_hang;
            $this->phanAnhCuaKhachHangLog = $phieuXXDHLog->phan_anh_cua_khach_hang;
            $this->thongTinDongGoiLog = $phieuXXDHLog->thong_tin_dong_goi;
            $this->statusLog = $phieuXXDHLog->status;
            $this->phanHoiKHSTLog = $phieuXXDHLog->phan_hoi_khst;
            $this->phanHoiQALog = $phieuXXDHLog->phan_hoi_qa;

        }else{

            $this->checkPhieuXXDHHasRollback = '';
            $this->loaiDonHangLog = '';
            $this->donHangGRSLog = '';
            $this->donHangNonGRSLog = '';
            $this->donHangSXMoiLog = '';
            $this->donHangLapLaiLog = '';
            $this->donHangTonKhoLog = '';
            $this->dateLog = '';
            $this->tenCongTyLog = '';
            $this->soSOLog = '';
            $this->soHDLog = '';
            $this->soConeLog = '';
            $this->soKgConeLog = '';
            $this->qaKienNghiLog = '';
            $this->LineLog = '';
            $this->MayLog = '';
            $this->ngayGiaoHangLog = '';
            $this->ngayBatDauGiaoLog = '';
            $this->kieuMayDetLog = '';
            $this->thanhPhamCuaKhachHangLog = '';
            $this->phanAnhCuaKhachHangLog = '';
            $this->thongTinDongGoiLog = '';
            $this->statusLog = '';
            $this->phanHoiKHSTLog = '';
            $this->phanHoiQALog = '';

        }

        $this->quyCachPhieuXXDH = QuyCachPhieuXXDH::where('phieu_xxdh_so_phieu_id', $phieuXXDH->id)
        ->where('status', 'Sale')
        ->get();

        $this->quyCachPhieuXXDHKHST = QuyCachPhieuXXDH::where('phieu_xxdh_so_phieu_id', $phieuXXDH->id)
        ->where('status', 'KHST')
        ->get();

        $this->listThongTinDongGoi = DB::table('thong_tin_dong_goi')->get();
        $this->listPallet = DB::table('pallet')->get();
        $this->listRecycle = DB::table('recycle')->get();

        $this->danhSachLoaiMayDet = LoaiMayDet::all();

    }

    public function approvePhieuXXDHNew(){

        DB::transaction( function(){

            $pxxdh = ModelsPhieuXXDH::where('so_phieu', $this->soPhieu)->first();

            if($pxxdh->don_hang_sx_moi == 1){
                if(strlen($pxxdh->so) == 12){

                    if($pxxdh->status == 'New'){

                        if(!Auth::user()->hasPermissionTo('sale_approve_pxxdhs')){
    
                            sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                            $this->emit('approvePhieuXXDHModal');
                            $this->resetInputField();
                            return;
    
                        }
    
                    }elseif($pxxdh->status == 'Sale APPROVED'){
    
                        if(!Auth::user()->hasPermissionTo('sm_approve_pxxdhs')){
    
                            sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                            $this->emit('approvePhieuXXDHModal');
                            $this->resetInputField();
                            return;
    
                        }
    
                    }elseif($pxxdh->status == 'SM APPROVED'){
    
                        if(!Auth::user()->hasPermissionTo('qa_approve_pxxdhs')){
    
                            sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                            $this->emit('approvePhieuXXDHModal');
                            $this->resetInputField();
                            return;
    
                        }
    
                    }elseif($pxxdh->status == 'QA REQUESTED'){

                        if(!Auth::user()->hasPermissionTo('quan_ly_khst_approve_pxxdhs')){
    
                            sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                            $this->emit('approvePhieuXXDHModal');
                            $this->resetInputField();
                            return;
    
                        }
    
                    }elseif($pxxdh->status == 'KHST APPROVED'){
    
                        if(!Auth::user()->hasPermissionTo('create_pxxdhs')){
    
                            sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                            $this->emit('approvePhieuXXDHModal');
                            $this->resetInputField();
                            return;
    
                        }
    
                    }elseif($pxxdh->status == 'ADMIN APPROVED'){
    
                        if(!Auth::user()->hasPermissionTo('qa_approve_pxxdhs')){
    
                            sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                            $this->emit('approvePhieuXXDHModal');
                            $this->resetInputField();
                            return;
    
                        }
    
                    }elseif($pxxdh->status == 'QA APPROVED'){
    
                        if(!Auth::user()->hasPermissionTo('create_pxxdhs')){
    
                            sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                            $this->emit('approvePhieuXXDHModal');
                            $this->resetInputField();
                            return;
    
                        }
    
                    }

                }else{

                    if($pxxdh->status == 'New'){

                        if(!Auth::user()->hasPermissionTo('sale_approve_pxxdhs')){
    
                            sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                            $this->emit('approvePhieuXXDHModal');
                            $this->resetInputField();
                            return;
    
                        }
    
                    }elseif($pxxdh->status == 'Sale APPROVED'){
    
                        if(!Auth::user()->hasPermissionTo('qa_approve_pxxdhs')){
    
                            sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                            $this->emit('approvePhieuXXDHModal');
                            $this->resetInputField();
                            return;
    
                        }
    
                    }elseif($pxxdh->status == 'QA REQUESTED'){
    
                        if(!Auth::user()->hasPermissionTo('quan_ly_khst_approve_pxxdhs')){
    
                            sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                            $this->emit('approvePhieuXXDHModal');
                            $this->resetInputField();
                            return;
    
                        }
    
                    }elseif($pxxdh->status == 'KHST APPROVED'){
    
                        if(!Auth::user()->hasPermissionTo('qa_approve_pxxdhs')){
    
                            sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                            $this->emit('approvePhieuXXDHModal');
                            $this->resetInputField();
                            return;
    
                        }
    
                    }elseif($pxxdh->status == 'QA APPROVED'){
    
                        if(!Auth::user()->hasPermissionTo('create_pxxdhs')){
    
                            sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                            $this->emit('approvePhieuXXDHModal');
                            $this->resetInputField();
                            return;
    
                        }
    
                    }

                }
            }else{
                if($pxxdh->status == 'New'){

                    if(!Auth::user()->hasPermissionTo('sale_approve_pxxdhs')){

                        sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                        $this->emit('approvePhieuXXDHModal');
                        $this->resetInputField();
                        return;

                    }

                }elseif($pxxdh->status == 'Sale APPROVED'){

                    if(!Auth::user()->hasPermissionTo('qa_approve_pxxdhs')){

                        sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                        $this->emit('approvePhieuXXDHModal');
                        $this->resetInputField();
                        return;

                    }

                }elseif($pxxdh->status == 'QA APPROVED'){

                    if(!Auth::user()->hasPermissionTo('quan_ly_khst_approve_pxxdhs')){

                        sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                        $this->emit('approvePhieuXXDHModal');
                        $this->resetInputField();
                        return;

                    }

                }elseif($pxxdh->status == 'KHST APPROVED'){

                    if(!Auth::user()->hasPermissionTo('create_pxxdhs')){

                        sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                        $this->emit('approvePhieuXXDHModal');
                        $this->resetInputField();
                        return;

                    }

                }
            }

            if($pxxdh->don_hang_sx_moi == 1){
                if(strlen($pxxdh->so) == 12){
                    if($pxxdh->status == 'New'){

                        $pxxdh->status = 'Sale APPROVED';
                        $pxxdh->thanh_pham_cua_khach_hang = $this->thanhPhamCuaKhachHang;
                        $pxxdh->phan_anh_cua_khach_hang = $this->phanAnhCuaKhachHang;
    
                        $pxxdh->sale_approved = Auth::user()->username;
                        $pxxdh->sale_approved_at = Carbon::now();
                        
                        $pxxdh->updated_user = Auth::user()->username;
                
                        $pxxdh->update();
        
                        $arr = [
        
                            'so_phieu' => $pxxdh->so_phieu,
                            'loai' => $pxxdh->loai,
                            'don_hang_grs' => $pxxdh->don_hang_grs,
                            'don_hang_non_grs' => $pxxdh->don_hang_non_grs,
                            'don_hang_sx_moi' => $pxxdh->don_hang_sx_moi,
                            'don_hang_lap_lai' => $pxxdh->don_hang_lap_lai,
                            'don_hang_ton_kho' => $pxxdh->don_hang_ton_kho,
                            'date' => $pxxdh->date,
                            'ten_cong_ty' => $pxxdh->ten_cong_ty,
                            'so' => $pxxdh->so,
                            'hop_dong' => $pxxdh->hop_dong,
                            'thanh_pham_cua_khach_hang' => $pxxdh->thanh_pham_cua_khach_hang,
                            'phan_anh_cua_khach_hang' => $pxxdh->phan_anh_cua_khach_hang,
                            'mail_chinh' => $pxxdh->mail_chinh,
                            'mail_phu_1' => $pxxdh->mail_phu_1,
                            'mail_phu_2' => $pxxdh->mail_phu_2,
            
                            'status' => 'Sale APPROVED',
                            'status_log' => 'Approve',
                            'created_user' => $pxxdh->created_user,
                            'updated_user' => Auth::user()->username,
            
                        ];
            
                        $PhieuXXDHLog = PhieuXXDHLog::create($arr);
    
                        foreach ($this->lot as $key => $value) {
    
                            $insert =  QuyCachPhieuXXDH::where('id' , $key)->first();
    
                            $insert->kieu_may_det = $this->kieuMayDet[$key];
                            $insert->lot = $this->lot[$key];
                            $insert->so_cone = $this->soCone[$key] ?? null;
                            $insert->so_kg_cone = $this->soKgCone[$key] ?? null;
                            $insert->line = $this->Line[$key] ?? null;
                            $insert->may = $this->May[$key] ?? null;
                            $insert->ngay_giao_hang = $this->ngayGiaoHang[$key] ?? null;
                            $insert->ngay_bat_dau_giao = $this->ngayBatDauGiao[$key] ?? null;
                            $insert->lich_du_kien = $this->lichDuKien;
                            $insert->thong_tin_dong_goi = $this->thongTinDongGoi[$key] ?? null;
                            $insert->pallet = $this->pallet[$key] ?? null;
                            $insert->recycle = $this->recycle[$key] ?? null;
        
                            $insert->update();
        
                            QuyCachPhieuXXDHLog::create([
                                
                                'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                                'quy_cach' => $insert->quy_cach,
                                'so_luong' => $insert->so_luong,
                                'kieu_may_det' => $this->kieuMayDet[$key] ?? null,
                                'lot' => $this->lot[$key] ?? null,
                                'so_cone' => $this->soCone[$key] ?? null,
                                'so_kg_cone' => $this->soKgCone[$key] ?? null,
                                'line' => $this->Line[$key] ?? null,
                                'may' => $this->May[$key] ?? null,
                                'ngay_giao_hang' => $this->ngayGiaoHang[$key] ?? null,
                                'ngay_bat_dau_giao' => $this->ngayBatDauGiao[$key] ?? null,
                                'lich_du_kien' => $this->lichDuKien,
                                'thong_tin_dong_goi' => $this->thongTinDongGoi[$key] ?? null,
                                'pallet' => $this->pallet[$key] ?? null,
                                'recycle' => $this->recycle[$key] ?? null,
                                'status' => 'Sale'
            
                            ]);
                        }
    
                        $emailQuanLySale = EmailQuanLy::where('chuc_vu', 'quan_ly_sale')->first();
        
                        Mail::to($emailQuanLySale->email)->cc('luongphan@soitheky.vn')->send(new MailPhieuXXDH('Sale APPROVED',$this->soPhieu, Auth::user()->username, $PhieuXXDHLog->updated_at, ''));
                        
                        flash()->addFlash('success', 'Duyệt thành công phiếu : ' . $this->soPhieu,'Thông báo');
        
                        $this->emit('approvePhieuXXDHModal');
        
                        $this->resetInputField();
        
                    }elseif($pxxdh->status == 'Sale APPROVED'){
                    
                        $pxxdh->sm_approved = Auth::user()->username;
                        $pxxdh->sm_approved_at = Carbon::now();
    
                        $pxxdh->status = 'SM APPROVED';
                        $pxxdh->updated_user = Auth::user()->username;
                
                        $pxxdh->update();
        
                        $arr = [
        
                            'so_phieu' => $pxxdh->so_phieu,
                            'loai' => $pxxdh->loai,
                            'don_hang_grs' => $pxxdh->don_hang_grs,
                            'don_hang_non_grs' => $pxxdh->don_hang_non_grs,
                            'don_hang_sx_moi' => $pxxdh->don_hang_sx_moi,
                            'don_hang_lap_lai' => $pxxdh->don_hang_lap_lai,
                            'don_hang_ton_kho' => $pxxdh->don_hang_ton_kho,
                            'date' => $pxxdh->date,
                            'ten_cong_ty' => $pxxdh->ten_cong_ty,
                            'so' => $pxxdh->so,
                            'hop_dong' => $pxxdh->hop_dong,
                            'thanh_pham_cua_khach_hang' => $pxxdh->thanh_pham_cua_khach_hang,
                            'phan_anh_cua_khach_hang' => $pxxdh->phan_anh_cua_khach_hang,
        
                            'mail_chinh' => $pxxdh->mail_chinh,
                            'mail_phu_1' => $pxxdh->mail_phu_1,
                            'mail_phu_2' => $pxxdh->mail_phu_2,
            
                            'status' => 'SM APPROVED',
                            'created_user' => $pxxdh->created_user,
                            
                            'status_log' => 'Approve',
                            'updated_user' => Auth::user()->username,
            
                        ];
            
                        $PhieuXXDHLog = PhieuXXDHLog::create($arr);
        
                        foreach ($this->quyCachPhieuXXDH as $item) {
                            
                            QuyCachPhieuXXDHLog::create([
                                
                                'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                                'quy_cach' => $item->quy_cach,
                                'so_luong' => $item->so_luong,
                                'kieu_may_det' => $item->kieu_may_det,
                                'lot' => $item->lot,
                                'so_cone' => $item->so_cone,
                                'so_kg_cone' => $item->so_kg_cone,
                                'line' => $item->line,
                                'may' => $item->may,
                                'ngay_giao_hang' => $item->ngay_giao_hang,
                                'ngay_bat_dau_giao' => $item->ngay_bat_dau_giao,
                                'thong_tin_dong_goi' => $item->thong_tin_dong_goi,
                                'pallet' => $item->pallet,
                                'recycle' => $item->recycle,
                                'status' => 'Sale'
            
                            ]);
        
                        }
        
                        Mail::to('qa@century.vn')->cc('luongphan@soitheky.vn')->send(new MailPhieuXXDH('SM APPROVED',$this->soPhieu, Auth::user()->username, $PhieuXXDHLog->updated_at,''));
        
                        flash()->addFlash('success', 'Duyệt thành công phiếu : ' . $this->soPhieu,'Thông báo');
        
                        $this->emit('approvePhieuXXDHModal');
        
                        $this->resetInputField();
        
                    }elseif($pxxdh->status == 'SM APPROVED'){

                        $pxxdh->status = 'QA REQUESTED';
                        $pxxdh->qa_kien_nghi = $this->qaKienNghi;
                        $pxxdh->qa_request = Auth::user()->username;
                        $pxxdh->qa_request_at = Carbon::now();
                        $pxxdh->updated_user = Auth::user()->username;
                
                        $pxxdh->update();
        
                        $arr = [
        
                            'so_phieu' => $pxxdh->so_phieu,
                            'loai' => $pxxdh->loai,
                            'don_hang_grs' => $pxxdh->don_hang_grs,
                            'don_hang_non_grs' => $pxxdh->don_hang_non_grs,
                            'don_hang_sx_moi' => $pxxdh->don_hang_sx_moi,
                            'don_hang_lap_lai' => $pxxdh->don_hang_lap_lai,
                            'don_hang_ton_kho' => $pxxdh->don_hang_ton_kho,
                            'date' => $pxxdh->date,
                            'ten_cong_ty' => $pxxdh->ten_cong_ty,
                            'so' => $pxxdh->so,
                            'hop_dong' => $pxxdh->hop_dong,
                            'qa_kien_nghi' => $pxxdh->qa_kien_nghi,
                            'thanh_pham_cua_khach_hang' => $pxxdh->thanh_pham_cua_khach_hang,
                            'phan_anh_cua_khach_hang' => $pxxdh->phan_anh_cua_khach_hang,
                            'phan_hoi_khst' => $this->phanHoiKHST,
        
                            'mail_chinh' => $pxxdh->mail_chinh,
                            'mail_phu_1' => $pxxdh->mail_phu_1,
                            'mail_phu_2' => $pxxdh->mail_phu_2,
            
                            'status' => 'QA REQUESTED',
                            'created_user' => $pxxdh->created_user,
                            
                            'status_log' => 'Approve',
                            'updated_user' => Auth::user()->username,
            
                        ];
            
                        $PhieuXXDHLog = PhieuXXDHLog::create($arr);
        
                        foreach ($this->quyCachPhieuXXDH as $item) {
                            
                            QuyCachPhieuXXDHLog::create([
                                
                                'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                                'quy_cach' => $item->quy_cach,
                                'so_luong' => $item->so_luong,
                                'kieu_may_det' => $item->kieu_may_det,
                                'lot' => $item->lot,
                                'so_cone' => $item->so_cone,
                                'so_kg_cone' => $item->so_kg_cone,
                                'line' => $item->line,
                                'may' => $item->may,
                                'ngay_giao_hang' => $item->ngay_giao_hang,
                                'ngay_bat_dau_giao' => $item->ngay_bat_dau_giao,
                                'thong_tin_dong_goi' => $item->thong_tin_dong_goi,
                                'pallet' => $item->pallet,
                                'recycle' => $item->recycle,
                                'status' => 'Sale'
            
                            ]);
        
                        }
        
                        Mail::to('khth@century.vn')->cc('luongphan@soitheky.vn')->send(new MailPhieuXXDH('QA APPROVED',$this->soPhieu, Auth::user()->username, $PhieuXXDHLog->updated_at, ''));
        
                        flash()->addFlash('success', 'Duyệt thành công phiếu : ' . $this->soPhieu,'Thông báo');
        
                        $this->emit('approvePhieuXXDHModal');
        
                        $this->resetInputField();

                    }elseif($pxxdh->status == 'QA REQUESTED'){

                        $ccMail = [];
    
                        if($this->cbCC == 1){
    
                            $phanBoPTKSX =  PhanBoPTKSX::where('nha_may', 'CC')->first();
    
                            $ccMail = array_merge($ccMail,[$phanBoPTKSX->email]);
    
                            $mailCC = $phanBoPTKSX->email;
    
                        }else{
    
                            $mailCC = '';
    
                        }
    
                        if($this->cbTB2 == 1){
    
                            $phanBoPTKSX =  PhanBoPTKSX::where('nha_may', 'TB2')->first();
    
                            $ccMail = array_merge($ccMail,[$phanBoPTKSX->email]);
    
                            $mailTB2 = $phanBoPTKSX->email;
    
                        }else{
    
                            $mailTB2 = '';
    
                        }
    
                        if($this->cbTB3 == 1){
    
                            $phanBoPTKSX =  PhanBoPTKSX::where('nha_may', 'TB3')->first();
    
                            $ccMail = array_merge($ccMail,[$phanBoPTKSX->email]);
    
                            $mailTB3 = $phanBoPTKSX->email;
    
                        }else{
    
                            $mailTB3 = '';
    
                        }
    
                        $pxxdh->status = 'KHST APPROVED';
                        $pxxdh->phan_hoi_khst = $this->phanHoiKHST;
                        $pxxdh->line = $this->Line;
                        $pxxdh->phan_bo_cc = $mailCC;
                        $pxxdh->phan_bo_tb2 = $mailTB2;
                        $pxxdh->phan_bo_tb3 = $mailTB3;
                        $pxxdh->xac_nhan_phan_bo = null;
                        $pxxdh->updated_user = Auth::user()->username;
                        $pxxdh->khst_approved = Auth::user()->username;
                        $pxxdh->khst_approved_at = Carbon::now();
                
                        $pxxdh->update();
        
                        $arr = [
        
                            'so_phieu' => $pxxdh->so_phieu,
                            'loai' => $pxxdh->loai,
                            'don_hang_grs' => $pxxdh->don_hang_grs,
                            'don_hang_non_grs' => $pxxdh->don_hang_non_grs,
                            'don_hang_sx_moi' => $pxxdh->don_hang_sx_moi,
                            'don_hang_lap_lai' => $pxxdh->don_hang_lap_lai,
                            'don_hang_ton_kho' => $pxxdh->don_hang_ton_kho,
                            'date' => $pxxdh->date,
                            'ten_cong_ty' => $pxxdh->ten_cong_ty,
                            'so' => $pxxdh->so,
                            'hop_dong' => $pxxdh->hop_dong,
                            'qa_kien_nghi' => $pxxdh->qa_kien_nghi,
                            'thanh_pham_cua_khach_hang' => $pxxdh->thanh_pham_cua_khach_hang,
                            'phan_anh_cua_khach_hang' => $pxxdh->phan_anh_cua_khach_hang,
                            'phan_hoi_khst' => $this->phanHoiKHST,
                            'phan_bo_cc' => $mailCC,
                            'phan_bo_tb2' => $mailTB2,
                            'phan_bo_tb3' => $mailTB3,
        
                            'mail_chinh' => $pxxdh->mail_chinh,
                            'mail_phu_1' => $pxxdh->mail_phu_1,
                            'mail_phu_2' => $pxxdh->mail_phu_2,
            
                            'status' => 'KHST APPROVED',
                            'created_user' => $pxxdh->created_user,
                            
                            'status_log' => 'Approve',
                            'updated_user' => Auth::user()->username,
            
                        ];
            
                        $PhieuXXDHLog = PhieuXXDHLog::create($arr);
        
                        foreach ($this->quyCachPhieuXXDH as $item) {
                            
                            QuyCachPhieuXXDHLog::create([
                                
                                'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                                'quy_cach' => $item->quy_cach,
                                'so_luong' => $item->so_luong,
                                'kieu_may_det' => $item->kieu_may_det,
                                'lot' => $item->lot,
                                'so_cone' => $item->so_cone,
                                'so_kg_cone' => $item->so_kg_cone,
                                'line' => $item->line,
                                'may' => $item->may,
                                'ngay_giao_hang' => $item->ngay_giao_hang,
                                'ngay_bat_dau_giao' => $item->ngay_bat_dau_giao,
                                'thong_tin_dong_goi' => $item->thong_tin_dong_goi,
                                'pallet' => $item->pallet,
                                'recycle' => $item->recycle,
                                'status' => 'Sale'
            
                            ]);
        
                        }

                        if($this->quyCachSuDungKHST != null){

                            foreach (array_reverse($this->quyCachSuDungKHST, true) as $key => $value) {
        
                                QuyCachPhieuXXDH::create([
                
                                    'phieu_xxdh_so_phieu_id' => $pxxdh->id,
                                    'quy_cach' => $this->quyCachSuDungKHST[$key],
                                    'so_luong' => $this->soLuongKHST[$key],
                                    'lot' => $this->lotKHST[$key],
                                    'status' => 'KHST'
            
                                ]);
                
                                QuyCachPhieuXXDHLog::create([
                
                                    'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                                    'quy_cach' => $this->quyCachSuDungKHST[$key],
                                    'so_luong' => $this->soLuongKHST[$key],
                                    'lot' => $this->lotKHST[$key],
                                    'status' => 'KHST'
                
                                ]);
                            }

                        }
    
                        Storage::disk('public')->makeDirectory('PhieuXXDH/' . $pxxdh->so_phieu);
        
                        $templateProcessor = new TemplateProcessor(public_path('PhieuXXDH/PXXDH.docx'));
        
                        $values = [
        
                            'date' => Carbon::create($pxxdh->date)->format('d-m-Y'),
                            'ten_cong_ty' => $pxxdh->ten_cong_ty,
                            'so' => $pxxdh->so,
                            'so_phieu' => $pxxdh->so_phieu,
                            'phan_hoi_khst' => $pxxdh->phan_hoi_khst,
        
                        ];
        
                        if($pxxdh->don_hang_grs == '1')
                            $templateProcessor->setImageValue('im_grs', 'images/icons-checkbox.png');
                        else
                            $templateProcessor->setImageValue('im_grs', 'images/icons-square.png');
        
                        if($pxxdh->don_hang_non_grs == '1')
                            $templateProcessor->setImageValue('im_non_grs', 'images/icons-checkbox.png');
                        else
                            $templateProcessor->setImageValue('im_non_grs', 'images/icons-square.png');
        
                        if($pxxdh->don_hang_sx_moi == '1')
                            $templateProcessor->setImageValue('im_moi', 'images/icons-checkbox.png');
                        else
                            $templateProcessor->setImageValue('im_moi', 'images/icons-square.png');
        
                        if($pxxdh->don_hang_lap_lai == '1')
                            $templateProcessor->setImageValue('im_lap_lai', 'images/icons-checkbox.png');
                        else
                            $templateProcessor->setImageValue('im_lap_lai', 'images/icons-square.png');
        
                        if($pxxdh->don_hang_ton_kho == '1')
                            $templateProcessor->setImageValue('im_ton_kho', 'images/icons-checkbox.png');
                        else
                            $templateProcessor->setImageValue('im_ton_kho', 'images/icons-square.png');
        
                        $templateProcessor->setValues($values);
                
                        $templateProcessor->saveAs(storage_path('app/public/PhieuXXDH/') . $pxxdh->so_phieu . '/' . $pxxdh->so_phieu .'.docx');
    
                        // Tạo file excel quy cách
    
                        $spreadsheet = new Spreadsheet();
    
                        $activeWorksheet = $spreadsheet->getActiveSheet();
    
                        $activeWorksheet->setTitle($this->soPhieu . ' - Quy cách');
    
                        $styleArray = [
                            'borders' => [
                                'outline' => [
                                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                                    'color' => ['argb' => '000000'],
                                ],
                            ],
                        ];
    
                        $activeWorksheet->getColumnDimensionByColumn(1)->setAutoSize(true);
                        $activeWorksheet->getColumnDimensionByColumn(2)->setAutoSize(true);
                        $activeWorksheet->getColumnDimensionByColumn(3)->setAutoSize(true);
                        $activeWorksheet->getColumnDimensionByColumn(4)->setAutoSize(true);
                        $activeWorksheet->getColumnDimensionByColumn(5)->setAutoSize(true);
                        $activeWorksheet->getColumnDimensionByColumn(6)->setAutoSize(true);
                        $activeWorksheet->getColumnDimensionByColumn(7)->setAutoSize(true);
                        $activeWorksheet->getColumnDimensionByColumn(8)->setAutoSize(true);
                        $activeWorksheet->getColumnDimensionByColumn(9)->setAutoSize(true);
                        $activeWorksheet->getColumnDimensionByColumn(10)->setAutoSize(true);
                        $activeWorksheet->getColumnDimensionByColumn(11)->setAutoSize(true);
                        $activeWorksheet->getColumnDimensionByColumn(12)->setAutoSize(true);
                        $activeWorksheet->getColumnDimensionByColumn(13)->setAutoSize(true);
    
                        $activeWorksheet->setCellValue('A1', 'Sale');
    
                        $activeWorksheet->mergeCells('A1:M1');
    
                        $activeWorksheet->setCellValue('A2', 'Quy cách');
                        $activeWorksheet->setCellValue('B2', 'Số lượng (kgs)');
                        $activeWorksheet->setCellValue('C2', 'Kiểu máy dệt + điều kiện đặc biệt của khách hàng');
                        $activeWorksheet->setCellValue('D2', 'Chạy theo TS LOT');
                        $activeWorksheet->setCellValue('E2', 'Số cone');
                        $activeWorksheet->setCellValue('F2', 'Số kg/cone');
                        $activeWorksheet->setCellValue('G2', 'Line');
                        $activeWorksheet->setCellValue('H2', 'Máy');
                        $activeWorksheet->setCellValue('I2', 'Ngày giao hàng');
                        $activeWorksheet->setCellValue('J2', 'Ngày bắt đầu giao (nếu có)');
                        $activeWorksheet->setCellValue('K2', 'Thông tin đóng gói');
                        $activeWorksheet->setCellValue('L2', 'Pallet');
                        $activeWorksheet->setCellValue('M2', 'Recycle');
    
                        $activeWorksheet->getStyle('A1:M2')->getFont()->setBold(true);
    
                        $currentRow = 3;
    
                        foreach ($this->quyCachPhieuXXDH as $item){
        
                            $activeWorksheet->setCellValue('A' . $currentRow, $item->quy_cach);
                            $activeWorksheet->setCellValue('B' . $currentRow, $item->so_luong);
                            $activeWorksheet->setCellValue('C' . $currentRow, $item->kieu_may_det);
                            $activeWorksheet->setCellValue('D' . $currentRow, $item->lot);
                            $activeWorksheet->setCellValue('E' . $currentRow, $item->so_cone);
                            $activeWorksheet->setCellValue('F' . $currentRow, $item->so_kg_cone);
                            $activeWorksheet->setCellValue('G' . $currentRow, $item->line);
                            $activeWorksheet->setCellValue('H' . $currentRow, $item->may);
                            $activeWorksheet->setCellValue('I' . $currentRow, $item->ngay_giao_hang);
                            $activeWorksheet->setCellValue('J' . $currentRow, $item->ngay_bat_dau_giao);
                            $activeWorksheet->setCellValue('K' . $currentRow, $item->thong_tin_dong_goi);
                            $activeWorksheet->setCellValue('L' . $currentRow, $item->pallet);
                            $activeWorksheet->setCellValue('M' . $currentRow, $item->recycle);
    
                            $currentRow = $currentRow + 1;
        
                        }
    
                        $activeWorksheet
                        ->getStyle('A1' . ':M' . $currentRow - 1)
                        ->getBorders()
                        ->getAllBorders()
                        ->setBorderStyle(Border::BORDER_THIN)
                        ->setColor(new Color('17202A'));
    
                        $activeWorksheet->getStyle('A1' . ':M' . $currentRow - 1)->applyFromArray($styleArray);
    
                        $activeWorksheet->setCellValue('A' . $currentRow + 1, 'KHST');
    
                        $currentRowKHST = $currentRow + 1;
    
                        $activeWorksheet->mergeCells('A' . $currentRow + 1 . ':M' . $currentRow + 1);
    
                        $activeWorksheet->getStyle('A' . $currentRow + 1 . ':M' . $currentRow + 2)->getFont()->setBold(true);
    
                        $activeWorksheet->setCellValue('A' . $currentRow + 2, 'Quy cách');
                        $activeWorksheet->setCellValue('B' . $currentRow + 2, 'Số lượng (kgs)');
                        $activeWorksheet->setCellValue('C' . $currentRow + 2, 'Kiểu máy dệt + điều kiện đặc biệt của khách hàng');
    
                        $currentRow = $currentRow + 3;
        
                        foreach ($this->quyCachPhieuXXDHKHST as $item2){
        
                            $activeWorksheet->setCellValue('A' . $currentRow, $item2->quy_cach);
                            $activeWorksheet->setCellValue('B' . $currentRow, $item2->so_luong);
                            $activeWorksheet->setCellValue('C' . $currentRow, $item2->kieu_may_det);
    
                            $currentRow = $currentRow + 1;
        
                        }
    
                        $activeWorksheet
                        ->getStyle('A' . $currentRowKHST . ':M' . $currentRow - 1)
                        ->getBorders()
                        ->getAllBorders()
                        ->setBorderStyle(Border::BORDER_THIN)
                        ->setColor(new Color('17202A'));
    
                        $activeWorksheet->getStyle('A' . $currentRowKHST . ':M' . $currentRow - 1)->applyFromArray($styleArray);
    
                        $activeWorksheet->setCellValue('A' . $currentRow + 1, 'Thành phẩm của khách hàng');
                        $activeWorksheet->setCellValue('B' . $currentRow + 1, 'Phản ánh của khách hàng về lot cũ');
    
                        $activeWorksheet->setCellValue('A' . $currentRow + 2, $pxxdh->thanh_pham_cua_khach_hang);
                        $activeWorksheet->setCellValue('B' . $currentRow + 2, $pxxdh->phan_anh_cua_khach_hang);
    
                        $activeWorksheet->getStyle('A' . $currentRow + 1 . ':B' . $currentRow + 1)->getFont()->setBold(true);
    
                        $activeWorksheet
                        ->getStyle('A' . $currentRow + 1 . ':B' . $currentRow + 2)
                        ->getBorders()
                        ->getAllBorders()
                        ->setBorderStyle(Border::BORDER_THIN)
                        ->setColor(new Color('17202A'));
    
                        $writer = new Xlsx($spreadsheet);
    
                        ob_start();
                        $writer->save('php://output');
                        $content = ob_get_contents();
                        ob_end_clean();
    
                        Storage::disk('public')->put('PhieuXXDH/' . $this->soPhieu . '/' . $this->soPhieu . ".xlsx", $content);

                        $user = User::where('username', $pxxdh->created_user)->first();
        
                        Mail::to($user->email)->cc('luongphan@soitheky.vn')->cc($ccMail)->send(new MailPhieuXXDH('KHST APPROVED',$this->soPhieu, Auth::user()->username, $PhieuXXDHLog->updated_at, ''));
        
                        flash()->addFlash('success', 'Duyệt thành công phiếu : ' . $this->soPhieu,'Thông báo');
        
                        $this->emit('approvePhieuXXDHModal');
        
                        $this->resetInputField();
                        
                    }elseif($pxxdh->status == 'KHST APPROVED'){
    
                        $soTam = SOTam::where('so_tam', $pxxdh->so)->first();

                        if($soTam == null){

                            flash()->addError('Không tìm thấy thông tin SO tạm.');
                            $this->resetInputField();
                            $this->emit('closeModal');
                            return;

                        }else{

                            $soTam->so_chinh_thuc = $this->soChinhThuc;
                            $soTam->updated_user = auth()->user()->username;
                            $soTam->save();

                            $laySO = SO::where('so', $pxxdh->so)->first();

                            $arraySO = explode(",", str_replace(' ', '', $this->soChinhThuc));

                            foreach ($arraySO as $key=>$value) {

                                $so = new SO();

                                $so->so = $value;
                                $so->hop_dong = $laySO->hop_dong;
                                $so->phieu_xxdh = $laySO->phieu_xxdh;
                                $so->status_phieu_xxdh = $laySO->status_phieu_xxdh;
                                $so->phieu_tksx = $laySO->phieu_tksx;
                                $so->status_phieu_tksx = $laySO->status_phieu_tksx;
                                $so->bk = $laySO->bk;
                                $so->lc = $laySO->lc;
                                $so->cthq = $laySO->cthq;
                                $so->pxk = $laySO->pxk;
                                $so->co = $laySO->co;
                                $so->tkxh = $laySO->tkxh;
                                $so->tlcd = $laySO->tlcd;
                                $so->created_at = $laySO->created_at;
                                $so->updated_at = $laySO->updated_at;

                                $so->save();
                            }
                        }

                        $tksx = PhieuTKSX::where('so', $pxxdh->so)->first();
                        $tksx->so = $this->soChinhThuc;
                        $tksx->save();

                        $pxxdh->so = $this->soChinhThuc;
                        $pxxdh->status = 'ADMIN APPROVED';
                        $pxxdh->admin_approved = Auth::user()->username;
                        $pxxdh->admin_approved_at = Carbon::now();
                        $pxxdh->updated_user = Auth::user()->username;
                
                        $pxxdh->update();
        
                        $arr = [
        
                            'so_phieu' => $pxxdh->so_phieu,
                            'loai' => $pxxdh->loai,
                            'don_hang_grs' => $pxxdh->don_hang_grs,
                            'don_hang_non_grs' => $pxxdh->don_hang_non_grs,
                            'don_hang_sx_moi' => $pxxdh->don_hang_sx_moi,
                            'don_hang_lap_lai' => $pxxdh->don_hang_lap_lai,
                            'don_hang_ton_kho' => $pxxdh->don_hang_ton_kho,
                            'date' => $pxxdh->date,
                            'ten_cong_ty' => $pxxdh->ten_cong_ty,
                            'so' => $this->soChinhThuc,
                            'hop_dong' => $pxxdh->hop_dong,
                            'qa_kien_nghi' => $pxxdh->qa_kien_nghi,
                            'thanh_pham_cua_khach_hang' => $pxxdh->thanh_pham_cua_khach_hang,
                            'phan_anh_cua_khach_hang' => $pxxdh->phan_anh_cua_khach_hang,
                            'phan_hoi_khst' => $this->phanHoiKHST,
        
                            'mail_chinh' => $pxxdh->mail_chinh,
                            'mail_phu_1' => $pxxdh->mail_phu_1,
                            'mail_phu_2' => $pxxdh->mail_phu_2,
            
                            'status' => 'ADMIN APPROVED',
                            'created_user' => $pxxdh->created_user,
                            
                            'status_log' => 'Approve',
                            'updated_user' => Auth::user()->username,
            
                        ];
            
                        $PhieuXXDHLog = PhieuXXDHLog::create($arr);
        
                        foreach ($this->quyCachPhieuXXDH as $item) {
                            
                            QuyCachPhieuXXDHLog::create([
                                
                                'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                                'quy_cach' => $item->quy_cach,
                                'so_luong' => $item->so_luong,
                                'kieu_may_det' => $item->kieu_may_det,
                                'lot' => $item->lot,
                                'so_cone' => $item->so_cone,
                                'so_kg_cone' => $item->so_kg_cone,
                                'line' => $item->line,
                                'may' => $item->may,
                                'ngay_giao_hang' => $item->ngay_giao_hang,
                                'ngay_bat_dau_giao' => $item->ngay_bat_dau_giao,
                                'thong_tin_dong_goi' => $item->thong_tin_dong_goi,
                                'pallet' => $item->pallet,
                                'recycle' => $item->recycle,
                                'status' => 'Sale'
            
                            ]);
        
                        }

                        foreach ($this->quyCachPhieuXXDHKHST as $item) {
        
                            QuyCachPhieuXXDHLog::create([
            
                                'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                                'quy_cach' => $item->quy_cach,
                                'so_luong' => $item->so_luong,
                                'lot' => $item->lot,
                                'status' => 'KHST'
            
                            ]);
                        }

                        $templateProcessor = new TemplateProcessor(storage_path('app/public/PhieuXXDH/') . $pxxdh->so_phieu . '/' . $pxxdh->so_phieu .'.docx');

                        $values = [
        
                            'so' => $this->soChinhThuc
        
                        ];
    
                        $templateProcessor->setValues($values);
    
                        $templateProcessor->saveAs(storage_path('app/public/PhieuXXDH/') . $pxxdh->so_phieu . '/' . $pxxdh->so_phieu .'.docx');
        
                        Mail::to('qa@century.vn')->cc('luongphan@soitheky.vn')->send(new MailPhieuXXDH('ADMIN APPROVED',$this->soPhieu, Auth::user()->username, $PhieuXXDHLog->updated_at, ''));
        
                        flash()->addFlash('success', 'Duyệt thành công phiếu : ' . $this->soPhieu,'Thông báo');
        
                        $this->emit('approvePhieuXXDHModal');
        
                        $this->resetInputField();
    
                    }elseif($pxxdh->status == 'ADMIN APPROVED'){

                        $pxxdh->status = 'QA APPROVED';
                        $pxxdh->phan_hoi_qa = $this->phanHoiQA;
                        $pxxdh->updated_user = Auth::user()->username;
                        $pxxdh->qa_approved = Auth::user()->username;
                        $pxxdh->qa_approved_at = Carbon::now();
                
                        $pxxdh->update();
        
                        $arr = [
        
                            'so_phieu' => $pxxdh->so_phieu,
                            'loai' => $pxxdh->loai,
                            'don_hang_grs' => $pxxdh->don_hang_grs,
                            'don_hang_non_grs' => $pxxdh->don_hang_non_grs,
                            'don_hang_sx_moi' => $pxxdh->don_hang_sx_moi,
                            'don_hang_lap_lai' => $pxxdh->don_hang_lap_lai,
                            'don_hang_ton_kho' => $pxxdh->don_hang_ton_kho,
                            'date' => $pxxdh->date,
                            'ten_cong_ty' => $pxxdh->ten_cong_ty,
                            'so' => $pxxdh->so,
                            'hop_dong' => $pxxdh->hop_dong,
                            'qa_kien_nghi' => $pxxdh->qa_kien_nghi,
                            'thanh_pham_cua_khach_hang' => $pxxdh->thanh_pham_cua_khach_hang,
                            'phan_anh_cua_khach_hang' => $pxxdh->phan_anh_cua_khach_hang,
                            'phan_hoi_khst' => $pxxdh->phanHoiKHST,
                            'phan_hoi_qa' => $this->phanHoiQA,
                            'phan_bo_cc' => $pxxdh->cbCC,
                            'phan_bo_tb2' => $pxxdh->cbTB2,
                            'phan_bo_tb3' => $pxxdh->cbTB3,
        
                            'mail_chinh' => $pxxdh->mail_chinh,
                            'mail_phu_1' => $pxxdh->mail_phu_1,
                            'mail_phu_2' => $pxxdh->mail_phu_2,
            
                            'status' => 'QA APPROVED',
                            'created_user' => $pxxdh->created_user,
                            
                            'status_log' => 'Approve',
                            'updated_user' => Auth::user()->username,
            
                        ];
        
                        $PhieuXXDHLog = PhieuXXDHLog::create($arr);
        
                        foreach ($this->quyCachPhieuXXDH as $item) {
                            
                            QuyCachPhieuXXDHLog::create([
                                
                                'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                                'quy_cach' => $item->quy_cach,
                                'so_luong' => $item->so_luong,
                                'kieu_may_det' => $item->kieu_may_det,
                                'lot' => $item->lot,
                                'so_cone' => $item->so_cone,
                                'so_kg_cone' => $item->so_kg_cone,
                                'line' => $item->line,
                                'may' => $item->may,
                                'ngay_giao_hang' => $item->ngay_giao_hang,
                                'ngay_bat_dau_giao' => $item->ngay_bat_dau_giao,
                                'thong_tin_dong_goi' => $item->thong_tin_dong_goi,
                                'pallet' => $item->pallet,
                                'recycle' => $item->recycle,
                                'status' => 'Sale'    
                            ]);
        
                        }
        
                        foreach ($this->quyCachPhieuXXDHKHST as $item) {
            
                            QuyCachPhieuXXDHLog::create([
            
                                'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                                'quy_cach' => $item->quy_cach,
                                'so_luong' => $item->so_luong,
                                'lot' => $item->lot,
                                'status' => 'KHST'
            
                            ]);
                        }

                        $templateProcessor = new TemplateProcessor(storage_path('app/public/PhieuXXDH/') . $pxxdh->so_phieu . '/' . $pxxdh->so_phieu .'.docx');

                        $values = [
        
                            'phan_hoi_qa' => $this->phanHoiQA
        
                        ];
    
                        $templateProcessor->setValues($values);
    
                        $templateProcessor->saveAs(storage_path('app/public/PhieuXXDH/') . $pxxdh->so_phieu . '/' . $pxxdh->so_phieu .'.docx');

                        $user = User::where('username', $pxxdh->created_user)->first();
        
                        Mail::to($user->email)->cc('luongphan@soitheky.vn')->send(new MailPhieuXXDH('QA APPROVED',$this->soPhieu, Auth::user()->username, $PhieuXXDHLog->updated_at, ''));
        
                        flash()->addFlash('success', 'Duyệt thành công phiếu : ' . $this->soPhieu,'Thông báo');
        
                        $this->emit('approvePhieuXXDHModal');
        
                        $this->resetInputField();

                    }elseif($pxxdh->status == 'QA APPROVED'){
                        $pxxdh->status = 'Finish';
                        $pxxdh->updated_user = Auth::user()->username;
                        $pxxdh->finish = Auth::user()->username;
                        $pxxdh->finish_at = Carbon::now();
                
                        $pxxdh->update();
        
                        $arr = [
        
                            'so_phieu' => $pxxdh->so_phieu,
                            'loai' => $pxxdh->loai,
                            'don_hang_grs' => $pxxdh->don_hang_grs,
                            'don_hang_non_grs' => $pxxdh->don_hang_non_grs,
                            'don_hang_sx_moi' => $pxxdh->don_hang_sx_moi,
                            'don_hang_lap_lai' => $pxxdh->don_hang_lap_lai,
                            'don_hang_ton_kho' => $pxxdh->don_hang_ton_kho,
                            'date' => $pxxdh->date,
                            'ten_cong_ty' => $pxxdh->ten_cong_ty,
                            'so' => $pxxdh->so,
                            'hop_dong' => $pxxdh->hop_dong,
                            'qa_kien_nghi' => $pxxdh->qa_kien_nghi,
                            'thanh_pham_cua_khach_hang' => $pxxdh->thanh_pham_cua_khach_hang,
                            'phan_anh_cua_khach_hang' => $pxxdh->phan_anh_cua_khach_hang,
                            'phan_hoi_khst' => $pxxdh->phanHoiKHST,
                            'phan_hoi_qa' => $pxxdh->phanHoiQA,
                            'phan_bo_cc' => $pxxdh->cbCC,
                            'phan_bo_tb2' => $pxxdh->cbTB2,
                            'phan_bo_tb3' => $pxxdh->cbTB3,
        
                            'mail_chinh' => $pxxdh->mail_chinh,
                            'mail_phu_1' => $pxxdh->mail_phu_1,
                            'mail_phu_2' => $pxxdh->mail_phu_2,
            
                            'status' => 'Finish',
                            'created_user' => $pxxdh->created_user,
                            
                            'status_log' => 'Finish',
                            'updated_user' => Auth::user()->username,
            
                        ];
        
                        $PhieuXXDHLog = PhieuXXDHLog::create($arr);
        
                        foreach ($this->quyCachPhieuXXDH as $item) {
                            
                            QuyCachPhieuXXDHLog::create([
                                
                                'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                                'quy_cach' => $item->quy_cach,
                                'so_luong' => $item->so_luong,
                                'kieu_may_det' => $item->kieu_may_det,
                                'lot' => $item->lot,
                                'so_cone' => $item->so_cone,
                                'so_kg_cone' => $item->so_kg_cone,
                                'line' => $item->line,
                                'may' => $item->may,
                                'ngay_giao_hang' => $item->ngay_giao_hang,
                                'ngay_bat_dau_giao' => $item->ngay_bat_dau_giao,
                                'thong_tin_dong_goi' => $item->thong_tin_dong_goi,
                                'pallet' => $item->pallet,
                                'recycle' => $item->recycle,
                                'status' => 'Sale'    
                            ]);
        
                        }
        
                        foreach ($this->quyCachPhieuXXDHKHST as $item) {
            
                            QuyCachPhieuXXDHLog::create([
            
                                'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                                'quy_cach' => $item->quy_cach,
                                'so_luong' => $item->so_luong,
                                'lot' => $item->lot,
                                'status' => 'KHST'
            
                            ]);
                        }
        
                        SO::where('so', $pxxdh->so)->update([
        
                            'status_phieu_xxdh' => '1'
                            
                        ]);

                        $cc = [];

                        if($pxxdh->mailPhu1 != null){

                            $cc = array_merge($cc, [

                                $pxxdh->mailPhu1,

                            ]);

                        }

                        if($pxxdh->mailPhu1 != null){

                            $cc = array_merge($cc, [

                                $pxxdh->mailPhu2

                            ]);

                        }
        
                        Mail::to($pxxdh->mail_chinh)
                        ->cc($cc)
                        ->send(new MailPhieuXXDH('Finish',$this->soPhieu, Auth::user()->username, $PhieuXXDHLog->updated_at, ''));
                        flash()->addFlash('success', 'Duyệt thành công phiếu : ' . $this->soPhieu,'Thông báo');
            
                        $this->resetInputField();
            
                        $this->emit('approvePhieuXXDHModal');
                    }
                }else{
                    if($pxxdh->status == 'New'){

                        $pxxdh->status = 'Sale APPROVED';
                        $pxxdh->thanh_pham_cua_khach_hang = $this->thanhPhamCuaKhachHang;
                        $pxxdh->phan_anh_cua_khach_hang = $this->phanAnhCuaKhachHang;
    
                        $pxxdh->sale_approved = Auth::user()->username;
                        $pxxdh->sale_approved_at = Carbon::now();
                        
                        $pxxdh->updated_user = Auth::user()->username;
                
                        $pxxdh->update();
        
                        $arr = [
        
                            'so_phieu' => $pxxdh->so_phieu,
                            'loai' => $pxxdh->loai,
                            'don_hang_grs' => $pxxdh->don_hang_grs,
                            'don_hang_non_grs' => $pxxdh->don_hang_non_grs,
                            'don_hang_sx_moi' => $pxxdh->don_hang_sx_moi,
                            'don_hang_lap_lai' => $pxxdh->don_hang_lap_lai,
                            'don_hang_ton_kho' => $pxxdh->don_hang_ton_kho,
                            'date' => $pxxdh->date,
                            'ten_cong_ty' => $pxxdh->ten_cong_ty,
                            'so' => $pxxdh->so,
                            'hop_dong' => $pxxdh->hop_dong,
                            'thanh_pham_cua_khach_hang' => $pxxdh->thanh_pham_cua_khach_hang,
                            'phan_anh_cua_khach_hang' => $pxxdh->phan_anh_cua_khach_hang,
                            'mail_chinh' => $pxxdh->mail_chinh,
                            'mail_phu_1' => $pxxdh->mail_phu_1,
                            'mail_phu_2' => $pxxdh->mail_phu_2,
            
                            'status' => 'Sale APPROVED',
                            'status_log' => 'Approve',
                            'created_user' => $pxxdh->created_user,
                            'updated_user' => Auth::user()->username,
            
                        ];
            
                        $PhieuXXDHLog = PhieuXXDHLog::create($arr);
    
                        foreach ($this->lot as $key => $value) {
    
                            $insert =  QuyCachPhieuXXDH::where('id' , $key)->first();
    
                            $insert->kieu_may_det = $this->kieuMayDet[$key];
                            $insert->lot = $this->lot[$key];
                            $insert->so_cone = $this->soCone[$key] ?? null;
                            $insert->so_kg_cone = $this->soKgCone[$key] ?? null;
                            $insert->line = $this->Line[$key] ?? null;
                            $insert->may = $this->May[$key] ?? null;
                            $insert->ngay_giao_hang = $this->ngayGiaoHang[$key] ?? null;
                            $insert->ngay_bat_dau_giao = $this->ngayBatDauGiao[$key] ?? null;
                            $insert->lich_du_kien = $this->lichDuKien;
                            $insert->thong_tin_dong_goi = $this->thongTinDongGoi[$key] ?? null;
                            $insert->pallet = $this->pallet[$key] ?? null;
                            $insert->recycle = $this->recycle[$key] ?? null;
        
                            $insert->update();
        
                            QuyCachPhieuXXDHLog::create([
                                
                                'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                                'quy_cach' => $insert->quy_cach,
                                'so_luong' => $insert->so_luong,
                                'kieu_may_det' => $this->kieuMayDet[$key] ?? null,
                                'lot' => $this->lot[$key] ?? null,
                                'so_cone' => $this->soCone[$key] ?? null,
                                'so_kg_cone' => $this->soKgCone[$key] ?? null,
                                'line' => $this->Line[$key] ?? null,
                                'may' => $this->May[$key] ?? null,
                                'ngay_giao_hang' => $this->ngayGiaoHang[$key] ?? null,
                                'ngay_bat_dau_giao' => $this->ngayBatDauGiao[$key] ?? null,
                                'lich_du_kien' => $this->lichDuKien,
                                'thong_tin_dong_goi' => $this->thongTinDongGoi[$key] ?? null,
                                'pallet' => $this->pallet[$key] ?? null,
                                'recycle' => $this->recycle[$key] ?? null,
                                'status' => 'Sale'
            
                            ]);
                        }

        
                        Mail::to('qa@century.vn')->cc('luongphan@soitheky.vn')->send(new MailPhieuXXDH('Sale APPROVED',$this->soPhieu, Auth::user()->username, $PhieuXXDHLog->updated_at, ''));
                        
                        flash()->addFlash('success', 'Duyệt thành công phiếu : ' . $this->soPhieu,'Thông báo');
        
                        $this->emit('approvePhieuXXDHModal');
        
                        $this->resetInputField();
        
                    }elseif($pxxdh->status == 'Sale APPROVED'){
                    
                        $pxxdh->status = 'QA REQUESTED';
                        $pxxdh->qa_kien_nghi = $this->qaKienNghi;
                        $pxxdh->qa_request = Auth::user()->username;
                        $pxxdh->qa_request_at = Carbon::now();
                        $pxxdh->updated_user = Auth::user()->username;
                
                        $pxxdh->update();
        
                        $arr = [
        
                            'so_phieu' => $pxxdh->so_phieu,
                            'loai' => $pxxdh->loai,
                            'don_hang_grs' => $pxxdh->don_hang_grs,
                            'don_hang_non_grs' => $pxxdh->don_hang_non_grs,
                            'don_hang_sx_moi' => $pxxdh->don_hang_sx_moi,
                            'don_hang_lap_lai' => $pxxdh->don_hang_lap_lai,
                            'don_hang_ton_kho' => $pxxdh->don_hang_ton_kho,
                            'date' => $pxxdh->date,
                            'ten_cong_ty' => $pxxdh->ten_cong_ty,
                            'so' => $pxxdh->so,
                            'hop_dong' => $pxxdh->hop_dong,
                            'qa_kien_nghi' => $pxxdh->qa_kien_nghi,
                            'thanh_pham_cua_khach_hang' => $pxxdh->thanh_pham_cua_khach_hang,
                            'phan_anh_cua_khach_hang' => $pxxdh->phan_anh_cua_khach_hang,
                            'phan_hoi_khst' => $this->phanHoiKHST,
        
                            'mail_chinh' => $pxxdh->mail_chinh,
                            'mail_phu_1' => $pxxdh->mail_phu_1,
                            'mail_phu_2' => $pxxdh->mail_phu_2,
            
                            'status' => 'QA REQUESTED',
                            'created_user' => $pxxdh->created_user,
                            
                            'status_log' => 'Approve',
                            'updated_user' => Auth::user()->username,
            
                        ];
            
                        $PhieuXXDHLog = PhieuXXDHLog::create($arr);
        
                        foreach ($this->quyCachPhieuXXDH as $item) {
                            
                            QuyCachPhieuXXDHLog::create([
                                
                                'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                                'quy_cach' => $item->quy_cach,
                                'so_luong' => $item->so_luong,
                                'kieu_may_det' => $item->kieu_may_det,
                                'lot' => $item->lot,
                                'so_cone' => $item->so_cone,
                                'so_kg_cone' => $item->so_kg_cone,
                                'line' => $item->line,
                                'may' => $item->may,
                                'ngay_giao_hang' => $item->ngay_giao_hang,
                                'ngay_bat_dau_giao' => $item->ngay_bat_dau_giao,
                                'thong_tin_dong_goi' => $item->thong_tin_dong_goi,
                                'pallet' => $item->pallet,
                                'recycle' => $item->recycle,
                                'status' => 'Sale'
            
                            ]);
        
                        }
        
                        Mail::to('khth@century.vn')->cc('luongphan@soitheky.vn')->send(new MailPhieuXXDH('QA APPROVED',$this->soPhieu, Auth::user()->username, $PhieuXXDHLog->updated_at, ''));
        
                        flash()->addFlash('success', 'Duyệt thành công phiếu : ' . $this->soPhieu,'Thông báo');
        
                        $this->emit('approvePhieuXXDHModal');
        
                        $this->resetInputField();
        
                    }elseif($pxxdh->status == 'QA REQUESTED'){

                        $ccMail = [];
    
                        if($this->cbCC == 1){
    
                            $phanBoPTKSX =  PhanBoPTKSX::where('nha_may', 'CC')->first();
    
                            $ccMail = array_merge($ccMail,[$phanBoPTKSX->email]);
    
                            $mailCC = $phanBoPTKSX->email;
    
                        }else{
    
                            $mailCC = '';
    
                        }
    
                        if($this->cbTB2 == 1){
    
                            $phanBoPTKSX =  PhanBoPTKSX::where('nha_may', 'TB2')->first();
    
                            $ccMail = array_merge($ccMail,[$phanBoPTKSX->email]);
    
                            $mailTB2 = $phanBoPTKSX->email;
    
                        }else{
    
                            $mailTB2 = '';
    
                        }
    
                        if($this->cbTB3 == 1){
    
                            $phanBoPTKSX =  PhanBoPTKSX::where('nha_may', 'TB3')->first();
    
                            $ccMail = array_merge($ccMail,[$phanBoPTKSX->email]);
    
                            $mailTB3 = $phanBoPTKSX->email;
    
                        }else{
    
                            $mailTB3 = '';
    
                        }
    
                        $pxxdh->status = 'KHST APPROVED';
                        $pxxdh->phan_hoi_khst = $this->phanHoiKHST;
                        $pxxdh->line = $this->Line;
                        $pxxdh->phan_bo_cc = $mailCC;
                        $pxxdh->phan_bo_tb2 = $mailTB2;
                        $pxxdh->phan_bo_tb3 = $mailTB3;
                        $pxxdh->xac_nhan_phan_bo = null;
                        $pxxdh->updated_user = Auth::user()->username;
                        $pxxdh->khst_approved = Auth::user()->username;
                        $pxxdh->khst_approved_at = Carbon::now();
                
                        $pxxdh->update();
        
                        $arr = [
        
                            'so_phieu' => $pxxdh->so_phieu,
                            'loai' => $pxxdh->loai,
                            'don_hang_grs' => $pxxdh->don_hang_grs,
                            'don_hang_non_grs' => $pxxdh->don_hang_non_grs,
                            'don_hang_sx_moi' => $pxxdh->don_hang_sx_moi,
                            'don_hang_lap_lai' => $pxxdh->don_hang_lap_lai,
                            'don_hang_ton_kho' => $pxxdh->don_hang_ton_kho,
                            'date' => $pxxdh->date,
                            'ten_cong_ty' => $pxxdh->ten_cong_ty,
                            'so' => $pxxdh->so,
                            'hop_dong' => $pxxdh->hop_dong,
                            'qa_kien_nghi' => $pxxdh->qa_kien_nghi,
                            'thanh_pham_cua_khach_hang' => $pxxdh->thanh_pham_cua_khach_hang,
                            'phan_anh_cua_khach_hang' => $pxxdh->phan_anh_cua_khach_hang,
                            'phan_hoi_khst' => $this->phanHoiKHST,
                            'phan_bo_cc' => $mailCC,
                            'phan_bo_tb2' => $mailTB2,
                            'phan_bo_tb3' => $mailTB3,
        
                            'mail_chinh' => $pxxdh->mail_chinh,
                            'mail_phu_1' => $pxxdh->mail_phu_1,
                            'mail_phu_2' => $pxxdh->mail_phu_2,
            
                            'status' => 'KHST APPROVED',
                            'created_user' => $pxxdh->created_user,
                            
                            'status_log' => 'Approve',
                            'updated_user' => Auth::user()->username,
            
                        ];
            
                        $PhieuXXDHLog = PhieuXXDHLog::create($arr);
        
                        foreach ($this->quyCachPhieuXXDH as $item) {
                            
                            QuyCachPhieuXXDHLog::create([
                                
                                'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                                'quy_cach' => $item->quy_cach,
                                'so_luong' => $item->so_luong,
                                'kieu_may_det' => $item->kieu_may_det,
                                'lot' => $item->lot,
                                'so_cone' => $item->so_cone,
                                'so_kg_cone' => $item->so_kg_cone,
                                'line' => $item->line,
                                'may' => $item->may,
                                'ngay_giao_hang' => $item->ngay_giao_hang,
                                'ngay_bat_dau_giao' => $item->ngay_bat_dau_giao,
                                'thong_tin_dong_goi' => $item->thong_tin_dong_goi,
                                'pallet' => $item->pallet,
                                'recycle' => $item->recycle,
                                'status' => 'Sale'
            
                            ]);
        
                        }
                        
                        if($this->quyCachSuDungKHST != null){

                            foreach (array_reverse($this->quyCachSuDungKHST, true) as $key => $value) {
        
                                QuyCachPhieuXXDH::create([
                
                                    'phieu_xxdh_so_phieu_id' => $pxxdh->id,
                                    'quy_cach' => $this->quyCachSuDungKHST[$key],
                                    'so_luong' => $this->soLuongKHST[$key],
                                    'lot' => $this->lotKHST[$key],
                                    'status' => 'KHST'
            
                                ]);
                
                                QuyCachPhieuXXDHLog::create([
                
                                    'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                                    'quy_cach' => $this->quyCachSuDungKHST[$key],
                                    'so_luong' => $this->soLuongKHST[$key],
                                    'lot' => $this->lotKHST[$key],
                                    'status' => 'KHST'
                
                                ]);
                            }

                        }
    
                        Storage::disk('public')->makeDirectory('PhieuXXDH/' . $pxxdh->so_phieu);
        
                        $templateProcessor = new TemplateProcessor(public_path('PhieuXXDH/PXXDH.docx'));
        
                        $values = [
        
                            'date' => Carbon::create($pxxdh->date)->format('d-m-Y'),
                            'ten_cong_ty' => $pxxdh->ten_cong_ty,
                            'so' => $pxxdh->so,
                            'so_phieu' => $pxxdh->so_phieu,
                            'phan_hoi_khst' => $pxxdh->phan_hoi_khst,
        
                        ];
        
                        if($pxxdh->don_hang_grs == '1')
                            $templateProcessor->setImageValue('im_grs', 'images/icons-checkbox.png');
                        else
                            $templateProcessor->setImageValue('im_grs', 'images/icons-square.png');
        
                        if($pxxdh->don_hang_non_grs == '1')
                            $templateProcessor->setImageValue('im_non_grs', 'images/icons-checkbox.png');
                        else
                            $templateProcessor->setImageValue('im_non_grs', 'images/icons-square.png');
        
                        if($pxxdh->don_hang_sx_moi == '1')
                            $templateProcessor->setImageValue('im_moi', 'images/icons-checkbox.png');
                        else
                            $templateProcessor->setImageValue('im_moi', 'images/icons-square.png');
        
                        if($pxxdh->don_hang_lap_lai == '1')
                            $templateProcessor->setImageValue('im_lap_lai', 'images/icons-checkbox.png');
                        else
                            $templateProcessor->setImageValue('im_lap_lai', 'images/icons-square.png');
        
                        if($pxxdh->don_hang_ton_kho == '1')
                            $templateProcessor->setImageValue('im_ton_kho', 'images/icons-checkbox.png');
                        else
                            $templateProcessor->setImageValue('im_ton_kho', 'images/icons-square.png');
        
                        $templateProcessor->setValues($values);
                
                        $templateProcessor->saveAs(storage_path('app/public/PhieuXXDH/') . $pxxdh->so_phieu . '/' . $pxxdh->so_phieu .'.docx');
    
                        // Tạo file excel quy cách
    
                        $spreadsheet = new Spreadsheet();
    
                        $activeWorksheet = $spreadsheet->getActiveSheet();
    
                        $activeWorksheet->setTitle($this->soPhieu . ' - Quy cách');
    
                        $styleArray = [
                            'borders' => [
                                'outline' => [
                                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                                    'color' => ['argb' => '000000'],
                                ],
                            ],
                        ];
    
                        $activeWorksheet->getColumnDimensionByColumn(1)->setAutoSize(true);
                        $activeWorksheet->getColumnDimensionByColumn(2)->setAutoSize(true);
                        $activeWorksheet->getColumnDimensionByColumn(3)->setAutoSize(true);
                        $activeWorksheet->getColumnDimensionByColumn(4)->setAutoSize(true);
                        $activeWorksheet->getColumnDimensionByColumn(5)->setAutoSize(true);
                        $activeWorksheet->getColumnDimensionByColumn(6)->setAutoSize(true);
                        $activeWorksheet->getColumnDimensionByColumn(7)->setAutoSize(true);
                        $activeWorksheet->getColumnDimensionByColumn(8)->setAutoSize(true);
                        $activeWorksheet->getColumnDimensionByColumn(9)->setAutoSize(true);
                        $activeWorksheet->getColumnDimensionByColumn(10)->setAutoSize(true);
                        $activeWorksheet->getColumnDimensionByColumn(11)->setAutoSize(true);
                        $activeWorksheet->getColumnDimensionByColumn(12)->setAutoSize(true);
                        $activeWorksheet->getColumnDimensionByColumn(13)->setAutoSize(true);
    
                        $activeWorksheet->setCellValue('A1', 'Sale');
    
                        $activeWorksheet->mergeCells('A1:M1');
    
                        $activeWorksheet->setCellValue('A2', 'Quy cách');
                        $activeWorksheet->setCellValue('B2', 'Số lượng (kgs)');
                        $activeWorksheet->setCellValue('C2', 'Kiểu máy dệt + điều kiện đặc biệt của khách hàng');
                        $activeWorksheet->setCellValue('D2', 'Chạy theo TS LOT');
                        $activeWorksheet->setCellValue('E2', 'Số cone');
                        $activeWorksheet->setCellValue('F2', 'Số kg/cone');
                        $activeWorksheet->setCellValue('G2', 'Line');
                        $activeWorksheet->setCellValue('H2', 'Máy');
                        $activeWorksheet->setCellValue('I2', 'Ngày giao hàng');
                        $activeWorksheet->setCellValue('J2', 'Ngày bắt đầu giao (nếu có)');
                        $activeWorksheet->setCellValue('K2', 'Thông tin đóng gói');
                        $activeWorksheet->setCellValue('L2', 'Pallet');
                        $activeWorksheet->setCellValue('M2', 'Recycle');
    
                        $activeWorksheet->getStyle('A1:M2')->getFont()->setBold(true);
    
                        $currentRow = 3;
    
                        foreach ($this->quyCachPhieuXXDH as $item){
        
                            $activeWorksheet->setCellValue('A' . $currentRow, $item->quy_cach);
                            $activeWorksheet->setCellValue('B' . $currentRow, $item->so_luong);
                            $activeWorksheet->setCellValue('C' . $currentRow, $item->kieu_may_det);
                            $activeWorksheet->setCellValue('D' . $currentRow, $item->lot);
                            $activeWorksheet->setCellValue('E' . $currentRow, $item->so_cone);
                            $activeWorksheet->setCellValue('F' . $currentRow, $item->so_kg_cone);
                            $activeWorksheet->setCellValue('G' . $currentRow, $item->line);
                            $activeWorksheet->setCellValue('H' . $currentRow, $item->may);
                            $activeWorksheet->setCellValue('I' . $currentRow, $item->ngay_giao_hang);
                            $activeWorksheet->setCellValue('J' . $currentRow, $item->ngay_bat_dau_giao);
                            $activeWorksheet->setCellValue('K' . $currentRow, $item->thong_tin_dong_goi);
                            $activeWorksheet->setCellValue('L' . $currentRow, $item->pallet);
                            $activeWorksheet->setCellValue('M' . $currentRow, $item->recycle);
    
                            $currentRow = $currentRow + 1;
        
                        }
    
                        $activeWorksheet
                        ->getStyle('A1' . ':M' . $currentRow - 1)
                        ->getBorders()
                        ->getAllBorders()
                        ->setBorderStyle(Border::BORDER_THIN)
                        ->setColor(new Color('17202A'));
    
                        $activeWorksheet->getStyle('A1' . ':M' . $currentRow - 1)->applyFromArray($styleArray);
    
                        $activeWorksheet->setCellValue('A' . $currentRow + 1, 'KHST');
    
                        $currentRowKHST = $currentRow + 1;
    
                        $activeWorksheet->mergeCells('A' . $currentRow + 1 . ':M' . $currentRow + 1);
    
                        $activeWorksheet->getStyle('A' . $currentRow + 1 . ':M' . $currentRow + 2)->getFont()->setBold(true);
    
                        $activeWorksheet->setCellValue('A' . $currentRow + 2, 'Quy cách');
                        $activeWorksheet->setCellValue('B' . $currentRow + 2, 'Số lượng (kgs)');
                        $activeWorksheet->setCellValue('C' . $currentRow + 2, 'Kiểu máy dệt + điều kiện đặc biệt của khách hàng');
    
                        $currentRow = $currentRow + 3;
        
                        foreach ($this->quyCachPhieuXXDHKHST as $item2){
        
                            $activeWorksheet->setCellValue('A' . $currentRow, $item2->quy_cach);
                            $activeWorksheet->setCellValue('B' . $currentRow, $item2->so_luong);
                            $activeWorksheet->setCellValue('C' . $currentRow, $item2->kieu_may_det);
    
                            $currentRow = $currentRow + 1;
        
                        }
    
                        $activeWorksheet
                        ->getStyle('A' . $currentRowKHST . ':M' . $currentRow - 1)
                        ->getBorders()
                        ->getAllBorders()
                        ->setBorderStyle(Border::BORDER_THIN)
                        ->setColor(new Color('17202A'));
    
                        $activeWorksheet->getStyle('A' . $currentRowKHST . ':M' . $currentRow - 1)->applyFromArray($styleArray);
    
                        $activeWorksheet->setCellValue('A' . $currentRow + 1, 'Thành phẩm của khách hàng');
                        $activeWorksheet->setCellValue('B' . $currentRow + 1, 'Phản ánh của khách hàng về lot cũ');
    
                        $activeWorksheet->setCellValue('A' . $currentRow + 2, $pxxdh->thanh_pham_cua_khach_hang);
                        $activeWorksheet->setCellValue('B' . $currentRow + 2, $pxxdh->phan_anh_cua_khach_hang);
    
                        $activeWorksheet->getStyle('A' . $currentRow + 1 . ':B' . $currentRow + 1)->getFont()->setBold(true);
    
                        $activeWorksheet
                        ->getStyle('A' . $currentRow + 1 . ':B' . $currentRow + 2)
                        ->getBorders()
                        ->getAllBorders()
                        ->setBorderStyle(Border::BORDER_THIN)
                        ->setColor(new Color('17202A'));
    
                        $writer = new Xlsx($spreadsheet);
    
                        ob_start();
                        $writer->save('php://output');
                        $content = ob_get_contents();
                        ob_end_clean();
    
                        Storage::disk('public')->put('PhieuXXDH/' . $this->soPhieu . '/' . $this->soPhieu . ".xlsx", $content);
        
                        Mail::to('qa@century.vn')->cc('luongphan@soitheky.vn')->cc($ccMail)->send(new MailPhieuXXDH('KHST APPROVED',$this->soPhieu, Auth::user()->username, $PhieuXXDHLog->updated_at, ''));
        
                        flash()->addFlash('success', 'Duyệt thành công phiếu : ' . $this->soPhieu,'Thông báo');
        
                        $this->emit('approvePhieuXXDHModal');
        
                        $this->resetInputField();

                    }elseif($pxxdh->status == 'KHST APPROVED'){

                        $pxxdh->status = 'QA APPROVED';
                        $pxxdh->phan_hoi_qa = $this->phanHoiQA;
                        $pxxdh->updated_user = Auth::user()->username;
                        $pxxdh->qa_approved = Auth::user()->username;
                        $pxxdh->qa_approved_at = Carbon::now();
                
                        $pxxdh->update();
        
                        $arr = [
        
                            'so_phieu' => $pxxdh->so_phieu,
                            'loai' => $pxxdh->loai,
                            'don_hang_grs' => $pxxdh->don_hang_grs,
                            'don_hang_non_grs' => $pxxdh->don_hang_non_grs,
                            'don_hang_sx_moi' => $pxxdh->don_hang_sx_moi,
                            'don_hang_lap_lai' => $pxxdh->don_hang_lap_lai,
                            'don_hang_ton_kho' => $pxxdh->don_hang_ton_kho,
                            'date' => $pxxdh->date,
                            'ten_cong_ty' => $pxxdh->ten_cong_ty,
                            'so' => $pxxdh->so,
                            'hop_dong' => $pxxdh->hop_dong,
                            'qa_kien_nghi' => $pxxdh->qa_kien_nghi,
                            'thanh_pham_cua_khach_hang' => $pxxdh->thanh_pham_cua_khach_hang,
                            'phan_anh_cua_khach_hang' => $pxxdh->phan_anh_cua_khach_hang,
                            'phan_hoi_khst' => $pxxdh->phanHoiKHST,
                            'phan_hoi_qa' => $this->phanHoiQA,
                            'phan_bo_cc' => $pxxdh->cbCC,
                            'phan_bo_tb2' => $pxxdh->cbTB2,
                            'phan_bo_tb3' => $pxxdh->cbTB3,
        
                            'mail_chinh' => $pxxdh->mail_chinh,
                            'mail_phu_1' => $pxxdh->mail_phu_1,
                            'mail_phu_2' => $pxxdh->mail_phu_2,
            
                            'status' => 'QA APPROVED',
                            'created_user' => $pxxdh->created_user,
                            
                            'status_log' => 'Approve',
                            'updated_user' => Auth::user()->username,
            
                        ];
        
                        $PhieuXXDHLog = PhieuXXDHLog::create($arr);
        
                        foreach ($this->quyCachPhieuXXDH as $item) {
                            
                            QuyCachPhieuXXDHLog::create([
                                
                                'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                                'quy_cach' => $item->quy_cach,
                                'so_luong' => $item->so_luong,
                                'kieu_may_det' => $item->kieu_may_det,
                                'lot' => $item->lot,
                                'so_cone' => $item->so_cone,
                                'so_kg_cone' => $item->so_kg_cone,
                                'line' => $item->line,
                                'may' => $item->may,
                                'ngay_giao_hang' => $item->ngay_giao_hang,
                                'ngay_bat_dau_giao' => $item->ngay_bat_dau_giao,
                                'thong_tin_dong_goi' => $item->thong_tin_dong_goi,
                                'pallet' => $item->pallet,
                                'recycle' => $item->recycle,
                                'status' => 'Sale'    
                            ]);
        
                        }
        
                        foreach ($this->quyCachPhieuXXDHKHST as $item) {
            
                            QuyCachPhieuXXDHLog::create([
            
                                'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                                'quy_cach' => $item->quy_cach,
                                'so_luong' => $item->so_luong,
                                'lot' => $item->lot,
                                'status' => 'KHST'
            
                            ]);
                        }

                        $templateProcessor = new TemplateProcessor(storage_path('app/public/PhieuXXDH/') . $pxxdh->so_phieu . '/' . $pxxdh->so_phieu .'.docx');

                        $values = [
        
                            'phan_hoi_qa' => $this->phanHoiQA
        
                        ];
    
                        $templateProcessor->setValues($values);
    
                        $templateProcessor->saveAs(storage_path('app/public/PhieuXXDH/') . $pxxdh->so_phieu . '/' . $pxxdh->so_phieu .'.docx');

                        $user = User::where('username', $pxxdh->created_user)->first();
        
                        Mail::to($user->email)->cc('luongphan@soitheky.vn')->send(new MailPhieuXXDH('QA APPROVED',$this->soPhieu, Auth::user()->username, $PhieuXXDHLog->updated_at, ''));
        
                        flash()->addFlash('success', 'Duyệt thành công phiếu : ' . $this->soPhieu,'Thông báo');
        
                        $this->emit('approvePhieuXXDHModal');
        
                        $this->resetInputField();

                    }elseif($pxxdh->status == 'QA APPROVED'){
                        $pxxdh->status = 'Finish';
                        $pxxdh->updated_user = Auth::user()->username;
                        $pxxdh->finish = Auth::user()->username;
                        $pxxdh->finish_at = Carbon::now();
                
                        $pxxdh->update();
        
                        $arr = [
        
                            'so_phieu' => $pxxdh->so_phieu,
                            'loai' => $pxxdh->loai,
                            'don_hang_grs' => $pxxdh->don_hang_grs,
                            'don_hang_non_grs' => $pxxdh->don_hang_non_grs,
                            'don_hang_sx_moi' => $pxxdh->don_hang_sx_moi,
                            'don_hang_lap_lai' => $pxxdh->don_hang_lap_lai,
                            'don_hang_ton_kho' => $pxxdh->don_hang_ton_kho,
                            'date' => $pxxdh->date,
                            'ten_cong_ty' => $pxxdh->ten_cong_ty,
                            'so' => $pxxdh->so,
                            'hop_dong' => $pxxdh->hop_dong,
                            'qa_kien_nghi' => $pxxdh->qa_kien_nghi,
                            'thanh_pham_cua_khach_hang' => $pxxdh->thanh_pham_cua_khach_hang,
                            'phan_anh_cua_khach_hang' => $pxxdh->phan_anh_cua_khach_hang,
                            'phan_hoi_khst' => $pxxdh->phanHoiKHST,
                            'phan_hoi_qa' => $pxxdh->phanHoiQA,
                            'phan_bo_cc' => $pxxdh->cbCC,
                            'phan_bo_tb2' => $pxxdh->cbTB2,
                            'phan_bo_tb3' => $pxxdh->cbTB3,
        
                            'mail_chinh' => $pxxdh->mail_chinh,
                            'mail_phu_1' => $pxxdh->mail_phu_1,
                            'mail_phu_2' => $pxxdh->mail_phu_2,
            
                            'status' => 'Finish',
                            'created_user' => $pxxdh->created_user,
                            
                            'status_log' => 'Finish',
                            'updated_user' => Auth::user()->username,
            
                        ];
        
                        $PhieuXXDHLog = PhieuXXDHLog::create($arr);
        
                        foreach ($this->quyCachPhieuXXDH as $item) {
                            
                            QuyCachPhieuXXDHLog::create([
                                
                                'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                                'quy_cach' => $item->quy_cach,
                                'so_luong' => $item->so_luong,
                                'kieu_may_det' => $item->kieu_may_det,
                                'lot' => $item->lot,
                                'so_cone' => $item->so_cone,
                                'so_kg_cone' => $item->so_kg_cone,
                                'line' => $item->line,
                                'may' => $item->may,
                                'ngay_giao_hang' => $item->ngay_giao_hang,
                                'ngay_bat_dau_giao' => $item->ngay_bat_dau_giao,
                                'thong_tin_dong_goi' => $item->thong_tin_dong_goi,
                                'pallet' => $item->pallet,
                                'recycle' => $item->recycle,
                                'status' => 'Sale'    
                            ]);
        
                        }
        
                        foreach ($this->quyCachPhieuXXDHKHST as $item) {
            
                            QuyCachPhieuXXDHLog::create([
            
                                'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                                'quy_cach' => $item->quy_cach,
                                'so_luong' => $item->so_luong,
                                'lot' => $item->lot,
                                'status' => 'KHST'
            
                            ]);
                        }
        
                        SO::where('so', $pxxdh->so)->update([
        
                            'status_phieu_xxdh' => '1'
                            
                        ]);

                        $cc = [];

                        if($pxxdh->mailPhu1 != null){

                            $cc = array_merge($cc, [

                                $pxxdh->mailPhu1,

                            ]);

                        }

                        if($pxxdh->mailPhu1 != null){

                            $cc = array_merge($cc, [

                                $pxxdh->mailPhu2

                            ]);

                        }
        
                        Mail::to($pxxdh->mail_chinh)
                        ->cc($cc)
                        ->send(new MailPhieuXXDH('Finish',$this->soPhieu, Auth::user()->username, $PhieuXXDHLog->updated_at, ''));
                        flash()->addFlash('success', 'Duyệt thành công phiếu : ' . $this->soPhieu,'Thông báo');
            
                        $this->resetInputField();
            
                        $this->emit('approvePhieuXXDHModal');
                    }
                }
            }else{
                if($pxxdh->status == 'New'){

                    $pxxdh->status = 'Sale APPROVED';
                    $pxxdh->thanh_pham_cua_khach_hang = $this->thanhPhamCuaKhachHang;
                    $pxxdh->phan_anh_cua_khach_hang = $this->phanAnhCuaKhachHang;

                    $pxxdh->sale_approved = Auth::user()->username;
                    $pxxdh->sale_approved_at = Carbon::now();
                    
                    $pxxdh->updated_user = Auth::user()->username;
            
                    $pxxdh->update();
    
                    $arr = [
    
                        'so_phieu' => $pxxdh->so_phieu,
                        'loai' => $pxxdh->loai,
                        'don_hang_grs' => $pxxdh->don_hang_grs,
                        'don_hang_non_grs' => $pxxdh->don_hang_non_grs,
                        'don_hang_sx_moi' => $pxxdh->don_hang_sx_moi,
                        'don_hang_lap_lai' => $pxxdh->don_hang_lap_lai,
                        'don_hang_ton_kho' => $pxxdh->don_hang_ton_kho,
                        'date' => $pxxdh->date,
                        'ten_cong_ty' => $pxxdh->ten_cong_ty,
                        'so' => $pxxdh->so,
                        'hop_dong' => $pxxdh->hop_dong,
                        'thanh_pham_cua_khach_hang' => $pxxdh->thanh_pham_cua_khach_hang,
                        'phan_anh_cua_khach_hang' => $pxxdh->phan_anh_cua_khach_hang,
                        'mail_chinh' => $pxxdh->mail_chinh,
                        'mail_phu_1' => $pxxdh->mail_phu_1,
                        'mail_phu_2' => $pxxdh->mail_phu_2,
        
                        'status' => 'Sale APPROVED',
                        'status_log' => 'Approve',
                        'created_user' => $pxxdh->created_user,
                        'updated_user' => Auth::user()->username,
        
                    ];
        
                    $PhieuXXDHLog = PhieuXXDHLog::create($arr);

                    foreach ($this->lot as $key => $value) {

                        $insert =  QuyCachPhieuXXDH::where('id' , $key)->first();

                        $insert->kieu_may_det = $this->kieuMayDet[$key];
                        $insert->lot = $this->lot[$key];
                        $insert->so_cone = $this->soCone[$key] ?? null;
                        $insert->so_kg_cone = $this->soKgCone[$key] ?? null;
                        $insert->line = $this->Line[$key] ?? null;
                        $insert->may = $this->May[$key] ?? null;
                        $insert->ngay_giao_hang = $this->ngayGiaoHang[$key] ?? null;
                        $insert->ngay_bat_dau_giao = $this->ngayBatDauGiao[$key] ?? null;
                        $insert->lich_du_kien = $this->lichDuKien;
                        $insert->thong_tin_dong_goi = $this->thongTinDongGoi[$key] ?? null;
                        $insert->pallet = $this->pallet[$key] ?? null;
                        $insert->recycle = $this->recycle[$key] ?? null;
    
                        $insert->update();
    
                        QuyCachPhieuXXDHLog::create([
                            
                            'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                            'quy_cach' => $insert->quy_cach,
                            'so_luong' => $insert->so_luong,
                            'kieu_may_det' => $this->kieuMayDet[$key] ?? null,
                            'lot' => $this->lot[$key] ?? null,
                            'so_cone' => $this->soCone[$key] ?? null,
                            'so_kg_cone' => $this->soKgCone[$key] ?? null,
                            'line' => $this->Line[$key] ?? null,
                            'may' => $this->May[$key] ?? null,
                            'ngay_giao_hang' => $this->ngayGiaoHang[$key] ?? null,
                            'ngay_bat_dau_giao' => $this->ngayBatDauGiao[$key] ?? null,
                            'lich_du_kien' => $this->lichDuKien,
                            'thong_tin_dong_goi' => $this->thongTinDongGoi[$key] ?? null,
                            'pallet' => $this->pallet[$key] ?? null,
                            'recycle' => $this->recycle[$key] ?? null,
                            'status' => 'Sale'
        
                        ]);
                    }

    
                    Mail::to('qa@century.vn')->cc('luongphan@soitheky.vn')->send(new MailPhieuXXDH('Sale APPROVED',$this->soPhieu, Auth::user()->username, $PhieuXXDHLog->updated_at, ''));
                    
                    flash()->addFlash('success', 'Duyệt thành công phiếu : ' . $this->soPhieu,'Thông báo');
    
                    $this->emit('approvePhieuXXDHModal');
    
                    $this->resetInputField();
    
                }elseif($pxxdh->status == 'Sale APPROVED'){
                    
                    $pxxdh->status = 'QA APPROVED';
                    $pxxdh->phan_hoi_qa = $this->phanHoiQA;
                    $pxxdh->updated_user = Auth::user()->username;
                    $pxxdh->qa_approved = Auth::user()->username;
                    $pxxdh->qa_approved_at = Carbon::now();
            
                    $pxxdh->update();
    
                    $arr = [
        
                        'so_phieu' => $pxxdh->so_phieu,
                        'loai' => $pxxdh->loai,
                        'don_hang_grs' => $pxxdh->don_hang_grs,
                        'don_hang_non_grs' => $pxxdh->don_hang_non_grs,
                        'don_hang_sx_moi' => $pxxdh->don_hang_sx_moi,
                        'don_hang_lap_lai' => $pxxdh->don_hang_lap_lai,
                        'don_hang_ton_kho' => $pxxdh->don_hang_ton_kho,
                        'date' => $pxxdh->date,
                        'ten_cong_ty' => $pxxdh->ten_cong_ty,
                        'so' => $pxxdh->so,
                        'hop_dong' => $pxxdh->hop_dong,
                        'qa_kien_nghi' => $pxxdh->qa_kien_nghi,
                        'thanh_pham_cua_khach_hang' => $pxxdh->thanh_pham_cua_khach_hang,
                        'phan_anh_cua_khach_hang' => $pxxdh->phan_anh_cua_khach_hang,
                        'phan_hoi_khst' => $pxxdh->phanHoiKHST,
                        'phan_hoi_qa' => $this->phanHoiQA,
                        'phan_bo_cc' => $pxxdh->cbCC,
                        'phan_bo_tb2' => $pxxdh->cbTB2,
                        'phan_bo_tb3' => $pxxdh->cbTB3,
    
                        'mail_chinh' => $pxxdh->mail_chinh,
                        'mail_phu_1' => $pxxdh->mail_phu_1,
                        'mail_phu_2' => $pxxdh->mail_phu_2,
        
                        'status' => 'QA APPROVED',
                        'created_user' => $pxxdh->created_user,
                        
                        'status_log' => 'Approve',
                        'updated_user' => Auth::user()->username,
        
                    ];
    
                    $PhieuXXDHLog = PhieuXXDHLog::create($arr);
    
                    foreach ($this->quyCachPhieuXXDH as $item) {
                        
                        QuyCachPhieuXXDHLog::create([
                            
                            'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                            'quy_cach' => $item->quy_cach,
                            'so_luong' => $item->so_luong,
                            'kieu_may_det' => $item->kieu_may_det,
                            'lot' => $item->lot,
                            'so_cone' => $item->so_cone,
                            'so_kg_cone' => $item->so_kg_cone,
                            'line' => $item->line,
                            'may' => $item->may,
                            'ngay_giao_hang' => $item->ngay_giao_hang,
                            'ngay_bat_dau_giao' => $item->ngay_bat_dau_giao,
                            'thong_tin_dong_goi' => $item->thong_tin_dong_goi,
                            'pallet' => $item->pallet,
                            'recycle' => $item->recycle,
                            'status' => 'Sale'    
                        ]);
    
                    }
    
                    Mail::to('khth@century.vn')->cc('luongphan@soitheky.vn')->send(new MailPhieuXXDH('QA APPROVED',$this->soPhieu, Auth::user()->username, $PhieuXXDHLog->updated_at, ''));
    
                    flash()->addFlash('success', 'Duyệt thành công phiếu : ' . $this->soPhieu,'Thông báo');
    
                    $this->emit('approvePhieuXXDHModal');
    
                    $this->resetInputField();
    
                }elseif($pxxdh->status == 'QA APPROVED'){

                    $ccMail = [];
    
                        if($this->cbCC == 1){
    
                            $phanBoPTKSX =  PhanBoPTKSX::where('nha_may', 'CC')->first();
    
                            $ccMail = array_merge($ccMail,[$phanBoPTKSX->email]);
    
                            $mailCC = $phanBoPTKSX->email;
    
                        }else{
    
                            $mailCC = '';
    
                        }
    
                        if($this->cbTB2 == 1){
    
                            $phanBoPTKSX =  PhanBoPTKSX::where('nha_may', 'TB2')->first();
    
                            $ccMail = array_merge($ccMail,[$phanBoPTKSX->email]);
    
                            $mailTB2 = $phanBoPTKSX->email;
    
                        }else{
    
                            $mailTB2 = '';
    
                        }
    
                        if($this->cbTB3 == 1){
    
                            $phanBoPTKSX =  PhanBoPTKSX::where('nha_may', 'TB3')->first();
    
                            $ccMail = array_merge($ccMail,[$phanBoPTKSX->email]);
    
                            $mailTB3 = $phanBoPTKSX->email;
    
                        }else{
    
                            $mailTB3 = '';
    
                        }
    
                        $pxxdh->status = 'KHST APPROVED';
                        $pxxdh->phan_hoi_khst = $this->phanHoiKHST;
                        $pxxdh->line = $this->Line;
                        $pxxdh->phan_bo_cc = $mailCC;
                        $pxxdh->phan_bo_tb2 = $mailTB2;
                        $pxxdh->phan_bo_tb3 = $mailTB3;
                        $pxxdh->xac_nhan_phan_bo = null;
                        $pxxdh->updated_user = Auth::user()->username;
                        $pxxdh->khst_approved = Auth::user()->username;
                        $pxxdh->khst_approved_at = Carbon::now();
                
                        $pxxdh->update();
        
                        $arr = [
        
                            'so_phieu' => $pxxdh->so_phieu,
                            'loai' => $pxxdh->loai,
                            'don_hang_grs' => $pxxdh->don_hang_grs,
                            'don_hang_non_grs' => $pxxdh->don_hang_non_grs,
                            'don_hang_sx_moi' => $pxxdh->don_hang_sx_moi,
                            'don_hang_lap_lai' => $pxxdh->don_hang_lap_lai,
                            'don_hang_ton_kho' => $pxxdh->don_hang_ton_kho,
                            'date' => $pxxdh->date,
                            'ten_cong_ty' => $pxxdh->ten_cong_ty,
                            'so' => $pxxdh->so,
                            'hop_dong' => $pxxdh->hop_dong,
                            'qa_kien_nghi' => $pxxdh->qa_kien_nghi,
                            'thanh_pham_cua_khach_hang' => $pxxdh->thanh_pham_cua_khach_hang,
                            'phan_anh_cua_khach_hang' => $pxxdh->phan_anh_cua_khach_hang,
                            'phan_hoi_khst' => $this->phanHoiKHST,
                            'phan_bo_cc' => $mailCC,
                            'phan_bo_tb2' => $mailTB2,
                            'phan_bo_tb3' => $mailTB3,
        
                            'mail_chinh' => $pxxdh->mail_chinh,
                            'mail_phu_1' => $pxxdh->mail_phu_1,
                            'mail_phu_2' => $pxxdh->mail_phu_2,
            
                            'status' => 'KHST APPROVED',
                            'created_user' => $pxxdh->created_user,
                            
                            'status_log' => 'Approve',
                            'updated_user' => Auth::user()->username,
            
                        ];
            
                        $PhieuXXDHLog = PhieuXXDHLog::create($arr);
        
                        foreach ($this->quyCachPhieuXXDH as $item) {
                            
                            QuyCachPhieuXXDHLog::create([
                                
                                'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                                'quy_cach' => $item->quy_cach,
                                'so_luong' => $item->so_luong,
                                'kieu_may_det' => $item->kieu_may_det,
                                'lot' => $item->lot,
                                'so_cone' => $item->so_cone,
                                'so_kg_cone' => $item->so_kg_cone,
                                'line' => $item->line,
                                'may' => $item->may,
                                'ngay_giao_hang' => $item->ngay_giao_hang,
                                'ngay_bat_dau_giao' => $item->ngay_bat_dau_giao,
                                'thong_tin_dong_goi' => $item->thong_tin_dong_goi,
                                'pallet' => $item->pallet,
                                'recycle' => $item->recycle,
                                'status' => 'Sale'
            
                            ]);
        
                        }
        
                        // foreach (array_reverse($this->quyCachSuDungKHST, true) as $key => $value) {
        
                        //     QuyCachPhieuXXDH::create([
            
                        //         'phieu_xxdh_so_phieu_id' => $pxxdh->id,
                        //         'quy_cach' => $this->quyCachSuDungKHST[$key],
                        //         'so_luong' => $this->soLuongKHST[$key],
                        //         'lot' => $this->lotKHST[$key],
                        //         'status' => 'KHST'
        
                        //     ]);
            
                        //     QuyCachPhieuXXDHLog::create([
            
                        //         'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                        //         'quy_cach' => $this->quyCachSuDungKHST[$key],
                        //         'so_luong' => $this->soLuongKHST[$key],
                        //         'lot' => $this->lotKHST[$key],
                        //         'status' => 'KHST'
            
                        //     ]);
                        // }
    
                        Storage::disk('public')->makeDirectory('PhieuXXDH/' . $pxxdh->so_phieu);
        
                        $templateProcessor = new TemplateProcessor(public_path('PhieuXXDH/PXXDH.docx'));
        
                        $values = [
        
                            'date' => Carbon::create($pxxdh->date)->format('d-m-Y'),
                            'ten_cong_ty' => $pxxdh->ten_cong_ty,
                            'so' => $pxxdh->so,
                            'so_phieu' => $pxxdh->so_phieu,
                            'phan_hoi_khst' => $pxxdh->phan_hoi_khst,
                            'phan_hoi_qa' => $pxxdh->phan_hoi_qa,
        
                        ];
        
                        if($pxxdh->don_hang_grs == '1')
                            $templateProcessor->setImageValue('im_grs', 'images/icons-checkbox.png');
                        else
                            $templateProcessor->setImageValue('im_grs', 'images/icons-square.png');
        
                        if($pxxdh->don_hang_non_grs == '1')
                            $templateProcessor->setImageValue('im_non_grs', 'images/icons-checkbox.png');
                        else
                            $templateProcessor->setImageValue('im_non_grs', 'images/icons-square.png');
        
                        if($pxxdh->don_hang_sx_moi == '1')
                            $templateProcessor->setImageValue('im_moi', 'images/icons-checkbox.png');
                        else
                            $templateProcessor->setImageValue('im_moi', 'images/icons-square.png');
        
                        if($pxxdh->don_hang_lap_lai == '1')
                            $templateProcessor->setImageValue('im_lap_lai', 'images/icons-checkbox.png');
                        else
                            $templateProcessor->setImageValue('im_lap_lai', 'images/icons-square.png');
        
                        if($pxxdh->don_hang_ton_kho == '1')
                            $templateProcessor->setImageValue('im_ton_kho', 'images/icons-checkbox.png');
                        else
                            $templateProcessor->setImageValue('im_ton_kho', 'images/icons-square.png');
        
                        $templateProcessor->setValues($values);
                
                        $templateProcessor->saveAs(storage_path('app/public/PhieuXXDH/') . $pxxdh->so_phieu . '/' . $pxxdh->so_phieu .'.docx');
    
                        // Tạo file excel quy cách
    
                        $spreadsheet = new Spreadsheet();
    
                        $activeWorksheet = $spreadsheet->getActiveSheet();
    
                        $activeWorksheet->setTitle($this->soPhieu . ' - Quy cách');
    
                        $styleArray = [
                            'borders' => [
                                'outline' => [
                                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                                    'color' => ['argb' => '000000'],
                                ],
                            ],
                        ];
    
                        $activeWorksheet->getColumnDimensionByColumn(1)->setAutoSize(true);
                        $activeWorksheet->getColumnDimensionByColumn(2)->setAutoSize(true);
                        $activeWorksheet->getColumnDimensionByColumn(3)->setAutoSize(true);
                        $activeWorksheet->getColumnDimensionByColumn(4)->setAutoSize(true);
                        $activeWorksheet->getColumnDimensionByColumn(5)->setAutoSize(true);
                        $activeWorksheet->getColumnDimensionByColumn(6)->setAutoSize(true);
                        $activeWorksheet->getColumnDimensionByColumn(7)->setAutoSize(true);
                        $activeWorksheet->getColumnDimensionByColumn(8)->setAutoSize(true);
                        $activeWorksheet->getColumnDimensionByColumn(9)->setAutoSize(true);
                        $activeWorksheet->getColumnDimensionByColumn(10)->setAutoSize(true);
                        $activeWorksheet->getColumnDimensionByColumn(11)->setAutoSize(true);
                        $activeWorksheet->getColumnDimensionByColumn(12)->setAutoSize(true);
                        $activeWorksheet->getColumnDimensionByColumn(13)->setAutoSize(true);
    
                        $activeWorksheet->setCellValue('A1', 'Sale');
    
                        $activeWorksheet->mergeCells('A1:M1');
    
                        $activeWorksheet->setCellValue('A2', 'Quy cách');
                        $activeWorksheet->setCellValue('B2', 'Số lượng (kgs)');
                        $activeWorksheet->setCellValue('C2', 'Kiểu máy dệt + điều kiện đặc biệt của khách hàng');
                        $activeWorksheet->setCellValue('D2', 'Chạy theo TS LOT');
                        $activeWorksheet->setCellValue('E2', 'Số cone');
                        $activeWorksheet->setCellValue('F2', 'Số kg/cone');
                        $activeWorksheet->setCellValue('G2', 'Line');
                        $activeWorksheet->setCellValue('H2', 'Máy');
                        $activeWorksheet->setCellValue('I2', 'Ngày giao hàng');
                        $activeWorksheet->setCellValue('J2', 'Ngày bắt đầu giao (nếu có)');
                        $activeWorksheet->setCellValue('K2', 'Thông tin đóng gói');
                        $activeWorksheet->setCellValue('L2', 'Pallet');
                        $activeWorksheet->setCellValue('M2', 'Recycle');
    
                        $activeWorksheet->getStyle('A1:M2')->getFont()->setBold(true);
    
                        $currentRow = 3;
    
                        foreach ($this->quyCachPhieuXXDH as $item){
        
                            $activeWorksheet->setCellValue('A' . $currentRow, $item->quy_cach);
                            $activeWorksheet->setCellValue('B' . $currentRow, $item->so_luong);
                            $activeWorksheet->setCellValue('C' . $currentRow, $item->kieu_may_det);
                            $activeWorksheet->setCellValue('D' . $currentRow, $item->lot);
                            $activeWorksheet->setCellValue('E' . $currentRow, $item->so_cone);
                            $activeWorksheet->setCellValue('F' . $currentRow, $item->so_kg_cone);
                            $activeWorksheet->setCellValue('G' . $currentRow, $item->line);
                            $activeWorksheet->setCellValue('H' . $currentRow, $item->may);
                            $activeWorksheet->setCellValue('I' . $currentRow, $item->ngay_giao_hang);
                            $activeWorksheet->setCellValue('J' . $currentRow, $item->ngay_bat_dau_giao);
                            $activeWorksheet->setCellValue('K' . $currentRow, $item->thong_tin_dong_goi);
                            $activeWorksheet->setCellValue('L' . $currentRow, $item->pallet);
                            $activeWorksheet->setCellValue('M' . $currentRow, $item->recycle);
    
                            $currentRow = $currentRow + 1;
        
                        }
    
                        $activeWorksheet
                        ->getStyle('A1' . ':M' . $currentRow - 1)
                        ->getBorders()
                        ->getAllBorders()
                        ->setBorderStyle(Border::BORDER_THIN)
                        ->setColor(new Color('17202A'));
    
                        $activeWorksheet->getStyle('A1' . ':M' . $currentRow - 1)->applyFromArray($styleArray);
    
                        $activeWorksheet->setCellValue('A' . $currentRow + 1, 'KHST');
    
                        $currentRowKHST = $currentRow + 1;
    
                        $activeWorksheet->mergeCells('A' . $currentRow + 1 . ':M' . $currentRow + 1);
    
                        $activeWorksheet->getStyle('A' . $currentRow + 1 . ':M' . $currentRow + 2)->getFont()->setBold(true);
    
                        $activeWorksheet->setCellValue('A' . $currentRow + 2, 'Quy cách');
                        $activeWorksheet->setCellValue('B' . $currentRow + 2, 'Số lượng (kgs)');
                        $activeWorksheet->setCellValue('C' . $currentRow + 2, 'Kiểu máy dệt + điều kiện đặc biệt của khách hàng');
    
                        $currentRow = $currentRow + 3;
        
                        // foreach ($this->quyCachPhieuXXDHKHST as $item2){
        
                        //     $activeWorksheet->setCellValue('A' . $currentRow, $item2->quy_cach);
                        //     $activeWorksheet->setCellValue('B' . $currentRow, $item2->so_luong);
                        //     $activeWorksheet->setCellValue('C' . $currentRow, $item2->kieu_may_det);
    
                        //     $currentRow = $currentRow + 1;
        
                        // }
    
                        $activeWorksheet
                        ->getStyle('A' . $currentRowKHST . ':M' . $currentRow - 1)
                        ->getBorders()
                        ->getAllBorders()
                        ->setBorderStyle(Border::BORDER_THIN)
                        ->setColor(new Color('17202A'));
    
                        $activeWorksheet->getStyle('A' . $currentRowKHST . ':M' . $currentRow - 1)->applyFromArray($styleArray);
    
                        $activeWorksheet->setCellValue('A' . $currentRow + 1, 'Thành phẩm của khách hàng');
                        $activeWorksheet->setCellValue('B' . $currentRow + 1, 'Phản ánh của khách hàng về lot cũ');
    
                        $activeWorksheet->setCellValue('A' . $currentRow + 2, $pxxdh->thanh_pham_cua_khach_hang);
                        $activeWorksheet->setCellValue('B' . $currentRow + 2, $pxxdh->phan_anh_cua_khach_hang);
    
                        $activeWorksheet->getStyle('A' . $currentRow + 1 . ':B' . $currentRow + 1)->getFont()->setBold(true);
    
                        $activeWorksheet
                        ->getStyle('A' . $currentRow + 1 . ':B' . $currentRow + 2)
                        ->getBorders()
                        ->getAllBorders()
                        ->setBorderStyle(Border::BORDER_THIN)
                        ->setColor(new Color('17202A'));
    
                        $writer = new Xlsx($spreadsheet);
    
                        ob_start();
                        $writer->save('php://output');
                        $content = ob_get_contents();
                        ob_end_clean();
    
                        Storage::disk('public')->put('PhieuXXDH/' . $this->soPhieu . '/' . $this->soPhieu . ".xlsx", $content);

                        $user = User::where('username', $pxxdh->created_user)->first();
        
                        Mail::to($user->email)->cc('luongphan@soitheky.vn')->cc($ccMail)->send(new MailPhieuXXDH('KHST APPROVED',$this->soPhieu, Auth::user()->username, $PhieuXXDHLog->updated_at, ''));
        
                        flash()->addFlash('success', 'Duyệt thành công phiếu : ' . $this->soPhieu,'Thông báo');
        
                        $this->emit('approvePhieuXXDHModal');
        
                        $this->resetInputField();

                }elseif($pxxdh->status == 'KHST APPROVED'){

                        $pxxdh->status = 'Finish';
                        $pxxdh->updated_user = Auth::user()->username;
                        $pxxdh->finish = Auth::user()->username;
                        $pxxdh->finish_at = Carbon::now();
                
                        $pxxdh->update();
        
                        $arr = [
        
                            'so_phieu' => $pxxdh->so_phieu,
                            'loai' => $pxxdh->loai,
                            'don_hang_grs' => $pxxdh->don_hang_grs,
                            'don_hang_non_grs' => $pxxdh->don_hang_non_grs,
                            'don_hang_sx_moi' => $pxxdh->don_hang_sx_moi,
                            'don_hang_lap_lai' => $pxxdh->don_hang_lap_lai,
                            'don_hang_ton_kho' => $pxxdh->don_hang_ton_kho,
                            'date' => $pxxdh->date,
                            'ten_cong_ty' => $pxxdh->ten_cong_ty,
                            'so' => $pxxdh->so,
                            'hop_dong' => $pxxdh->hop_dong,
                            'qa_kien_nghi' => $pxxdh->qa_kien_nghi,
                            'thanh_pham_cua_khach_hang' => $pxxdh->thanh_pham_cua_khach_hang,
                            'phan_anh_cua_khach_hang' => $pxxdh->phan_anh_cua_khach_hang,
                            'phan_hoi_khst' => $pxxdh->phanHoiKHST,
                            'phan_hoi_qa' => $pxxdh->phanHoiQA,
                            'phan_bo_cc' => $pxxdh->cbCC,
                            'phan_bo_tb2' => $pxxdh->cbTB2,
                            'phan_bo_tb3' => $pxxdh->cbTB3,
        
                            'mail_chinh' => $pxxdh->mail_chinh,
                            'mail_phu_1' => $pxxdh->mail_phu_1,
                            'mail_phu_2' => $pxxdh->mail_phu_2,
            
                            'status' => 'Finish',
                            'created_user' => $pxxdh->created_user,
                            
                            'status_log' => 'Finish',
                            'updated_user' => Auth::user()->username,
            
                        ];
        
                        $PhieuXXDHLog = PhieuXXDHLog::create($arr);
        
                        foreach ($this->quyCachPhieuXXDH as $item) {
                            
                            QuyCachPhieuXXDHLog::create([
                                
                                'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                                'quy_cach' => $item->quy_cach,
                                'so_luong' => $item->so_luong,
                                'kieu_may_det' => $item->kieu_may_det,
                                'lot' => $item->lot,
                                'so_cone' => $item->so_cone,
                                'so_kg_cone' => $item->so_kg_cone,
                                'line' => $item->line,
                                'may' => $item->may,
                                'ngay_giao_hang' => $item->ngay_giao_hang,
                                'ngay_bat_dau_giao' => $item->ngay_bat_dau_giao,
                                'thong_tin_dong_goi' => $item->thong_tin_dong_goi,
                                'pallet' => $item->pallet,
                                'recycle' => $item->recycle,
                                'status' => 'Sale'    
                            ]);
        
                        }
        
                        foreach ($this->quyCachPhieuXXDHKHST as $item) {
            
                            QuyCachPhieuXXDHLog::create([
            
                                'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                                'quy_cach' => $item->quy_cach,
                                'so_luong' => $item->so_luong,
                                'lot' => $item->lot,
                                'status' => 'KHST'
            
                            ]);
                        }
        
                        SO::where('so', $pxxdh->so)->update([
        
                            'status_phieu_xxdh' => '1'
                            
                        ]);

                        $cc = [];

                        if($pxxdh->mailPhu1 != null){

                            $cc = array_merge($cc, [

                                $pxxdh->mailPhu1,

                            ]);

                        }

                        if($pxxdh->mailPhu1 != null){

                            $cc = array_merge($cc, [

                                $pxxdh->mailPhu2

                            ]);

                        }
        
                        Mail::to($pxxdh->mail_chinh)
                        ->cc($cc)
                        ->send(new MailPhieuXXDH('Finish',$this->soPhieu, Auth::user()->username, $PhieuXXDHLog->updated_at, ''));
                        flash()->addFlash('success', 'Duyệt thành công phiếu : ' . $this->soPhieu,'Thông báo');
            
                        $this->resetInputField();
            
                        $this->emit('approvePhieuXXDHModal');

                }
            }

            $this->state = 'main';
            
        });
    }

    public function approvePhieuXXDH(){

        DB::transaction( function(){

            $pxxdh = ModelsPhieuXXDH::where('so_phieu', $this->soPhieu)->first();

            if($pxxdh->loai == 'dht'){
                if($pxxdh->status == 'New'){

                    if(!Auth::user()->hasPermissionTo('sale_approve_pxxdhs')){

                        sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                        $this->emit('approvePhieuXXDHModal');
                        $this->resetInputField();
                        return;

                    }

                }elseif($pxxdh->status == 'Sale APPROVED'){

                    if(!Auth::user()->hasPermissionTo('sm_approve_pxxdhs')){

                        sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                        $this->emit('approvePhieuXXDHModal');
                        $this->resetInputField();
                        return;

                    }

                }elseif($pxxdh->status == 'SM APPROVED'){

                    if(!Auth::user()->hasPermissionTo('quan_ly_khst_approve_pxxdhs')){

                        sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                        $this->emit('approvePhieuXXDHModal');
                        $this->resetInputField();
                        return;

                    }

                }elseif($pxxdh->status == 'KHST APPROVED'){

                    if(!Auth::user()->hasPermissionTo('qa_approve_pxxdhs')){

                        sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                        $this->emit('approvePhieuXXDHModal');
                        $this->resetInputField();
                        return;

                    }

                }elseif($pxxdh->status == 'QA APPROVED'){

                    if(!Auth::user()->hasPermissionTo('create_pxxdhs')){

                        sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                        $this->emit('approvePhieuXXDHModal');
                        $this->resetInputField();
                        return;

                    }

                }
            }else{
                if($pxxdh->status == 'New'){

                    if(!Auth::user()->hasPermissionTo('sale_approve_pxxdhs')){

                        sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                        $this->emit('approvePhieuXXDHModal');
                        $this->resetInputField();
                        return;

                    }

                }elseif($pxxdh->status == 'Sale APPROVED'){

                    if(!Auth::user()->hasPermissionTo('sm_approve_pxxdhs')){

                        sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                        $this->emit('approvePhieuXXDHModal');
                        $this->resetInputField();
                        return;

                    }

                }elseif($pxxdh->status == 'SM APPROVED'){

                    if(!Auth::user()->hasPermissionTo('qa_approve_pxxdhs')){

                        sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                        $this->emit('approvePhieuXXDHModal');
                        $this->resetInputField();
                        return;

                    }

                }elseif($pxxdh->status == 'QA REQUESTED'){

                    if(!Auth::user()->hasPermissionTo('quan_ly_khst_approve_pxxdhs')){

                        sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                        $this->emit('approvePhieuXXDHModal');
                        $this->resetInputField();
                        return;

                    }

                }elseif($pxxdh->status == 'KHST APPROVED'){

                    if(!Auth::user()->hasPermissionTo('qa_approve_pxxdhs')){

                        sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                        $this->emit('approvePhieuXXDHModal');
                        $this->resetInputField();
                        return;

                    }

                }elseif($pxxdh->status == 'QA APPROVED'){

                    if(!Auth::user()->hasPermissionTo('create_pxxdhs')){

                        sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                        $this->emit('approvePhieuXXDHModal');
                        $this->resetInputField();
                        return;

                    }

                }
            }

            if($pxxdh->loai == 'dht'){
                if($pxxdh->status == 'New'){

                    $pxxdh->status = 'Sale APPROVED';
                    $pxxdh->thanh_pham_cua_khach_hang = $this->thanhPhamCuaKhachHang;
                    $pxxdh->phan_anh_cua_khach_hang = $this->phanAnhCuaKhachHang;

                    $pxxdh->sale_approved = Auth::user()->username;
                    $pxxdh->sale_approved_at = Carbon::now();
                    
                    $pxxdh->updated_user = Auth::user()->username;
            
                    $pxxdh->update();
    
                    $arr = [
    
                        'so_phieu' => $pxxdh->so_phieu,
                        'loai' => $pxxdh->loai,
                        'don_hang_grs' => $pxxdh->don_hang_grs,
                        'don_hang_non_grs' => $pxxdh->don_hang_non_grs,
                        'don_hang_sx_moi' => $pxxdh->don_hang_sx_moi,
                        'don_hang_lap_lai' => $pxxdh->don_hang_lap_lai,
                        'don_hang_ton_kho' => $pxxdh->don_hang_ton_kho,
                        'date' => $pxxdh->date,
                        'ten_cong_ty' => $pxxdh->ten_cong_ty,
                        'so' => $pxxdh->so,
                        'hop_dong' => $pxxdh->hop_dong,
                        // 'so_cone' => $pxxdh->so_cone,
                        // 'so_kg_cone' => $pxxdh->so_kg_cone,
                        // 'line' => $pxxdh->line,
                        // 'may' => $pxxdh->may,
                        // 'ngay_giao_hang' => $pxxdh->ngay_giao_hang,
                        // 'ngay_bat_dau_giao' => $pxxdh->ngay_bat_dau_giao,
                        'thanh_pham_cua_khach_hang' => $pxxdh->thanh_pham_cua_khach_hang,
                        'phan_anh_cua_khach_hang' => $pxxdh->phan_anh_cua_khach_hang,
                        // 'thong_tin_dong_goi' => $pxxdh->thong_tin_dong_goi,
                        'mail_chinh' => $pxxdh->mail_chinh,
                        'mail_phu_1' => $pxxdh->mail_phu_1,
                        'mail_phu_2' => $pxxdh->mail_phu_2,
        
                        'status' => 'Sale APPROVED',
                        'status_log' => 'Approve',
                        'created_user' => $pxxdh->created_user,
                        'updated_user' => Auth::user()->username,
        
                    ];
        
                    $PhieuXXDHLog = PhieuXXDHLog::create($arr);

                    foreach ($this->lot as $key => $value) {

                        $insert =  QuyCachPhieuXXDH::where('id' , $key)->first();

                        $insert->kieu_may_det = $this->kieuMayDet[$key];
                        $insert->lot = $this->lot[$key];
                        $insert->so_cone = $this->soCone[$key] ?? null;
                        $insert->so_kg_cone = $this->soKgCone[$key] ?? null;
                        $insert->line = $this->Line[$key] ?? null;
                        $insert->may = $this->May[$key] ?? null;
                        $insert->ngay_giao_hang = $this->ngayGiaoHang[$key] ?? null;
                        $insert->ngay_bat_dau_giao = $this->ngayBatDauGiao[$key] ?? null;
                        //$insert->thanh_pham_cua_khach_hang = $this->thanhPhamCuaKhachHang[$key] ?? null;
                        //$insert->phan_anh_cua_khach_hang = $this->phanAnhCuaKhachHang[$key] ?? null;
                        $insert->lich_du_kien = $this->lichDuKien;
                        $insert->thong_tin_dong_goi = $this->thongTinDongGoi[$key] ?? null;
                        $insert->pallet = $this->pallet[$key] ?? null;
                        $insert->recycle = $this->recycle[$key] ?? null;
    
                        $insert->update();
    
                        QuyCachPhieuXXDHLog::create([
                            
                            'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                            'quy_cach' => $insert->quy_cach,
                            'so_luong' => $insert->so_luong,
                            'kieu_may_det' => $this->kieuMayDet[$key] ?? null,
                            'lot' => $this->lot[$key] ?? null,
                            'so_cone' => $this->soCone[$key] ?? null,
                            'so_kg_cone' => $this->soKgCone[$key] ?? null,
                            'line' => $this->Line[$key] ?? null,
                            'may' => $this->May[$key] ?? null,
                            'ngay_giao_hang' => $this->ngayGiaoHang[$key] ?? null,
                            'ngay_bat_dau_giao' => $this->ngayBatDauGiao[$key] ?? null,
                            //'thanh_pham_cua_khach_hang' => $this->thanhPhamCuaKhachHang[$key] ?? null,
                            //'phan_anh_cua_khach_hang' => $this->phanAnhCuaKhachHang[$key] ?? null,
                            'lich_du_kien' => $this->lichDuKien,
                            'thong_tin_dong_goi' => $this->thongTinDongGoi[$key] ?? null,
                            'pallet' => $this->pallet[$key] ?? null,
                            'recycle' => $this->recycle[$key] ?? null,
                            'status' => 'Sale'
        
                        ]);
                    }

                    $emailQuanLySale = EmailQuanLy::where('chuc_vu', 'quan_ly_sale')->first();
    
                    Mail::to($emailQuanLySale->email)->cc('luongphan@soitheky.vn')->send(new MailPhieuXXDH('Sale APPROVED',$this->soPhieu, Auth::user()->username, $PhieuXXDHLog->updated_at, ''));
                    
                    flash()->addFlash('success', 'Duyệt thành công phiếu : ' . $this->soPhieu,'Thông báo');
    
                    $this->emit('approvePhieuXXDHModal');
    
                    $this->resetInputField();
    
                }elseif($pxxdh->status == 'Sale APPROVED'){
                    
                    $pxxdh->sm_approved = Auth::user()->username;
                    $pxxdh->sm_approved_at = Carbon::now();

                    $pxxdh->status = 'SM APPROVED';
                    $pxxdh->updated_user = Auth::user()->username;
            
                    $pxxdh->update();
    
                    $arr = [
    
                        'so_phieu' => $pxxdh->so_phieu,
                        'loai' => $pxxdh->loai,
                        'don_hang_grs' => $pxxdh->don_hang_grs,
                        'don_hang_non_grs' => $pxxdh->don_hang_non_grs,
                        'don_hang_sx_moi' => $pxxdh->don_hang_sx_moi,
                        'don_hang_lap_lai' => $pxxdh->don_hang_lap_lai,
                        'don_hang_ton_kho' => $pxxdh->don_hang_ton_kho,
                        'date' => $pxxdh->date,
                        'ten_cong_ty' => $pxxdh->ten_cong_ty,
                        'so' => $pxxdh->so,
                        'hop_dong' => $pxxdh->hop_dong,
                        // 'so_cone' => $pxxdh->so_cone,
                        // 'so_kg_cone' => $pxxdh->so_kg_cone,
                        // 'line' => $pxxdh->line,
                        // 'may' => $pxxdh->may,
                        // 'ngay_giao_hang' => $pxxdh->ngay_giao_hang,
                        // 'ngay_bat_dau_giao' => $pxxdh->ngay_bat_dau_giao,
                        'thanh_pham_cua_khach_hang' => $pxxdh->thanh_pham_cua_khach_hang,
                        'phan_anh_cua_khach_hang' => $pxxdh->phan_anh_cua_khach_hang,
                        // 'thong_tin_dong_goi' => $pxxdh->thong_tin_dong_goi,
    
                        'mail_chinh' => $pxxdh->mail_chinh,
                        'mail_phu_1' => $pxxdh->mail_phu_1,
                        'mail_phu_2' => $pxxdh->mail_phu_2,
        
                        'status' => 'SM APPROVED',
                        'created_user' => $pxxdh->created_user,
                        
                        'status_log' => 'Approve',
                        'updated_user' => Auth::user()->username,
        
                    ];
        
                    $PhieuXXDHLog = PhieuXXDHLog::create($arr);
    
                    foreach ($this->quyCachPhieuXXDH as $item) {
                        
                        QuyCachPhieuXXDHLog::create([
                            
                            'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                            'quy_cach' => $item->quy_cach,
                            'so_luong' => $item->so_luong,
                            'kieu_may_det' => $item->kieu_may_det,
                            'lot' => $item->lot,
                            'so_cone' => $item->so_cone,
                            'so_kg_cone' => $item->so_kg_cone,
                            'line' => $item->line,
                            'may' => $item->may,
                            'ngay_giao_hang' => $item->ngay_giao_hang,
                            'ngay_bat_dau_giao' => $item->ngay_bat_dau_giao,
                            //'thanh_pham_cua_khach_hang' => $item->thanh_pham_cua_khach_hang,
                            //'phan_anh_cua_khach_hang' => $item->phan_anh_cua_khach_hang,
                            'thong_tin_dong_goi' => $item->thong_tin_dong_goi,
                            'pallet' => $item->pallet,
                            'recycle' => $item->recycle,
                            'status' => 'Sale'
        
                        ]);
    
                    }
    
                    Mail::to('khth@century.vn')->cc('luongphan@soitheky.vn')->send(new MailPhieuXXDH('SM APPROVED',$this->soPhieu, Auth::user()->username, $PhieuXXDHLog->updated_at,''));
    
                    flash()->addFlash('success', 'Duyệt thành công phiếu : ' . $this->soPhieu,'Thông báo');
    
                    $this->emit('approvePhieuXXDHModal');
    
                    $this->resetInputField();
    
                }elseif($pxxdh->status == 'SM APPROVED'){
                    
                    $ccMail = [];

                    if($this->cbCC == 1){

                        $phanBoPTKSX =  PhanBoPTKSX::where('nha_may', 'CC')->first();

                        $ccMail = array_merge($ccMail,[$phanBoPTKSX->email]);

                        $mailCC = $phanBoPTKSX->email;

                    }else{

                        $mailCC = '';

                    }

                    if($this->cbTB2 == 1){

                        $phanBoPTKSX =  PhanBoPTKSX::where('nha_may', 'TB2')->first();

                        $ccMail = array_merge($ccMail,[$phanBoPTKSX->email]);

                        $mailTB2 = $phanBoPTKSX->email;

                    }else{

                        $mailTB2 = '';

                    }

                    if($this->cbTB3 == 1){

                        $phanBoPTKSX =  PhanBoPTKSX::where('nha_may', 'TB3')->first();

                        $ccMail = array_merge($ccMail,[$phanBoPTKSX->email]);

                        $mailTB3 = $phanBoPTKSX->email;

                    }else{

                        $mailTB3 = '';

                    }

                    $pxxdh->status = 'KHST APPROVED';
                    $pxxdh->phan_hoi_khst = $this->phanHoiKHST;
                    $pxxdh->line = $this->Line;
                    $pxxdh->phan_bo_cc = $mailCC;
                    $pxxdh->phan_bo_tb2 = $mailTB2;
                    $pxxdh->phan_bo_tb3 = $mailTB3;
                    $pxxdh->xac_nhan_phan_bo = null;
                    $pxxdh->updated_user = Auth::user()->username;
                    $pxxdh->khst_approved = Auth::user()->username;
                    $pxxdh->khst_approved_at = Carbon::now();
            
                    $pxxdh->update();
    
                    $arr = [
    
                        'so_phieu' => $pxxdh->so_phieu,
                        'loai' => $pxxdh->loai,
                        'don_hang_grs' => $pxxdh->don_hang_grs,
                        'don_hang_non_grs' => $pxxdh->don_hang_non_grs,
                        'don_hang_sx_moi' => $pxxdh->don_hang_sx_moi,
                        'don_hang_lap_lai' => $pxxdh->don_hang_lap_lai,
                        'don_hang_ton_kho' => $pxxdh->don_hang_ton_kho,
                        'date' => $pxxdh->date,
                        'ten_cong_ty' => $pxxdh->ten_cong_ty,
                        'so' => $pxxdh->so,
                        'hop_dong' => $pxxdh->hop_dong,
                        // 'so_cone' => $pxxdh->so_cone,
                        // 'so_kg_cone' => $pxxdh->so_kg_cone,
                        // 'line' => $pxxdh->line,
                        // 'may' => $pxxdh->may,
                        // 'ngay_giao_hang' => $pxxdh->ngay_giao_hang,
                        // 'ngay_bat_dau_giao' => $pxxdh->ngay_bat_dau_giao,
                        'thanh_pham_cua_khach_hang' => $pxxdh->thanh_pham_cua_khach_hang,
                        'phan_anh_cua_khach_hang' => $pxxdh->phan_anh_cua_khach_hang,
                        // 'thong_tin_dong_goi' => $pxxdh->thong_tin_dong_goi,
                        'phan_hoi_khst' => $this->phanHoiKHST,
                        'phan_bo_cc' => $mailCC,
                        'phan_bo_tb2' => $mailTB2,
                        'phan_bo_tb3' => $mailTB3,
    
                        'mail_chinh' => $pxxdh->mail_chinh,
                        'mail_phu_1' => $pxxdh->mail_phu_1,
                        'mail_phu_2' => $pxxdh->mail_phu_2,
        
                        'status' => 'KHST APPROVED',
                        'created_user' => $pxxdh->created_user,
                        
                        'status_log' => 'Approve',
                        'updated_user' => Auth::user()->username,
        
                    ];
        
                    $PhieuXXDHLog = PhieuXXDHLog::create($arr);
    
                    foreach ($this->quyCachPhieuXXDH as $item) {
                        
                        QuyCachPhieuXXDHLog::create([
                            
                            'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                            'quy_cach' => $item->quy_cach,
                            'so_luong' => $item->so_luong,
                            'kieu_may_det' => $item->kieu_may_det,
                            'lot' => $item->lot,
                            'so_cone' => $item->so_cone,
                            'so_kg_cone' => $item->so_kg_cone,
                            'line' => $item->line,
                            'may' => $item->may,
                            'ngay_giao_hang' => $item->ngay_giao_hang,
                            'ngay_bat_dau_giao' => $item->ngay_bat_dau_giao,
                            //'thanh_pham_cua_khach_hang' => $item->thanh_pham_cua_khach_hang,
                            //'phan_anh_cua_khach_hang' => $item->phan_anh_cua_khach_hang,
                            'thong_tin_dong_goi' => $item->thong_tin_dong_goi,
                            'pallet' => $item->pallet,
                            'recycle' => $item->recycle,
                            'status' => 'Sale'
        
                        ]);
    
                    }
                    
                    if($this->quyCachSuDungKHST != null){

                        foreach (array_reverse($this->quyCachSuDungKHST, true) as $key => $value) {
    
                            QuyCachPhieuXXDH::create([
            
                                'phieu_xxdh_so_phieu_id' => $pxxdh->id,
                                'quy_cach' => $this->quyCachSuDungKHST[$key],
                                'so_luong' => $this->soLuongKHST[$key],
                                'lot' => $this->lotKHST[$key],
                                'status' => 'KHST'
        
                            ]);
            
                            QuyCachPhieuXXDHLog::create([
            
                                'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                                'quy_cach' => $this->quyCachSuDungKHST[$key],
                                'so_luong' => $this->soLuongKHST[$key],
                                'lot' => $this->lotKHST[$key],
                                'status' => 'KHST'
            
                            ]);
                        }

                    }

                    Storage::disk('public')->makeDirectory('PhieuXXDH/' . $pxxdh->so_phieu);
    
                    $templateProcessor = new TemplateProcessor(public_path('PhieuXXDH/PXXDH.docx'));
    
                    $values = [
    
                        'date' => Carbon::create($pxxdh->date)->format('d-m-Y'),
                        'ten_cong_ty' => $pxxdh->ten_cong_ty,
                        'so' => $pxxdh->so,
                        'so_phieu' => $pxxdh->so_phieu,
                        // 'so_cone' => $pxxdh->so_cone,
                        // 'so_kg_cone' => $pxxdh->so_kg_cone,
                        // 'line' => $pxxdh->line,
                        // 'may' => $pxxdh->may,
                        // 'ngay_giao_hang' => Carbon::create($pxxdh->ngay_giao_hang)->format('d-m-Y'),
                        // 'ngay_bat_dau_giao' => Carbon::create($pxxdh->ngay_bat_dau_giao)->format('d-m-Y'),
                        // 'thanh_pham_cua_khach_hang' => $pxxdh->thanh_pham_cua_khach_hang,
                        // 'phan_anh_cua_khach_hang' => $pxxdh->phan_anh_cua_khach_hang,
                        'phan_hoi_khst' => $pxxdh->phan_hoi_khst,
                        // 'phan_hoi_qa' => $this->phanHoiQA
    
                    ];
                    // $values_table = [];
                    // $values_table_thuc_te = [];
    
                    // foreach ($this->quyCachPhieuXXDH as $item){
    
                    //     $values_table = array_merge($values_table,[
    
                    //         [
                    //             'quy_cach' => $item->quy_cach, 
                    //             'so_luong' => $item->so_luong, 
                    //             'kieu_may_det' => $item->kieu_may_det, 
                    //             'lot' => $item->lot,
                    //         ]
    
                    //     ]);
    
                    // }
    
                    // foreach ($this->quyCachPhieuXXDHKHST as $item){
    
                    //     $values_table_thuc_te = array_merge($values_table_thuc_te,[
    
                    //         [
                    //             'quy_cach_thuc_te' => $item->quy_cach, 
                    //             'so_luong_thuc_te' => $item->so_luong, 
                    //             'lot_thuc_te' => $item->lot,
                    //         ]
    
                    //     ]);
    
                    // }
    
                    // $templateProcessor->cloneRowAndSetValues('quy_cach', $values_table);
                    // $templateProcessor->cloneRowAndSetValues('quy_cach_thuc_te', $values_table_thuc_te);
    
                    if($pxxdh->don_hang_grs == '1')
                        $templateProcessor->setImageValue('im_grs', 'images/icons-checkbox.png');
                    else
                        $templateProcessor->setImageValue('im_grs', 'images/icons-square.png');
    
                    if($pxxdh->don_hang_non_grs == '1')
                        $templateProcessor->setImageValue('im_non_grs', 'images/icons-checkbox.png');
                    else
                        $templateProcessor->setImageValue('im_non_grs', 'images/icons-square.png');
    
                    if($pxxdh->don_hang_sx_moi == '1')
                        $templateProcessor->setImageValue('im_moi', 'images/icons-checkbox.png');
                    else
                        $templateProcessor->setImageValue('im_moi', 'images/icons-square.png');
    
                    if($pxxdh->don_hang_lap_lai == '1')
                        $templateProcessor->setImageValue('im_lap_lai', 'images/icons-checkbox.png');
                    else
                        $templateProcessor->setImageValue('im_lap_lai', 'images/icons-square.png');
    
                    if($pxxdh->don_hang_ton_kho == '1')
                        $templateProcessor->setImageValue('im_ton_kho', 'images/icons-checkbox.png');
                    else
                        $templateProcessor->setImageValue('im_ton_kho', 'images/icons-square.png');
    
                    $templateProcessor->setValues($values);
            
                    $templateProcessor->saveAs(storage_path('app/public/PhieuXXDH/') . $pxxdh->so_phieu . '/' . $pxxdh->so_phieu .'.docx');

                    // Tạo file excel quy cách

                    $spreadsheet = new Spreadsheet();

                    $activeWorksheet = $spreadsheet->getActiveSheet();

                    $activeWorksheet->setTitle($this->soPhieu . ' - Quy cách');

                    $styleArray = [
                        'borders' => [
                            'outline' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                                'color' => ['argb' => '000000'],
                            ],
                        ],
                    ];

                    $activeWorksheet->getColumnDimensionByColumn(1)->setAutoSize(true);
                    $activeWorksheet->getColumnDimensionByColumn(2)->setAutoSize(true);
                    $activeWorksheet->getColumnDimensionByColumn(3)->setAutoSize(true);
                    $activeWorksheet->getColumnDimensionByColumn(4)->setAutoSize(true);
                    $activeWorksheet->getColumnDimensionByColumn(5)->setAutoSize(true);
                    $activeWorksheet->getColumnDimensionByColumn(6)->setAutoSize(true);
                    $activeWorksheet->getColumnDimensionByColumn(7)->setAutoSize(true);
                    $activeWorksheet->getColumnDimensionByColumn(8)->setAutoSize(true);
                    $activeWorksheet->getColumnDimensionByColumn(9)->setAutoSize(true);
                    $activeWorksheet->getColumnDimensionByColumn(10)->setAutoSize(true);
                    $activeWorksheet->getColumnDimensionByColumn(11)->setAutoSize(true);
                    $activeWorksheet->getColumnDimensionByColumn(12)->setAutoSize(true);
                    $activeWorksheet->getColumnDimensionByColumn(13)->setAutoSize(true);

                    $activeWorksheet->setCellValue('A1', 'Sale');

                    $activeWorksheet->mergeCells('A1:M1');

                    $activeWorksheet->setCellValue('A2', 'Quy cách');
                    $activeWorksheet->setCellValue('B2', 'Số lượng (kgs)');
                    $activeWorksheet->setCellValue('C2', 'Kiểu máy dệt + điều kiện đặc biệt của khách hàng');
                    $activeWorksheet->setCellValue('D2', 'Chạy theo TS LOT');
                    $activeWorksheet->setCellValue('E2', 'Số cone');
                    $activeWorksheet->setCellValue('F2', 'Số kg/cone');
                    $activeWorksheet->setCellValue('G2', 'Line');
                    $activeWorksheet->setCellValue('H2', 'Máy');
                    $activeWorksheet->setCellValue('I2', 'Ngày giao hàng');
                    $activeWorksheet->setCellValue('J2', 'Ngày bắt đầu giao (nếu có)');
                    $activeWorksheet->setCellValue('K2', 'Thông tin đóng gói');
                    $activeWorksheet->setCellValue('L2', 'Pallet');
                    $activeWorksheet->setCellValue('M2', 'Recycle');

                    $activeWorksheet->getStyle('A1:M2')->getFont()->setBold(true);

                    $currentRow = 3;

                    foreach ($this->quyCachPhieuXXDH as $item){
    
                        $activeWorksheet->setCellValue('A' . $currentRow, $item->quy_cach);
                        $activeWorksheet->setCellValue('B' . $currentRow, $item->so_luong);
                        $activeWorksheet->setCellValue('C' . $currentRow, $item->kieu_may_det);
                        $activeWorksheet->setCellValue('D' . $currentRow, $item->lot);
                        $activeWorksheet->setCellValue('E' . $currentRow, $item->so_cone);
                        $activeWorksheet->setCellValue('F' . $currentRow, $item->so_kg_cone);
                        $activeWorksheet->setCellValue('G' . $currentRow, $item->line);
                        $activeWorksheet->setCellValue('H' . $currentRow, $item->may);
                        $activeWorksheet->setCellValue('I' . $currentRow, $item->ngay_giao_hang);
                        $activeWorksheet->setCellValue('J' . $currentRow, $item->ngay_bat_dau_giao);
                        $activeWorksheet->setCellValue('K' . $currentRow, $item->thong_tin_dong_goi);
                        $activeWorksheet->setCellValue('L' . $currentRow, $item->pallet);
                        $activeWorksheet->setCellValue('M' . $currentRow, $item->recycle);

                        $currentRow = $currentRow + 1;
    
                    }

                    $activeWorksheet
                    ->getStyle('A1' . ':M' . $currentRow - 1)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN)
                    ->setColor(new Color('17202A'));

                    $activeWorksheet->getStyle('A1' . ':M' . $currentRow - 1)->applyFromArray($styleArray);

                    $activeWorksheet->setCellValue('A' . $currentRow + 1, 'KHST');

                    $currentRowKHST = $currentRow + 1;

                    $activeWorksheet->mergeCells('A' . $currentRow + 1 . ':M' . $currentRow + 1);

                    $activeWorksheet->getStyle('A' . $currentRow + 1 . ':M' . $currentRow + 2)->getFont()->setBold(true);

                    $activeWorksheet->setCellValue('A' . $currentRow + 2, 'Quy cách');
                    $activeWorksheet->setCellValue('B' . $currentRow + 2, 'Số lượng (kgs)');
                    $activeWorksheet->setCellValue('C' . $currentRow + 2, 'Kiểu máy dệt + điều kiện đặc biệt của khách hàng');

                    $currentRow = $currentRow + 3;
    
                    foreach ($this->quyCachPhieuXXDHKHST as $item2){
    
                        $activeWorksheet->setCellValue('A' . $currentRow, $item2->quy_cach);
                        $activeWorksheet->setCellValue('B' . $currentRow, $item2->so_luong);
                        $activeWorksheet->setCellValue('C' . $currentRow, $item2->kieu_may_det);

                        $currentRow = $currentRow + 1;
    
                    }

                    $activeWorksheet
                    ->getStyle('A' . $currentRowKHST . ':M' . $currentRow - 1)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN)
                    ->setColor(new Color('17202A'));

                    $activeWorksheet->getStyle('A' . $currentRowKHST . ':M' . $currentRow - 1)->applyFromArray($styleArray);

                    $activeWorksheet->setCellValue('A' . $currentRow + 1, 'Thành phẩm của khách hàng');
                    $activeWorksheet->setCellValue('B' . $currentRow + 1, 'Phản ánh của khách hàng về lot cũ');

                    $activeWorksheet->setCellValue('A' . $currentRow + 2, $pxxdh->thanh_pham_cua_khach_hang);
                    $activeWorksheet->setCellValue('B' . $currentRow + 2, $pxxdh->phan_anh_cua_khach_hang);

                    $activeWorksheet->getStyle('A' . $currentRow + 1 . ':B' . $currentRow + 1)->getFont()->setBold(true);

                    $activeWorksheet
                    ->getStyle('A' . $currentRow + 1 . ':B' . $currentRow + 2)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN)
                    ->setColor(new Color('17202A'));

                    $writer = new Xlsx($spreadsheet);

                    ob_start();
                    $writer->save('php://output');
                    $content = ob_get_contents();
                    ob_end_clean();

                    Storage::disk('public')->put('PhieuXXDH/' . $this->soPhieu . '/' . $this->soPhieu . ".xlsx", $content);
    
                    Mail::to('qa@century.vn')->cc('luongphan@soitheky.vn')->cc($ccMail)->send(new MailPhieuXXDH('KHST APPROVED',$this->soPhieu, Auth::user()->username, $PhieuXXDHLog->updated_at,''));
    
                    flash()->addFlash('success', 'Duyệt thành công phiếu : ' . $this->soPhieu,'Thông báo');
    
                    $this->emit('approvePhieuXXDHModal');
    
                    $this->resetInputField();
    
                }elseif($pxxdh->status == 'KHST APPROVED'){
    
                    $pxxdh->status = 'QA APPROVED';
                    $pxxdh->phan_hoi_qa = $this->phanHoiQA;
                    $pxxdh->updated_user = Auth::user()->username;
                    $pxxdh->qa_approved = Auth::user()->username;
                    $pxxdh->qa_approved_at = Carbon::now();
            
                    $pxxdh->update();
    
                    $arr = [
    
                        'so_phieu' => $pxxdh->so_phieu,
                        'loai' => $pxxdh->loai,
                        'don_hang_grs' => $pxxdh->don_hang_grs,
                        'don_hang_non_grs' => $pxxdh->don_hang_non_grs,
                        'don_hang_sx_moi' => $pxxdh->don_hang_sx_moi,
                        'don_hang_lap_lai' => $pxxdh->don_hang_lap_lai,
                        'don_hang_ton_kho' => $pxxdh->don_hang_ton_kho,
                        'date' => $pxxdh->date,
                        'ten_cong_ty' => $pxxdh->ten_cong_ty,
                        'so' => $pxxdh->so,
                        'hop_dong' => $pxxdh->hop_dong,
                        // 'so_cone' => $pxxdh->so_cone,
                        // 'so_kg_cone' => $pxxdh->so_kg_cone,
                        // 'line' => $pxxdh->line,
                        // 'may' => $pxxdh->may,
                        // 'ngay_giao_hang' => $pxxdh->ngay_giao_hang,
                        // 'ngay_bat_dau_giao' => $pxxdh->ngay_bat_dau_giao,
                        'thanh_pham_cua_khach_hang' => $pxxdh->thanh_pham_cua_khach_hang,
                        'phan_anh_cua_khach_hang' => $pxxdh->phan_anh_cua_khach_hang,
                        // 'thong_tin_dong_goi' => $pxxdh->thong_tin_dong_goi,
                        'phan_hoi_khst' => $pxxdh->phanHoiKHST,
                        'phan_hoi_qa' => $this->phanHoiQA,
                        'phan_bo_cc' => $pxxdh->cbCC,
                        'phan_bo_tb2' => $pxxdh->cbTB2,
                        'phan_bo_tb3' => $pxxdh->cbTB3,
    
                        'mail_chinh' => $pxxdh->mail_chinh,
                        'mail_phu_1' => $pxxdh->mail_phu_1,
                        'mail_phu_2' => $pxxdh->mail_phu_2,
        
                        'status' => 'QA APPROVED',
                        'created_user' => $pxxdh->created_user,
                        
                        'status_log' => 'Approve',
                        'updated_user' => Auth::user()->username,
        
                    ];
    
                    $PhieuXXDHLog = PhieuXXDHLog::create($arr);
    
                    foreach ($this->quyCachPhieuXXDH as $item) {
                        
                        QuyCachPhieuXXDHLog::create([
                            
                            'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                            'quy_cach' => $item->quy_cach,
                            'so_luong' => $item->so_luong,
                            'kieu_may_det' => $item->kieu_may_det,
                            'lot' => $item->lot,
                            'so_cone' => $item->so_cone,
                            'so_kg_cone' => $item->so_kg_cone,
                            'line' => $item->line,
                            'may' => $item->may,
                            'ngay_giao_hang' => $item->ngay_giao_hang,
                            'ngay_bat_dau_giao' => $item->ngay_bat_dau_giao,
                            //'thanh_pham_cua_khach_hang' => $item->thanh_pham_cua_khach_hang,
                            //'phan_anh_cua_khach_hang' => $item->phan_anh_cua_khach_hang,
                            'thong_tin_dong_goi' => $item->thong_tin_dong_goi,
                            'pallet' => $item->pallet,
                            'recycle' => $item->recycle,
                            'status' => 'Sale'    
                        ]);
    
                    }
    
                    foreach ($this->quyCachPhieuXXDHKHST as $item) {
        
                        QuyCachPhieuXXDHLog::create([
        
                            'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                            'quy_cach' => $item->quy_cach,
                            'so_luong' => $item->so_luong,
                            'lot' => $item->lot,
                            'status' => 'KHST'
        
                        ]);
                    }

                    if(file_exists(storage_path('app/public/PhieuXXDH/') . $pxxdh->so_phieu . '/' . $pxxdh->so_phieu .'.docx')){

                        $templateProcessor = new TemplateProcessor(storage_path('app/public/PhieuXXDH/') . $pxxdh->so_phieu . '/' . $pxxdh->so_phieu .'.docx');

                        $values = [
        
                            'phan_hoi_qa' => $this->phanHoiQA
        
                        ];
    
                        $templateProcessor->setValues($values);
    
                        $templateProcessor->saveAs(storage_path('app/public/PhieuXXDH/') . $pxxdh->so_phieu . '/' . $pxxdh->so_phieu .'.docx');

                    }else{
                    
                        Storage::disk('public')->makeDirectory('PhieuXXDH/' . $pxxdh->so_phieu);
    
                        $templateProcessor = new TemplateProcessor(public_path('PhieuXXDH/PXXDH.docx'));
        
                        $values = [
        
                            'date' => Carbon::create($pxxdh->date)->format('d-m-Y'),
                            'ten_cong_ty' => $pxxdh->ten_cong_ty,
                            'so' => $pxxdh->so,
                            'so_phieu' => $pxxdh->so_phieu,
                            // 'so_cone' => $pxxdh->so_cone,
                            // 'so_kg_cone' => $pxxdh->so_kg_cone,
                            // 'line' => $pxxdh->line,
                            // 'may' => $pxxdh->may,
                            // 'ngay_giao_hang' => Carbon::create($pxxdh->ngay_giao_hang)->format('d-m-Y'),
                            // 'ngay_bat_dau_giao' => Carbon::create($pxxdh->ngay_bat_dau_giao)->format('d-m-Y'),
                            // 'thanh_pham_cua_khach_hang' => $pxxdh->thanh_pham_cua_khach_hang,
                            // 'phan_anh_cua_khach_hang' => $pxxdh->phan_anh_cua_khach_hang,
                            'phan_hoi_khst' => $pxxdh->phan_hoi_khst,
                            // 'phan_hoi_qa' => $this->phanHoiQA
        
                        ];
                        // $values_table = [];
                        // $values_table_thuc_te = [];
        
                        // foreach ($this->quyCachPhieuXXDH as $item){
        
                        //     $values_table = array_merge($values_table,[
        
                        //         [
                        //             'quy_cach' => $item->quy_cach, 
                        //             'so_luong' => $item->so_luong, 
                        //             'kieu_may_det' => $item->kieu_may_det, 
                        //             'lot' => $item->lot,
                        //         ]
        
                        //     ]);
        
                        // }
        
                        // foreach ($this->quyCachPhieuXXDHKHST as $item){
        
                        //     $values_table_thuc_te = array_merge($values_table_thuc_te,[
        
                        //         [
                        //             'quy_cach_thuc_te' => $item->quy_cach, 
                        //             'so_luong_thuc_te' => $item->so_luong, 
                        //             'lot_thuc_te' => $item->lot,
                        //         ]
        
                        //     ]);
        
                        // }
        
                        // $templateProcessor->cloneRowAndSetValues('quy_cach', $values_table);
                        // $templateProcessor->cloneRowAndSetValues('quy_cach_thuc_te', $values_table_thuc_te);
        
                        if($pxxdh->don_hang_grs == '1')
                            $templateProcessor->setImageValue('im_grs', 'images/icons-checkbox.png');
                        else
                            $templateProcessor->setImageValue('im_grs', 'images/icons-square.png');
        
                        if($pxxdh->don_hang_non_grs == '1')
                            $templateProcessor->setImageValue('im_non_grs', 'images/icons-checkbox.png');
                        else
                            $templateProcessor->setImageValue('im_non_grs', 'images/icons-square.png');
        
                        if($pxxdh->don_hang_sx_moi == '1')
                            $templateProcessor->setImageValue('im_moi', 'images/icons-checkbox.png');
                        else
                            $templateProcessor->setImageValue('im_moi', 'images/icons-square.png');
        
                        if($pxxdh->don_hang_lap_lai == '1')
                            $templateProcessor->setImageValue('im_lap_lai', 'images/icons-checkbox.png');
                        else
                            $templateProcessor->setImageValue('im_lap_lai', 'images/icons-square.png');
        
                        if($pxxdh->don_hang_ton_kho == '1')
                            $templateProcessor->setImageValue('im_ton_kho', 'images/icons-checkbox.png');
                        else
                            $templateProcessor->setImageValue('im_ton_kho', 'images/icons-square.png');
        
                        $templateProcessor->setValues($values);
                
                        $templateProcessor->saveAs(storage_path('app/public/PhieuXXDH/') . $pxxdh->so_phieu . '/' . $pxxdh->so_phieu .'.docx');
    
                        // Tạo file excel quy cách
    
                        $spreadsheet = new Spreadsheet();
    
                        $activeWorksheet = $spreadsheet->getActiveSheet();
    
                        $activeWorksheet->setTitle($this->soPhieu . ' - Quy cách');
    
                        $activeWorksheet->setCellValue('A1', 'Quy cách');
                        $activeWorksheet->setCellValue('B1', 'Số lượng (kgs)');
                        $activeWorksheet->setCellValue('C1', 'Kiểu máy dệt + điều kiện đặc biệt của khách hàng');
                        $activeWorksheet->setCellValue('D1', 'Chạy theo TS LOT');
                        $activeWorksheet->setCellValue('E1', 'Số cone');
                        $activeWorksheet->setCellValue('F1', 'Số kg/cone');
                        $activeWorksheet->setCellValue('G1', 'Line');
                        $activeWorksheet->setCellValue('H1', 'Máy');
                        $activeWorksheet->setCellValue('I1', 'Ngày giao hàng');
                        $activeWorksheet->setCellValue('J1', 'Ngày bắt đầu giao (nếu có)');
                        $activeWorksheet->setCellValue('K1', 'Thông tin đóng gói');
                        $activeWorksheet->setCellValue('L1', 'Pallet');
                        $activeWorksheet->setCellValue('M1', 'Recycle');
    
                        $currentRow = 2;
    
                        foreach ($this->quyCachPhieuXXDH as $item){
        
                            $activeWorksheet->setCellValue('A' . $currentRow, $item->quy_cach);
                            $activeWorksheet->setCellValue('B' . $currentRow, $item->so_luong);
                            $activeWorksheet->setCellValue('C' . $currentRow, $item->kieu_may_det);
                            $activeWorksheet->setCellValue('D' . $currentRow, $item->lot);
                            $activeWorksheet->setCellValue('E' . $currentRow, $item->so_cone);
                            $activeWorksheet->setCellValue('F' . $currentRow, $item->so_kg_cone);
                            $activeWorksheet->setCellValue('G' . $currentRow, $item->line);
                            $activeWorksheet->setCellValue('H' . $currentRow, $item->may);
                            $activeWorksheet->setCellValue('I' . $currentRow, $item->ngay_giao_hang);
                            $activeWorksheet->setCellValue('J' . $currentRow, $item->ngay_bat_dau_giao);
                            $activeWorksheet->setCellValue('K' . $currentRow, $item->thong_tin_dong_goi);
                            $activeWorksheet->setCellValue('L' . $currentRow, $item->pallet);
                            $activeWorksheet->setCellValue('M' . $currentRow, $item->recycle);
    
                            $currentRow = $currentRow + 1;
        
                        }
    
                        $activeWorksheet->setCellValue('A' . $currentRow + 1, 'Quy cách');
                        $activeWorksheet->setCellValue('B' . $currentRow + 1, 'Số lượng (kgs)');
                        $activeWorksheet->setCellValue('C' . $currentRow + 1, 'Kiểu máy dệt + điều kiện đặc biệt của khách hàng');
    
                        $currentRow = $currentRow + 2;
        
                        foreach ($this->quyCachPhieuXXDHKHST as $item2){
        
                            $activeWorksheet->setCellValue('A' . $currentRow, $item2->quy_cach);
                            $activeWorksheet->setCellValue('B' . $currentRow, $item2->so_luong);
                            $activeWorksheet->setCellValue('C' . $currentRow, $item2->kieu_may_det);
    
                            $currentRow = $currentRow + 1;
        
                        }
    
                        $activeWorksheet->setCellValue('A' . $currentRow + 1, 'Thành phẩm của khách hàng');
                        $activeWorksheet->setCellValue('B' . $currentRow + 1, 'Phản ánh của khách hàng về lot cũ');
    
                        $activeWorksheet->setCellValue('A' . $currentRow + 2, $pxxdh->thanh_pham_cua_khach_hang);
                        $activeWorksheet->setCellValue('B' . $currentRow + 2, $pxxdh->phan_anh_cua_khach_hang);
    
                        $writer = new Xlsx($spreadsheet);
    
                        ob_start();
                        $writer->save('php://output');
                        $content = ob_get_contents();
                        ob_end_clean();
    
                        Storage::disk('public')->put($this->soPhieu . '/' . $this->soPhieu . ".xlsx", $content);

                    }

                    $emailUserCreate = User::where('username', $pxxdh->created_user)->first();
    
                    Mail::to($emailUserCreate->email)->cc('luongphan@soitheky.vn')->send(new MailPhieuXXDH('QA APPROVED',$this->soPhieu, Auth::user()->username, $PhieuXXDHLog->updated_at, ''));
    
                    flash()->addFlash('success', 'Duyệt thành công phiếu : ' . $this->soPhieu,'Thông báo');
    
                    $this->emit('approvePhieuXXDHModal');
    
                    $this->resetInputField();
    
                }elseif($pxxdh->status == 'QA APPROVED'){
    
                    $pxxdh->status = 'Finish';
                    $pxxdh->finish = Auth::user()->username;
                    $pxxdh->finish_at = Carbon::now();
                    $pxxdh->updated_user = Auth::user()->username;
            
                    $pxxdh->update();
    
                    $arr = [
    
                        'so_phieu' => $pxxdh->so_phieu,
                        'loai' => $pxxdh->loai,
                        'don_hang_grs' => $pxxdh->don_hang_grs,
                        'don_hang_non_grs' => $pxxdh->don_hang_non_grs,
                        'don_hang_sx_moi' => $pxxdh->don_hang_sx_moi,
                        'don_hang_lap_lai' => $pxxdh->don_hang_lap_lai,
                        'don_hang_ton_kho' => $pxxdh->don_hang_ton_kho,
                        'date' => $pxxdh->date,
                        'ten_cong_ty' => $pxxdh->ten_cong_ty,
                        'so' => $pxxdh->so,
                        'hop_dong' => $pxxdh->hop_dong,
                        // 'so_cone' => $pxxdh->so_cone,
                        // 'so_kg_cone' => $pxxdh->so_kg_cone,
                        // 'line' => $pxxdh->line,
                        // 'may' => $pxxdh->may,
                        // 'ngay_giao_hang' => $pxxdh->ngay_giao_hang,
                        // 'ngay_bat_dau_giao' => $pxxdh->ngay_bat_dau_giao,
                        'thanh_pham_cua_khach_hang' => $pxxdh->thanh_pham_cua_khach_hang,
                        'phan_anh_cua_khach_hang' => $pxxdh->phan_anh_cua_khach_hang,
                        // 'thong_tin_dong_goi' => $pxxdh->thong_tin_dong_goi,
                        'phan_hoi_khst' => $pxxdh->phanHoiKHST,
                        'phan_bo_cc' => $pxxdh->cbCC,
                        'phan_bo_tb2' => $pxxdh->cbTB2,
                        'phan_bo_tb3' => $pxxdh->cbTB3,
                        'phan_hoi_qa' => $pxxdh->phanHoiQA,
    
                        'mail_chinh' => $pxxdh->mail_chinh,
                        'mail_phu_1' => $pxxdh->mail_phu_1,
                        'mail_phu_2' => $pxxdh->mail_phu_2,
        
                        'status' => 'Finish',
                        'created_user' => $pxxdh->created_user,
                        
                        'status_log' => 'Finish',
                        'updated_user' => Auth::user()->username,
        
                    ];
    
                    $PhieuXXDHLog = PhieuXXDHLog::create($arr);
    
                    foreach ($this->quyCachPhieuXXDH as $item) {
                        
                        QuyCachPhieuXXDHLog::create([
                            
                            'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                            'quy_cach' => $item->quy_cach,
                            'so_luong' => $item->so_luong,
                            'kieu_may_det' => $item->kieu_may_det,
                            'lot' => $item->lot,
                            'so_cone' => $item->so_cone,
                            'so_kg_cone' => $item->so_kg_cone,
                            'line' => $item->line,
                            'may' => $item->may,
                            'ngay_giao_hang' => $item->ngay_giao_hang,
                            'ngay_bat_dau_giao' => $item->ngay_bat_dau_giao,
                            //'thanh_pham_cua_khach_hang' => $item->thanh_pham_cua_khach_hang,
                            //'phan_anh_cua_khach_hang' => $item->phan_anh_cua_khach_hang,
                            'thong_tin_dong_goi' => $item->thong_tin_dong_goi,
                            'pallet' => $item->pallet,
                            'recycle' => $item->recycle,
                            'status' => 'Sale'    
                        ]);
    
                    }
    
                    foreach ($this->quyCachPhieuXXDHKHST as $item) {
        
                        QuyCachPhieuXXDHLog::create([
        
                            'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                            'quy_cach' => $item->quy_cach,
                            'so_luong' => $item->so_luong,
                            'lot' => $item->lot,
                            'status' => 'KHST'
        
                        ]);
                    }
    
                    SO::where('so', $pxxdh->so)->update([
    
                        'status_phieu_xxdh' => '1'
                        
                    ]);

                    $cc = [];

                    if($pxxdh->mailPhu1 != null){

                        $cc = array_merge($cc, [

                            $pxxdh->mailPhu1,

                        ]);

                    }

                    if($pxxdh->mailPhu1 != null){

                        $cc = array_merge($cc, [

                            $pxxdh->mailPhu2

                        ]);

                    }
    
                    Mail::to($pxxdh->mail_chinh)
                    ->cc($cc)
                    ->send(new MailPhieuXXDH('Finish',$this->soPhieu, Auth::user()->username, $PhieuXXDHLog->updated_at, ''));
                    flash()->addFlash('success', 'Duyệt thành công phiếu : ' . $this->soPhieu,'Thông báo');
        
                    $this->resetInputField();
        
                    $this->emit('approvePhieuXXDHModal');
                }
            }else{
                if($pxxdh->status == 'New'){

                    $pxxdh->status = 'Sale APPROVED';
    
                    // $pxxdh->so_cone = $this->soCone;
                    // $pxxdh->so_kg_cone = $this->soKgCone;
                    // $pxxdh->line = $this->Line;
                    // $pxxdh->may = $this->May;
                    // $pxxdh->ngay_giao_hang = $this->ngayGiaoHang;
                    // $pxxdh->ngay_bat_dau_giao = $this->ngayBatDauGiao;
                    $pxxdh->thanh_pham_cua_khach_hang = $this->thanhPhamCuaKhachHang;
                    $pxxdh->phan_anh_cua_khach_hang = $this->phanAnhCuaKhachHang;
                    // $pxxdh->thong_tin_dong_goi = $this->thongTinDongGoi;

                    $pxxdh->sale_approved = Auth::user()->username;
                    $pxxdh->sale_approved_at = Carbon::now();
                    
                    $pxxdh->updated_user = Auth::user()->username;
                    
            
                    $pxxdh->update();
    
                    $arr = [
    
                        'so_phieu' => $pxxdh->so_phieu,
                        'loai' => $pxxdh->loai,
                        'don_hang_grs' => $pxxdh->don_hang_grs,
                        'don_hang_non_grs' => $pxxdh->don_hang_non_grs,
                        'don_hang_sx_moi' => $pxxdh->don_hang_sx_moi,
                        'don_hang_lap_lai' => $pxxdh->don_hang_lap_lai,
                        'don_hang_ton_kho' => $pxxdh->don_hang_ton_kho,
                        'date' => $pxxdh->date,
                        'ten_cong_ty' => $pxxdh->ten_cong_ty,
                        'so' => $pxxdh->so,
                        'hop_dong' => $pxxdh->hop_dong,
                        // 'so_cone' => $pxxdh->so_cone,
                        // 'so_kg_cone' => $pxxdh->so_kg_cone,
                        // 'line' => $pxxdh->line,
                        // 'may' => $pxxdh->may,
                        // 'ngay_giao_hang' => $pxxdh->ngay_giao_hang,
                        // 'ngay_bat_dau_giao' => $pxxdh->ngay_bat_dau_giao,
                        'thanh_pham_cua_khach_hang' => $pxxdh->thanh_pham_cua_khach_hang,
                        'phan_anh_cua_khach_hang' => $pxxdh->phan_anh_cua_khach_hang,
                        // 'thong_tin_dong_goi' => $pxxdh->thong_tin_dong_goi,
    
                        'mail_chinh' => $pxxdh->mail_chinh,
                        'mail_phu_1' => $pxxdh->mail_phu_1,
                        'mail_phu_2' => $pxxdh->mail_phu_2,
        
                        'status' => 'Sale APPROVED',
                        'status_log' => 'Approve',
                        'created_user' => $pxxdh->created_user,
                        'updated_user' => Auth::user()->username,
        
                    ];
        
                    $PhieuXXDHLog = PhieuXXDHLog::create($arr);
    
                    foreach ($this->lot as $key => $value) {
    
                        $insert =  QuyCachPhieuXXDH::where('id' , $key)->first();
                        
                        $insert->kieu_may_det = $this->kieuMayDet[$key];
                        $insert->lot = $this->lot[$key];
                        $insert->so_cone = $this->soCone[$key] ?? null;
                        $insert->so_kg_cone = $this->soKgCone[$key] ?? null;
                        $insert->line = $this->Line[$key] ?? null;
                        $insert->may = $this->May[$key] ?? null;
                        $insert->ngay_giao_hang = $this->ngayGiaoHang[$key] ?? null;
                        $insert->ngay_bat_dau_giao = $this->ngayBatDauGiao[$key] ?? null;
                        //$insert->thanh_pham_cua_khach_hang = $this->thanhPhamCuaKhachHang[$key] ?? null;
                        //$insert->phan_anh_cua_khach_hang = $this->phanAnhCuaKhachHang[$key] ?? null;
                        $insert->lich_du_kien = $this->lichDuKien;
                        $insert->thong_tin_dong_goi = $this->thongTinDongGoi[$key] ?? null;
                        $insert->pallet = $this->pallet[$key] ?? null;
                        $insert->recycle = $this->recycle[$key] ?? null;
    
                        $insert->update();
    
                        QuyCachPhieuXXDHLog::create([
                            
                            'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                            'quy_cach' => $insert->quy_cach,
                            'so_luong' => $insert->so_luong,
                            'kieu_may_det' => $this->kieuMayDet[$key] ?? null,
                            'lot' => $this->lot[$key] ?? null,
                            'so_cone' => $this->soCone[$key] ?? null,
                            'so_kg_cone' => $this->soKgCone[$key] ?? null,
                            'line' => $this->Line[$key] ?? null,
                            'may' => $this->May[$key] ?? null,
                            'ngay_giao_hang' => $this->ngayGiaoHang[$key] ?? null,
                            'ngay_bat_dau_giao' => $this->ngayBatDauGiao[$key] ?? null,
                            //'thanh_pham_cua_khach_hang' => $this->thanhPhamCuaKhachHang[$key] ?? null,
                            //'phan_anh_cua_khach_hang' => $this->phanAnhCuaKhachHang[$key] ?? null,
                            'lich_du_kien' => $this->lichDuKien,
                            'thong_tin_dong_goi' => $this->thongTinDongGoi[$key] ?? null,
                            'pallet' => $this->pallet[$key] ?? null,
                            'recycle' => $this->recycle[$key] ?? null,
                            'status' => 'Sale'
        
                        ]);
                    }

                    $emailQuanLySale = EmailQuanLy::where('chuc_vu', 'quan_ly_sale')->first();
    
                    Mail::to($emailQuanLySale->email)->cc('luongphan@soitheky.vn')->send(new MailPhieuXXDH('Sale APPROVED',$this->soPhieu, Auth::user()->username, $PhieuXXDHLog->updated_at, ''));
                    
                    flash()->addFlash('success', 'Duyệt thành công phiếu : ' . $this->soPhieu,'Thông báo');
    
                    $this->emit('approvePhieuXXDHModal');
    
                    $this->resetInputField();
    
                }elseif($pxxdh->status == 'Sale APPROVED'){
    
                    $pxxdh->status = 'SM APPROVED';
                    $pxxdh->sm_approved = Auth::user()->username;
                    $pxxdh->sm_approved_at = Carbon::now();
                    $pxxdh->updated_user = Auth::user()->username;
            
                    $pxxdh->update();
    
                    $arr = [
    
                        'so_phieu' => $pxxdh->so_phieu,
                        'loai' => $pxxdh->loai,
                        'don_hang_grs' => $pxxdh->don_hang_grs,
                        'don_hang_non_grs' => $pxxdh->don_hang_non_grs,
                        'don_hang_sx_moi' => $pxxdh->don_hang_sx_moi,
                        'don_hang_lap_lai' => $pxxdh->don_hang_lap_lai,
                        'don_hang_ton_kho' => $pxxdh->don_hang_ton_kho,
                        'date' => $pxxdh->date,
                        'ten_cong_ty' => $pxxdh->ten_cong_ty,
                        'so' => $pxxdh->so,
                        'hop_dong' => $pxxdh->hop_dong,
                        // 'so_cone' => $pxxdh->so_cone,
                        // 'so_kg_cone' => $pxxdh->so_kg_cone,
                        // 'line' => $pxxdh->line,
                        // 'may' => $pxxdh->may,
                        // 'ngay_giao_hang' => $pxxdh->ngay_giao_hang,
                        // 'ngay_bat_dau_giao' => $pxxdh->ngay_bat_dau_giao,
                        'thanh_pham_cua_khach_hang' => $pxxdh->thanh_pham_cua_khach_hang,
                        'phan_anh_cua_khach_hang' => $pxxdh->phan_anh_cua_khach_hang,
                        // 'thong_tin_dong_goi' => $pxxdh->thong_tin_dong_goi,
    
                        'mail_chinh' => $pxxdh->mail_chinh,
                        'mail_phu_1' => $pxxdh->mail_phu_1,
                        'mail_phu_2' => $pxxdh->mail_phu_2,
        
                        'status' => 'SM APPROVED',
                        'created_user' => $pxxdh->created_user,
                        
                        'status_log' => 'Approve',
                        'updated_user' => Auth::user()->username,
        
                    ];
        
                    $PhieuXXDHLog = PhieuXXDHLog::create($arr);
    
                    foreach ($this->quyCachPhieuXXDH as $item) {
                        
                        QuyCachPhieuXXDHLog::create([
                            
                            'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                            'quy_cach' => $item->quy_cach,
                            'so_luong' => $item->so_luong,
                            'kieu_may_det' => $item->kieu_may_det,
                            'lot' => $item->lot,
                            'so_cone' => $item->so_cone,
                            'so_kg_cone' => $item->so_kg_cone,
                            'line' => $item->line,
                            'may' => $item->may,
                            'ngay_giao_hang' => $item->ngay_giao_hang,
                            'ngay_bat_dau_giao' => $item->ngay_bat_dau_giao,
                            //'thanh_pham_cua_khach_hang' => $item->thanh_pham_cua_khach_hang,
                            //'phan_anh_cua_khach_hang' => $item->phan_anh_cua_khach_hang,
                            'thong_tin_dong_goi' => $item->thong_tin_dong_goi,
                            'pallet' => $item->pallet,
                            'recycle' => $item->recycle,
                            'status' => 'Sale'
        
                        ]);
    
                    }
    
                    Mail::to('qa@century.vn')->cc('luongphan@soitheky.vn')->send(new MailPhieuXXDH('SM APPROVED',$this->soPhieu, Auth::user()->username, $PhieuXXDHLog->updated_at, ''));
    
                    flash()->addFlash('success', 'Duyệt thành công phiếu : ' . $this->soPhieu,'Thông báo');
    
                    $this->emit('approvePhieuXXDHModal');
    
                    $this->resetInputField();
    
                }elseif($pxxdh->status == 'SM APPROVED'){
    
                    $pxxdh->status = 'QA REQUESTED';
                    $pxxdh->qa_kien_nghi = $this->qaKienNghi;
                    $pxxdh->qa_request = Auth::user()->username;
                    $pxxdh->qa_request_at = Carbon::now();
                    $pxxdh->updated_user = Auth::user()->username;
            
                    $pxxdh->update();
    
                    $arr = [
    
                        'so_phieu' => $pxxdh->so_phieu,
                        'loai' => $pxxdh->loai,
                        'don_hang_grs' => $pxxdh->don_hang_grs,
                        'don_hang_non_grs' => $pxxdh->don_hang_non_grs,
                        'don_hang_sx_moi' => $pxxdh->don_hang_sx_moi,
                        'don_hang_lap_lai' => $pxxdh->don_hang_lap_lai,
                        'don_hang_ton_kho' => $pxxdh->don_hang_ton_kho,
                        'date' => $pxxdh->date,
                        'ten_cong_ty' => $pxxdh->ten_cong_ty,
                        'so' => $pxxdh->so,
                        'hop_dong' => $pxxdh->hop_dong,
                        // 'so_cone' => $pxxdh->so_cone,
                        // 'so_kg_cone' => $pxxdh->so_kg_cone,
                        'qa_kien_nghi' => $pxxdh->qa_kien_nghi,
                        // 'line' => $pxxdh->line,
                        // 'may' => $pxxdh->may,
                        // 'ngay_giao_hang' => $pxxdh->ngay_giao_hang,
                        // 'ngay_bat_dau_giao' => $pxxdh->ngay_bat_dau_giao,
                        'thanh_pham_cua_khach_hang' => $pxxdh->thanh_pham_cua_khach_hang,
                        'phan_anh_cua_khach_hang' => $pxxdh->phan_anh_cua_khach_hang,
                        'phan_hoi_khst' => $this->phanHoiKHST,
                        // 'thong_tin_dong_goi' => $pxxdh->thong_tin_dong_goi,
    
                        'mail_chinh' => $pxxdh->mail_chinh,
                        'mail_phu_1' => $pxxdh->mail_phu_1,
                        'mail_phu_2' => $pxxdh->mail_phu_2,
        
                        'status' => 'QA REQUESTED',
                        'created_user' => $pxxdh->created_user,
                        
                        'status_log' => 'Approve',
                        'updated_user' => Auth::user()->username,
        
                    ];
        
                    $PhieuXXDHLog = PhieuXXDHLog::create($arr);
    
                    foreach ($this->quyCachPhieuXXDH as $item) {
                        
                        QuyCachPhieuXXDHLog::create([
                            
                            'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                            'quy_cach' => $item->quy_cach,
                            'so_luong' => $item->so_luong,
                            'kieu_may_det' => $item->kieu_may_det,
                            'lot' => $item->lot,
                            'so_cone' => $item->so_cone,
                            'so_kg_cone' => $item->so_kg_cone,
                            'line' => $item->line,
                            'may' => $item->may,
                            'ngay_giao_hang' => $item->ngay_giao_hang,
                            'ngay_bat_dau_giao' => $item->ngay_bat_dau_giao,
                            //'thanh_pham_cua_khach_hang' => $item->thanh_pham_cua_khach_hang,
                            //'phan_anh_cua_khach_hang' => $item->phan_anh_cua_khach_hang,
                            'thong_tin_dong_goi' => $item->thong_tin_dong_goi,
                            'pallet' => $item->pallet,
                            'recycle' => $item->recycle,
                            'status' => 'Sale'
        
                        ]);
    
                    }
    
                    Mail::to('khth@century.vn')->cc('luongphan@soitheky.vn')->send(new MailPhieuXXDH('KHST APPROVED',$this->soPhieu, Auth::user()->username, $PhieuXXDHLog->updated_at, ''));
    
                    flash()->addFlash('success', 'Duyệt thành công phiếu : ' . $this->soPhieu,'Thông báo');
    
                    $this->emit('approvePhieuXXDHModal');
    
                    $this->resetInputField();
    
                }elseif($pxxdh->status == 'QA REQUESTED'){

                    $ccMail = [];

                    if($this->cbCC == 1){

                        $phanBoPTKSX =  PhanBoPTKSX::where('nha_may', 'CC')->first();

                        $ccMail = array_merge($ccMail,[$phanBoPTKSX->email]);

                        $mailCC = $phanBoPTKSX->email;

                    }else{

                        $mailCC = '';

                    }

                    if($this->cbTB2 == 1){

                        $phanBoPTKSX =  PhanBoPTKSX::where('nha_may', 'TB2')->first();

                        $ccMail = array_merge($ccMail,[$phanBoPTKSX->email]);

                        $mailTB2 = $phanBoPTKSX->email;

                    }else{

                        $mailTB2 = '';

                    }

                    if($this->cbTB3 == 1){

                        $phanBoPTKSX =  PhanBoPTKSX::where('nha_may', 'TB3')->first();

                        $ccMail = array_merge($ccMail,[$phanBoPTKSX->email]);

                        $mailTB3 = $phanBoPTKSX->email;

                    }else{

                        $mailTB3 = '';

                    }

                    $pxxdh->status = 'KHST APPROVED';
                    $pxxdh->phan_hoi_khst = $this->phanHoiKHST;
                    $pxxdh->line = $this->Line;
                    $pxxdh->phan_bo_cc = $mailCC;
                    $pxxdh->phan_bo_tb2 = $mailTB2;
                    $pxxdh->phan_bo_tb3 = $mailTB3;
                    $pxxdh->xac_nhan_phan_bo = null;
                    $pxxdh->updated_user = Auth::user()->username;
                    $pxxdh->khst_approved = Auth::user()->username;
                    $pxxdh->khst_approved_at = Carbon::now();
            
                    $pxxdh->update();
    
                    $arr = [
    
                        'so_phieu' => $pxxdh->so_phieu,
                        'loai' => $pxxdh->loai,
                        'don_hang_grs' => $pxxdh->don_hang_grs,
                        'don_hang_non_grs' => $pxxdh->don_hang_non_grs,
                        'don_hang_sx_moi' => $pxxdh->don_hang_sx_moi,
                        'don_hang_lap_lai' => $pxxdh->don_hang_lap_lai,
                        'don_hang_ton_kho' => $pxxdh->don_hang_ton_kho,
                        'date' => $pxxdh->date,
                        'ten_cong_ty' => $pxxdh->ten_cong_ty,
                        'so' => $pxxdh->so,
                        'hop_dong' => $pxxdh->hop_dong,
                        // 'so_cone' => $pxxdh->so_cone,
                        // 'so_kg_cone' => $pxxdh->so_kg_cone,
                        'qa_kien_nghi' => $pxxdh->qa_kien_nghi,
                        // 'line' => $pxxdh->line,
                        // 'may' => $pxxdh->may,
                        // 'ngay_giao_hang' => $pxxdh->ngay_giao_hang,
                        // 'ngay_bat_dau_giao' => $pxxdh->ngay_bat_dau_giao,
                        'thanh_pham_cua_khach_hang' => $pxxdh->thanh_pham_cua_khach_hang,
                        'phan_anh_cua_khach_hang' => $pxxdh->phan_anh_cua_khach_hang,
                        // 'thong_tin_dong_goi' => $pxxdh->thong_tin_dong_goi,
                        'phan_hoi_khst' => $this->phanHoiKHST,
                        'phan_bo_cc' => $mailCC,
                        'phan_bo_tb2' => $mailTB2,
                        'phan_bo_tb3' => $mailTB3,
    
                        'mail_chinh' => $pxxdh->mail_chinh,
                        'mail_phu_1' => $pxxdh->mail_phu_1,
                        'mail_phu_2' => $pxxdh->mail_phu_2,
        
                        'status' => 'KHST APPROVED',
                        'created_user' => $pxxdh->created_user,
                        
                        'status_log' => 'Approve',
                        'updated_user' => Auth::user()->username,
        
                    ];
        
                    $PhieuXXDHLog = PhieuXXDHLog::create($arr);
    
                    foreach ($this->quyCachPhieuXXDH as $item) {
                        
                        QuyCachPhieuXXDHLog::create([
                            
                            'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                            'quy_cach' => $item->quy_cach,
                            'so_luong' => $item->so_luong,
                            'kieu_may_det' => $item->kieu_may_det,
                            'lot' => $item->lot,
                            'so_cone' => $item->so_cone,
                            'so_kg_cone' => $item->so_kg_cone,
                            'line' => $item->line,
                            'may' => $item->may,
                            'ngay_giao_hang' => $item->ngay_giao_hang,
                            'ngay_bat_dau_giao' => $item->ngay_bat_dau_giao,
                            //'thanh_pham_cua_khach_hang' => $item->thanh_pham_cua_khach_hang,
                            //'phan_anh_cua_khach_hang' => $item->phan_anh_cua_khach_hang,
                            'thong_tin_dong_goi' => $item->thong_tin_dong_goi,
                            'pallet' => $item->pallet,
                            'recycle' => $item->recycle,
                            'status' => 'Sale'
        
                        ]);
    
                    }
    
                    foreach (array_reverse($this->quyCachSuDungKHST, true) as $key => $value) {
    
                        QuyCachPhieuXXDH::create([
        
                            'phieu_xxdh_so_phieu_id' => $pxxdh->id,
                            'quy_cach' => $this->quyCachSuDungKHST[$key],
                            'so_luong' => $this->soLuongKHST[$key],
                            'lot' => $this->lotKHST[$key],
                            'status' => 'KHST'
    
                        ]);
        
                        QuyCachPhieuXXDHLog::create([
        
                            'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                            'quy_cach' => $this->quyCachSuDungKHST[$key],
                            'so_luong' => $this->soLuongKHST[$key],
                            'lot' => $this->lotKHST[$key],
                            'status' => 'KHST'
        
                        ]);
                    }

                    Storage::disk('public')->makeDirectory('PhieuXXDH/' . $pxxdh->so_phieu);
    
                    $templateProcessor = new TemplateProcessor(public_path('PhieuXXDH/PXXDH.docx'));
    
                    $values = [
    
                        'date' => Carbon::create($pxxdh->date)->format('d-m-Y'),
                        'ten_cong_ty' => $pxxdh->ten_cong_ty,
                        'so' => $pxxdh->so,
                        'so_phieu' => $pxxdh->so_phieu,
                        // 'so_cone' => $pxxdh->so_cone,
                        // 'so_kg_cone' => $pxxdh->so_kg_cone,
                        // 'line' => $pxxdh->line,
                        // 'may' => $pxxdh->may,
                        // 'ngay_giao_hang' => Carbon::create($pxxdh->ngay_giao_hang)->format('d-m-Y'),
                        // 'ngay_bat_dau_giao' => Carbon::create($pxxdh->ngay_bat_dau_giao)->format('d-m-Y'),
                        // 'thanh_pham_cua_khach_hang' => $pxxdh->thanh_pham_cua_khach_hang,
                        // 'phan_anh_cua_khach_hang' => $pxxdh->phan_anh_cua_khach_hang,
                        'phan_hoi_khst' => $pxxdh->phan_hoi_khst,
                        // 'phan_hoi_qa' => $this->phanHoiQA
    
                    ];
                    // $values_table = [];
                    // $values_table_thuc_te = [];
    
                    // foreach ($this->quyCachPhieuXXDH as $item){
    
                    //     $values_table = array_merge($values_table,[
    
                    //         [
                    //             'quy_cach' => $item->quy_cach, 
                    //             'so_luong' => $item->so_luong, 
                    //             'kieu_may_det' => $item->kieu_may_det, 
                    //             'lot' => $item->lot,
                    //         ]
    
                    //     ]);
    
                    // }
    
                    // foreach ($this->quyCachPhieuXXDHKHST as $item){
    
                    //     $values_table_thuc_te = array_merge($values_table_thuc_te,[
    
                    //         [
                    //             'quy_cach_thuc_te' => $item->quy_cach, 
                    //             'so_luong_thuc_te' => $item->so_luong, 
                    //             'lot_thuc_te' => $item->lot,
                    //         ]
    
                    //     ]);
    
                    // }
    
                    // $templateProcessor->cloneRowAndSetValues('quy_cach', $values_table);
                    // $templateProcessor->cloneRowAndSetValues('quy_cach_thuc_te', $values_table_thuc_te);
    
                    if($pxxdh->don_hang_grs == '1')
                        $templateProcessor->setImageValue('im_grs', 'images/icons-checkbox.png');
                    else
                        $templateProcessor->setImageValue('im_grs', 'images/icons-square.png');
    
                    if($pxxdh->don_hang_non_grs == '1')
                        $templateProcessor->setImageValue('im_non_grs', 'images/icons-checkbox.png');
                    else
                        $templateProcessor->setImageValue('im_non_grs', 'images/icons-square.png');
    
                    if($pxxdh->don_hang_sx_moi == '1')
                        $templateProcessor->setImageValue('im_moi', 'images/icons-checkbox.png');
                    else
                        $templateProcessor->setImageValue('im_moi', 'images/icons-square.png');
    
                    if($pxxdh->don_hang_lap_lai == '1')
                        $templateProcessor->setImageValue('im_lap_lai', 'images/icons-checkbox.png');
                    else
                        $templateProcessor->setImageValue('im_lap_lai', 'images/icons-square.png');
    
                    if($pxxdh->don_hang_ton_kho == '1')
                        $templateProcessor->setImageValue('im_ton_kho', 'images/icons-checkbox.png');
                    else
                        $templateProcessor->setImageValue('im_ton_kho', 'images/icons-square.png');
    
                    $templateProcessor->setValues($values);
            
                    $templateProcessor->saveAs(storage_path('app/public/PhieuXXDH/') . $pxxdh->so_phieu . '/' . $pxxdh->so_phieu .'.docx');

                    // Tạo file excel quy cách

                    $spreadsheet = new Spreadsheet();

                    $activeWorksheet = $spreadsheet->getActiveSheet();

                    $activeWorksheet->setTitle($this->soPhieu . ' - Quy cách');

                    $styleArray = [
                        'borders' => [
                            'outline' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                                'color' => ['argb' => '000000'],
                            ],
                        ],
                    ];

                    $activeWorksheet->getColumnDimensionByColumn(1)->setAutoSize(true);
                    $activeWorksheet->getColumnDimensionByColumn(2)->setAutoSize(true);
                    $activeWorksheet->getColumnDimensionByColumn(3)->setAutoSize(true);
                    $activeWorksheet->getColumnDimensionByColumn(4)->setAutoSize(true);
                    $activeWorksheet->getColumnDimensionByColumn(5)->setAutoSize(true);
                    $activeWorksheet->getColumnDimensionByColumn(6)->setAutoSize(true);
                    $activeWorksheet->getColumnDimensionByColumn(7)->setAutoSize(true);
                    $activeWorksheet->getColumnDimensionByColumn(8)->setAutoSize(true);
                    $activeWorksheet->getColumnDimensionByColumn(9)->setAutoSize(true);
                    $activeWorksheet->getColumnDimensionByColumn(10)->setAutoSize(true);
                    $activeWorksheet->getColumnDimensionByColumn(11)->setAutoSize(true);
                    $activeWorksheet->getColumnDimensionByColumn(12)->setAutoSize(true);
                    $activeWorksheet->getColumnDimensionByColumn(13)->setAutoSize(true);

                    $activeWorksheet->setCellValue('A1', 'Sale');

                    $activeWorksheet->mergeCells('A1:M1');

                    $activeWorksheet->setCellValue('A2', 'Quy cách');
                    $activeWorksheet->setCellValue('B2', 'Số lượng (kgs)');
                    $activeWorksheet->setCellValue('C2', 'Kiểu máy dệt + điều kiện đặc biệt của khách hàng');
                    $activeWorksheet->setCellValue('D2', 'Chạy theo TS LOT');
                    $activeWorksheet->setCellValue('E2', 'Số cone');
                    $activeWorksheet->setCellValue('F2', 'Số kg/cone');
                    $activeWorksheet->setCellValue('G2', 'Line');
                    $activeWorksheet->setCellValue('H2', 'Máy');
                    $activeWorksheet->setCellValue('I2', 'Ngày giao hàng');
                    $activeWorksheet->setCellValue('J2', 'Ngày bắt đầu giao (nếu có)');
                    $activeWorksheet->setCellValue('K2', 'Thông tin đóng gói');
                    $activeWorksheet->setCellValue('L2', 'Pallet');
                    $activeWorksheet->setCellValue('M2', 'Recycle');

                    $activeWorksheet->getStyle('A1:M2')->getFont()->setBold(true);

                    $currentRow = 3;

                    foreach ($this->quyCachPhieuXXDH as $item){
    
                        $activeWorksheet->setCellValue('A' . $currentRow, $item->quy_cach);
                        $activeWorksheet->setCellValue('B' . $currentRow, $item->so_luong);
                        $activeWorksheet->setCellValue('C' . $currentRow, $item->kieu_may_det);
                        $activeWorksheet->setCellValue('D' . $currentRow, $item->lot);
                        $activeWorksheet->setCellValue('E' . $currentRow, $item->so_cone);
                        $activeWorksheet->setCellValue('F' . $currentRow, $item->so_kg_cone);
                        $activeWorksheet->setCellValue('G' . $currentRow, $item->line);
                        $activeWorksheet->setCellValue('H' . $currentRow, $item->may);
                        $activeWorksheet->setCellValue('I' . $currentRow, $item->ngay_giao_hang);
                        $activeWorksheet->setCellValue('J' . $currentRow, $item->ngay_bat_dau_giao);
                        $activeWorksheet->setCellValue('K' . $currentRow, $item->thong_tin_dong_goi);
                        $activeWorksheet->setCellValue('L' . $currentRow, $item->pallet);
                        $activeWorksheet->setCellValue('M' . $currentRow, $item->recycle);

                        $currentRow = $currentRow + 1;
    
                    }

                    $activeWorksheet
                    ->getStyle('A1' . ':M' . $currentRow - 1)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN)
                    ->setColor(new Color('17202A'));

                    $activeWorksheet->getStyle('A1' . ':M' . $currentRow - 1)->applyFromArray($styleArray);

                    $activeWorksheet->setCellValue('A' . $currentRow + 1, 'KHST');

                    $currentRowKHST = $currentRow + 1;

                    $activeWorksheet->mergeCells('A' . $currentRow + 1 . ':M' . $currentRow + 1);

                    $activeWorksheet->getStyle('A' . $currentRow + 1 . ':M' . $currentRow + 2)->getFont()->setBold(true);

                    $activeWorksheet->setCellValue('A' . $currentRow + 2, 'Quy cách');
                    $activeWorksheet->setCellValue('B' . $currentRow + 2, 'Số lượng (kgs)');
                    $activeWorksheet->setCellValue('C' . $currentRow + 2, 'Kiểu máy dệt + điều kiện đặc biệt của khách hàng');

                    $currentRow = $currentRow + 3;
    
                    foreach ($this->quyCachPhieuXXDHKHST as $item2){
    
                        $activeWorksheet->setCellValue('A' . $currentRow, $item2->quy_cach);
                        $activeWorksheet->setCellValue('B' . $currentRow, $item2->so_luong);
                        $activeWorksheet->setCellValue('C' . $currentRow, $item2->kieu_may_det);

                        $currentRow = $currentRow + 1;
    
                    }

                    $activeWorksheet
                    ->getStyle('A' . $currentRowKHST . ':M' . $currentRow - 1)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN)
                    ->setColor(new Color('17202A'));

                    $activeWorksheet->getStyle('A' . $currentRowKHST . ':M' . $currentRow - 1)->applyFromArray($styleArray);

                    $activeWorksheet->setCellValue('A' . $currentRow + 1, 'Thành phẩm của khách hàng');
                    $activeWorksheet->setCellValue('B' . $currentRow + 1, 'Phản ánh của khách hàng về lot cũ');

                    $activeWorksheet->setCellValue('A' . $currentRow + 2, $pxxdh->thanh_pham_cua_khach_hang);
                    $activeWorksheet->setCellValue('B' . $currentRow + 2, $pxxdh->phan_anh_cua_khach_hang);

                    $activeWorksheet->getStyle('A' . $currentRow + 1 . ':B' . $currentRow + 1)->getFont()->setBold(true);

                    $activeWorksheet
                    ->getStyle('A' . $currentRow + 1 . ':B' . $currentRow + 2)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN)
                    ->setColor(new Color('17202A'));

                    $writer = new Xlsx($spreadsheet);

                    ob_start();
                    $writer->save('php://output');
                    $content = ob_get_contents();
                    ob_end_clean();

                    Storage::disk('public')->put('PhieuXXDH/' . $this->soPhieu . '/' . $this->soPhieu . ".xlsx", $content);
    
                    Mail::to('qa@century.vn')->cc('luongphan@soitheky.vn')->cc($ccMail)->send(new MailPhieuXXDH('KHST APPROVED',$this->soPhieu, Auth::user()->username, $PhieuXXDHLog->updated_at, ''));
    
                    flash()->addFlash('success', 'Duyệt thành công phiếu : ' . $this->soPhieu,'Thông báo');
    
                    $this->emit('approvePhieuXXDHModal');
    
                    $this->resetInputField();
                    
                }elseif($pxxdh->status == 'KHST APPROVED'){
    
                    $pxxdh->status = 'QA APPROVED';
                    $pxxdh->phan_hoi_qa = $this->phanHoiQA;
                    $pxxdh->updated_user = Auth::user()->username;
                    $pxxdh->qa_approved = Auth::user()->username;
                    $pxxdh->qa_approved_at = Carbon::now();
            
                    $pxxdh->update();
    
                    $arr = [
    
                        'so_phieu' => $pxxdh->so_phieu,
                        'loai' => $pxxdh->loai,
                        'don_hang_grs' => $pxxdh->don_hang_grs,
                        'don_hang_non_grs' => $pxxdh->don_hang_non_grs,
                        'don_hang_sx_moi' => $pxxdh->don_hang_sx_moi,
                        'don_hang_lap_lai' => $pxxdh->don_hang_lap_lai,
                        'don_hang_ton_kho' => $pxxdh->don_hang_ton_kho,
                        'date' => $pxxdh->date,
                        'ten_cong_ty' => $pxxdh->ten_cong_ty,
                        'so' => $pxxdh->so,
                        'hop_dong' => $pxxdh->hop_dong,
                        // 'so_cone' => $pxxdh->so_cone,
                        // 'so_kg_cone' => $pxxdh->so_kg_cone,
                        'qa_kien_nghi' => $pxxdh->qa_kien_nghi,
                        // 'line' => $pxxdh->line,
                        // 'may' => $pxxdh->may,
                        // 'ngay_giao_hang' => $pxxdh->ngay_giao_hang,
                        // 'ngay_bat_dau_giao' => $pxxdh->ngay_bat_dau_giao,
                        'thanh_pham_cua_khach_hang' => $pxxdh->thanh_pham_cua_khach_hang,
                        'phan_anh_cua_khach_hang' => $pxxdh->phan_anh_cua_khach_hang,
                        // 'thong_tin_dong_goi' => $pxxdh->thong_tin_dong_goi,
                        'phan_hoi_khst' => $pxxdh->phanHoiKHST,
                        'phan_hoi_qa' => $this->phanHoiQA,
                        'phan_bo_cc' => $pxxdh->cbCC,
                        'phan_bo_tb2' => $pxxdh->cbTB2,
                        'phan_bo_tb3' => $pxxdh->cbTB3,
    
                        'mail_chinh' => $pxxdh->mail_chinh,
                        'mail_phu_1' => $pxxdh->mail_phu_1,
                        'mail_phu_2' => $pxxdh->mail_phu_2,
        
                        'status' => 'QA APPROVED',
                        'created_user' => $pxxdh->created_user,
                        
                        'status_log' => 'Approve',
                        'updated_user' => Auth::user()->username,
        
                    ];
    
                    $PhieuXXDHLog = PhieuXXDHLog::create($arr);
    
                    foreach ($this->quyCachPhieuXXDH as $item) {
                        
                        QuyCachPhieuXXDHLog::create([
                            
                            'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                            'quy_cach' => $item->quy_cach,
                            'so_luong' => $item->so_luong,
                            'kieu_may_det' => $item->kieu_may_det,
                            'lot' => $item->lot,
                            'so_cone' => $item->so_cone,
                            'so_kg_cone' => $item->so_kg_cone,
                            'line' => $item->line,
                            'may' => $item->may,
                            'ngay_giao_hang' => $item->ngay_giao_hang,
                            'ngay_bat_dau_giao' => $item->ngay_bat_dau_giao,
                            //'thanh_pham_cua_khach_hang' => $item->thanh_pham_cua_khach_hang,
                            //'phan_anh_cua_khach_hang' => $item->phan_anh_cua_khach_hang,
                            'thong_tin_dong_goi' => $item->thong_tin_dong_goi,
                            'pallet' => $item->pallet,
                            'recycle' => $item->recycle,
                            'status' => 'Sale'    
                        ]);
    
                    }
    
                    foreach ($this->quyCachPhieuXXDHKHST as $item) {
        
                        QuyCachPhieuXXDHLog::create([
        
                            'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                            'quy_cach' => $item->quy_cach,
                            'so_luong' => $item->so_luong,
                            'lot' => $item->lot,
                            'status' => 'KHST'
        
                        ]);
                    }

                    if(file_exists(storage_path('app/public/PhieuXXDH/') . $pxxdh->so_phieu . '/' . $pxxdh->so_phieu .'.docx')){

                        $templateProcessor = new TemplateProcessor(storage_path('app/public/PhieuXXDH/') . $pxxdh->so_phieu . '/' . $pxxdh->so_phieu .'.docx');

                        $values = [
        
                            'phan_hoi_qa' => $this->phanHoiQA
        
                        ];
    
                        $templateProcessor->setValues($values);
    
                        $templateProcessor->saveAs(storage_path('app/public/PhieuXXDH/') . $pxxdh->so_phieu . '/' . $pxxdh->so_phieu .'.docx');

                    }else{

                        Storage::disk('public')->makeDirectory('PhieuXXDH/' . $pxxdh->so_phieu);
    
                    $templateProcessor = new TemplateProcessor(public_path('PhieuXXDH/PXXDH.docx'));
    
                    $values = [
    
                        'date' => Carbon::create($pxxdh->date)->format('d-m-Y'),
                        'ten_cong_ty' => $pxxdh->ten_cong_ty,
                        'so' => $pxxdh->so,
                        'so_phieu' => $pxxdh->so_phieu,
                        // 'so_cone' => $pxxdh->so_cone,
                        // 'so_kg_cone' => $pxxdh->so_kg_cone,
                        // 'line' => $pxxdh->line,
                        // 'may' => $pxxdh->may,
                        // 'ngay_giao_hang' => Carbon::create($pxxdh->ngay_giao_hang)->format('d-m-Y'),
                        // 'ngay_bat_dau_giao' => Carbon::create($pxxdh->ngay_bat_dau_giao)->format('d-m-Y'),
                        // 'thanh_pham_cua_khach_hang' => $pxxdh->thanh_pham_cua_khach_hang,
                        // 'phan_anh_cua_khach_hang' => $pxxdh->phan_anh_cua_khach_hang,
                        'phan_hoi_khst' => $pxxdh->phan_hoi_khst,
                        // 'phan_hoi_qa' => $this->phanHoiQA
    
                    ];
                    // $values_table = [];
                    // $values_table_thuc_te = [];
    
                    // foreach ($this->quyCachPhieuXXDH as $item){
    
                    //     $values_table = array_merge($values_table,[
    
                    //         [
                    //             'quy_cach' => $item->quy_cach, 
                    //             'so_luong' => $item->so_luong, 
                    //             'kieu_may_det' => $item->kieu_may_det, 
                    //             'lot' => $item->lot,
                    //         ]
    
                    //     ]);
    
                    // }
    
                    // foreach ($this->quyCachPhieuXXDHKHST as $item){
    
                    //     $values_table_thuc_te = array_merge($values_table_thuc_te,[
    
                    //         [
                    //             'quy_cach_thuc_te' => $item->quy_cach, 
                    //             'so_luong_thuc_te' => $item->so_luong, 
                    //             'lot_thuc_te' => $item->lot,
                    //         ]
    
                    //     ]);
    
                    // }
    
                    // $templateProcessor->cloneRowAndSetValues('quy_cach', $values_table);
                    // $templateProcessor->cloneRowAndSetValues('quy_cach_thuc_te', $values_table_thuc_te);
    
                    if($pxxdh->don_hang_grs == '1')
                        $templateProcessor->setImageValue('im_grs', 'images/icons-checkbox.png');
                    else
                        $templateProcessor->setImageValue('im_grs', 'images/icons-square.png');
    
                    if($pxxdh->don_hang_non_grs == '1')
                        $templateProcessor->setImageValue('im_non_grs', 'images/icons-checkbox.png');
                    else
                        $templateProcessor->setImageValue('im_non_grs', 'images/icons-square.png');
    
                    if($pxxdh->don_hang_sx_moi == '1')
                        $templateProcessor->setImageValue('im_moi', 'images/icons-checkbox.png');
                    else
                        $templateProcessor->setImageValue('im_moi', 'images/icons-square.png');
    
                    if($pxxdh->don_hang_lap_lai == '1')
                        $templateProcessor->setImageValue('im_lap_lai', 'images/icons-checkbox.png');
                    else
                        $templateProcessor->setImageValue('im_lap_lai', 'images/icons-square.png');
    
                    if($pxxdh->don_hang_ton_kho == '1')
                        $templateProcessor->setImageValue('im_ton_kho', 'images/icons-checkbox.png');
                    else
                        $templateProcessor->setImageValue('im_ton_kho', 'images/icons-square.png');
    
                    $templateProcessor->setValues($values);
            
                    $templateProcessor->saveAs(storage_path('app/public/PhieuXXDH/') . $pxxdh->so_phieu . '/' . $pxxdh->so_phieu .'.docx');

                    // Tạo file excel quy cách

                    $spreadsheet = new Spreadsheet();

                    $activeWorksheet = $spreadsheet->getActiveSheet();

                    $activeWorksheet->setTitle($this->soPhieu . ' - Quy cách');

                    $activeWorksheet->setCellValue('A1', 'Quy cách');
                    $activeWorksheet->setCellValue('B1', 'Số lượng (kgs)');
                    $activeWorksheet->setCellValue('C1', 'Kiểu máy dệt + điều kiện đặc biệt của khách hàng');
                    $activeWorksheet->setCellValue('D1', 'Chạy theo TS LOT');
                    $activeWorksheet->setCellValue('E1', 'Số cone');
                    $activeWorksheet->setCellValue('F1', 'Số kg/cone');
                    $activeWorksheet->setCellValue('G1', 'Line');
                    $activeWorksheet->setCellValue('H1', 'Máy');
                    $activeWorksheet->setCellValue('I1', 'Ngày giao hàng');
                    $activeWorksheet->setCellValue('J1', 'Ngày bắt đầu giao (nếu có)');
                    $activeWorksheet->setCellValue('K1', 'Thông tin đóng gói');
                    $activeWorksheet->setCellValue('L1', 'Pallet');
                    $activeWorksheet->setCellValue('M1', 'Recycle');

                    $currentRow = 2;

                    foreach ($this->quyCachPhieuXXDH as $item){
    
                        $activeWorksheet->setCellValue('A' . $currentRow, $item->quy_cach);
                        $activeWorksheet->setCellValue('B' . $currentRow, $item->so_luong);
                        $activeWorksheet->setCellValue('C' . $currentRow, $item->kieu_may_det);
                        $activeWorksheet->setCellValue('D' . $currentRow, $item->lot);
                        $activeWorksheet->setCellValue('E' . $currentRow, $item->so_cone);
                        $activeWorksheet->setCellValue('F' . $currentRow, $item->so_kg_cone);
                        $activeWorksheet->setCellValue('G' . $currentRow, $item->line);
                        $activeWorksheet->setCellValue('H' . $currentRow, $item->may);
                        $activeWorksheet->setCellValue('I' . $currentRow, $item->ngay_giao_hang);
                        $activeWorksheet->setCellValue('J' . $currentRow, $item->ngay_bat_dau_giao);
                        $activeWorksheet->setCellValue('K' . $currentRow, $item->thong_tin_dong_goi);
                        $activeWorksheet->setCellValue('L' . $currentRow, $item->pallet);
                        $activeWorksheet->setCellValue('M' . $currentRow, $item->recycle);

                        $currentRow = $currentRow + 1;
    
                    }

                    $activeWorksheet->setCellValue('A' . $currentRow + 1, 'Quy cách');
                    $activeWorksheet->setCellValue('B' . $currentRow + 1, 'Số lượng (kgs)');
                    $activeWorksheet->setCellValue('C' . $currentRow + 1, 'Kiểu máy dệt + điều kiện đặc biệt của khách hàng');

                    $currentRow = $currentRow + 2;
    
                    foreach ($this->quyCachPhieuXXDHKHST as $item2){
    
                        $activeWorksheet->setCellValue('A' . $currentRow, $item2->quy_cach);
                        $activeWorksheet->setCellValue('B' . $currentRow, $item2->so_luong);
                        $activeWorksheet->setCellValue('C' . $currentRow, $item2->kieu_may_det);

                        $currentRow = $currentRow + 1;
    
                    }

                    $activeWorksheet->setCellValue('A' . $currentRow + 1, 'Thành phẩm của khách hàng');
                    $activeWorksheet->setCellValue('B' . $currentRow + 1, 'Phản ánh của khách hàng về lot cũ');

                    $activeWorksheet->setCellValue('A' . $currentRow + 2, $pxxdh->thanh_pham_cua_khach_hang);
                    $activeWorksheet->setCellValue('B' . $currentRow + 2, $pxxdh->phan_anh_cua_khach_hang);

                    $writer = new Xlsx($spreadsheet);

                    ob_start();
                    $writer->save('php://output');
                    $content = ob_get_contents();
                    ob_end_clean();

                    Storage::disk('public')->put($this->soPhieu . '/' . $this->soPhieu . ".xlsx", $content);

                    }

                    $emailUserCreate = User::where('username', $pxxdh->created_user)->first();
    
                    Mail::to($emailUserCreate->email)->cc('luongphan@soitheky.vn')->send(new MailPhieuXXDH('QA APPROVED',$this->soPhieu, Auth::user()->username, $PhieuXXDHLog->updated_at, ''));
    
                    flash()->addFlash('success', 'Duyệt thành công phiếu : ' . $this->soPhieu,'Thông báo');
    
                    $this->emit('approvePhieuXXDHModal');
    
                    $this->resetInputField();
    
                }elseif($pxxdh->status == 'QA APPROVED'){
    
                    $pxxdh->status = 'Finish';
                    $pxxdh->updated_user = Auth::user()->username;
                    $pxxdh->finish = Auth::user()->username;
                    $pxxdh->finish_at = Carbon::now();
            
                    $pxxdh->update();
    
                    $arr = [
    
                        'so_phieu' => $pxxdh->so_phieu,
                        'loai' => $pxxdh->loai,
                        'don_hang_grs' => $pxxdh->don_hang_grs,
                        'don_hang_non_grs' => $pxxdh->don_hang_non_grs,
                        'don_hang_sx_moi' => $pxxdh->don_hang_sx_moi,
                        'don_hang_lap_lai' => $pxxdh->don_hang_lap_lai,
                        'don_hang_ton_kho' => $pxxdh->don_hang_ton_kho,
                        'date' => $pxxdh->date,
                        'ten_cong_ty' => $pxxdh->ten_cong_ty,
                        'so' => $pxxdh->so,
                        'hop_dong' => $pxxdh->hop_dong,
                        // 'so_cone' => $pxxdh->so_cone,
                        // 'so_kg_cone' => $pxxdh->so_kg_cone,
                        'qa_kien_nghi' => $pxxdh->qa_kien_nghi,
                        // 'line' => $pxxdh->line,
                        // 'may' => $pxxdh->may,
                        // 'ngay_giao_hang' => $pxxdh->ngay_giao_hang,
                        // 'ngay_bat_dau_giao' => $pxxdh->ngay_bat_dau_giao,
                        'thanh_pham_cua_khach_hang' => $pxxdh->thanh_pham_cua_khach_hang,
                        'phan_anh_cua_khach_hang' => $pxxdh->phan_anh_cua_khach_hang,
                        // 'thong_tin_dong_goi' => $pxxdh->thong_tin_dong_goi,
                        'phan_hoi_khst' => $pxxdh->phanHoiKHST,
                        'phan_hoi_qa' => $pxxdh->phanHoiQA,
                        'phan_bo_cc' => $pxxdh->cbCC,
                        'phan_bo_tb2' => $pxxdh->cbTB2,
                        'phan_bo_tb3' => $pxxdh->cbTB3,
    
                        'mail_chinh' => $pxxdh->mail_chinh,
                        'mail_phu_1' => $pxxdh->mail_phu_1,
                        'mail_phu_2' => $pxxdh->mail_phu_2,
        
                        'status' => 'Finish',
                        'created_user' => $pxxdh->created_user,
                        
                        'status_log' => 'Finish',
                        'updated_user' => Auth::user()->username,
        
                    ];
    
                    $PhieuXXDHLog = PhieuXXDHLog::create($arr);
    
                    foreach ($this->quyCachPhieuXXDH as $item) {
                        
                        QuyCachPhieuXXDHLog::create([
                            
                            'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                            'quy_cach' => $item->quy_cach,
                            'so_luong' => $item->so_luong,
                            'kieu_may_det' => $item->kieu_may_det,
                            'lot' => $item->lot,
                            'so_cone' => $item->so_cone,
                            'so_kg_cone' => $item->so_kg_cone,
                            'line' => $item->line,
                            'may' => $item->may,
                            'ngay_giao_hang' => $item->ngay_giao_hang,
                            'ngay_bat_dau_giao' => $item->ngay_bat_dau_giao,
                            //'thanh_pham_cua_khach_hang' => $item->thanh_pham_cua_khach_hang,
                            //'phan_anh_cua_khach_hang' => $item->phan_anh_cua_khach_hang,
                            'thong_tin_dong_goi' => $item->thong_tin_dong_goi,
                            'pallet' => $item->pallet,
                            'recycle' => $item->recycle,
                            'status' => 'Sale'    
                        ]);
    
                    }
    
                    foreach ($this->quyCachPhieuXXDHKHST as $item) {
        
                        QuyCachPhieuXXDHLog::create([
        
                            'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                            'quy_cach' => $item->quy_cach,
                            'so_luong' => $item->so_luong,
                            'lot' => $item->lot,
                            'status' => 'KHST'
        
                        ]);
                    }
    
                    SO::where('so', $pxxdh->so)->update([
    
                        'status_phieu_xxdh' => '1'
                        
                    ]);

                    $cc = [];

                    if($pxxdh->mailPhu1 != null){

                        $cc = array_merge($cc, [

                            $pxxdh->mailPhu1,

                        ]);

                    }

                    if($pxxdh->mailPhu1 != null){

                        $cc = array_merge($cc, [

                            $pxxdh->mailPhu2

                        ]);

                    }
    
                    Mail::to($pxxdh->mail_chinh)
                    ->cc($cc)
                    ->send(new MailPhieuXXDH('Finish',$this->soPhieu, Auth::user()->username, $PhieuXXDHLog->updated_at, ''));
                    flash()->addFlash('success', 'Duyệt thành công phiếu : ' . $this->soPhieu,'Thông báo');
        
                    $this->resetInputField();
        
                    $this->emit('approvePhieuXXDHModal');
                }
            }

            $this->state = 'main';
            
        });
    }

    public function xacNhanPhieuXXDHModal($soPhieu){

        $this->soPhieu = $soPhieu;

        $phieuXXDH = ModelsPhieuXXDH::where('so_phieu', $soPhieu)->first();

        $this->quyCachPhieuXXDH = QuyCachPhieuXXDH::where('phieu_xxdh_so_phieu_id', $phieuXXDH->id)
        ->where('status', 'Sale')
        ->get();

        $this->quyCachPhieuXXDHKHST = QuyCachPhieuXXDH::where('phieu_xxdh_so_phieu_id', $phieuXXDH->id)
        ->where('status', 'KHST')
        ->get();

    }

    public function xacNhanPhieuXXDH(){

        $pxxdh = DB::table('phieu_xxdh')
        ->where('so_phieu', $this->soPhieu)
        ->first();

        if($pxxdh->loai == 'dht'){
            if($pxxdh->status == 'New'){

                sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                $this->emit('xacNhanPhieuXXDHModal');
                $this->resetInputField();
                return;

            }elseif($pxxdh->status == 'Sale APPROVED'){

                sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                $this->emit('xacNhanPhieuXXDHModal');
                $this->resetInputField();
                return;

            }elseif($pxxdh->status == 'SM APPROVED'){

                sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                $this->emit('xacNhanPhieuXXDHModal');
                $this->resetInputField();
                return;

            }
        }else{
            if($pxxdh->status == 'New'){

                sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                $this->emit('xacNhanPhieuXXDHModal');
                $this->resetInputField();
                return;

            }elseif($pxxdh->status == 'Sale APPROVED'){

                sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                $this->emit('xacNhanPhieuXXDHModal');
                $this->resetInputField();
                return;

            }elseif($pxxdh->status == 'SM APPROVED'){

                sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                $this->emit('xacNhanPhieuXXDHModal');
                $this->resetInputField();
                return;

            }elseif($pxxdh->status == 'QA REQUESTED'){

                sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                $this->emit('xacNhanPhieuXXDHModal');
                $this->resetInputField();
                return;

            }
        }

        DB::transaction(function(){

            DB::table('phieu_xxdh')
            ->where('so_phieu', $this->soPhieu)
            ->update([

                'xac_nhan_phan_bo' => Auth::user()->username,

            ]);

            $PXXDH = DB::table('phieu_xxdh')
            ->where('so_phieu', $this->soPhieu)
            ->first();

            $idLog = DB::table('phieu_xxdh_log')->insertGetId([

                'so_phieu' => $PXXDH->so_phieu,
                'loai' => $PXXDH->loai,
                'don_hang_grs' => $PXXDH->don_hang_grs,
                'don_hang_non_grs' => $PXXDH->don_hang_non_grs,
                'don_hang_sx_moi' => $PXXDH->don_hang_sx_moi,
                'don_hang_lap_lai' => $PXXDH->don_hang_lap_lai,
                'don_hang_ton_kho' => $PXXDH->don_hang_ton_kho,
                'date' => $PXXDH->date,
                'ten_cong_ty' => $PXXDH->ten_cong_ty,
                'so' => $PXXDH->so,
                'hop_dong' => $PXXDH->hop_dong,
                'thanh_pham_cua_khach_hang' => $PXXDH->thanh_pham_cua_khach_hang,
                'phan_anh_cua_khach_hang' => $PXXDH->phan_anh_cua_khach_hang,
                'qa_kien_nghi' => $PXXDH->qa_kien_nghi,
                'phan_hoi_khst' => $PXXDH->phan_hoi_khst,
                'phan_bo_cc' => $PXXDH->phan_bo_cc,
                'phan_bo_tb2' => $PXXDH->phan_bo_tb2,
                'phan_bo_tb3' => $PXXDH->phan_bo_tb3,
                'xac_nhan_phan_bo' => $PXXDH->xac_nhan_phan_bo,
                'phan_hoi_qa' => $PXXDH->phan_hoi_qa,
                'mail_chinh' => $PXXDH->mail_chinh,
                'mail_phu_1' => $PXXDH->mail_phu_1,
                'mail_phu_2' => $PXXDH->mail_phu_2,

                'status' => $PXXDH->status,
                'created_user' => $PXXDH->created_user,
                
                'status_log' => 'Confirm',
                'created_user' => Auth::user()->username,
                'updated_user' => Auth::user()->username,
                
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            foreach ($this->quyCachPhieuXXDH as $item) {
                            
                QuyCachPhieuXXDHLog::create([
                    
                    'phieu_xxdh_so_phieu_id_log' => $idLog,
                    'quy_cach' => $item->quy_cach,
                    'so_luong' => $item->so_luong,
                    'kieu_may_det' => $item->kieu_may_det,
                    'lot' => $item->lot,
                    'so_cone' => $item->so_cone,
                    'so_kg_cone' => $item->so_kg_cone,
                    'line' => $item->line,
                    'may' => $item->may,
                    'ngay_giao_hang' => $item->ngay_giao_hang,
                    'ngay_bat_dau_giao' => $item->ngay_bat_dau_giao,
                    'thong_tin_dong_goi' => $item->thong_tin_dong_goi,
                    'pallet' => $item->pallet,
                    'recycle' => $item->recycle,
                    'status' => 'Sale'    
                ]);

            }

            foreach ($this->quyCachPhieuXXDHKHST as $item) {

                QuyCachPhieuXXDHLog::create([

                    'phieu_xxdh_so_phieu_id_log' => $idLog,
                    'quy_cach' => $item->quy_cach,
                    'so_luong' => $item->so_luong,
                    'lot' => $item->lot,
                    'status' => 'KHST'

                ]);
            }

            flash()->addSuccess('Xác nhận thành công.');
            $this->emit('xacNhanPhieuXXDHModal');
            $this->resetInputField();

        });

    }

    public function rollBackModal($soPhieu, $status){  

        $this->checkProccess($soPhieu, 'Roll back', 'rollBackPhieuXXDHModal');

        $this->soPhieu = $soPhieu;
        $this->status = $status;

        $phieuXXDH = ModelsPhieuXXDH::where('so_phieu', $soPhieu)->first();

        $this->loaiDonHang = $phieuXXDH->loai;

        $this->quyCachPhieuXXDH = QuyCachPhieuXXDH::where('phieu_xxdh_so_phieu_id', $phieuXXDH->id)
        ->where('status', 'Sale')
        ->get();

        $this->quyCachPhieuXXDHKHST = QuyCachPhieuXXDH::where('phieu_xxdh_so_phieu_id', $phieuXXDH->id)
        ->where('status', 'KHST')
        ->get();

    }

    public function rollBack(){

        DB::transaction(function(){

            $pxxdh = ModelsPhieuXXDH::where('so_phieu', $this->soPhieu)->first();

            if($this->capRollBack == 'sale_admin'){
    
                $status = 'New';
    
            }elseif($this->capRollBack == 'sale'){
    
                $status = 'Sale APPROVED';
    
            }elseif($this->capRollBack == 'khst'){
    
                $status = 'KHST APPROVED';
    
            }elseif($this->capRollBack == 'qa'){
    
                $status = 'QA APPROVED';
    
            }elseif($this->capRollBack == 'qa_request'){
    
                $status = 'QA REQUEST';
    
            }
    
            $updatedUser = PhieuXXDHLog::where('so_phieu', $this->soPhieu)
                ->where('status', $status)
                ->select('updated_user')
                ->first();
    
            $pxxdh->status = $status;
            $pxxdh->updated_user = $updatedUser->updated_user;

            if($this->capRollBack == 'sale_admin'){
    
                $pxxdh->sale_approved = null;
                $pxxdh->sale_approved_at = null;
                $pxxdh->sm_approved = null;
                $pxxdh->sm_approved_at = null;
                $pxxdh->qa_request = null;
                $pxxdh->qa_request_at = null;
                $pxxdh->khst_approved = null;
                $pxxdh->khst_approved_at = null;
                $pxxdh->qa_approved = null;
                $pxxdh->qa_approved_at = null;
                $pxxdh->finish = null;
                $pxxdh->finish_at = null;
    
            }elseif($this->capRollBack == 'sale'){
    
                $pxxdh->sm_approved = null;
                $pxxdh->sm_approved_at = null;
                $pxxdh->qa_request = null;
                $pxxdh->qa_request_at = null;
                $pxxdh->khst_approved = null;
                $pxxdh->khst_approved_at = null;
                $pxxdh->qa_approved = null;
                $pxxdh->qa_approved_at = null;
                $pxxdh->finish = null;
                $pxxdh->finish_at = null;
    
            }elseif($this->capRollBack == 'khst'){
    
                $pxxdh->qa_approved = null;
                $pxxdh->qa_approved_at = null;
                $pxxdh->finish = null;
                $pxxdh->finish_at = null;
    
            }elseif($this->capRollBack == 'qa'){
    
                $pxxdh->finish = null;
                $pxxdh->finish_at = null;
    
            }elseif($this->capRollBack == 'qa_request'){
    
                $pxxdh->khst_approved = null;
                $pxxdh->khst_approved_at = null;
                $pxxdh->qa_approved = null;
                $pxxdh->qa_approved_at = null;
                $pxxdh->finish = null;
                $pxxdh->finish_at = null;
    
            }
    
            $pxxdh->update();
    
            $arr = [
    
                'so_phieu' => $pxxdh->so_phieu,
                'loai' => $pxxdh->loai,
                'don_hang_grs' => $pxxdh->don_hang_grs,
                'don_hang_non_grs' => $pxxdh->don_hang_non_grs,
                'don_hang_sx_moi' => $pxxdh->don_hang_sx_moi,
                'don_hang_lap_lai' => $pxxdh->don_hang_lap_lai,
                'don_hang_ton_kho' => $pxxdh->don_hang_ton_kho,
                'date' => $pxxdh->date,
                'ten_cong_ty' => $pxxdh->ten_cong_ty,
                'so' => $pxxdh->so,
                'hop_dong' => $pxxdh->hop_dong,
                // 'so_cone' => $pxxdh->so_cone,
                // 'so_kg_cone' => $pxxdh->so_kg_cone,
                // 'line' => $pxxdh->line,
                // 'may' => $pxxdh->may,
                // 'ngay_giao_hang' => $pxxdh->ngay_giao_hang,
                // 'ngay_bat_dau_giao' => $pxxdh->ngay_bat_dau_giao,
                'thanh_pham_cua_khach_hang' => $pxxdh->thanh_pham_cua_khach_hang,
                'phan_anh_cua_khach_hang' => $pxxdh->phan_anh_cua_khach_hang,
                // 'thong_tin_dong_goi' => $pxxdh->thong_tin_dong_goi,
                'phan_hoi_khst' => $pxxdh->phan_hoi_khst,
                'phan_hoi_qa' => $pxxdh->phan_hoi_qa,
                'phan_bo_cc' => $pxxdh->cbCC,
                'phan_bo_tb2' => $pxxdh->cbTB2,
                'phan_bo_tb3' => $pxxdh->cbTB3,
    
                'mail_chinh' => $pxxdh->mail_chinh,
                'mail_phu_1' => $pxxdh->mail_phu_1,
                'mail_phu_2' => $pxxdh->mail_phu_2,
    
                'status' => $status,
                'created_user' => $pxxdh->created_user,
                
                'status_log' => 'Roll back',
                'ly_do_rollback' => $this->lyDoRollback,
                'updated_user' => Auth::user()->username,
    
            ];
    
            $PhieuXXDHLog = PhieuXXDHLog::create($arr);
    
            foreach ($this->quyCachPhieuXXDH as $item) {
                        
                QuyCachPhieuXXDHLog::create([
                    
                    'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                    'quy_cach' => $item->quy_cach,
                    'so_luong' => $item->so_luong,
                    'kieu_may_det' => $item->kieu_may_det,
                    'lot' => $item->lot,
                    'so_cone' => $item->so_cone,
                    'so_kg_cone' => $item->so_kg_cone,
                    'line' => $item->line,
                    'may' => $item->may,
                    'ngay_giao_hang' => $item->ngay_giao_hang,
                    'ngay_bat_dau_giao' => $item->ngay_bat_dau_giao,
                    //'thanh_pham_cua_khach_hang' => $item->thanh_pham_cua_khach_hang,
                    //'phan_anh_cua_khach_hang' => $item->phan_anh_cua_khach_hang,
                    'thong_tin_dong_goi' => $item->thong_tin_dong_goi,
                    'pallet' => $item->pallet,
                    'recycle' => $item->recycle,
                    'status' => 'Sale'    
                ]);
    
            }
    
            foreach ($this->quyCachPhieuXXDHKHST as $item) {
    
                QuyCachPhieuXXDHLog::create([
    
                    'phieu_xxdh_so_phieu_id_log' => $PhieuXXDHLog->id,
                    'quy_cach' => $item->quy_cach,
                    'so_luong' => $item->so_luong,
                    'lot' => $item->lot,
                    'status' => 'KHST'
    
                ]);
            }

            $PXXDHLog = PhieuXXDHLog::where('so_phieu', $this->soPhieu)
            ->where('status', $status)
            ->first();

            $user = User::where('username', $PXXDHLog->updated_user)->first();

            Mail::to($user->email)->send(new MailPhieuXXDH('Rollback',$this->soPhieu, Auth::user()->username, $PhieuXXDHLog->updated_at, $this->lyDoRollback));

            flash()->addFlash('success', 'Roll back thành công phiếu : ' . $this->soPhieu,'Thông báo');

            $this->resetInputField();

            $this->emit('rollBackPhieuXXDHModal');

        });

    }

    public function downloadFileModal($soPhieu){

        $this->soPhieu = $soPhieu;
        $this->danhSachFile = Storage::disk('public')->allFiles('PhieuXXDH/' . $soPhieu . '/');

    }

    public function downloadFile($soPhieu, $tenFile){

        return response()->download(storage_path('app/public/PhieuXXDH/') . $soPhieu . '/' . $tenFile);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function search(){

        $search_fields = [
            'phieu_xxdh.so_phieu',
            'phieu_xxdh.ten_cong_ty',
            'phieu_xxdh.so',
            'phieu_xxdh.status',
            'phieu_xxdh.created_user'
        ];

        $search_terms = explode(',', $this->search);

        $query = ModelsPhieuXXDH::query();

        foreach ($search_terms as $term) {
            $query->orWhere(function ($query) use ($search_fields, $term) {

                foreach ($search_fields as $field) {
                    $query->orWhere($field, 'LIKE', '%' . trim($term) . '%');
                }
            });
        }

        $query->join(DB::raw('(select * from phieu_xxdh_quy_cach WHERE id IN (SELECT MAX(id) FROM phieu_xxdh_quy_cach GROUP BY phieu_xxdh_so_phieu_id)) as T2')
            , 'phieu_xxdh.id', 'T2.phieu_xxdh_so_phieu_id');

        $query->where('phieu_xxdh.is_delete', null);

        if($this->tuNgay == null && $this->denNgay == null){

            $query->whereBetween('phieu_xxdh.created_at', ['2023-05-01 00:00:00', '2099-01-01 00:00:00']);

        }elseif($this->tuNgay != null && $this->denNgay != null){

            $query->whereBetween('phieu_xxdh.created_at', [$this->tuNgay . ' 00:00:00', $this->denNgay . ' 23:59:59']);

        }elseif($this->tuNgay == null && $this->denNgay != null){

            $query->whereBetween('phieu_xxdh.created_at', ['2023-05-01 00:00:00', $this->denNgay . ' 23:59:59']);

        }
        elseif($this->tuNgay != null && $this->denNgay == null){

            $query->whereBetween('phieu_xxdh.created_at', [$this->tuNgay . ' 00:00:00', '2099-01-01 00:00:00']);

        }

        if($this->canhan_tatca == 'phieuDoiDuyet'){

            $query->where(function($query){

                if(Auth::user()->hasPermissionTo('create_pxxdhs')){

                    $query->orWhere(function($query){

                        $query->where('phieu_xxdh.is_delete', null);
    
                        $query->where('phieu_xxdh.created_user', '=' , Auth::user()->username);

                        $query->where(function ($query){{

                            $query->where(function($query){{

                                $query->where('phieu_xxdh.don_hang_sx_moi', '1')
                                    ->where('phieu_xxdh.status', '=' , 'QA APPROVED');

                            }})
                            ->orWhere(function($query){{

                                $query->where('phieu_xxdh.don_hang_sx_moi', '1')
                                        ->whereRaw('LENGTH(phieu_xxdh.so) = 12')
                                        ->where('phieu_xxdh.status', '=' , 'KHST APPROVED');

                            }})
                            ->orWhere(function($query){{

                                $query->where('phieu_xxdh.don_hang_ton_kho', 1)
                                        ->where('phieu_xxdh.status', '=' , 'KHST APPROVED');

                            }});
                                

                        }});

                    });

                }
                
                if(Auth::user()->hasPermissionTo('sale_approve_pxxdhs')){

                    $query->orWhere(function($query){

                        $query->where('phieu_xxdh.mail_chinh', '=' , Auth::user()->email)
                              ->orWhere('phieu_xxdh.mail_phu_1', '=' , Auth::user()->email)
                              ->orWhere('phieu_xxdh.mail_phu_2', '=' , Auth::user()->email);

                    })
                    ->where('phieu_xxdh.status', '=' , 'New');

                }
                
                if(Auth::user()->hasPermissionTo('sm_approve_pxxdhs')){
    
                    $query->orWhere(function($query){

                        $query->where('phieu_xxdh.don_hang_sx_moi', '1')
                            ->whereRaw('LENGTH(phieu_xxdh.so) = 12')
                            ->where('phieu_xxdh.status', 'Sale APPROVED');

                    });

                }
                
                if(Auth::user()->hasPermissionTo('quan_ly_khst_approve_pxxdhs')){
    
                    $query->orWhere(function($query){

                        $query->where(function($query){

                            $query->where('phieu_xxdh.don_hang_sx_moi', '1')
                                    ->where('phieu_xxdh.status', 'QA REQUESTED');
                        })
                        ->orWhere(function($query){

                            $query->where(function ($query){

                                        $query->where('phieu_xxdh.don_hang_sx_moi', 0)
                                            ->orWhereNull('phieu_xxdh.don_hang_sx_moi');

                                    })
                                    ->where('phieu_xxdh.don_hang_ton_kho', 1)
                                    ->where('phieu_xxdh.status', 'QA APPROVED');

                        });

                    });

                }
                
                if(Auth::user()->hasPermissionTo('qa_approve_pxxdhs')){
    
                    $query->orWhere(function($query){

                        $query->where(function ($query) {
                            $query->where('phieu_xxdh.status', '=' , 'Sale APPROVED')
                                    ->where('phieu_xxdh.don_hang_sx_moi', '1')
                                    ->whereRaw('LENGTH(phieu_xxdh.so) < 12');
                        })
                        ->orWhere(function ($query) {
                            $query->where('phieu_xxdh.status', '=' , 'KHST APPROVED')
                                    ->where('phieu_xxdh.don_hang_sx_moi', '1')
                                    ->whereRaw('LENGTH(phieu_xxdh.so) < 12');
                        })
                        ->orWhere(function ($query) {
                            $query->where('phieu_xxdh.status', '=' , 'SM APPROVED')
                                ->where('phieu_xxdh.don_hang_sx_moi', '1')
                                ->whereRaw('LENGTH(phieu_xxdh.so) = 12');
                        })
                        ->orWhere(function ($query) {
                            $query->where('phieu_xxdh.status', '=' , 'Sale APPROVED')
                                ->where('phieu_xxdh.don_hang_sx_moi', '1')
                                ->whereRaw('LENGTH(phieu_xxdh.so) = 12');
                        })
                        ->orWhere(function ($query) {
                            $query->where('phieu_xxdh.status', '=' , 'Sale APPROVED')
                            ->where(function ($query){

                                $query->where('phieu_xxdh.don_hang_sx_moi', 0)
                                    ->orWhereNull('phieu_xxdh.don_hang_sx_moi');

                            });
                        });

                    });

                }

                if(Auth::user()->hasRole('khst_user')){

                    $query->orWhere(function($query){

                        $query->where('phieu_xxdh.phan_bo_cc', Auth::user()->email);
                        $query->orWhere('phieu_xxdh.phan_bo_tb2', Auth::user()->email);
                        $query->orWhere('phieu_xxdh.phan_bo_tb3', Auth::user()->email);

                    });

                }

            });

        }elseif($this->canhan_tatca == 'phieuDaDuyet'){
            
            $query->where(function($query){

                $query->orWhere('sale_approved', Auth::user()->username);
                $query->orWhere('sm_approved', Auth::user()->username);
                $query->orWhere('qa_request', Auth::user()->username);
                $query->orWhere('khst_approved', Auth::user()->username);
                $query->orWhere('qa_approved', Auth::user()->username);
                $query->orWhere('finish', Auth::user()->username);

            });
        }elseif($this->canhan_tatca == 'phieuChuaPhanBo'){

            // $query->whereIn('phieu_xxdh.status', ['KHST APPROVED', 'QA APPROVED', 'Finish']);

            $query->where('phieu_xxdh.xac_nhan_phan_bo', null);

            // $query->where(function($query){

            //     $query->where('phan_bo_cc', Auth::user()->email);
            //     $query->orWhere('phan_bo_tb2', Auth::user()->email);
            //     $query->orWhere('phan_bo_tb3', Auth::user()->email);

            // });

        }elseif($this->canhan_tatca == 'phieuDaPhanBo'){

            $query->where('phieu_xxdh.xac_nhan_phan_bo', '<>', '');

            $query->where(function($query){

                $query->where('phan_bo_cc', Auth::user()->email);
                $query->orWhere('phan_bo_tb2', Auth::user()->email);
                $query->orWhere('phan_bo_tb3', Auth::user()->email);

            });

        }

        $query->select('phieu_xxdh.so_phieu', 'phieu_xxdh.loai', 'phieu_xxdh.don_hang_sx_moi', 'phieu_xxdh.don_hang_lap_lai', 'phieu_xxdh.don_hang_ton_kho' , 'phieu_xxdh.ten_cong_ty', 'phieu_xxdh.so', 
            'phieu_xxdh.hop_dong','phieu_xxdh.status', 'phieu_xxdh.mail_chinh' ,'phieu_xxdh.created_user', 'phieu_xxdh.updated_user', 'phieu_xxdh.created_at',
            'phieu_xxdh.phan_bo_cc', 'phieu_xxdh.phan_bo_tb2', 'phieu_xxdh.phan_bo_tb3', 'T2.lot')->orderBy('phieu_xxdh.created_at', 'desc');
                
        $this->search_result = $query->paginate($this->paginate);
    }

    public function checkProccess($soPhieu, $proccess, $modal){

        DB::transaction( function() use ($soPhieu, $proccess, $modal){

            $checkProccess = RealTimeProcessPhieuXXDH::where('so_phieu', $soPhieu)->first();

            if($checkProccess == null){

                RealTimeProcessPhieuXXDH::create([

                    'so_phieu' => $soPhieu,
                    'proccess' => $proccess,
                    'username' => Auth::user()->username

                ]);

            }else{

                if($checkProccess->username != Auth::user()->username){

                    flash()->addFlash('error', 'Phiếu : ' . $soPhieu . ' đang trong quá trình ' . $checkProccess->proccess . ' bởi ' . $checkProccess->username,'Thông báo');
                    $this->emit($modal);
                    return;

                }else{
                    
                    $checkProccess->delete();

                }
            }

        });

    }

    public function deleteProccess($soPhieu){

        DB::transaction( function() use ($soPhieu){

            $checkProccess = RealTimeProcessPhieuXXDH::where('so_phieu', $soPhieu)
            ->where('username', Auth::user()->username)
            ->first();

            if($checkProccess != null){

                $checkProccess->delete();

            }

        });

    }

    public function changeCaNhanTatCa(){

        $this->resetPage();

    }

    public function render()
    {

        if($this->search == ''){

            $query = ModelsPhieuXXDH::query();

            $query->join(DB::raw('(select * from phieu_xxdh_quy_cach WHERE id IN (SELECT MAX(id) FROM phieu_xxdh_quy_cach GROUP BY phieu_xxdh_so_phieu_id)) as T2')
            , 'phieu_xxdh.id', 'T2.phieu_xxdh_so_phieu_id');

            $query->where('phieu_xxdh.is_delete', null);
    
            if($this->tuNgay == null && $this->denNgay == null){

                $query->whereBetween('phieu_xxdh.created_at', ['2023-05-01 00:00:00', '2099-01-01 00:00:00']);

            }elseif($this->tuNgay != null && $this->denNgay != null){

                $query->whereBetween('phieu_xxdh.created_at', [$this->tuNgay . ' 00:00:00', $this->denNgay . ' 23:59:59']);

            }elseif($this->tuNgay == null && $this->denNgay != null){

                $query->whereBetween('phieu_xxdh.created_at', ['2023-05-01 00:00:00', $this->denNgay . ' 23:59:59']);

            }
            elseif($this->tuNgay != null && $this->denNgay == null){

                $query->whereBetween('phieu_xxdh.created_at', [$this->tuNgay . ' 00:00:00', '2099-01-01 00:00:00']);

            }

            if($this->canhan_tatca == 'phieuDoiDuyet'){

                $query->where(function($query){

                    if(Auth::user()->hasPermissionTo('create_pxxdhs')){

                        $query->orWhere(function($query){

                            $query->where('phieu_xxdh.is_delete', null);
        
                            $query->where('phieu_xxdh.created_user', '=' , Auth::user()->username);

                            $query->where(function ($query){{

                                $query->where(function($query){{

                                    $query->where('phieu_xxdh.don_hang_sx_moi', '1')
                                        ->where('phieu_xxdh.status', '=' , 'QA APPROVED');

                                }})
                                ->orWhere(function($query){{

                                    $query->where('phieu_xxdh.don_hang_sx_moi', '1')
                                            ->whereRaw('LENGTH(phieu_xxdh.so) = 12')
                                            ->where('phieu_xxdh.status', '=' , 'KHST APPROVED');

                                }})
                                ->orWhere(function($query){{

                                    $query->where('phieu_xxdh.don_hang_ton_kho', '1')
                                            ->where('phieu_xxdh.don_hang_sx_moi', '!=', '1')
                                            ->where('phieu_xxdh.status', '=' , 'KHST APPROVED');

                                }});
                                    

                            }});

                        });
    
                    }
                    
                    if(Auth::user()->hasPermissionTo('sale_approve_pxxdhs')){
    
                        $query->orWhere(function($query){

                            $query->where('phieu_xxdh.mail_chinh', '=' , Auth::user()->email)
                                  ->orWhere('phieu_xxdh.mail_phu_1', '=' , Auth::user()->email)
                                  ->orWhere('phieu_xxdh.mail_phu_2', '=' , Auth::user()->email);

                        })
                        ->where('phieu_xxdh.status', '=' , 'New');
    
                    }
                    
                    if(Auth::user()->hasPermissionTo('sm_approve_pxxdhs')){
        
                        $query->orWhere(function($query){

                            $query->where('phieu_xxdh.don_hang_sx_moi', '1')
                                ->whereRaw('LENGTH(phieu_xxdh.so) = 12')
                                ->where('phieu_xxdh.status', 'Sale APPROVED');

                        });
    
                    }
                    
                    if(Auth::user()->hasPermissionTo('quan_ly_khst_approve_pxxdhs')){
        
                        $query->orWhere(function($query){

                            $query->where(function($query){

                                $query->where('phieu_xxdh.don_hang_sx_moi', '1')
                                        ->where('phieu_xxdh.status', 'QA REQUESTED');
                            })
                            ->orWhere(function($query){

                                $query->where(function ($query){

                                            $query->where('phieu_xxdh.don_hang_sx_moi', 0)
                                                ->orWhereNull('phieu_xxdh.don_hang_sx_moi');

                                        })
                                        ->where('phieu_xxdh.don_hang_ton_kho', 1)
                                        ->where('phieu_xxdh.status', 'QA APPROVED');

                            });

                        });
    
                    }
                    
                    if(Auth::user()->hasPermissionTo('qa_approve_pxxdhs')){
        
                        $query->orWhere(function($query){

                            $query->where(function ($query) {
                                $query->where('phieu_xxdh.status', '=' , 'Sale APPROVED')
                                        ->where('phieu_xxdh.don_hang_sx_moi', '1')
                                        ->whereRaw('LENGTH(phieu_xxdh.so) < 12');
                            })
                            ->orWhere(function ($query) {
                                $query->where('phieu_xxdh.status', '=' , 'KHST APPROVED')
                                        ->where('phieu_xxdh.don_hang_sx_moi', '1')
                                        ->whereRaw('LENGTH(phieu_xxdh.so) < 12');
                            })
                            ->orWhere(function ($query) {
                                $query->where('phieu_xxdh.status', '=' , 'SM APPROVED')
                                    ->where('phieu_xxdh.don_hang_sx_moi', '1')
                                    ->whereRaw('LENGTH(phieu_xxdh.so) = 12');
                            })
                            ->orWhere(function ($query) {
                                $query->where('phieu_xxdh.status', '=' , 'Sale APPROVED')
                                    ->where('phieu_xxdh.don_hang_sx_moi', '1')
                                    ->whereRaw('LENGTH(phieu_xxdh.so) = 12');
                            })
                            ->orWhere(function ($query) {
                                $query->where('phieu_xxdh.status', '=' , 'Sale APPROVED')
                                ->where(function ($query){

                                    $query->where('phieu_xxdh.don_hang_sx_moi', 0)
                                        ->orWhereNull('phieu_xxdh.don_hang_sx_moi');

                                });
                            });

                        });
    
                    }

                    if(Auth::user()->hasRole('khst_user')){

                        $query->orWhere(function($query){

                            $query->where('phieu_xxdh.phan_bo_cc', Auth::user()->email);
                            $query->orWhere('phieu_xxdh.phan_bo_tb2', Auth::user()->email);
                            $query->orWhere('phieu_xxdh.phan_bo_tb3', Auth::user()->email);

                        });

                    }

                });

            }elseif($this->canhan_tatca == 'phieuDaDuyet'){
                
                $query->where(function($query){

                    $query->orWhere('sale_approved', Auth::user()->username);
                    $query->orWhere('sm_approved', Auth::user()->username);
                    $query->orWhere('qa_request', Auth::user()->username);
                    $query->orWhere('khst_approved', Auth::user()->username);
                    $query->orWhere('qa_approved', Auth::user()->username);
                    $query->orWhere('finish', Auth::user()->username);

                });
            }elseif($this->canhan_tatca == 'phieuChuaPhanBo'){

                // $query->whereIn('phieu_xxdh.status', ['KHST APPROVED', 'QA APPROVED', 'Finish']);

                $query->where('phieu_xxdh.xac_nhan_phan_bo', null);

                // $query->where(function($query){

                //     $query->where('phan_bo_cc', Auth::user()->email);
                //     $query->orWhere('phan_bo_tb2', Auth::user()->email);
                //     $query->orWhere('phan_bo_tb3', Auth::user()->email);

                // });

            }elseif($this->canhan_tatca == 'phieuDaPhanBo'){

                $query->where('phieu_xxdh.xac_nhan_phan_bo', '<>', '');

                $query->where(function($query){

                    $query->where('phan_bo_cc', Auth::user()->email);
                    $query->orWhere('phan_bo_tb2', Auth::user()->email);
                    $query->orWhere('phan_bo_tb3', Auth::user()->email);

                });

            }

            $query->select('phieu_xxdh.so_phieu', 'phieu_xxdh.loai', 'phieu_xxdh.don_hang_sx_moi', 'phieu_xxdh.don_hang_lap_lai', 'phieu_xxdh.don_hang_ton_kho' , 'phieu_xxdh.ten_cong_ty', 'phieu_xxdh.so', 
            'phieu_xxdh.hop_dong','phieu_xxdh.status', 'phieu_xxdh.mail_chinh' ,'phieu_xxdh.created_user', 'phieu_xxdh.updated_user', 'phieu_xxdh.created_at',
            'phieu_xxdh.phan_bo_cc', 'phieu_xxdh.phan_bo_tb2', 'phieu_xxdh.phan_bo_tb3', 'T2.lot')->orderBy('phieu_xxdh.created_at', 'desc');

            $danhSachPhieuXXDH = $query->paginate($this->paginate);

        }else{

            $this->search();
            $danhSachPhieuXXDH = $this->search_result;

        }

        // $danhSachMail = User::select('name','email')->where('phong_ban', 'sale')->get();

        $danhSachMail = User::permission('sale_approve_pxxdhs')->get();

        $danhSachSO7 = SO7::select('VBELN')
        ->distinct()
        ->orderByDesc('VBELN')
        ->take(100)
        ->whereNotIn('VBELN', SO::select('so')->get()->toArray())
        ->get();

        return view('livewire.phieu-x-x-d-h', compact('danhSachPhieuXXDH','danhSachSO7','danhSachMail'));
    }
}
