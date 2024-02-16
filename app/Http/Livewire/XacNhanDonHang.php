<?php

namespace App\Http\Livewire;

use App\Mail\XacNhanDonHangMail;
use App\Models\BenB;
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
use TNkemdilim\MoneyToWords\Converter;
use TNkemdilim\MoneyToWords\Languages as Language;

class XacNhanDonHang extends Component
{
    public $soPhieu, $loai, $ngay, $benA, $diaChiBenA, $benB, $diaChiBenB, $incoterm, $thoiGianGiaoHang, $xuatXu, $dongGoi, $hinhThucThanhToan, $thoiGianThanhToan, $diaDiemGiaoHang, $ghiChu, $status;

    public $quyCach, $soLuong, $donGia;

    public $quyCachEdit, $soLuongEdit, $donGiaEdit;

    public $search, $tuNgay, $denNgay, $canhan_tatca, $paginate;

    public $danhSachBenB, $danhSachQuyCach, $log;

    public $inputs = [], $i = 0;

    public $state;

    public $XNDHQuyCach;

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function resetInputField(){

        $this->inputs = [];
        $this->i = 0;

        $this->state = 'main';
        $this->loai = 'nd';
        $this->ngay = null;
        $this->diaChiBenB = null;
        $this->incoterm = null;
        $this->quyCach = null;
        $this->soLuong = null;
        $this->donGia = null;
        $this->thoiGianGiaoHang = null;
        $this->xuatXu = null;
        $this->dongGoi = null;
        $this->hinhThucThanhToan = null;
        $this->thoiGianThanhToan = null;
        $this->diaDiemGiaoHang = null;
        $this->ghiChu = null;

    }

    public function mount(){
        
        $this->paginate = 15;
        $this->canhan_tatca = 'phieuDoiDuyet';
        $this->loai = 'nd';
        $this->state = 'main';

    }

    public function addQuyCach($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs ,$i);
    }

    public function removeQuyCach($i)
    {
        unset($this->inputs[$i]);
    }

    public function addXNDHModal(){

        $this->state = 'add';
        
    }

    public function addXNDH(){

        DB::transaction(function(){

            $this->soPhieu = IdGenerator::generate(['table' => 'xac_nhan_don_hang', 'field' => 'so_phieu', 'length' => '14', 'prefix' => 'XNDH-' . Carbon::now()->isoFormat('DDMMYY') . '-','reset_on_prefix_change' => true]);

            if($this->benA == 'congTy'){

                if($this->loai == 'nd'){
                    $tenBenA = 'CÔNG TY CỔ PHẦN SỢI THẾ KỶ';
                    $diaChiBenA = 'B1-1 KCN Tây Bắc Củ Chi, Huyện Củ Chi, TP. Hồ Chí Minh, Việt Nam.';
                }    
                else{
                    $tenBenA = 'CENTURY SYNTHETIC FIBER CORPORATION';
                    $diaChiBenA = 'B1-1, CU CHI NORTHWEST INDUSTRIAL ZONE, CU CHI DISTRICT, HO CHI MINH CITY, VIETNAM.';
                }
                    
            }else{
                if($this->loai == 'nd'){
                    $tenBenA = 'CHI NHÁNH  CÔNG TY  CP SỢI THẾ KỶ';
                    $diaChiBenA = 'Đường số 8- KCN Trảng Bàng , P An Tịnh, Thị  Xã Trảng Bàng , Tỉnh Tây Ninh, Việt Nam.';
                }  
                else{
                    $tenBenA = 'CENTURY SYNTHETIC FIBER CORPORATION- BRANCH';
                    $diaChiBenA = 'Road no.08, Trang Bang Industrial Zone, An Tinh Ward, Trang Bang Town, Tay Ninh Province, Viet Nam.';
                }
            }

            DB::table('xac_nhan_don_hang')->insert([

                'so_phieu' => $this->soPhieu,
                'loai' => $this->loai,
                'ngay' => $this->ngay,
                'ben_a' => $tenBenA,
                'dia_chi_ben_a' => $diaChiBenA,
                'ben_b' => $this->benB,
                'dia_chi_ben_b' => $this->diaChiBenB,
                'incoterm' => $this->incoterm,
                'thoi_gian_giao_hang' => $this->thoiGianGiaoHang,
                'xuat_xu' => $this->xuatXu,
                'dong_goi' => $this->dongGoi,
                'hinh_thuc_thanh_toan' => $this->hinhThucThanhToan,
                'thoi_gian_thanh_toan' => $this->thoiGianThanhToan,
                'dia_diem_giao_hang' => $this->diaDiemGiaoHang,
                'ghi_chu' => $this->ghiChu,
                'new' => Auth::user()->username,
                'new_at' => Carbon::now(),
                'status' => 'New',
                'created_user' => Auth::user()->username,
                'updated_user' => Auth::user()->username,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ]);

            $idLog = DB::table('xac_nhan_don_hang_log')->insertGetId([

                'so_phieu' => $this->soPhieu,
                'loai' => $this->loai,
                'ngay' => $this->ngay,
                'ben_a' => $tenBenA,
                'dia_chi_ben_a' => $diaChiBenA,
                'ben_b' => $this->benB,
                'dia_chi_ben_b' => $this->diaChiBenB,
                'incoterm' => $this->incoterm,
                'thoi_gian_giao_hang' => $this->thoiGianGiaoHang,
                'xuat_xu' => $this->xuatXu,
                'dong_goi' => $this->dongGoi,
                'hinh_thuc_thanh_toan' => $this->hinhThucThanhToan,
                'thoi_gian_thanh_toan' => $this->thoiGianThanhToan,
                'dia_diem_giao_hang' => $this->diaDiemGiaoHang,
                'ghi_chu' => $this->ghiChu,
                'status' => 'New',
                'status_log' => 'Created',
                'created_user' => Auth::user()->username,
                'updated_user' => Auth::user()->username,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ]);

            foreach (array_reverse($this->quyCach, true) as $key => $value) {

                DB::table('xac_nhan_don_hang_quy_cach')->insert([

                    'so_phieu' => $this->soPhieu,
                    'quy_cach' => $this->quyCach[$key],
                    'so_luong' => $this->soLuong[$key],
                    'don_gia' => $this->donGia[$key],

                ]);

                DB::table('xac_nhan_don_hang_quy_cach_log')->insert([

                    'so_phieu' => $this->soPhieu,
                    'id_log' => $idLog,
                    'quy_cach' => $this->quyCach[$key],
                    'so_luong' => $this->soLuong[$key],
                    'don_gia' => $this->donGia[$key],

                ]);

            }

            if($this->loai == 'nd'){

                $users = User::permission('approve_1_xac_nhan_don_hang')->first();

                Mail::to($users->email)->later(now()->addMinutes(1), new XacNhanDonHangMail('New',$this->soPhieu, Auth::user()->username, Carbon::now()));

            }elseif($this->loai == 'xk'){
            
                $users = User::permission('approve_2_xac_nhan_don_hang')->first();
    
                Mail::to($users->email)->later(now()->addMinutes(1), new XacNhanDonHangMail('New',$this->soPhieu, Auth::user()->username, Carbon::now()));

            }

            flash()->addFlash('success', 'Tạo thành công phiếu : ' . $this->soPhieu,'Thông báo');
            $this->state = 'main';
            $this->resetInputField();
            $this->emit('addXNDHModal');
        });

    }

    public function updateXNDHModal($soPhieu){

        $this->state = 'update';
        $this->soPhieu = $soPhieu;

    }

    public function updateXNDH(){

        DB::transaction(function(){

            if($this->benA == 'congTy'){

                if($this->loai == 'nd'){
                    $tenBenA = 'CÔNG TY CỔ PHẦN SỢI THẾ KỶ';
                    $diaChiBenA = 'B1-1 KCN Tây Bắc Củ Chi, Huyện Củ Chi, TP. Hồ Chí Minh, Việt Nam.';
                }    
                else{
                    $tenBenA = 'CENTURY SYNTHETIC FIBER CORPORATION';
                    $diaChiBenA = 'B1-1, CU CHI NORTHWEST INDUSTRIAL ZONE, CU CHI DISTRICT, HO CHI MINH CITY, VIETNAM.';
                }
                    
            }else{
                if($this->loai == 'nd'){
                    $tenBenA = 'CHI NHÁNH  CÔNG TY  CP SỢI THẾ KỶ';
                    $diaChiBenA = 'Đường số 8- KCN Trảng Bàng , P An Tịnh, Thị  Xã Trảng Bàng , Tỉnh Tây Ninh, Việt Nam.';
                }  
                else{
                    $tenBenA = 'CENTURY SYNTHETIC FIBER CORPORATION- BRANCH';
                    $diaChiBenA = 'Road no.08, Trang Bang Industrial Zone, An Tinh Ward, Trang Bang Town, Tay Ninh Province, Viet Nam.';
                }
            }

            DB::table('xac_nhan_don_hang')
            ->where('so_phieu', $this->soPhieu)
            ->update([

                'loai' => $this->loai,
                'ngay' => $this->ngay,
                'ben_a' => $tenBenA,
                'dia_chi_ben_a' => $diaChiBenA,
                'ben_b' => $this->benB,
                'dia_chi_ben_b' => $this->diaChiBenB,
                'incoterm' => $this->incoterm,
                'thoi_gian_giao_hang' => $this->thoiGianGiaoHang,
                'xuat_xu' => $this->xuatXu,
                'dong_goi' => $this->dongGoi,
                'hinh_thuc_thanh_toan' => $this->hinhThucThanhToan,
                'thoi_gian_thanh_toan' => $this->thoiGianThanhToan,
                'dia_diem_giao_hang' => $this->diaDiemGiaoHang,
                'ghi_chu' => $this->ghiChu,
                'updated_user' => Auth::user()->username,
                'updated_at' => Carbon::now(),

            ]);

            $idLog = DB::table('xac_nhan_don_hang_log')->insertGetId([

                'so_phieu' => $this->soPhieu,
                'loai' => $this->loai,
                'ngay' => $this->ngay,
                'ben_a' => $tenBenA,
                'dia_chi_ben_a' => $diaChiBenA,
                'ben_b' => $this->benB,
                'dia_chi_ben_b' => $this->diaChiBenB,
                'incoterm' => $this->incoterm,
                'thoi_gian_giao_hang' => $this->thoiGianGiaoHang,
                'xuat_xu' => $this->xuatXu,
                'dong_goi' => $this->dongGoi,
                'hinh_thuc_thanh_toan' => $this->hinhThucThanhToan,
                'thoi_gian_thanh_toan' => $this->thoiGianThanhToan,
                'dia_diem_giao_hang' => $this->diaDiemGiaoHang,
                'ghi_chu' => $this->ghiChu,
                'status' => 'New',
                'status_log' => 'Updated',
                'created_user' => Auth::user()->username,
                'updated_user' => Auth::user()->username,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ]);

            foreach ($this->quyCachEdit as $key => $value) {

                DB::table('xac_nhan_don_hang_quy_cach')
                ->where('so_phieu', $this->soPhieu)
                ->update([

                    'quy_cach' => $this->quyCachEdit[$key],
                    'so_luong' => $this->soLuongEdit[$key],
                    'don_gia' => $this->donGiaEdit[$key],

                ]);
                
                DB::table('xac_nhan_don_hang_quy_cach_log')->insert([

                    'so_phieu' => $this->soPhieu,
                    'id_log' => $idLog,
                    'quy_cach' => $this->quyCachEdit[$key],
                    'so_luong' => $this->soLuongEdit[$key],
                    'don_gia' => $this->donGiaEdit[$key],

                ]);
            }

            if($this->quyCach != null){

                foreach (array_reverse($this->quyCach, true) as $key => $value) {

                    DB::table('xac_nhan_don_hang_quy_cach')->insert([
    
                        'so_phieu' => $this->soPhieu,
                        'quy_cach' => $this->quyCach[$key],
                        'so_luong' => $this->soLuong[$key],
                        'don_gia' => $this->donGia[$key],
    
                    ]);
    
                    DB::table('xac_nhan_don_hang_quy_cach_log')->insert([
    
                        'so_phieu' => $this->soPhieu,
                        'id_log' => $idLog,
                        'quy_cach' => $this->quyCach[$key],
                        'so_luong' => $this->soLuong[$key],
                        'don_gia' => $this->donGia[$key],
    
                    ]);
    
                }

            }

            flash()->addFlash('success', 'Sửa thành công phiếu : ' . $this->soPhieu,'Thông báo');
            $this->state = 'main';
            $this->resetInputField();
            $this->emit('updateXNDHModal');

        });

    }

    public function deleteModal($soPhieu){

        $this->state = 'delete';
        $this->soPhieu = $soPhieu;

    }

    public function delete(){

        DB::transaction(function(){

            DB::table('xac_nhan_don_hang')
            ->where('so_phieu', $this->soPhieu)
            ->update([
                'is_delete' => '1',
            ]);

            $XNDH = DB::table('xac_nhan_don_hang')
            ->where('so_phieu', $this->soPhieu)
            ->first();

            $idLog = DB::table('xac_nhan_don_hang_log')->insertGetId([

                'so_phieu' => $XNDH->so_phieu,
                'loai' => $XNDH->loai,
                'ngay' => $XNDH->ngay,
                'ben_a' => $XNDH->ben_a,
                'dia_chi_ben_a' => $XNDH->dia_chi_ben_a,
                'ben_b' => $XNDH->ben_b,
                'dia_chi_ben_b' => $XNDH->dia_chi_ben_b,
                'incoterm' => $XNDH->incoterm,
                'thoi_gian_giao_hang' => $XNDH->thoi_gian_giao_hang,
                'xuat_xu' => $XNDH->xuat_xu,
                'dong_goi' => $XNDH->dong_goi,
                'hinh_thuc_thanh_toan' => $XNDH->hinh_thuc_thanh_toan,
                'thoi_gian_thanh_toan' => $XNDH->thoi_gian_thanh_toan,
                'dia_diem_giao_hang' => $XNDH->dia_diem_giao_hang,
                'ghi_chu' => $XNDH->ghi_chu,
                'status' => $XNDH->status,
                'status_log' => 'Deleted',
                'created_user' => Auth::user()->username,
                'updated_user' => Auth::user()->username,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ]);

            $XNDHQuyCach = DB::table('bao_gia_san_pham')
            ->where('so_phieu', $this->soPhieu)
            ->get();

        });

    }

    public function detailXNDHModal($soPhieu){

        $this->state = 'detail';
        $this->soPhieu = $soPhieu;

    }

    public function approveXNDHModal($soPhieu){

        $this->state = 'approve';
        $this->soPhieu = $soPhieu;

    }

    public function approveXNDH(){
        DB::transaction(function(){

            if($this->loai == 'nd'){
                if($this->status == 'New'){
                    if (Auth::user()->hasPermissionTo('approve_1_xac_nhan_don_hang')) {

                        DB::table('xac_nhan_don_hang')
                        ->where('so_phieu', $this->soPhieu)
                        ->update([
    
                            'approved_1' => Auth::user()->username,
                            'approved_1_at' => Carbon::now(),
    
                            'status' => 'Approved 1',
    
                            'updated_user' => Auth::user()->username,
                            'updated_at' => Carbon::now(),
    
                        ]);
    
                        $XNDH = DB::table('xac_nhan_don_hang')
                        ->where('so_phieu', $this->soPhieu)
                        ->first();
    
                        $idLog = DB::table('xac_nhan_don_hang_log')->insertGetId([
    
                            'so_phieu' => $this->soPhieu,
                            'loai' => $XNDH->loai,
                            'ngay' => $XNDH->ngay,
                            'ben_a' => $XNDH->ben_a,
                            'dia_chi_ben_a' => $XNDH->dia_chi_ben_a,
                            'ben_b' => $XNDH->ben_b,
                            'dia_chi_ben_b' => $XNDH->dia_chi_ben_b,
                            'incoterm' => $XNDH->incoterm,
                            'thoi_gian_giao_hang' => $XNDH->thoi_gian_giao_hang,
                            'xuat_xu' => $XNDH->xuat_xu,
                            'dong_goi' => $XNDH->dong_goi,
                            'hinh_thuc_thanh_toan' => $XNDH->hinh_thuc_thanh_toan,
                            'thoi_gian_thanh_toan' => $XNDH->thoi_gian_thanh_toan,
                            'dia_diem_giao_hang' => $XNDH->dia_diem_giao_hang,
                            'ghi_chu' => $XNDH->ghi_chu,
                            'status' => 'Approved 1',
                            'status_log' => 'Approved',
                            'created_user' => $XNDH->created_user,
                            'updated_user' => Auth::user()->username,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
    
                        ]);
    
                        foreach ($this->danhSachQuyCach as $item) {
                            
                            DB::table('xac_nhan_don_hang_quy_cach_log')->insert([
    
                                'so_phieu' => $this->soPhieu,
                                'id_log' => $idLog,
                                'quy_cach' => $item->quy_cach ?? $item['quy_cach'],
                                'so_luong' => $item->so_luong ?? $item['so_luong'],
                                'don_gia' => $item->don_gia ?? $item['don_gia'],
    
                            ]);
    
                        }

                        $users = User::permission('approve_2_xac_nhan_don_hang')->first();

                        $userSale = User::where('username', $XNDH->created_user)->first();
        
                        Mail::to($users->email)
                        ->cc($userSale->email)
                        ->later(now()->addMinutes(1), new XacNhanDonHangMail('Approved 1',$this->soPhieu, Auth::user()->username, Carbon::now()));
    
                        flash()->addFlash('success', 'Duyệt thành công phiếu : ' . $this->soPhieu,'Thông báo');
                        $this->emit('approveXNDHModal');
                        $this->resetInputField();
                        
                    }else{

                        sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                        $this->emit('approveXNDHModal');
        
                    }
                }elseif($this->status == 'Approved 1'){
    
                    if (Auth::user()->hasPermissionTo('approve_2_xac_nhan_don_hang')) {
    
                        DB::table('xac_nhan_don_hang')
                        ->where('so_phieu', $this->soPhieu)
                        ->update([
    
                            'approved_2' => Auth::user()->username,
                            'approved_2_at' => Carbon::now(),
    
                            'status' => 'Approved 2',
    
                            'updated_user' => Auth::user()->username,
                            'updated_at' => Carbon::now(),
    
                        ]);
    
                        $XNDH = DB::table('xac_nhan_don_hang')
                        ->where('so_phieu', $this->soPhieu)
                        ->first();
    
                        $idLog = DB::table('xac_nhan_don_hang_log')->insertGetId([
    
                            'so_phieu' => $this->soPhieu,
                            'loai' => $XNDH->loai,
                            'ngay' => $XNDH->ngay,
                            'ben_a' => $XNDH->ben_a,
                            'dia_chi_ben_a' => $XNDH->dia_chi_ben_a,
                            'ben_b' => $XNDH->ben_b,
                            'dia_chi_ben_b' => $XNDH->dia_chi_ben_b,
                            'incoterm' => $XNDH->incoterm,
                            'thoi_gian_giao_hang' => $XNDH->thoi_gian_giao_hang,
                            'xuat_xu' => $XNDH->xuat_xu,
                            'dong_goi' => $XNDH->dong_goi,
                            'hinh_thuc_thanh_toan' => $XNDH->hinh_thuc_thanh_toan,
                            'thoi_gian_thanh_toan' => $XNDH->thoi_gian_thanh_toan,
                            'dia_diem_giao_hang' => $XNDH->dia_diem_giao_hang,
                            'ghi_chu' => $XNDH->ghi_chu,
                            'status' => 'Approved 2',
                            'status_log' => 'Approved',
                            'created_user' => $XNDH->created_user,
                            'updated_user' => Auth::user()->username,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
    
                        ]);
    
                        foreach ($this->danhSachQuyCach as $item) {
                            
                            DB::table('xac_nhan_don_hang_quy_cach_log')->insert([
    
                                'so_phieu' => $this->soPhieu,
                                'id_log' => $idLog,
                                'quy_cach' => $item->quy_cach ?? $item['quy_cach'],
                                'so_luong' => $item->so_luong ?? $item['so_luong'],
                                'don_gia' => $item->don_gia ?? $item['don_gia'],
    
                            ]);
    
                        }

                        $users = User::permission('approve_3_xac_nhan_don_hang')->first();
    
                        $userSale = User::where('username', $XNDH->created_user)->first();
        
                        Mail::to($users->email)
                        ->cc($userSale->email)
                        ->later(now()->addMinutes(1), new XacNhanDonHangMail('Approved 2',$this->soPhieu, Auth::user()->username, Carbon::now()));
    
                        flash()->addFlash('success', 'Duyệt thành công phiếu : ' . $this->soPhieu,'Thông báo');
                        $this->emit('approveXNDHModal');
                        $this->resetInputField();
                        
                    }else{
    
                        sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                        $this->emit('approveXNDHModal');
        
                    }
    
                }elseif($this->status == 'Approved 2'){
    
                    if (Auth::user()->hasPermissionTo('approve_3_xac_nhan_don_hang')) {
    
                        DB::table('xac_nhan_don_hang')
                        ->where('so_phieu', $this->soPhieu)
                        ->update([
    
                            'finish' => Auth::user()->username,
                            'finish_at' => Carbon::now(),
    
                            'status' => 'Finish',
    
                            'updated_user' => Auth::user()->username,
                            'updated_at' => Carbon::now(),
    
                        ]);
    
                        $XNDH = DB::table('xac_nhan_don_hang')
                        ->where('so_phieu', $this->soPhieu)
                        ->first();
    
                        $idLog = DB::table('xac_nhan_don_hang_log')->insertGetId([
    
                            'so_phieu' => $this->soPhieu,
                            'loai' => $XNDH->loai,
                            'ngay' => $XNDH->ngay,
                            'ben_a' => $XNDH->ben_a,
                            'dia_chi_ben_a' => $XNDH->dia_chi_ben_a,
                            'ben_b' => $XNDH->ben_b,
                            'dia_chi_ben_b' => $XNDH->dia_chi_ben_b,
                            'incoterm' => $XNDH->incoterm,
                            'thoi_gian_giao_hang' => $XNDH->thoi_gian_giao_hang,
                            'xuat_xu' => $XNDH->xuat_xu,
                            'dong_goi' => $XNDH->dong_goi,
                            'hinh_thuc_thanh_toan' => $XNDH->hinh_thuc_thanh_toan,
                            'thoi_gian_thanh_toan' => $XNDH->thoi_gian_thanh_toan,
                            'dia_diem_giao_hang' => $XNDH->dia_diem_giao_hang,
                            'ghi_chu' => $XNDH->ghi_chu,
                            'status' => 'Finish',
                            'status_log' => 'Approved',
                            'created_user' => $XNDH->created_user,
                            'updated_user' => Auth::user()->username,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
    
                        ]);
    
                        foreach ($this->danhSachQuyCach as $item) {
                            
                            DB::table('xac_nhan_don_hang_quy_cach_log')->insert([
    
                                'so_phieu' => $this->soPhieu,
                                'id_log' => $idLog,
                                'quy_cach' => $item->quy_cach ?? $item['quy_cach'],
                                'so_luong' => $item->so_luong ?? $item['so_luong'],
                                'don_gia' => $item->don_gia ?? $item['don_gia'],
    
                            ]);
    
                        }

                        $templateProcessor = new TemplateProcessor(public_path('XNDH/ORDER_CONFIRMATION_TV.docx'));

                        $XNDH = DB::table('xac_nhan_don_hang')
                        ->where('so_phieu', $this->soPhieu)
                        ->first();

                        $XNDHQuyCach = DB::table('xac_nhan_don_hang_quy_cach')
                        ->where('so_phieu', $this->soPhieu)
                        ->get();

                        $XNDHQuyCach->transform(function ($item) {

                            $item->thanh_tien = $item->so_luong * $item->don_gia;
                
                            return $item;
                        });

                        $XNDHQuyCach->all();

                        $stt = 0;

                        $values_table = [];

                        foreach ($XNDHQuyCach as $item) {
                            
                            $values_table = array_merge($values_table,[

                                [
                                    'stt' => $stt = $stt + 1,
                                    'quy_cach' => $item->quy_cach,
                                    'so_luong' => number_format($item->so_luong,2),
                                    'don_gia' => number_format($item->don_gia),
                                    'thanh_tien' => number_format($item->thanh_tien),
                                ],
            
                            ]);
                        }

                        $converter = new Converter("đồng chẵn", "",Language::VIETNAMESE);

                        $values = [
    
                            'so_phieu' => $this->soPhieu,
                            'ngay' => ' ngày ' . Carbon::create($XNDH->ngay)->day . ' tháng ' . Carbon::create($XNDH->ngay)->month . ' năm ' . Carbon::create($XNDH->ngay)->year,
                            'ben_a' => $XNDH->ben_a,
                            'dia_chi_ben_a' => $XNDH->dia_chi_ben_a,
                            'ben_b' => $XNDH->ben_b,
                            'dia_chi_ben_b' => $XNDH->dia_chi_ben_b,

                            'thoi_gian_giao_hang' => $XNDH->thoi_gian_giao_hang,
                            'xuat_xu' => $XNDH->xuat_xu,
                            'dong_goi' => $XNDH->dong_goi,
                            'hinh_thuc_thanh_toan' => $XNDH->hinh_thuc_thanh_toan,
                            'thoi_gian_thanh_toan' => $XNDH->thoi_gian_thanh_toan,
                            'dia_diem_giao_hang' => $XNDH->dia_diem_giao_hang,
                            'ghi_chu' => $XNDH->ghi_chu,
                            'vat' => $XNDHQuyCach->sum('thanh_tien') * 0.1,
                            'tong_cong' => $XNDHQuyCach->sum('thanh_tien') * 1.1,
                            'thanh_tien_bang_chu' => ucfirst(str_replace(' chỉ một','',$converter->convert($XNDHQuyCach->sum('thanh_tien') * 1.1)))
                        ];

                        $templateProcessor->setValues($values);

                        $templateProcessor->cloneRowAndSetValues('stt', $values_table);

                        Storage::disk('public')->makeDirectory('XNDH/' . $this->soPhieu);

                        $templateProcessor->saveAs(storage_path('app/public/XNDH/') . $this->soPhieu . '/' . $this->soPhieu .'.docx');

                        $userSale = User::where('username', $XNDH->created_user)->first();
    
                        Mail::to($userSale->email)->later(now()->addMinutes(1), new XacNhanDonHangMail('Finish',$this->soPhieu, Auth::user()->username, Carbon::now()));

                        flash()->addFlash('success', 'Duyệt thành công phiếu : ' . $this->soPhieu,'Thông báo');
                        $this->emit('approveXNDHModal');
                        $this->resetInputField();
                        
                    }else{
    
                        sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                        $this->emit('approveXNDHModal');
        
                    }
    
                }
            }else{
                if($this->status == 'New'){

                    if (Auth::user()->hasPermissionTo('approve_2_xac_nhan_don_hang')) {
    
                        DB::table('xac_nhan_don_hang')
                        ->where('so_phieu', $this->soPhieu)
                        ->update([
    
                            'approved_2' => Auth::user()->username,
                            'approved_2_at' => Carbon::now(),
    
                            'status' => 'Approved 2',
    
                            'updated_user' => Auth::user()->username,
                            'updated_at' => Carbon::now(),
    
                        ]);
    
                        $XNDH = DB::table('xac_nhan_don_hang')
                        ->where('so_phieu', $this->soPhieu)
                        ->first();
    
                        $idLog = DB::table('xac_nhan_don_hang_log')->insertGetId([
    
                            'so_phieu' => $this->soPhieu,
                            'loai' => $XNDH->loai,
                            'ngay' => $XNDH->ngay,
                            'ben_a' => $XNDH->ben_a,
                            'dia_chi_ben_a' => $XNDH->dia_chi_ben_a,
                            'ben_b' => $XNDH->ben_b,
                            'dia_chi_ben_b' => $XNDH->dia_chi_ben_b,
                            'incoterm' => $XNDH->incoterm,
                            'thoi_gian_giao_hang' => $XNDH->thoi_gian_giao_hang,
                            'xuat_xu' => $XNDH->xuat_xu,
                            'dong_goi' => $XNDH->dong_goi,
                            'hinh_thuc_thanh_toan' => $XNDH->hinh_thuc_thanh_toan,
                            'thoi_gian_thanh_toan' => $XNDH->thoi_gian_thanh_toan,
                            'dia_diem_giao_hang' => $XNDH->dia_diem_giao_hang,
                            'ghi_chu' => $XNDH->ghi_chu,
                            'status' => 'Approved 2',
                            'status_log' => 'Approved',
                            'created_user' => $XNDH->created_user,
                            'updated_user' => Auth::user()->username,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
    
                        ]);
    
                        foreach ($this->danhSachQuyCach as $item) {
                            
                            DB::table('xac_nhan_don_hang_quy_cach_log')->insert([
    
                                'so_phieu' => $this->soPhieu,
                                'id_log' => $idLog,
                                'quy_cach' => $item->quy_cach ?? $item['quy_cach'],
                                'so_luong' => $item->so_luong ?? $item['so_luong'],
                                'don_gia' => $item->don_gia ?? $item['don_gia'],
    
                            ]);
    
                        }

                        $users = User::permission('approve_3_xac_nhan_don_hang')->first();
    
                        $userSale = User::where('username', $XNDH->created_user)->first();
        
                        Mail::to($users->email)
                        ->cc($userSale->email)
                        ->later(now()->addMinutes(1), new XacNhanDonHangMail('Approved 2',$this->soPhieu, Auth::user()->username, Carbon::now()));
    
                        flash()->addFlash('success', 'Duyệt thành công phiếu : ' . $this->soPhieu,'Thông báo');
                        $this->emit('approveXNDHModal');
                        $this->resetInputField();
                        
                    }else{
    
                        sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                        $this->emit('approveXNDHModal');
        
                    }
    
                }elseif($this->status == 'Approved 2'){
    
                    if (Auth::user()->hasPermissionTo('approve_3_xac_nhan_don_hang')) {
    
                        DB::table('xac_nhan_don_hang')
                        ->where('so_phieu', $this->soPhieu)
                        ->update([
    
                            'finish' => Auth::user()->username,
                            'finish_at' => Carbon::now(),
    
                            'status' => 'Finish',
    
                            'updated_user' => Auth::user()->username,
                            'updated_at' => Carbon::now(),
    
                        ]);
    
                        $XNDH = DB::table('xac_nhan_don_hang')
                        ->where('so_phieu', $this->soPhieu)
                        ->first();
    
                        $idLog = DB::table('xac_nhan_don_hang_log')->insertGetId([
    
                            'so_phieu' => $this->soPhieu,
                            'loai' => $XNDH->loai,
                            'ngay' => $XNDH->ngay,
                            'ben_a' => $XNDH->ben_a,
                            'dia_chi_ben_a' => $XNDH->dia_chi_ben_a,
                            'ben_b' => $XNDH->ben_b,
                            'dia_chi_ben_b' => $XNDH->dia_chi_ben_b,
                            'incoterm' => $XNDH->incoterm,
                            'thoi_gian_giao_hang' => $XNDH->thoi_gian_giao_hang,
                            'xuat_xu' => $XNDH->xuat_xu,
                            'dong_goi' => $XNDH->dong_goi,
                            'hinh_thuc_thanh_toan' => $XNDH->hinh_thuc_thanh_toan,
                            'thoi_gian_thanh_toan' => $XNDH->thoi_gian_thanh_toan,
                            'dia_diem_giao_hang' => $XNDH->dia_diem_giao_hang,
                            'ghi_chu' => $XNDH->ghi_chu,
                            'status' => 'Finish',
                            'status_log' => 'Approved',
                            'created_user' => $XNDH->created_user,
                            'updated_user' => Auth::user()->username,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
    
                        ]);
    
                        foreach ($this->danhSachQuyCach as $item) {
                            
                            DB::table('xac_nhan_don_hang_quy_cach_log')->insert([
    
                                'so_phieu' => $this->soPhieu,
                                'id_log' => $idLog,
                                'quy_cach' => $item->quy_cach ?? $item['quy_cach'],
                                'so_luong' => $item->so_luong ?? $item['so_luong'],
                                'don_gia' => $item->don_gia ?? $item['don_gia'],
    
                            ]);
    
                        }

                        $templateProcessor = new TemplateProcessor(public_path('XNDH/ORDER_CONFIRMATION_TA.docx'));

                        $XNDH = DB::table('xac_nhan_don_hang')
                        ->where('so_phieu', $this->soPhieu)
                        ->first();

                        $XNDHQuyCach = DB::table('xac_nhan_don_hang_quy_cach')
                        ->where('so_phieu', $this->soPhieu)
                        ->get();

                        $XNDHQuyCach->transform(function ($item) {

                            $item->thanh_tien = $item->so_luong * $item->don_gia;
                
                            return $item;
                        });

                        $XNDHQuyCach->all();

                        $values_table = [];

                        foreach ($XNDHQuyCach as $item) {
                            
                            $values_table = array_merge($values_table,[

                                [
                                    'quy_cach' => $item->quy_cach,
                                    'so_luong' => number_format($item->so_luong,2),
                                    'don_gia' => number_format($item->don_gia),
                                    'thanh_tien' => number_format($item->thanh_tien),
                                ],
            
                            ]);
                        }

                        $converter = new Converter("đồng chẵn", "",Language::VIETNAMESE);

                        $values = [
    
                            'so_phieu' => $this->soPhieu,
                            'ngay' => ' ngày ' . Carbon::create($XNDH->ngay)->day . ' tháng ' . Carbon::create($XNDH->ngay)->month . ' năm ' . Carbon::create($XNDH->ngay)->year,
                            'ben_a' => $XNDH->ben_a,
                            'dia_chi_ben_a' => $XNDH->dia_chi_ben_a,
                            'ben_b' => $XNDH->ben_b,
                            'dia_chi_ben_b' => $XNDH->dia_chi_ben_b,
                            'incoterm' => $XNDH->incoterm,
                            'thoi_gian_giao_hang' => $XNDH->thoi_gian_giao_hang,
                            'xuat_xu' => $XNDH->xuat_xu,
                            'dong_goi' => $XNDH->dong_goi,
                            'hinh_thuc_thanh_toan' => $XNDH->hinh_thuc_thanh_toan,
                            'thoi_gian_thanh_toan' => $XNDH->thoi_gian_thanh_toan,
                            'dia_diem_giao_hang' => $XNDH->dia_diem_giao_hang,
                            'ghi_chu' => $XNDH->ghi_chu,
                            'vat' => $XNDHQuyCach->sum('thanh_tien') * 0.1,
                            'tong_cong' => $XNDHQuyCach->sum('thanh_tien') * 1.1,
                            'thanh_tien_bang_chu' => ucfirst(str_replace(' chỉ một','',$converter->convert($XNDHQuyCach->sum('thanh_tien') * 1.1)))
                        ];

                        $templateProcessor->setValues($values);

                        $templateProcessor->cloneRowAndSetValues('quy_cach', $values_table);

                        Storage::disk('public')->makeDirectory('XNDH/' . $this->soPhieu);

                        $templateProcessor->saveAs(storage_path('app/public/XNDH/') . $this->soPhieu . '/' . $this->soPhieu .'.docx');

                        $userSale = User::where('username', $XNDH->created_user)->first();
    
                        Mail::to($userSale->email)->later(now()->addMinutes(1), new XacNhanDonHangMail('Finish',$this->soPhieu, Auth::user()->username, Carbon::now()));
    
                        flash()->addFlash('success', 'Duyệt thành công phiếu : ' . $this->soPhieu,'Thông báo');
                        $this->emit('approveXNDHModal');
                        $this->resetInputField();
                        
                    }else{
    
                        sweetalert()->addInfo('Dữ liệu đã bị thay đổi. Vui lòng tải lại website để nhận dữ liệu mới.');
                        $this->emit('approveXNDHModal');
        
                    }
    
                }
            }

        });

    }

    public function rollbackXNDHModal($soPhieu){

        $this->state = 'rollback';
        $this->soPhieu = $soPhieu;

    }

    public function rollbackXNDH(){

        DB::transaction(function(){
            
            $XNDH = DB::table('xac_nhan_don_hang')->where('so_phieu', $this->soPhieu)->first();

            DB::table('xac_nhan_don_hang')
            ->where('so_phieu', $this->soPhieu)
            ->update([

                'approved_1' => null,
                'approved_1_at' => null,
                'approved_2' => null,
                'approved_2_at' => null,
                'finish' => null,
                'finish_at' => null,
                'status' => 'New',
                'updated_user' => $XNDH->new,
                'updated_at' => Carbon::now(),

            ]);

            $idLog = DB::table('xac_nhan_don_hang_log')->insertGetId([

                'so_phieu' => $this->soPhieu,
                'loai' => $XNDH->loai,
                'ngay' => $XNDH->ngay,
                'ben_a' => $XNDH->ben_a,
                'dia_chi_ben_a' => $XNDH->dia_chi_ben_a,
                'ben_b' => $XNDH->ben_b,
                'dia_chi_ben_b' => $XNDH->dia_chi_ben_b,
                'incoterm' => $XNDH->incoterm,
                'thoi_gian_giao_hang' => $XNDH->thoi_gian_giao_hang,
                'xuat_xu' => $XNDH->xuat_xu,
                'dong_goi' => $XNDH->dong_goi,
                'hinh_thuc_thanh_toan' => $XNDH->hinh_thuc_thanh_toan,
                'thoi_gian_thanh_toan' => $XNDH->thoi_gian_thanh_toan,
                'dia_diem_giao_hang' => $XNDH->dia_diem_giao_hang,
                'ghi_chu' => $XNDH->ghi_chu,
                'status' => $XNDH->status,
                'status_log' => 'Rollback',
                'created_user' => Auth::user()->username,
                'updated_user' => Auth::user()->username,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ]);

            $danhSachQuyCach = DB::table('xac_nhan_don_hang_quy_cach')
            ->where('so_phieu', $this->soPhieu)
            ->get();

            foreach ($danhSachQuyCach as $item) {

                DB::table('xac_nhan_don_hang_quy_cach_log')->insert([
    
                    'so_phieu' => $this->soPhieu,
                    'id_log' => $idLog,
                    'quy_cach' => $item->quy_cach,
                    'so_luong' => $item->so_luong,
                    'don_gia' => $item->don_gia,

                ]);
                
            }

            Mail::to($XNDH->created_user)->later(now()->addMinutes(1), new XacNhanDonHangMail('Rollback',$this->soPhieu, Auth::user()->username, Carbon::now()));

            flash()->addFlash('success', 'Rollback thành công phiếu : ' . $this->soPhieu,'Thông báo');
            $this->resetInputField();
            $this->emit('rollbackXNDHModal');
        });

    }

    public function changeCaNhanTatCa(){

        $this->resetPage();

    }

    public function downloadFile($soPhieu){
        return response()->download(storage_path('app/public/XNDH/') . $soPhieu . '/' . $soPhieu . '.docx');
    }

    public function render()
    {
        if($this->state == 'main'){

            $search_fields = [
                'so_phieu',
                'loai',
                'ngay',
                'ben_b',
                'created_user',
                'created_at'
            ];

            $search_terms = explode(',', $this->search);

            $danhSachXNDH = DB::table('xac_nhan_don_hang')

            ->where(function ($query) use($search_terms, $search_fields){

                if($this->search != ''){

                    foreach ($search_terms as $term) {
                        $query->orWhere(function ($query) use ($search_fields, $term) {
            
                            foreach ($search_fields as $field) {
                                $query->orWhere($field, 'LIKE', '%' . trim($term) . '%');
                            }
                        });
                    }

                } 

            })
            
            ->where('is_delete', null)

            ->where( function ($query){

                if($this->tuNgay == null && $this->denNgay == null){

                    $query->whereBetween('created_at', ['2023-05-01 00:00:00', '2099-01-01 00:00:00']);
        
                }elseif($this->tuNgay != null && $this->denNgay != null){
        
                    $query->whereBetween('created_at', [$this->tuNgay . ' 00:00:00', $this->denNgay . ' 23:59:59']);
        
                }elseif($this->tuNgay == null && $this->denNgay != null){
        
                    $query->whereBetween('created_at', ['2023-05-01 00:00:00', $this->denNgay . ' 23:59:59']);
        
                }
                elseif($this->tuNgay != null && $this->denNgay == null){
        
                    $query->whereBetween('created_at', [$this->tuNgay . ' 00:00:00', '2099-01-01 00:00:00']);
        
                }

            })

            ->where(function ($query){

                if($this->canhan_tatca == 'phieuDoiDuyet'){

                    if(Auth::user()->hasPermissionTo('create_xac_nhan_don_hang')){

                        $query->orWhere(function($query){

                            $query->where('new', Auth::user()->username);
    
                            $query->where('status', '<>', 'Finish');
    
                        }); 

                    }

                    if(Auth::user()->hasPermissionTo('approve_1_xac_nhan_don_hang')){

                        $query->orWhere(function($query){
    
                            $query->where('status', 'New');

                            $query->where('loai', 'nd');
    
                        }); 

                    }

                    if(Auth::user()->hasPermissionTo('approve_2_xac_nhan_don_hang')){

                        $query->orWhere(function($query){

                            $query->orWhere(function($query){
    
                                $query->where('status', 'Approved 1');
    
                                $query->where('loai', 'nd');
    
                            });
    
                            $query->orWhere(function($query){
    
                                $query->where('status', 'New');
    
                                $query->where('loai', 'xk');
                                
                            });
                        }); 

                    }

                    if(Auth::user()->hasPermissionTo('approve_3_xac_nhan_don_hang')){

                        $query->orWhere(function($query){
    
                            $query->where('status', 'Approved 2');
    
                        }); 

                    }

                }elseif($this->canhan_tatca == 'phieuDaDuyet'){
                    
                    $query->where(function($query){

                        $query->orWhere(function($query){
    
                            $query->where('new', Auth::user()->username);
                            $query->where('status', 'Finish');
    
                        });
                        $query->orWhere('approved_1', Auth::user()->username);
                        $query->orWhere('approved_2', Auth::user()->username);
                        $query->orWhere('finish', Auth::user()->username);
    
                    });
                }

            });

            $danhSachXNDH->select('so_phieu', 'loai' , 'ngay', 'ben_b', 'status', 'created_user', 'created_at');
                    
            session(['result' => $danhSachXNDH->paginate($this->paginate)]);

        }elseif($this->state == 'add'){

            $this->danhSachBenB = BenB::all();

        }elseif($this->state == 'detail'){

            $XNDH = DB::table('xac_nhan_don_hang')
                ->where('so_phieu', $this->soPhieu)
                ->first();

            $this->soPhieu = $XNDH->so_phieu;
            $this->loai = $XNDH->loai;
            $this->ngay = $XNDH->ngay;
            $this->benA = $XNDH->ben_a;
            $this->diaChiBenA = $XNDH->dia_chi_ben_a;
            $this->benB = $XNDH->ben_b;
            $this->diaChiBenB = $XNDH->dia_chi_ben_b;
            $this->incoterm = $XNDH->incoterm;
            $this->thoiGianGiaoHang = $XNDH->thoi_gian_giao_hang;
            $this->xuatXu = $XNDH->xuat_xu;
            $this->dongGoi = $XNDH->dong_goi;
            $this->hinhThucThanhToan = $XNDH->hinh_thuc_thanh_toan;
            $this->thoiGianThanhToan = $XNDH->thoi_gian_thanh_toan;
            $this->diaDiemGiaoHang = $XNDH->dia_diem_giao_hang;
            $this->ghiChu = $XNDH->ghi_chu;
            $this->status = $XNDH->status;

            $this->danhSachQuyCach = DB::table('xac_nhan_don_hang_quy_cach')
                                    ->where('so_phieu',$this->soPhieu)
                                    ->get();

            $this->log = DB::table('xac_nhan_don_hang_log')
                ->where('so_phieu', $this->soPhieu)
                ->get();

        }elseif($this->state = 'approve'){

            $XNDH = DB::table('xac_nhan_don_hang')
            ->where('so_phieu', $this->soPhieu)
            ->first();

            $this->soPhieu = $XNDH->so_phieu;
            $this->loai = $XNDH->loai;
            $this->ngay = $XNDH->ngay;
            $this->benA = $XNDH->ben_a;
            $this->diaChiBenA = $XNDH->dia_chi_ben_a;
            $this->benB = $XNDH->ben_b;
            $this->diaChiBenB = $XNDH->dia_chi_ben_b;
            $this->incoterm = $XNDH->incoterm;
            $this->thoiGianGiaoHang = $XNDH->thoi_gian_giao_hang;
            $this->xuatXu = $XNDH->xuat_xu;
            $this->dongGoi = $XNDH->dong_goi;
            $this->hinhThucThanhToan = $XNDH->hinh_thuc_thanh_toan;
            $this->thoiGianThanhToan = $XNDH->thoi_gian_thanh_toan;
            $this->diaDiemGiaoHang = $XNDH->dia_diem_giao_hang;
            $this->ghiChu = $XNDH->ghi_chu;
            $this->status = $XNDH->status;

            $this->danhSachQuyCach = DB::table('xac_nhan_don_hang_quy_cach')
                                    ->where('so_phieu',$this->soPhieu)
                                    ->get();

        }elseif($this->state = 'update'){

            $XNDH = DB::table('xac_nhan_don_hang')
            ->where('so_phieu', $this->soPhieu)
            ->first();

            $this->loai = $XNDH->loai;
            $this->ngay = $XNDH->ngay;
            $this->benA = $XNDH->ben_a;
            $this->benB = $XNDH->ben_b;
            $this->diaChiBenB = $XNDH->dia_chi_ben_b;
            $this->incoterm = $XNDH->incoterm;
            $this->thoiGianGiaoHang = $XNDH->thoi_gian_giao_hang;
            $this->xuatXu = $XNDH->xuat_xu;
            $this->dongGoi = $XNDH->dong_goi;
            $this->hinhThucThanhToan = $XNDH->hinh_thuc_thanh_toan;
            $this->thoiGianThanhToan = $XNDH->thoi_gian_thanh_toan;
            $this->diaDiemGiaoHang = $XNDH->dia_diem_giao_hang;
            $this->ghiChu = $XNDH->ghi_chu;

            $this->XNDHQuyCach = DB::table('xac_nhan_don_hang_quy_cach')
            ->where('so_phieu', $this->soPhieu)
            ->get();

            foreach ($this->XNDHQuyCach as $item) {

                $this->quyCachEdit[$item->id] = $item->quy_cach;
                $this->soLuongEdit[$item->id] = $item->so_luong;
                $this->donGiaEdit[$item->id] = $item->don_gia;

            }

        }

        $tableMain = session('result');

        return view('livewire.xac-nhan-don-hang', compact('tableMain'));
    }
}
