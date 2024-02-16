<?php

namespace App\Http\Livewire;

use App\Mail\TieuChuanKhachHangMail;
use App\Models\BenB;
use App\Models\LoaiMayDet;
use App\Models\TieuChuanKhachHang as ModelsTieuChuanKhachHang;
use App\Models\TieuChuanKhachHangLog;
use App\Models\User;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;

class TieuChuanKhachHang extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'page' => ['except' => 1],
    ];

    public $soPhieuTimKiem, $tenKhachHangTimKiem, $quyCachSoiTimKiem, $radioTimKiem;

    public $danhSachKhachHang;

    public $state;

    public $soPhieu;

    public ModelsTieuChuanKhachHang $tieuChuanKhachHangModel;

    public $tieuChuanKhachHangLog;

    public $danhSachLoaiMayDet;

    protected $rules = [
        'tieuChuanKhachHangModel.ma_khach_hang' => 'string',
        'tieuChuanKhachHangModel.loai_may_det' => 'string',
        'tieuChuanKhachHangModel.quy_cach_soi' => 'string',
        'tieuChuanKhachHangModel.chung_loai_soi' => 'string',
        'tieuChuanKhachHangModel.chip' => 'string',
        'tieuChuanKhachHangModel.khach_hang_chi_dinh_chip' => 'string',
        'tieuChuanKhachHangModel.lot' => 'string',
        'tieuChuanKhachHangModel.twist' => 'string',
        'tieuChuanKhachHangModel.denier' => 'string',
        'tieuChuanKhachHangModel.tenacity' => 'string',
        'tieuChuanKhachHangModel.elongation' => 'string',
        'tieuChuanKhachHangModel.dty_bws' => 'string',
        'tieuChuanKhachHangModel.dty_cr' => 'string',
        'tieuChuanKhachHangModel.dty_cc' => 'string',
        'tieuChuanKhachHangModel.dty_oil_pick' => 'string',
        'tieuChuanKhachHangModel.dty_knots' => 'string',
        'tieuChuanKhachHangModel.stability' => 'string',
        'tieuChuanKhachHangModel.ti02' => 'string',
        'tieuChuanKhachHangModel.times' => 'string',
        'tieuChuanKhachHangModel.torque' => 'string',
        'tieuChuanKhachHangModel.yeu_cau_tem' => 'string',
        'tieuChuanKhachHangModel.thong_tin_khac' => 'string',
    ];

    public function mount(){

        $this->state = 'main';
        $this->radioTimKiem = 'choDuyet';

    }

    public function resetInputField(){

    }

    public function create(){

        $this->state = 'create';
        $this->tieuChuanKhachHangModel = new ModelsTieuChuanKhachHang();

    }

    public function store()
    {
        $soPhieu = IdGenerator::generate(['table' => 'tieu_chuan_khach_hang', 'field' => 'so_phieu', 'length' => '9', 'prefix' => 'TCKH', 'reset_on_prefix_change' => true]);

        $benB = BenB::where('ma_khach_hang', $this->tieuChuanKhachHangModel->ma_khach_hang)->first();

        $this->tieuChuanKhachHangModel->so_phieu = $soPhieu;
        $this->tieuChuanKhachHangModel->ten_khach_hang = $benB->ten_tv;
        $this->tieuChuanKhachHangModel->status = 'Mới';
        $this->tieuChuanKhachHangModel->created_user = auth()->user()->username;
        $this->tieuChuanKhachHangModel->updated_user = auth()->user()->username;
        $this->tieuChuanKhachHangModel->qa_tao = auth()->user()->username;
        $this->tieuChuanKhachHangModel->qa_tao_at = Carbon::now();
        $this->tieuChuanKhachHangModel->save();

        $log = new TieuChuanKhachHangLog();
        $log->so_phieu = $soPhieu;
        $log->ma_khach_hang = $this->tieuChuanKhachHangModel->ma_khach_hang;
        $log->ten_khach_hang = $this->tieuChuanKhachHangModel->ten_khach_hang;
        $log->loai_may_det = $this->tieuChuanKhachHangModel->loai_may_det;
        $log->quy_cach_soi = $this->tieuChuanKhachHangModel->quy_cach_soi;
        $log->chung_loai_soi = $this->tieuChuanKhachHangModel->chung_loai_soi;
        $log->chip = $this->tieuChuanKhachHangModel->chip;
        $log->khach_hang_chi_dinh_chip = $this->tieuChuanKhachHangModel->khach_hang_chi_dinh_chip;
        $log->lot = $this->tieuChuanKhachHangModel->lot;
        $log->twist = $this->tieuChuanKhachHangModel->twist;
        $log->denier = $this->tieuChuanKhachHangModel->denier;
        $log->tenacity = $this->tieuChuanKhachHangModel->tenacity;
        $log->elongation = $this->tieuChuanKhachHangModel->elongation;
        $log->dty_bws = $this->tieuChuanKhachHangModel->dty_bws;
        $log->dty_cr = $this->tieuChuanKhachHangModel->dty_cr;
        $log->dty_cc = $this->tieuChuanKhachHangModel->dty_cc;
        $log->dty_oil_pick = $this->tieuChuanKhachHangModel->dty_oil_pick;
        $log->dty_knots = $this->tieuChuanKhachHangModel->dty_knots;
        $log->stability = $this->tieuChuanKhachHangModel->stability;
        $log->ti02 = $this->tieuChuanKhachHangModel->ti02;
        $log->times = $this->tieuChuanKhachHangModel->times;
        $log->torque = $this->tieuChuanKhachHangModel->torque;
        $log->yeu_cau_tem = $this->tieuChuanKhachHangModel->yeu_cau_tem;
        $log->thong_tin_khac = $this->tieuChuanKhachHangModel->thong_tin_khac;
        $log->status = 'Mới';
        $log->created_user = auth()->user()->username;
        $log->updated_user = auth()->user()->username;
        $log->save();

        $arrayMail = [
            'Mới',
            $soPhieu,
            $this->tieuChuanKhachHangModel->ten_khach_hang,
        ];

        flash()->addSuccess('Tạo phiếu thành công.');
        $this->emit('closeModal');
        $this->state = 'main';
        Mail::to('sales@century.vn')->send(new TieuChuanKhachHangMail($arrayMail));
    }

    public function show($soPhieu){

        $this->state = 'show';
        $this->soPhieu = $soPhieu;

    }

    public function approveModal($soPhieu){

        $this->state = 'approve';
        $this->soPhieu = $soPhieu;

    }

    public function approve(){

        if ($this->tieuChuanKhachHangModel->status == 'Mới') {

            $this->tieuChuanKhachHangModel->sale_duyet = auth()->user()->username;
            $this->tieuChuanKhachHangModel->sale_duyet_at = Carbon::now();
            $this->tieuChuanKhachHangModel->updated_user = auth()->user()->username;
            $this->tieuChuanKhachHangModel->status = 'Sale đã duyệt';
            $this->tieuChuanKhachHangModel->save();

            $arrayMail = [
                'Sale đã duyệt',
                $this->tieuChuanKhachHangModel->so_phieu,
                $this->tieuChuanKhachHangModel->ten_khach_hang,
            ];

            Mail::to('qa@century.vn')->send(new TieuChuanKhachHangMail($arrayMail));

        }else{

            $this->tieuChuanKhachHangModel->quan_ly_qa_duyet = auth()->user()->username;
            $this->tieuChuanKhachHangModel->quan_ly_qa_duyet_at = Carbon::now();
            $this->tieuChuanKhachHangModel->updated_user = auth()->user()->username;
            $this->tieuChuanKhachHangModel->status = 'QA đã duyệt';
            $this->tieuChuanKhachHangModel->save();

            $arrayMail = [
                'QA đã duyệt',
                $this->tieuChuanKhachHangModel->so_phieu,
                $this->tieuChuanKhachHangModel->ten_khach_hang,
            ];

            $user = User::where('username', $this->tieuChuanKhachHangModel->created_user)->first();

            Mail::to($user->email)->send(new TieuChuanKhachHangMail($arrayMail));

        }
        

        $log = new TieuChuanKhachHangLog();
        $log->so_phieu = $this->tieuChuanKhachHangModel->so_phieu;
        $log->ma_khach_hang = $this->tieuChuanKhachHangModel->ma_khach_hang;
        $log->ten_khach_hang = $this->tieuChuanKhachHangModel->ten_khach_hang;
        $log->loai_may_det = $this->tieuChuanKhachHangModel->loai_may_det;
        $log->quy_cach_soi = $this->tieuChuanKhachHangModel->quy_cach_soi;
        $log->chung_loai_soi = $this->tieuChuanKhachHangModel->chung_loai_soi;
        $log->chip = $this->tieuChuanKhachHangModel->chip;
        $log->khach_hang_chi_dinh_chip = $this->tieuChuanKhachHangModel->khach_hang_chi_dinh_chip;
        $log->lot = $this->tieuChuanKhachHangModel->lot;
        $log->twist = $this->tieuChuanKhachHangModel->twist;
        $log->denier = $this->tieuChuanKhachHangModel->denier;
        $log->tenacity = $this->tieuChuanKhachHangModel->tenacity;
        $log->elongation = $this->tieuChuanKhachHangModel->elongation;
        $log->dty_bws = $this->tieuChuanKhachHangModel->dty_bws;
        $log->dty_cr = $this->tieuChuanKhachHangModel->dty_cr;
        $log->dty_cc = $this->tieuChuanKhachHangModel->dty_cc;
        $log->dty_oil_pick = $this->tieuChuanKhachHangModel->dty_oil_pick;
        $log->dty_knots = $this->tieuChuanKhachHangModel->dty_knots;
        $log->stability = $this->tieuChuanKhachHangModel->stability;
        $log->ti02 = $this->tieuChuanKhachHangModel->ti02;
        $log->times = $this->tieuChuanKhachHangModel->times;
        $log->torque = $this->tieuChuanKhachHangModel->torque;
        $log->status = $this->tieuChuanKhachHangModel->status;
        $log->yeu_cau_tem = $this->tieuChuanKhachHangModel->yeu_cau_tem;
        $log->thong_tin_khac = $this->tieuChuanKhachHangModel->thong_tin_khac;
        $log->created_user = auth()->user()->username;
        $log->updated_user = auth()->user()->username;
        $log->save();

        flash()->addSuccess('Duyệt phiếu thành công.');
        $this->emit('closeModal');
        $this->state = 'main';

    }

    public function edit($soPhieu){

        $this->state = 'edit';
        $this->soPhieu = $soPhieu;

    }

    public function update(){

        $this->tieuChuanKhachHangModel->save();

        $log = new TieuChuanKhachHangLog();
        $log->so_phieu = $this->tieuChuanKhachHangModel->so_phieu;
        $log->ma_khach_hang = $this->tieuChuanKhachHangModel->ma_khach_hang;
        $log->ten_khach_hang = $this->tieuChuanKhachHangModel->ten_khach_hang;
        $log->loai_may_det = $this->tieuChuanKhachHangModel->loai_may_det;
        $log->quy_cach_soi = $this->tieuChuanKhachHangModel->quy_cach_soi;
        $log->chung_loai_soi = $this->tieuChuanKhachHangModel->chung_loai_soi;
        $log->chip = $this->tieuChuanKhachHangModel->chip;
        $log->khach_hang_chi_dinh_chip = $this->tieuChuanKhachHangModel->khach_hang_chi_dinh_chip;
        $log->lot = $this->tieuChuanKhachHangModel->lot;
        $log->twist = $this->tieuChuanKhachHangModel->twist;
        $log->denier = $this->tieuChuanKhachHangModel->denier;
        $log->tenacity = $this->tieuChuanKhachHangModel->tenacity;
        $log->elongation = $this->tieuChuanKhachHangModel->elongation;
        $log->dty_bws = $this->tieuChuanKhachHangModel->dty_bws;
        $log->dty_cr = $this->tieuChuanKhachHangModel->dty_cr;
        $log->dty_cc = $this->tieuChuanKhachHangModel->dty_cc;
        $log->dty_oil_pick = $this->tieuChuanKhachHangModel->dty_oil_pick;
        $log->dty_knots = $this->tieuChuanKhachHangModel->dty_knots;
        $log->stability = $this->tieuChuanKhachHangModel->stability;
        $log->ti02 = $this->tieuChuanKhachHangModel->ti02;
        $log->times = $this->tieuChuanKhachHangModel->times;
        $log->torque = $this->tieuChuanKhachHangModel->torque;
        $log->yeu_cau_tem = $this->tieuChuanKhachHangModel->yeu_cau_tem;
        $log->thong_tin_khac = $this->tieuChuanKhachHangModel->thong_tin_khac;
        $log->status = 'Cập nhật';
        $log->created_user = auth()->user()->username;
        $log->updated_user = auth()->user()->username;
        $log->save();

        flash()->addSuccess('Cập nhật phiếu thành công.');
        $this->emit('closeModal');
        $this->state = 'main';

    }

    public function timKiem(){

        $this->state = 'timKiem';

    }

    public function render()
    {
        if($this->state == 'main' || $this->state == 'timKiem'){

            $queryString = ModelsTieuChuanKhachHang::query();

            $queryString->where(function($query){

                $query->whereRaw("'" . $this->soPhieuTimKiem . "' = ''");
                $query->orWhere('so_phieu', $this->soPhieuTimKiem);
    
            });

            $queryString->where(function($query){

                $query->whereRaw("'" . $this->tenKhachHangTimKiem . "' = ''");
                $query->orWhere('ten_khach_hang', 'like', '%' . $this->tenKhachHangTimKiem . '%');
    
            });

            $queryString->where(function($query){

                $query->whereRaw("'" . $this->quyCachSoiTimKiem . "' = ''");
                $query->orWhere('quy_cach_soi', 'like', '%' . $this->quyCachSoiTimKiem . '%');
    
            });

            if (auth()->user()->hasPermissionTo('create_tckh')) {
                if ($this->radioTimKiem == 'choDuyet') {
                    $queryString->where('created_user', auth()->user()->username);
                    $queryString->where('status', '!=', 'QA đã duyệt');
                }elseif ($this->radioTimKiem == 'daDuyet'){
                    $queryString->where('created_user', auth()->user()->username);
                    $queryString->where('status', 'QA đã duyệt');
                }
            }elseif (auth()->user()->hasPermissionTo('sale_duyet_tckh')) {
                if ($this->radioTimKiem == 'choDuyet') {
                    $queryString->where('status', 'Mới');
                }elseif ($this->radioTimKiem == 'daDuyet'){
                    $queryString->where('sale_duyet', auth()->user()->username);
                }
            }elseif (auth()->user()->hasPermissionTo('qa_duyet_tckh')) {
                if ($this->radioTimKiem == 'choDuyet') {
                    $queryString->where('status', 'Sale đã duyệt');
                }elseif ($this->radioTimKiem == 'daDuyet'){
                    $queryString->where('quan_ly_qa_duyet', auth()->user()->username);
                }
            }
    
            session(['main' => $queryString->paginate(15)]);

        }elseif($this->state == 'create'){

            $this->danhSachKhachHang = BenB::all();
            $this->danhSachLoaiMayDet = LoaiMayDet::all();

        }elseif($this->state == 'show'){

            $this->tieuChuanKhachHangModel = ModelsTieuChuanKhachHang::where('so_phieu', $this->soPhieu)->first();
            $this->tieuChuanKhachHangLog = TieuChuanKhachHangLog::where('so_phieu', $this->soPhieu)->get();

        }elseif($this->state == 'edit'){

            $this->danhSachKhachHang = BenB::all();
            $this->tieuChuanKhachHangModel = ModelsTieuChuanKhachHang::where('so_phieu', $this->soPhieu)->first();
            $this->danhSachLoaiMayDet = LoaiMayDet::all();

        }elseif($this->state == 'approve'){

            $this->tieuChuanKhachHangModel = ModelsTieuChuanKhachHang::where('so_phieu', $this->soPhieu)->first();

        }

        return view('livewire.tieu-chuan-khach-hang');
    }
}
