<?php

namespace App\Http\Livewire;

use Brick\Math\BigNumber;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Ramsey\Uuid\Type\Decimal;

use function Ramsey\Uuid\v1;

class SOFile extends Component
{
    public $so, $bookingNumber, $totalBookingContainer, $intendedVessel, $portOfLoading, $portOfDischarge, $intendedVgm, $intendedEsi, $intendedFcl, $eta, $etd;

    public $loaiChungTu, $fileAll;

    public $idRow, $state;

    public $quyCach, $soLuong;

    use WithFileUploads;

    public function mount($so){

        $this->so = $so;

    }

    public function resetInput(){

        $this->bookingNumber = null;
        $this->totalBookingContainer = null;
        $this->intendedVessel = null;
        $this->portOfLoading = null;
        $this->portOfDischarge = null;
        $this->intendedVgm = null;
        $this->intendedEsi = null;
        $this->intendedFcl = null;
        $this->eta = null;
        $this->etd = null;
        $this->loaiChungTu = null;
        $this->idRow = null;
        $this->state = null;

    }

    // Upload

    public function upFileAllModal(){

        $this->state = 'upFileAll';

    }

    public function upFileAll(){

        if($this->fileAll == null){

            flash()->addFlash('error', 'Thao tác quá nhanh, vui lòng bấm "Thực hiện" lại.','Thông báo');

        }else{

            DB::transaction(function (){

                $arrayFile = [];
    
                foreach ($this->fileAll as $item) {
    
                    array_push($arrayFile, $item->getClientOriginalName());
    
                }

                if($this->loaiChungTu == 'bk'){

                    $id = DB::table('so_file')->insertGetId([

                        'so' => $this->so,
                        'file_bk' => implode(',', $arrayFile),
                        'booking_number' => $this->bookingNumber,
                        'total_booking_container' => $this->totalBookingContainer,
                        'intened_vessel' => $this->intendedVessel,
                        'port_of_loading' => $this->portOfLoading,
                        'port_of_discharge' => $this->portOfDischarge,
                        'intened_vgm_cut_off' => $this->intendedVgm,
                        'intened_esi_cut_off' => $this->intendedEsi,
                        'intened_fcl_cy_cut_off' => $this->intendedFcl,
                        'eta' => $this->eta,
                        'etd' => $this->etd,
                        'created_user' => Auth::user()->username,
                        'updated_user' => Auth::user()->username,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()

                    ]);

                    DB::table('so_file_log')->insert([

                        'so' => $this->so,
                        'id_file' => $id,
                        'ten_file' => implode(',', $arrayFile),
                        'loai_file' => 'bk',
                        'status' => 'Thêm',
                        'created_user' => Auth::user()->username,
                        'updated_user' => Auth::user()->username,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()

                    ]);

                    DB::table('so')
                    ->where('so', $this->so)
                    ->update([

                        'bk' => '1'

                    ]);
    
                    $path = 'SO/' . $this->so . '/' . $id . '/BK';
    
                }elseif($this->loaiChungTu == 'lc'){

                    $id = DB::table('so_file')->insertGetId([

                        'so' => $this->so,
                        'file_lc' => implode(',', $arrayFile),
                        'created_user' => Auth::user()->username,
                        'updated_user' => Auth::user()->username,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()

                    ]);

                    DB::table('so_file_log')->insert([

                        'so' => $this->so,
                        'id_file' => $id,
                        'ten_file' => implode(',', $arrayFile),
                        'loai_file' => 'lc',
                        'status' => 'Thêm',
                        'created_user' => Auth::user()->username,
                        'updated_user' => Auth::user()->username,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()

                    ]);

                    DB::table('so')
                    ->where('so', $this->so)
                    ->update([

                        'lc' => '1'

                    ]);
    
                    $path = 'SO/' . $this->so . '/' . $id . '/LC';
    
                }elseif($this->loaiChungTu == 'cthq'){

                    $id = DB::table('so_file')->insertGetId([

                        'so' => $this->so,
                        'file_cthq' => implode(',', $arrayFile),
                        'created_user' => Auth::user()->username,
                        'updated_user' => Auth::user()->username,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()

                    ]);

                    DB::table('so_file_log')->insert([

                        'so' => $this->so,
                        'id_file' => $id,
                        'ten_file' => implode(',', $arrayFile),
                        'loai_file' => 'cthq',
                        'status' => 'Thêm',
                        'created_user' => Auth::user()->username,
                        'updated_user' => Auth::user()->username,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()

                    ]);

                    DB::table('so')
                    ->where('so', $this->so)
                    ->update([

                        'cthq' => '1'

                    ]);
    
                    $path = 'SO/' . $this->so . '/' . $id . '/ChungTuHaiQuan';
                    
                }elseif($this->loaiChungTu == 'pxk'){
    
                    $id = DB::table('so_file')->insertGetId([

                        'so' => $this->so,
                        'file_pxk' => implode(',', $arrayFile),
                        'quy_cach' => $this->quyCach,
                        'so_luong' => str_replace(',', '', $this->soLuong),
                        'created_user' => Auth::user()->username,
                        'updated_user' => Auth::user()->username,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()

                    ]);

                    DB::table('so_file_log')->insert([

                        'so' => $this->so,
                        'id_file' => $id,
                        'ten_file' => implode(',', $arrayFile),
                        'loai_file' => 'pxk',
                        'status' => 'Thêm',
                        'created_user' => Auth::user()->username,
                        'updated_user' => Auth::user()->username,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()

                    ]);

                    DB::table('so')
                    ->where('so', $this->so)
                    ->update([

                        'pxk' => '1'

                    ]);
    
                    $path = 'SO/' . $this->so . '/' . $id . '/PhieuXuatKho';
    
                }elseif($this->loaiChungTu == 'co'){

                    $id = DB::table('so_file')->insertGetId([

                        'so' => $this->so,
                        'file_co' => implode(',', $arrayFile),
                        'created_user' => Auth::user()->username,
                        'updated_user' => Auth::user()->username,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()

                    ]);

                    DB::table('so_file_log')->insert([

                        'so' => $this->so,
                        'id_file' => $id,
                        'ten_file' => implode(',', $arrayFile),
                        'loai_file' => 'co',
                        'status' => 'Thêm',
                        'created_user' => Auth::user()->username,
                        'updated_user' => Auth::user()->username,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()

                    ]);

                    DB::table('so')
                    ->where('so', $this->so)
                    ->update([

                        'co' => '1'

                    ]);
    
                    $path = 'SO/' . $this->so . '/' . $id . '/CO';
    
                }elseif($this->loaiChungTu == 'tkxh'){
    
                    $id = DB::table('so_file')->insertGetId([

                        'so' => $this->so,
                        'file_tkxh' => implode(',', $arrayFile),
                        'created_user' => Auth::user()->username,
                        'updated_user' => Auth::user()->username,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()

                    ]);

                    DB::table('so_file_log')->insert([

                        'so' => $this->so,
                        'id_file' => $id,
                        'ten_file' => implode(',', $arrayFile),
                        'loai_file' => 'tkxh',
                        'status' => 'Thêm',
                        'created_user' => Auth::user()->username,
                        'updated_user' => Auth::user()->username,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()

                    ]);

                    DB::table('so')
                    ->where('so', $this->so)
                    ->update([

                        'tkxh' => '1'

                    ]);
    
                    $path = 'SO/' . $this->so . '/' . $id . '/ToKhaiXuatHang';
    
                }elseif($this->loaiChungTu == 'tlcd'){

                    $id = DB::table('so_file')->insertGetId([

                        'so' => $this->so,
                        'file_tlcd' => implode(',', $arrayFile),
                        'created_user' => Auth::user()->username,
                        'updated_user' => Auth::user()->username,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()

                    ]);

                    DB::table('so_file_log')->insert([

                        'so' => $this->so,
                        'id_file' => $id,
                        'ten_file' => implode(',', $arrayFile),
                        'loai_file' => 'tlcd',
                        'status' => 'Thêm',
                        'created_user' => Auth::user()->username,
                        'updated_user' => Auth::user()->username,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()

                    ]);

                    DB::table('so')
                    ->where('so', $this->so)
                    ->update([

                        'tlcd' => '1'

                    ]);

    
                    $path = 'SO/' . $this->so . '/' . $id . '/TaiLieuCoDinh';
    
                }
    
                if(!Storage::disk('ftp')->exists($path)) {
    
                    Storage::disk('ftp')->makeDirectory($path);
    
                }
    
                foreach ($this->fileAll as $item) {
    
                    Storage::disk('ftp')->putFileAs($path, $item, $item->getClientOriginalName());
    
                } 
    
                flash()->addSuccess('Thành công.');
                $this->resetInput();
                $this->emit('upFileAllModal');
    
            });

        }

    }

    public function updateFileModal($id, $bk){

        $this->idRow = $id;

        $this->bookingNumber = $bk;

        $this->state = 'updateFile';

    }

    public function updateFile(){

        DB::transaction(function (){

            $arrayFile = [];
    
            foreach ($this->fileAll as $item) {

                array_push($arrayFile, $item->getClientOriginalName());

            }

            $soFile = DB::table('so_file')
            ->where('so', $this->so)
            ->where('id', $this->idRow)
            ->first();

            if($soFile->{'file_' . $this->loaiChungTu} != ''){

                DB::table('so_file')
                ->where('so', $this->so)
                ->where('id', $this->idRow)
                ->update([
    
                    'file_' . $this->loaiChungTu => $soFile->{'file_' . $this->loaiChungTu} . ',' . implode(',', $arrayFile),
                    'updated_user' => Auth::user()->username,
                    'updated_at' => Carbon::now()
    
                ]);

                DB::table('so_file_log')->insert([

                    'so' => $this->so,
                    'id_file' => $this->idRow,
                    'ten_file' => implode(',', $arrayFile),
                    'loai_file' => $this->loaiChungTu,
                    'status' => 'Thêm',
                    'created_user' => Auth::user()->username,
                    'updated_user' => Auth::user()->username,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()

                ]);

                DB::table('so')
                ->where('so', $this->so)
                ->update([

                    $this->loaiChungTu => '1'

                ]);

            }else{

                if($this->loaiChungTu == 'bk'){

                    DB::table('so_file')
                    ->where('so', $this->so)
                    ->where('id', $this->idRow)
                    ->update([
        
                        'file_bk' => implode(',', $arrayFile),
                        'booking_number' => $this->bookingNumber,
                        'total_booking_container' => $this->totalBookingContainer,
                        'intened_vessel' => $this->intendedVessel,
                        'port_of_loading' => $this->portOfLoading,
                        'port_of_discharge' => $this->portOfDischarge,
                        'intened_vgm_cut_off' => $this->intendedVgm,
                        'intened_esi_cut_off' => $this->intendedEsi,
                        'intened_fcl_cy_cut_off' => $this->intendedFcl,
                        'eta' => $this->eta,
                        'etd' => $this->etd,
                        'updated_user' => Auth::user()->username,
                        'updated_at' => Carbon::now()
        
                    ]);

                    DB::table('so_file_log')->insert([

                        'so' => $this->so,
                        'id_file' => $this->idRow,
                        'ten_file' => implode(',', $arrayFile),
                        'loai_file' => $this->loaiChungTu,
                        'status' => 'Thêm',
                        'created_user' => Auth::user()->username,
                        'updated_user' => Auth::user()->username,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
    
                    ]);
    
                    DB::table('so')
                    ->where('so', $this->so)
                    ->update([
    
                        $this->loaiChungTu => '1'
    
                    ]);

                }else{

                    DB::table('so_file')
                    ->where('so', $this->so)
                    ->where('id', $this->idRow)
                    ->update([
        
                        'file_' . $this->loaiChungTu => implode(',', $arrayFile),
                        'updated_user' => Auth::user()->username,
                        'updated_at' => Carbon::now()
        
                    ]);

                    DB::table('so_file_log')->insert([

                        'so' => $this->so,
                        'id_file' => $this->idRow,
                        'ten_file' => implode(',', $arrayFile),
                        'loai_file' => $this->loaiChungTu,
                        'status' => 'Thêm',
                        'created_user' => Auth::user()->username,
                        'updated_user' => Auth::user()->username,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
    
                    ]);
    
                    DB::table('so')
                    ->where('so', $this->so)
                    ->update([
    
                        $this->loaiChungTu => '1'
    
                    ]);

                }

            }

            if($this->loaiChungTu == 'bk'){
    
                $path = 'SO/' . $this->so . '/' . $this->idRow . '/BK';

            }elseif($this->loaiChungTu == 'lc'){
    
                $path = 'SO/' . $this->so . '/' . $this->idRow . '/LC';

            }elseif($this->loaiChungTu == 'cthq'){

                $path = 'SO/' . $this->so . '/' . $this->idRow . '/ChungTuHaiQuan';
                
            }elseif($this->loaiChungTu == 'pxk'){

                $path = 'SO/' . $this->so . '/' . $this->idRow . '/PhieuXuatKho';

            }elseif($this->loaiChungTu == 'co'){

                $path = 'SO/' . $this->so . '/' . $this->idRow . '/CO';

            }elseif($this->loaiChungTu == 'tkxh'){

                $path = 'SO/' . $this->so . '/' . $this->idRow . '/ToKhaiXuatHang';

            }elseif($this->loaiChungTu == 'tlcd'){

                $path = 'SO/' . $this->so . '/' . $this->idRow . '/TaiLieuCoDinh';

            }

            if(!Storage::disk('ftp')->exists($path)) {
    
                Storage::disk('ftp')->makeDirectory($path);

            }

            foreach ($this->fileAll as $item) {

                Storage::disk('ftp')->putFileAs($path, $item, $item->getClientOriginalName());

            }

            flash()->addSuccess('Thành công.');
            $this->resetInput();
            $this->emit('updateFileModal');

        });

    }

    // Download

    public function downloadFile($bookingNumber, $loai, $so, $tenFile){

        $path = 'SO/' . $so . '/' . $bookingNumber . '/' . $loai . '/' . $tenFile;

        return Storage::disk('ftp')->download($path);

    }

    public function render()
    {
        // Lấy Danh Sách File
        $danhSachFile = DB::table('so_file')
        ->where('so', $this->so)
        ->get();

        // Lấy tổng số lượng trong phiếu XXĐH

        $tongSoLuong = 0;

        $table = DB::table('phieu_xxdh')
        ->join('phieu_xxdh_quy_cach', 'phieu_xxdh.id', 'phieu_xxdh_quy_cach.phieu_xxdh_so_phieu_id') 
        ->where('phieu_xxdh.so', $this->so)
        ->leftjoin('so_file', 'phieu_xxdh.so', 'so_file.so')
        ->select('phieu_xxdh_quy_cach.quy_cach as quy_cach', 'phieu_xxdh_quy_cach.so_luong as so_luong_tong', 'so_file.so_luong as so_luong_da_giao')
        ->get();

        $table->transform(function ($item){

            $item->so_luong_tong = str_replace(',', '', $item->so_luong_tong);
            $item->so_luong_da_giao = $item->so_luong_da_giao == '' ? 0 : str_replace(',', '', $item->so_luong_da_giao);

            return $item;

        });

        return view('livewire.so-file', compact('danhSachFile', 'table'));
    }
}
