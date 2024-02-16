<?php

namespace App\Http\Livewire;

use App\Exports\MoPhong as ExportsMoPhong;
use App\Models\PhieuTKSX;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class MoPhong extends Component
{
    public $state;

    public $danhSachNhanVien, $soTKSXTimKiem, $userTimKiem, $maTimKiem, $quyCachTimKiem, $soMayTimKiem, $matMayTimKiem, $tuNgay, $denNgay, $trangThaiTimKiem;

    public $soLuuKhoTimKiem, $mayTimKiem, $plantTimKiem, $ngaySanXuatTimKiem, $ngayDetTimKiem, $ketQuaNhuomTimKiem;

    public $soLuuKho, $soPhieuTKSX, $maHang, $quyCach, $may, $plant, $ngaySanXuat, $lanXuongGian, $ngayTrenTKSX, $ngayDet, $ketQuaNhuom;

    public $danhSachMoPhong;

    public $paginate;

    public $radioTongQuatChiTiet;

    public $moPhong, $idMoPhong;

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'page' => ['except' => 1],
    ];

    public function mount(){

        $this->paginate = 15;
        $this->state = 'main';
        // $this->userTimKiem = Auth::user()->username;
        $this->trangThaiTimKiem = null;

        $this->tuNgay = Carbon::now()->subDays(30)->isoFormat('YYYY-MM-DD');
        $this->denNgay = Carbon::now()->isoFormat('YYYY-MM-DD');
        $this->radioTongQuatChiTiet = 'tongQuat';

    }

    public function resetInputField(){

        $this->soPhieuTKSX = null;
        $this->soLuuKho = null;
        $this->quyCach = null;
        $this->maHang = null;
        $this->may = null;
        $this->plant = null;
        $this->ngaySanXuat = null;
        $this->lanXuongGian = null;
        $this->ngayTrenTKSX = null;
        $this->ngayDet = null;
        $this->ketQuaNhuom = null;
        $this->state = 'main';

    }

    public function capNhatModal($soPhieu){

        $this->state = 'capNhat';
        $this->soPhieuTKSX = $soPhieu;

    }

    public function capNhat(){

        if($this->soLuuKho != 'x' || $this->soLuuKho != 'X'){

            $mo_phong = DB::table('mo_phong')
            ->where('so_luu_kho', $this->soLuuKho)
            ->first();
    
            if($mo_phong != null){
    
                sweetalert()->addError('Số lưu kho đã tồn tại');
                return;
    
            }

        }

        DB::transaction(function(){

            $tksx = PhieuTKSX::where('so_phieu', $this->soPhieuTKSX)->first();

            DB::table('mo_phong')->insert([

                'so_phieu_tksx' => $this->soPhieuTKSX,
                'so_luu_kho' => $this->soLuuKho,
                'khach_hang' => $tksx->khach_hang,
                'quy_cach' => $this->quyCach,
                'ma' => $this->maHang,
                'may' => $this->may,
                'plant' => $this->plant,
                'ngay_san_xuat' => $this->ngaySanXuat,
                'lan_xuong_gian' => $this->lanXuongGian,
                'ngay_tren_tksx' => $this->ngayTrenTKSX,
                'ngay_det' => $this->ngayDet,
                'ket_qua_nhuom' => $this->ketQuaNhuom,
                'status' => '0',
                'created_user' => Auth::user()->username,
                'updated_user' => Auth::user()->username,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ]);

            DB::table('mo_phong_log')->insert([

                'so_phieu_tksx' => $this->soPhieuTKSX,
                'khach_hang' => $tksx->khach_hang,
                'so_luu_kho' => $this->soLuuKho,
                'quy_cach' => $this->quyCach,
                'ma' => $this->maHang,
                'may' => $this->may,
                'plant' => $this->plant,
                'ngay_san_xuat' => $this->ngaySanXuat,
                'lan_xuong_gian' => $this->lanXuongGian,
                'ngay_tren_tksx' => $this->ngayTrenTKSX,
                'ngay_det' => $this->ngayDet,
                'ket_qua_nhuom' => $this->ketQuaNhuom,
                'status_log' => 'Thêm',
                'created_user' => Auth::user()->username,
                'updated_user' => Auth::user()->username,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ]);

            flash()->addSuccess('Thêm thành công');
            $this->emit('capNhatModal');
            $this->resetInputField();
            $this->state = 'main';

        });
    }

    public function chiTiet($soPhieu){

        $this->state = 'chiTiet';
        $this->soPhieuTKSX = $soPhieu;

    }

    public function ketThucMoPhongModal($soPhieu, $maHang){

        $this->state = 'ketThucMoPhong';
        $this->soPhieuTKSX = $soPhieu;
        $this->maHang = $maHang;

    }

    public function ketThucMoPhong(){

        DB::transaction( function(){

            DB::table('phieu_tksx')
            ->where('so_phieu', $this->soPhieuTKSX)
            ->where('ma_dty', $this->maHang)
            ->update([

                'ket_thuc_mo_phong' => '1',
                'updated_user' => Auth::user()->username,
                'updated_at' => Carbon::now()

            ]);

            DB::table('phieu_tksx_log')
            ->insert([

                'so_phieu' => $this->soPhieuTKSX,
                'ma_dty' => $this->maHang,
                'status_log' => 'Ket Thuc Mo Phong',
                'created_user' => Auth::user()->username,
                'updated_user' => Auth::user()->username,
                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now()

            ]);

            DB::table('mo_phong')
            ->where('so_phieu_tksx', $this->soPhieuTKSX)
            ->where('ma', $this->maHang)
            ->update([

                'ket_thuc_mo_phong' => '1',
                'updated_user' => Auth::user()->username,
                'updated_at' => Carbon::now()

            ]);

            $danhSachMoPhong = DB::table('mo_phong')
            ->where('so_phieu_tksx', $this->soPhieuTKSX)
            ->where('ma', $this->maHang)
            ->get();

            foreach ($danhSachMoPhong as $item) {
                
                DB::table('mo_phong_log')
                ->insert([

                    'so_phieu_tksx' => $item->so_phieu_tksx,
                    'so_luu_kho' => $item->so_luu_kho,
                    'quy_cach' => $item->quy_cach,
                    'ma' => $item->ma,
                    'may' => $item->may,
                    'plant' => $item->plant,
                    'ngay_san_xuat' => $item->ngay_san_xuat,
                    'lan_xuong_gian' => $item->lan_xuong_gian,
                    'ngay_tren_tksx' => $item->ngay_tren_tksx,
                    'ngay_det' => $item->ngay_det,
                    'ket_qua_nhuom' => $item->ket_qua_nhuom,
                    'status_log' => 'Ket Thuc Mo Phong',
                    'created_user' => Auth::user()->username,
                    'updated_user' => Auth::user()->username,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),

                ]);

            }

            flash()->addSuccess('Thực hiện thành công');
            $this->emit('ketThucMoPhongModal');
            $this->resetInputField();
            $this->state = 'main';

        });

    }

    public function deleteModal($idMoPhong){

        $this->state = 'xoa';
        $this->idMoPhong = $idMoPhong;

    }

    public function delete(){

        $moPhong = DB::table('mo_phong')
        ->where('id', $this->idMoPhong)
        ->first();

        DB::table('mo_phong_log')
        ->insert([

            'so_phieu_tksx' => $moPhong->so_phieu_tksx,
            'so_luu_kho' => $moPhong->so_luu_kho,
            'quy_cach' => $moPhong->quy_cach,
            'ma' => $moPhong->ma,
            'may' => $moPhong->may,
            'plant' => $moPhong->plant,
            'ngay_san_xuat' => $moPhong->ngay_san_xuat,
            'lan_xuong_gian' => $moPhong->lan_xuong_gian,
            'ngay_tren_tksx' => $moPhong->ngay_tren_tksx,
            'ngay_det' => $moPhong->ngay_det,
            'ket_qua_nhuom' => $moPhong->ket_qua_nhuom,
            'status_log' => 'Xóa',
            'created_user' => Auth::user()->username,
            'updated_user' => Auth::user()->username,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

        ]);

        DB::table('mo_phong')
        ->where('id', $this->idMoPhong)
        ->delete();

        flash()->addSuccess('Xóa thành công');
        $this->emit('closeModal');
        $this->resetInputField();
        $this->state = 'main';

    }

    public function radioClick(){

        $this->resetPage();

    }

    public function timKiem(){

        $this->state = 'timKiem';
        $this->resetPage();

    }

    public function taiFile(){

        $main = DB::table('mo_phong')
            ->where('ket_thuc_mo_phong', $this->trangThaiTimKiem == '0' ? null : $this->trangThaiTimKiem)
            ->where(function($query){

                $query->whereRaw("'" . $this->userTimKiem . "' = ''");
                $query->orWhere('created_user', 'like', '%' . $this->userTimKiem . '%');

            })
            ->where(function($query){

                $query->whereRaw("'" . $this->soLuuKhoTimKiem . "' = ''");
                $query->orWhere('so_luu_kho', 'like', '%' . $this->soLuuKhoTimKiem . '%');

            })
            ->where(function($query){

                $query->whereRaw("'" . $this->maTimKiem . "' = ''");
                $query->orWhere('ma', 'like', '%' . $this->maTimKiem . '%');

            })
            ->where(function($query){

                $query->whereRaw("'" . $this->quyCachTimKiem . "' = ''");
                $query->orWhere('quy_cach', 'like', '%' . $this->quyCachTimKiem . '%');

            })
            ->where(function($query){

                $query->whereRaw("'" . $this->mayTimKiem . "' = ''");
                $query->orWhere('may', 'like', '%' . $this->mayTimKiem . '%');

            })
            ->where(function($query){

                $query->whereRaw("'" . $this->plantTimKiem . "' = ''");
                $query->orWhere('plant', 'like', '%' . $this->plantTimKiem . '%');

            })
            ->where(function($query){

                $query->whereRaw("'" . $this->ngaySanXuatTimKiem . "' = ''");
                $query->orWhere('ngay_san_xuat', 'like', '%' . $this->ngaySanXuatTimKiem . '%');

            })
            ->where(function($query){

                $query->whereRaw("'" . $this->ngayDetTimKiem . "' = ''");
                $query->orWhere('ngay_det', 'like', '%' . $this->ngayDetTimKiem . '%');

            })
            ->where(function($query){

                $query->whereRaw("'" . $this->ketQuaNhuomTimKiem . "' = ''");
                $query->orWhere('ket_qua_nhuom', 'like', '%' . $this->ketQuaNhuomTimKiem . '%');

            })
            ->where(function($query){

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
            ->orderBy('so_luu_kho')
            ->select('so_luu_kho',
            'quy_cach',
            'ma',
            'may',
            'plant',
            'ngay_san_xuat',
            'lan_xuong_gian',
            'ngay_det',
            'ket_qua_nhuom')
            ->get();

        return Excel::download(new ExportsMoPhong($main), 'Báo Cáo Mô Phỏng.xlsx');

    }

    public function render()
    {
        if(in_array($this->state, ['main', 'timKiem'])){

            if($this->radioTongQuatChiTiet == 'tongQuat'){

                $main = DB::table('phieu_tksx')
                ->leftjoin('mo_phong', 'phieu_tksx.so_phieu', 'mo_phong.so_phieu_tksx')
                ->selectRaw('phieu_tksx.so_phieu, phieu_tksx.ma_dty, phieu_tksx.may, phieu_tksx.quy_cach_dty, phieu_tksx.created_at, phieu_tksx.status, count(mo_phong.so_luu_kho) as number_row')
                ->where('phieu_tksx.status', 'Finish')
                ->where('phieu_tksx.ket_thuc_mo_phong', $this->trangThaiTimKiem == '0' ? null : $this->trangThaiTimKiem)
                ->where(function($query){
    
                    $query->whereRaw("'" . $this->soTKSXTimKiem . "' = ''");
                    $query->orWhere('phieu_tksx.so_phieu', 'like', '%' . $this->soTKSXTimKiem . '%');
        
                })
                ->where(function($query){
        
                    $query->whereRaw("'" . $this->maTimKiem . "' = ''");
                    $query->orWhere('phieu_tksx.ma_dty', 'like', '%' . $this->maTimKiem . '%');
        
                })
                ->where(function($query){
        
                    $query->whereRaw("'" . $this->quyCachTimKiem . "' = ''");
                    $query->orWhere('phieu_tksx.quy_cach_dty', 'like', '%' . $this->quyCachTimKiem . '%');
        
                })
                ->where(function($query){

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

                })
                
                ->whereBetween('phieu_tksx.created_at', [$this->tuNgay, $this->denNgay])
                ->groupBy('phieu_tksx.so_phieu', 'phieu_tksx.ma_dty', 'phieu_tksx.may', 'phieu_tksx.quy_cach_dty', 'phieu_tksx.created_at', 'phieu_tksx.status')
                ->orderByDesc('phieu_tksx.created_at')
                ->paginate($this->paginate);
    
                session(['main' => $main]);

            }else{

                $this->danhSachNhanVien = User::permission('create_mo_phong')->get();

                $main = DB::table('mo_phong')
                ->where('ket_thuc_mo_phong', $this->trangThaiTimKiem == '0' ? null : $this->trangThaiTimKiem)
                ->where(function($query){
    
                    $query->whereRaw("'" . $this->userTimKiem . "' = ''");
                    $query->orWhere('created_user', 'like', '%' . $this->userTimKiem . '%');
        
                })
                ->where(function($query){
        
                    $query->whereRaw("'" . $this->soLuuKhoTimKiem . "' = ''");
                    $query->orWhere('so_luu_kho', 'like', '%' . $this->soLuuKhoTimKiem . '%');
        
                })
                ->where(function($query){
        
                    $query->whereRaw("'" . $this->maTimKiem . "' = ''");
                    $query->orWhere('ma', 'like', '%' . $this->maTimKiem . '%');
        
                })
                ->where(function($query){
    
                    $query->whereRaw("'" . $this->quyCachTimKiem . "' = ''");
                    $query->orWhere('quy_cach', 'like', '%' . $this->quyCachTimKiem . '%');
        
                })
                ->where(function($query){
        
                    $query->whereRaw("'" . $this->mayTimKiem . "' = ''");
                    $query->orWhere('may', 'like', '%' . $this->mayTimKiem . '%');
        
                })
                ->where(function($query){
        
                    $query->whereRaw("'" . $this->plantTimKiem . "' = ''");
                    $query->orWhere('plant', 'like', '%' . $this->plantTimKiem . '%');
        
                })
                ->where(function($query){
    
                    $query->whereRaw("'" . $this->ngaySanXuatTimKiem . "' = ''");
                    $query->orWhere('ngay_san_xuat', 'like', '%' . $this->ngaySanXuatTimKiem . '%');
        
                })
                ->where(function($query){
        
                    $query->whereRaw("'" . $this->ngayDetTimKiem . "' = ''");
                    $query->orWhere('ngay_det', 'like', '%' . $this->ngayDetTimKiem . '%');
        
                })
                ->where(function($query){
        
                    $query->whereRaw("'" . $this->ketQuaNhuomTimKiem . "' = ''");
                    $query->orWhere('ket_qua_nhuom', 'like', '%' . $this->ketQuaNhuomTimKiem . '%');
        
                })
                ->where(function($query){

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
                ->orderBy('so_luu_kho')
                ->paginate($this->paginate);
    
                session(['main' => $main]);

            }

        }elseif($this->state == 'capNhat'){

            $tksx = DB::table('phieu_tksx')
            ->where('so_phieu', $this->soPhieuTKSX)
            ->first();

            $this->state = 'capNhat';
            $this->soPhieuTKSX = $this->soPhieuTKSX;
            $this->quyCach = $tksx->quy_cach_dty;
            $this->maHang = $tksx->ma_dty;
            $this->ngayTrenTKSX = Carbon::create($tksx->ngay)->isoFormat('YYYY-MM-DD');

        }elseif($this->state == 'chiTiet'){

            $this->danhSachMoPhong = DB::table('mo_phong')
            ->where('so_phieu_tksx', $this->soPhieuTKSX)
            ->get();

        }

        return view('livewire.mo-phong');
    }
}
