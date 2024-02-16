<?php

namespace App\Http\Livewire;

use App\Exports\TheoDoiTKSX;
use App\Models\PhieuTKSX;
use App\Models\TheoDoiSXDTY;
use App\Models\TheoDoiSXDTYLog;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class TheoDoiTKSXDTY extends Component
{
    use WithFileUploads;

    public $maHangTimKiem, $quyCachTimKiem, $tenKhachHangTimKiem, $nhaMayTimKiem;

    public $maHang;

    public $paginate, $state;

    public $ngaySXChinhThuc, $ngayKiemTraTSKT, $ngayQCKiemTSKT, $ketQua, $fileDinhKem;

    public $idPhieu;

    public $radioTongQuatChiTiet;

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'page' => ['except' => 1],
    ];

    public function mount(){

        $this->paginate = 15;
        $this->state = 'main';
        $this->radioTongQuatChiTiet = 'choCapNhat';

    }

    public function create(){

        $this->state = 'create';

    }

    public function store(){

        $phieuTKSX = PhieuTKSX::where('ma_dty', 'like', '%' . $this->maHang . '%')
                            ->orWhere('so_phieu', $this->maHang)
                            ->get();

        if($phieuTKSX->count() == 0){

            flash()->addError('Không tìm thấy dữ liệu.');
            return;

        }elseif($phieuTKSX->count() > 1){

            flash()->addError('Tìm thấy nhiều hơn 1 phiếu TKSX có liên quan của mã hàng. Vui lòng nhập số Phiếu TKSX để lấy thông tin chính xác.');
            return;

        }else{

            $arrayIndex = array(strpos($phieuTKSX[0]->ma_poy, 'L'), strpos($phieuTKSX[0]->ma_poy, 'T'), strpos($phieuTKSX[0]->ma_poy, 'K'));

            $minIndex = min(array_diff($arrayIndex, array(0, false)));
    
            $linePOY = substr($phieuTKSX[0]->ma_poy, $minIndex);
    
            $phieuTheoDoi = new TheoDoiSXDTY();
    
            $phieuTheoDoi->ma_hang = $this->maHang;
            $phieuTheoDoi->may = $phieuTKSX[0]->may;
            $phieuTheoDoi->quy_cach = $phieuTKSX[0]->quy_cach_dty;
            $phieuTheoDoi->don_chap = $phieuTKSX[0]->soi;
            $phieuTheoDoi->ma_cu_moi = $phieuTKSX[0]->ma_cu_moi;
            $phieuTheoDoi->line_poy = trim($linePOY);
            $phieuTheoDoi->ma_poy = trim($phieuTKSX[0]->ma_poy);
            $phieuTheoDoi->ma_fdy = '';
            $phieuTheoDoi->khach_hang = $phieuTKSX[0]->khach_hang;
            $phieuTheoDoi->yeu_cau_khach_hang = $phieuTKSX[0]->qa_kien_nghi;
            $phieuTheoDoi->dieu_kien_khach_hang = $phieuTKSX[0]->dieu_kien_khach_hang;
            $phieuTheoDoi->khoi_luong = $phieuTKSX[0]->so_luong_don_hang;
            $phieuTheoDoi->created_user = Auth::user()->username;
            $phieuTheoDoi->updated_user = Auth::user()->username;
    
            $phieuTheoDoi->save();
    
            $phieuTheoDoiLog = new TheoDoiSXDTYLog();
    
            $phieuTheoDoiLog->ma_hang = $this->maHang;
            $phieuTheoDoiLog->may = $phieuTKSX[0]->may;
            $phieuTheoDoiLog->quy_cach = $phieuTKSX[0]->quy_cach_dty;
            $phieuTheoDoiLog->don_chap = $phieuTKSX[0]->soi;
            $phieuTheoDoiLog->ma_cu_moi = $phieuTKSX[0]->ma_cu_moi;
            $phieuTheoDoiLog->line_poy = trim($linePOY);
            $phieuTheoDoiLog->ma_poy = trim($phieuTKSX[0]->ma_poy);
            $phieuTheoDoiLog->ma_fdy = '';
            $phieuTheoDoiLog->khach_hang = $phieuTKSX[0]->khach_hang;
            $phieuTheoDoi->yeu_cau_khach_hang = $phieuTKSX[0]->qa_kien_nghi;
            $phieuTheoDoi->dieu_kien_khach_hang = $phieuTKSX[0]->dieu_kien_khach_hang;
            $phieuTheoDoiLog->khoi_luong = $phieuTKSX[0]->so_luong_don_hang;
            $phieuTheoDoiLog->status = 'Thêm mới';
            $phieuTheoDoiLog->created_user = Auth::user()->username;
            $phieuTheoDoiLog->updated_user = Auth::user()->username;
    
            $phieuTheoDoiLog->save();
    
            flash()->addSuccess('Thêm mới thành công');
            $this->emit('closeModal');
            $this->state = 'main';

        }

    }

    public function edit($idPhieu){

        $this->state = 'edit';
        $this->idPhieu = $idPhieu;

    }

    public function update(){

        $phieu = TheoDoiSXDTY::where('id', $this->idPhieu)->first();

        $phieu->ngay_sx_chinh_thuc = $this->ngaySXChinhThuc ? Carbon::create($this->ngaySXChinhThuc)->isoFormat('YYYY-MM-DD') : null;
        $phieu->ngay_kiem_tra_tskt = $this->ngayKiemTraTSKT ? Carbon::create($this->ngayKiemTraTSKT)->isoFormat('YYYY-MM-DD') : null;
        $phieu->ngay_qc_gui_tskt = $this->ngayQCKiemTSKT ? Carbon::create($this->ngayQCKiemTSKT)->isoFormat('YYYY-MM-DD') : null;
        $phieu->ket_qua = $this->ketQua;
        $phieu->file = $this->fileDinhKem != null ? $this->fileDinhKem->getClientOriginalName() : null;
        $phieu->status = 'Đã cập nhật';
        $phieu->updated_user = Auth::user()->username;

        $phieu->save();

        $phieuTheoDoiLog = new TheoDoiSXDTYLog();
        $phieuTheoDoiLog->tksx = $phieu->tksx;
        $phieuTheoDoiLog->ma_hang = $phieu->ma_hang;
        $phieuTheoDoiLog->may = $phieu->may;
        $phieuTheoDoiLog->quy_cach = $phieu->quy_cach;
        $phieuTheoDoiLog->don_chap = $phieu->don_chap;
        $phieuTheoDoiLog->ma_cu_moi = $phieu->ma_cu_moi;
        $phieuTheoDoiLog->line_poy = $phieu->line_poy;
        $phieuTheoDoiLog->ma_poy = $phieu->ma_poy;
        $phieuTheoDoiLog->ma_fdy = '';
        $phieuTheoDoiLog->khach_hang = $phieu->khach_hang;
        $phieuTheoDoiLog->yeu_cau_khach_hang = $phieu->yeu_cau_khach_hang;
        $phieuTheoDoiLog->dieu_kien_khach_hang = $phieu->dieu_kien_khach_hang;
        $phieuTheoDoiLog->khoi_luong = $phieu->khoi_luong;
        $phieuTheoDoiLog->ngay_qa_ky_tk = $phieu->ngay_qa_ky_tk;
        $phieuTheoDoiLog->ngay_tk = $phieu->ngay_tk;
        $phieuTheoDoiLog->ngay_sx_chinh_thuc = $phieu->ngay_sx_chinh_thuc;
        $phieuTheoDoiLog->ngay_kiem_tra_tskt = $phieu->ngay_kiem_tra_tskt;
        $phieuTheoDoiLog->ngay_qc_gui_tskt = $phieu->ngay_qc_gui_tskt;
        $phieuTheoDoiLog->ket_qua = $phieu->ket_qua;
        $phieuTheoDoiLog->file = $phieu->file;
        $phieu->file = $this->fileDinhKem != null ? $this->fileDinhKem->getClientOriginalName() : null;
        $phieuTheoDoiLog->status = 'Cập nhật';
        $phieuTheoDoiLog->created_user = Auth::user()->username;
        $phieuTheoDoiLog->updated_user = Auth::user()->username;

        $phieuTheoDoiLog->save();

        $path = 'TheoDoiTKSX/' . $phieu->id;

        if(!Storage::disk('ftp')->exists($path)) {

            Storage::disk('ftp')->makeDirectory($path);

        }

        Storage::disk('ftp')->putFileAs($path, $this->fileDinhKem, $this->fileDinhKem->getClientOriginalName());

        flash()->addSuccess('Cập nhật thành công');
        $this->emit('closeModal');
        $this->state = 'main';

    }

    public function duyetModal($idPhieu){

        $this->state = 'duyet';
        $this->idPhieu = $idPhieu;

    }

    public function duyet(){

        $phieu = TheoDoiSXDTY::where('id', $this->idPhieu)->first();
        $phieu->status = 'Đã duyệt';
        $phieu->updated_user = Auth::user()->username;
        $phieu->save();

        $phieuTheoDoiLog = new TheoDoiSXDTYLog();
        $phieuTheoDoiLog->tksx = $phieu->tksx;
        $phieuTheoDoiLog->ma_hang = $phieu->ma_hang;
        $phieuTheoDoiLog->may = $phieu->may;
        $phieuTheoDoiLog->quy_cach = $phieu->quy_cach;
        $phieuTheoDoiLog->don_chap = $phieu->don_chap;
        $phieuTheoDoiLog->ma_cu_moi = $phieu->ma_cu_moi;
        $phieuTheoDoiLog->line_poy = $phieu->line_poy;
        $phieuTheoDoiLog->ma_poy = $phieu->ma_poy;
        $phieuTheoDoiLog->ma_fdy = '';
        $phieuTheoDoiLog->khach_hang = $phieu->khach_hang;
        $phieuTheoDoiLog->yeu_cau_khach_hang = $phieu->yeu_cau_khach_hang;
        $phieuTheoDoiLog->dieu_kien_khach_hang = $phieu->dieu_kien_khach_hang;
        $phieuTheoDoiLog->khoi_luong = $phieu->khoi_luong;
        $phieuTheoDoiLog->ngay_qa_ky_tk = $phieu->ngay_qa_ky_tk;
        $phieuTheoDoiLog->ngay_tk = $phieu->ngay_tk;
        $phieuTheoDoiLog->ngay_sx_chinh_thuc = $phieu->ngay_sx_chinh_thuc;
        $phieuTheoDoiLog->ngay_kiem_tra_tskt = $phieu->ngay_kiem_tra_tskt;
        $phieuTheoDoiLog->ngay_qc_gui_tskt = $phieu->ngay_qc_gui_tskt;
        $phieuTheoDoiLog->ket_qua = $phieu->ket_qua;
        $phieuTheoDoiLog->file = $phieu->file;
        $phieuTheoDoiLog->status = 'Duyệt';
        $phieuTheoDoiLog->created_user = Auth::user()->username;
        $phieuTheoDoiLog->updated_user = Auth::user()->username;

        $phieuTheoDoiLog->save();

        flash()->addSuccess('Duyệt thành công');
        $this->emit('closeModal');
        $this->state = 'main';

    }

    public function download($id, $file){

        return Storage::disk('ftp')->download('TheoDoiTKSX/' . $id . '/' . $file);

    }

    public function timKiem(){

        $this->state = 'main';

    }

    public function radioClick(){

        $this->resetPage();

    }

    public function taiFile(){
        if($this->radioTongQuatChiTiet == 'choCapNhat'){

            $main = DB::table('theo_doi_s_x_d_t_y_s')
            ->where('status' , 'Thêm mới')
            ->where(function($query){

                $query->whereRaw("'" . $this->maHangTimKiem . "' = ''");
                $query->orWhere('ma_hang', 'like', '%' . $this->maHangTimKiem . '%');
    
            })
            ->where(function($query){
    
                $query->whereRaw("'" . $this->quyCachTimKiem . "' = ''");
                $query->orWhere('quy_cach', 'like', '%' . $this->quyCachTimKiem . '%');
    
            })
            ->where(function($query){
    
                $query->whereRaw("'" . $this->tenKhachHangTimKiem . "' = ''");
                $query->orWhere('khach_hang', 'like', '%' . $this->tenKhachHangTimKiem . '%');
    
            })
            ->where(function($query){

                $query->whereRaw("'" . $this->nhaMayTimKiem . "' = ''");
                $query->orWhere('tksx', 'like', '%' . $this->nhaMayTimKiem . '%');
    
            })
            ->orderByDesc('created_at')
            ->select('tksx',
            'may',
            'ma_hang',
            'quy_cach',
            'don_chap',
            'ma_cu_moi',
            'line_poy',
            'ma_poy',
            'khach_hang',
            'yeu_cau_khach_hang',
            'dieu_kien_khach_hang',
            'khoi_luong',
            'ngay_qa_ky_tk',
            'ngay_tk',
            'ngay_sx_chinh_thuc',
            'ngay_kiem_tra_tskt',
            'ngay_qc_gui_tskt',
            'ket_qua',)
            ->get();

        }elseif($this->radioTongQuatChiTiet == 'choDuyet'){

            $main = DB::table('theo_doi_s_x_d_t_y_s')
            ->where('status' , 'Đã cập nhật')
            ->where(function($query){

                $query->whereRaw("'" . $this->maHangTimKiem . "' = ''");
                $query->orWhere('ma_hang', 'like', '%' . $this->maHangTimKiem . '%');
    
            })
            ->where(function($query){
    
                $query->whereRaw("'" . $this->quyCachTimKiem . "' = ''");
                $query->orWhere('quy_cach', 'like', '%' . $this->quyCachTimKiem . '%');
    
            })
            ->where(function($query){
    
                $query->whereRaw("'" . $this->tenKhachHangTimKiem . "' = ''");
                $query->orWhere('khach_hang', 'like', '%' . $this->tenKhachHangTimKiem . '%');
    
            })
            ->where(function($query){

                $query->whereRaw("'" . $this->nhaMayTimKiem . "' = ''");
                $query->orWhere('tksx', 'like', '%' . $this->nhaMayTimKiem . '%');
    
            })
            ->orderByDesc('created_at')
            ->select('tksx',
            'may',
            'ma_hang',
            'quy_cach',
            'don_chap',
            'ma_cu_moi',
            'line_poy',
            'ma_poy',
            'khach_hang',
            'yeu_cau_khach_hang',
            'dieu_kien_khach_hang',
            'khoi_luong',
            'ngay_qa_ky_tk',
            'ngay_tk',
            'ngay_sx_chinh_thuc',
            'ngay_kiem_tra_tskt',
            'ngay_qc_gui_tskt',
            'ket_qua',)
            ->get();

        }else{

            $main = DB::table('theo_doi_s_x_d_t_y_s')
            ->where('status' , 'Đã duyệt')
            ->where(function($query){

                $query->whereRaw("'" . $this->maHangTimKiem . "' = ''");
                $query->orWhere('ma_hang', 'like', '%' . $this->maHangTimKiem . '%');
    
            })
            ->where(function($query){
    
                $query->whereRaw("'" . $this->quyCachTimKiem . "' = ''");
                $query->orWhere('quy_cach', 'like', '%' . $this->quyCachTimKiem . '%');
    
            })
            ->where(function($query){
    
                $query->whereRaw("'" . $this->tenKhachHangTimKiem . "' = ''");
                $query->orWhere('khach_hang', 'like', '%' . $this->tenKhachHangTimKiem . '%');
    
            })
            ->where(function($query){

                $query->whereRaw("'" . $this->nhaMayTimKiem . "' = ''");
                $query->orWhere('tksx', 'like', '%' . $this->nhaMayTimKiem . '%');
    
            })
            ->orderByDesc('created_at')
            ->select('tksx',
            'may',
            'ma_hang',
            'quy_cach',
            'don_chap',
            'ma_cu_moi',
            'line_poy',
            'ma_poy',
            'khach_hang',
            'yeu_cau_khach_hang',
            'dieu_kien_khach_hang',
            'khoi_luong',
            'ngay_qa_ky_tk',
            'ngay_tk',
            'ngay_sx_chinh_thuc',
            'ngay_kiem_tra_tskt',
            'ngay_qc_gui_tskt',
            'ket_qua',)
            ->get();

        }

        return Excel::download(new TheoDoiTKSX($main), 'Theo dõi TKSX.xlsx');

    }

    public function render()
    {
        if($this->state == 'main'){

            if($this->radioTongQuatChiTiet == 'choCapNhat'){

                $main = DB::table('theo_doi_s_x_d_t_y_s')
                ->where('status' , 'Thêm mới')
                ->where(function($query){

                    $query->whereRaw("'" . $this->maHangTimKiem . "' = ''");
                    $query->orWhere('ma_hang', 'like', '%' . $this->maHangTimKiem . '%');
        
                })
                ->where(function($query){
        
                    $query->whereRaw("'" . $this->quyCachTimKiem . "' = ''");
                    $query->orWhere('quy_cach', 'like', '%' . $this->quyCachTimKiem . '%');
        
                })
                ->where(function($query){
        
                    $query->whereRaw("'" . $this->tenKhachHangTimKiem . "' = ''");
                    $query->orWhere('khach_hang', 'like', '%' . $this->tenKhachHangTimKiem . '%');
        
                })
                ->where(function($query){

                    $query->whereRaw("'" . $this->nhaMayTimKiem . "' = ''");
                    $query->orWhere('tksx', 'like', '%' . $this->nhaMayTimKiem . '%');
        
                })->orderByDesc('created_at')
            
                ->paginate($this->paginate);

                session(['main' => $main]);

            }elseif($this->radioTongQuatChiTiet == 'choDuyet'){

                $main = DB::table('theo_doi_s_x_d_t_y_s')
                ->where('status' , 'Đã cập nhật')
                ->where(function($query){

                    $query->whereRaw("'" . $this->maHangTimKiem . "' = ''");
                    $query->orWhere('ma_hang', 'like', '%' . $this->maHangTimKiem . '%');
        
                })
                ->where(function($query){
        
                    $query->whereRaw("'" . $this->quyCachTimKiem . "' = ''");
                    $query->orWhere('quy_cach', 'like', '%' . $this->quyCachTimKiem . '%');
        
                })
                ->where(function($query){
        
                    $query->whereRaw("'" . $this->tenKhachHangTimKiem . "' = ''");
                    $query->orWhere('khach_hang', 'like', '%' . $this->tenKhachHangTimKiem . '%');
        
                })
                ->where(function($query){

                    $query->whereRaw("'" . $this->nhaMayTimKiem . "' = ''");
                    $query->orWhere('tksx', 'like', '%' . $this->nhaMayTimKiem . '%');
        
                })->orderByDesc('created_at')
            
                ->paginate($this->paginate);

                session(['main' => $main]);

            }else{

                $main = DB::table('theo_doi_s_x_d_t_y_s')
                ->where('status' , 'Đã duyệt')
                ->where(function($query){

                    $query->whereRaw("'" . $this->maHangTimKiem . "' = ''");
                    $query->orWhere('ma_hang', 'like', '%' . $this->maHangTimKiem . '%');
        
                })
                ->where(function($query){
        
                    $query->whereRaw("'" . $this->quyCachTimKiem . "' = ''");
                    $query->orWhere('quy_cach', 'like', '%' . $this->quyCachTimKiem . '%');
        
                })
                ->where(function($query){
        
                    $query->whereRaw("'" . $this->tenKhachHangTimKiem . "' = ''");
                    $query->orWhere('khach_hang', 'like', '%' . $this->tenKhachHangTimKiem . '%');
        
                })
                ->where(function($query){

                    $query->whereRaw("'" . $this->nhaMayTimKiem . "' = ''");
                    $query->orWhere('tksx', 'like', '%' . $this->nhaMayTimKiem . '%');
        
                })->orderByDesc('created_at')
            
                ->paginate($this->paginate);

                session(['main' => $main]);

            }

        }

        return view('livewire.theo-doi-t-k-s-x-d-t-y');
    }
}
