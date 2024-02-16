<?php

namespace App\Http\Livewire;

use App\Mail\PhieuMHDTY;
use App\Mail\PhieuTKSX as MailPhieuTKSX;
use App\Mail\PhieuXXDH as MailPhieuXXDH;
use App\Models\EmailQuanLy;
use App\Models\PhieuTBTDMHDTY;
use App\Models\PhieuTBTDMHDTYLog;
use App\Models\PhieuTKSX;
use App\Models\PhieuTKSXLog;
use App\Models\PhieuXXDH;
use App\Models\QuyCachPhieuXXDH;
use App\Models\RealTimeProcessPhieuTKSX;
use App\Models\SO;
use App\Models\SOTam;
use App\Models\TheoDoiSXDTY;
use App\Models\TheoDoiSXDTYLog;
use App\Models\User;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use PhpOffice\PhpWord\TemplateProcessor;

class PhieuThayDoiMaHang extends Component
{   
    public $canhan_tatca, $theodon_dukien;

    public $soPhieu, $soSO, $sale, $soMay, $mat, $quyCach, $maHang, $ngay, $mauOng, $quyCachPOY, $maPOY, $quyCachDTY, $maDTY, $tenCongTy, $loaiHang, $soLuongDonHang, $ghiChuSoLuong, $dieuKienKhachHang, $status;

    public $danhSachPhieuXXDH, $qaKienNghi;

    public $thongTinDoiMa, $soi, $maCuMoi;

    public $paginate;

    public $search, $tuNgay, $denNgay, $capRollBack;

    protected $search_result;

    public $log, $danhSachDieuKienKhachHang, $dieuKienKhachHangSelect;

    public $lyDoRollback, $noteReject;

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

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
        $this->sale = '';
        $this->soMay = '';
        $this->mat = '';
        $this->quyCach = '';
        $this->maHang = '';
        $this->ngay = '';
        $this->mauOng = '';
        $this->quyCachPOY = '';
        $this->maPOY = '';
        $this->quyCachDTY = '';
        $this->maDTY = '';
        $this->tenCongTy = '';
        $this->loaiHang = '';
        $this->soLuongDonHang = '';
        $this->ghiChuSoLuong = '';
        $this->dieuKienKhachHang = '';
        $this->status = '';
        $this->qaKienNghi = '';
        $this->thongTinDoiMa = '';
        $this->soi = '';
        $this->maCuMoi = '';
        $this->danhSachDieuKienKhachHang = '';
        $this->dieuKienKhachHangSelect = '';
        $this->lyDoRollback = '';

    }

    public function addPhieuMHDTY(){

        if($this->theodon_dukien == 'phieuTheoDon'){

            // $arraySO = explode(',')

            $LaySO = PhieuXXDH::where('so', $this->soSO)->first();

            if($LaySO == null){

                flash()->addFlash('error', 'Không tìm thấy thông tin SO : ' . $this->soSO,'Thông báo');
                $this->resetInputField();
                return;

            }
        }

        DB::transaction( function(){

            if($this->soMay <= 16){

                $nhamay = 'CC';

            }elseif($this->soMay <= 34 || in_array($this->soMay, [35,54,55,56,57])){

                $nhamay = 'TB2';

            }else{

                $nhamay = 'TB3';

            }

            $this->soPhieu = IdGenerator::generate(['table' => 'phieu_tksx', 'field' => 'so_phieu', 'length' => '15', 'prefix' => 'DTY-' . $nhamay . '/' . Carbon::now()->isoFormat('MMYY') . '-','reset_on_prefix_change' => true]);

            $arr = [

                'so_phieu' => $this->soPhieu,
                'so' => $this->soSO,
                'sale' => $this->sale,
                'may' => $this->soMay . $this->mat,
                'quy_cach' => $this->quyCach,
                'ma' => $this->maHang,
                'ngay' => $this->ngay,
                'thong_tin_doi_ma' => $this->thongTinDoiMa,
                'mau_ong' => $this->mauOng,
                'soi' => $this->soi,
                'ma_cu_moi' => $this->maCuMoi,
                'quy_cach_poy' => $this->quyCachPOY,
                'ma_poy' => $this->maPOY,
                'quy_cach_dty' => $this->quyCachDTY,
                'ma_dty' => $this->maDTY,
                'khach_hang' => $this->tenCongTy,
                'loai_hang' => $this->loaiHang,
                'so_luong_don_hang' => $this->soLuongDonHang,
                'ghi_chu_so_luong' => $this->ghiChuSoLuong,
                'dieu_kien_khach_hang' => $this->dieuKienKhachHang,
                'status' => 'New',
                'new' => Auth::user()->username,
                'new_at' => Carbon::now(),
                'created_user' => Auth::user()->username,
                'updated_user' => Auth::user()->username,

            ];

            PhieuTKSX::create($arr);

            $arr = array_merge($arr, [

                'status_log' => 'New',

            ]);

            PhieuTKSXLog::create($arr);

            if($this->theodon_dukien == 'phieuTheoDon'){

                $so = SO::where('so', $this->soSO)->first();

                if($so->phieu_tksx == '' || $so->phieu_tksx == null){

                    SO::where('so', $this->soSO)->update([

                        'phieu_tksx' => $this->soPhieu,
                        'status_phieu_tksx' => '0'
                        
                    ]);

                }elseif($so->phieu_tksx != ''){

                    SO::where('so', $this->soSO)->update([

                        'phieu_tksx' =>  $so->phieu_tksx . ',' . $this->soPhieu,
                        
                    ]);

                }

                $laySoTam = SOTam::where('so_tam', $this->soSO)->first();

                if($laySoTam != null){

                    if($laySoTam->so_phieu_tksx != '')
                        $laySoTam->so_phieu_tksx = $laySoTam->so_phieu_tksx . ',' . $this->soPhieu;
                    else
                        $laySoTam->so_phieu_tksx = $this->soPhieu;
                    $laySoTam->save();

                    $idPXXDH = PhieuXXDH::where('so_phieu', $laySoTam->so_phieu_xxdh)->first();
    
                    $layQuyCachPXXDH = QuyCachPhieuXXDH::where('phieu_xxdh_so_phieu_id', $idPXXDH->id)->get();
        
                    foreach ($layQuyCachPXXDH as $item) {
                        
                        if(strtoupper($item->lot) == 'NEW LOT'){
        
                            $item->lot_chinh_thuc = $this->maDTY;
        
                            $item->save();
                        }
        
                    }

                } 
            }

            $emailQuanLyKHST = EmailQuanLy::where('chuc_vu', 'quan_ly_khst')->first();

            Mail::to($emailQuanLyKHST->email)->cc('loanpham@soitheky.vn')->later(now()->addMinutes(1), new MailPhieuTKSX('New',$this->soPhieu, Auth::user()->username, Carbon::now(),''));

            flash()->addFlash('success', 'Tạo thành công phiếu : ' . $this->soPhieu,'Thông báo');
            $this->resetInputField();
            $this->emit('addPhieuMHDTYModal');

        });

    }

    public function viewPhieuMHDTYModal($soPhieu){

        $PhieuTKSX = PhieuTKSX::where('so_phieu', $soPhieu)->first();

        $this->soPhieu = $PhieuTKSX->so_phieu;
        $this->soSO = $PhieuTKSX->so;
        $this->sale = $PhieuTKSX->sale;
        $this->soMay = $PhieuTKSX->may;
        $this->quyCach = $PhieuTKSX->quy_cach;
        $this->maHang = $PhieuTKSX->ma;
        $this->ngay = $PhieuTKSX->ngay;
        $this->thongTinDoiMa = $PhieuTKSX->thong_tin_doi_ma;
        $this->mauOng = $PhieuTKSX->mau_ong;
        $this->soi = $PhieuTKSX->soi;
        $this->maCuMoi = $PhieuTKSX->ma_cu_moi;
        $this->quyCachPOY = $PhieuTKSX->quy_cach_poy;
        $this->maPOY = $PhieuTKSX->ma_poy;
        $this->quyCachDTY = $PhieuTKSX->quy_cach_dty;
        $this->maDTY = $PhieuTKSX->ma_dty;
        $this->tenCongTy = $PhieuTKSX->khach_hang;
        $this->loaiHang = $PhieuTKSX->loai_hang;
        $this->soLuongDonHang = $PhieuTKSX->so_luong_don_hang;
        $this->ghiChuSoLuong = $PhieuTKSX->ghi_chu_so_luong;
        $this->dieuKienKhachHang = $PhieuTKSX->dieu_kien_khach_hang;
        $this->qaKienNghi = $PhieuTKSX->qa_kien_nghi;
        $this->status = $PhieuTKSX->status;

        $this->log = PhieuTKSXLog::where('so_phieu', $soPhieu)->get();

    }

    public function editPhieuMHDTYModal($soPhieu){

        $PhieuTKSX = PhieuTKSX::where('so_phieu', $soPhieu)->first();

        $this->soPhieu = $PhieuTKSX->so_phieu;
        $this->soSO = $PhieuTKSX->so;
        $this->sale = $PhieuTKSX->sale;
        $this->soMay = $PhieuTKSX->may;
        $this->quyCach = $PhieuTKSX->quy_cach;
        $this->maHang = $PhieuTKSX->ma;
        $this->ngay = Carbon::create($PhieuTKSX->ngay)->isoFormat('YYYY-MM-DD');
        $this->mauOng = $PhieuTKSX->mau_ong;
        $this->quyCachPOY = $PhieuTKSX->quy_cach_poy;
        $this->maPOY = $PhieuTKSX->ma_poy;
        $this->quyCachDTY = $PhieuTKSX->quy_cach_dty;
        $this->maDTY = $PhieuTKSX->ma_dty;
        $this->tenCongTy = $PhieuTKSX->khach_hang;
        $this->loaiHang = $PhieuTKSX->loai_hang;
        $this->soLuongDonHang = $PhieuTKSX->so_luong_don_hang;
        $this->ghiChuSoLuong = $PhieuTKSX->ghi_chu_so_luong;
        $this->dieuKienKhachHang = $PhieuTKSX->dieu_kien_khach_hang;
        $this->status = $PhieuTKSX->status;
        $this->qaKienNghi = $PhieuTKSX->qa_kien_nghi;

        $this->thongTinDoiMa = $PhieuTKSX->thong_tin_doi_ma;
        $this->soi = $PhieuTKSX->soi;
        $this->maCuMoi = $PhieuTKSX->ma_cu_moi;

    }

    public function updatePhieuMHDTY(){

        DB::transaction( function(){

            $update = PhieuTKSX::where('so_phieu', $this->soPhieu)->first();
                
            $update->may = $this->soMay;
            $update->quy_cach = $this->quyCach;
            $update->ma = $this->maHang;
            $update->ngay = $this->ngay;
            $update->mau_ong = $this->mauOng;
            $update->thong_tin_doi_ma = $this->thongTinDoiMa;
            $update->soi = $this->soi;
            $update->ma_cu_moi = $this->maCuMoi;
            $update->quy_cach_poy = $this->quyCachPOY;
            $update->ma_poy = $this->maPOY;
            $update->quy_cach_dty = $this->quyCachDTY;
            $update->ma_dty = $this->maDTY;
            $update->khach_hang = $this->tenCongTy;
            $update->loai_hang = $this->loaiHang;
            $update->so_luong_don_hang = $this->soLuongDonHang;
            $update->ghi_chu_so_luong = $this->ghiChuSoLuong;
            $update->dieu_kien_khach_hang = $this->dieuKienKhachHang;
            $update->qa_kien_nghi = $this->qaKienNghi;

            $update->updated_user = Auth::user()->username;

            $update->save();

            $arr = [

                'so_phieu' => $this->soPhieu,
                'so' => $this->soSO,
                'sale' => $this->sale,
                'may' => $this->soMay,
                'quy_cach' => $this->quyCach,
                'ma' => $this->maHang,
                'thong_tin_doi_ma' => $this->thongTinDoiMa,
                'ngay' => $this->ngay,
                'mau_ong' => $this->mauOng,
                'soi' => $this->soi,
                'ma_cu_moi' => $this->maCuMoi,
                'quy_cach_poy' => $this->quyCachPOY,
                'ma_poy' => $this->maPOY,
                'quy_cach_dty' => $this->quyCachDTY,
                'ma_dty' => $this->maDTY,
                'khach_hang' => $this->tenCongTy,
                'loai_hang' => $this->loaiHang,
                'so_luong_don_hang' => $this->soLuongDonHang,
                'ghi_chu_so_luong' => $this->ghiChuSoLuong,
                'dieu_kien_khach_hang' => $this->dieuKienKhachHang,
                'qa_kien_nghi' => $this->qaKienNghi,

                'status' => $update->status,
                'created_user' => $update->created_user,

                'status_log' => 'Update',
                'updated_user' => Auth::user()->username,

            ];

            PhieuTKSXLog::create($arr);

            flash()->addFlash('success', 'Sửa thành công phiếu : ' . $this->soPhieu,'Thông báo');
            $this->resetInputField();
            $this->emit('editPhieuMHDTYModal');

        });

    }

    public function deletePhieuMHDTYModal($soPhieu){

        $this->soPhieu = $soPhieu;

    }

    public function deletePhieuMHDTY(){

        DB::transaction(function(){

            $delete = PhieuTKSX::where('so_phieu', $this->soPhieu)->first();

            $delete->is_delete = '1';
            $delete->updated_user = Auth::user()->username;

            $delete->save();

            $arr = [

                'so_phieu' => $delete->so_phieu,
                'so' => $delete->so,
                'sale' => $delete->sale,
                'may' => $delete->may,
                'quy_cach' => $delete->quy_cach,
                'ma' => $delete->ma,
                'ngay' => $delete->ngay,
                'mau_ong' => $delete->mau_ong,
                'quy_cach_poy' => $delete->quy_cach_poy,
                'ma_poy' => $delete->ma_poy,
                'quy_cach_dty' => $delete->quy_cach_dty,
                'ma_dty' => $delete->ma_dty,
                'khach_hang' => $delete->khach_hang,
                'loai_hang' => $delete->loai_hang,
                'so_luong_don_hang' => $delete->so_luong_don_hang,
                'ghi_chu_so_luong' => $delete->ghi_chu_so_luong,
                'dieu_kien_khach_hang' => $delete->dieu_kien_khach_hang,
                'qa_kien_nghi' => $delete->qa_kien_nghi,
                'thong_tin_doi_ma' => $delete->thong_tin_doi_ma,
                'ma_cu_moi' => $delete->ma_cu_moi,
                'soi' => $delete->soi,

                'status' => $delete->status,
                'created_user' => $delete->created_user,

                'status_log' => 'Delete',
                'updated_user' => Auth::user()->username,

                'is_delete' => '1',

            ];

            PhieuTKSXLog::create($arr);

            if($this->soSO != null){

                SO::where('so', $this->soSO)->update([

                    'phieu_mhdty' => '',
                    'status_phieu_mhdty' => ''
                    
                ]);

            }
            

            flash()->addFlash('success', 'Xóa thành công phiếu : ' . $this->soPhieu,'Thông báo');
            $this->resetInputField();
            $this->emit('deletePhieuMHDTYModal');

        });
    }

    public function approvePhieuMHDTYModal($soPhieu){

        $this->soPhieu = $soPhieu;

        $PhieuTKSX = PhieuTKSX::where('so_phieu', $soPhieu)->first();

        $this->soSO = $PhieuTKSX->so;
        $this->sale = $PhieuTKSX->sale;
        $this->soMay = $PhieuTKSX->may;
        $this->quyCach = $PhieuTKSX->quy_cach;
        $this->maHang = $PhieuTKSX->ma;
        $this->ngay = $PhieuTKSX->ngay;
        $this->thongTinDoiMa = $PhieuTKSX->thong_tin_doi_ma;
        $this->mauOng = $PhieuTKSX->mau_ong;
        $this->soi = $PhieuTKSX->soi;
        $this->maCuMoi = $PhieuTKSX->ma_cu_moi;
        $this->quyCachPOY = $PhieuTKSX->quy_cach_poy;
        $this->maPOY = $PhieuTKSX->ma_poy;
        $this->quyCachDTY = $PhieuTKSX->quy_cach_dty;
        $this->maDTY = $PhieuTKSX->ma_dty;
        $this->tenCongTy = $PhieuTKSX->khach_hang;
        $this->loaiHang = $PhieuTKSX->loai_hang;
        $this->soLuongDonHang = $PhieuTKSX->so_luong_don_hang;
        $this->ghiChuSoLuong = $PhieuTKSX->ghi_chu_so_luong;
        $this->dieuKienKhachHang = $PhieuTKSX->dieu_kien_khach_hang;
        $this->qaKienNghi = $PhieuTKSX->qa_kien_nghi;
        $this->status = $PhieuTKSX->status;

    }

    public function approvePhieuMHDTY(){

        DB::transaction( function(){

            $pxxdh = PhieuTKSX::where('so_phieu', $this->soPhieu)->first();

            if($pxxdh->status == 'New'){

                if(!Auth::user()->hasPermissionTo('quan_ly_khst_approve_ptksx')){

                    sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                    $this->emit('approvePhieuMHDTYModal');
                    $this->resetInputField();
                    return;

                }

            }elseif($pxxdh->status == 'KHST APPROVED'){

                if(!Auth::user()->hasPermissionTo('qa_approve_ptksx')){

                    sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                    $this->emit('approvePhieuMHDTYModal');
                    $this->resetInputField();
                    return;

                }

            }elseif($pxxdh->status == 'QA APPROVED'){

                if(!Auth::user()->hasPermissionTo('sale_approve_ptksx')){

                    sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                    $this->emit('approvePhieuMHDTYModal');
                    $this->resetInputField();
                    return;

                }

            }elseif($pxxdh->status == 'Sale APPROVED'){

                if(!Auth::user()->hasPermissionTo('sm_approve_ptksx')){

                    sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                    $this->emit('approvePhieuMHDTYModal');
                    $this->resetInputField();
                    return;

                }

            }elseif($pxxdh->status == 'SM APPROVED'){

                if(!Auth::user()->hasPermissionTo('create_ptksx')){

                    sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                    $this->emit('approvePhieuMHDTYModal');
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
    
                $arr = [

                    'so_phieu' => $this->soPhieu,
                    'so' => $this->soSO,
                    'sale' => $this->sale,
                    'may' => $this->soMay,
                    'quy_cach' => $this->quyCach,
                    'ma' => $this->maHang,
                    'ngay' => $this->ngay,
                    'mau_ong' => $this->mauOng,
                    'quy_cach_poy' => $this->quyCachPOY,
                    'ma_poy' => $this->maPOY,
                    'quy_cach_dty' => $this->quyCachDTY,
                    'ma_dty' => $this->maDTY,
                    'khach_hang' => $this->tenCongTy,
                    'loai_hang' => $this->loaiHang,
                    'so_luong_don_hang' => $this->soLuongDonHang,
                    'ghi_chu_so_luong' => $this->ghiChuSoLuong,
                    'dieu_kien_khach_hang' => $this->dieuKienKhachHang,
                    'thong_tin_doi_ma' => $this->thongTinDoiMa,
                    'ma_cu_moi' => $this->maCuMoi,
                    'soi' => $this->soi,

                    'status' => 'KHST APPROVED',

                    'status_log' => 'Approve',
                    'created_user' => Auth::user()->username,
                    'updated_user' => Auth::user()->username,
    
                ];
    
                PhieuTKSXLog::create($arr);

                if (empty($this->sale)) {

                    // Storage::disk('public')->makeDirectory('PhieuTKSX/' . $pxxdh->so_phieu);
    
                    $templateProcessor = new TemplateProcessor(public_path('PhieuTKSX/PTKSX - DungMay.docx'));

                    $values = [
                        
                        'so_phieu' => $this->soPhieu,
                        'may' => $this->soMay . $this->mat,
                        'quy_cach' => $this->quyCach,
                        'ma' => $this->maHang,
                        'ngay' => Carbon::create($this->ngay)->isoFormat('DD.MM.YYYY'),
                        'thong_tin_doi_ma' => $this->thongTinDoiMa,
                        'ngay_2' => 'Ngày ' . Carbon::create($this->ngay)->isoFormat('DD') . ' tháng ' . Carbon::create($this->ngay)->isoFormat('MM') . ' năm ' . Carbon::create($this->ngay)->isoFormat('YYYY'),
                        
                    ];

                    $templateProcessor->setValues($values);

                    Storage::disk('public')->makeDirectory('PhieuTKSX/' . str_replace('/','_',$pxxdh->so_phieu));
                
                    $templateProcessor->saveAs(storage_path('app/public/PhieuTKSX/') . str_replace('/','_',$pxxdh->so_phieu) . '/' . str_replace('/','_',$pxxdh->so_phieu) .'.docx');
                    
                    $emailUserCreate = User::where('username', $pxxdh->created_user)->first();
                    
                    Mail::to($emailUserCreate->email)->later(now()->addMinutes(1), new MailPhieuTKSX('KHST APPROVED',$this->soPhieu, Auth::user()->username, $pxxdh->updated_at, ''));

                }else{
                
                    Mail::to('qa@soitheky.vn')->later(now()->addMinutes(1), new MailPhieuTKSX('KHST APPROVED',$this->soPhieu, Auth::user()->username, $pxxdh->updated_at, ''));
                
                }

            }elseif($pxxdh->status == 'KHST APPROVED'){

                $pxxdh->status = 'QA APPROVED';
                $pxxdh->updated_user = Auth::user()->username;
                $pxxdh->qa_kien_nghi = $this->qaKienNghi;

                $pxxdh->qa_approved = Auth::user()->username;
                $pxxdh->qa_approved_at = Carbon::now();
        
                $pxxdh->update();

                $arr = [

                    'so_phieu' => $this->soPhieu,
                    'so' => $this->soSO,
                    'sale' => $this->sale,
                    'may' => $this->soMay,
                    'quy_cach' => $this->quyCach,
                    'ma' => $this->maHang,
                    'ngay' => $this->ngay,
                    'mau_ong' => $this->mauOng,
                    'quy_cach_poy' => $this->quyCachPOY,
                    'ma_poy' => $this->maPOY,
                    'quy_cach_dty' => $this->quyCachDTY,
                    'ma_dty' => $this->maDTY,
                    'khach_hang' => $this->tenCongTy,
                    'loai_hang' => $this->loaiHang,
                    'so_luong_don_hang' => $this->soLuongDonHang,
                    'ghi_chu_so_luong' => $this->ghiChuSoLuong,
                    'dieu_kien_khach_hang' => $this->dieuKienKhachHang,
                    'qa_kien_nghi' => $this->qaKienNghi,
                    'thong_tin_doi_ma' => $this->thongTinDoiMa,
                    'ma_cu_moi' => $this->maCuMoi,
                    'soi' => $this->soi,

                    'status' => 'QA APPROVED',

                    'status_log' => 'Approve',
                    'created_user' => Auth::user()->username,
                    'updated_user' => Auth::user()->username,
    
                ];

                PhieuTKSXLog::create($arr);

                Mail::to($this->sale)->later(now()->addMinutes(1), new MailPhieuTKSX('QA APPROVED',$this->soPhieu, Auth::user()->username, $pxxdh->updated_at,''));

            }elseif($pxxdh->status == 'QA APPROVED'){

                $pxxdh->status = 'Sale APPROVED';
                $pxxdh->updated_user = Auth::user()->username;

                $pxxdh->sale_approved = Auth::user()->username;
                $pxxdh->sale_approved_at = Carbon::now();
        
                $pxxdh->update();

                $arr = [

                    'so_phieu' => $this->soPhieu,
                    'so' => $this->soSO,
                    'sale' => $this->sale,
                    'may' => $this->soMay,
                    'quy_cach' => $this->quyCach,
                    'ma' => $this->maHang,
                    'ngay' => $this->ngay,
                    'mau_ong' => $this->mauOng,
                    'quy_cach_poy' => $this->quyCachPOY,
                    'ma_poy' => $this->maPOY,
                    'quy_cach_dty' => $this->quyCachDTY,
                    'ma_dty' => $this->maDTY,
                    'khach_hang' => $this->tenCongTy,
                    'loai_hang' => $this->loaiHang,
                    'so_luong_don_hang' => $this->soLuongDonHang,
                    'ghi_chu_so_luong' => $this->ghiChuSoLuong,
                    'dieu_kien_khach_hang' => $this->dieuKienKhachHang,
                    'qa_kien_nghi' => $this->qaKienNghi,
                    'thong_tin_doi_ma' => $this->thongTinDoiMa,
                    'ma_cu_moi' => $this->maCuMoi,
                    'soi' => $this->soi,

                    'status' => 'Sale APPROVED',

                    'status_log' => 'Approve',
                    'created_user' => Auth::user()->username,
                    'updated_user' => Auth::user()->username,
    
                ];

                PhieuTKSXLog::create($arr);

                $emailQuanLySale = EmailQuanLy::where('chuc_vu', 'quan_ly_sale')->first();

                Mail::to($emailQuanLySale->email)->later(now()->addMinutes(1), new MailPhieuTKSX('Sale APPROVED',$this->soPhieu, Auth::user()->username, $pxxdh->updated_at, ''));

            }elseif($pxxdh->status == 'Sale APPROVED'){

                $pxxdh->status = 'SM APPROVED';
                $pxxdh->updated_user = Auth::user()->username;

                $pxxdh->sm_approved = Auth::user()->username;
                $pxxdh->sm_approved_at = Carbon::now();
        
                $pxxdh->update();

                $arr = [

                    'so_phieu' => $this->soPhieu,
                    'so' => $this->soSO,
                    'sale' => $this->sale,
                    'may' => $this->soMay,
                    'quy_cach' => $this->quyCach,
                    'ma' => $this->maHang,
                    'ngay' => $this->ngay,
                    'mau_ong' => $this->mauOng,
                    'quy_cach_poy' => $this->quyCachPOY,
                    'ma_poy' => $this->maPOY,
                    'quy_cach_dty' => $this->quyCachDTY,
                    'ma_dty' => $this->maDTY,
                    'khach_hang' => $this->tenCongTy,
                    'loai_hang' => $this->loaiHang,
                    'so_luong_don_hang' => $this->soLuongDonHang,
                    'ghi_chu_so_luong' => $this->ghiChuSoLuong,
                    'dieu_kien_khach_hang' => $this->dieuKienKhachHang,
                    'qa_kien_nghi' => $this->qaKienNghi,
                    'thong_tin_doi_ma' => $this->thongTinDoiMa,
                    'ma_cu_moi' => $this->maCuMoi,
                    'soi' => $this->soi,

                    'status' => 'SM APPROVED',

                    'status_log' => 'Approve',
                    'created_user' => Auth::user()->username,
                    'updated_user' => Auth::user()->username,
    
                ];
                
                PhieuTKSXLog::create($arr);

                $emailUserCreate = User::where('username', $pxxdh->created_user)->first();

                Mail::to($emailUserCreate->email)->later(now()->addMinutes(1), new MailPhieuTKSX('SM APPROVED',$this->soPhieu, Auth::user()->username, $pxxdh->updated_at, ''));

            }elseif($pxxdh->status == 'SM APPROVED'){

                $pxxdh->status = 'Finish';
                $pxxdh->updated_user = Auth::user()->username;

                $pxxdh->finish = Auth::user()->username;
                $pxxdh->finish_at = Carbon::now();
        
                $pxxdh->update();

                $arr = [

                    'so_phieu' => $this->soPhieu,
                    'so' => $this->soSO,
                    'sale' => $this->sale,
                    'may' => $this->soMay,
                    'quy_cach' => $this->quyCach,
                    'ma' => $this->maHang,
                    'ngay' => $this->ngay,
                    'mau_ong' => $this->mauOng,
                    'quy_cach_poy' => $this->quyCachPOY,
                    'ma_poy' => $this->maPOY,
                    'quy_cach_dty' => $this->quyCachDTY,
                    'ma_dty' => $this->maDTY,
                    'khach_hang' => $this->tenCongTy,
                    'loai_hang' => $this->loaiHang,
                    'so_luong_don_hang' => $this->soLuongDonHang,
                    'ghi_chu_so_luong' => $this->ghiChuSoLuong,
                    'dieu_kien_khach_hang' => $this->dieuKienKhachHang,
                    'qa_kien_nghi' => $this->qaKienNghi,
                    'thong_tin_doi_ma' => $this->thongTinDoiMa,
                    'ma_cu_moi' => $this->maCuMoi,
                    'soi' => $this->soi,

                    'status' => 'Finish',
                    'status_log' => 'Approve',
                    
                    'created_user' => Auth::user()->username,
                    'updated_user' => Auth::user()->username,
    
                ];

                PhieuTKSXLog::create($arr);

                if($this->soSO != null){

                    $phieuXXDH = PhieuXXDH::where('so', $this->soSO)
                    ->where('don_hang_sx_moi', '1')
                    ->first();

                    if($phieuXXDH != null){

                        QuyCachPhieuXXDH::where('phieu_xxdh_so_phieu_id', $phieuXXDH->id)
                        ->where('quy_cach', $this->quyCachDTY)
                        ->whereIn('lot', ['new lot', 'New lot', 'NEW LOT', 'New Lot'])
                        ->update([
                            'lot' => $this->maDTY . ' (new lot)'
                        ]);

                    }

                    SO::where('so', $this->soSO)->update([
    
                        'status_phieu_tksx' => '1'
                        
                    ]);

                }
                
                $linePOY = '';

                $arrayIndex = array(strpos($pxxdh->ma_poy, 'L'), strpos($pxxdh->ma_poy, 'T'), strpos($pxxdh->ma_poy, 'K'));

                if(array_diff($arrayIndex, array(0, false)) != null){

                    $minIndex = min(array_diff($arrayIndex, array(0, false)));

                    $linePOY = substr($pxxdh->ma_poy, $minIndex);

                }
        
                $phieuTheoDoi = new TheoDoiSXDTY();
        
                $phieuTheoDoi->tksx = $this->soPhieu;
                $phieuTheoDoi->ma_hang = $this->maDTY;
                $phieuTheoDoi->may = $pxxdh->may;
                $phieuTheoDoi->quy_cach = $pxxdh->quy_cach_dty;
                $phieuTheoDoi->don_chap = $pxxdh->soi;
                $phieuTheoDoi->ma_cu_moi = $pxxdh->ma_cu_moi;
                $phieuTheoDoi->line_poy = trim($linePOY);
                $phieuTheoDoi->ma_poy = trim($pxxdh->ma_poy);
                $phieuTheoDoi->ma_fdy = '';
                $phieuTheoDoi->khach_hang = $pxxdh->khach_hang;
                $phieuTheoDoi->yeu_cau_khach_hang = $pxxdh->qa_kien_nghi;
                $phieuTheoDoi->dieu_kien_khach_hang = $pxxdh->dieu_kien_khach_hang;
                $phieuTheoDoi->khoi_luong = $pxxdh->so_luong_don_hang;
                $phieuTheoDoi->ngay_qa_ky_tk = $pxxdh->qa_approved_at;
                $phieuTheoDoi->ngay_tk = $pxxdh->ngay;
                $phieuTheoDoi->status = 'Thêm mới';
                $phieuTheoDoi->created_user = Auth::user()->username;
                $phieuTheoDoi->updated_user = Auth::user()->username;
        
                $phieuTheoDoi->save();
        
                $phieuTheoDoiLog = new TheoDoiSXDTYLog();
        
                $phieuTheoDoiLog->tksx = $this->soPhieu;
                $phieuTheoDoiLog->ma_hang = $this->maDTY;
                $phieuTheoDoiLog->may = $pxxdh->may;
                $phieuTheoDoiLog->quy_cach = $pxxdh->quy_cach_dty;
                $phieuTheoDoiLog->don_chap = $pxxdh->soi;
                $phieuTheoDoiLog->ma_cu_moi = $pxxdh->ma_cu_moi;
                $phieuTheoDoiLog->line_poy = trim($linePOY);
                $phieuTheoDoiLog->ma_poy = trim($pxxdh->ma_poy);
                $phieuTheoDoiLog->ma_fdy = '';
                $phieuTheoDoiLog->khach_hang = $pxxdh->khach_hang;
                $phieuTheoDoi->yeu_cau_khach_hang = $pxxdh->qa_kien_nghi;
                $phieuTheoDoi->dieu_kien_khach_hang = $pxxdh->dieu_kien_khach_hang;
                $phieuTheoDoiLog->khoi_luong = $pxxdh->so_luong_don_hang;
                $phieuTheoDoiLog->ngay_qa_ky_tk = $pxxdh->qa_approved_at;
                $phieuTheoDoiLog->ngay_tk = $pxxdh->ngay;
                $phieuTheoDoiLog->status = 'Thêm mới';
                $phieuTheoDoiLog->created_user = Auth::user()->username;
                $phieuTheoDoiLog->updated_user = Auth::user()->username;
        
                $phieuTheoDoiLog->save();

                // Storage::disk('public')->makeDirectory('PhieuTKSX/' . $pxxdh->so_phieu);
    
                $templateProcessor = new TemplateProcessor(public_path('PhieuTKSX/PTKSX.docx'));

                $username_sale = PhieuTKSXLog::where('so_phieu', $this->soPhieu)->where('status', 'Sale APPROVED')->first();

                $name_sale = User::where('username', $username_sale->updated_user)->first();

                $values = [
                    
                    'so_phieu' => $this->soPhieu,
                    'may' => $this->soMay . $this->mat,
                    'quy_cach' => $this->quyCach,
                    'ma' => $this->maHang,
                    'ngay' => Carbon::create($this->ngay)->isoFormat('DD.MM.YYYY'),
                    'mau_ong' => $this->mauOng,
                    'quy_cach_poy' => $this->quyCachPOY,
                    'ma_poy' => $this->maPOY,
                    'quy_cach_dty' => $this->quyCachDTY,
                    'ma_dty' => $this->maDTY,
                    'khach_hang' => $this->tenCongTy,
                    'loai_hang' => $this->loaiHang,
                    'so_luong_don_hang' => $this->soLuongDonHang,
                    'ghi_chu_so_luong' => $this->ghiChuSoLuong,
                    'dieu_kien_khach_hang' => $this->dieuKienKhachHang,
                    'ngay_2' => 'Ngày ' . Carbon::create($this->ngay)->isoFormat('DD') . ' tháng ' . Carbon::create($this->ngay)->isoFormat('MM') . ' năm ' . Carbon::create($this->ngay)->isoFormat('YYYY'),
                    'qa_kien_nghi' => $this->qaKienNghi,
                    'username_sale' => $name_sale->name,
                    'thong_tin_doi_ma' => $this->thongTinDoiMa,
                    'soi' => $this->soi,
                    'ma_cu_moi' => $this->maCuMoi,

                ];

                $templateProcessor->setValues($values);

                Storage::disk('public')->makeDirectory('PhieuTKSX/' . str_replace('/','_',$pxxdh->so_phieu));
            
                $templateProcessor->saveAs(storage_path('app/public/PhieuTKSX/') . str_replace('/','_',$pxxdh->so_phieu) . '/' . str_replace('/','_',$pxxdh->so_phieu) .'.docx');

                $emailQuanLyKHST = EmailQuanLy::where('chuc_vu', 'quan_ly_khst')->first();
                
                Mail::to($emailQuanLyKHST->email)->cc('loanpham@soitheky.vn')->later(now()->addMinutes(1), new MailPhieuTKSX('Finish',$this->soPhieu, Auth::user()->username, $pxxdh->updated_at, ''));

            }

            flash()->addFlash('success', 'Duyệt thành công phiếu : ' . $this->soPhieu,'Thông báo');
            $this->emit('approvePhieuMHDTYModal');

        });
    }

    public function rollBackModal($soPhieu, $status){  

        $this->checkProccess($soPhieu, 'Roll back', 'rollBackPhieuTKSXModal');

        $this->soPhieu = $soPhieu;
        $this->status = $status;

    }

    public function rollBack(){

        DB::transaction(function(){

            $ptksx = PhieuTKSX::where('so_phieu', $this->soPhieu)->first();

            if($this->capRollBack == 'new'){
    
                $status = 'New';
    
            }elseif($this->capRollBack == 'qa'){
    
                $status = 'QA APPROVED';
    
            }
    
            $updatedUser = PhieuTKSXLog::where('so_phieu', $this->soPhieu)
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
    
            $arr = [
    
                'so_phieu' => $ptksx->so_phieu,
                'phieu_xxdh_so_phieu' => $ptksx->phieu_xxdh_so_phieu,
                'sale' => $ptksx->sale,
                'may' => $ptksx->may,
                'quy_cach' => $ptksx->quy_cach,
                'ma' => $ptksx->ma,
                'ngay' => $ptksx->ngay,
                'mau_ong' => $ptksx->mau_ong,
                'quy_cach_poy' => $ptksx->quy_cach_poy,
                'ma_poy' => $ptksx->ma_poy,
                'quy_cach_dty' => $ptksx->quy_cach_dty,
                'ma_dty' => $ptksx->ma_dty,
                'khach_hang' => $ptksx->khach_hang,
                'loai_hang' => $ptksx->loai_hang,
                'so_luong_don_hang' => $ptksx->so_luong_don_hang,
                'ghi_chu_so_luong' => $ptksx->ghi_chu_so_luong,
                'dieu_kien_khach_hang' => $ptksx->dieu_kien_khach_hang,
                'qa_kien_nghi' => $ptksx->qa_kien_nghi,
                'thong_tin_doi_ma' => $this->thongTinDoiMa,
                'ma_cu_moi' => $this->maCuMoi,
                'soi' => $this->soi,
    
                'status' => $status,
                'status_log' => 'Roll back',
                'ly_do_rollback' => $this->lyDoRollback,
                'created_user' => Auth::user()->username,
                'updated_user' => Auth::user()->username,
    
            ];
    
            $PTKSXLog = PhieuTKSXLog::create($arr);

            $layUser = PhieuTKSXLog::where('so_phieu', $this->soPhieu)
            ->where('status', $status)
            ->first();

            $user = User::where('username', $layUser->updated_user)->first();

            Mail::to($user->email)->later(now()->addMinutes(1), new MailPhieuTKSX('Rollback',$this->soPhieu, Auth::user()->username, $PTKSXLog->updated_at, $this->lyDoRollback));

            flash()->addFlash('success', 'Roll back thành công phiếu : ' . $this->soPhieu,'Thông báo');

            $this->resetInputField();

            $this->emit('rollBackPhieuTKSXModal');

        });

    }

    public function rejectModal($soPhieu){

        $this->soPhieu = $soPhieu;

    }

    public function reject(){

        DB::transaction(function(){

            $tksx = PhieuTKSX::where('so_phieu', $this->soPhieu)->first();

            $tksx->status = 'Reject';
            $tksx->note_reject = $this->noteReject;
            $tksx->reject = Auth::user()->username;
            $tksx->reject_at = Carbon::now();
            $tksx->updated_user = Auth::user()->username;

            $tksx->save();

            $arr = [

                'so_phieu' => $tksx->so_phieu,
                'so' => $tksx->so,
                'sale' => $tksx->sale,
                'may' => $tksx->may,
                'quy_cach' => $tksx->quy_cach,
                'ma' => $tksx->ma,
                'ngay' => $tksx->ngay,
                'mau_ong' => $tksx->mau_ong,
                'quy_cach_poy' => $tksx->quy_cach_poy,
                'ma_poy' => $tksx->ma_poy,
                'quy_cach_dty' => $tksx->quy_cach_dty,
                'ma_dty' => $tksx->ma_dty,
                'khach_hang' => $tksx->khach_hang,
                'loai_hang' => $tksx->loai_hang,
                'so_luong_don_hang' => $tksx->so_luong_don_hang,
                'ghi_chu_so_luong' => $tksx->ghi_chu_so_luong,
                'dieu_kien_khach_hang' => $tksx->dieu_kien_khach_hang,
                'qa_kien_nghi' => $tksx->qa_kien_nghi,
                'thong_tin_doi_ma' => $tksx->thong_tin_doi_ma,
                'ma_cu_moi' => $tksx->ma_cu_moi,
                'soi' => $tksx->soi,

                'status' => $tksx->status,
                'created_user' => $tksx->created_user,

                'status_log' => 'Reject',
                'note_reject' => $this->noteReject,
                'updated_user' => Auth::user()->username,

            ];

            PhieuTKSXLog::create($arr); 

            flash()->addFlash('success', 'Reject thành công phiếu : ' . $this->soPhieu,'Thông báo');
            $this->resetInputField();
            $this->emit('closeModal');

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

        DB::table('phieu_tksx')
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

    public function downloadFile($soPhieu){

        return response()->download(storage_path('app/public/PhieuTKSX/') . str_replace('/','_',$soPhieu) . '/' . str_replace('/','_',$soPhieu) . '.docx');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function search(){

        $search_fields = [
            'phieu_tksx.so_phieu',
            'phieu_tksx.khach_hang',
            'phieu_tksx.so',
            'phieu_tksx.created_user',
            'phieu_tksx.quy_cach',
            'phieu_tksx.ma',
            'phieu_tksx.status'
        ];

        $search_terms = explode(',', $this->search);

        $query = PhieuTKSX::query();

        foreach ($search_terms as $term) {
            $query->orWhere(function ($query) use ($search_fields, $term) {

                foreach ($search_fields as $field) {
                    $query->orWhere($field, 'LIKE', '%' . trim($term) . '%');
                }
            });
        }

        $query->where('phieu_tksx.is_delete', null);

        if($this->tuNgay == null && $this->denNgay == null){

            $query->whereBetween('phieu_tksx.created_at', ['2023-05-01 00:00:00', '2099-01-01 00:00:00']);

        }elseif($this->tuNgay != null && $this->denNgay != null){
            $query->whereBetween('phieu_tksx.created_at', [$this->tuNgay . ' 00:00:00', $this->denNgay . ' 23:59:59']);

        }elseif($this->tuNgay == null && $this->denNgay != null){
            $query->whereBetween('phieu_tksx.created_at', ['2023-05-01 00:00:00', $this->denNgay . ' 23:59:59']);

        }
        elseif($this->tuNgay != null && $this->denNgay == null){
            $query->whereBetween('phieu_tksx.created_at', [$this->tuNgay . ' 00:00:00', '2099-01-01 00:00:00']);

        }

        if($this->canhan_tatca == 'phieuDoiDuyet'){

            $query->where(function($query){

                if(Auth::user()->hasPermissionTo('create_ptksx')){

                    $query->orWhere(function($query){

                        $query->where('phieu_tksx.created_user', '=' , Auth::user()->username);

                        $query->where('phieu_tksx.status' , 'SM APPROVED');

                    });
                }

                if(Auth::user()->hasPermissionTo('quan_ly_khst_approve_ptksx')){

                    $query->orWhere(function($query){

                        $query->where('phieu_tksx.status', 'New');

                    });
                }

                if(Auth::user()->hasPermissionTo('qa_approve_ptksx')){

                    $query->orWhere(function($query){

                        $query->where('phieu_tksx.status', 'KHST APPROVED');

                    });
                }

                if(Auth::user()->hasPermissionTo('sale_approve_ptksx')){
                    
                    $query->orWhere(function($query){

                        $query->where('phieu_tksx.status', 'QA APPROVED');
                        $query->where('phieu_tksx.sale', Auth::user()->email);

                    });        

                }

                if(Auth::user()->hasPermissionTo('sm_approve_ptksx')){

                    $query->orWhere(function($query){

                        $query->where('phieu_tksx.status', 'Sale APPROVED');  

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

        $query->select('phieu_tksx.so_phieu', 'phieu_tksx.so' , 'phieu_tksx.sale', 'phieu_tksx.khach_hang','phieu_tksx.status' ,
        'phieu_tksx.created_user', 'phieu_tksx.updated_user', 'phieu_tksx.created_at')->orderBy('phieu_tksx.created_at', 'desc');

        $this->search_result = $query->paginate($this->paginate);

    }

    public function changeCaNhanTatCa(){

        $this->resetPage();

    }

    public function render()
    {   
        if($this->search == ''){

            $query = PhieuTKSX::query();

            $query->where('phieu_tksx.is_delete', null);

            if($this->tuNgay == null && $this->denNgay == null){

                $query->whereBetween('phieu_tksx.created_at', ['2023-05-01 00:00:00', '2099-01-01 00:00:00']);

            }elseif($this->tuNgay != null && $this->denNgay != null){

                $query->whereBetween('phieu_tksx.created_at', [$this->tuNgay . ' 00:00:00', $this->denNgay . ' 23:59:59']);

            }elseif($this->tuNgay == null && $this->denNgay != null){

                $query->whereBetween('phieu_tksx.created_at', ['2023-05-01 00:00:00', $this->denNgay . ' 23:59:59']);

            }
            elseif($this->tuNgay != null && $this->denNgay == null){

                $query->whereBetween('phieu_tksx.created_at', [$this->tuNgay . ' 00:00:00', '2099-01-01 00:00:00']);

            }

            if($this->canhan_tatca == 'phieuDoiDuyet'){

                $query->where(function($query){

                    if(Auth::user()->hasPermissionTo('create_ptksx')){

                        $query->orWhere(function($query){
    
                            $query->where('phieu_tksx.created_user', '=' , Auth::user()->username);
    
                            $query->where('phieu_tksx.status' , 'SM APPROVED');
    
                        });
                    }

                    if(Auth::user()->hasPermissionTo('quan_ly_khst_approve_ptksx')){

                        $query->orWhere(function($query){
    
                            $query->where('phieu_tksx.status', 'New');
    
                        });
                    }

                    if(Auth::user()->hasPermissionTo('qa_approve_ptksx')){

                        $query->orWhere(function($query){
    
                            $query->where('phieu_tksx.status', 'KHST APPROVED');

                            $query->where('phieu_tksx.sale', '<>' ,'');
    
                        });
                    }

                    if(Auth::user()->hasPermissionTo('sale_approve_ptksx')){
                        
                        $query->orWhere(function($query){
    
                            $query->where('phieu_tksx.status', 'QA APPROVED');
                            $query->where('phieu_tksx.sale', Auth::user()->email);
    
                        });        
    
                    }

                    if(Auth::user()->hasPermissionTo('sm_approve_ptksx')){

                        $query->orWhere(function($query){

                            $query->where('phieu_tksx.status', 'Sale APPROVED');  

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

            $query->select('phieu_tksx.so_phieu', 'phieu_tksx.so' , 'phieu_tksx.sale', 'phieu_tksx.khach_hang','phieu_tksx.status' ,
            'phieu_tksx.created_user', 'phieu_tksx.updated_user', 'phieu_tksx.created_at')->orderBy('phieu_tksx.created_at', 'desc');
                
            $ptbtdmhdty = $query->paginate($this->paginate);

        }else{

            $this->search();
            $ptbtdmhdty = $this->search_result;

        }

        $danhSachMail = User::permission('sale_approve_ptksx')->get();

        if($this->soSO != null){

            $this->danhSachDieuKienKhachHang = PhieuXXDH::join('phieu_xxdh_quy_cach', 'phieu_xxdh.id', '=', 'phieu_xxdh_quy_cach.phieu_xxdh_so_phieu_id')
            ->where('phieu_xxdh_quy_cach.status', 'Sale')
            ->where('phieu_xxdh.so', $this->soSO)
            ->get();

        }

        if($this->dieuKienKhachHangSelect != ''){

            $this->dieuKienKhachHang = $this->dieuKienKhachHangSelect;

        }
        
        return view('livewire.phieu-thay-doi-ma-hang', compact('ptbtdmhdty','danhSachMail'));
    }
}
