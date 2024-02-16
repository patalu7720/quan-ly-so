<?php

namespace App\Http\Livewire;

use App\Mail\PhieuTKSX;
use App\Models\EmailQuanLy;
use App\Models\PhieuTKSX as ModelsPhieuTKSX;
use App\Models\PhieuTKSXFDY as ModelsPhieuTKSXFDY;
use App\Models\PhieuTKSXFDYLog;
use App\Models\PhieuXXDH;
use App\Models\QuyCachPhieuXXDH;
use App\Models\RealTimeProcessPhieuTKSX;
use App\Models\SO;
use App\Models\User;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use PhpOffice\PhpWord\TemplateProcessor;
use Livewire\WithPagination;

class PhieuTKSXFDY extends Component
{

    public $canhan_tatca, $theodon_dukien;
    
    public $soPhieu, $soSO, $line, $sale, $thongTinDoiMa, $ngayDuDinhThayDoi, $quyCachCu, $quyCachMoi, $lotCu, $lotMoi, $trongLuong1, $trongLuong2, $mauOng1, $mauOng2, $chip1, $chip2, $dau1, $dau2, $doan1, $doan2, $thongTinKhac, $khachHang, $soLuong, $ghiChu, $qaKienNghi;

    public $status, $tuNgay, $denNgay, $search, $search_result, $paginate;

    public $capRollBack, $lyDoRollback;

    use WithPagination;

    public $log;

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public $arrLog = [];

    public function mount(){

        $this->paginate = 15;
        $this->canhan_tatca = 'phieuDoiDuyet';
        $this->theodon_dukien = 'phieuTheoDon';

    }

    public function resetInputField(){

        $this->deleteProccess($this->soPhieu);

        $this->log = '';
        $this->soPhieu = '';
        $this->soSO = '';
        $this->line = '';
        $this->sale = '';
        $this->thongTinDoiMa = '';
        $this->ngayDuDinhThayDoi = '';
        $this->quyCachCu = '';
        $this->quyCachMoi = '';
        $this->lotCu = '';
        $this->lotMoi = '';
        $this->trongLuong1 = '';
        $this->trongLuong2 = '';
        $this->mauOng1 = '';
        $this->mauOng2 = '';
        $this->chip1 = '';
        $this->chip2 = '';
        $this->dau1 = '';
        $this->dau2 = '';
        $this->doan1 = '';
        $this->doan2 = '';
        $this->thongTinKhac = '';
        $this->khachHang = '';
        $this->soLuong = '';
        $this->ghiChu = '';
        $this->qaKienNghi = '';

    }

    public function arr(){

        $this->arrLog = [
            'so_phieu' => $this->soPhieu,
            'so' => $this->soSO,
            'line' => $this->line,
            'sale' => $this->sale,
            'thong_tin_doi_ma' => $this->thongTinDoiMa,
            'ngay_du_dinh_thay_doi' => $this->ngayDuDinhThayDoi,
            'quy_cach_cu' => $this->quyCachCu,
            'quy_cach_moi' =>$this->quyCachMoi,
            'lot_cu' => $this->lotCu,
            'lot_moi' => $this->lotMoi,
            'trong_luong_1' => $this->trongLuong1,
            'trong_luong_2'=> $this->trongLuong2,
            'mau_ong_1' => $this->mauOng1,
            'mau_ong_2' => $this->mauOng2,
            'chip_1' => $this->chip1,
            'chip_2' => $this->chip2,
            'dau_1' => $this->dau1,
            'dau_2' => $this->dau2,
            'doan_1' => $this->doan1,
            'doan_2' => $this->doan2,
            'thong_tin_khac' => $this->thongTinKhac,
            'khach_hang' => $this->khachHang,
            'so_luong' => $this->soLuong,
            'ghi_chu' => $this->ghiChu,
            'qa_kien_nghi' => $this->qaKienNghi
        ];

    }

    public function addPhieuTKSXFDY(){

        if($this->theodon_dukien == 'phieuTheoDon'){

            if(!in_array($this->soSO, ['forecast', 'Forecast', 'FC', 'fc', 'sample', 'Sample', 'B'])){

                $LaySO = PhieuXXDH::whereNotIn('status', ['New', 'Sale APPROVED'])
                ->where('so','like', '%' . $this->soSO . '%')
                ->first();

                if($LaySO == null){

                flash()->addFlash('error', 'Không tìm thấy thông tin SO : ' . $this->soSO,'Thông báo');
                return;

                }

            }

        }

        DB::transaction( function(){

            $this->soPhieu = IdGenerator::generate(['table' => 'phieu_tksx_fdy', 'field' => 'so_phieu', 'length' => '15', 'prefix' => 'FDY-TB/' . Carbon::now()->isoFormat('MMYY') . '-','reset_on_prefix_change' => true]);
            
            $this->arr();

            $arr1 = array_merge($this->arrLog,[
                'status' => 'New',
                'created_user' => Auth::user()->username,
                'updated_user' => Auth::user()->username,
                'new' => Auth::user()->username,
                'new_at' => Carbon::now(),

            ]);

            ModelsPhieuTKSXFDY::create($arr1);

            $arr2 = array_merge($this->arrLog, [

                'status' => 'New',
                'created_user' => Auth::user()->username,
                'updated_user' => Auth::user()->username,
                'status_log' => 'New',

            ]);

            PhieuTKSXFDYLog::create($arr2);

            if($this->theodon_dukien == 'phieuTheoDon'){

                if(!in_array($this->soSO, ['forecast', 'Forecast', 'FC', 'fc', 'sample', 'Sample', 'B'])){

                    $so = SO::where('so', 'like', '%' . $this->soSO . '%')->first();

                    if($so->phieu_tksx == '' || $so->phieu_tksx == null){
    
                        SO::where('so',  'like', '%' . $this->soSO . '%')->update([
    
                            'phieu_tksx' => $this->soPhieu,
                            'status_phieu_tksx' => '0'
                            
                        ]);
    
                    }elseif($so->phieu_tksx != ''){
    
                        SO::where('so',  'like', '%' . $this->soSO . '%')->update([
    
                            'phieu_tksx' =>  $so->phieu_tksx . ',' . $this->soPhieu,
                            
                        ]);
    
                    }
                }
            }

            $emailQuanLyKHST = EmailQuanLy::where('chuc_vu', 'quan_ly_khst')->first();

            Mail::to($emailQuanLyKHST->email)->later(now()->addMinutes(1), new PhieuTKSX('New',$this->soPhieu, Auth::user()->username, Carbon::now(), ''));

            flash()->addFlash('success', 'Tạo thành công phiếu : ' . $this->soPhieu,'Thông báo');
            $this->resetInputField();
            $this->emit('addPhieuTKSXFDYModal');

        });

    }

    public function viewPhieuTKSXFDYModal($soPhieu){

        $PhieuTKSX = ModelsPhieuTKSXFDY::where('so_phieu', $soPhieu)->first();

        $this->soPhieu = $PhieuTKSX->so_phieu;
        $this->soSO = $PhieuTKSX->so;
        $this->sale = $PhieuTKSX->sale;
        $this->line = $PhieuTKSX->line;
        $this->thongTinDoiMa = $PhieuTKSX->thong_tin_doi_ma;
        $this->ngayDuDinhThayDoi = $PhieuTKSX->ngay_du_dinh_thay_doi;
        $this->quyCachCu = $PhieuTKSX->quy_cach_cu;
        $this->quyCachMoi = $PhieuTKSX->quy_cach_moi;
        $this->lotCu = $PhieuTKSX->lot_cu;
        $this->lotMoi = $PhieuTKSX->lot_moi;
        $this->trongLuong1 = $PhieuTKSX->trong_luong_1;
        $this->trongLuong2 = $PhieuTKSX->trong_luong_2;
        $this->mauOng1 = $PhieuTKSX->mau_ong_1;
        $this->mauOng2 = $PhieuTKSX->mau_ong_2;
        $this->chip1 = $PhieuTKSX->chip_1;
        $this->chip2 = $PhieuTKSX->chip_2;
        $this->dau1 = $PhieuTKSX->dau_1;
        $this->dau2 = $PhieuTKSX->dau_2;
        $this->doan1 = $PhieuTKSX->doan_1;
        $this->doan2 = $PhieuTKSX->doan_2;
        $this->thongTinKhac = $PhieuTKSX->thong_tin_khac;
        $this->khachHang = $PhieuTKSX->khach_hang;
        $this->soLuong = $PhieuTKSX->so_luong;
        $this->ghiChu = $PhieuTKSX->ghi_chu;
        $this->qaKienNghi = $PhieuTKSX->qa_kien_nghi;

        $this->log = PhieuTKSXFDYLog::where('so_phieu', $soPhieu)->get();

    }

    public function editPhieuTKSXFDYModal($soPhieu){

        $PhieuTKSX = ModelsPhieuTKSXFDY::where('so_phieu', $soPhieu)->first();

        $this->soPhieu = $PhieuTKSX->so_phieu;
        $this->soSO = $PhieuTKSX->so;
        $this->sale = $PhieuTKSX->sale;
        $this->line = $PhieuTKSX->line;
        $this->thongTinDoiMa = $PhieuTKSX->thong_tin_doi_ma;
        $this->ngayDuDinhThayDoi = Carbon::create($PhieuTKSX->ngay_du_dinh_thay_doi)->isoFormat('YYYY-MM-DD');;
        $this->quyCachCu = $PhieuTKSX->quy_cach_cu;
        $this->quyCachMoi = $PhieuTKSX->quy_cach_moi;
        $this->lotCu = $PhieuTKSX->lot_cu;
        $this->lotMoi = $PhieuTKSX->lot_moi;
        $this->mauOng1 = $PhieuTKSX->mau_ong_1;
        $this->mauOng2 = $PhieuTKSX->mau_ong_2;
        $this->chip1 = $PhieuTKSX->chip1;
        $this->chip2 = $PhieuTKSX->chip2;
        $this->dau1 = $PhieuTKSX->dau1;
        $this->dau2 = $PhieuTKSX->dau2;
        $this->doan1 = $PhieuTKSX->doan1;
        $this->doan2 = $PhieuTKSX->doan2;
        $this->thongTinKhac = $PhieuTKSX->thong_tin_khac;
        $this->khachHang = $PhieuTKSX->khach_hang;
        $this->soLuong = $PhieuTKSX->so_luong;
        $this->ghiChu = $PhieuTKSX->ghi_chu;
        $this->qaKienNghi = $PhieuTKSX->qa_kien_nghi;
        $this->status = $PhieuTKSX->status;

    }

    public function updatePhieuTKSXFDY(){

        DB::transaction( function(){

            $update = ModelsPhieuTKSXFDY::where('so_phieu', $this->soPhieu)->first();

            $update->line = $this->line;
            $update->thong_tin_doi_ma = $this->thongTinDoiMa;
            $update->ngay_du_dinh_thay_doi = $this->ngayDuDinhThayDoi;
            $update->quy_cach_cu = $this->quyCachCu;
            $update->quy_cach_moi =$this->quyCachMoi;
            $update->lot_cu = $this->lotCu;
            $update->lot_moi = $this->lotMoi;
            $update->trong_luong_1 = $this->trongLuong1;
            $update->trong_luong_2= $this->trongLuong2;
            $update->mau_ong_1 = $this->mauOng1;
            $update->mau_ong_2 = $this->mauOng2;
            $update->chip_1 = $this->chip1;
            $update->chip_2 = $this->chip2;
            $update->dau_1 = $this->dau1;
            $update->dau_2 = $this->dau2;
            $update->doan_1 = $this->doan1;
            $update->doan_2 = $this->doan2;
            $update->thong_tin_khac = $this->thongTinKhac;
            $update->khach_hang = $this->khachHang;
            $update->so_luong = $this->soLuong;
            $update->ghi_chu = $this->ghiChu;
            $update->qa_kien_nghi = $this->qaKienNghi;
            $update->updated_user = Auth::user()->username;

            $update->save();

            $this->arr();

            $arr = array_merge($this->arrLog,[

                'status' => $update->status,
                'created_user' => $update->created_user,

                'status_log' => 'Update',
                'updated_user' => Auth::user()->username,

            ]);

            PhieuTKSXFDYLog::create($arr);

            flash()->addFlash('success', 'Sửa thành công phiếu : ' . $this->soPhieu,'Thông báo');
            $this->resetInputField();
            $this->emit('editPhieuTKSXFDYModal');

        });

    }

    public function deletePhieuTKSXFDYModal($soPhieu){

        $this->soPhieu = $soPhieu;

    }

    public function deletePhieuTKSXFDY(){

        DB::transaction(function(){

            $delete = ModelsPhieuTKSXFDY::where('so_phieu', $this->soPhieu)->first();

            $delete->is_delete = '1';
            $delete->updated_user = Auth::user()->username;

            $delete->save();

            $this->arr();

            $arr = array_merge($this->arrLog,[
                
                'status' => $delete->status,
                'created_user' => $delete->created_user,

                'status_log' => 'Delete',
                'updated_user' => Auth::user()->username,

                'is_delete' => '1',

            ]);

            PhieuTKSXFDYLog::create($arr);

            if($this->soSO != null){

                SO::where('so', $this->soSO)->update([

                    'phieu_mhdty' => '',
                    'status_phieu_mhdty' => ''
                    
                ]);

            }

            flash()->addFlash('success', 'Xóa thành công phiếu : ' . $this->soPhieu,'Thông báo');
            $this->resetInputField();
            $this->emit('deletePhieuTKSXFDYModal');

        });
    }

    public function approvePhieuTKSXFDYModal($soPhieu){

        $this->soPhieu = $soPhieu;

        $PhieuTKSX = ModelsPhieuTKSXFDY::where('so_phieu', $soPhieu)->first();

        $this->soPhieu = $PhieuTKSX->so_phieu;
        $this->soSO = $PhieuTKSX->so;
        $this->sale = $PhieuTKSX->sale;
        $this->line = $PhieuTKSX->line;
        $this->thongTinDoiMa = $PhieuTKSX->thong_tin_doi_ma;
        $this->ngayDuDinhThayDoi = Carbon::create($PhieuTKSX->ngay_du_dinh_thay_doi)->isoFormat('YYYY-MM-DD');;
        $this->quyCachCu = $PhieuTKSX->quy_cach_cu;
        $this->quyCachMoi = $PhieuTKSX->quy_cach_moi;
        $this->lotCu = $PhieuTKSX->lot_cu;
        $this->lotMoi = $PhieuTKSX->lot_moi;
        $this->trongLuong1 = $PhieuTKSX->trong_luong_1;
        $this->trongLuong2 = $PhieuTKSX->trong_luong_2;
        $this->mauOng1 = $PhieuTKSX->mau_ong_1;
        $this->mauOng2 = $PhieuTKSX->mau_ong_2;
        $this->chip1 = $PhieuTKSX->chip_1;
        $this->chip2 = $PhieuTKSX->chip_2;
        $this->dau1 = $PhieuTKSX->dau_1;
        $this->dau2 = $PhieuTKSX->dau_2;
        $this->doan1 = $PhieuTKSX->doan_1;
        $this->doan2 = $PhieuTKSX->doan_2;
        $this->thongTinKhac = $PhieuTKSX->thong_tin_khac;
        $this->khachHang = $PhieuTKSX->khach_hang;
        $this->soLuong = $PhieuTKSX->so_luong;
        $this->ghiChu = $PhieuTKSX->ghi_chu;
        $this->qaKienNghi = $PhieuTKSX->qa_kien_nghi;
        $this->status = $PhieuTKSX->status;

    }

    public function approvePhieuTKSXFDY(){

        DB::transaction( function(){

            $pxxdh = ModelsPhieuTKSXFDY::where('so_phieu', $this->soPhieu)->first();

            if($pxxdh->status == 'New'){

                if(!Auth::user()->hasPermissionTo('quan_ly_khst_approve_ptksx')){

                    sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                    $this->emit('approvePhieuTKSXFDYModal');
                    $this->resetInputField();
                    return;

                }

            }elseif($pxxdh->status == 'KHST APPROVED'){

                if(!Auth::user()->hasPermissionTo('qa_approve_ptksx')){

                    sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                    $this->emit('approvePhieuTKSXFDYModal');
                    $this->resetInputField();
                    return;

                }

            }elseif($pxxdh->status == 'QA APPROVED'){

                if(!Auth::user()->hasPermissionTo('sale_approve_ptksx')){

                    sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                    $this->emit('approvePhieuTKSXFDYModal');
                    $this->resetInputField();
                    return;

                }

            }elseif($pxxdh->status == 'Sale APPROVED'){

                if(!Auth::user()->hasPermissionTo('sm_approve_ptksx')){

                    sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                    $this->emit('approvePhieuTKSXFDYModal');
                    $this->resetInputField();
                    return;

                }

            }elseif($pxxdh->status == 'SM APPROVED'){

                if(!Auth::user()->hasPermissionTo('create_ptksx')){

                    sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                    $this->emit('approvePhieuTKSXFDYModal');
                    $this->resetInputField();
                    return;

                }

            }

            if($pxxdh->status == 'New'){

                $pxxdh->status = 'KHST APPROVED';
                $pxxdh->updated_user = Auth::user()->username;

                $pxxdh->khst_approved = Auth::user()->username;
                $pxxdh->khst_approved_at = Carbon::now();
        
                $pxxdh->update();

                $this->arr();
    
                $arr = array_merge($this->arrLog,[

                    'status' => 'KHST APPROVED',
                    'status_log' => 'Approve',
                    'created_user' => Auth::user()->username,
                    'updated_user' => Auth::user()->username,
    
                ]);
    
                PhieuTKSXFDYLog::create($arr);

                Mail::to('qa@soitheky.vn')->later(now()->addMinutes(1), new PhieuTKSX('KHST APPROVED',$this->soPhieu, Auth::user()->username, $pxxdh->updated_at,''));

            }elseif($pxxdh->status == 'KHST APPROVED'){

                $pxxdh->status = 'QA APPROVED';
                $pxxdh->updated_user = Auth::user()->username;
                $pxxdh->qa_kien_nghi = $this->qaKienNghi;

                $pxxdh->qa_approved = Auth::user()->username;
                $pxxdh->qa_approved_at = Carbon::now();
        
                $pxxdh->update();

                $this->arr();

                $arr = array_merge($this->arrLog,[

                    'status' => 'QA APPROVED',
                    'status_log' => 'Approve',
                    'created_user' => Auth::user()->username,
                    'updated_user' => Auth::user()->username,
    
                ]);

                PhieuTKSXFDYLog::create($arr);

                Mail::to($this->sale)->later(now()->addMinutes(1), new PhieuTKSX('QA APPROVED',$this->soPhieu, Auth::user()->username, $pxxdh->updated_at, ''));

            }elseif($pxxdh->status == 'QA APPROVED'){

                $pxxdh->status = 'Sale APPROVED';
                $pxxdh->updated_user = Auth::user()->username;

                $pxxdh->sale_approved = Auth::user()->username;
                $pxxdh->sale_approved_at = Carbon::now();
        
                $pxxdh->update();

                $this->arr();

                $arr = array_merge($this->arrLog,[

                    'status' => 'Sale APPROVED',
                    'status_log' => 'Approve',
                    'created_user' => Auth::user()->username,
                    'updated_user' => Auth::user()->username,
    
                ]);

                PhieuTKSXFDYLog::create($arr);

                $emailQuanLySale = EmailQuanLy::where('chuc_vu', 'quan_ly_sale')->first();

                Mail::to($emailQuanLySale->email)->later(now()->addMinutes(1), new PhieuTKSX('Sale APPROVED',$this->soPhieu, Auth::user()->username, $pxxdh->updated_at, ''));

            }elseif($pxxdh->status == 'Sale APPROVED'){

                $pxxdh->status = 'SM APPROVED';
                $pxxdh->updated_user = Auth::user()->username;

                $pxxdh->sm_approved = Auth::user()->username;
                $pxxdh->sm_approved_at = Carbon::now();
        
                $pxxdh->update();

                $this->arr();

                $arr = array_merge($this->arrLog,[

                    'status' => 'SM APPROVED',
                    'status_log' => 'Approve',
                    'created_user' => Auth::user()->username,
                    'updated_user' => Auth::user()->username,
    
                ]);

                PhieuTKSXFDYLog::create($arr);

                $emailUserCreate = User::where('username', $pxxdh->created_user)->first();

                Mail::to($emailUserCreate->email)->later(now()->addMinutes(1), new PhieuTKSX('SM APPROVED',$this->soPhieu, Auth::user()->username, $pxxdh->updated_at, ''));

            }elseif($pxxdh->status == 'SM APPROVED'){

                $pxxdh->status = 'Finish';
                $pxxdh->updated_user = Auth::user()->username;

                $pxxdh->finish = Auth::user()->username;
                $pxxdh->finish_at = Carbon::now();
        
                $pxxdh->update();

                $this->arr();

                $arr = array_merge($this->arrLog,[

                    'status' => 'Finish',
                    'status_log' => 'Approve',
                    'created_user' => Auth::user()->username,
                    'updated_user' => Auth::user()->username,
    
                ]);

                PhieuTKSXFDYLog::create($arr);

                if($this->soSO != null){

                    $phieuXXDH = PhieuXXDH::where('so', $this->soSO)
                    ->where('don_hang_sx_moi', '1')
                    ->first();

                    if($phieuXXDH != null){

                        QuyCachPhieuXXDH::where('phieu_xxdh_so_phieu_id', $phieuXXDH->id)
                        ->where('quy_cach', 'like', '%' . $this->quyCachMoi . '%')
                        ->whereIn('lot', ['new lot', 'New lot', 'NEW LOT', 'New Lot'])
                        ->update([
                            'lot' => $this->lotMoi . ' (new lot)'
                        ]);

                    }

                    SO::where('so', $this->soSO)->update([
    
                        'status_phieu_tksx' => '1'
                        
                    ]);

                }

                //Storage::disk('public')->makeDirectory('PhieuTKSX/' . $pxxdh->so_phieu);
    
                $templateProcessor = new TemplateProcessor(public_path('PhieuTKSX/PTKSXFDY.docx'));

                $username_sale = PhieuTKSXFDYLog::where('so_phieu', $this->soPhieu)->where('status', 'Sale APPROVED')->first();

                $name_sale = User::where('username', $username_sale->updated_user)->first();

                $values = [

                    'so_phieu' => $this->soPhieu,
                    'phieu_xxdh_so_phieu' => $this->soSO,
                    'line' => $this->line,
                    'thong_tin_doi_ma' => $this->thongTinDoiMa,
                    'ngay_du_dinh_thay_doi' => Carbon::create($this->ngayDuDinhThayDoi)->isoFormat('DD.MM.YYYY'),
                    'quy_cach_cu' => $this->quyCachCu,
                    'quy_cach_moi' =>$this->quyCachMoi,
                    'lot_cu' => $this->lotCu,
                    'lot_moi' => $this->lotMoi,
                    'trong_luong_1' => $this->trongLuong1,
                    'trong_luong_2'=> $this->trongLuong2,
                    'mau_ong_1' => $this->mauOng1,
                    'mau_ong_2' => $this->mauOng2,
                    'chip_1' => $this->chip1,
                    'chip_2' => $this->chip2,
                    'dau_1' => $this->dau1,
                    'dau_2' => $this->dau2,
                    'doan_1' => $this->doan1,
                    'doan_2' => $this->doan2,
                    'thong_tin_khac' => $this->thongTinKhac,
                    'khach_hang' => $this->khachHang,
                    'so_luong' => $this->soLuong,
                    'ghi_chu' => $this->ghiChu,
                    'qa_kien_nghi' => str_replace(['"', "'", '<', '>', '&'], ['&quot;', '&apos;', '&lt;', '&gt;', '&amp;'], $this->qaKienNghi),
                    'ngay' => 'Ngày ' . Carbon::now()->isoFormat('DD') . ' tháng ' . Carbon::now()->isoFormat('MM') . ' năm ' . Carbon::now()->isoFormat('YYYY'),

                ];

                $templateProcessor->setValues($values);

                Storage::disk('public')->makeDirectory('PhieuTKSX/' . str_replace('/','_',$pxxdh->so_phieu));
            
                $templateProcessor->saveAs(storage_path('app/public/PhieuTKSX/') . str_replace('/','_',$pxxdh->so_phieu) . '/' . str_replace('/','_',$pxxdh->so_phieu) .'.docx');

                $emailQuanLyKHST = EmailQuanLy::where('chuc_vu', 'quan_ly_khst')->first();
                
                Mail::to($emailQuanLyKHST->email)->later(now()->addMinutes(1), new PhieuTKSX('Finish',$this->soPhieu, Auth::user()->username, $pxxdh->updated_at, ''));

            }

            flash()->addFlash('success', 'Duyệt thành công phiếu : ' . $this->soPhieu,'Thông báo');
            $this->emit('approvePhieuTKSXFDYModal');

        });
    }

    public function rollBackModal($soPhieu, $status){  

        $this->checkProccess($soPhieu, 'Roll back', 'rollBackPhieuTKSXFDYModal');

        $this->soPhieu = $soPhieu;
        $this->status = $status;

    }

    public function rollBack(){

        DB::transaction(function(){

            $ptksx = ModelsPhieuTKSXFDY::where('so_phieu', $this->soPhieu)->first();

            if($this->capRollBack == 'new'){
    
                $status = 'New';
    
            }elseif($this->capRollBack == 'qa'){
    
                $status = 'QA APPROVED';
    
            }
    
            $updatedUser = PhieuTKSXFDYLog::where('so_phieu', $this->soPhieu)
                ->where('status', $status)
                ->select('updated_user')
                ->first();
    
            $ptksx->status = $status;
            $ptksx->updated_user = $updatedUser->updated_user;

            if($this->capRollBack == 'new'){

                $ptksx->khst_approved = null;
                $ptksx->khst_approved_at = null;

                $ptksx->qa_approved = null;
                $ptksx->qa_approved_at = null;

                $ptksx->sale_approved = null;
                $ptksx->sale_approved_at = null;

                $ptksx->sm_approved = null;
                $ptksx->sm_approved_at = null;

                $ptksx->finish = null;
                $ptksx->finish_at = null;
    
            }elseif($this->capRollBack == 'qa'){

                $ptksx->sale_approved = null;
                $ptksx->sale_approved_at = null;

                $ptksx->sm_approved = null;
                $ptksx->sm_approved_at = null;

                $ptksx->finish = null;
                $ptksx->finish_at = null;
    
            }
    
            $ptksx->update();

            $this->arr();
    
            $arr = array_merge($this->arrLog,[

                'status' => $status,
                'status_log' => 'Roll back',
                'created_user' => Auth::user()->username,
                'updated_user' => Auth::user()->username,

            ]);
    
            $PhieuXXDHLog = PhieuTKSXFDYLog::create($arr);

            $layUser = PhieuTKSXFDYLog::where('so_phieu', $this->soPhieu)
            ->where('status', $status)
            ->first();

            $user = User::where('username', $layUser->updated_user)->first();

            Mail::to($user->email)->later(now()->addMinutes(1), new PhieuTKSX('Rollback',$this->soPhieu, Auth::user()->username, $PhieuXXDHLog->updated_at, $this->lyDoRollback));

            flash()->addFlash('success', 'Roll back thành công phiếu : ' . $this->soPhieu,'Thông báo');

            $this->resetInputField();

            $this->emit('rollBackPhieuTKSXFDYModal');

        });

    }

    public function checkProccess($soPhieu, $proccess, $modal){

        DB::transaction( function() use ($soPhieu, $proccess, $modal){

            $checkProccess = RealTimeProcessPhieuTKSX::where('so_phieu', $soPhieu)->first();

            if($checkProccess == null){

                RealTimeProcessPhieuTKSX::create([

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

            $checkProccess = RealTimeProcessPhieuTKSX::where('so_phieu', $soPhieu)
            ->where('username', Auth::user()->username)
            ->first();

            if($checkProccess != null){

                $checkProccess->delete();

            }

        });

    }

    public function downloadFile($soPhieu){

        return response()->download(storage_path('app/public/PhieuTKSX/') . str_replace('/','_',$soPhieu) . '/' . str_replace('/','_',$soPhieu) . '.docx');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updateSoModal($soPhieu){

        $this->soPhieu = $soPhieu;

    }

    public function updateSo(){

        $LaySO = PhieuXXDH::whereNotIn('status', ['New', 'Sale APPROVED'])
                                ->where('so','like', '%' . $this->soSO . '%')
                                ->first();

        if($LaySO == null){

            sweetalert()->addError('Không tìm thấy thông tin SO : ' . $this->soSO,'Thông báo');
            return;

        }

        DB::table('phieu_tksx_fdy')
        ->where('so_phieu', $this->soPhieu)
        ->update([

            'so' => $this->soSO

        ]);

        $so = SO::where('so', 'like', '%' . $this->soSO . '%')->first();

        if($so->phieu_tksx == '' || $so->phieu_tksx == null){

            SO::where('so',  'like', '%' . $this->soSO . '%')->update([

                'phieu_tksx' => $this->soPhieu,
                'status_phieu_tksx' => '0'
                
            ]);

        }elseif($so->phieu_tksx != ''){

            SO::where('so',  'like', '%' . $this->soSO . '%')->update([

                'phieu_tksx' =>  $so->phieu_tksx . ',' . $this->soPhieu,
                
            ]);

        }
    }

    public function changeCaNhanTatCa(){

        $this->resetPage();

    }

    public function render()
    {
        if($this->search == ''){

            $query = ModelsPhieuTKSXFDY::query();

            $query->where('phieu_tksx_fdy.is_delete', null);

            if($this->tuNgay == null && $this->denNgay == null){

                $query->whereBetween('phieu_tksx_fdy.created_at', ['2023-05-01 00:00:00', '2099-01-01 00:00:00']);

            }elseif($this->tuNgay != null && $this->denNgay != null){

                $query->whereBetween('phieu_tksx_fdy.created_at', [$this->tuNgay . ' 00:00:00', $this->denNgay . ' 23:59:59']);

            }elseif($this->tuNgay == null && $this->denNgay != null){

                $query->whereBetween('phieu_tksx_fdy.created_at', ['2023-05-01 00:00:00', $this->denNgay . ' 23:59:59']);

            }
            elseif($this->tuNgay != null && $this->denNgay == null){

                $query->whereBetween('phieu_tksx_fdy.created_at', [$this->tuNgay . ' 00:00:00', '2099-01-01 00:00:00']);

            }

            if($this->canhan_tatca == 'phieuDoiDuyet'){

                $query->where(function($query){
    
                    if(Auth::user()->hasPermissionTo('create_ptksx')){
    
                        $query->orWhere(function($query){
    
                            $query->where('phieu_tksx_fdy.created_user', '=' , Auth::user()->username);
    
                            $query->where('phieu_tksx_fdy.status' , 'SM APPROVED');
    
                        });
                    }
    
                    if(Auth::user()->hasPermissionTo('quan_ly_khst_approve_ptksx')){
    
                        $query->orWhere(function($query){
    
                            $query->where('phieu_tksx_fdy.status', 'New');
    
                        });
                    }
    
                    if(Auth::user()->hasPermissionTo('qa_approve_ptksx')){
    
                        $query->orWhere(function($query){
    
                            $query->where('phieu_tksx_fdy.status', 'KHST APPROVED');
    
                        });
                    }
    
                    if(Auth::user()->hasPermissionTo('sale_approve_ptksx')){
                        
                        $query->orWhere(function($query){
    
                            $query->where('phieu_tksx_fdy.status', 'QA APPROVED');
                            $query->where('phieu_tksx_fdy.sale', Auth::user()->email);
    
                        });        
    
                    }
    
                    if(Auth::user()->hasPermissionTo('sm_approve_ptksx')){
    
                        $query->orWhere(function($query){
    
                            $query->where('phieu_tksx_fdy.status', 'Sale APPROVED');  
    
                        });   
    
                    }
    
                });
    
            }elseif($this->canhan_tatca == 'phieuDaDuyet'){
    
                $query->where(function($query){
    
                    $query->orWhere('khst_approved', Auth::user()->username);
                    $query->orWhere('qa_approved', Auth::user()->username);
                    $query->orWhere('sale_approved', Auth::user()->username);
                    $query->orWhere('sm_approved', Auth::user()->username);
                    $query->orWhere('finish', Auth::user()->username);
    
                });
    
            }
            
            $ptksxfdy = $query->paginate($this->paginate);

        }else{

            $search_fields = [
                'phieu_tksx_fdy.so_phieu',
                'phieu_tksx_fdy.khach_hang',
                'phieu_tksx_fdy.created_user',
                'phieu_tksx_fdy.status'
            ];
    
            $search_terms = explode(',', $this->search);
    
            $query = ModelsPhieuTKSXFDY::query();
    
            foreach ($search_terms as $term) {
                $query->orWhere(function ($query) use ($search_fields, $term) {
    
                    foreach ($search_fields as $field) {
                        $query->orWhere($field, 'LIKE', '%' . trim($term) . '%');
                    }
                });
            }
    
            if($this->tuNgay == null && $this->denNgay == null){
    
                $query->whereBetween('phieu_tksx_fdy.created_at', ['2023-05-01 00:00:00', '2099-01-01 00:00:00']);
    
            }elseif($this->tuNgay != null && $this->denNgay != null){
                $query->whereBetween('phieu_tksx_fdy.created_at', [$this->tuNgay . ' 00:00:00', $this->denNgay . ' 23:59:59']);
    
            }elseif($this->tuNgay == null && $this->denNgay != null){
                $query->whereBetween('phieu_tksx_fdy.created_at', ['2023-05-01 00:00:00', $this->denNgay . ' 23:59:59']);
    
            }
            elseif($this->tuNgay != null && $this->denNgay == null){
                $query->whereBetween('phieu_tksx_fdy.created_at', [$this->tuNgay . ' 00:00:00', '2099-01-01 00:00:00']);
    
            }
    
            $query->where('phieu_tksx_fdy.is_delete', null);
    
            if($this->canhan_tatca == 'phieuDoiDuyet'){
    
                $query->where(function($query){
    
                    if(Auth::user()->hasPermissionTo('create_ptksx')){
    
                        $query->orWhere(function($query){
    
                            $query->where('phieu_tksx_fdy.created_user', '=' , Auth::user()->username);
    
                            $query->where('phieu_tksx_fdy.status' , 'SM APPROVED');
    
                        });
                    }
    
                    if(Auth::user()->hasPermissionTo('quan_ly_khst_approve_ptksx')){
    
                        $query->orWhere(function($query){
    
                            $query->where('phieu_tksx_fdy.status', 'New');
    
                        });
                    }
    
                    if(Auth::user()->hasPermissionTo('qa_approve_ptksx')){
    
                        $query->orWhere(function($query){
    
                            $query->where('phieu_tksx_fdy.status', 'KHST APPROVED');
    
                        });
                    }
    
                    if(Auth::user()->hasPermissionTo('sale_approve_ptksx')){
                        
                        $query->orWhere(function($query){
    
                            $query->where('phieu_tksx_fdy.status', 'QA APPROVED');
                            $query->where('phieu_tksx_fdy.sale', Auth::user()->email);
    
                        });        
    
                    }
    
                    if(Auth::user()->hasPermissionTo('sm_approve_ptksx')){
    
                        $query->orWhere(function($query){
    
                            $query->where('phieu_tksx_fdy.status', 'Sale APPROVED');  
    
                        });   
    
                    }
    
                });
    
            }elseif($this->canhan_tatca == 'phieuDaDuyet'){
    
                $query->where(function($query){
    
                    $query->orWhere('khst_approved', Auth::user()->username);
                    $query->orWhere('qa_approved', Auth::user()->username);
                    $query->orWhere('sale_approved', Auth::user()->username);
                    $query->orWhere('sm_approved', Auth::user()->username);
                    $query->orWhere('finish', Auth::user()->username);
    
                });
    
            }
    
            $ptksxfdy = $query->paginate($this->paginate);

        }

        $danhSachMail = User::permission('sale_approve_ptksx')->get();

        // if($this->soSO != ''){

        //     $mailSale = PhieuXXDH::where('so_phieu', $this->soSO)->first();

        //     $this->sale = $mailSale->mail_chinh;

        // }

        $arr = ModelsPhieuTKSXFDY::where('so', '<>', '')
                            ->whereNull('is_delete')
                            ->select('so')
                            ->get()
                            ->toArray();

        $danhSachSO = PhieuXXDH::whereNotIn('status', ['New', 'Sale APPROVED'])
                                        ->whereNotIn('so', $arr)
                                        ->get();

        return view('livewire.phieu-t-k-s-x-f-d-y',compact('ptksxfdy','danhSachSO','danhSachMail'));
    }
}
