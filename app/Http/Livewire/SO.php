<?php

namespace App\Http\Livewire;

use App\Models\HopDong;
use App\Models\PhieuTKSX;
use App\Models\PhieuTKSXFDY;
use App\Models\PhieuTKSXFDYLog;
use App\Models\PhieuTKSXLog;
use App\Models\PhieuXXDH;
use App\Models\PhieuXXDHLog;
use App\Models\QuyCachPhieuXXDH;
use App\Models\SanPham;
use App\Models\SO as ModelsSO;
use App\Models\SOLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class SO extends Component
{   
    use WithFileUploads;

    use WithPagination;

    public $so, $phieu_xxdh, $status_phieu_xxdh, $phieu_tksx, $status_phieu_tksx;

    public $paginate;

    public $danhSachFileBooking, $fileBooking = [], $fileBookingID, $noteBooking, $danhSachNoteBooking;

    public $danhSachFileChungTuHaiQuan, $fileChungTuHaiQuan = [], $fileChungTuHaiQuanID, $noteChungTuHaiQuan, $danhSachNoteChungTuHaiQuan;

    public $danhSachFilePhieuXuatKho, $filePhieuXuatKho = [], $filePhieuXuatKhoID, $notePhieuXuatKho, $danhSachNotePhieuXuatKho;

    public $danhSachFileCO, $fileCO = [], $fileCOID, $noteCO, $danhSachNoteCO;

    public $danhSachFileToKhaiXuatHang, $fileToKhaiXuatHang = [], $fileToKhaiXuatHangID, $noteToKhaiXuatHang, $danhSachNoteToKhaiXuatHang;

    public $danhSachFileTaiLieuCoDinh, $fileTaiLieuCoDinh = [], $fileTaiLieuCoDinhID, $noteTaiLieuCoDinh, $danhSachNoteTaiLieuCoDinh;

    public $tab;

    public $loaiDonHang,$soPhieuXXDH ,$donHangGRS, $donHangNonGRS, $donHangSXMoi ,$donHangLapLai ,$donHangTonKho ,$date ,$tenCongTyXXDH ,$soSO ,$quyCachSuDung ,$soLuong ,$soCone;

    public $soKgCone, $qaKienNghi, $Line, $May, $ngayGiaoHang, $ngayBatDauGiao, $kieuMayDet, $lot, $thanhPhamCuaKhachHang, $phanAnhCuaKhachHang , $phanHoiKHST, $phanHoiQA, $soHD, $thongTinDongGoi;

    public $quyCachPhieuXXDH, $quyCachPhieuXXDHKHST;

    public $soPhieuTKSX, $soPhieuXXDHMoi, $sale, $soMay, $quyCach, $maHang, $ngay, $mauOng, $quyCachPOY, $maPOY, $quyCachDTY, $maDTY, $tenCongTyTKSX, $loaiHang, $soLuongDonHang, $ghiChuSoLuong, $dieuKienKhachHang, $status, $lotSale;
    
    public $selectSo, $search, $tuNgay, $denNgay;

    public $state;

    public $cbTB2, $cbTB3, $cbCC;

    public $phieuXXDH, $logPXXDH, $PhieuTKSXDTY, $logPTKSXDTY, $PhieuTKSXFDY, $logPTKSXFDY;

    public $thongTinDoiMa, $soi, $maCuMoi;

    public $soHopDong, $hopdong,$sanpham,$danhsachfileHD,$danhsachfilePhuluc,$danhsachfileTDG;

    protected $search_result;

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function mount(){

        $this->paginate = 15;

        $this->tab = '3';

        $this->state = 'main';

    }

    public function resetInputField(){

        $this->fileBooking = [];
        $this->noteBooking = '';

        $this->fileChungTuHaiQuan = [];
        $this->noteChungTuHaiQuan = '';

        $this->filePhieuXuatKho = [];
        $this->notePhieuXuatKho = '';

        $this->fileCO = [];
        $this->noteCO = '';

        $this->fileToKhaiXuatHang = [];
        $this->noteToKhaiXuatHang = '';

        $this->fileTaiLieuCoDinh = [];
        $this->noteTaiLieuCoDinh = '';

        $this->state = 'main';

    }

    public function convert_name($str) {

		$str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
		$str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
		$str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
		$str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
		$str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
		$str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
		$str = preg_replace("/(đ)/", 'd', $str);
		$str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
		$str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
		$str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
		$str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
		$str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
		$str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
		$str = preg_replace("/(Đ)/", 'D', $str);
		$str = preg_replace("/(\“|\”|\‘|\’|\,|\!|\&|\;|\@|\#|\%|\~|\`|\=|\_|\'|\]|\[|\}|\{|\)|\(|\+|\^)/", '-', $str);
		$str = preg_replace("/( )/", '-', $str);
		return $str;

	}

    public function downloadFile($status, $so, $tenfile){
        
        return Storage::disk('ftp')->download($status . '/' . $so . '/' . $tenfile);

    }

    public function deleteFile($status, $so, $tenfile){

        Storage::disk('ftp')->delete($status . '/' . $so . '/' . $tenfile);

        $path = $status . "/" . $so;

        $this->{'danhSachFile' . $status} = Storage::disk('ftp')->allFiles($path);

        DB::transaction( function() use($status, $so, $tenfile) {

            if($this->{'danhSachFile' . $status} == null){

                if($status == 'Booking'){

                    $arr = [

                        'booking' => ''

                    ];

                }elseif ($status == 'ChungTuHaiQuan') {
                    
                    $arr = [

                        'chung_tu_hai_quan' => ''

                    ];

                }elseif ($status == 'PhieuXuatKho') {
                    
                    $arr = [

                        'phieu_xuat_kho' => ''

                    ];

                }elseif ($status == 'CO') {
                    
                    $arr = [

                        'co' => ''

                    ];

                }elseif ($status == 'ToKhaiXuatHang') {
                    
                    $arr = [

                        'to_khai_xuat_hang' => ''

                    ];

                }
                elseif ($status == 'TaiLieuCoDinh') {
                    
                    $arr = [

                        'tai_lieu_co_dinh' => ''

                    ];

                }

                ModelsSO::where('so',$so)->update($arr);

            }

            $file = DB::table('so_file')
            ->where('so', $so)
            ->where('ten_file', $tenfile)
            ->where('status', $status)
            ->first();

            DB::table('so_file')
            ->where('so', $so)
            ->where('ten_file', $tenfile)
            ->where('status', $status)
            ->delete();
    
            SOLog::create([
        
                'so' => $so,
                'ten_file' => $tenfile,
                'note' => $file->note,
                'status' => $status,
                'status_log' => 'Delete',
                'username' => Auth::user()->username
    
            ]);
    
            flash()->addFlash('success', 'Delete file thành công','Thông báo');

        });

    }

    public function tab($tab){

        $this->tab = $tab;

    }

    public function details($so){

        $this->state = 'details';

        $this->so = $so;

    }

    public function detailFilesSOModal($so){

        $this->state = 'detailFiles';

        $this->so = $so;

    }

    // Chi tiết hợp đồng

    public function detailHopDongModal($soHopDong){

        $this->state = 'detailHopDong';

        if(substr($soHopDong,0,3) == 'TKY'){

            $this->soHopDong = $soHopDong;

        }else{

            $soHopDongRutGon = str_replace(['/HĐMB-','/HDMB-'], '', $soHopDong);

            $laySoNam = substr($soHopDongRutGon, strlen($soHopDongRutGon) - 4, strlen($soHopDongRutGon));

            $lay5KyTuDau = str_replace(substr($soHopDongRutGon, strlen($soHopDongRutGon) - 4, strlen($soHopDongRutGon)), '', $soHopDongRutGon);

            if(strlen($lay5KyTuDau) == 4){

                $lay5KyTuDau = '0' . $lay5KyTuDau;

            }

            $this->soHopDong =  $laySoNam . $lay5KyTuDau;

        }

    }

    public function taifileHD($sohd, $tenfile){

        $hopdong = HopDong::where('sohd', $sohd)->first();

        if($hopdong->loaihopdong == '1' || $hopdong->loaihopdong == '2'){

            return response()->download(storage_path('app/public/HD/') . $sohd . '/' . $tenfile);

        }else{
        
            return response()->download(storage_path('app/public/HD/') . str_replace('/', '_', $sohd) . '/' . str_replace('/', '_', $tenfile));
        
        }
    }

    public function taifilePhuluc($sohd, $tenfile){

        $hopdong = HopDong::where('sohd', $sohd)->first();

        if($hopdong->loaihopdong == '1' || $hopdong->loaihopdong == '2'){

            return response()->download(storage_path('app/public/Addendum/') . $sohd . '/' . $tenfile);

        }else{
        
            return response()->download(storage_path('app/public/Addendum/') . str_replace('/', '_', $sohd) . '/' . str_replace('/', '_', $tenfile));
        
        }
    }

    public function taifileTDG($so_tdg){

        if(substr($so_tdg, 0, 3) == 'TDG')
            return Storage::disk('ftp')->download('TDG/' . $so_tdg . '.xlsx');
        elseif(substr($so_tdg, 0, 3) == 'TTD')
            return Storage::disk('ftp')->download('TTDH/' . $so_tdg . '.xlsx');
    }

    // Chi tiết Phiếu XXĐH

    public function detailPhieuXXDHModal($soPhieu){

        $this->state = 'detailPhieuXXDH';

        $this->soPhieuXXDH = $soPhieu;

    }

    // Chi tiết Phiếu XXĐH

    public function detailPhieuTKSXModal($soPhieu){

        $this->state = 'detailPhieuTKSX';

        $this->soPhieuTKSX = $soPhieu;

    }

    // Upload File

    public function uploadBooking($so){

        if($this->fileBooking == null){

            flash()->addFlash('error', 'Thao tác quá nhanh, vui lòng bấm "Thực hiện" lại.','Thông báo');

        }else{

            $path = "Booking/" . $so;

            if(!Storage::disk('ftp')->exists($path)) {

                Storage::disk('ftp')->makeDirectory($path);

            }

            DB::transaction( function () use($path,$so){

                foreach ($this->fileBooking as $file) {

                    //$file->storeAs($path, $file->getClientOriginalName() ,'ftp');

                    //Storage::putFile($path, $file);

                    $danhSachFile = DB::table('so_file')
                    ->where('so', $this->so)
                    ->where('status', 'Booking')
                    ->get();

                    foreach ($danhSachFile as $item) {
                        if ($item->ten_file == $file->getClientOriginalName()) {
                            
                            sweetalert()->addError('Tên file đã tồn tại. Vui lòng chọn file khác.');
                            return;

                        }
                    }

                    Storage::disk('ftp')->putFileAs($path, $file, $this->convert_name($file->getClientOriginalName()));

                    DB::table('so_file')->insert([

                        'so' => $so,
                        'ten_file' => $this->convert_name($file->getClientOriginalName()),
                        'note' => $this->noteBooking,
                        'status' => 'Booking',
                        'username' => Auth::user()->username,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),

                    ]);
    
                    SOLog::create([
    
                        'so' => $so,
                        'ten_file' => $this->convert_name($file->getClientOriginalName()),
                        'note' => $this->noteBooking,
                        'status' => 'Booking',
                        'status_log' => 'Upload',
                        'username' => Auth::user()->username
    
                    ]);
    
                }
    
                ModelsSO::where('so', $so)->update([
    
                    'booking' => '1',
                    
                ]);

                flash()->addFlash('success', 'Upload file thành công','Thông báo');
                // $this->danhSachFileBooking = Storage::disk('ftp')->allFiles($path);
                // $this->fileBookingID++;
                // $this->selectSo = ModelsSO::where('so', $so)->first();
                $this->resetInputField();
                $this->state = 'details';

            });            
        }
    }

    public function uploadChungTuHaiQuan($so){

        if($this->fileChungTuHaiQuan == null){

            flash()->addFlash('error', 'Thao tác quá nhanh, vui lòng bấm "Thực hiện" lại.','Thông báo');

        }else{

            $path = "ChungTuHaiQuan/" . $so;

            if(!Storage::disk('ftp')->exists($path)) {

                Storage::disk('ftp')->makeDirectory($path);

            }

            DB::transaction( function () use($path,$so){

                foreach ($this->fileChungTuHaiQuan as $file) {

                    //$file->storeAs($path, $file->getClientOriginalName() ,'ftp');

                    Storage::disk('ftp')->putFileAs($path, $file, $this->convert_name($file->getClientOriginalName()));

                    DB::table('so_file')->insert([

                        'so' => $so,
                        'ten_file' => $this->convert_name($file->getClientOriginalName()),
                        'note' => $this->noteChungTuHaiQuan,
                        'status' => 'ChungTuHaiQuan',
                        'username' => Auth::user()->username,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),

                    ]);
    
                    SOLog::create([
    
                        'so' => $so,
                        'ten_file' => $this->convert_name($file->getClientOriginalName()),
                        'note' => $this->noteChungTuHaiQuan,
                        'status' => 'ChungTuHaiQuan',
                        'status_log' => 'Upload',
                        'username' => Auth::user()->username
    
                    ]);
    
                }
    
                ModelsSO::where('so', $so)->update([
    
                    'chung_tu_hai_quan' => '1',
                    
                ]);

            });            
    
            flash()->addFlash('success', 'Upload file thành công','Thông báo');
            // $this->danhSachFileChungTuHaiQuan = Storage::disk('ftp')->allFiles($path);
            // $this->fileChungTuHaiQuanID++;
            // $this->selectSo = ModelsSO::where('so', $so)->first();
            $this->resetInputField();
            $this->state = 'details';
        }
    }

    public function uploadPhieuXuatKho($so){

        if($this->filePhieuXuatKho == null){

            flash()->addFlash('error', 'Thao tác quá nhanh, vui lòng bấm "Thực hiện" lại.','Thông báo');

        }else{

            $path = "PhieuXuatKho/" . $so;

            if(!Storage::disk('ftp')->exists($path)) {

                Storage::disk('ftp')->makeDirectory($path);

            }

            DB::transaction( function () use($path,$so){

                foreach ($this->filePhieuXuatKho as $file) {

                    Storage::disk('ftp')->putFileAs($path, $file, $this->convert_name($file->getClientOriginalName()));
    
                    DB::table('so_file')->insert([

                        'so' => $so,
                        'ten_file' => $this->convert_name($file->getClientOriginalName()),
                        'note' => $this->notePhieuXuatKho,
                        'status' => 'PhieuXuatKho',
                        'username' => Auth::user()->username,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),

                    ]);

                    SOLog::create([
    
                        'so' => $so,
                        'ten_file' => $this->convert_name($file->getClientOriginalName()),
                        'note' => $this->notePhieuXuatKho,
                        'status' => 'PhieuXuatKho',
                        'status_log' => 'Upload',
                        'username' => Auth::user()->username
    
                    ]);
    
                }
    
                ModelsSO::where('so', $so)->update([
    
                    'phieu_xuat_kho' => '1',
                    
                ]);

            });            
    
            flash()->addFlash('success', 'Upload file thành công','Thông báo');
            // $this->danhSachFilePhieuXuatKho = Storage::disk('ftp')->allFiles($path);
            // $this->filePhieuXuatKhoID++;
            // $this->selectSo = ModelsSO::where('so', $so)->first();
            $this->resetInputField();
            $this->state = 'details';
        }
    }

    public function uploadCO($so){

        if($this->fileCO == null){

            flash()->addFlash('error', 'Thao tác quá nhanh, vui lòng bấm "Thực hiện" lại.','Thông báo');

        }else{

            $path = "CO/" . $so;

            if(!Storage::disk('ftp')->exists($path)) {

                Storage::disk('ftp')->makeDirectory($path);

            }

            DB::transaction( function () use($path,$so){

                foreach ($this->fileCO as $file) {

                    Storage::disk('ftp')->putFileAs($path, $file, $this->convert_name($file->getClientOriginalName()));
    
                    DB::table('so_file')->insert([

                        'so' => $so,
                        'ten_file' => $this->convert_name($file->getClientOriginalName()),
                        'note' => $this->noteCO,
                        'status' => 'CO',
                        'username' => Auth::user()->username,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),

                    ]);

                    SOLog::create([
    
                        'so' => $so,
                        'ten_file' => $this->convert_name($file->getClientOriginalName()),
                        'note' => $this->noteCO,
                        'status' => 'CO',
                        'status_log' => 'Upload',
                        'username' => Auth::user()->username
    
                    ]);
    
                }
    
                ModelsSO::where('so', $so)->update([
    
                    'co' => '1',
                    
                ]);

            });            
    
            flash()->addFlash('success', 'Upload file thành công','Thông báo');
            // $this->danhSachFileCO = Storage::disk('ftp')->allFiles($path);
            // $this->fileCOID++;
            // $this->selectSo = ModelsSO::where('so', $so)->first();
            $this->resetInputField();
            $this->state = 'details';
        }
    }

    public function uploadToKhaiXuatHang($so){

        if($this->fileToKhaiXuatHang == null){

            flash()->addFlash('error', 'Thao tác quá nhanh, vui lòng bấm "Thực hiện" lại.','Thông báo');

        }else{

            $path = "ToKhaiXuatHang/" . $so;

            if(!Storage::disk('ftp')->exists($path)) {

                Storage::disk('ftp')->makeDirectory($path);

            }

            DB::transaction( function () use($path,$so){

                foreach ($this->fileToKhaiXuatHang as $file) {

                    Storage::disk('ftp')->putFileAs($path, $file, $this->convert_name($file->getClientOriginalName()));
    
                    DB::table('so_file')->insert([

                        'so' => $so,
                        'ten_file' => $this->convert_name($file->getClientOriginalName()),
                        'note' => $this->noteToKhaiXuatHang,
                        'status' => 'ToKhaiXuatHang',
                        'username' => Auth::user()->username,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),

                    ]);

                    SOLog::create([
    
                        'so' => $so,
                        'ten_file' => $this->convert_name($file->getClientOriginalName()),
                        'note' => $this->noteToKhaiXuatHang,
                        'status' => 'ToKhaiXuatHang',
                        'status_log' => 'Upload',
                        'username' => Auth::user()->username
    
                    ]);
    
                }
    
                ModelsSO::where('so', $so)->update([
    
                    'to_khai_xuat_hang' => '1',
                    
                ]);

            });            
    
            flash()->addFlash('success', 'Upload file thành công','Thông báo');
            // $this->danhSachFileToKhaiXuatHang = Storage::disk('ftp')->allFiles($path);
            // $this->fileToKhaiXuatHangID++;
            // $this->selectSo = ModelsSO::where('so', $so)->first();
            $this->resetInputField();
            $this->state = 'details';
        }
    }

    public function uploadTaiLieuCoDinh($so){

        if($this->fileTaiLieuCoDinh == null){

            flash()->addFlash('error', 'Thao tác quá nhanh, vui lòng bấm "Thực hiện" lại.','Thông báo');

        }else{

            $path = "TaiLieuCoDinh/" . $so;

            if(!Storage::disk('ftp')->exists($path)) {

                Storage::disk('ftp')->makeDirectory($path);

            }

            DB::transaction( function () use($path,$so){

                foreach ($this->fileTaiLieuCoDinh as $file) {

                    Storage::disk('ftp')->putFileAs($path, $file, $this->convert_name($file->getClientOriginalName()));

                    DB::table('so_file')->insert([

                        'so' => $so,
                        'ten_file' => $this->convert_name($file->getClientOriginalName()),
                        'note' => $this->noteTaiLieuCoDinh,
                        'status' => 'TaiLieuCoDinh',
                        'username' => Auth::user()->username,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),

                    ]);
    
                    SOLog::create([
    
                        'so' => $so,
                        'ten_file' => $this->convert_name($file->getClientOriginalName()),
                        'note' => $this->noteTaiLieuCoDinh,
                        'status' => 'TaiLieuCoDinh',
                        'status_log' => 'Upload',
                        'username' => Auth::user()->username
    
                    ]);
    
                }
    
                ModelsSO::where('so', $so)->update([
    
                    'tai_lieu_co_dinh' => '1',
                    
                ]);

            });            
    
            flash()->addFlash('success', 'Upload file thành công','Thông báo');
            // $this->danhSachFileTaiLieuCoDinh = Storage::disk('ftp')->allFiles($path);
            // $this->fileTaiLieuCoDinhID++;
            // $this->selectSo = ModelsSO::where('so', $so)->first();
            $this->resetInputField();
            $this->state = 'details';
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function search(){

        $search_fields = [
            'so',
            'hop_dong',
            'phieu_xxdh',
            'phieu_tksx',
        ];

        $search_terms = explode(',', $this->search);

        $query = ModelsSO::query();

        foreach ($search_terms as $term) {
            $query->orWhere(function ($query) use ($search_fields, $term) {

                foreach ($search_fields as $field) {
                    $query->orWhere($field, 'LIKE', '%' . trim($term) . '%');
                }
            });
        }

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

        $query->orderByDesc('created_at');

        $this->search_result = $query->paginate($this->paginate);

    }

    public function render()
    {
        if($this->state == 'main'){

            if($this->search == ''){

                $query = ModelsSO::query();
    
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

                $query->orderByDesc('created_at');
    
                $danhSachSO = $query->paginate($this->paginate);
    
            }else{
                
                $this->search();
                $danhSachSO = $this->search_result;
    
            }

            session(['main' => $danhSachSO]);

        }if($this->state == 'detailHopDong'){

            $select = [

                'hop_dong.sohd',
                'hop_dong.loaihopdong',
                'hop_dong.so_tdg',
                'loai_hop_dong.tenhopdong',
                'hop_dong.ngaylaphd',
    
                'ben_a_vs_hop_dong.ten_tv as ben_a_vs_hop_dong_ten_tv',
                'ben_a_vs_hop_dong.dia_chi_tv as ben_a_vs_hop_dong_dia_chi_tv',
                'ben_a_vs_hop_dong.ma_so_thue_tv as ben_a_vs_hop_dong_ma_so_thue_tv',
                'ben_a_vs_hop_dong.dien_thoai_tv as ben_a_vs_hop_dong_dien_thoai_tv',
                'ben_a_vs_hop_dong.fax_tv as ben_a_vs_hop_dong_fax_tv',
    
                'ben_b_vs_hop_dong.ma_khach_hang as ben_b_vs_hop_dong_ma_khach_hang',
                'ben_b_vs_hop_dong.ten_tv as ben_b_vs_hop_dong_ten_tv',
                'ben_b_vs_hop_dong.dia_chi_tv as ben_b_vs_hop_dong_dia_chi_tv',
                'ben_b_vs_hop_dong.tai_khoan_ngan_hang_tv as ben_b_vs_hop_dong_tai_khoan_ngan_hang_tv',
                'ben_b_vs_hop_dong.dai_dien_tv as ben_b_vs_hop_dong_dai_dien_tv',
                'ben_b_vs_hop_dong.chuc_vu_tv as ben_b_vs_hop_dong_chuc_vu_tv',
                'ben_b_vs_hop_dong.ten_ta as ben_b_vs_hop_dong_ten_ta',
                'ben_b_vs_hop_dong.dia_chi_ta as ben_b_vs_hop_dong_dia_chi_ta',
                'ben_b_vs_hop_dong.tai_khoan_ngan_hang_ta as ben_b_vs_hop_dong_tai_khoan_ngan_hang_ta',
                'ben_b_vs_hop_dong.dai_dien_ta as ben_b_vs_hop_dong_dai_dien_ta',
                'ben_b_vs_hop_dong.chuc_vu_ta as ben_b_vs_hop_dong_chuc_vu_ta',
                'ben_b_vs_hop_dong.ma_so_thue_tv as ben_b_vs_hop_dong_ma_so_thue_tv',
                'ben_b_vs_hop_dong.dien_thoai_tv as ben_b_vs_hop_dong_dien_thoai_tv',
                'ben_b_vs_hop_dong.fax_tv as ben_b_vs_hop_dong_fax_tv',
    
                'dai_dien_ben_a_vs_hop_dong.dai_dien_tv as dai_dien_ben_a_vs_hop_dong_dai_dien_tv',
                'dai_dien_ben_a_vs_hop_dong.chuc_vu_tv as dai_dien_ben_a_vs_hop_dong_chuc_vu_tv',
                'dai_dien_ben_a_vs_hop_dong.dai_dien_ta as dai_dien_ben_a_vs_hop_dong_dai_dien_ta',
                'dai_dien_ben_a_vs_hop_dong.chuc_vu_ta as dai_dien_ben_a_vs_hop_dong_chuc_vu_ta',
                'dai_dien_ben_a_vs_hop_dong.uy_quyen_tv as dai_dien_ben_a_vs_hop_dong_uy_quyen_tv',
    
                'sotaikhoan',
                'chutaikhoan',
    
                'sotaikhoan_ta',
                'chutaikhoan_ta',
                
                'tygia',
                'chatluong',
                'donggoi',
                'thoigianthanhtoan',
                'phuongthucthanhtoan',
                'diadiemgiaohang',
                'diachi_diadiemgiaohang',
                'thoigiangiaohang',
                'phuongthucgiaohang',
                'giaohangtungphan',
                'phivanchuyen',
    
                'chatluong_ta',
                'donggoi_ta',
                'thoigianthanhtoan_ta',
                'phuongthucthanhtoan_ta',
                'diadiemgiaohang_ta',
                'diachi_diadiemgiaohang_ta',
                'phuongthucgiaohang_ta',
                'phivanchuyen_ta',
    
                'soluongbanin',
    
                'cpt',
                'po',
    
                'trungchuyen',
                'loadingport',
                'dischargport',
    
                'tinhtrang',
                'username_approve',
    
                'username',
    
                'hop_dong.created_at as hop_dong_created_at',
                'hop_dong.updated_at as hop_dong_updated_at'
    
            ];
    
            $this->hopdong = HopDong::join('ben_a_vs_hop_dong', 'hop_dong.bena', '=', 'ben_a_vs_hop_dong.id')
                                    ->join('ben_b_vs_hop_dong', 'hop_dong.benb', '=', 'ben_b_vs_hop_dong.id')
                                    ->join('dai_dien_ben_a_vs_hop_dong', 'hop_dong.dai_dien_ben_a', '=', 'dai_dien_ben_a_vs_hop_dong.id')
                                    ->join('loai_hop_dong', 'hop_dong.loaihopdong', '=', 'loai_hop_dong.id')
                                    ->where('hop_dong.sohd', $this->soHopDong)
                                    ->select($select)
                                    ->first();
    
            if($this->hopdong == null){
    
                sweetalert()->addError('Không tìm thấy thông tin hợp đồng.');
                $this->emit('detailHopDongModal');
                $this->state = 'main';
    
            }else{

                $this->sanpham = SanPham::where('sohd', $this->soHopDong)->first();
    
                if($this->hopdong->loaihopdong == '1' || $this->hopdong->loaihopdong == '2'){
        
                    $this->danhsachfileHD = Storage::disk('public')->allFiles('HD/' . $this->soHopDong);
                    $this->danhsachfilePhuluc = Storage::disk('public')->allFiles('Addendum/' . $this->soHopDong);
                    $this->danhsachfileTDG = Storage::disk('ftp')->allFiles('TDG/' . $this->soHopDong);
        
                }else{
        
                    $this->danhsachfileHD = Storage::disk('public')->allFiles('HD/' . str_replace('/','_',$this->soHopDong));
                    $this->danhsachfilePhuluc = Storage::disk('public')->allFiles('Addendum/' . str_replace('/','_',$this->soHopDong));
                    $this->danhsachfileTDG = Storage::disk('ftp')->allFiles('TDG/' . $this->soHopDong);
                }

            }

        }elseif($this->state == 'detailPhieuXXDH'){

            $this->phieuXXDH = PhieuXXDH::where('so_phieu', $this->soPhieuXXDH)->first();

            $this->quyCachPhieuXXDH = QuyCachPhieuXXDH::where('phieu_xxdh_so_phieu_id', $this->phieuXXDH->id)
            ->where('status', 'Sale')
            ->get();
    
            $this->quyCachPhieuXXDHKHST = QuyCachPhieuXXDH::where('phieu_xxdh_so_phieu_id', $this->phieuXXDH->id)
            ->where('status', 'KHST')
            ->get();
    
            $this->logPXXDH = PhieuXXDHLog::where('so_phieu', $this->phieuXXDH->so_phieu)->get();


        }elseif($this->state == 'detailPhieuTKSX'){

            $this->PhieuTKSXDTY = PhieuTKSX::where('so_phieu', $this->soPhieuTKSX)->get();

            $this->logPTKSXDTY = PhieuTKSXLog::where('so_phieu', $this->soPhieuTKSX)->get();

            if($this->PhieuTKSXDTY->isEmpty()){

                $this->PhieuTKSXFDY = PhieuTKSXFDY::where('so_phieu', $this->soPhieuTKSX)->get();

                $this->logPTKSXFDY = PhieuTKSXFDYLog::where('so_phieu', $this->soPhieuTKSX)->get();
            }

        }elseif($this->state == 'details'){

            // if(Storage::disk('ftp')->exists('Booking/' . $this->so)) {

            //     $this->danhSachFileBooking = Storage::disk('ftp')->allFiles('Booking/' . $this->so);

            //     $this->danhSachNoteBooking = DB::table('so_file')
            //     ->where('so', $this->so)
            //     ->where('status', 'Booking')
            //     ->get();

            // }

            // if(Storage::disk('ftp')->exists('ChungTuHaiQuan/' . $this->so)) {

            //     $this->danhSachFileChungTuHaiQuan = Storage::disk('ftp')->allFiles('ChungTuHaiQuan/' . $this->so);

            //     $this->danhSachNoteChungTuHaiQuan = DB::table('so_file')
            //     ->where('so', $this->so)
            //     ->where('status', 'ChungTuHaiQuan')
            //     ->get();

            // }

            // if(Storage::disk('ftp')->exists('PhieuXuatKho/' . $this->so)) {

            //     $this->danhSachFilePhieuXuatKho = Storage::disk('ftp')->allFiles('PhieuXuatKho/' . $this->so);

            //     $this->danhSachNotePhieuXuatKho = DB::table('so_file')
            //     ->where('so', $this->so)
            //     ->where('status', 'PhieuXuatKho')
            //     ->get();

            // }

            // if(Storage::disk('ftp')->exists('CO/' . $this->so)) {

            //     $this->danhSachFileCO = Storage::disk('ftp')->allFiles('CO/' . $this->so);

            //     $this->danhSachNoteCO = DB::table('so_file')
            //     ->where('so', $this->so)
            //     ->where('status', 'CO')
            //     ->get();

            // }

            // if(Storage::disk('ftp')->exists('ToKhaiXuatHang/' . $this->so)) {

            //     $this->danhSachFileToKhaiXuatHang = Storage::disk('ftp')->allFiles('ToKhaiXuatHang/' . $this->so);

            //     $this->danhSachNoteToKhaiXuatHang = DB::table('so_file')
            //     ->where('so', $this->so)
            //     ->where('status', 'ToKhaiXuatHang')
            //     ->get();

            // }

            // if(Storage::disk('ftp')->exists('TaiLieuCoDinh/' . $this->so)) {

            //     $this->danhSachFileTaiLieuCoDinh = Storage::disk('ftp')->allFiles('TaiLieuCoDinh/' . $this->so);

            //     $this->danhSachNoteTaiLieuCoDinh = DB::table('so_file')
            //     ->where('so', $this->so)
            //     ->where('status', 'TaiLieuCoDinh')
            //     ->get();

            // }
        }elseif($this->state == 'detailFiles'){

            

        }

        return view('livewire.s-o');
    }
}
