<?php

namespace App\Http\Livewire;

use App\Mail\AlertApproveMail;
use App\Mail\AlertRejectMail;
use App\Mail\CreateContractMail;
use App\Mail\HopDong as MailHopDong;
use App\Mail\NewContractMail;
use App\Mail\PhieuXXDHSaleToKhst;
use App\Models\BenA;
use App\Models\BenAHopDong;
use App\Models\BenB;
use App\Models\BenBHopDong;
use App\Models\ChatLuong;
use App\Models\DaiDienBenA;
use App\Models\DaiDienBenAHopDong;
use App\Models\DongGoi;
use App\Models\HopDong as ModelsHopDong;
use App\Models\HopDongLog;
use App\Models\Lear;
use App\Models\LearLog;
use App\Models\PhuongThucGiaoHang;
use App\Models\SanPham;
use App\Models\SanPhamLog;
use App\Models\SO;
use App\Models\TaiKhoanNganHang;
use App\Models\TaiKhoanNganHangNgoaiLe;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Livewire\WithPagination;
use PhpOffice\PhpWord\TemplateProcessor;
use TNkemdilim\MoneyToWords\Converter;
use TNkemdilim\MoneyToWords\Languages as Language;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;

class HopDong extends Component
{
    use WithFileUploads;

    public $shd,$loaihopdong, $soTDG, $soTDGTam, $search, $canhan_tatca, $danhSachSaleAdmin, $trangThaiTimKiem, $tenKHTimKiem;

    public $soTDGsoTTDH;

    protected $search_result;

    public $ngaylaphd;

    public $bena,$daidienbena;

    public $check_ma_so_thue_ben_b, $check_tai_khoan_ngan_hang_ben_b, $check_sdt_ben_b, $check_fax_ben_b, $check_dai_dien_ben_b, $check_uyquyen_ben_b;
    public $benb,$diachibenb,$masothuebenb,$taikhoansobenb,$diachitaikhoansobenb,$sdtbenb,$faxbenb,$daidienbenb,$chucvudaidienbenb,$uyquyendaidienbenb,$makhachhangbenb;

    public $chatluong, $vat;
    public $thoigianthanhtoan;
    public $phuongthucthanhtoan;
    public $diadiemgiaohang,$diachi_diadiemgiaohang, $diachi_diadiemgiaohang_ta;
    public $thoigiangiaohang;
    public $phuongthucgiaohang;
    public $phivanchuyen;
    public $giaohangtungphan;

    public $soLuong_1_10;

    public $quycach1, $soluong1, $dongia1;
    public $quycach2, $soluong2, $dongia2;
    public $quycach3, $soluong3, $dongia3;
    public $quycach4, $soluong4, $dongia4;
    public $quycach5, $soluong5, $dongia5;
    public $quycach6, $soluong6, $dongia6;
    public $quycach7, $soluong7, $dongia7;
    public $quycach8, $soluong8, $dongia8;
    public $quycach9, $soluong9, $dongia9;
    public $quycach10, $soluong10, $dongia10;
    public $quycach11, $soluong11, $dongia11;
    public $quycach12, $soluong12, $dongia12;
    public $quycach13, $soluong13, $dongia13;
    public $quycach14, $soluong14, $dongia14;
    public $quycach15, $soluong15, $dongia15;
    public $soluongbanin;

    public $formSubmit;

    public $benb_ta, $diachibenb_ta, $taikhoansobenb_ta;
    public $chatluong_ta,$thoigianthanhtoan_ta, $phuongthucthanhtoan_ta, $diadiemgiaohang_ta, $phuongthucgiaohang_ta, $phivanchuyen_ta;

    public $tygia,$cpt,$po;

    public $trungchuyen, $loadingport, $dischargport; 

    public $paginate;

    public $inputs = [], $i = 0;

    public $wk, $container, $quantity, $unitPrice, $amount;

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public $danhsachbena, $danhsachbenb, $danhsachdaidienbena;

    public $filescan, $fileroot, $filehdcosan, $filephuluc, $filetdg, $sohd_chitiethopdong;

    public $tuNgay, $denNgay, $donggoi, $donggoi_ta, $listdonggoi, $donggoikhac, $donggoikhac_ta, $listphuongthucgiaohang, $phuongthucgiaohangkhac, $phuongthucgiaohangkhac_ta;

    public $cbBenNhan, $benNhanTA, $benNhanTV, $diaChiBenNhan, $sdtBenNhan, $daiDienBenNhan, $chucVuDaiDienBenNhan;

    public $reject;

    public $userTimKiem, $soHDTimKiem, $loaiHDTimKiem, $state;

    public $soAnnex, $benNhan1, $diaChiBenNhan1, $daiDienBenNhan1, $benNhan2, $diaChiBenNhan2, $daiDienBenNhan2;

    public function mount()
    {
        $this->tuNgay = Carbon::now()->subDays(30)->isoFormat('YYYY-MM-DD');

        $this->denNgay = Carbon::now()->isoFormat('YYYY-MM-DD');

        $this->ngaylaphd = Carbon::now()->toDateString();

        $this->thoigiangiaohang = Carbon::now()->toDateString();

        $this->bena = '1';

        $this->daidienbena = '1';

        $this->paginate = 15;

        $this->danhsachbena = BenA::all();

        $this->danhsachbenb = BenB::all();

        $this->danhsachdaidienbena = DaiDienBenA::where('ben_a_id', $this->bena)->get();

        $user = User::where('username', Auth::user()->username)->first();

        $this->canhan_tatca = 'doiduyet';

        $this->trangThaiTimKiem = 'TatCa';

        $this->listdonggoi = DongGoi::all();
        $this->listphuongthucgiaohang = PhuongThucGiaoHang::all();
        $this->formSubmit = '';

        $this->soTDGsoTTDH = 'soTDGRadio';

        $this->soLuong_1_10 = '10';

        $this->cbBenNhan = '';

        $this->state = 'main';

        if(Auth::user()->hasPermissionTo('create_contracts')){

            $this->userTimKiem = Auth::user()->username;
            $this->canhan_tatca = 'tatca';

        }

        if(Auth::user()->hasPermissionTo('approve_contracts')){

            $this->userTimKiem = '';
            $this->canhan_tatca = 'tatca';

        }

    }

    public function resetInputField(){

        $this->loaihopdong = '';
        $this->ngaylaphd = Carbon::now()->toDateString();

        $this->soTDG = '';
        $this->soTDGTam = '';

        $this->bena = '1';
        $this->daidienbena = '1';

        $this->benb = '';
        $this->diachibenb = '';
        $this->masothuebenb = '';
        $this->taikhoansobenb = '';
        $this->diachitaikhoansobenb = '';
        $this->sdtbenb = '';
        $this->faxbenb = '';
        $this->daidienbenb = '';
        $this->chucvudaidienbenb = '';
        $this->uyquyendaidienbenb = '';
        $this->makhachhangbenb = '';

        $this->check_ma_so_thue_ben_b = 0;
        $this->check_tai_khoan_ngan_hang_ben_b = 0;
        $this->check_sdt_ben_b = 0;
        $this->check_fax_ben_b = 0;
        $this->check_dai_dien_ben_b = 0;
        $this->check_uyquyen_ben_b = 0;

        $this->chatluong = '';
        $this->vat = '';
        $this->thoigianthanhtoan = '';
        $this->phuongthucthanhtoan = '';
        $this->diadiemgiaohang = '';
        $this->diachi_diadiemgiaohang = '';
        $this->diachi_diadiemgiaohang_ta = '';
        $this->thoigiangiaohang = Carbon::now()->toDateString();
        $this->phuongthucgiaohang = '';
        $this->phivanchuyen = '';
        $this->giaohangtungphan = '';
        $this->soluongbanin = '';

        $this->benb_ta = '';
        $this->chatluong_ta = '';
        $this->diachibenb_ta = '';
        $this->taikhoansobenb_ta = '';
        // $this->daidienbenb_ta = '';
        // $this->chucvudaidienbenb_ta = '';
        $this->thoigianthanhtoan_ta = '';
        $this->phuongthucthanhtoan_ta = '';
        $this->diadiemgiaohang_ta = '';
        $this->phuongthucgiaohang_ta = '';
        $this->phivanchuyen_ta = '';

        $this->cpt = '';
        $this->po = '';
        $this->tygia = '';

        $this->trungchuyen = '';
        $this->loadingport = '';
        $this->dischargport = '';

        for ($i=1; $i < 16 ; $i++) { 
            $this->{'quycach'.$i} = ''; $this->{'soluong'.$i} = ''; $this->{'dongia'.$i} = ''; 
        }

        $this->filescan = '';
        $this->fileroot = ''; 
        $this->filehdcosan = ''; 
        $this->filephuluc = ''; 
        $this->sohd_chitiethopdong = '';
        $this->formSubmit = '';

        $this->reject = '';

        $this->phuongthucgiaohangkhac_ta = '';
        $this->phuongthucgiaohangkhac = '';

        $this->donggoi = '';
        $this->donggoi_ta = '';
        $this->donggoikhac = '';
        $this->donggoikhac_ta = '';

        $this->inputs = [];
        $this->i = 0;

        $this->cbBenNhan = '';
        $this->benNhanTA = '';
        $this->benNhanTV = '';
        $this->diaChiBenNhan = '';
        $this->sdtBenNhan = '';
        $this->daiDienBenNhan = '';
        $this->chucVuDaiDienBenNhan = '';

        $this->soAnnex = '';
        $this->benNhan1 = '';
        $this->diaChiBenNhan1 = '';
        $this->daiDienBenNhan1 = '';
        $this->benNhan2 = '';
        $this->diaChiBenNhan2 = '';
        $this->daiDienBenNhan2 = '';
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

    #region Hợp đồng NDTV

    public function storeFileHopDongNoiDiaTiengViet(){

        $ngaylaphd = Carbon::create($this->ngaylaphd);

        $templateProcessor = new TemplateProcessor(public_path('HD/HDMB-NDTV.docx'));

        $values = [

            'sohd' => substr($this->shd,4,5) . '/HĐMB-' . substr($this->shd,0,4),
            'ngay' => 'Hôm nay, ngày '. $ngaylaphd->format('d') .' tháng '. $ngaylaphd->format('m') .' năm '. $ngaylaphd->format('Y'),

        ];

        // Lấy thông tin bên A

        $bena = BenA::where('id', $this->bena)->get();
        $daidienbena = DaiDienBenA::where('id', $this->daidienbena)->get();

        $values = array_merge($values,[

            'ben_a' => $bena[0]->ten_tv,
            'dia_chi_ben_a' => $bena[0]->dia_chi_tv,
            'ma_so_thue_ben_a' => $bena[0]->ma_so_thue_tv,
            'sdt_ben_a' => $bena[0]->dien_thoai_tv,
            'fax_ben_a' => $bena[0]->fax_tv,
            'dai_dien_ben_a' => $daidienbena[0]->dai_dien_tv,
            'chuc_vu_dai_dien_ben_a' => $daidienbena[0]->chuc_vu_tv,
            'uy_quyen_ben_a' => '(Giấy ủy quyền : số ' . $daidienbena[0]->uy_quyen_tv . ')',

        ]);

        // Lấy thông tin bên B

        $values = array_merge($values,[

            'ben_b' => str_replace("&", "&amp;",$this->benb),
            'dia_chi_ben_b' => str_replace("&", "&amp;",$this->diachibenb),

        ]);

        // Kiểm tra check mã số thuế

        if($this->check_ma_so_thue_ben_b == 1){

            $templateProcessor->cloneBlock('block_mst_ben_b', 1, true, true);

            $values = array_merge($values,[

                'ma_so_thue_ben_b#1' => $this->masothuebenb,
    
            ]);

        }else{

            $templateProcessor->deleteBlock('block_mst_ben_b');

        }

        // Kiểm tra check tài khoản ngân hàng

        if($this->check_tai_khoan_ngan_hang_ben_b == 1){

            $templateProcessor->cloneBlock('block_so_tai_khoan_ben_b', 1, true, true);

            $values = array_merge($values,[

                'so_tai_khoan_ben_b#1' => $this->taikhoansobenb,
    
            ]);

        }else{

            $templateProcessor->deleteBlock('block_so_tai_khoan_ben_b');

        }

        // Kiểm tra check sdt, fax

        if($this->check_sdt_ben_b == 1 && $this->check_fax_ben_b == 1 && $this->sdtbenb != '' && $this->faxbenb != ''){

            $templateProcessor->cloneBlock('block_sdt_ben_b', 1, true, true);

            $values = array_merge($values,[

                'sdt_ben_b#1' => "Điện thoại\t\t\t\t\t\t\t: " . $this->sdtbenb . "\t\t\t\t\t\t\t\t\t" . "Fax : " . $this->faxbenb,
    
            ]);

        }elseif($this->check_sdt_ben_b == 1 && $this->sdtbenb != '' && $this->check_fax_ben_b == 0){

            $templateProcessor->cloneBlock('block_sdt_ben_b', 1, true, true);

            $values = array_merge($values,[

                'sdt_ben_b#1' => "Điện thoại\t\t\t\t\t\t\t: " . $this->sdtbenb,
    
            ]);

        }elseif($this->check_sdt_ben_b == 0 && $this->check_fax_ben_b == 1 && $this->faxbenb != ''){

            $templateProcessor->cloneBlock('block_sdt_ben_b', 1, true, true);

            $values = array_merge($values,[

                'sdt_ben_b#1' => "Fax\t\t\t\t\t\t\t: " . $this->faxbenb,
    
            ]);

        }else{

            $templateProcessor->deleteBlock('block_sdt_ben_b');

        }

        $values = array_merge($values, [

            'dai_dien_ben_b' => $this->daidienbenb,
            'chuc_vu_dai_dien_ben_b' => $this->chucvudaidienbenb,

        ]);

        // kiểm tra đại diện bên b

        if($this->check_dai_dien_ben_b == 1 && $this->daidienbenb != '' && $this->chucvudaidienbenb != ''){

            $templateProcessor->cloneBlock('block_dai_dien_ben_b', 1, true, true);

            $values = array_merge($values,[

                'dai_dien_ben_b#1' => "Đại diện \t\t\t: " . $this->daidienbenb . "\t\t\t\t\t\t\t\t Chức vụ : " . $this->chucvudaidienbenb,
    
            ]);

        }else{

            if($this->benb == 'CTY TNHH MTV DỆT VẢI VINATEX QUỐC TẾ'){

                $templateProcessor->cloneBlock('block_dai_dien_ben_b', 1, true, true);

                $values = array_merge($values,[

                    'dai_dien_ben_b#1' => "Đại diện \t\t\t: " . $this->daidienbenb . "\t\t\t\t\t\t\t\t Chức vụ : " . $this->chucvudaidienbenb,
        
                ]);

            }
            else
            $templateProcessor->deleteBlock('block_dai_dien_ben_b');

        }

        // Kiểm tra check uy quyền

        if($this->check_uyquyen_ben_b == 1 && $this->uyquyendaidienbenb != ''){

            $templateProcessor->cloneBlock('block_uy_quyen_ben_b', 1, true, true);

            $values = array_merge($values,[

                'uy_quyen_ben_b#1' => '(Giấy ủy quyền : số ' . $this->uyquyendaidienbenb . ')',
    
            ]);

        }else{

            $templateProcessor->deleteBlock('block_uy_quyen_ben_b');

        }

        $sanpham = SanPham::where('sohd', $this->shd)->get();

        $sanpham->transform(function ($item) {

            $item['sumthanhtien'] = $item['soluong1'] * $item['dongia1'] + $item['soluong2'] * $item['dongia2']+ $item['soluong3'] * $item['dongia3']+ $item['soluong4'] * $item['dongia4']
            + $item['soluong5'] * $item['dongia5']+ $item['soluong6'] * $item['dongia6']+ $item['soluong7'] * $item['dongia7']+ $item['soluong8'] * $item['dongia8']+ $item['soluong9'] * $item['dongia9']
            + $item['soluong10'] * $item['dongia10']+ $item['soluong11'] * $item['dongia11']+ $item['soluong12'] * $item['dongia12']+ $item['soluong13'] * $item['dongia13']+ $item['soluong14'] * $item['dongia14']
            + $item['soluong15'] * $item['dongia15'];

            $item['sumsoluong'] = $item['soluong1'] + $item['soluong2'] + $item['soluong3'] + $item['soluong4'] + $item['soluong5'] + $item['soluong6'] + $item['soluong7'] + 
            $item['soluong8'] + $item['soluong9'] + $item['soluong10'] + $item['soluong11'] + $item['soluong12'] + $item['soluong13'] + $item['soluong14'] + $item['soluong15'];

            return $item;
        });

        $sanpham->all();

        $stt = 0;

        $san_pham_values = [];

        for ($i=1; $i <16 ; $i++) { 

            if($sanpham[0]->{'quycach' . $i} != '' && $sanpham[0]->{'soluong' . $i} != '' && $sanpham[0]->{'dongia' . $i} != ''){

                $san_pham_values = array_merge($san_pham_values,[

                    [
                        'san_pham_stt' => $stt = $stt + 1,
                        'san_pham_quy_cach' => str_replace("\n", "<w:br/>", $sanpham[0]->{'quycach' . $i}),
                        'san_pham_so_luong' => number_format($sanpham[0]->{'soluong' . $i},2),
                        'san_pham_don_gia' => number_format($sanpham[0]->{'dongia' . $i}),
                        'san_pham_thanh_tien' => number_format($sanpham[0]->{'soluong' . $i} * $sanpham[0]->{'dongia' . $i}),
                    ],

                ]);

            }
        }

        $tongcong = round($sanpham[0]->sumthanhtien + ($sanpham[0]->sumthanhtien * ($this->vat / 100)));

        $converter = new Converter("đồng chẵn", "",Language::VIETNAMESE);

        $sotaikhoan = TaiKhoanNganHang::where('cong_ty_chi_nhanh' , $this->bena)
                                        ->where('noi_dia_xuat_khau', 'nd')
                                        ->first();

        $hethanhopdong = Carbon::create($this->thoigiangiaohang)->addDay(30);

        $thoigiangiaohang = Carbon::create($this->thoigiangiaohang);

        $values = array_merge($values, [

            '%vat' => $this->vat,
            'vat' => number_format($sanpham[0]->sumthanhtien * ($this->vat / 100)),
            'tong_cong' => number_format($sanpham[0]->sumsoluong,2),
            'thanh_tien' => number_format($tongcong),
            'thanh_tien_bang_chu' => ucfirst(str_replace(' chỉ một','',$converter->convert($tongcong))),

            'chat_luong' => str_replace("\n", "<w:br/>", $this->chatluong),
            'thoi_han_thanh_toan' => $this->thoigianthanhtoan,
            'phuong_thuc_thanh_toan' => $this->phuongthucthanhtoan,
            'so_tai_khoan' => $sotaikhoan->so_tai_khoan_tv,
            'chu_tai_khoan' => $sotaikhoan->chu_tai_khoan_tv,

            'dia_diem_giao_hang' => str_replace("&", "&amp;",$this->diadiemgiaohang),
            'thoi_gian_giao_hang' => "Trước ngày " . $thoigiangiaohang->format('d') . " tháng " . $thoigiangiaohang->format('m') . " năm " . $thoigiangiaohang->format('Y') . ".",
            'phi_van_chuyen' => $this->phivanchuyen,
            'thoi_gian_giao_hang_30_ngay' => $hethanhopdong->format('d') . " tháng " . $hethanhopdong->format('m') . " năm " . $hethanhopdong->format('Y'),

            'tong_ban_in' => str_pad($this->soluongbanin, 2, '0', STR_PAD_LEFT),
            'ban_in_ben_a' => str_pad($this->soluongbanin / 2, 2, '0', STR_PAD_LEFT),
            'ban_in_ben_b' => str_pad($this->soluongbanin / 2, 2, '0', STR_PAD_LEFT),

        ]);

        if($this->donggoi == 'Khác'){

            $values = array_merge($values,['dong_goi' => $this->donggoikhac]);

        }else{

            $values = array_merge($values,['dong_goi' => $this->donggoi]);

        }

        if($this->phuongthucgiaohang == 'Khác'){

            $values = array_merge($values,['phuong_thuc_giao_hang' => $this->phuongthucgiaohangkhac]);

        }else{

            $values = array_merge($values,['phuong_thuc_giao_hang' => $this->phuongthucgiaohang]);

        }


        if($this->diachi_diadiemgiaohang != ''){

            $templateProcessor->cloneBlock('block_dia_chi_dia_diem_giao_hang', 1, true, true);

            $values = array_merge($values,[

                'dia_chi_dia_diem_giao_hang#1' => $this->diachi_diadiemgiaohang,
    
            ]);

        }else{

            $templateProcessor->deleteBlock('block_dia_chi_dia_diem_giao_hang');

        }

        $templateProcessor->setValues($values);

        $templateProcessor->cloneRowAndSetValues('san_pham_stt', $san_pham_values);

        $templateProcessor->saveAs(storage_path('app/public/HD/') . $this->shd . '/' . $this->shd .'.docx');

    }

    public function createHopDongNoiDiaTiengViet(){

        $this->formSubmit = 'storeHopDongNoiDiaTiengViet';
        $this->loaihopdong = '1';

    }

    public function storeHopDongNoiDiaTiengViet(){

        // $laySoTDG = ModelsHopDong::where('so_tdg', $this->soTDG)->first();

        // if($laySoTDG != null){

        //     sweetalert()->addFlash('error', 'Số TDG/TTĐH đã được sử dụng','Thông báo');
        //     return;

        // }

        $TDG = DB::table('phieu_tdg')
        ->where('so_phieu', $this->soTDG)
        ->get();

        if($TDG->isEmpty()){

            $TTDH = DB::table('phieu_ttdh')
            ->where('so_phieu', $this->soTDG)
            ->get();

            if($TTDH->isEmpty()){

                sweetalert()->addFlash('error', 'Số TDG/TTĐH không tồn tại','Thông báo');
                return;

            }

        }

        $this->shd = IdGenerator::generate(['table' => 'hop_dong', 'field' => 'sohd', 'length' => '9', 'prefix' => Carbon::now()->format('Y'),'reset_on_prefix_change' => true]);

        if($this->makhachhangbenb == ''){

            flash()->addFlash('error', 'Không tìm thấy khách hàng này','Thông báo');

        }else{

            DB::transaction( function(){

                $ben_a = BenA::where('id' , $this->bena)->first();
    
                $sotaikhoan = TaiKhoanNganHang::where('cong_ty_chi_nhanh' , $this->bena)
                                                ->where('noi_dia_xuat_khau', 'nd')
                                                ->first();
    
                $ben_a_hop_dong = BenAHopDong::create([
    
                    'sohd' => $this->shd,
                    'ma_cong_ty' => $this->bena,
                    'ten_tv' => $ben_a->ten_tv,
                    'dia_chi_tv' => $ben_a->dia_chi_tv,
                    'ma_so_thue_tv' => $ben_a->ma_so_thue_tv,
                    'dien_thoai_tv' => $ben_a->dien_thoai_tv,
                    'fax_tv' => $ben_a->fax_tv,
    
                ]);

                BenB::where('ma_khach_hang', $this->makhachhangbenb)->update([
    
                    'dia_chi_tv' => $this->diachibenb,
                    'ma_so_thue_tv' => $this->masothuebenb,
                    'tai_khoan_ngan_hang_tv' => $this->taikhoansobenb,
                    'dien_thoai_tv' => $this->sdtbenb,
                    'fax_tv' => $this->faxbenb,
                    'dai_dien_tv' => $this->daidienbenb,
                    'chuc_vu_tv' => $this->chucvudaidienbenb,
                    'giay_uy_quyen_tv' => $this->uyquyendaidienbenb,
    
                ]);

                $ben_b_hop_dong = BenBHopDong::create([
    
                    'sohd' => $this->shd,
                    'ma_khach_hang' => $this->makhachhangbenb,
    
                    'ten_tv' => $this->benb,
                    'dia_chi_tv' => $this->diachibenb,
                    'ma_so_thue_tv' => $this->masothuebenb,
                    'tai_khoan_ngan_hang_tv' => $this->taikhoansobenb,
                    'dien_thoai_tv' => $this->sdtbenb,
                    'fax_tv' => $this->faxbenb,
                    'dai_dien_tv' => $this->daidienbenb,
                    'chuc_vu_tv' => $this->chucvudaidienbenb,
                    'giay_uy_quyen_tv' => $this->uyquyendaidienbenb,

                    
                    'check_ma_so_thue' => $this->check_ma_so_thue_ben_b,
                    'check_tai_khoan_ngan_hang' => $this->check_tai_khoan_ngan_hang_ben_b,
                    'check_dien_thoai' => $this->check_sdt_ben_b,
                    'check_fax' => $this->check_fax_ben_b,
                    'check_dai_dien' => $this->check_dai_dien_ben_b,
                    'check_giay_uy_quyen' => $this->check_uyquyen_ben_b,
                    
                ]);

                $dai_dien_ben_a = DaiDienBenA::where('id', $this->daidienbena)->first();

                $dai_dien_ben_a_hop_dong = DaiDienBenAHopDong::create([

                    'sohd' => $this->shd,
                    'dai_dien_id' => $this->daidienbena,
                    'ben_a_id' => $this->bena,
                    'dai_dien_tv' => $dai_dien_ben_a->dai_dien_tv,
                    'chuc_vu_tv'=> $dai_dien_ben_a->chuc_vu_tv,
                    'uy_quyen_tv'=> $dai_dien_ben_a->uy_quyen_tv,

                ]);

                $arr_hopdong = [

                    'sohd' => $this->shd,
                    'loaihopdong' => '1',
                    'so_tdg' => $this->soTDG,
                    
                    'ngaylaphd' => $this->ngaylaphd,
                    'ngayhethanhd' => Carbon::create($this->ngaylaphd)->addDays(30)->format('Y-m-d'),

                    'bena' => $ben_a_hop_dong->id,
                    'dai_dien_ben_a' => $dai_dien_ben_a_hop_dong->id,
                    'benb' => $ben_b_hop_dong->id,
    
                    'sotaikhoan' => $sotaikhoan->so_tai_khoan_tv,
                    'chutaikhoan' => $sotaikhoan->chu_tai_khoan_tv,

                    'vat' => $this->vat,
                    'chatluong' => $this->chatluong,
                    'thoigianthanhtoan' => $this->thoigianthanhtoan,

                    'phuongthucthanhtoan' => $this->phuongthucthanhtoan,
                    'diadiemgiaohang' => $this->diadiemgiaohang,
                    'diachi_diadiemgiaohang' => $this->diachi_diadiemgiaohang,
                    'thoigiangiaohang' => $this->thoigiangiaohang,
                    'giaohangtungphan' => $this->giaohangtungphan,
                    'phivanchuyen' => $this->phivanchuyen,

                    'soluongbanin' => $this->soluongbanin,
                    'tinhtrang' => 'New',
                    'username' => Auth::user()->username,

                ];

                if($this->donggoikhac != ''){

                    $arr_hopdong = array_merge($arr_hopdong,[ 'donggoi' => $this->donggoikhac ]);

                }else{

                    $arr_hopdong = array_merge($arr_hopdong,[ 'donggoi' => $this->donggoi ]);

                }

                if($this->phuongthucgiaohangkhac != ''){

                    $arr_hopdong = array_merge($arr_hopdong,[ 'phuongthucgiaohang' => $this->phuongthucgiaohangkhac ]);

                }else{

                    $arr_hopdong = array_merge($arr_hopdong,[ 'phuongthucgiaohang' => $this->phuongthucgiaohang ]);

                }
    
                ModelsHopDong::create($arr_hopdong);

                $arr_hopdong = array_merge($arr_hopdong,[ 'trangthai' => 'Tạo' ]);
    
                HopDongLog::create($arr_hopdong);
    
                $sanpham = [
                    'sohd' => $this->shd,
    
                    'quycach1' => $this->quycach1,
                    'soluong1' => $this->soluong1,
                    'dongia1' => $this->dongia1
                ];
    
                for ($i = 2; $i < 16 ; $i++) { 
    
                    if($this->{'quycach'.$i} != '' && $this->{'soluong'.$i} && $this->{'dongia'.$i}){
    
                        $temp = [
                            'quycach' . $i => $this->{'quycach'.$i},
                            'soluong' . $i => $this->{'soluong'.$i},
                            'dongia' . $i => $this->{'dongia'.$i}
                        ];
        
                        $sanpham = array_merge($sanpham,$temp);
        
                        $temp = [];
    
                    }
                    
                }
    
                SanPham::create(array_merge($sanpham,['username' => Auth::user()->username]));
    
                $sanphamlog = array_merge($sanpham,['trangthai' => 'Tạo','username' => Auth::user()->username]);
    
                SanPhamLog::create($sanphamlog);

            });

            Storage::disk('public')->makeDirectory('HD/' . $this->shd);

            $this->storeFileHopDongNoiDiaTiengViet();

            $taiKhoanDuyetCap1 = User::permission('approve_1_contracts')->first();

            Mail::to($taiKhoanDuyetCap1->email)->later(now()->addMinutes(1), new MailHopDong('created', '1', $this->shd , Auth::user()->username, Carbon::now(), ''));

            flash()->addFlash('success', 'Tạo thành công HĐ : ' . substr($this->shd,4,5) . '/HĐMB-' . substr($this->shd,0,4),'Thông báo');
            $this->resetInputField();
            $this->emit('storeHDNDTV');

        }
    }

    public function editHopDongNoiDiaTiengViet($sohd){

        $this->formSubmit = 'updateHopDongNoiDiaTiengViet';

        $this->loaihopdong = '1';

        $hd = ModelsHopDong::where('sohd', $sohd)->first();

        $ben_a_hop_dong = BenAHopDong::where('id', $hd->bena)->first();

        $this->shd = $sohd;
        $this->ngaylaphd = $hd->ngaylaphd;

        $this->soTDG = $hd->so_tdg;
        
        $this->soTDGTam = $hd->so_tdg;
        

        $this->bena = $ben_a_hop_dong->ma_cong_ty;

        $dai_dien_ben_a_hop_dong = DaiDienBenAHopDong::where('id' , $hd->dai_dien_ben_a)->first();
        $this->daidienbena = $dai_dien_ben_a_hop_dong->dai_dien_id;

        $selectDongGoi = DongGoi::where('donggoi', $hd->donggoi)->get();
        $selectPTGH = PhuongThucGiaoHang::where('phuongthucgiaohang', $hd->phuongthucgiaohang)->get();

        if($selectDongGoi->count() == 0){

            $this->donggoi = 'Khác';
            $this->donggoikhac = $hd->donggoi;

        }else{

            $this->donggoi = $hd->donggoi;
            $this->donggoikhac = '';

        }

        if($selectPTGH->count() == 0){

            $this->phuongthucgiaohang = 'Khác';
            $this->phuongthucgiaohangkhac = $hd->phuongthucgiaohang;

        }else{

            $this->phuongthucgiaohang = $hd->phuongthucgiaohang;
            $this->phuongthucgiaohangkhac = '';

        }

        $ben_b_hop_dong = BenBHopDong::where('id', $hd->benb)->first();

        $this->makhachhangbenb = $ben_b_hop_dong->ma_khach_hang;
        $this->benb = $ben_b_hop_dong->ten_tv;
        $this->diachibenb = $ben_b_hop_dong->dia_chi_tv;
        $this->masothuebenb = $ben_b_hop_dong->ma_so_thue_tv;
        $this->taikhoansobenb = $ben_b_hop_dong->tai_khoan_ngan_hang_tv;
        $this->sdtbenb = $ben_b_hop_dong->dien_thoai_tv;
        $this->faxbenb = $ben_b_hop_dong->fax_tv;
        $this->daidienbenb = $ben_b_hop_dong->dai_dien_tv;
        $this->chucvudaidienbenb = $ben_b_hop_dong->chuc_vu_tv;
        $this->uyquyendaidienbenb = $ben_b_hop_dong->giay_uy_quyen_tv;

        $this->check_ma_so_thue_ben_b = $ben_b_hop_dong->check_ma_so_thue;
        $this->check_tai_khoan_ngan_hang_ben_b = $ben_b_hop_dong->check_tai_khoan_ngan_hang;
        $this->check_sdt_ben_b = $ben_b_hop_dong->check_dien_thoai;
        $this->check_fax_ben_b = $ben_b_hop_dong->check_fax;
        $this->check_dai_dien_ben_b = $ben_b_hop_dong->check_dai_dien;
        $this->check_uyquyen_ben_b = $ben_b_hop_dong->check_giay_uy_quyen;

        $this->vat = $hd->vat;
        $this->chatluong = $hd->chatluong;
        $this->thoigianthanhtoan = $hd->thoigianthanhtoan;
        $this->phuongthucthanhtoan = $hd->phuongthucthanhtoan;
        $this->diadiemgiaohang = $hd->diadiemgiaohang;
        $this->diachi_diadiemgiaohang = $hd->diachi_diadiemgiaohang;
        $this->thoigiangiaohang = $hd->thoigiangiaohang;
        $this->phivanchuyen = $hd->phivanchuyen;

        $this->giaohangtungphan = $hd->giaohangtungphan;

        $this->soluongbanin = $hd->soluongbanin;

        $sanpham = SanPham::where('sohd', $this->shd)->get();

        for ($i=1; $i <16 ; $i++) { 
            
            $this->{'quycach'.$i} = $sanpham[0]->{'quycach'.$i};
            $this->{'soluong'.$i} = $sanpham[0]->{'soluong'.$i};
            $this->{'dongia'.$i} = $sanpham[0]->{'dongia'.$i};

        }

    }

    public function updateHopDongNoiDiaTiengViet(){

        if($this->shd){

            if($this->makhachhangbenb == ''){

                flash()->addFlash('error', 'Không tìm thấy khách hàng này','Thông báo');
    
            }else{

                if($this->soTDGTam != $this->soTDG){

                    $laySoTDG = ModelsHopDong::where('so_tdg', $this->soTDG)->first();
        
                    if($laySoTDG != null){
        
                        flash()->addFlash('error', 'Số TDG/TTĐH đã được sử dụng','Thông báo');
                        return;
        
                    }
        
                    $TDG = DB::table('phieu_tdg')
                    ->where('so_phieu', $this->soTDG)
                    ->get();
        
                    if($TDG->isEmpty()){
        
                        $TTDH = DB::table('phieu_ttdh')
                        ->where('so_phieu', $this->soTDG)
                        ->get();
        
                        if($TTDH->isEmpty()){
        
                            sweetalert()->addFlash('error', 'Số TDG/TTĐH không tồn tại','Thông báo');
                            return;
        
                        }
        
                    }
        
                }

                DB::transaction( function(){

                    // if($this->soTDGsoTTDH == 'soTDGRadio'){

                    //     $TDGorTTDH = 'DataFile-';
    
                    // }else{
    
                    //     $TDGorTTDH = 'TTDH-';
    
                    // }

                    $ben_a = BenA::where('id' , $this->bena)->first();
    
                    $sotaikhoan = TaiKhoanNganHang::where('cong_ty_chi_nhanh' , $this->bena)
                                                    ->where('noi_dia_xuat_khau', 'nd')
                                                    ->first();
        
                    $ben_a_hop_dong = BenAHopDong::create([
        
                        'sohd' => $this->shd,
                        'ma_cong_ty' => $this->bena,
                        'ten_tv' => $ben_a->ten_tv,
                        'dia_chi_tv' => $ben_a->dia_chi_tv,
                        'ma_so_thue_tv' => $ben_a->ma_so_thue_tv,
                        'dien_thoai_tv' => $ben_a->dien_thoai_tv,
                        'fax_tv' => $ben_a->fax_tv,
        
                    ]);

                    BenB::where('ma_khach_hang', $this->makhachhangbenb)->update([
        
                        'dia_chi_tv' => $this->diachibenb,
                        'ma_so_thue_tv' => $this->masothuebenb,
                        'tai_khoan_ngan_hang_tv' => $this->taikhoansobenb,
                        'dien_thoai_tv' => $this->sdtbenb,
                        'fax_tv' => $this->faxbenb,
                        'dai_dien_tv' => $this->daidienbenb,
                        'chuc_vu_tv' => $this->chucvudaidienbenb,
                        'giay_uy_quyen_tv' => $this->uyquyendaidienbenb,
        
                    ]);
        
                    $ben_b_hop_dong = BenBHopDong::create([
        
                        'sohd' => $this->shd,
                        'ma_khach_hang' => $this->makhachhangbenb,
        
                        'ten_tv' => $this->benb,
                        'dia_chi_tv' => $this->diachibenb,
                        'ma_so_thue_tv' => $this->masothuebenb,
                        'tai_khoan_ngan_hang_tv' => $this->taikhoansobenb,
                        'dien_thoai_tv' => $this->sdtbenb,
                        'fax_tv' => $this->faxbenb,
                        'dai_dien_tv' => $this->daidienbenb,
                        'chuc_vu_tv' => $this->chucvudaidienbenb,
                        'giay_uy_quyen_tv' => $this->uyquyendaidienbenb,

                        'check_ma_so_thue' => $this->check_ma_so_thue_ben_b,
                        'check_tai_khoan_ngan_hang' => $this->check_tai_khoan_ngan_hang_ben_b,
                        'check_dien_thoai' => $this->check_sdt_ben_b,
                        'check_fax' => $this->check_fax_ben_b,
                        'check_dai_dien' => $this->check_dai_dien_ben_b,
                        'check_giay_uy_quyen' => $this->check_uyquyen_ben_b,
                        
                    ]);

                    $dai_dien_ben_a = DaiDienBenA::where('id', $this->daidienbena)->first();

                    $dai_dien_ben_a_hop_dong = DaiDienBenAHopDong::create([

                        'sohd' => $this->shd,
                        'dai_dien_id' => $this->daidienbena,
                        'ben_a_id' => $this->bena,
                        'dai_dien_tv' => $dai_dien_ben_a->dai_dien_tv,
                        'chuc_vu_tv'=> $dai_dien_ben_a->chuc_vu_tv,
                        'uy_quyen_tv'=> $dai_dien_ben_a->uy_quyen_tv,

                    ]);

                    $hopdong_update = ModelsHopDong::where('sohd', $this->shd)->first();
    
                    if($this->donggoikhac != ''){
    
                        $hopdong_update->donggoi = $this->donggoikhac;
    
                    }else{
    
                        $hopdong_update->donggoi = $this->donggoi;
    
                    }
    
                    if($this->phuongthucgiaohangkhac != ''){
    
                        $hopdong_update->phuongthucgiaohang = $this->phuongthucgiaohangkhac;
    
                    }else{
    
                        $hopdong_update->phuongthucgiaohang = $this->phuongthucgiaohang;
    
                    }

                    // Nếu số TDG cũ khác với số TDG nhập mới
                    if($this->soTDGTam != $this->soTDG){

                        $hopdong_update->so_tdg = $this->soTDG;
    
                    }
                    

                    $hopdong_update->ngaylaphd = $this->ngaylaphd;
                    $hopdong_update->ngayhethanhd = Carbon::create($this->ngaylaphd)->addDays(30)->format('Y-m-d');

                    $hopdong_update->bena = $ben_a_hop_dong->id;
                    $hopdong_update->dai_dien_ben_a = $dai_dien_ben_a_hop_dong->id;
                    $hopdong_update->benb = $ben_b_hop_dong->id;
    
                    $hopdong_update->sotaikhoan = $sotaikhoan->so_tai_khoan_tv;
                    $hopdong_update->chutaikhoan = $sotaikhoan->chu_tai_khoan_tv;
    
                    $hopdong_update->vat = $this->vat;
                    $hopdong_update->chatluong = $this->chatluong;
                    $hopdong_update->thoigianthanhtoan = $this->thoigianthanhtoan;
                    $hopdong_update->phuongthucthanhtoan = $this->phuongthucthanhtoan;
                    $hopdong_update->diadiemgiaohang = $this->diadiemgiaohang;
                    $hopdong_update->diachi_diadiemgiaohang = $this->diachi_diadiemgiaohang;
                    $hopdong_update->thoigiangiaohang = $this->thoigiangiaohang;
                    $hopdong_update->giaohangtungphan = $this->giaohangtungphan;
                    $hopdong_update->phivanchuyen = $this->phivanchuyen;
    
                    $hopdong_update->soluongbanin = $this->soluongbanin;
    
                    $hopdong_update->username = Auth::user()->username;

                    $hopdong_update->tinhtrang = 'New';

                    $hopdong_update->save();
    
                    HopDongLog::create([
        
                        'sohd' => $this->shd,
                        'loaihopdong' => '1',
                        'so_tdg' => $hopdong_update->so_tdg,
                        
                        'ngaylaphd' => $this->ngaylaphd,
                        'ngayhethanhd' => Carbon::create($this->ngaylaphd)->addDays(30)->format('Y-m-d'),
        
                        'bena' => $ben_a_hop_dong->id,
                        'dai_dien_ben_a' => $dai_dien_ben_a_hop_dong->id,
                        'benb' => $ben_b_hop_dong->id,
        
                        'sotaikhoan' => $sotaikhoan->so_tai_khoan_tv,
                        'chutaikhoan' => $sotaikhoan->chu_tai_khoan_tv,
        
                        'chatluong' => $hopdong_update->chatluong,
                        'donggoi' => $hopdong_update->donggoi,

                        'vat' => $this->vat,
                        'thoigianthanhtoan' => $this->thoigianthanhtoan,
                        'phuongthucthanhtoan' => $this->phuongthucthanhtoan,
                        'diadiemgiaohang' => $this->diadiemgiaohang,
                        'diachi_diadiemgiaohang' => $this->diachi_diadiemgiaohang,
                        'thoigiangiaohang' => $this->thoigiangiaohang,
                        'phuongthucgiaohang' => $hopdong_update->phuongthucgiaohang,
                        'giaohangtungphan' => $this->giaohangtungphan,
                        'phivanchuyen' => $this->phivanchuyen,
        
                        'soluongbanin' => $this->soluongbanin,

                        'tinhtrang' => $hopdong_update->tinhtrang,

                        'username_approve' => $hopdong_update->username_approve,
        
                        'username' => Auth::user()->username,
        
                        'trangthai' => 'Sửa'
        
                    ]);
    
                    $sanpham = [];
        
                    for ($i=1; $i <16 ; $i++) { 
        
                        if($this->{'quycach'.$i} != '' && $this->{'soluong'.$i} != '' && $this->{'dongia'.$i} != ''){
        
                            $temp = [
            
                                'quycach'.$i => $this->{'quycach'.$i},
                                'soluong'.$i => $this->{'soluong'.$i},
                                'dongia'.$i => $this->{'dongia'.$i},
            
                            ];
            
                            $sanpham = array_merge($sanpham, $temp);
        
                            $temp = [];
        
                        }else{
                        
                            $temp = [
            
                                'quycach'.$i => null,
                                'soluong'.$i => null,
                                'dongia'.$i => null,
            
                            ];
            
                            $sanpham = array_merge($sanpham, $temp);
        
                            $temp = [];

                        }
                        
                    }
        
                    $sanpham = array_merge($sanpham,['username' => Auth::user()->username]);
        
                    $sanphamlog = array_merge($sanpham,[

                        'sohd' => $this->shd,
                        'username' => Auth::user()->username,
                        'trangthai' => 'Sửa'

                    ]);
                    
                    SanPham::where('sohd', (string)$this->shd)->update($sanpham);
        
                    SanPhamLog::create($sanphamlog);
        
                    });

                    $this->storeFileHopDongNoiDiaTiengViet();
        
                    flash()->addFlash('success', 'Sửa thành công HĐ : ' . substr($this->shd,4,5) . '/HĐMB-' . substr($this->shd,0,4),'Thông báo');
                    $this->resetInputField();
                    $this->emit('updateHDNDTV');

            }
        }
    }

    #endregion

    #region Hợp đồng NDSN

    public function storeFileHopDongNoiDiaSongNgu(){

        // Lấy thông tin bên A

        $bena = BenA::where('id', $this->bena)->get();
        $daidienbena = DaiDienBenA::where('id', $this->daidienbena)->first();

        $ngaylaphd = Carbon::create($this->ngaylaphd);

        $sotaikhoan = TaiKhoanNganHang::where('cong_ty_chi_nhanh' , $this->bena)
                                        ->where('noi_dia_xuat_khau', 'nd')
                                        ->first();

        $templateProcessor = new TemplateProcessor(public_path('HD/HDMB-NDSN.docx'));

        $values = [

            'ten_cong_ty' => $bena[0]->ten_ta,
            'dia_chi_cong_ty' => $bena[0]->dia_chi_ta,
            'so_hop_dong' => substr($this->shd,4,5) . '/HDMB-' . substr($this->shd,0,4) . ' (' . $ngaylaphd->format('d.m.Y') . ')',

        ];

        if($bena[0]->id == '1'){

              $values = array_merge($values, [

                    'dia_diem_tieng_anh' => 'Ho Chi Minh',
                    'ngay_thang_nam_tieng_anh' => ' ' . $ngaylaphd->format('d M Y'),

                    'dia_diem_tieng_viet' => 'Hồ Chí Minh',
                    'ngay_thang_nam_tieng_viet' => 'ngày '. $ngaylaphd->format('d') .' tháng '. $ngaylaphd->format('m') .' năm '. $ngaylaphd->format('Y'),

              ]);  

        }else{

            $values = array_merge($values, [

                'dia_diem_tieng_anh' => 'Tay Ninh',
                'ngay_thang_nam_tieng_anh' => ' ' . $ngaylaphd->format('d M Y'),

                'dia_diem_tieng_viet' => 'Tây Ninh',
                'ngay_thang_nam_tieng_viet' => 'ngày '. $ngaylaphd->format('d') .' tháng '. $ngaylaphd->format('m') .' năm '. $ngaylaphd->format('Y'),

          ]);  

        }

        $values = array_merge($values, [

            'ben_a_tieng_anh' => $bena[0]->ten_ta,
            'ben_a_tieng_viet' => $bena[0]->ten_tv,

            'dia_chi_ben_a_tieng_anh' => $bena[0]->dia_chi_ta,
            'dia_chi_ben_a_tieng_viet' => $bena[0]->dia_chi_tv,

            'sdt_ben_a_tieng_anh' => $bena[0]->dien_thoai_tv, 
            'stk_ben_a_tieng_anh' => $sotaikhoan->so_tai_khoan_ta,

            'ma_so_thue' => $bena[0]->ma_so_thue_tv,
            'fax' => $bena[0]->fax_tv,

            'dai_dien_ben_a_tieng_anh' => $daidienbena->dai_dien_ta,
            'chuc_vu_dai_dien_ben_a_tieng_anh' => $daidienbena->chuc_vu_ta,
            'uy_quyen_ben_a_tieng_anh' => 'POA NO ' . $daidienbena->uy_quyen_tv,
            'uy_quyen_ben_a_tieng_viet' => $daidienbena->uy_quyen_tv,

        ]);

        // Lấy thông tin bên B

        $values = array_merge($values,[

            'ben_b_tieng_anh' => str_replace("&", "&amp;",$this->benb_ta),
            'ben_b_tieng_viet' => str_replace("&", "&amp;",$this->benb),
            'dia_chi_ben_b_tieng_anh' => $this->diachibenb_ta,
            'dia_chi_ben_b_tieng_viet' => $this->diachibenb,
            // 'dai_dien_ben_b_tieng_anh' => $this->daidienbenb,
            // 'chuc_vu_dai_dien_ben_b_tieng_anh' => $this->chucvudaidienbenb,

        ]);

        // Kiểm tra check mã số thuế

        if($this->check_ma_so_thue_ben_b == 1){

            $templateProcessor->cloneBlock('block_mst_ben_b', 1, true, true);

            $values = array_merge($values,[

                'ma_so_thue_ben_b#1' => $this->masothuebenb,
    
            ]);

        }else{

            $templateProcessor->deleteBlock('block_mst_ben_b');

        }

        // Kiểm tra check tài khoản ngân hàng

        if($this->check_tai_khoan_ngan_hang_ben_b == 1){

            $templateProcessor->cloneBlock('block_so_tai_khoan_ben_b', 1, true, true);

            $values = array_merge($values,[

                'so_tai_khoan_ben_b#1' => $this->taikhoansobenb,
    
            ]);

        }else{

            $templateProcessor->deleteBlock('block_so_tai_khoan_ben_b');

        }

        // Kiểm tra check sdt, fax

        if($this->check_sdt_ben_b == 1 && $this->check_fax_ben_b == 1 && $this->sdtbenb != '' && $this->faxbenb != ''){

            $templateProcessor->cloneBlock('block_sdt_ben_b', 1, true, true);

            $values = array_merge($values,[

                'sdt_ben_b#1' => "Điện thoại\t\t\t\t: " . $this->sdtbenb . "\t\t\t\t" . 'Fax : ' . $this->faxbenb,
    
            ]);

        }elseif($this->check_sdt_ben_b == 1 && $this->check_fax_ben_b == 0 && $this->sdtbenb != ''){

            $templateProcessor->cloneBlock('block_sdt_ben_b', 1, true, true);

            $values = array_merge($values,[

                'sdt_ben_b#1' => "Điện thoại\t\t\t\t: " . $this->sdtbenb,
    
            ]);

        }elseif($this->check_sdt_ben_b == 0 && $this->check_fax_ben_b == 1 && $this->faxbenb != ''){

            $templateProcessor->cloneBlock('block_sdt_ben_b', 1, true, true);

            $values = array_merge($values,[

                'sdt_ben_b#1' => "Fax\t\t\t\t: " . $this->faxbenb,
    
            ]);

        }else{

            $templateProcessor->deleteBlock('block_sdt_ben_b');

        }

        // kiểm tra đại diện bên b

        if($this->check_dai_dien_ben_b == 1 && $this->daidienbenb != '' && $this->chucvudaidienbenb != ''){

            $templateProcessor->cloneBlock('block_dai_dien_ben_b', 1, true, true);

            $values = array_merge($values,[

                'dai_dien_ben_b#1' => "Represented by\t\t\t: " . $this->daidienbenb . "   -  Position : " . $this->chucvudaidienbenb,
    
            ]);

        }else{

            $templateProcessor->deleteBlock('block_dai_dien_ben_b');

        }

        // kiểm tra ủy quyên bên b

        if($this->check_uyquyen_ben_b == 1 && $this->uyquyendaidienbenb != ''){

            $templateProcessor->cloneBlock('block_uy_quyen_ben_b', 1, true, true);

            $values = array_merge($values,[

                'uy_quyen_ben_b_tieng_anh#1' => 'POA NO ' . $this->uyquyendaidienbenb . '',
                'uy_quyen_ben_b_tieng_viet#1' => $this->uyquyendaidienbenb,
    
            ]);

        }else{

            $templateProcessor->deleteBlock('block_uy_quyen_ben_b');

        }

        // Kiểm tra bên nhận

        if($this->benNhanTA != ''){

            $templateProcessor->cloneBlock('block_ben_nhan', 1, true, true);

            $values = array_merge($values,[

                'ben_nhan_ta#1' => str_replace("&", "&amp;",$this->benNhanTA),
                'ben_nhan_tv#1' => str_replace("&", "&amp;",$this->benNhanTV),
                'dia_chi_ben_nhan#1' => $this->diaChiBenNhan,
    
            ]);

            if($this->sdtBenNhan != ''){

                $templateProcessor->cloneBlock('block_sdt_ben_nhan', 1, true, true);

                $values = array_merge($values,[

                    'sdt_ben_nhan#1' => $this->sdtBenNhan,
        
                ]);

            }else{

                $templateProcessor->deleteBlock('block_sdt_ben_nhan');

            }

            if($this->daiDienBenNhan != ''){

                $templateProcessor->cloneBlock('block_dai_dien_ben_nhan', 1, true, true);

                $values = array_merge($values,[

                    'dai_dien_ben_nhan#1' => "Represented by\t\t\t: " . $this->daiDienBenNhan . "   -  Position : " . $this->chucVuDaiDienBenNhan,
        
                ]);

            }else{

                $templateProcessor->deleteBlock('block_dai_dien_ben_nhan');

            }

        }else{

            $templateProcessor->deleteBlock('block_ben_nhan');

        }

        $sanpham = SanPham::where('sohd', $this->shd)->get();

        $sanpham->transform(function ($item) {

            $item['sumthanhtien'] = $item['soluong1'] * $item['dongia1'] + $item['soluong2'] * $item['dongia2']+ $item['soluong3'] * $item['dongia3']+ $item['soluong4'] * $item['dongia4']
            + $item['soluong5'] * $item['dongia5']+ $item['soluong6'] * $item['dongia6']+ $item['soluong7'] * $item['dongia7']+ $item['soluong8'] * $item['dongia8']+ $item['soluong9'] * $item['dongia9']
            + $item['soluong10'] * $item['dongia10']+ $item['soluong11'] * $item['dongia11']+ $item['soluong12'] * $item['dongia12']+ $item['soluong13'] * $item['dongia13']+ $item['soluong14'] * $item['dongia14']
            + $item['soluong15'] * $item['dongia15'];

            $item['sumsoluong'] = $item['soluong1'] + $item['soluong2'] + $item['soluong3'] + $item['soluong4'] + $item['soluong5'] + $item['soluong6'] + $item['soluong7'] + 
            $item['soluong8'] + $item['soluong9'] + $item['soluong10'] + $item['soluong11'] + $item['soluong12'] + $item['soluong13'] + $item['soluong14'] + $item['soluong15'];

            return $item;
        });

        $sanpham->all();

        $san_pham_values = [];

        for ($i=1; $i <16 ; $i++) { 

            if($sanpham[0]->{'quycach' . $i} != '' && $sanpham[0]->{'soluong' . $i} != '' && $sanpham[0]->{'dongia' . $i} != ''){

                $san_pham_values = array_merge($san_pham_values,[

                    [
                        'san_pham' => str_replace("\n", "<w:br/>", $sanpham[0]->{'quycach' . $i}),
                        'so_luong' => number_format($sanpham[0]->{'soluong' . $i},2),
                        'don_gia' => number_format($sanpham[0]->{'dongia' . $i}),
                        'thanh_tien' => number_format($sanpham[0]->{'soluong' . $i} * $sanpham[0]->{'dongia' . $i}),
                    ],

                ]);

            }
        }

        $templateProcessor->cloneBlock('block_unit_price', count($san_pham_values), true, true);

        $i = 0;

        foreach ($san_pham_values as $item) {
            
            $i = $i + 1;

            $values = array_merge($values,[

                'unit_price#' . $i => 'Unit price ' . $i . ' : $' . round((float)str_replace(',', '', $item['don_gia']) /$this->tygia,2) . '/kg',
                'don_gia#' . $i => 'Đơn giá ' . $i . ' : $' . round((float)str_replace(',', '', $item['don_gia'])/$this->tygia,2) . '/kg',

            ]);
            
        }

        $values = array_merge($values, [

            '1_10' => $this->soLuong_1_10

        ]);

        $tongcong = round($sanpham[0]->sumthanhtien + ($sanpham[0]->sumthanhtien * ($this->vat / 100)));

        $converter_tieng_anh = new Converter("", "",Language::ENGLISH);   

        $converter_tieng_viet = new Converter("đồng chẵn", "",Language::VIETNAMESE);

        $hethanhopdong = Carbon::create($this->thoigiangiaohang)->addDay(30);

        $thoigiangiaohang = Carbon::create($this->thoigiangiaohang);

        //Chất lượng khác tiếng việt
        // if($this->chatluong == 'Khác'){

        //     $values = array_merge($values,['chat_luong_tieng_viet' => $this->chatluongkhac]);

        // }else{

        //     $values = array_merge($values,['chat_luong_tieng_viet' => $this->chatluong]);

        // }

        //Chất lượng khác tiếng anh
        // if($this->chatluong_ta == 'Khác'){

        //     $values = array_merge($values,['chat_luong_tieng_anh' => $this->chatluongkhac_ta]);

        // }else{

        //     $values = array_merge($values,['chat_luong_tieng_anh' => $this->chatluong_ta]);

        // }

        //Đóng gói khác tiếng việt
        if($this->donggoi == 'Khác'){

            $values = array_merge($values,['dong_goi_tieng_viet' => $this->donggoikhac]);

        }else{

            $values = array_merge($values,['dong_goi_tieng_viet' => $this->donggoi]);

        }

        //Đóng gói khác tiếng anh
        if($this->donggoi_ta == 'Other'){

            $values = array_merge($values,['dong_goi_tieng_anh' => $this->donggoikhac_ta]);

        }else{

            $values = array_merge($values,['dong_goi_tieng_anh' => $this->donggoi_ta]);

        }

        $values = array_merge($values, [

            '%vat' => $this->vat,
            'vat' => number_format($sanpham[0]->sumthanhtien * ($this->vat / 100)),
            'total_amount' => number_format($tongcong),
            'ty_gia' => number_format($this->tygia),
            'tong_so_luong' => number_format($sanpham[0]->sumsoluong,2),
            'thanh_tien_bang_chu_tieng_anh' => ucfirst($converter_tieng_anh->convert($tongcong)),
            'thanh_tien_bang_chu_tieng_viet' => ucfirst(str_replace(' chỉ một','',$converter_tieng_viet->convert($tongcong))),
            'chat_luong_tieng_anh' => str_replace("\n", "<w:br/>", $this->chatluong_ta),
            'chat_luong_tieng_viet' => str_replace("\n", "<w:br/>", $this->chatluong),
            'dia_diem_giao_hang_tieng_anh' => str_replace("&", "&amp;",$this->diadiemgiaohang_ta),
            'dia_diem_giao_hang_tieng_viet' => $this->diadiemgiaohang,
            'thoi_gian_giao_hang_tieng_anh' => 'Before ' . $thoigiangiaohang->format('d M Y'),
            'thoi_gian_giao_hang_tieng_viet' => "Trước ngày " . $thoigiangiaohang->format('d') . " tháng " . $thoigiangiaohang->format('m') . " năm " . $thoigiangiaohang->format('Y') . ".",
            'chi_phi_van_chuyen_tieng_anh' => $this->phivanchuyen_ta,
            'chi_phi_van_chuyen_tieng_viet' => $this->phivanchuyen,
            'chu_tk_ben_a_tieng_anh' => $sotaikhoan->chu_tai_khoan_ta,
            'stk_ben_a_tieng_anh' => $sotaikhoan->so_tai_khoan_ta,
            'chu_tk_ben_a_tieng_viet' => $sotaikhoan->chu_tai_khoan_tv,
            'stk_ben_a_tieng_viet' => $sotaikhoan->so_tai_khoan_tv,
            'ngay_thang_nam_tieng_anh_2' => $hethanhopdong->format('d M Y'),
            'ngay_thang_nam_tieng_viet_2' => 'ngày '. $hethanhopdong->format('d') .' tháng '. $hethanhopdong->format('m') .' năm '. $hethanhopdong->format('Y'),
            'so_luong_ban_in' => str_pad($this->soluongbanin, 2, '0', STR_PAD_LEFT),
            'so_luong_ban_in_chia_2' => str_pad($this->soluongbanin / 2, 2, '0', STR_PAD_LEFT),
            'phuong_thuc_thanh_toan_tieng_viet' => $this->phuongthucthanhtoan,
            'phuong_thuc_thanh_toan_tieng_anh' => $this->phuongthucthanhtoan_ta

        ]);

        if($this->giaohangtungphan == '1'){

            $templateProcessor->cloneBlock('block_giao_tung_phan', 1, true, true);

            $values = array_merge($values,[

                'giao_tung_phan_tieng_anh#1' => 'Allowed',
                'giao_tung_phan_tieng_viet#1' => 'Cho phép',
    
            ]);

        }elseif($this->giaohangtungphan == '2'){

            $templateProcessor->cloneBlock('block_giao_tung_phan', 1, true, true);

            $values = array_merge($values,[

                'giao_tung_phan_tieng_anh#1' => 'Not Allowed',
                'giao_tung_phan_tieng_viet#1' => 'Không cho phép',
    
            ]);

        }else{

            $templateProcessor->deleteBlock('block_giao_tung_phan');

        }

        if($this->diachi_diadiemgiaohang != ''){

            $templateProcessor->cloneBlock('block_dia_chi_dia_diem_giao_hang', 1, true, true);

            $values = array_merge($values,[

                'dia_chi_dia_diem_giao_hang#1' => $this->diachi_diadiemgiaohang,
    
            ]);

        }else{

            $templateProcessor->deleteBlock('block_dia_chi_dia_diem_giao_hang');

        }

        if($this->diachi_diadiemgiaohang_ta != ''){

            $templateProcessor->cloneBlock('block_dia_chi_dia_diem_giao_hang_ta', 1, true, true);

            $values = array_merge($values,[

                'dia_chi_dia_diem_giao_hang_ta#1' => $this->diachi_diadiemgiaohang_ta,
    
            ]);

        }else{

            $templateProcessor->deleteBlock('block_dia_chi_dia_diem_giao_hang_ta');

        }

        $templateProcessor->setValues($values);

        $templateProcessor->cloneRowAndSetValues('san_pham', $san_pham_values);

        $templateProcessor->saveAs(storage_path('app/public/HD/'). $this->shd . '/' . $this->shd .'.docx');

    }

    public function createHopDongNoiDiaSongNgu(){

        $this->formSubmit = 'storeHopDongNoiDiaSongNgu';
        $this->loaihopdong = '2';
        $this->soLuong_1_10 = '10';

    }

    public function storeHopDongNoiDiaSongNgu(){

        // $laySoTDG = ModelsHopDong::where('so_tdg', $this->soTDG)->first();

        // if($laySoTDG != null){

        //     sweetalert()->addFlash('error', 'Số TDG/TTĐH đã được sử dụng','Thông báo');
        //     return;

        // }

        $TDG = DB::table('phieu_tdg')
        ->where('so_phieu', $this->soTDG)
        ->get();

        if($TDG->isEmpty()){

            $TTDH = DB::table('phieu_ttdh')
            ->where('so_phieu', $this->soTDG)
            ->get();

            if($TTDH->isEmpty()){

                sweetalert()->addFlash('error', 'Số TDG/TTĐH không tồn tại','Thông báo');
                return;

            }

        }

        $this->shd = IdGenerator::generate(['table' => 'hop_dong', 'field' => 'sohd', 'length' => '9', 'prefix' => Carbon::now()->format('Y'),'reset_on_prefix_change' => true]);

        if($this->makhachhangbenb == ''){

            flash()->addFlash('error', 'Không tìm thấy khách hàng này','Thông báo');

        }else{

            DB::transaction( function(){

                // if($this->soTDGsoTTDH == 'soTDGRadio'){

                //     $TDGorTTDH = 'DataFile-';

                // }else{

                //     $TDGorTTDH = 'TTDH-';

                // }

                $ben_a = BenA::where('id' , $this->bena)->first();
    
                $sotaikhoan = TaiKhoanNganHang::where('cong_ty_chi_nhanh' , $this->bena)
                                                ->where('noi_dia_xuat_khau', 'nd')
                                                ->first();
    
                $ben_a_hop_dong = BenAHopDong::create([
    
                    'sohd' => $this->shd,
                    'ma_cong_ty' => $this->bena,
                    'ten_tv' => $ben_a->ten_tv,
                    'dia_chi_tv' => $ben_a->dia_chi_tv,
                    'ma_so_thue_tv' => $ben_a->ma_so_thue_tv,
                    'dien_thoai_tv' => $ben_a->dien_thoai_tv,
                    'fax_tv' => $ben_a->fax_tv,

                    'ten_ta' => $ben_a->ten_ta,
                    'dia_chi_ta' => $ben_a->dia_chi_ta,
    
                ]);

                BenB::where('ma_khach_hang', $this->makhachhangbenb)->update([
    
                    'dia_chi_tv' => $this->diachibenb,
                    'ma_so_thue_tv' => $this->masothuebenb,
                    'tai_khoan_ngan_hang_tv' => $this->taikhoansobenb,
                    'dien_thoai_tv' => $this->sdtbenb,
                    'fax_tv' => $this->faxbenb,
                    'dai_dien_tv' => $this->daidienbenb,
                    'chuc_vu_tv' => $this->chucvudaidienbenb,
                    'giay_uy_quyen_tv' => $this->uyquyendaidienbenb,

                    'ten_ta' => $this->benb_ta,
                    'dia_chi_ta' => $this->diachibenb_ta,
                    'tai_khoan_ngan_hang_ta' => $this->taikhoansobenb_ta,
                    // 'dai_dien_ta' => $this->daidienbenb_ta,
                    // 'chuc_vu_ta' => $this->chucvudaidienbenb_ta,
    
                ]);
    
                $ben_b_hop_dong = BenBHopDong::create([
    
                    'ma_khach_hang' => $this->makhachhangbenb,
                    'sohd' => $this->shd,
    
                    'ten_tv' => $this->benb,
                    'dia_chi_tv' => $this->diachibenb,
                    'ma_so_thue_tv' => $this->masothuebenb,
                    'tai_khoan_ngan_hang_tv' => $this->taikhoansobenb,
                    'dien_thoai_tv' => $this->sdtbenb,
                    'fax_tv' => $this->faxbenb,
                    'dai_dien_tv' => $this->daidienbenb,
                    'chuc_vu_tv' => $this->chucvudaidienbenb,
                    'giay_uy_quyen_tv' => $this->uyquyendaidienbenb,

                    'ten_ta' => $this->benb_ta,
                    'dia_chi_ta' => $this->diachibenb_ta,
                    'tai_khoan_ngan_hang_ta' => $this->taikhoansobenb_ta,
                    // 'dai_dien_ta' => $this->daidienbenb_ta,
                    // 'chuc_vu_ta' => $this->chucvudaidienbenb_ta,

                    'check_ma_so_thue' => $this->check_ma_so_thue_ben_b,
                    'check_tai_khoan_ngan_hang' => $this->check_tai_khoan_ngan_hang_ben_b,
                    'check_dien_thoai' => $this->check_sdt_ben_b,
                    'check_fax' => $this->check_fax_ben_b,
                    'check_dai_dien' => $this->check_dai_dien_ben_b,
                    'check_giay_uy_quyen' => $this->check_uyquyen_ben_b,
                    
                ]);

                $dai_dien_ben_a = DaiDienBenA::where('id', $this->daidienbena)->first();

                $dai_dien_ben_a_hop_dong = DaiDienBenAHopDong::create([

                    'sohd' => $this->shd,
                    'dai_dien_id' => $this->daidienbena,
                    'ben_a_id' => $this->bena,
                    'dai_dien_tv' => $dai_dien_ben_a->dai_dien_tv,
                    'chuc_vu_tv'=> $dai_dien_ben_a->chuc_vu_tv,
                    'uy_quyen_tv'=> $dai_dien_ben_a->uy_quyen_tv,
                    'dai_dien_ta'=> $dai_dien_ben_a->dai_dien_ta,
                    'chuc_vu_ta'=> $dai_dien_ben_a->chuc_vu_ta,

                ]);

                $arr_hopdong = [

                    'sohd' => $this->shd,
                    'loaihopdong' => '2',
                    'so_tdg' => $this->soTDG,
                    
                    'ngaylaphd' => $this->ngaylaphd,
                    'ngayhethanhd' => Carbon::create($this->thoigiangiaohang)->addDays(30)->format('Y-m-d'),
    
                    'bena' => $ben_a_hop_dong->id,
                    'dai_dien_ben_a' => $dai_dien_ben_a_hop_dong->id,
                    'benb' => $ben_b_hop_dong->id,

                    'ben_nhan_ta' => $this->benNhanTA,
                    'ben_nhan_tv' => $this->benNhanTV,
                    'dia_chi_ben_nhan' => $this->diaChiBenNhan,
                    'sdt_ben_nhan' => $this->sdtBenNhan,
                    'dai_dien_ben_nhan' => $this->daiDienBenNhan,
                    'chuc_vu_ben_nhan' => $this->chucVuDaiDienBenNhan,
    
                    'sotaikhoan' => $sotaikhoan->so_tai_khoan_tv,
                    'chutaikhoan' => $sotaikhoan->chu_tai_khoan_tv,

                    'sotaikhoan_ta' => $sotaikhoan->so_tai_khoan_ta,
                    'chutaikhoan_ta' => $sotaikhoan->chu_tai_khoan_ta,
    
                    'tygia' => $this->tygia,
                    'vat' => $this->vat,

                    'chatluong' => $this->chatluong,
                    'chatluong_ta' => $this->chatluong_ta,

                    'thoigianthanhtoan' => $this->thoigianthanhtoan,
                    'thoigianthanhtoan_ta' => $this->thoigianthanhtoan_ta,

                    'phuongthucthanhtoan' => $this->phuongthucthanhtoan,
                    'phuongthucthanhtoan_ta' => $this->phuongthucthanhtoan_ta,

                    'diadiemgiaohang' => $this->diadiemgiaohang,
                    'diadiemgiaohang_ta' => $this->diadiemgiaohang_ta,

                    'diachi_diadiemgiaohang' => $this->diachi_diadiemgiaohang,
                    'diachi_diadiemgiaohang_ta' => $this->diachi_diadiemgiaohang_ta,

                    'thoigiangiaohang' => $this->thoigiangiaohang,

                    'giaohangtungphan' => $this->giaohangtungphan,

                    'phivanchuyen' => $this->phivanchuyen,
                    'phivanchuyen_ta' => $this->phivanchuyen_ta,
    
                    'soluongbanin' => $this->soluongbanin,

                    'tinhtrang' => 'New',
    
                    'username' => Auth::user()->username,

                ];

                // // Chất lượng khác
    
                // if($this->chatluongkhac != ''){

                //     $arr_hopdong = array_merge($arr_hopdong,[ 'chatluong' => $this->chatluongkhac ]);

                // }else{

                //     $arr_hopdong = array_merge($arr_hopdong,[ 'chatluong' => $this->chatluong ]);

                // }

                // // Chất lượng khác TA

                // if($this->chatluongkhac_ta != ''){

                //     $arr_hopdong = array_merge($arr_hopdong,[ 'chatluong_ta' => $this->chatluongkhac_ta ]);

                // }else{

                //     $arr_hopdong = array_merge($arr_hopdong,[ 'chatluong_ta' => $this->chatluong_ta ]);

                // }

                // Đóng gói khác

                if($this->donggoikhac != ''){

                    $arr_hopdong = array_merge($arr_hopdong,[ 'donggoi' => $this->donggoikhac ]);

                }else{

                    $arr_hopdong = array_merge($arr_hopdong,[ 'donggoi' => $this->donggoi ]);

                }

                // Đóng gói khác TA

                if($this->donggoikhac_ta != ''){

                    $arr_hopdong = array_merge($arr_hopdong,[ 'donggoi_ta' => $this->donggoikhac_ta ]);

                }else{

                    $arr_hopdong = array_merge($arr_hopdong,[ 'donggoi_ta' => $this->donggoi_ta ]);

                }

                // Phương thức giao hàng khác

                if($this->phuongthucgiaohangkhac != ''){

                    $arr_hopdong = array_merge($arr_hopdong,[ 'phuongthucgiaohang' => $this->phuongthucgiaohangkhac ]);

                }else{

                    $arr_hopdong = array_merge($arr_hopdong,[ 'phuongthucgiaohang' => $this->phuongthucgiaohang ]);

                }

                // Phương thức giao hàng khác TA

                if($this->phuongthucgiaohangkhac_ta != ''){

                    $arr_hopdong = array_merge($arr_hopdong,[ 'phuongthucgiaohang_ta' => $this->phuongthucgiaohangkhac_ta ]);

                }else{

                    $arr_hopdong = array_merge($arr_hopdong,[ 'phuongthucgiaohang_ta' => $this->phuongthucgiaohang_ta ]);

                }
    
                ModelsHopDong::create($arr_hopdong);
    
                $arr_hopdong = array_merge($arr_hopdong,[ 'trangthai' => 'Tạo' ]);
    
                HopDongLog::create($arr_hopdong);
    
                $sanpham = [
                    'sohd' => $this->shd,
    
                    'quycach1' => $this->quycach1,
                    'soluong1' => $this->soluong1,
                    'dongia1' => $this->dongia1
                ];
    
                for ($i = 2; $i < 16 ; $i++) { 
    
                    if($this->{'quycach'.$i} != '' && $this->{'soluong'.$i} && $this->{'dongia'.$i}){
    
                        $temp = [
                            'quycach' . $i => $this->{'quycach'.$i},
                            'soluong' . $i => $this->{'soluong'.$i},
                            'dongia' . $i => $this->{'dongia'.$i}
                        ];
        
                        $sanpham = array_merge($sanpham,$temp);
        
                        $temp = [];
    
                    }
                    
                }
    
                SanPham::create(array_merge($sanpham,['username' => Auth::user()->username]));
    
                $sanphamlog = array_merge($sanpham,['trangthai' => 'Tạo','username' => Auth::user()->username]);
    
                SanPhamLog::create($sanphamlog);

                

            });

            Storage::disk('public')->makeDirectory('HD/' . $this->shd);

            $this->storeFileHopDongNoiDiaSongNgu();

            $taiKhoanDuyetCap1 = User::permission('approve_1_contracts')->first();

            //Mail::to('chloehsu@century.vn')->send(new NewContractMail('2', $this->shd , Auth::user()->username, Carbon::now()));
            Mail::to($taiKhoanDuyetCap1->email)->later(now()->addMinutes(1), new MailHopDong('created', '2', $this->shd , Auth::user()->username, Carbon::now(), ''));

            flash()->addFlash('success', 'Tạo thành công HĐ : ' . substr($this->shd,4,5) . '/HĐMB-' . substr($this->shd,0,4),'Thông báo');
            $this->resetInputField();
            $this->emit('storeHDNDSN');

        }

    }

    public function editHopDongNoiDiaSongNgu($sohd){

        $this->formSubmit = 'updateHopDongNoiDiaSongNgu';

        $this->loaihopdong = '2';

        $hd = ModelsHopDong::where('sohd', $sohd)->first();

        $ben_a_hop_dong = BenAHopDong::where('id', $hd->bena)->first();

        $this->shd = $sohd;
        $this->ngaylaphd = $hd->ngaylaphd;
        $this->soTDG = $hd->so_tdg;
        
        $this->soTDGTam = $hd->so_tdg;

        $this->bena = $ben_a_hop_dong->ma_cong_ty;

        $dai_dien_ben_a_hop_dong = DaiDienBenAHopDong::where('id' , $hd->dai_dien_ben_a)->first();
        $this->daidienbena = $dai_dien_ben_a_hop_dong->dai_dien_id;

        $selectDongGoi = DongGoi::where('donggoi', $hd->donggoi)->get();
        $selectPTGH = PhuongThucGiaoHang::where('phuongthucgiaohang', $hd->phuongthucgiaohang)->get();

        $selectDongGoi_ta = DongGoi::where('donggoi_ta', $hd->donggoi_ta)->get();
        $selectPTGH_ta = PhuongThucGiaoHang::where('phuongthucgiaohang_ta', $hd->phuongthucgiaohang_ta)->get();

        //Đóng gói khác
        if($selectDongGoi->count() == 0){

            $this->donggoi = 'Khác';
            $this->donggoikhac = $hd->donggoi;

        }else{

            $this->donggoi = $hd->donggoi;
            $this->donggoikhac = '';

        }

        //Đóng gói khác TA
        if($selectDongGoi_ta->count() == 0){

            $this->donggoi_ta = 'Other';
            $this->donggoikhac_ta = $hd->donggoi_ta;

        }else{

            $this->donggoi_ta = $hd->donggoi_ta;
            $this->donggoikhac_ta = '';

        }


        // PTGH khác
        if($selectPTGH->count() == 0){

            $this->phuongthucgiaohang = 'Khác';
            $this->phuongthucgiaohangkhac = $hd->phuongthucgiaohang;

        }else{

            $this->phuongthucgiaohang = $hd->phuongthucgiaohang;
            $this->phuongthucgiaohangkhac = '';

        }

        // PTGH khác TA
        if($selectPTGH_ta->count() == 0){

            $this->phuongthucgiaohang_ta = 'Other';
            $this->phuongthucgiaohangkhac_ta = $hd->phuongthucgiaohang_ta;

        }else{

            $this->phuongthucgiaohang_ta = $hd->phuongthucgiaohang_ta;
            $this->phuongthucgiaohangkhac_ta = '';

        }

        $ben_b_hop_dong = BenBHopDong::where('id', $hd->benb)->first();

        $this->makhachhangbenb = $ben_b_hop_dong->ma_khach_hang;
        $this->benb = $ben_b_hop_dong->ten_tv;
        $this->diachibenb = $ben_b_hop_dong->dia_chi_tv;
        $this->masothuebenb = $ben_b_hop_dong->ma_so_thue_tv;
        $this->taikhoansobenb = $ben_b_hop_dong->tai_khoan_ngan_hang_tv;
        $this->sdtbenb = $ben_b_hop_dong->dien_thoai_tv;
        $this->faxbenb = $ben_b_hop_dong->fax_tv;
        $this->daidienbenb = $ben_b_hop_dong->dai_dien_tv;
        $this->chucvudaidienbenb = $ben_b_hop_dong->chuc_vu_tv;
        $this->uyquyendaidienbenb = $ben_b_hop_dong->giay_uy_quyen_tv;

        $this->check_ma_so_thue_ben_b = $ben_b_hop_dong->check_ma_so_thue;
        $this->check_tai_khoan_ngan_hang_ben_b = $ben_b_hop_dong->check_tai_khoan_ngan_hang;
        $this->check_sdt_ben_b = $ben_b_hop_dong->check_dien_thoai;
        $this->check_fax_ben_b = $ben_b_hop_dong->check_fax;
        $this->check_dai_dien_ben_b = $ben_b_hop_dong->check_dai_dien;
        $this->check_uyquyen_ben_b = $ben_b_hop_dong->check_giay_uy_quyen;

        $this->benb_ta = $ben_b_hop_dong->ten_ta;
        $this->diachibenb_ta = $ben_b_hop_dong->dia_chi_ta;
        $this->taikhoansobenb_ta = $ben_b_hop_dong->tai_khoan_ngan_hang_ta;
        // $this->daidienbenb_ta = $ben_b_hop_dong->dai_dien_ta;
        // $this->chucvudaidienbenb_ta = $ben_b_hop_dong->chuc_vu_ta;

        $this->benNhanTA = $hd->ben_nhan_ta;
        $this->benNhanTV = $hd->ben_nhan_tv;
        $this->diaChiBenNhan = $hd->dia_chi_ben_nhan;
        $this->sdtBenNhan = $hd->sdt_ben_nhan;
        $this->daiDienBenNhan = $hd->dai_dien_ben_nhan;
        $this->chucVuDaiDienBenNhan = $hd->chuc_vu_ben_nhan;

        if($this->benNhanTA != ''){

            $this->cbBenNhan = '1';

        }else{

            $this->cbBenNhan = '';

        }

        $this->tygia = $hd->tygia;
        $this->vat = $hd->vat;

        $this->chatluong = $hd->chatluong;
        $this->thoigianthanhtoan = $hd->thoigianthanhtoan;
        $this->phuongthucthanhtoan = $hd->phuongthucthanhtoan;
        $this->diadiemgiaohang = $hd->diadiemgiaohang;
        $this->diachi_diadiemgiaohang = $hd->diachi_diadiemgiaohang;
        $this->thoigiangiaohang = $hd->thoigiangiaohang;
        $this->phivanchuyen = $hd->phivanchuyen;

        $this->chatluong_ta = $hd->chatluong_ta;
        $this->thoigianthanhtoan_ta = $hd->thoigianthanhtoan_ta;
        $this->phuongthucthanhtoan_ta = $hd->phuongthucthanhtoan_ta;
        $this->diadiemgiaohang_ta = $hd->diadiemgiaohang_ta;
        $this->diachi_diadiemgiaohang_ta = $hd->diachi_diadiemgiaohang_ta;
        $this->phivanchuyen_ta = $hd->phivanchuyen_ta;

        $this->giaohangtungphan = $hd->giaohangtungphan;

        $this->soluongbanin = $hd->soluongbanin;

        $sanpham = SanPham::where('sohd', $this->shd)->get();

        for ($i=1; $i <16 ; $i++) { 
            
            $this->{'quycach'.$i} = $sanpham[0]->{'quycach'.$i};
            $this->{'soluong'.$i} = $sanpham[0]->{'soluong'.$i};
            $this->{'dongia'.$i} = $sanpham[0]->{'dongia'.$i};

        }

    }

    public function updateHopDongNoiDiaSongNgu(){
        
        if($this->shd){

            if($this->makhachhangbenb == ''){

                flash()->addFlash('error', 'Không tìm thấy khách hàng này','Thông báo');
    
            }else{

                if($this->soTDGTam != $this->soTDG){

                    $laySoTDG = ModelsHopDong::where('so_tdg', $this->soTDG)->first();
        
                    if($laySoTDG != null){
        
                        flash()->addFlash('error', 'Số TDG/TTĐH đã được sử dụng','Thông báo');
                        return;
        
                    }
        
                    $TDG = DB::table('phieu_tdg')
                    ->where('so_phieu', $this->soTDG)
                    ->get();
        
                    if($TDG->isEmpty()){
        
                        $TTDH = DB::table('phieu_ttdh')
                        ->where('so_phieu', $this->soTDG)
                        ->get();
        
                        if($TTDH->isEmpty()){
        
                            sweetalert()->addFlash('error', 'Số TDG/TTĐH không tồn tại','Thông báo');
                            return;
        
                        }
        
                    }
        
                }

                DB::transaction( function(){

                    // if($this->soTDGsoTTDH == 'soTDGRadio'){

                    //     $TDGorTTDH = 'DataFile-';
    
                    // }else{
    
                    //     $TDGorTTDH = 'TTDH-';
    
                    // }

                    $ben_a = BenA::where('id' , $this->bena)->first();
    
                    $sotaikhoan = TaiKhoanNganHang::where('cong_ty_chi_nhanh' , $this->bena)
                                                    ->where('noi_dia_xuat_khau', 'nd')
                                                    ->first();
        
                    $ben_a_hop_dong = BenAHopDong::create([
        
                        'sohd' => $this->shd,
                        'ma_cong_ty' => $this->bena,
                        'ten_tv' => $ben_a->ten_tv,
                        'dia_chi_tv' => $ben_a->dia_chi_tv,
                        'ma_so_thue_tv' => $ben_a->ma_so_thue_tv,
                        'dien_thoai_tv' => $ben_a->dien_thoai_tv,
                        'fax_tv' => $ben_a->fax_tv,

                        'ten_ta' => $ben_a->ten_ta,
                        'dia_chi_ta' => $ben_a->dia_chi_ta,
        
                    ]);

                    BenB::where('ma_khach_hang', $this->makhachhangbenb)->update([
        
                        'dia_chi_tv' => $this->diachibenb,
                        'ma_so_thue_tv' => $this->masothuebenb,
                        'tai_khoan_ngan_hang_tv' => $this->taikhoansobenb,
                        'dien_thoai_tv' => $this->sdtbenb,
                        'fax_tv' => $this->faxbenb,
                        'dai_dien_tv' => $this->daidienbenb,
                        'chuc_vu_tv' => $this->chucvudaidienbenb,
                        'giay_uy_quyen_tv' => $this->uyquyendaidienbenb,

                        'ten_ta' => $this->benb_ta,
                        'dia_chi_ta' => $this->diachibenb_ta,
                        'tai_khoan_ngan_hang_ta' => $this->taikhoansobenb_ta,
                        // 'dai_dien_ta' => $this->daidienbenb_ta,
                        // 'chuc_vu_ta' => $this->chucvudaidienbenb_ta,
        
                    ]);
        
                    $ben_b_hop_dong = BenBHopDong::create([
        
                        'sohd' => $this->shd,
                        'ma_khach_hang' => $this->makhachhangbenb, 
        
                        'ten_tv' => $this->benb,
                        'dia_chi_tv' => $this->diachibenb,
                        'ma_so_thue_tv' => $this->masothuebenb,
                        'tai_khoan_ngan_hang_tv' => $this->taikhoansobenb,
                        'dien_thoai_tv' => $this->sdtbenb,
                        'fax_tv' => $this->faxbenb,
                        'dai_dien_tv' => $this->daidienbenb,
                        'chuc_vu_tv' => $this->chucvudaidienbenb,
                        'giay_uy_quyen_tv' => $this->uyquyendaidienbenb,

                        'ten_ta' => $this->benb_ta,
                        'dia_chi_ta' => $this->diachibenb_ta,
                        'tai_khoan_ngan_hang_ta' => $this->taikhoansobenb_ta,
                        // 'dai_dien_ta' => $this->daidienbenb_ta,
                        // 'chuc_vu_ta' => $this->chucvudaidienbenb_ta,

                        'check_ma_so_thue' => $this->check_ma_so_thue_ben_b,
                        'check_tai_khoan_ngan_hang' => $this->check_tai_khoan_ngan_hang_ben_b,
                        'check_dien_thoai' => $this->check_sdt_ben_b,
                        'check_fax' => $this->check_fax_ben_b,
                        'check_dai_dien' => $this->check_dai_dien_ben_b,
                        'check_giay_uy_quyen' => $this->check_uyquyen_ben_b,

                    ]);

                    $dai_dien_ben_a = DaiDienBenA::where('id', $this->daidienbena)->first();

                    $dai_dien_ben_a_hop_dong = DaiDienBenAHopDong::create([

                        'sohd' => $this->shd,
                        'dai_dien_id' => $this->daidienbena,
                        'ben_a_id' => $this->bena,
                        'dai_dien_tv' => $dai_dien_ben_a->dai_dien_tv,
                        'chuc_vu_tv'=> $dai_dien_ben_a->chuc_vu_tv,
                        'uy_quyen_tv'=> $dai_dien_ben_a->uy_quyen_tv,
                        'dai_dien_ta'=> $dai_dien_ben_a->dai_dien_ta,
                        'chuc_vu_ta'=> $dai_dien_ben_a->chuc_vu_ta,

                    ]);

                    $hopdong_update = ModelsHopDong::where('sohd', $this->shd)->first();

                    // // Chất lượng khác
                    // if($this->chatluongkhac != ''){

                    //     $hopdong_update->chatluong = $this->chatluongkhac;
    
                    // }else{
    
                    //     $hopdong_update->chatluong = $this->chatluong;
    
                    // }

                    // // Chất lượng khác TA
                    // if($this->chatluongkhac_ta != ''){

                    //     $hopdong_update->chatluong_ta = $this->chatluongkhac_ta;
    
                    // }else{
    
                    //     $hopdong_update->chatluong_ta = $this->chatluong_ta;
    
                    // }
                    
                    // Đóng gói khác
                    if($this->donggoikhac != ''){
    
                        $hopdong_update->donggoi = $this->donggoikhac;
    
                    }else{
    
                        $hopdong_update->donggoi = $this->donggoi;
    
                    }

                    // Đóng gói khác TA
                    if($this->donggoikhac_ta != ''){
    
                        $hopdong_update->donggoi_ta = $this->donggoikhac_ta;
    
                    }else{
    
                        $hopdong_update->donggoi_ta = $this->donggoi_ta;
    
                    }
                    
                    // ptth khác
                    if($this->phuongthucgiaohangkhac != ''){
    
                        $hopdong_update->phuongthucgiaohang = $this->phuongthucgiaohangkhac;
    
                    }else{
    
                        $hopdong_update->phuongthucgiaohang = $this->phuongthucgiaohang;
    
                    }

                    // ptgh khác
                    if($this->phuongthucgiaohangkhac_ta != ''){
    
                        $hopdong_update->phuongthucgiaohang_ta = $this->phuongthucgiaohangkhac_ta;
    
                    }else{
    
                        $hopdong_update->phuongthucgiaohang_ta = $this->phuongthucgiaohang_ta;
    
                    }

                    // Nếu số TDG cũ khác với số TDG nhập mới
                    if($this->soTDGTam != $this->soTDG){

                        $hopdong_update->so_tdg = $this->soTDG;
    
                    }
                    

                    $hopdong_update->ngaylaphd = $this->ngaylaphd;
                    $hopdong_update->ngayhethanhd = Carbon::create($this->thoigiangiaohang)->addDays(30)->format('Y-m-d');
    
                    $hopdong_update->bena = $ben_a_hop_dong->id;
                    $hopdong_update->dai_dien_ben_a = $dai_dien_ben_a_hop_dong->id;
                    $hopdong_update->benb = $ben_b_hop_dong->id;

                    $hopdong_update->ben_nhan_ta = $this->benNhanTA;
                    $hopdong_update->ben_nhan_tv = $this->benNhanTV;
                    $hopdong_update->dia_chi_ben_nhan = $this->diaChiBenNhan;
                    $hopdong_update->sdt_ben_nhan = $this->sdtBenNhan;
                    $hopdong_update->dai_dien_ben_nhan = $this->daiDienBenNhan;
                    $hopdong_update->chuc_vu_ben_nhan = $this->chucVuDaiDienBenNhan;
    
                    $hopdong_update->sotaikhoan = $sotaikhoan->so_tai_khoan_tv;
                    $hopdong_update->chutaikhoan = $sotaikhoan->chu_tai_khoan_tv;

                    $hopdong_update->sotaikhoan_ta = $sotaikhoan->so_tai_khoan_ta;
                    $hopdong_update->chutaikhoan_ta = $sotaikhoan->chu_tai_khoan_ta;
    
                    $hopdong_update->tygia = $this->tygia;
                    $hopdong_update->vat = $this->vat;

                    $hopdong_update->chatluong = $this->chatluong;
                    $hopdong_update->chatluong_ta = $this->chatluong_ta;

                    $hopdong_update->thoigianthanhtoan = $this->thoigianthanhtoan;
                    $hopdong_update->thoigianthanhtoan_ta = $this->thoigianthanhtoan_ta;

                    $hopdong_update->phuongthucthanhtoan = $this->phuongthucthanhtoan;
                    $hopdong_update->phuongthucthanhtoan_ta = $this->phuongthucthanhtoan_ta;

                    $hopdong_update->diadiemgiaohang = $this->diadiemgiaohang;
                    $hopdong_update->diadiemgiaohang_ta = $this->diadiemgiaohang_ta;

                    $hopdong_update->diachi_diadiemgiaohang = $this->diachi_diadiemgiaohang;
                    $hopdong_update->diachi_diadiemgiaohang_ta = $this->diachi_diadiemgiaohang_ta;

                    $hopdong_update->thoigiangiaohang = $this->thoigiangiaohang;

                    $hopdong_update->giaohangtungphan = $this->giaohangtungphan;

                    $hopdong_update->phivanchuyen = $this->phivanchuyen;
                    $hopdong_update->phivanchuyen_ta = $this->phivanchuyen_ta;
    
                    $hopdong_update->soluongbanin = $this->soluongbanin;
    
                    $hopdong_update->username = Auth::user()->username;

                    $hopdong_update->tinhtrang = 'New';

                    $hopdong_update->save();
    
                    HopDongLog::create([
        
                        'sohd' => $this->shd,
                        'loaihopdong' => '2',
                        'so_tdg' => $hopdong_update->so_tdg,
                        
                        'ngaylaphd' => $this->ngaylaphd,
                        'ngayhethanhd' => Carbon::create($this->thoigiangiaohang)->addDays(30)->format('Y-m-d'),
        
                        'bena' => $ben_a_hop_dong->id,
                        'dai_dien_ben_a' => $dai_dien_ben_a_hop_dong->id,
                        'benb' => $ben_b_hop_dong->id,

                        'ben_nhan_ta' => $this->benNhanTA,
                        'ben_nhan_tv' => $this->benNhanTV,
                        'dia_chi_ben_nhan' => $this->diaChiBenNhan,
                        'sdt_ben_nhan' >= $this->sdtBenNhan,
                        'dai_dien_ben_nhan' => $this->daiDienBenNhan,
                        'chuc_vu_ben_nhan' => $this->chucVuDaiDienBenNhan,
        
                        'sotaikhoan' => $sotaikhoan->so_tai_khoan_tv,
                        'chutaikhoan' => $sotaikhoan->chu_tai_khoan_tv,
    
                        'sotaikhoan_ta' => $sotaikhoan->so_tai_khoan_ta,
                        'chutaikhoan_ta' => $sotaikhoan->chu_tai_khoan_ta,
        
                        'tygia' => $this->tygia,
                        'vat' => $this->vat,

                        'chatluong' => $hopdong_update->chatluong,
                        'chatluong_ta' => $hopdong_update->chatluong_ta,

                        'donggoi' => $hopdong_update->donggoi,
                        'donggoi_ta' => $hopdong_update->donggoi_ta,
    
                        'thoigianthanhtoan' => $this->thoigianthanhtoan,
                        'thoigianthanhtoan_ta' => $this->thoigianthanhtoan_ta,
    
                        'phuongthucthanhtoan' => $this->phuongthucthanhtoan,
                        'phuongthucthanhtoan_ta' => $this->phuongthucthanhtoan_ta,
    
                        'diadiemgiaohang' => $this->diadiemgiaohang,
                        'diadiemgiaohang_ta' => $this->diadiemgiaohang_ta,

                        'diachi_diadiemgiaohang' => $this->diachi_diadiemgiaohang,
                        'diachi_diadiemgiaohang_ta' => $this->diachi_diadiemgiaohang_ta,
    
                        'thoigiangiaohang' => $this->thoigiangiaohang,
                        
                        'phuongthucgiaohang' => $hopdong_update->phuongthucgiaohang,
                        'phuongthucgiaohang_ta' => $hopdong_update->phuongthucgiaohang_ta,
    
                        'giaohangtungphan' => $this->giaohangtungphan,
    
                        'phivanchuyen' => $this->phivanchuyen,
                        'phivanchuyen_ta' => $this->phivanchuyen_ta,
        
                        'soluongbanin' => $this->soluongbanin,

                        'tinhtrang' => $hopdong_update->tinhtrang,

                        'username_approve' => $hopdong_update->username_approve,
        
                        'username' => Auth::user()->username,
            
                        'trangthai' => 'Sửa'
        
                    ]);
    
                    $sanpham = [];
        
                    for ($i=1; $i <16 ; $i++) { 
        
                        if($this->{'quycach'.$i} != '' && $this->{'soluong'.$i} != '' && $this->{'dongia'.$i} != ''){
        
                            $temp = [
            
                                'quycach'.$i => $this->{'quycach'.$i},
                                'soluong'.$i => $this->{'soluong'.$i},
                                'dongia'.$i => $this->{'dongia'.$i},
            
                            ];
            
                            $sanpham = array_merge($sanpham, $temp);
        
                            $temp = [];
        
                        }else{
                        
                            $temp = [
            
                                'quycach'.$i => null,
                                'soluong'.$i => null,
                                'dongia'.$i => null,
            
                            ];
            
                            $sanpham = array_merge($sanpham, $temp);
        
                            $temp = [];

                        }
                        
                    }
        
                    $sanpham = array_merge($sanpham,['username' => Auth::user()->username]);
        
                    $sanphamlog = array_merge($sanpham,[

                        'sohd' => $this->shd,
                        'username' => Auth::user()->username,
                        'trangthai' => 'Sửa'
                        
                    ]);
                    
                    SanPham::where('sohd', (string)$this->shd)
                        ->update($sanpham);
        
                    SanPhamLog::create($sanphamlog);
        
                    });

                    $this->storeFileHopDongNoiDiaSongNgu();
        
                    flash()->addFlash('success', 'Sửa thành công HĐ : ' . substr($this->shd,4,5) . '/HĐMB-' . substr($this->shd,0,4),'Thông báo');
                    $this->resetInputField();
                    $this->emit('updateHDNDSN');

            }
        }
    }

    #endregion

    #region Hợp đồng XKTCTA

    public function createHopDongXuatKhauTaiChoTiengAnh(){

        $this->formSubmit = 'storeHopDongXuatKhauTaiChoTiengAnh';
        $this->loaihopdong = '3';

    }

    public function storeHopDongXuatKhauTaiChoTiengAnh(){

        // $laySoTDG = ModelsHopDong::where('so_tdg', $this->soTDG)->first();

        // if($laySoTDG != null){

        //     sweetalert()->addFlash('error', 'Số TDG/TTĐH đã được sử dụng','Thông báo');
        //     return;

        // }

        $TDG = DB::table('phieu_tdg')
        ->where('so_phieu', $this->soTDG)
        ->get();

        if($TDG->isEmpty()){

            $TTDH = DB::table('phieu_ttdh')
            ->where('so_phieu', $this->soTDG)
            ->get();

            if($TTDH->isEmpty()){

                sweetalert()->addFlash('error', 'Số TDG/TTĐH không tồn tại','Thông báo');
                return;

            }

        }

        $ngaylaphopdong = Carbon::create($this->ngaylaphd)->isoFormat('YYMMDD');

        $this->shd = IdGenerator::generate(['table' => 'hop_dong', 'field' => 'sohd', 'length' => '16', 'prefix' => 'TKY-' . $ngaylaphopdong . '/EX-','reset_on_prefix_change' => true]);

        if($this->makhachhangbenb == ''){

            flash()->addFlash('error', 'Không tìm thấy khách hàng này','Thông báo');

        }else{

            DB::transaction( function(){

                // if($this->soTDGsoTTDH == 'soTDGRadio'){

                //     $TDGorTTDH = 'DataFile-';

                // }else{

                //     $TDGorTTDH = 'TTDH-';

                // }

                $ben_a = BenA::where('id' , $this->bena)->first();
    
                // $sotaikhoan = TaiKhoanNganHang::where('cong_ty_chi_nhanh' , $this->bena)
                //                                 ->where('noi_dia_xuat_khau', 'xk')
                //                                 ->first();
    
                $ben_a_hop_dong = BenAHopDong::create([
    
                    'sohd' => $this->shd,
                    'ma_cong_ty' => $this->bena,

                    'ten_tv' => $ben_a->ten_tv,
                    'ten_ta' => $ben_a->ten_ta,

                    'dia_chi_tv' => $ben_a->dia_chi_tv,
                    'dia_chi_ta' => $ben_a->dia_chi_ta,

                    'ma_so_thue_tv' => $ben_a->ma_so_thue_tv,
                    'dien_thoai_tv' => $ben_a->dien_thoai_tv,
                    'fax_tv' => $ben_a->fax_tv,
    
                ]);

                BenB::where('ma_khach_hang', $this->makhachhangbenb)->update([

                    'ten_ta' => $this->benb_ta,
                    'dia_chi_ta' => $this->diachibenb_ta,
                    // 'dai_dien_ta' => $this->daidienbenb_ta,
                    // 'chuc_vu_ta' => $this->chucvudaidienbenb_ta,
                    'giay_uy_quyen_tv' => $this->uyquyendaidienbenb,
    
                ]);

                $ben_b_hop_dong = BenBHopDong::create([
    
                    'sohd' => $this->shd,
                    'ma_khach_hang' => $this->makhachhangbenb,
    
                    'ten_tv' => $this->benb,
                    'ten_ta' => $this->benb_ta,

                    'dia_chi_ta' => $this->diachibenb_ta,

                    // 'dai_dien_ta' => $this->daidienbenb_ta,
                    // 'chuc_vu_ta' => $this->chucvudaidienbenb_ta,
                    'dai_dien_tv' => $this->daidienbenb,
                    'chuc_vu_tv' => $this->chucvudaidienbenb,
                    'giay_uy_quyen_tv' => $this->uyquyendaidienbenb,

                    'check_dai_dien' => $this->check_dai_dien_ben_b,
                    'check_giay_uy_quyen' => $this->check_uyquyen_ben_b,
                    
                ]);

                $dai_dien_ben_a = DaiDienBenA::where('id', $this->daidienbena)->first();

                $dai_dien_ben_a_hop_dong = DaiDienBenAHopDong::create([

                    'sohd' => $this->shd,
                    'dai_dien_id' => $this->daidienbena,
                    'ben_a_id' => $this->bena,
                    'uy_quyen_tv'=> $dai_dien_ben_a->uy_quyen_tv,
                    'dai_dien_ta'=> $dai_dien_ben_a->dai_dien_ta,
                    'chuc_vu_ta'=> $dai_dien_ben_a->chuc_vu_ta,

                ]);

                $arr_hopdong = [

                    'sohd' => $this->shd,
                    'loaihopdong' => '3',
                    'so_tdg' => $this->soTDG,
                    
                    'ngaylaphd' => $this->ngaylaphd,
                    'ngayhethanhd' => Carbon::create($this->ngaylaphd)->addDays(45)->format('Y-m-d'),
    
                    'bena' => $ben_a_hop_dong->id,
                    'dai_dien_ben_a' => $dai_dien_ben_a_hop_dong->id,
                    'benb' => $ben_b_hop_dong->id,
    
                    'chatluong_ta' => $this->chatluong_ta,
                    'phuongthucthanhtoan_ta' => $this->phuongthucthanhtoan_ta,
                    'diadiemgiaohang_ta' => $this->diadiemgiaohang_ta,
                    'diachi_diadiemgiaohang_ta' => $this->diachi_diadiemgiaohang_ta,
                    'thoigiangiaohang' => $this->thoigiangiaohang,
                    'giaohangtungphan' => $this->giaohangtungphan,
    
                    'soluongbanin' => $this->soluongbanin,

                    'cpt' => $this->cpt,
                    'po' => $this->po,

                    'tinhtrang' => 'New',
    
                    'username' => Auth::user()->username,

                ];

                $ngan_hang = TaiKhoanNganHangNgoaiLe::where('ma_khach_hang', $this->makhachhangbenb)
                                                    ->where('cong_ty_chi_nhanh', $this->bena)
                                                    ->where('noi_dia_xuat_khau', 'xk')
                                                    ->first();

                if($ngan_hang != null){

                    $arr_hopdong = array_merge($arr_hopdong,[ 

                        'sotaikhoan_ta' => $ngan_hang->so_tai_khoan_ta,
                        'chutaikhoan_ta' => $ngan_hang->chu_tai_khoan_ta,

                    ]);

                }else{

                    $sotaikhoan = TaiKhoanNganHang::where('cong_ty_chi_nhanh' , $this->bena)
                                                ->where('noi_dia_xuat_khau', 'xk')
                                                ->first();

                    $arr_hopdong = array_merge($arr_hopdong,[ 

                        'sotaikhoan_ta' => $sotaikhoan->so_tai_khoan_ta,
                        'chutaikhoan_ta' => $sotaikhoan->chu_tai_khoan_ta,

                    ]);
                
                }

                // if($this->chatluongkhac_ta != ''){

                //     $arr_hopdong = array_merge($arr_hopdong,[ 'chatluong_ta' => $this->chatluongkhac_ta ]);

                // }else{

                //     $arr_hopdong = array_merge($arr_hopdong,[ 'chatluong_ta' => $this->chatluong_ta ]);

                // }

                if($this->donggoikhac_ta != ''){

                    $arr_hopdong = array_merge($arr_hopdong,[ 'donggoi_ta' => $this->donggoikhac_ta ]);

                }else{

                    $arr_hopdong = array_merge($arr_hopdong,[ 'donggoi_ta' => $this->donggoi_ta ]);

                }
    
                ModelsHopDong::create($arr_hopdong);

                $arr_hopdong = array_merge($arr_hopdong,[ 'trangthai' => 'Tạo' ]);
    
                HopDongLog::create($arr_hopdong);
    
                $sanpham = [
                    'sohd' => $this->shd,
    
                    'quycach1' => $this->quycach1,
                    'soluong1' => $this->soluong1,
                    'dongia1' => $this->dongia1
                ];
    
                for ($i = 2; $i < 16 ; $i++) { 
    
                    if($this->{'quycach'.$i} != '' && $this->{'soluong'.$i} && $this->{'dongia'.$i}){
    
                        $temp = [
                            'quycach' . $i => $this->{'quycach'.$i},
                            'soluong' . $i => $this->{'soluong'.$i},
                            'dongia' . $i => $this->{'dongia'.$i}
                        ];
        
                        $sanpham = array_merge($sanpham,$temp);
        
                        $temp = [];
    
                    }
                    
                }
    
                SanPham::create(array_merge($sanpham,['username' => Auth::user()->username]));
    
                $sanphamlog = array_merge($sanpham,['trangthai' => 'Tạo','username' => Auth::user()->username]);
    
                SanPhamLog::create($sanphamlog);

                
            });

            Storage::disk('public')->makeDirectory('HD/' . str_replace('/','_',$this->shd));

            $this->storeFileHopDongXuatKhauTaiChoTiengAnh();

            $taiKhoanDuyetCap1 = User::permission('approve_1_contracts')->first();
            //Mail::to('chloehsu@century.vn')->send(new NewContractMail('3', $this->shd , Auth::user()->username, Carbon::now()));
            Mail::to($taiKhoanDuyetCap1->email)->later(now()->addMinutes(1), new MailHopDong('created', '3', $this->shd , Auth::user()->username, Carbon::now(), ''));

            flash()->addFlash('success', 'Tạo thành công HĐ : ' . $this->shd,'Thông báo');
            $this->resetInputField();
            $this->emit('storeHDXKTCTA');

        }
    } 

    public function storeFileHopDongXuatKhauTaiChoTiengAnh(){

        $templateProcessor = new TemplateProcessor(public_path('HD/HDMB-XKTCTA.docx'));

        $values = [

            'so_hop_dong' => $this->shd,
            'ngay_lap_hop_dong' => Carbon::create($this->ngaylaphd)->format('d M Y'),

        ];

        if($this->po != ''){

            $templateProcessor->cloneBlock('block_so_po', 1, true, true);

            $values = array_merge($values,[

                'so_po#1' => $this->po,
    
            ]);

        }else{

            $templateProcessor->deleteBlock('block_so_po');

        }

        // Lấy thông tin bên A

        $bena = BenA::where('id', $this->bena)->get();
        $daidienbena = DaiDienBenA::where('id', $this->daidienbena)->get();

        $values = array_merge($values,[

            'ben_a' => $bena[0]->ten_ta,
            'dia_chi_ben_a' => $bena[0]->dia_chi_ta,
            'dai_dien_ben_a' => $daidienbena[0]->dai_dien_ta,
            'chuc_vu_dai_dien_ben_a' => $daidienbena[0]->chuc_vu_ta,
            'giay_uy_quyen_ben_a' => $daidienbena[0]->uy_quyen_tv,

        ]);

        // Lấy thông tin bên B

        $values = array_merge($values,[

            'ben_b' => $this->benb_ta,
            'dia_chi_ben_b' => str_replace("&", "&amp;",$this->diachibenb_ta),

        ]);

        $values = array_merge($values, [

            'dai_dien_ben_b' => $this->daidienbenb,
            'chuc_vu_dai_dien_ben_b' => $this->chucvudaidienbenb,

        ]);

        // kiểm tra đại diện bên b

        if($this->check_dai_dien_ben_b == 1 && $this->daidienbenb != '' && $this->chucvudaidienbenb != ''){

            $templateProcessor->cloneBlock('block_dai_dien_ben_b', 1, true, true);

            $values = array_merge($values,[

                'dai_dien_ben_b#1' => "Represented by\t\t\t: " . $this->daidienbenb . "   -  Position : " . $this->chucvudaidienbenb,
    
            ]);

        }else{

            $templateProcessor->deleteBlock('block_dai_dien_ben_b');

        }

        // Kiểm tra check uy quyền

        if($this->check_uyquyen_ben_b == 1 && $this->uyquyendaidienbenb != ''){

            $templateProcessor->cloneBlock('block_uy_quyen_ben_b', 1, true, true);

            $values = array_merge($values,[

                'uy_quyen_ben_b#1' => '(POA NO ' . $this->uyquyendaidienbenb . ')',
    
            ]);

        }else{

            $templateProcessor->deleteBlock('block_uy_quyen_ben_b');

        }

        $sanpham = SanPham::where('sohd', $this->shd)->get();

        $sanpham->transform(function ($item) {

            $item['sumthanhtien'] = $item['soluong1'] * $item['dongia1'] + $item['soluong2'] * $item['dongia2']+ $item['soluong3'] * $item['dongia3']+ $item['soluong4'] * $item['dongia4']
            + $item['soluong5'] * $item['dongia5']+ $item['soluong6'] * $item['dongia6']+ $item['soluong7'] * $item['dongia7']+ $item['soluong8'] * $item['dongia8']+ $item['soluong9'] * $item['dongia9']
            + $item['soluong10'] * $item['dongia10']+ $item['soluong11'] * $item['dongia11']+ $item['soluong12'] * $item['dongia12']+ $item['soluong13'] * $item['dongia13']+ $item['soluong14'] * $item['dongia14']
            + $item['soluong15'] * $item['dongia15'];

            $item['sumsoluong'] = $item['soluong1'] + $item['soluong2'] + $item['soluong3'] + $item['soluong4'] + $item['soluong5'] + $item['soluong6'] + $item['soluong7'] + 
            $item['soluong8'] + $item['soluong9'] + $item['soluong10'] + $item['soluong11'] + $item['soluong12'] + $item['soluong13'] + $item['soluong14'] + $item['soluong15'];

            return $item;
        });

        $sanpham->all();

        $san_pham_values = [];

        for ($i=1; $i <16 ; $i++) { 

            if($sanpham[0]->{'quycach' . $i} != '' && $sanpham[0]->{'soluong' . $i} != '' && $sanpham[0]->{'dongia' . $i} != ''){

                $san_pham_values = array_merge($san_pham_values,[

                    [
                        'san_pham' => str_replace("\n", "<w:br/>", $sanpham[0]->{'quycach' . $i}),
                        'so_luong' => number_format($sanpham[0]->{'soluong' . $i},2),
                        'don_gia' => $sanpham[0]->{'dongia' . $i},
                        'thanh_tien' => number_format($sanpham[0]->{'soluong' . $i} * $sanpham[0]->{'dongia' . $i},2),
                    ],

                ]);

            }
        }

        $ngan_hang = TaiKhoanNganHangNgoaiLe::where('ma_khach_hang', $this->makhachhangbenb)
                                                    ->where('cong_ty_chi_nhanh', $this->bena)
                                                    ->where('noi_dia_xuat_khau', 'xk')
                                                    ->first();

        if($ngan_hang != null){

            $values = array_merge($values,[ 

                'so_tai_khoan' => $ngan_hang->so_tai_khoan_ta,
                'chu_tai_khoan' => $ngan_hang->chu_tai_khoan_ta,

                ]);

        }else{

            $sotaikhoan = TaiKhoanNganHang::where('cong_ty_chi_nhanh' , $this->bena)
                        ->where('noi_dia_xuat_khau', 'xk')
                        ->first();

            $values = array_merge($values,[ 

                'so_tai_khoan' => $sotaikhoan->so_tai_khoan_ta,
                'chu_tai_khoan' => $sotaikhoan->chu_tai_khoan_ta,

            ]);

        }

        $thoigiangiaohang = Carbon::create($this->thoigiangiaohang);

        $values = array_merge($values, [

            'total_mount' => number_format($sanpham[0]->sumthanhtien,2),
            'cpt' => $this->cpt,

            'thoi_gian_giao_hang' => "Before " . $thoigiangiaohang->format('d M Y'),
            
            // 'so_tai_khoan' => $sotaikhoan->so_tai_khoan_ta,
            // 'chu_tai_khoan' => $sotaikhoan->chu_tai_khoan_ta,

            'chat_luong' => str_replace("\n", "<w:br/>", $this->chatluong_ta),

            'phuong_thuc_thanh_toan' => $this->phuongthucthanhtoan_ta,
            'dia_diem_giao_hang' => str_replace("&", "&amp;",$this->diadiemgiaohang_ta),
            'dia_chi_dia_diem_giao_hang' => str_replace("&", "&amp;",$this->diachi_diadiemgiaohang_ta),

            'so_luong_ban_in' => str_pad($this->soluongbanin, 2, '0', STR_PAD_LEFT),
            'ngay_het_han_hop_dong' => $thoigiangiaohang->addDay(45)->format('d M Y')

        ]);

        // if($this->chatluong_ta == 'Khác'){

        //     $values = array_merge($values,['chat_luong' => $this->chatluongkhac_ta]);

        // }else{

        //     $values = array_merge($values,['chat_luong' => $this->chatluong_ta]);

        // }

        if($this->donggoi_ta == 'Other'){

            $values = array_merge($values,['dong_goi' => $this->donggoikhac_ta]);

        }else{

            $values = array_merge($values,['dong_goi' => $this->donggoi_ta]);

        }

        if($this->giaohangtungphan == '1'){

            $templateProcessor->cloneBlock('block_giao_hang_tung_phan', 1, true, true);

            $values = array_merge($values,[

                'giao_hang_tung_phan#1' => 'Allowed',
    
            ]);

        }elseif($this->giaohangtungphan == '2'){

            $templateProcessor->cloneBlock('block_giao_hang_tung_phan', 1, true, true);

            $values = array_merge($values,[

                'giao_hang_tung_phan#1' => 'Not Allowed',
    
            ]);

        }else{

            $templateProcessor->deleteBlock('block_giao_hang_tung_phan');

        }


        $templateProcessor->setValues($values);

        $templateProcessor->cloneRowAndSetValues('san_pham', $san_pham_values);

        $templateProcessor->saveAs(storage_path('app/public/HD/') . str_replace('/','_',$this->shd) . '/' . str_replace('/','_',$this->shd) .'.docx');

    }

    public function editHopDongXuatKhauTaiChoTiengAnh($sohd){

        $this->formSubmit = 'updateHopDongXuatKhauTaiChoTiengAnh';
        
        $this->loaihopdong = '3';

        $hd = ModelsHopDong::where('sohd', $sohd)->first();

        $ben_a_hop_dong = BenAHopDong::where('id', $hd->bena)->first();

        $this->shd = $sohd;
        $this->ngaylaphd = $hd->ngaylaphd;
        $this->soTDG = $hd->so_tdg;
        
        $this->soTDGTam = $hd->so_tdg;
        

        $this->bena = $ben_a_hop_dong->ma_cong_ty;

        $dai_dien_ben_a_hop_dong = DaiDienBenAHopDong::where('id' , $hd->dai_dien_ben_a)->first();
        $this->daidienbena = $dai_dien_ben_a_hop_dong->dai_dien_id;

        $ben_b_hop_dong = BenBHopDong::where('id', $hd->benb)->first();
        $this->makhachhangbenb = $ben_b_hop_dong->ma_khach_hang;
        $this->benb = $ben_b_hop_dong->ten_tv;

        $this->benb_ta = $ben_b_hop_dong->ten_ta;
        $this->diachibenb_ta = $ben_b_hop_dong->dia_chi_ta;
        // $this->daidienbenb_ta = $ben_b_hop_dong->dai_dien_ta;
        // $this->chucvudaidienbenb_ta = $ben_b_hop_dong->chuc_vu_ta;
        $this->daidienbenb = $ben_b_hop_dong->dai_dien_tv;
        $this->chucvudaidienbenb = $ben_b_hop_dong->chuc_vu_tv;
        $this->uyquyendaidienbenb = $ben_b_hop_dong->giay_uy_quyen_tv;

        $this->check_dai_dien_ben_b = $ben_b_hop_dong->check_dai_dien;
        $this->check_uyquyen_ben_b = $ben_b_hop_dong->check_giay_uy_quyen;

        //$selectChatluong = ChatLuong::where('chatluong', $hd->chatluong_ta)->get();
        $selectDongGoi = DongGoi::where('donggoi_ta', $hd->donggoi_ta)->get();

        // if($selectChatluong->count() == 0){

        //     $this->chatluong_ta = 'Khác';
        //     $this->chatluongkhac_ta = $hd->chatluong_ta;

        // }else{

        //     $this->chatluong_ta = $hd->chatluong_ta;
        //     $this->chatluongkhac_ta = '';

        // }

        if($selectDongGoi->count() == 0){

            $this->donggoi_ta = 'Other';
            $this->donggoikhac_ta = $hd->donggoi_ta;

        }else{

            $this->donggoi_ta = $hd->donggoi_ta;
            $this->donggoikhac_ta = '';

        }
        
        $this->chatluong_ta = $hd->chatluong_ta;
        $this->phuongthucthanhtoan_ta = $hd->phuongthucthanhtoan_ta;
        $this->diadiemgiaohang_ta = $hd->diadiemgiaohang_ta;
        $this->diachi_diadiemgiaohang_ta = $hd->diachi_diadiemgiaohang_ta;

        $this->giaohangtungphan = $hd->giaohangtungphan;

        $this->soluongbanin = $hd->soluongbanin;

        $this->cpt = $hd->cpt;
        $this->po = $hd->po;

        $sanpham = SanPham::where('sohd', $this->shd)->get();

        for ($i=1; $i <16 ; $i++) { 
            
            $this->{'quycach'.$i} = $sanpham[0]->{'quycach'.$i};
            $this->{'soluong'.$i} = $sanpham[0]->{'soluong'.$i};
            $this->{'dongia'.$i} = $sanpham[0]->{'dongia'.$i};

        }

    }

    public function updateHopDongXuatKhauTaiChoTiengAnh(){
        if($this->shd){

            if($this->makhachhangbenb == ''){

                flash()->addFlash('error', 'Không tìm thấy khách hàng này','Thông báo');
    
            }else{

                if($this->soTDGTam != $this->soTDG){

                    $laySoTDG = ModelsHopDong::where('so_tdg', $this->soTDG)->first();
        
                    if($laySoTDG != null){
        
                        flash()->addFlash('error', 'Số TDG/TTĐH đã được sử dụng','Thông báo');
                        return;
        
                    }
        
                    $TDG = DB::table('phieu_tdg')
                    ->where('so_phieu', $this->soTDG)
                    ->get();
        
                    if($TDG->isEmpty()){
        
                        $TTDH = DB::table('phieu_ttdh')
                        ->where('so_phieu', $this->soTDG)
                        ->get();
        
                        if($TTDH->isEmpty()){
        
                            sweetalert()->addFlash('error', 'Số TDG/TTĐH không tồn tại','Thông báo');
                            return;
        
                        }
        
                    }
        
                }

                DB::transaction( function(){

                    // if($this->soTDGsoTTDH == 'soTDGRadio'){

                    //     $TDGorTTDH = 'DataFile-';
    
                    // }else{
    
                    //     $TDGorTTDH = 'TTDH-';
    
                    // }

                    $ben_a = BenA::where('id' , $this->bena)->first();
    
                    // $sotaikhoan = TaiKhoanNganHang::where('cong_ty_chi_nhanh' , $this->bena)
                    //                                 ->where('noi_dia_xuat_khau', 'nd')
                    //                                 ->first();
        
                    $ben_a_hop_dong = BenAHopDong::create([

                        'sohd' => $this->shd,
                        'ma_cong_ty' => $this->bena,

                        'ten_tv' => $ben_a->ten_tv,
                        'ten_ta' => $ben_a->ten_ta,

                        'dia_chi_tv' => $ben_a->dia_chi_tv,
                        'dia_chi_ta' => $ben_a->dia_chi_ta,

                        'ma_so_thue_tv' => $ben_a->ma_so_thue_tv,
                        'dien_thoai_tv' => $ben_a->dien_thoai_tv,
                        'fax_tv' => $ben_a->fax_tv,
        
                    ]);

                    BenB::where('ma_khach_hang', $this->makhachhangbenb)->update([

                        'ten_ta' => $this->benb_ta,
                        'dia_chi_ta' => $this->diachibenb_ta,
                        // 'dai_dien_ta' => $this->daidienbenb_ta,
                        // 'chuc_vu_ta' => $this->chucvudaidienbenb_ta,
        
                    ]);
        
                    $ben_b_hop_dong = BenBHopDong::create([
        
                        'sohd' => $this->shd,
                        'ma_khach_hang' => $this->makhachhangbenb,

                        'ten_tv' => $this->benb,
                        'ten_ta' => $this->benb_ta,
                        'dia_chi_ta' => $this->diachibenb_ta,
                        // 'dai_dien_ta' => $this->daidienbenb_ta,
                        // 'chuc_vu_ta' => $this->chucvudaidienbenb_ta,
                        'dai_dien_tv' => $this->daidienbenb,
                        'chuc_vu_tv' => $this->chucvudaidienbenb,
                        'giay_uy_quyen_tv' => $this->uyquyendaidienbenb,

                        'check_dai_dien' => $this->check_dai_dien_ben_b,
                        'check_giay_uy_quyen' => $this->check_uyquyen_ben_b,
                        
                    ]);

                    $dai_dien_ben_a = DaiDienBenA::where('id', $this->daidienbena)->first();

                    $dai_dien_ben_a_hop_dong = DaiDienBenAHopDong::create([

                        'sohd' => $this->shd,
                        'dai_dien_id' => $this->daidienbena,
                        'ben_a_id' => $this->bena,
                        'uy_quyen_tv'=> $dai_dien_ben_a->uy_quyen_tv,
                        'dai_dien_ta'=> $dai_dien_ben_a->dai_dien_ta,
                        'chuc_vu_ta'=> $dai_dien_ben_a->chuc_vu_ta,

                    ]);

                    $hopdong_update = ModelsHopDong::where('sohd', $this->shd)->first();

                    // if($this->chatluongkhac_ta != ''){

                    //     $hopdong_update->chatluong_ta = $this->chatluongkhac_ta;
    
                    // }else{
    
                    //     $hopdong_update->chatluong_ta = $this->chatluong_ta;
    
                    // }
    
                    if($this->donggoikhac_ta != ''){
    
                        $hopdong_update->donggoi_ta = $this->donggoikhac_ta;
    
                    }else{
    
                        $hopdong_update->donggoi_ta = $this->donggoi_ta;
    
                    }

                    // Nếu số TDG cũ khác với số TDG nhập mới
                    if($this->soTDGTam != $this->soTDG){

                        $hopdong_update->so_tdg = $this->soTDG;
    
                    }
                    

                    $hopdong_update->ngaylaphd = $this->ngaylaphd;
                    $hopdong_update->ngayhethanhd = Carbon::create($this->ngaylaphd)->addDays(45)->format('Y-m-d');
    
                    $hopdong_update->bena = $ben_a_hop_dong->id;
                    $hopdong_update->dai_dien_ben_a = $dai_dien_ben_a_hop_dong->id;
                    $hopdong_update->benb = $ben_b_hop_dong->id;

                    $ngan_hang = TaiKhoanNganHangNgoaiLe::where('ma_khach_hang', $this->makhachhangbenb)
                    ->where('cong_ty_chi_nhanh', $this->bena)
                    ->where('noi_dia_xuat_khau', 'xk')
                    ->first();

                    if($ngan_hang != null){

                        $hopdong_update->sotaikhoan_ta = $ngan_hang->so_tai_khoan_ta;
                        $hopdong_update->chutaikhoan_ta = $ngan_hang->chu_tai_khoan_ta;

                    }else{

                        $sotaikhoan = TaiKhoanNganHang::where('cong_ty_chi_nhanh' , $this->bena)
                            ->where('noi_dia_xuat_khau', 'xk')
                            ->first();

                        $hopdong_update->sotaikhoan_ta = $sotaikhoan->so_tai_khoan_ta;
                        $hopdong_update->chutaikhoan_ta = $sotaikhoan->chu_tai_khoan_ta;

                    }
    
                    $hopdong_update->chatluong_ta = $this->chatluong_ta;
                    $hopdong_update->phuongthucthanhtoan_ta = $this->phuongthucthanhtoan_ta;
                    $hopdong_update->diadiemgiaohang_ta = $this->diadiemgiaohang_ta;
                    $hopdong_update->diachi_diadiemgiaohang_ta = $this->diachi_diadiemgiaohang_ta;
                    $hopdong_update->thoigiangiaohang = $this->thoigiangiaohang;
                    $hopdong_update->giaohangtungphan = $this->giaohangtungphan;
    
                    $hopdong_update->soluongbanin = $this->soluongbanin;

                    $hopdong_update->cpt = $this->cpt;
                    $hopdong_update->po = $this->po;
    
                    $hopdong_update->username = Auth::user()->username;

                    $hopdong_update->tinhtrang = 'New';

                    $hopdong_update->save();
    
                    HopDongLog::create([
        
                        'sohd' => $this->shd,
                        'loaihopdong' => '3',
                        'so_tdg' => $hopdong_update->so_tdg,
                        
                        'ngaylaphd' => $this->ngaylaphd,
                        'ngayhethanhd' => Carbon::create($this->ngaylaphd)->addDays(45)->format('Y-m-d'),
        
                        'bena' => $ben_a_hop_dong->id,
                        'dai_dien_ben_a' => $dai_dien_ben_a_hop_dong->id,
                        'benb' => $ben_b_hop_dong->id,

                        'sotaikhoan_ta' => $hopdong_update->so_tai_khoan_ta,
                        'chutaikhoan_ta' => $hopdong_update->chu_tai_khoan_ta,
        
                        'chatluong_ta' => $hopdong_update->chatluong_ta,
                        'donggoi_ta' => $hopdong_update->donggoi_ta,
                        
                        'phuongthucthanhtoan_ta' => $this->phuongthucthanhtoan_ta,
                        'diadiemgiaohang_ta' => $this->diadiemgiaohang_ta,
                        'diachi_diadiemgiaohang_ta' => $this->diachi_diadiemgiaohang_ta,
                        'thoigiangiaohang' => $this->thoigiangiaohang,
                        'giaohangtungphan' => $this->giaohangtungphan,
        
                        'soluongbanin' => $this->soluongbanin,

                        'cpt' => $this->cpt,
                        'po' => $this->po,

                        'tinhtrang' => $hopdong_update->tinhtrang,

                        'username_approve' => $hopdong_update->username_approve,
        
                        'username' => Auth::user()->username,
            
                        'trangthai' => 'Sửa'
        
                    ]);
    
                    $sanpham = [
                        'sohd' => $this->shd,
                    ];
        
                    for ($i=1; $i <16 ; $i++) { 
        
                        if($this->{'quycach'.$i} != '' && $this->{'soluong'.$i} && $this->{'dongia'.$i}){
        
                            $temp = [
            
                                'quycach'.$i => $this->{'quycach'.$i},
                                'soluong'.$i => $this->{'soluong'.$i},
                                'dongia'.$i => $this->{'dongia'.$i},
            
                            ];
            
                            $sanpham = array_merge($sanpham, $temp);
        
                            $temp = [];
        
                        }
                        
                    }
        
                    $sanpham = array_merge($sanpham,['username' => Auth::user()->username]);
        
                    $sanphamlog = array_merge($sanpham,['username' => Auth::user()->username, 'trangthai' => 'Sửa']);
                    
                    SanPham::where('sohd', (string)$this->shd)
                        ->update($sanpham);
        
                    SanPhamLog::create($sanphamlog);
        
                    });

                    $this->storeFileHopDongXuatKhauTaiChoTiengAnh();
        
                    flash()->addFlash('success', 'Sửa thành công HĐ : ' . $this->shd,'Thông báo');
                    $this->resetInputField();
                    $this->emit('updateHDXKTCTA');

            }
        }
    }

    #endregion

    #region Annex DESIPRO 

    public function createAnnexDESIPRO(){

        $this->loaihopdong = '3';

    }

    public function storeAnnexDESIPRO(){

        $TDG = DB::table('phieu_tdg')
        ->where('so_phieu', $this->soTDG)
        ->get();

        if($TDG->isEmpty()){

            $TTDH = DB::table('phieu_ttdh')
            ->where('so_phieu', $this->soTDG)
            ->get();

            if($TTDH->isEmpty()){

                sweetalert()->addFlash('error', 'Số TDG/TTĐH không tồn tại','Thông báo');
                return;

            }

        }

        $ngaylaphopdong = Carbon::create($this->ngaylaphd)->isoFormat('YYMMDD');

        $this->shd = 'ANNEX NO. ' . $this->soAnnex;

        if($this->makhachhangbenb == ''){

            flash()->addFlash('error', 'Không tìm thấy khách hàng này','Thông báo');

        }else{

            DB::transaction( function(){

                $ben_a = BenA::where('id' , $this->bena)->first();
    
                $ben_a_hop_dong = BenAHopDong::create([
    
                    'sohd' => $this->shd,
                    'ma_cong_ty' => $this->bena,

                    'ten_tv' => $ben_a->ten_tv,
                    'ten_ta' => $ben_a->ten_ta,

                    'dia_chi_tv' => $ben_a->dia_chi_tv,
                    'dia_chi_ta' => $ben_a->dia_chi_ta,

                    'ma_so_thue_tv' => $ben_a->ma_so_thue_tv,
                    'dien_thoai_tv' => $ben_a->dien_thoai_tv,
                    'fax_tv' => $ben_a->fax_tv,
    
                ]);

                BenB::where('ma_khach_hang', $this->makhachhangbenb)->update([

                    'ten_ta' => $this->benb_ta,
                    'dia_chi_ta' => $this->diachibenb_ta,
    
                ]);

                $ben_b_hop_dong = BenBHopDong::create([
    
                    'sohd' => $this->shd,
                    'ma_khach_hang' => $this->makhachhangbenb,
    
                    'ten_tv' => $this->benb,
                    'ten_ta' => $this->benb_ta,

                    'dia_chi_ta' => $this->diachibenb_ta,
                    
                ]);

                $dai_dien_ben_a = DaiDienBenA::where('id', $this->daidienbena)->first();

                $dai_dien_ben_a_hop_dong = DaiDienBenAHopDong::create([

                    'sohd' => $this->shd,
                    'dai_dien_id' => $this->daidienbena,
                    'ben_a_id' => $this->bena,
                    'uy_quyen_tv'=> $dai_dien_ben_a->uy_quyen_tv,
                    'dai_dien_ta'=> $dai_dien_ben_a->dai_dien_ta,
                    'chuc_vu_ta'=> $dai_dien_ben_a->chuc_vu_ta,

                ]);

                $arr_hopdong = [

                    'sohd' => $this->shd,
                    'loaihopdong' => '3',
                    'so_tdg' => $this->soTDG,
                    
                    'ngaylaphd' => $this->ngaylaphd,
                    'ngayhethanhd' => Carbon::create($this->ngaylaphd)->addDays(45)->format('Y-m-d'),
    
                    'bena' => $ben_a_hop_dong->id,
                    'dai_dien_ben_a' => $dai_dien_ben_a_hop_dong->id,
                    'benb' => $ben_b_hop_dong->id,
    
                    'chatluong_ta' => $this->chatluong_ta,
                    'phuongthucthanhtoan_ta' => $this->phuongthucthanhtoan_ta,
                    'diadiemgiaohang_ta' => $this->diadiemgiaohang_ta,
                    'diachi_diadiemgiaohang_ta' => $this->diachi_diadiemgiaohang_ta,
                    'thoigiangiaohang' => $this->thoigiangiaohang,
                    'giaohangtungphan' => $this->giaohangtungphan,

                    'cpt' => $this->cpt,

                    'ben_nhan_1' => $this->benNhan1,
                    'dia_chi_ben_nhan_1' => $this->diaChiBenNhan1,
                    'dai_dien_ben_nhan_1' => $this->daiDienBenNhan1,
                    'ben_nhan_2' => $this->benNhan2,
                    'dia_chi_ben_nhan_2' => $this->diaChiBenNhan2,
                    'dai_dien_ben_nhan_2' => $this->daiDienBenNhan2,

                    'tinhtrang' => 'New',
    
                    'username' => Auth::user()->username,

                ];

                $ngan_hang = TaiKhoanNganHangNgoaiLe::where('ma_khach_hang', $this->makhachhangbenb)
                                                    ->where('cong_ty_chi_nhanh', $this->bena)
                                                    ->where('noi_dia_xuat_khau', 'xk')
                                                    ->first();

                if($ngan_hang != null){

                    $arr_hopdong = array_merge($arr_hopdong,[ 

                        'sotaikhoan_ta' => $ngan_hang->so_tai_khoan_ta,
                        'chutaikhoan_ta' => $ngan_hang->chu_tai_khoan_ta,

                    ]);

                }else{

                    $sotaikhoan = TaiKhoanNganHang::where('cong_ty_chi_nhanh' , $this->bena)
                                                ->where('noi_dia_xuat_khau', 'xk')
                                                ->first();

                    $arr_hopdong = array_merge($arr_hopdong,[ 

                        'sotaikhoan_ta' => $sotaikhoan->so_tai_khoan_ta,
                        'chutaikhoan_ta' => $sotaikhoan->chu_tai_khoan_ta,

                    ]);
                
                }

                if($this->donggoikhac_ta != ''){

                    $arr_hopdong = array_merge($arr_hopdong,[ 'donggoi_ta' => $this->donggoikhac_ta ]);

                }else{

                    $arr_hopdong = array_merge($arr_hopdong,[ 'donggoi_ta' => $this->donggoi_ta ]);

                }
    
                ModelsHopDong::create($arr_hopdong);

                $arr_hopdong = array_merge($arr_hopdong,[ 'trangthai' => 'Tạo' ]);
    
                HopDongLog::create($arr_hopdong);
    
                $sanpham = [
                    'sohd' => $this->shd,
    
                    'quycach1' => $this->quycach1,
                    'soluong1' => $this->soluong1,
                    'dongia1' => $this->dongia1
                ];
    
                for ($i = 2; $i < 16 ; $i++) { 
    
                    if($this->{'quycach'.$i} != '' && $this->{'soluong'.$i} && $this->{'dongia'.$i}){
    
                        $temp = [
                            'quycach' . $i => $this->{'quycach'.$i},
                            'soluong' . $i => $this->{'soluong'.$i},
                            'dongia' . $i => $this->{'dongia'.$i}
                        ];
        
                        $sanpham = array_merge($sanpham,$temp);
        
                        $temp = [];
    
                    }
                    
                }
    
                SanPham::create(array_merge($sanpham,['username' => Auth::user()->username]));
    
                $sanphamlog = array_merge($sanpham,['trangthai' => 'Tạo','username' => Auth::user()->username]);
    
                SanPhamLog::create($sanphamlog);

                
            });

            Storage::disk('public')->makeDirectory('HD/' . str_replace('/','_',$this->shd));

            $this->storeFileAnnexDESIPRO();

            $taiKhoanDuyetCap1 = User::permission('approve_1_contracts')->first();

            //Mail::to('chloehsu@century.vn')->send(new NewContractMail('3', $this->shd , Auth::user()->username, Carbon::now()));
            Mail::to($taiKhoanDuyetCap1->email)->later(now()->addMinutes(1), new MailHopDong('created', '3', $this->shd , Auth::user()->username, Carbon::now(), ''));

            flash()->addFlash('success', 'Tạo thành công HĐ : ' . $this->shd,'Thông báo');
            $this->resetInputField();
            $this->emit('storeHDXKTCTA');

        }
    } 

    public function storeFileAnnexDESIPRO(){

        $templateProcessor = new TemplateProcessor(public_path('HD/ANNEX-DESIPRO.docx'));

        $values = [

            'annex_number' => $this->soAnnex,
            'day' => Carbon::create($this->ngaylaphd)->format('d M Y'),

        ];

        // Lấy thông tin bên A

        $bena = BenA::where('id', $this->bena)->get();
        $daidienbena = DaiDienBenA::where('id', $this->daidienbena)->get();

        $values = array_merge($values,[

            'ben_a' => $bena[0]->ten_ta,
            'dia_chi_ben_a' => $bena[0]->dia_chi_ta,
            'dai_dien_ben_a' => $daidienbena[0]->dai_dien_ta,
            'chuc_vu_dai_dien_ben_a' => $daidienbena[0]->chuc_vu_ta,

        ]);

        // Lấy thông tin bên B

        $values = array_merge($values,[

            'ben_b' => $this->benb_ta,
            'dia_chi_ben_b' => str_replace("&", "&amp;",$this->diachibenb_ta),

        ]);

        // Bên Nhận 1, 2

        $values = array_merge($values,[

            'ben_nhan_1' => $this->benNhan1,
            'dia_chi_ben_nhan_1' => str_replace("&", "&amp;",$this->diaChiBenNhan1),
            'dai_dien_ben_nhan_1' => $this->daiDienBenNhan1,

            'ben_nhan_2' => $this->benNhan2,
            'dia_chi_ben_nhan_2' => str_replace("&", "&amp;",$this->diaChiBenNhan2),
            'dai_dien_ben_nhan_2' => $this->daiDienBenNhan2,

        ]);

        $sanpham = SanPham::where('sohd', $this->shd)->get();

        $sanpham->transform(function ($item) {

            $item['sumthanhtien'] = $item['soluong1'] * $item['dongia1'] + $item['soluong2'] * $item['dongia2']+ $item['soluong3'] * $item['dongia3']+ $item['soluong4'] * $item['dongia4']
            + $item['soluong5'] * $item['dongia5']+ $item['soluong6'] * $item['dongia6']+ $item['soluong7'] * $item['dongia7']+ $item['soluong8'] * $item['dongia8']+ $item['soluong9'] * $item['dongia9']
            + $item['soluong10'] * $item['dongia10']+ $item['soluong11'] * $item['dongia11']+ $item['soluong12'] * $item['dongia12']+ $item['soluong13'] * $item['dongia13']+ $item['soluong14'] * $item['dongia14']
            + $item['soluong15'] * $item['dongia15'];

            $item['sumsoluong'] = $item['soluong1'] + $item['soluong2'] + $item['soluong3'] + $item['soluong4'] + $item['soluong5'] + $item['soluong6'] + $item['soluong7'] + 
            $item['soluong8'] + $item['soluong9'] + $item['soluong10'] + $item['soluong11'] + $item['soluong12'] + $item['soluong13'] + $item['soluong14'] + $item['soluong15'];

            return $item;
        });

        $sanpham->all();

        $san_pham_values = [];

        for ($i=1; $i <16 ; $i++) { 

            if($sanpham[0]->{'quycach' . $i} != '' && $sanpham[0]->{'soluong' . $i} != '' && $sanpham[0]->{'dongia' . $i} != ''){

                $san_pham_values = array_merge($san_pham_values,[

                    [
                        'san_pham' => str_replace("\n", "<w:br/>", $sanpham[0]->{'quycach' . $i}),
                        'so_luong' => number_format($sanpham[0]->{'soluong' . $i},2),
                        'don_gia' => $sanpham[0]->{'dongia' . $i},
                        'thanh_tien' => number_format($sanpham[0]->{'soluong' . $i} * $sanpham[0]->{'dongia' . $i},2),
                    ],

                ]);

            }
        }

        $ngan_hang = TaiKhoanNganHangNgoaiLe::where('ma_khach_hang', $this->makhachhangbenb)
                                                    ->where('cong_ty_chi_nhanh', $this->bena)
                                                    ->where('noi_dia_xuat_khau', 'xk')
                                                    ->first();

        if($ngan_hang != null){

            $values = array_merge($values,[ 

                'so_tai_khoan' => $ngan_hang->so_tai_khoan_ta,
                'chu_tai_khoan' => $ngan_hang->chu_tai_khoan_ta,

                ]);

        }else{

            $sotaikhoan = TaiKhoanNganHang::where('cong_ty_chi_nhanh' , $this->bena)
                        ->where('noi_dia_xuat_khau', 'xk')
                        ->first();

            $values = array_merge($values,[ 

                'so_tai_khoan' => $sotaikhoan->so_tai_khoan_ta,
                'chu_tai_khoan' => $sotaikhoan->chu_tai_khoan_ta,

            ]);

        }

        $thoigiangiaohang = Carbon::create($this->thoigiangiaohang);

        $values = array_merge($values, [

            'total_mount' => number_format($sanpham[0]->sumthanhtien,2),
            'cpt' => $this->cpt,

            'thoi_gian_giao_hang' => "Before " . $thoigiangiaohang->format('d M Y'),
            
            // 'so_tai_khoan' => $sotaikhoan->so_tai_khoan_ta,
            // 'chu_tai_khoan' => $sotaikhoan->chu_tai_khoan_ta,

            'chat_luong' => str_replace("\n", "<w:br/>", $this->chatluong_ta),

            'phuong_thuc_thanh_toan' => $this->phuongthucthanhtoan_ta,
            'dia_diem_giao_hang' => str_replace("&", "&amp;",$this->diadiemgiaohang_ta),
            'dia_chi_dia_diem_giao_hang' => str_replace("&", "&amp;",$this->diachi_diadiemgiaohang_ta),

        ]);

        // if($this->chatluong_ta == 'Khác'){

        //     $values = array_merge($values,['chat_luong' => $this->chatluongkhac_ta]);

        // }else{

        //     $values = array_merge($values,['chat_luong' => $this->chatluong_ta]);

        // }

        if($this->donggoi_ta == 'Other'){

            $values = array_merge($values,['dong_goi' => $this->donggoikhac_ta]);

        }else{

            $values = array_merge($values,['dong_goi' => $this->donggoi_ta]);

        }

        if($this->giaohangtungphan == '1'){

            $templateProcessor->cloneBlock('block_giao_hang_tung_phan', 1, true, true);

            $values = array_merge($values,[

                'giao_hang_tung_phan#1' => 'Allowed',
    
            ]);

        }elseif($this->giaohangtungphan == '2'){

            $templateProcessor->cloneBlock('block_giao_hang_tung_phan', 1, true, true);

            $values = array_merge($values,[

                'giao_hang_tung_phan#1' => 'Not Allowed',
    
            ]);

        }else{

            $templateProcessor->deleteBlock('block_giao_hang_tung_phan');

        }


        $templateProcessor->setValues($values);

        $templateProcessor->cloneRowAndSetValues('san_pham', $san_pham_values);

        $templateProcessor->saveAs(storage_path('app/public/HD/') . str_replace('/','_',$this->shd) . '/' . str_replace('/','_',$this->shd) .'.docx');

    }

    public function editAnnexDESIPRO($sohd){
        
        $this->loaihopdong = '3';

        $hd = ModelsHopDong::where('sohd', $sohd)->first();

        $ben_a_hop_dong = BenAHopDong::where('id', $hd->bena)->first();

        $this->shd = $sohd;
        $this->ngaylaphd = $hd->ngaylaphd;
        $this->soTDG = $hd->so_tdg;
        
        $this->soTDGTam = $hd->so_tdg;

        $this->bena = $ben_a_hop_dong->ma_cong_ty;

        $dai_dien_ben_a_hop_dong = DaiDienBenAHopDong::where('id' , $hd->dai_dien_ben_a)->first();
        $this->daidienbena = $dai_dien_ben_a_hop_dong->dai_dien_id;

        $ben_b_hop_dong = BenBHopDong::where('id', $hd->benb)->first();
        $this->makhachhangbenb = $ben_b_hop_dong->ma_khach_hang;
        $this->benb = $ben_b_hop_dong->ten_tv;

        $this->benb_ta = $ben_b_hop_dong->ten_ta;
        $this->diachibenb_ta = $ben_b_hop_dong->dia_chi_ta;

        $selectDongGoi = DongGoi::where('donggoi_ta', $hd->donggoi_ta)->get();

        if($selectDongGoi->count() == 0){

            $this->donggoi_ta = 'Other';
            $this->donggoikhac_ta = $hd->donggoi_ta;

        }else{

            $this->donggoi_ta = $hd->donggoi_ta;
            $this->donggoikhac_ta = '';

        }
        
        $this->chatluong_ta = $hd->chatluong_ta;
        $this->phuongthucthanhtoan_ta = $hd->phuongthucthanhtoan_ta;
        $this->diadiemgiaohang_ta = $hd->diadiemgiaohang_ta;
        $this->diachi_diadiemgiaohang_ta = $hd->diachi_diadiemgiaohang_ta;

        $this->giaohangtungphan = $hd->giaohangtungphan;

        $this->cpt = $hd->cpt;

        $sanpham = SanPham::where('sohd', $this->shd)->get();

        for ($i=1; $i <16 ; $i++) { 
            
            $this->{'quycach'.$i} = $sanpham[0]->{'quycach'.$i};
            $this->{'soluong'.$i} = $sanpham[0]->{'soluong'.$i};
            $this->{'dongia'.$i} = $sanpham[0]->{'dongia'.$i};

        }

    }

    public function updateAnnexDESIPRO(){
        if($this->shd){

            if($this->makhachhangbenb == ''){

                flash()->addFlash('error', 'Không tìm thấy khách hàng này','Thông báo');
    
            }else{

                if($this->soTDGTam != $this->soTDG){

                    $laySoTDG = ModelsHopDong::where('so_tdg', $this->soTDG)->first();
        
                    if($laySoTDG != null){
        
                        flash()->addFlash('error', 'Số TDG/TTĐH đã được sử dụng','Thông báo');
                        return;
        
                    }
        
                    $TDG = DB::table('phieu_tdg')
                    ->where('so_phieu', $this->soTDG)
                    ->get();
        
                    if($TDG->isEmpty()){
        
                        $TTDH = DB::table('phieu_ttdh')
                        ->where('so_phieu', $this->soTDG)
                        ->get();
        
                        if($TTDH->isEmpty()){
        
                            sweetalert()->addFlash('error', 'Số TDG/TTĐH không tồn tại','Thông báo');
                            return;
        
                        }
        
                    }
        
                }

                DB::transaction( function(){

                    $ben_a = BenA::where('id' , $this->bena)->first();
        
                    $ben_a_hop_dong = BenAHopDong::create([

                        'sohd' => $this->shd,
                        'ma_cong_ty' => $this->bena,

                        'ten_tv' => $ben_a->ten_tv,
                        'ten_ta' => $ben_a->ten_ta,

                        'dia_chi_tv' => $ben_a->dia_chi_tv,
                        'dia_chi_ta' => $ben_a->dia_chi_ta,

                        'ma_so_thue_tv' => $ben_a->ma_so_thue_tv,
                        'dien_thoai_tv' => $ben_a->dien_thoai_tv,
                        'fax_tv' => $ben_a->fax_tv,
        
                    ]);

                    BenB::where('ma_khach_hang', $this->makhachhangbenb)->update([

                        'ten_ta' => $this->benb_ta,
                        'dia_chi_ta' => $this->diachibenb_ta,
        
                    ]);
        
                    $ben_b_hop_dong = BenBHopDong::create([
        
                        'sohd' => $this->shd,
                        'ma_khach_hang' => $this->makhachhangbenb,

                        'ten_tv' => $this->benb,
                        'ten_ta' => $this->benb_ta,
                        'dia_chi_ta' => $this->diachibenb_ta,
                        
                    ]);

                    $dai_dien_ben_a = DaiDienBenA::where('id', $this->daidienbena)->first();

                    $dai_dien_ben_a_hop_dong = DaiDienBenAHopDong::create([

                        'sohd' => $this->shd,
                        'dai_dien_id' => $this->daidienbena,
                        'ben_a_id' => $this->bena,
                        'uy_quyen_tv'=> $dai_dien_ben_a->uy_quyen_tv,
                        'dai_dien_ta'=> $dai_dien_ben_a->dai_dien_ta,
                        'chuc_vu_ta'=> $dai_dien_ben_a->chuc_vu_ta,

                    ]);

                    $hopdong_update = ModelsHopDong::where('sohd', $this->shd)->first();
    
                    if($this->donggoikhac_ta != ''){
    
                        $hopdong_update->donggoi_ta = $this->donggoikhac_ta;
    
                    }else{
    
                        $hopdong_update->donggoi_ta = $this->donggoi_ta;
    
                    }

                    // Nếu số TDG cũ khác với số TDG nhập mới
                    if($this->soTDGTam != $this->soTDG){

                        $hopdong_update->so_tdg = $this->soTDG;
    
                    }
                    

                    $hopdong_update->ngaylaphd = $this->ngaylaphd;
                    $hopdong_update->ngayhethanhd = Carbon::create($this->ngaylaphd)->addDays(45)->format('Y-m-d');
    
                    $hopdong_update->bena = $ben_a_hop_dong->id;
                    $hopdong_update->dai_dien_ben_a = $dai_dien_ben_a_hop_dong->id;
                    $hopdong_update->benb = $ben_b_hop_dong->id;

                    $ngan_hang = TaiKhoanNganHangNgoaiLe::where('ma_khach_hang', $this->makhachhangbenb)
                    ->where('cong_ty_chi_nhanh', $this->bena)
                    ->where('noi_dia_xuat_khau', 'xk')
                    ->first();

                    if($ngan_hang != null){

                        $hopdong_update->sotaikhoan_ta = $ngan_hang->so_tai_khoan_ta;
                        $hopdong_update->chutaikhoan_ta = $ngan_hang->chu_tai_khoan_ta;

                    }else{

                        $sotaikhoan = TaiKhoanNganHang::where('cong_ty_chi_nhanh' , $this->bena)
                            ->where('noi_dia_xuat_khau', 'xk')
                            ->first();

                        $hopdong_update->sotaikhoan_ta = $sotaikhoan->so_tai_khoan_ta;
                        $hopdong_update->chutaikhoan_ta = $sotaikhoan->chu_tai_khoan_ta;

                    }
    
                    $hopdong_update->chatluong_ta = $this->chatluong_ta;
                    $hopdong_update->phuongthucthanhtoan_ta = $this->phuongthucthanhtoan_ta;
                    $hopdong_update->diadiemgiaohang_ta = $this->diadiemgiaohang_ta;
                    $hopdong_update->diachi_diadiemgiaohang_ta = $this->diachi_diadiemgiaohang_ta;
                    $hopdong_update->thoigiangiaohang = $this->thoigiangiaohang;
                    $hopdong_update->giaohangtungphan = $this->giaohangtungphan;

                    $hopdong_update->cpt = $this->cpt;
    
                    $hopdong_update->username = Auth::user()->username;

                    $hopdong_update->tinhtrang = 'New';

                    $hopdong_update->save();
    
                    HopDongLog::create([
        
                        'sohd' => $this->shd,
                        'loaihopdong' => '3',
                        'so_tdg' => $hopdong_update->so_tdg,
                        
                        'ngaylaphd' => $this->ngaylaphd,
                        'ngayhethanhd' => Carbon::create($this->ngaylaphd)->addDays(45)->format('Y-m-d'),
        
                        'bena' => $ben_a_hop_dong->id,
                        'dai_dien_ben_a' => $dai_dien_ben_a_hop_dong->id,
                        'benb' => $ben_b_hop_dong->id,

                        'sotaikhoan_ta' => $hopdong_update->so_tai_khoan_ta,
                        'chutaikhoan_ta' => $hopdong_update->chu_tai_khoan_ta,
        
                        'chatluong_ta' => $hopdong_update->chatluong_ta,
                        'donggoi_ta' => $hopdong_update->donggoi_ta,
                        
                        'phuongthucthanhtoan_ta' => $this->phuongthucthanhtoan_ta,
                        'diadiemgiaohang_ta' => $this->diadiemgiaohang_ta,
                        'diachi_diadiemgiaohang_ta' => $this->diachi_diadiemgiaohang_ta,
                        'thoigiangiaohang' => $this->thoigiangiaohang,
                        'giaohangtungphan' => $this->giaohangtungphan,

                        'cpt' => $this->cpt,

                        'tinhtrang' => $hopdong_update->tinhtrang,

                        'username_approve' => $hopdong_update->username_approve,
        
                        'username' => Auth::user()->username,
            
                        'trangthai' => 'Sửa'
        
                    ]);
    
                    $sanpham = [
                        'sohd' => $this->shd,
                    ];
        
                    for ($i=1; $i <16 ; $i++) { 
        
                        if($this->{'quycach'.$i} != '' && $this->{'soluong'.$i} && $this->{'dongia'.$i}){
        
                            $temp = [
            
                                'quycach'.$i => $this->{'quycach'.$i},
                                'soluong'.$i => $this->{'soluong'.$i},
                                'dongia'.$i => $this->{'dongia'.$i},
            
                            ];
            
                            $sanpham = array_merge($sanpham, $temp);
        
                            $temp = [];
        
                        }
                        
                    }
        
                    $sanpham = array_merge($sanpham,['username' => Auth::user()->username]);
        
                    $sanphamlog = array_merge($sanpham,['username' => Auth::user()->username, 'trangthai' => 'Sửa']);
                    
                    SanPham::where('sohd', (string)$this->shd)
                        ->update($sanpham);
        
                    SanPhamLog::create($sanphamlog);
        
                    });

                    $this->storeFileAnnexDESIPRO();
        
                    flash()->addFlash('success', 'Sửa thành công HĐ : ' . $this->shd,'Thông báo');
                    $this->resetInputField();
                    $this->emit('updateHDXKTCTA');

            }
        }
    }

    #endregion

    #region Hợp đồng XKTCSN

    public function createHopDongXuatKhauTaiChoSongNgu(){

        $this->formSubmit = 'storeHopDongXuatKhauTaiChoSongNgu';
        $this->loaihopdong = '4';

    }

    public function storeHopDongXuatKhauTaiChoSongNgu(){

        // $laySoTDG = ModelsHopDong::where('so_tdg', $this->soTDG)->first();

        // if($laySoTDG != null){

        //     sweetalert()->addFlash('error', 'Số TDG/TTĐH đã được sử dụng','Thông báo');
        //     return;

        // }

        $TDG = DB::table('phieu_tdg')
        ->where('so_phieu', $this->soTDG)
        ->get();

        if($TDG->isEmpty()){

            $TTDH = DB::table('phieu_ttdh')
            ->where('so_phieu', $this->soTDG)
            ->get();

            if($TTDH->isEmpty()){

                sweetalert()->addFlash('error', 'Số TDG/TTĐH không tồn tại','Thông báo');
                return;

            }

        }

        $ngaylaphopdong = Carbon::create($this->ngaylaphd)->isoFormat('YYMMDD');

        $this->shd = IdGenerator::generate(['table' => 'hop_dong', 'field' => 'sohd', 'length' => '16', 'prefix' => 'TKY-' . $ngaylaphopdong . '/EX-','reset_on_prefix_change' => true]);

        if($this->makhachhangbenb == ''){

            flash()->addFlash('error', 'Không tìm thấy khách hàng này','Thông báo');

        }else{

            DB::transaction( function(){

                // if($this->soTDGsoTTDH == 'soTDGRadio'){

                //     $TDGorTTDH = 'DataFile-';

                // }else{

                //     $TDGorTTDH = 'TTDH-';

                // }

                $ben_a = BenA::where('id' , $this->bena)->first();
    
                $sotaikhoan = TaiKhoanNganHang::where('cong_ty_chi_nhanh' , $this->bena)
                                                ->where('noi_dia_xuat_khau', 'xk')
                                                ->first();
    
                $ben_a_hop_dong = BenAHopDong::create([
    
                    'sohd' => $this->shd,
                    'ma_cong_ty' => $this->bena,

                    'ten_tv' => $ben_a->ten_tv,
                    'dia_chi_tv' => $ben_a->dia_chi_tv,
                    'ma_so_thue_tv' => $ben_a->ma_so_thue_tv,
                    'dien_thoai_tv' => $ben_a->dien_thoai_tv,
                    'fax_tv' => $ben_a->fax_tv,

                    'ten_ta' => $ben_a->ten_ta,
                    'dia_chi_ta' => $ben_a->dia_chi_ta,

                ]);

                BenB::where('ma_khach_hang', $this->makhachhangbenb)->update([

                    'dia_chi_tv' => $this->diachibenb,
                    'ma_so_thue_tv' => $this->masothuebenb,
                    'tai_khoan_ngan_hang_tv' => $this->taikhoansobenb,
                    'dien_thoai_tv' => $this->sdtbenb,
                    'fax_tv' => $this->faxbenb,
                    'dai_dien_tv' => $this->daidienbenb,
                    'chuc_vu_tv' => $this->chucvudaidienbenb,
                    'giay_uy_quyen_tv' => $this->uyquyendaidienbenb,

                    'ten_ta' => $this->benb_ta,
                    'dia_chi_ta' => $this->diachibenb_ta,
                    'tai_khoan_ngan_hang_ta' => $this->taikhoansobenb_ta,
                    // 'dai_dien_ta' => $this->daidienbenb_ta,
                    // 'chuc_vu_ta' => $this->chucvudaidienbenb_ta,
    
                ]);
    
                $ben_b_hop_dong = BenBHopDong::create([
    
                    'sohd' => $this->shd,
                    'ma_khach_hang' => $this->makhachhangbenb,
    
                    'ten_tv' => $this->benb,
                    'dia_chi_tv' => $this->diachibenb,
                    'ma_so_thue_tv' => $this->masothuebenb,
                    'tai_khoan_ngan_hang_tv' => $this->taikhoansobenb,
                    'dien_thoai_tv' => $this->sdtbenb,
                    'fax_tv' => $this->faxbenb,
                    'dai_dien_tv' => $this->daidienbenb,
                    'chuc_vu_tv' => $this->chucvudaidienbenb,
                    'giay_uy_quyen_tv' => $this->uyquyendaidienbenb,

                    'ten_ta' => $this->benb_ta,
                    'dia_chi_ta' => $this->diachibenb_ta,
                    'tai_khoan_ngan_hang_ta' => $this->taikhoansobenb_ta,
                    // 'dai_dien_ta' => $this->daidienbenb_ta,
                    // 'chuc_vu_ta' => $this->chucvudaidienbenb_ta,

                    'check_ma_so_thue' => $this->check_ma_so_thue_ben_b,
                    'check_tai_khoan_ngan_hang' => $this->check_tai_khoan_ngan_hang_ben_b,
                    'check_dien_thoai' => $this->check_sdt_ben_b,
                    'check_fax' => $this->check_fax_ben_b,
                    'check_dai_dien' => $this->check_dai_dien_ben_b,
                    'check_giay_uy_quyen' => $this->check_uyquyen_ben_b,
                    
                ]);

                $dai_dien_ben_a = DaiDienBenA::where('id', $this->daidienbena)->first();

                $dai_dien_ben_a_hop_dong = DaiDienBenAHopDong::create([

                    'sohd' => $this->shd,
                    'dai_dien_id' => $this->daidienbena,
                    'ben_a_id' => $this->bena,
                    'dai_dien_tv' => $dai_dien_ben_a->dai_dien_tv,
                    'chuc_vu_tv'=> $dai_dien_ben_a->chuc_vu_tv,
                    'uy_quyen_tv'=> $dai_dien_ben_a->uy_quyen_tv,
                    'dai_dien_ta'=> $dai_dien_ben_a->dai_dien_ta,
                    'chuc_vu_ta'=> $dai_dien_ben_a->chuc_vu_ta,

                ]);

                $arr_hopdong = [

                    'sohd' => $this->shd,
                    'loaihopdong' => '4',
                    'so_tdg' => $this->soTDG,
                    
                    'ngaylaphd' => $this->ngaylaphd,
                    'ngayhethanhd' => Carbon::create($this->ngaylaphd)->addDays(45)->format('Y-m-d'),
    
                    'bena' => $ben_a_hop_dong->id,
                    'dai_dien_ben_a' => $dai_dien_ben_a_hop_dong->id,
                    'benb' => $ben_b_hop_dong->id,

                    'ben_nhan_ta' => $this->benNhanTA,
                    'ben_nhan_tv' => $this->benNhanTV,
                    'dia_chi_ben_nhan' => $this->diaChiBenNhan,
                    'sdt_ben_nhan' => $this->sdtBenNhan,
                    'dai_dien_ben_nhan' => $this->daiDienBenNhan,
                    'chuc_vu_ben_nhan' => $this->chucVuDaiDienBenNhan,
    
                    'sotaikhoan' => $sotaikhoan->so_tai_khoan_tv,
                    'chutaikhoan' => $sotaikhoan->chu_tai_khoan_tv,

                    'sotaikhoan_ta' => $sotaikhoan->so_tai_khoan_ta,
                    'chutaikhoan_ta' => $sotaikhoan->chu_tai_khoan_ta,
    
                    'tygia' => $this->tygia,
                    'chatluong' => $this->chatluong,
                    'chatluong_ta' => $this->chatluong_ta,

                    'thoigianthanhtoan' => $this->thoigianthanhtoan,
                    'thoigianthanhtoan_ta' => $this->thoigianthanhtoan_ta,

                    'phuongthucthanhtoan' => $this->phuongthucthanhtoan,
                    'phuongthucthanhtoan_ta' => $this->phuongthucthanhtoan_ta,

                    'diadiemgiaohang' => $this->diadiemgiaohang,
                    'diadiemgiaohang_ta' => $this->diadiemgiaohang_ta,

                    'diachi_diadiemgiaohang' => $this->diachi_diadiemgiaohang,
                    'diachi_diadiemgiaohang_ta' => $this->diachi_diadiemgiaohang_ta,

                    'thoigiangiaohang' => $this->thoigiangiaohang,

                    'giaohangtungphan' => $this->giaohangtungphan,

                    'phivanchuyen' => $this->phivanchuyen,
                    'phivanchuyen_ta' => $this->phivanchuyen_ta,
    
                    'soluongbanin' => $this->soluongbanin,

                    'tinhtrang' => 'New',
    
                    'username' => Auth::user()->username,

                ];

                // Đóng gói khác

                if($this->donggoikhac != ''){

                    $arr_hopdong = array_merge($arr_hopdong,[ 'donggoi' => $this->donggoikhac ]);

                }else{

                    $arr_hopdong = array_merge($arr_hopdong,[ 'donggoi' => $this->donggoi ]);

                }

                // Đóng gói khác TA

                if($this->donggoikhac_ta != ''){

                    $arr_hopdong = array_merge($arr_hopdong,[ 'donggoi_ta' => $this->donggoikhac_ta ]);

                }else{

                    $arr_hopdong = array_merge($arr_hopdong,[ 'donggoi_ta' => $this->donggoi_ta ]);

                }

                // Phương thức giao hàng khác

                if($this->phuongthucgiaohangkhac != ''){

                    $arr_hopdong = array_merge($arr_hopdong,[ 'phuongthucgiaohang' => $this->phuongthucgiaohangkhac ]);

                }else{

                    $arr_hopdong = array_merge($arr_hopdong,[ 'phuongthucgiaohang' => $this->phuongthucgiaohang ]);

                }

                // Phương thức giao hàng khác TA

                if($this->phuongthucgiaohangkhac_ta != ''){

                    $arr_hopdong = array_merge($arr_hopdong,[ 'phuongthucgiaohang_ta' => $this->phuongthucgiaohangkhac_ta ]);

                }else{

                    $arr_hopdong = array_merge($arr_hopdong,[ 'phuongthucgiaohang_ta' => $this->phuongthucgiaohang_ta ]);

                }
    
                ModelsHopDong::create($arr_hopdong);

                $arr_hopdong = array_merge($arr_hopdong,[ 'trangthai' => 'Tạo' ]);
    
                HopDongLog::create($arr_hopdong);
    
                $sanpham = [
                    'sohd' => $this->shd,
    
                    'quycach1' => $this->quycach1,
                    'soluong1' => $this->soluong1,
                    'dongia1' => $this->dongia1
                ];
    
                for ($i = 2; $i < 16 ; $i++) { 
    
                    if($this->{'quycach'.$i} != '' && $this->{'soluong'.$i} && $this->{'dongia'.$i}){
    
                        $temp = [
                            'quycach' . $i => $this->{'quycach'.$i},
                            'soluong' . $i => $this->{'soluong'.$i},
                            'dongia' . $i => $this->{'dongia'.$i}
                        ];
        
                        $sanpham = array_merge($sanpham,$temp);
        
                        $temp = [];
    
                    }
                    
                }
    
                SanPham::create(array_merge($sanpham,['username' => Auth::user()->username]));
    
                $sanphamlog = array_merge($sanpham,['trangthai' => 'Tạo','username' => Auth::user()->username]);
    
                SanPhamLog::create($sanphamlog);

                
            });

            Storage::disk('public')->makeDirectory('HD/' . str_replace('/','_',$this->shd));

            $this->storeFileHopDongXuatKhauTaiChoSongNgu();

            $taiKhoanDuyetCap1 = User::permission('approve_1_contracts')->first();
            //Mail::to('chloehsu@century.vn')->send(new NewContractMail('4', $this->shd , Auth::user()->username, Carbon::now()));
            Mail::to($taiKhoanDuyetCap1->email)->later(now()->addMinutes(1), new MailHopDong('created', '4', $this->shd , Auth::user()->username, Carbon::now(), ''));

            flash()->addFlash('success', 'Tạo thành công HĐ : ' . $this->shd,'Thông báo');
            $this->resetInputField();
            $this->emit('storeHDXKTCSN');

        }
    } 

    public function storeFileHopDongXuatKhauTaiChoSongNgu(){

        // Lấy thông tin bên A

        $bena = BenA::where('id', $this->bena)->get();
        $daidienbena = DaiDienBenA::where('id', $this->daidienbena)->first();

        $ngaylaphd = Carbon::create($this->ngaylaphd);

        $sotaikhoan = TaiKhoanNganHang::where('cong_ty_chi_nhanh' , $this->bena)
                                        ->where('noi_dia_xuat_khau', 'xk')
                                        ->first();

        $templateProcessor = new TemplateProcessor(public_path('HD/HDMB-XKTCSN.docx'));

        $values = [

            'ten_cong_ty' => $bena[0]->ten_ta,
            'dia_chi_cong_ty' => $bena[0]->dia_chi_ta,
            'so_hop_dong_tieng_viet' => $this->shd . ' (' . Carbon::create($this->ngaylaphd)->format('d/M/Y') . ')',
            'so_hop_dong_tieng_anh' => $this->shd . ' (' . Carbon::create($this->ngaylaphd)->format('d/m/Y') . ')',

        ];

        if($bena[0]->id == '1'){

              $values = array_merge($values, [

                    'dia_diem_tieng_anh' => 'Ho Chi Minh',
                    'ngay_thang_nam_tieng_anh' => $ngaylaphd->format('d M Y'),

                    'dia_diem_tieng_viet' => 'Hồ Chí Minh',
                    'ngay_thang_nam_tieng_viet' => 'ngày '. $ngaylaphd->format('d') .' tháng '. $ngaylaphd->format('m') .' năm '. $ngaylaphd->format('Y'),

              ]);  

        }else{

            $values = array_merge($values, [

                'dia_diem_tieng_anh' => 'Tay Ninh',
                'ngay_thang_nam_tieng_anh' => $ngaylaphd->format('d M Y'),

                'dia_diem_tieng_viet' => 'Tây Ninh',
                'ngay_thang_nam_tieng_viet' => 'ngày '. $ngaylaphd->format('d') .' tháng '. $ngaylaphd->format('m') .' năm '. $ngaylaphd->format('Y'),

          ]);  

        }

        $values = array_merge($values, [

            'ten_ben_a_tieng_anh' => $bena[0]->ten_ta,
            'ten_ben_a_tieng_viet' => $bena[0]->ten_tv,

            'dia_chi_ben_a_tieng_anh' => $bena[0]->dia_chi_ta,
            'dia_chi_ben_a_tieng_viet' => $bena[0]->dia_chi_tv,

            'sdt_ben_a' => $bena[0]->dien_thoai_tv, 
            'fax_ben_a' => $bena[0]->fax_tv, 
            'tax_code_ben_a' => $bena[0]->ma_so_thue_tv,

            'dai_dien_ben_a' => $daidienbena->dai_dien_ta,
            'chuc_vu_dai_dien_ben_a' => $daidienbena->chuc_vu_ta,
            'giay_uy_quyen' => $daidienbena->uy_quyen_tv,
            'giay_uy_quyen' => $daidienbena->uy_quyen_tv,

        ]);

        // Lấy thông tin bên B

        $values = array_merge($values,[

            'ben_b_tieng_anh' => str_replace("&", "&amp;",$this->benb_ta),
            'ben_b_tieng_viet' => str_replace("&", "&amp;",$this->benb),
            'dia_chi_ben_b_tieng_anh' => $this->diachibenb_ta,
            'dia_chi_ben_b_tieng_viet' => $this->diachibenb,

            // 'dai_dien_ben_b' => $this->daidienbenb_ta,
            // 'chuc_vu_dai_dien_ben_b' => $this->chucvudaidienbenb_ta,

        ]);

        if($this->check_ma_so_thue_ben_b == 1 && $this->masothuebenb != ''){

            $templateProcessor->cloneBlock('block_mst', 1, true, true);

            $values = array_merge($values,[

                'mst#1' => 'Tax code : ' . $this->masothuebenb,
    
            ]);
        }else{

            $templateProcessor->deleteBlock('block_mst');

        }

        if($this->check_sdt_ben_b == 1 && $this->sdtbenb != '' && $this->check_fax_ben_b == 1 && $this->faxbenb != ''){

            $templateProcessor->cloneBlock('block_sdt', 1, true, true);

            $values = array_merge($values,[

                'sdt#1' => 'Tel : ' . $this->sdtbenb . "\t\t\t" . 'Fax : ' . $this->faxbenb,
    
            ]);

        }elseif($this->check_sdt_ben_b == 1 && $this->sdtbenb != '' && $this->check_fax_ben_b == 0){

            $templateProcessor->cloneBlock('block_sdt', 1, true, true);

            $values = array_merge($values,[

                'sdt#1' => 'Tel : ' . $this->sdtbenb,
    
            ]);

        }elseif($this->check_fax_ben_b == 1 && $this->faxbenb != '' && $this->check_sdt_ben_b == 0){

            $templateProcessor->cloneBlock('block_sdt', 1, true, true);

            $values = array_merge($values,[

                'sdt#1' => 'Fax : ' . $this->faxbenb,
    
            ]);

        }else{

            $templateProcessor->deleteBlock('block_sdt');

        }

        // kiểm tra đại diện bên b

        if($this->check_dai_dien_ben_b == 1 && $this->daidienbenb != '' && $this->chucvudaidienbenb != ''){

            $templateProcessor->cloneBlock('block_dai_dien_ben_b', 1, true, true);

            $values = array_merge($values,[

                'dai_dien_ben_b#1' => "Represented by\t\t\t: " . $this->daidienbenb . "   -  Position : " . $this->chucvudaidienbenb,
    
            ]);

        }else{

            $templateProcessor->deleteBlock('block_dai_dien_ben_b');

        }

        // Kiểm tra check uy quyền

        if($this->check_uyquyen_ben_b == 1 && $this->uyquyendaidienbenb != ''){

            $templateProcessor->cloneBlock('block_uy_quyen_ben_b', 1, true, true);

            $values = array_merge($values,[

                'uy_quyen_ben_b#1' => '(POA NO ' . $this->uyquyendaidienbenb . ')',
    
            ]);

        }else{

            $templateProcessor->deleteBlock('block_uy_quyen_ben_b');

        }

        // Kiểm tra bên nhận

        if($this->benNhanTA != ''){

            $templateProcessor->cloneBlock('block_ben_nhan', 1, true, true);

            $values = array_merge($values,[

                'ben_nhan_ta#1' => str_replace("&", "&amp;",$this->benNhanTA),
                'ben_nhan_tv#1' => str_replace("&", "&amp;",$this->benNhanTV),
                'dia_chi_ben_nhan#1' => $this->diaChiBenNhan,
    
            ]);

            if($this->sdtBenNhan != ''){

                $templateProcessor->cloneBlock('block_sdt_ben_nhan', 1, true, true);

                $values = array_merge($values,[

                    'sdt_ben_nhan#1' => $this->sdtBenNhan,
        
                ]);

            }else{

                $templateProcessor->deleteBlock('block_sdt_ben_nhan');

            }

            if($this->daiDienBenNhan != ''){

                $templateProcessor->cloneBlock('block_dai_dien_ben_nhan', 1, true, true);

                $values = array_merge($values,[

                    'dai_dien_ben_nhan#1' => "Represented by\t\t\t: " . $this->daiDienBenNhan . "   -  Position : " . $this->chucVuDaiDienBenNhan,
        
                ]);

            }else{

                $templateProcessor->deleteBlock('block_dai_dien_ben_nhan');

            }

        }else{

            $templateProcessor->deleteBlock('block_ben_nhan');

        }

        $sanpham = SanPham::where('sohd', $this->shd)->get();

        $sanpham->transform(function ($item) {

            $item['sumthanhtien'] = $item['soluong1'] * $item['dongia1'] + $item['soluong2'] * $item['dongia2']+ $item['soluong3'] * $item['dongia3']+ $item['soluong4'] * $item['dongia4']
            + $item['soluong5'] * $item['dongia5']+ $item['soluong6'] * $item['dongia6']+ $item['soluong7'] * $item['dongia7']+ $item['soluong8'] * $item['dongia8']+ $item['soluong9'] * $item['dongia9']
            + $item['soluong10'] * $item['dongia10']+ $item['soluong11'] * $item['dongia11']+ $item['soluong12'] * $item['dongia12']+ $item['soluong13'] * $item['dongia13']+ $item['soluong14'] * $item['dongia14']
            + $item['soluong15'] * $item['dongia15'];

            $item['sumsoluong'] = $item['soluong1'] + $item['soluong2'] + $item['soluong3'] + $item['soluong4'] + $item['soluong5'] + $item['soluong6'] + $item['soluong7'] + 
            $item['soluong8'] + $item['soluong9'] + $item['soluong10'] + $item['soluong11'] + $item['soluong12'] + $item['soluong13'] + $item['soluong14'] + $item['soluong15'];

            return $item;
        });

        $sanpham->all();

        $san_pham_values = [];

        for ($i=1; $i <16 ; $i++) { 

            if($sanpham[0]->{'quycach' . $i} != '' && $sanpham[0]->{'soluong' . $i} != '' && $sanpham[0]->{'dongia' . $i} != ''){

                $san_pham_values = array_merge($san_pham_values,[

                    [
                        'san_pham' => str_replace("\r\n", "<w:br/>", $sanpham[0]->{'quycach' . $i}),
                        'so_luong' => number_format($sanpham[0]->{'soluong' . $i},2),
                        'don_gia' => $sanpham[0]->{'dongia' . $i},
                        'thanh_tien' => number_format($sanpham[0]->{'soluong' . $i} * $sanpham[0]->{'dongia' . $i},2),
                    ],

                ]);

            }
        }

        $converter_tieng_anh = new Converter("", "",Language::ENGLISH);   

        $converter_tieng_viet = new Converter("đồng chẵn", "",Language::VIETNAMESE);

        $hethanhopdong = Carbon::create($this->thoigiangiaohang)->addDay(45);

        $thoigiangiaohang = Carbon::create($this->thoigiangiaohang);

        //Đóng gói khác tiếng việt
        if($this->donggoi == 'Khác'){

            $values = array_merge($values,['dong_goi_tieng_viet' => $this->donggoikhac]);

        }else{

            $values = array_merge($values,['dong_goi_tieng_viet' => $this->donggoi]);

        }

        //Đóng gói khác tiếng anh
        if($this->donggoi_ta == 'Other'){

            $values = array_merge($values,['dong_goi_tieng_anh' => $this->donggoikhac_ta]);

        }else{

            $values = array_merge($values,['dong_goi_tieng_anh' => $this->donggoi_ta]);

        }

        // PTGH TV

        if($this->phuongthucgiaohang == 'Khác'){

            $values = array_merge($values,['phuong_thuc_giao_hang_tieng_viet' => $this->phuongthucgiaohangkhac]);

        }else{

            $values = array_merge($values,['phuong_thuc_giao_hang_tieng_viet' => $this->phuongthucgiaohang]);

        }

        // PTGH TA

        if($this->phuongthucgiaohang_ta == 'Other'){

            $values = array_merge($values,['phuong_thuc_giao_hang_tieng_anh' => $this->phuongthucgiaohangkhac_ta]);

        }else{

            $values = array_merge($values,['phuong_thuc_giao_hang_tieng_anh' => $this->phuongthucgiaohang_ta]);

        }

        $values = array_merge($values, [

            'total_amount' => number_format($sanpham[0]->sumthanhtien,2),
            'cpt' => $this->cpt,
            'tong_so_luong' => number_format($sanpham[0]->sumsoluong,2),
            'thanh_tien_bang_chu_tieng_anh' => ucfirst($converter_tieng_anh->convert($sanpham[0]->sumthanhtien)),
            'thanh_tien_bang_chu_tieng_viet' => ucfirst(str_replace([' chỉ một', 'linh'],['', 'lẻ'],$converter_tieng_viet->convert($sanpham[0]->sumthanhtien))),
            'chat_luong_tieng_anh' => $this->chatluong_ta,
            'chat_luong_tieng_viet' => $this->chatluong,
            'dia_diem_giao_hang_tieng_anh' => $this->diadiemgiaohang_ta,
            'dia_chi_dia_diem_giao_hang_tieng_anh' => $this->diachi_diadiemgiaohang_ta,
            'dia_diem_giao_hang_tieng_viet' => $this->diadiemgiaohang,
            'dia_chi_dia_diem_giao_hang_tieng_viet' => $this->diachi_diadiemgiaohang,
            'thoi_gian_giao_hang_tieng_anh' => 'Before ' . $thoigiangiaohang->format('d M Y'),
            'thoi_gian_giao_hang_tieng_viet' => "Trước ngày " . $thoigiangiaohang->format('d') . " tháng " . $thoigiangiaohang->format('m') . " năm " . $thoigiangiaohang->format('Y') . ".",
            'chi_phi_van_chuyen_tieng_anh' => $this->phivanchuyen_ta,
            'chi_phi_van_chuyen_tieng_viet' => $this->phivanchuyen,
            'ben_a_tieng_anh' => $sotaikhoan->chu_tai_khoan_ta,
            'stk_ben_a_tieng_anh' => $sotaikhoan->so_tai_khoan_ta,
            'ben_a_tieng_viet' => $sotaikhoan->chu_tai_khoan_tv,
            'stk_ben_a_tieng_viet' => $sotaikhoan->so_tai_khoan_tv,
            'ngay_thang_nam_tieng_anh_2' => $hethanhopdong->format('d M Y'),
            'ngay_thang_nam_tieng_viet_2' => 'ngày'. $hethanhopdong->format('d') .' tháng '. $hethanhopdong->format('m') .' năm '. $hethanhopdong->format('Y'),
            'so_luong_ban_in' => str_pad($this->soluongbanin, 2, '0', STR_PAD_LEFT),
            'so_luong_ban_in_chia_2' => str_pad($this->soluongbanin / 2, 2, '0', STR_PAD_LEFT),

            'phuong_thuc_thanh_toan_tieng_anh' => $this->phuongthucthanhtoan_ta,
            'phuong_thuc_thanh_toan_tieng_viet' => $this->phuongthucthanhtoan,
        ]);

        if($this->giaohangtungphan == '1'){

            $templateProcessor->cloneBlock('block_giao_hang_tung_phan', 1, true, true);

            $values = array_merge($values,[

                'giao_tung_phan_tieng_anh#1' => 'Allowed.',
                'giao_tung_phan_tieng_viet#1' => 'Cho phép.',
    
            ]);

        }elseif($this->giaohangtungphan == '2'){

            $templateProcessor->cloneBlock('block_giao_hang_tung_phan', 1, true, true);

            $values = array_merge($values,[

                'giao_tung_phan_tieng_anh#1' => 'Not Allowed',
                'giao_tung_phan_tieng_viet#1' => 'Không cho phép.',
    
            ]);

        }else{

            $templateProcessor->deleteBlock('block_giao_hang_tung_phan');

        }

        $templateProcessor->setValues($values);

        $templateProcessor->cloneRowAndSetValues('san_pham', $san_pham_values);

        $templateProcessor->saveAs(storage_path('app/public/HD/') . str_replace('/','_',$this->shd) . '/' . str_replace('/','_',$this->shd) .'.docx');

    }

    public function editHopDongXuatKhauTaiChoSongNgu($sohd){

        $this->formSubmit = 'updateHopDongXuatKhauTaiChoSongNgu';

        $this->loaihopdong = '4';

        $hd = ModelsHopDong::where('sohd', $sohd)->first();

        $ben_a_hop_dong = BenAHopDong::where('id', $hd->bena)->first();

        $this->shd = $sohd;
        $this->ngaylaphd = $hd->ngaylaphd;
        $this->soTDG = $hd->so_tdg;
        
        $this->soTDGTam = $hd->so_tdg;
        

        $this->bena = $ben_a_hop_dong->ma_cong_ty;

        $dai_dien_ben_a_hop_dong = DaiDienBenAHopDong::where('id' , $hd->dai_dien_ben_a)->first();
        $this->daidienbena = $dai_dien_ben_a_hop_dong->dai_dien_id;

        $selectDongGoi = DongGoi::where('donggoi', $hd->donggoi)->get();
        $selectPTGH = PhuongThucGiaoHang::where('phuongthucgiaohang', $hd->phuongthucgiaohang)->get();

        $selectDongGoi_ta = DongGoi::where('donggoi_ta', $hd->donggoi_ta)->get();
        $selectPTGH_ta = PhuongThucGiaoHang::where('phuongthucgiaohang_ta', $hd->phuongthucgiaohang_ta)->get();

        //Đóng gói khác
        if($selectDongGoi->count() == 0){

            $this->donggoi = 'Khác';
            $this->donggoikhac = $hd->donggoi;

        }else{

            $this->donggoi = $hd->donggoi;
            $this->donggoikhac = '';

        }

        //Đóng gói khác TA
        if($selectDongGoi_ta->count() == 0){

            $this->donggoi_ta = 'Other';
            $this->donggoikhac_ta = $hd->donggoi_ta;

        }else{

            $this->donggoi_ta = $hd->donggoi_ta;
            $this->donggoikhac_ta = '';

        }


        // PTGH khác
        if($selectPTGH->count() == 0){

            $this->phuongthucgiaohang = 'Khác';
            $this->phuongthucgiaohangkhac = $hd->phuongthucgiaohang;

        }else{

            $this->phuongthucgiaohang = $hd->phuongthucgiaohang;
            $this->phuongthucgiaohangkhac = '';

        }

        // PTGH khác TA
        if($selectPTGH_ta->count() == 0){

            $this->phuongthucgiaohang_ta = 'Other';
            $this->phuongthucgiaohangkhac_ta = $hd->phuongthucgiaohang_ta;

        }else{

            $this->phuongthucgiaohang_ta = $hd->phuongthucgiaohang_ta;
            $this->phuongthucgiaohangkhac_ta = '';

        }

        $ben_b_hop_dong = BenBHopDong::where('id', $hd->benb)->first();
        $this->makhachhangbenb = $ben_b_hop_dong->ma_khach_hang;
        $this->benb = $ben_b_hop_dong->ten_tv;
        $this->diachibenb = $ben_b_hop_dong->dia_chi_tv;
        $this->masothuebenb = $ben_b_hop_dong->ma_so_thue_tv;
        $this->sdtbenb = $ben_b_hop_dong->dien_thoai_tv;
        $this->faxbenb = $ben_b_hop_dong->fax_tv;
        $this->daidienbenb = $ben_b_hop_dong->dai_dien_tv;
        $this->chucvudaidienbenb = $ben_b_hop_dong->chuc_vu_tv;
        $this->uyquyendaidienbenb = $ben_b_hop_dong->giay_uy_quyen_tv;

        $this->benb_ta = $ben_b_hop_dong->ten_ta;
        $this->diachibenb_ta = $ben_b_hop_dong->dia_chi_ta;
        // $this->daidienbenb_ta = $ben_b_hop_dong->dai_dien_ta;
        // $this->chucvudaidienbenb_ta = $ben_b_hop_dong->chuc_vu_ta;

        $this->check_ma_so_thue_ben_b = $ben_b_hop_dong->check_ma_so_thue;
        $this->check_tai_khoan_ngan_hang_ben_b = $ben_b_hop_dong->check_tai_khoan_ngan_hang;
        $this->check_sdt_ben_b = $ben_b_hop_dong->check_dien_thoai;
        $this->check_fax_ben_b = $ben_b_hop_dong->check_fax;
        $this->check_dai_dien_ben_b = $ben_b_hop_dong->check_dai_dien;
        $this->check_uyquyen_ben_b = $ben_b_hop_dong->check_giay_uy_quyen;

        $this->benNhanTA = $hd->ben_nhan_ta;
        $this->benNhanTV = $hd->ben_nhan_tv;
        $this->diaChiBenNhan = $hd->dia_chi_ben_nhan;
        $this->sdtBenNhan = $hd->sdt_ben_nhan;
        $this->daiDienBenNhan = $hd->dai_dien_ben_nhan;
        $this->chucVuDaiDienBenNhan = $hd->chuc_vu_ben_nhan;

        if($this->benNhanTA != ''){

            $this->cbBenNhan = '1';

        }else{

            $this->cbBenNhan = '';

        }

        $this->tygia = $hd->tygia;
        $this->chatluong = $hd->chatluong;
        $this->thoigianthanhtoan = $hd->thoigianthanhtoan;
        $this->phuongthucthanhtoan = $hd->phuongthucthanhtoan;
        $this->diadiemgiaohang = $hd->diadiemgiaohang;
        $this->diachi_diadiemgiaohang = $hd->diachi_diadiemgiaohang;
        $this->thoigiangiaohang = $hd->thoigiangiaohang;
        $this->phivanchuyen = $hd->phivanchuyen;

        $this->chatluong_ta = $hd->chatluong_ta;
        $this->thoigianthanhtoan_ta = $hd->thoigianthanhtoan_ta;
        $this->phuongthucthanhtoan_ta = $hd->phuongthucthanhtoan_ta;
        $this->diadiemgiaohang_ta = $hd->diadiemgiaohang_ta;
        $this->diachi_diadiemgiaohang_ta = $hd->diachi_diadiemgiaohang_ta;
        $this->phivanchuyen_ta = $hd->phivanchuyen_ta;

        $this->giaohangtungphan = $hd->giaohangtungphan;

        $this->soluongbanin = $hd->soluongbanin;

        $this->cpt = $hd->cpt;
        $this->po = $hd->po;

        $sanpham = SanPham::where('sohd', $this->shd)->get();

        for ($i=1; $i <16 ; $i++) { 
            
            $this->{'quycach'.$i} = $sanpham[0]->{'quycach'.$i};
            $this->{'soluong'.$i} = $sanpham[0]->{'soluong'.$i};
            $this->{'dongia'.$i} = $sanpham[0]->{'dongia'.$i};

        }

    }

    public function updateHopDongXuatKhauTaiChoSongNgu(){
        
        if($this->shd){

            if($this->makhachhangbenb == ''){

                flash()->addFlash('error', 'Không tìm thấy khách hàng này','Thông báo');
    
            }else{

                if($this->soTDGTam != $this->soTDG){

                    $laySoTDG = ModelsHopDong::where('so_tdg', $this->soTDG)->first();
        
                    if($laySoTDG != null){
        
                        flash()->addFlash('error', 'Số TDG/TTĐH đã được sử dụng','Thông báo');
                        return;
        
                    }
        
                    $TDG = DB::table('phieu_tdg')
                    ->where('so_phieu', $this->soTDG)
                    ->get();
        
                    if($TDG->isEmpty()){
        
                        $TTDH = DB::table('phieu_ttdh')
                        ->where('so_phieu', $this->soTDG)
                        ->get();
        
                        if($TTDH->isEmpty()){
        
                            sweetalert()->addFlash('error', 'Số TDG/TTĐH không tồn tại','Thông báo');
                            return;
        
                        }
        
                    }
        
                }

                DB::transaction( function(){

                    $ben_a = BenA::where('id' , $this->bena)->first();
    
                    $sotaikhoan = TaiKhoanNganHang::where('cong_ty_chi_nhanh' , $this->bena)
                                                    ->where('noi_dia_xuat_khau', 'xk')
                                                    ->first();
        
                    $ben_a_hop_dong = BenAHopDong::create([
        
                        'sohd' => $this->shd,
                        'ma_cong_ty' => $this->bena,

                        'ten_tv' => $ben_a->ten_tv,
                        'dia_chi_tv' => $ben_a->dia_chi_tv,
                        'ma_so_thue_tv' => $ben_a->ma_so_thue_tv,
                        'dien_thoai_tv' => $ben_a->dien_thoai_tv,
                        'fax_tv' => $ben_a->fax_tv,

                        'ten_ta' => $ben_a->ten_ta,
                        'dia_chi_ta' => $ben_a->dia_chi_ta,
        
                    ]);

                    BenB::where('ma_khach_hang', $this->makhachhangbenb)->update([
        
                        'dia_chi_tv' => $this->diachibenb,
                        'ma_so_thue_tv' => $this->masothuebenb,
                        'tai_khoan_ngan_hang_tv' => $this->taikhoansobenb,
                        'dien_thoai_tv' => $this->sdtbenb,
                        'fax_tv' => $this->faxbenb,
                        'dai_dien_tv' => $this->daidienbenb,
                        'chuc_vu_tv' => $this->chucvudaidienbenb,
                        'giay_uy_quyen_tv' => $this->uyquyendaidienbenb,

                        'ten_ta' => $this->benb_ta,
                        'dia_chi_ta' => $this->diachibenb_ta,
                        'tai_khoan_ngan_hang_ta' => $this->taikhoansobenb_ta,
                        // 'dai_dien_ta' => $this->daidienbenb_ta,
                        // 'chuc_vu_ta' => $this->chucvudaidienbenb_ta,
        
                    ]);
        
                    $ben_b_hop_dong = BenBHopDong::create([
        
                        'sohd' => $this->shd,
                        'ma_khach_hang' => $this->makhachhangbenb,
        
                        'ten_tv' => $this->benb,
                        'dia_chi_tv' => $this->diachibenb,
                        'ma_so_thue_tv' => $this->masothuebenb,
                        'tai_khoan_ngan_hang_tv' => $this->taikhoansobenb,
                        'dien_thoai_tv' => $this->sdtbenb,
                        'fax_tv' => $this->faxbenb,
                        'dai_dien_tv' => $this->daidienbenb,
                        'chuc_vu_tv' => $this->chucvudaidienbenb,
                        'giay_uy_quyen_tv' => $this->uyquyendaidienbenb,

                        'ten_ta' => $this->benb_ta,
                        'dia_chi_ta' => $this->diachibenb_ta,
                        'tai_khoan_ngan_hang_ta' => $this->taikhoansobenb_ta,
                        // 'dai_dien_ta' => $this->daidienbenb_ta,
                        // 'chuc_vu_ta' => $this->chucvudaidienbenb_ta,

                        'check_ma_so_thue' => $this->check_ma_so_thue_ben_b,
                        'check_tai_khoan_ngan_hang' => $this->check_tai_khoan_ngan_hang_ben_b,
                        'check_dien_thoai' => $this->check_sdt_ben_b,
                        'check_fax' => $this->check_fax_ben_b,
                        'check_dai_dien' => $this->check_dai_dien_ben_b,
                        'check_giay_uy_quyen' => $this->check_uyquyen_ben_b,
                        
                    ]);

                    $dai_dien_ben_a = DaiDienBenA::where('id', $this->daidienbena)->first();

                    $dai_dien_ben_a_hop_dong = DaiDienBenAHopDong::create([

                        'sohd' => $this->shd,
                        'dai_dien_id' => $this->daidienbena,
                        'ben_a_id' => $this->bena,
                        'dai_dien_tv' => $dai_dien_ben_a->dai_dien_tv,
                        'chuc_vu_tv'=> $dai_dien_ben_a->chuc_vu_tv,
                        'uy_quyen_tv'=> $dai_dien_ben_a->uy_quyen_tv,
                        'dai_dien_ta'=> $dai_dien_ben_a->dai_dien_ta,
                        'chuc_vu_ta'=> $dai_dien_ben_a->chuc_vu_ta,

                    ]);

                    $hopdong_update = ModelsHopDong::where('sohd', $this->shd)->first();

                    // Đóng gói khác
                    if($this->donggoikhac != ''){
    
                        $hopdong_update->donggoi = $this->donggoikhac;
    
                    }else{
    
                        $hopdong_update->donggoi = $this->donggoi;
    
                    }

                    // Đóng gói khác TA
                    if($this->donggoikhac_ta != ''){
    
                        $hopdong_update->donggoi_ta = $this->donggoikhac;
    
                    }else{
    
                        $hopdong_update->donggoi_ta = $this->donggoi_ta;
    
                    }
                    
                    // ptth khác
                    if($this->phuongthucgiaohangkhac != ''){
    
                        $hopdong_update->phuongthucgiaohang = $this->phuongthucgiaohangkhac;
    
                    }else{
    
                        $hopdong_update->phuongthucgiaohang = $this->phuongthucgiaohang;
    
                    }

                    // ptgh khác
                    if($this->phuongthucgiaohangkhac_ta != ''){
    
                        $hopdong_update->phuongthucgiaohang_ta = $this->phuongthucgiaohangkhac_ta;
    
                    }else{
    
                        $hopdong_update->phuongthucgiaohang_ta = $this->phuongthucgiaohang_ta;
    
                    }

                    // Nếu số TDG cũ khác với số TDG nhập mới
                    if($this->soTDGTam != $this->soTDG){

                        $hopdong_update->so_tdg = $this->soTDG;
    
                    }
                    

                    $hopdong_update->ngaylaphd = $this->ngaylaphd;
                    $hopdong_update->ngayhethanhd = Carbon::create($this->ngaylaphd)->addDays(45)->format('Y-m-d');
    
                    $hopdong_update->bena = $ben_a_hop_dong->id;
                    $hopdong_update->dai_dien_ben_a = $dai_dien_ben_a_hop_dong->id;
                    $hopdong_update->benb = $ben_b_hop_dong->id;

                    $hopdong_update->ben_nhan_ta = $this->benNhanTA;
                    $hopdong_update->ben_nhan_tv = $this->benNhanTV;
                    $hopdong_update->dia_chi_ben_nhan = $this->diaChiBenNhan;
                    $hopdong_update->sdt_ben_nhan = $this->sdtBenNhan;
                    $hopdong_update->dai_dien_ben_nhan = $this->daiDienBenNhan;
                    $hopdong_update->chuc_vu_ben_nhan = $this->chucVuDaiDienBenNhan;
    
                    $hopdong_update->sotaikhoan = $sotaikhoan->so_tai_khoan_tv;
                    $hopdong_update->chutaikhoan = $sotaikhoan->chu_tai_khoan_tv;

                    $hopdong_update->sotaikhoan_ta = $sotaikhoan->so_tai_khoan_ta;
                    $hopdong_update->chutaikhoan_ta = $sotaikhoan->chu_tai_khoan_ta;
    
                    $hopdong_update->tygia = $this->tygia;
                    $hopdong_update->chatluong = $this->chatluong;
                    $hopdong_update->chatluong_ta = $this->chatluong_ta;

                    $hopdong_update->thoigianthanhtoan = $this->thoigianthanhtoan;
                    $hopdong_update->thoigianthanhtoan_ta = $this->thoigianthanhtoan_ta;

                    $hopdong_update->phuongthucthanhtoan = $this->phuongthucthanhtoan;
                    $hopdong_update->phuongthucthanhtoan_ta = $this->phuongthucthanhtoan_ta;

                    $hopdong_update->diadiemgiaohang = $this->diadiemgiaohang;
                    $hopdong_update->diadiemgiaohang_ta = $this->diadiemgiaohang_ta;

                    $hopdong_update->diachi_diadiemgiaohang = $this->diachi_diadiemgiaohang;
                    $hopdong_update->diachi_diadiemgiaohang_ta = $this->diachi_diadiemgiaohang_ta;

                    $hopdong_update->thoigiangiaohang = $this->thoigiangiaohang;

                    $hopdong_update->giaohangtungphan = $this->giaohangtungphan;

                    $hopdong_update->phivanchuyen = $this->phivanchuyen;
                    $hopdong_update->phivanchuyen_ta = $this->phivanchuyen_ta;
    
                    $hopdong_update->soluongbanin = $this->soluongbanin;
    
                    $hopdong_update->username = Auth::user()->username;

                    $hopdong_update->tinhtrang = 'New';

                    $hopdong_update->save();
    
                    HopDongLog::create([
        
                        'sohd' => $this->shd,
                        'loaihopdong' => '4',
                        'so_tdg' => $hopdong_update->so_tdg,
                        
                        'ngaylaphd' => $this->ngaylaphd,
                        'ngayhethanhd' => Carbon::create($this->ngaylaphd)->addDays(45)->format('Y-m-d'),
        
                        'bena' => $ben_a_hop_dong->id,
                        'dai_dien_ben_a' => $dai_dien_ben_a_hop_dong->id,
                        'benb' => $ben_b_hop_dong->id,

                        'ben_nhan_ta' => $this->benNhanTA,
                        'ben_nhan_tv' => $this->benNhanTV,
                        'dia_chi_ben_nhan' => $this->diaChiBenNhan,
                        'sdt_ben_nhan' >= $this->sdtBenNhan,
                        'dai_dien_ben_nhan' => $this->daiDienBenNhan,
                        'chuc_vu_ben_nhan' => $this->chucVuDaiDienBenNhan,
        
                        'sotaikhoan' => $sotaikhoan->so_tai_khoan_tv,
                        'chutaikhoan' => $sotaikhoan->chu_tai_khoan_tv,

                        'sotaikhoan_ta' => $sotaikhoan->so_tai_khoan_ta,
                        'chutaikhoan_ta' => $sotaikhoan->chu_tai_khoan_ta,
        
                        'tygia' => $this->tygia,
                        'chatluong' => $hopdong_update->chatluong,
                        'chatluong_ta' => $hopdong_update->chatluong_ta,

                        'donggoi' => $hopdong_update->donggoi,
                        'donggoi_ta' => $hopdong_update->donggoi_ta,

                        'thoigianthanhtoan' => $this->thoigianthanhtoan,
                        'thoigianthanhtoan_ta' => $this->thoigianthanhtoan_ta,

                        'phuongthucthanhtoan' => $this->phuongthucthanhtoan,
                        'phuongthucthanhtoan_ta' => $this->phuongthucthanhtoan_ta,

                        'diadiemgiaohang' => $this->diadiemgiaohang,
                        'diadiemgiaohang_ta' => $this->diadiemgiaohang_ta,

                        'diachi_diadiemgiaohang' => $this->diachi_diadiemgiaohang,
                        'diachi_diadiemgiaohang_ta' => $this->diachi_diadiemgiaohang_ta,

                        'thoigiangiaohang' => $this->thoigiangiaohang,
                        
                        'phuongthucgiaohang' => $hopdong_update->phuongthucgiaohang,
                        'phuongthucgiaohang_ta' => $hopdong_update->phuongthucgiaohang_ta,

                        'giaohangtungphan' => $this->giaohangtungphan,

                        'phivanchuyen' => $this->phivanchuyen,
                        'phivanchuyen_ta' => $this->phivanchuyen_ta,
        
                        'soluongbanin' => $this->soluongbanin,

                        'tinhtrang' => $hopdong_update->tinhtrang,

                        'username_approve' => $hopdong_update->username_approve,
        
                        'username' => Auth::user()->username,
            
                        'trangthai' => 'Sửa'
        
                    ]);
    
                    $sanpham = [
                        'sohd' => $this->shd,
                    ];
        
                    for ($i=1; $i <16 ; $i++) { 
        
                        if($this->{'quycach'.$i} != '' && $this->{'soluong'.$i} && $this->{'dongia'.$i}){
        
                            $temp = [
            
                                'quycach'.$i => $this->{'quycach'.$i},
                                'soluong'.$i => $this->{'soluong'.$i},
                                'dongia'.$i => $this->{'dongia'.$i},
            
                            ];
            
                            $sanpham = array_merge($sanpham, $temp);
        
                            $temp = [];
        
                        }
                        
                    }
        
                    $sanpham = array_merge($sanpham,['username' => Auth::user()->username]);
        
                    $sanphamlog = array_merge($sanpham,['username' => Auth::user()->username, 'trangthai' => 'Sửa']);
                    
                    SanPham::where('sohd', (string)$this->shd)
                        ->update($sanpham);
        
                    SanPhamLog::create($sanphamlog);
        
                    });

                    $this->storeFileHopDongXuatKhauTaiChoSongNgu();
        
                    flash()->addFlash('success', 'Sửa thành công HĐ : ' . $this->shd,'Thông báo');
                    $this->resetInputField();
                    $this->emit('updateHDNDSN');

            }
        }
    }

    #endregion

    #region Hợp đồng XKTT

    public function createHopDongXuatKhauTrucTiep(){

        $this->formSubmit = 'storeHopDongXuatKhauTrucTiep';
        $this->loaihopdong = '5';

    }

    public function storeHopDongXuatKhauTrucTiep(){

        // $laySoTDG = ModelsHopDong::where('so_tdg', $this->soTDG)->first();

        // if($laySoTDG != null){

        //     sweetalert()->addFlash('error', 'Số TDG/TTĐH đã được sử dụng','Thông báo');
        //     return;

        // }

        $TDG = DB::table('phieu_tdg')
        ->where('so_phieu', $this->soTDG)
        ->get();

        if($TDG->isEmpty()){

            $TTDH = DB::table('phieu_ttdh')
            ->where('so_phieu', $this->soTDG)
            ->get();

            if($TTDH->isEmpty()){

                sweetalert()->addFlash('error', 'Số TDG/TTĐH không tồn tại','Thông báo');
                return;

            }

        }

        $ngaylaphopdong = Carbon::create($this->ngaylaphd)->isoFormat('YYMMDD');

        $this->shd = IdGenerator::generate(['table' => 'hop_dong', 'field' => 'sohd', 'length' => '16', 'prefix' => 'TKY-' . $ngaylaphopdong . '/EX-','reset_on_prefix_change' => true]);

        if($this->makhachhangbenb == ''){

            flash()->addFlash('error', 'Không tìm thấy khách hàng này','Thông báo');

        }else{

            DB::transaction( function(){

                $ben_a = BenA::where('id' , $this->bena)->first();
    
                $ben_a_hop_dong = BenAHopDong::create([
    
                    'sohd' => $this->shd,
                    'ma_cong_ty' => $this->bena,

                    'ten_tv' => $ben_a->ten_tv,
                    'ten_ta' => $ben_a->ten_ta,

                    'dia_chi_tv' => $ben_a->dia_chi_tv,
                    'dia_chi_ta' => $ben_a->dia_chi_ta,

                    'ma_so_thue_tv' => $ben_a->ma_so_thue_tv,
                    'dien_thoai_tv' => $ben_a->dien_thoai_tv,
                    'fax_tv' => $ben_a->fax_tv,
    
                ]);

                BenB::where('ma_khach_hang', $this->makhachhangbenb)->update([

                    'dien_thoai_tv' => $this->sdtbenb,
                    'fax_tv' => $this->faxbenb,

                    'ten_ta' => $this->benb_ta,
                    'dia_chi_ta' => $this->diachibenb_ta,
    
                ]);
    
                $ben_b_hop_dong = BenBHopDong::create([
    
                    'sohd' => $this->shd,
                    'ma_khach_hang' => $this->makhachhangbenb,
    
                    'ten_tv' => $this->benb,
                    'ten_ta' => $this->benb_ta,
                    'dia_chi_ta' => $this->diachibenb_ta,

                    'dien_thoai_tv' => $this->sdtbenb,
                    'fax_tv' => $this->faxbenb,
                    'dai_dien_tv' => $this->daidienbenb,
                    'chuc_vu_tv' => $this->chucvudaidienbenb,

                    'check_dien_thoai' => $this->check_sdt_ben_b,
                    'check_fax' => $this->check_fax_ben_b,
                    'check_dai_dien' => $this->check_dai_dien_ben_b,
                    'check_giay_uy_quyen' => $this->check_uyquyen_ben_b,
                    
                ]);

                $dai_dien_ben_a = DaiDienBenA::where('id', $this->daidienbena)->first();

                $dai_dien_ben_a_hop_dong = DaiDienBenAHopDong::create([

                    'sohd' => $this->shd,
                    'dai_dien_id' => $this->daidienbena,
                    'ben_a_id' => $this->bena,
                    'uy_quyen_tv'=> $dai_dien_ben_a->uy_quyen_tv,
                    'dai_dien_ta'=> $dai_dien_ben_a->dai_dien_ta,
                    'chuc_vu_ta'=> $dai_dien_ben_a->chuc_vu_ta,

                ]);

                $arr_hopdong = [

                    'sohd' => $this->shd,
                    'loaihopdong' => '5',
                    'so_tdg' => $this->soTDG,
                    
                    'ngaylaphd' => $this->ngaylaphd,
                    'ngayhethanhd' => Carbon::create($this->ngaylaphd)->addDays(30)->format('Y-m-d'),
    
                    'bena' => $ben_a_hop_dong->id,
                    'dai_dien_ben_a' => $dai_dien_ben_a_hop_dong->id,
                    'benb' => $ben_b_hop_dong->id,

                    'ben_nhan_ta' => $this->benNhanTA,
                    'ben_nhan_tv' => $this->benNhanTV,
                    'dia_chi_ben_nhan' => $this->diaChiBenNhan,
                    'sdt_ben_nhan' => $this->sdtBenNhan,
                    'dai_dien_ben_nhan' => $this->daiDienBenNhan,
                    'chuc_vu_ben_nhan' => $this->chucVuDaiDienBenNhan,

                    'chatluong_ta' => $this->chatluong_ta,
                    'trungchuyen' => $this->trungchuyen,
                    'loadingport' => $this->loadingport,
                    'dischargport' => $this->dischargport,
                    'phuongthucthanhtoan_ta' => $this->phuongthucthanhtoan_ta,
                    'thoigiangiaohang' => $this->thoigiangiaohang,
                    'giaohangtungphan' => $this->giaohangtungphan,
    
                    'soluongbanin' => $this->soluongbanin,

                    'cpt' => $this->cpt,
                    'po' => $this->po,

                    'tinhtrang' => 'New',
    
                    'username' => Auth::user()->username,

                ];

                $ngan_hang = TaiKhoanNganHangNgoaiLe::where('ma_khach_hang', $this->makhachhangbenb)
                                                    ->where('cong_ty_chi_nhanh', $this->bena)
                                                    ->where('noi_dia_xuat_khau', 'xk')
                                                    ->first();

                if($ngan_hang != null){

                    $arr_hopdong = array_merge($arr_hopdong,[ 

                        'sotaikhoan_ta' => $ngan_hang->so_tai_khoan_ta,
                        'chutaikhoan_ta' => $ngan_hang->chu_tai_khoan_ta,

                    ]);

                }else{

                    $sotaikhoan = TaiKhoanNganHang::where('cong_ty_chi_nhanh' , $this->bena)
                                                ->where('noi_dia_xuat_khau', 'xk')
                                                ->first();

                    $arr_hopdong = array_merge($arr_hopdong,[ 

                        'sotaikhoan_ta' => $sotaikhoan->so_tai_khoan_ta,
                        'chutaikhoan_ta' => $sotaikhoan->chu_tai_khoan_ta,

                    ]);
                
                }

                if($this->donggoikhac_ta != ''){

                    $arr_hopdong = array_merge($arr_hopdong,[ 'donggoi_ta' => $this->donggoikhac_ta ]);

                }else{

                    $arr_hopdong = array_merge($arr_hopdong,[ 'donggoi_ta' => $this->donggoi_ta ]);

                }
    
                ModelsHopDong::create($arr_hopdong);

                $arr_hopdong = array_merge($arr_hopdong,[ 'trangthai' => 'Tạo' ]);
    
                HopDongLog::create($arr_hopdong);
    
                $sanpham = [
                    'sohd' => $this->shd,
    
                    'quycach1' => $this->quycach1,
                    'soluong1' => $this->soluong1,
                    'dongia1' => $this->dongia1
                ];
    
                for ($i = 2; $i < 16 ; $i++) { 
    
                    if($this->{'quycach'.$i} != '' && $this->{'soluong'.$i} && $this->{'dongia'.$i}){
    
                        $temp = [
                            'quycach' . $i => $this->{'quycach'.$i},
                            'soluong' . $i => $this->{'soluong'.$i},
                            'dongia' . $i => $this->{'dongia'.$i}
                        ];
        
                        $sanpham = array_merge($sanpham,$temp);
        
                        $temp = [];
    
                    }
                    
                }
    
                SanPham::create(array_merge($sanpham,['username' => Auth::user()->username]));
    
                $sanphamlog = array_merge($sanpham,['trangthai' => 'Tạo','username' => Auth::user()->username]);
    
                SanPhamLog::create($sanphamlog);

                
            });

            Storage::disk('public')->makeDirectory('HD/' . str_replace('/','_',$this->shd));

            $this->storeFileHopDongXuatKhauTrucTiep();
            $taiKhoanDuyetCap1 = User::permission('approve_1_contracts')->first();
            //Mail::to('chloehsu@century.vn')->send(new NewContractMail('5', $this->shd , Auth::user()->username, Carbon::now()));
            Mail::to($taiKhoanDuyetCap1->email)->later(now()->addMinutes(1), new MailHopDong('created', '5', $this->shd , Auth::user()->username, Carbon::now(), ''));

            flash()->addFlash('success', 'Tạo thành công HĐ : ' . $this->shd,'Thông báo');
            $this->resetInputField();
            $this->emit('storeHDXKTT');

        }
    }

    public function storeFileHopDongXuatKhauTrucTiep(){

        $templateProcessor = new TemplateProcessor(public_path('HD/HDMB-XKTT.docx'));

        $values = [

            'so_hop_dong' => $this->shd,
            'ngay_lap_hop_dong' => Carbon::create($this->ngaylaphd)->format('d M Y'),

        ];

        if($this->po != ''){

            $templateProcessor->cloneBlock('block_po', 1, true, true);

            $values = array_merge($values,[

                'po#1' => "Po : " . $this->po,
    
            ]);

        }else{

            $templateProcessor->deleteBlock('block_po');

        }

        // Lấy thông tin bên A

        $bena = BenA::where('id', $this->bena)->get();
        $daidienbena = DaiDienBenA::where('id', $this->daidienbena)->get();

        $values = array_merge($values,[

            'ben_a' => $bena[0]->ten_ta,
            'dia_chi_ben_a' => $bena[0]->dia_chi_ta,
            'sdt_ben_a' => $bena[0]->dien_thoai_tv,
            'dai_dien_ben_a' => $daidienbena[0]->dai_dien_ta,
            'chuc_vu_dai_dien_ben_a' => $daidienbena[0]->chuc_vu_ta,
            'giay_uy_quyen_ben_a' => $daidienbena[0]->uy_quyen_tv,

        ]);

        // Lấy thông tin bên B

        $values = array_merge($values,[

            'ben_b' => str_replace("&", "&amp;",$this->benb_ta),
            'dia_chi_ben_b' => str_replace("&", "&amp;",$this->diachibenb_ta),
            'sdt_ben_b' => $this->sdtbenb,
            'fax_ben_b' => $this->faxbenb,

            // 'dai_dien_ben_b' => $this->daidienbenb_ta,
            // 'chuc_vu_dai_dien_ben_b' => $this->chucvudaidienbenb_ta,
        ]);

        // kiểm tra sđt bên b

        if($this->sdtbenb != '' && $this->faxbenb != ''){

            $templateProcessor->cloneBlock('block_sdt_ben_b', 1, true, true);

            $values = array_merge($values,[

                'sdt_ben_b#1' => "Tel\t\t\t: " . $this->sdtbenb . "   -  Fax : " . $this->faxbenb,
    
            ]);

        }elseif($this->sdtbenb != '' && $this->faxbenb == ''){

            $templateProcessor->cloneBlock('block_sdt_ben_b', 1, true, true);

            $values = array_merge($values,[

                'sdt_ben_b#1' => "Tel\t\t\t: " . $this->sdtbenb,
    
            ]);

        }elseif($this->sdtbenb == '' && $this->faxbenb != ''){

            $templateProcessor->cloneBlock('block_sdt_ben_b', 1, true, true);

            $values = array_merge($values,[

                'sdt_ben_b#1' => "Fax\t\t\t: " . $this->faxbenb,
    
            ]);

        }else{

            $templateProcessor->deleteBlock('block_sdt_ben_b');

        }

        // kiểm tra đại diện bên b

        if($this->check_dai_dien_ben_b == 1 && $this->daidienbenb != '' && $this->chucvudaidienbenb != ''){

            $templateProcessor->cloneBlock('block_dai_dien_ben_b', 1, true, true);

            $values = array_merge($values,[

                'dai_dien_ben_b#1' => "Represented by\t\t\t: " . $this->daidienbenb . "   -  Position : " . $this->chucvudaidienbenb,
    
            ]);

        }else{

            $templateProcessor->deleteBlock('block_dai_dien_ben_b');

        }

        // Kiểm tra bên nhận

        if($this->benNhanTA != ''){

            $templateProcessor->cloneBlock('block_ben_nhan', 1, true, true);

            $values = array_merge($values,[

                'ben_nhan_ta#1' => str_replace("&", "&amp;",$this->benNhanTA),
                'ben_nhan_tv#1' => str_replace("&", "&amp;",$this->benNhanTV),
                'dia_chi_ben_nhan#1' => $this->diaChiBenNhan,
    
            ]);

            if($this->sdtBenNhan != ''){

                $templateProcessor->cloneBlock('block_sdt_ben_nhan', 1, true, true);

                $values = array_merge($values,[

                    'sdt_ben_nhan#1' => $this->sdtBenNhan,
        
                ]);

            }else{

                $templateProcessor->deleteBlock('block_sdt_ben_nhan');

            }

            if($this->daiDienBenNhan != ''){

                $templateProcessor->cloneBlock('block_dai_dien_ben_nhan', 1, true, true);

                $values = array_merge($values,[

                    'dai_dien_ben_nhan#1' => "Represented by\t\t\t: " . $this->daiDienBenNhan . "   -  Position : " . $this->chucVuDaiDienBenNhan,
        
                ]);

            }else{

                $templateProcessor->deleteBlock('block_dai_dien_ben_nhan');

            }

        }else{

            $templateProcessor->deleteBlock('block_ben_nhan');

        }

        // Kiểm tra giao từng phần
        
        if($this->giaohangtungphan == '1'){

            $templateProcessor->cloneBlock('block_giao_tung_phan', 1, true, true);

            $values = array_merge($values,[

                'giao_tung_phan_tieng_anh#1' => 'Partial shipment: Allowed',
    
            ]);

        }elseif($this->giaohangtungphan == '2'){

            $templateProcessor->cloneBlock('block_giao_tung_phan', 1, true, true);

            $values = array_merge($values,[

                'giao_tung_phan_tieng_anh#1' => 'Partial shipment: Not Allowed',
    
            ]);

        }else{

            $templateProcessor->deleteBlock('block_giao_tung_phan');

        }

        // Kiểm tra trung chuyển

        if($this->trungchuyen != ''){

            $templateProcessor->cloneBlock('block_trung_chuyen', 1, true, true);

            $values = array_merge($values,[

                'trung_chuyen#1' => 'Transshipment     :  ' . $this->trungchuyen,
    
            ]);

        }else{

            $templateProcessor->deleteBlock('block_trung_chuyen');

        }

        //Sản phẩm

        $sanpham = SanPham::where('sohd', $this->shd)->get();

        

        $sanpham->transform(function ($item) {

            $item['sumthanhtien'] = $item['soluong1'] * $item['dongia1'] + $item['soluong2'] * $item['dongia2']+ $item['soluong3'] * $item['dongia3']+ $item['soluong4'] * $item['dongia4']
            + $item['soluong5'] * $item['dongia5']+ $item['soluong6'] * $item['dongia6']+ $item['soluong7'] * $item['dongia7']+ $item['soluong8'] * $item['dongia8']+ $item['soluong9'] * $item['dongia9']
            + $item['soluong10'] * $item['dongia10']+ $item['soluong11'] * $item['dongia11']+ $item['soluong12'] * $item['dongia12']+ $item['soluong13'] * $item['dongia13']+ $item['soluong14'] * $item['dongia14']
            + $item['soluong15'] * $item['dongia15'];

            $item['sumsoluong'] = $item['soluong1'] + $item['soluong2'] + $item['soluong3'] + $item['soluong4'] + $item['soluong5'] + $item['soluong6'] + $item['soluong7'] + 
            $item['soluong8'] + $item['soluong9'] + $item['soluong10'] + $item['soluong11'] + $item['soluong12'] + $item['soluong13'] + $item['soluong14'] + $item['soluong15'];

            return $item;
        });

        $sanpham->all();

        $san_pham_values = [];

        for ($i=1; $i <16 ; $i++) { 

            if($sanpham[0]->{'quycach' . $i} != '' && $sanpham[0]->{'soluong' . $i} != '' && $sanpham[0]->{'dongia' . $i} != ''){

                $san_pham_values = array_merge($san_pham_values,[

                    [
                        'san_pham' => str_replace("\n", "<w:br/>", $sanpham[0]->{'quycach' . $i}),
                        'so_luong' => number_format($sanpham[0]->{'soluong' . $i},2),
                        'don_gia' => $sanpham[0]->{'dongia' . $i},
                        'thanh_tien' => number_format($sanpham[0]->{'soluong' . $i} * $sanpham[0]->{'dongia' . $i},2),
                    ],

                ]);

            }
        }

        

        $thoigiangiaohang = Carbon::create($this->thoigiangiaohang);

        $values = array_merge($values, [

            'total_amount' => number_format($sanpham[0]->sumthanhtien,2),
            'cpt' => $this->cpt,
            'CPT' => $this->cpt,

            'loading_port' => $this->loadingport,
            'discharg_port' => $this->dischargport,
            'thoi_gian_giao_hang' => " Before " . $thoigiangiaohang->format('d M Y'),
            
            'chat_luong' => str_replace("\n", "<w:br/>", $this->chatluong_ta),

            'phuong_thuc_thanh_toan' => $this->phuongthucthanhtoan_ta,

            'so_ban_in' => str_pad($this->soluongbanin, 2, '0', STR_PAD_LEFT),
            'ngay_het_han_hop_dong' => $thoigiangiaohang->addDay(30)->format('d M Y')

        ]);

        $ngan_hang = TaiKhoanNganHangNgoaiLe::where('ma_khach_hang', $this->makhachhangbenb)
                                                    ->where('cong_ty_chi_nhanh', $this->bena)
                                                    ->where('noi_dia_xuat_khau', 'xk')
                                                    ->first();

        if($ngan_hang != null){

            $values = array_merge($values,[ 

                'so_tai_khoan_ben_a' => $ngan_hang->so_tai_khoan_ta,
                'chu_tai_khoan' => $ngan_hang->chu_tai_khoan_ta,

                ]);

        }else{

            $sotaikhoan = TaiKhoanNganHang::where('cong_ty_chi_nhanh' , $this->bena)
                        ->where('noi_dia_xuat_khau', 'xk')
                        ->first();

            $values = array_merge($values,[ 

                'so_tai_khoan_ben_a' => $sotaikhoan->so_tai_khoan_ta,
                'chu_tai_khoan' => $sotaikhoan->chu_tai_khoan_ta,

            ]);

        }

        // Đóng gói

        if($this->donggoi_ta == 'Other'){

            $values = array_merge($values,['dong_goi' => $this->donggoikhac_ta]);

        }else{

            $values = array_merge($values,['dong_goi' => $this->donggoi_ta]);

        }

        $templateProcessor->setValues($values);

        $templateProcessor->cloneRowAndSetValues('san_pham', $san_pham_values);

        $templateProcessor->saveAs(storage_path('app/public/HD/') . str_replace('/','_',$this->shd) . '/' . str_replace('/','_',$this->shd) .'.docx');

    }

    public function editHopDongXuatKhauTrucTiep($sohd){

        $this->formSubmit = 'updateHopDongXuatKhauTrucTiep';

        $this->loaihopdong = '5';

        $hd = ModelsHopDong::where('sohd', $sohd)->first();

        $ben_a_hop_dong = BenAHopDong::where('id', $hd->bena)->first();

        $this->shd = $sohd;
        $this->ngaylaphd = $hd->ngaylaphd;

        $this->soTDG = $hd->so_tdg;
        
        $this->soTDGTam = $hd->so_tdg;
        

        $this->bena = $ben_a_hop_dong->ma_cong_ty;

        $dai_dien_ben_a_hop_dong = DaiDienBenAHopDong::where('id' , $hd->dai_dien_ben_a)->first();
        $this->daidienbena = $dai_dien_ben_a_hop_dong->dai_dien_id;

        $ben_b_hop_dong = BenBHopDong::where('id', $hd->benb)->first();

        $this->makhachhangbenb = $ben_b_hop_dong->ma_khach_hang;
        $this->benb = $ben_b_hop_dong->ten_tv;
        $this->benb_ta = $ben_b_hop_dong->ten_ta;
        $this->diachibenb_ta = $ben_b_hop_dong->dia_chi_ta;

        $this->sdtbenb = $ben_b_hop_dong->dien_thoai_tv;
        $this->faxbenb = $ben_b_hop_dong->fax_tv;
        $this->daidienbenb = $ben_b_hop_dong->dai_dien_tv;
        $this->chucvudaidienbenb = $ben_b_hop_dong->chuc_vu_tv;

        $this->benNhanTA = $hd->ben_nhan_ta;
        $this->benNhanTV = $hd->ben_nhan_tv;
        $this->diaChiBenNhan = $hd->dia_chi_ben_nhan;
        $this->sdtBenNhan = $hd->sdt_ben_nhan;
        $this->daiDienBenNhan = $hd->dai_dien_ben_nhan;
        $this->chucVuDaiDienBenNhan = $hd->chuc_vu_ben_nhan;

        if($this->benNhanTA != ''){

            $this->cbBenNhan = '1';

        }else{

            $this->cbBenNhan = '';

        }

        $this->check_sdt_ben_b = $ben_b_hop_dong->check_dien_thoai;
        $this->check_fax_ben_b = $ben_b_hop_dong->check_fax;
        $this->check_dai_dien_ben_b = $ben_b_hop_dong->check_dai_dien;
        $this->check_uyquyen_ben_b = $ben_b_hop_dong->check_giay_uy_quyen;
        // $this->daidienbenb_ta = $ben_b_hop_dong->dai_dien_ta;
        // $this->chucvudaidienbenb_ta = $ben_b_hop_dong->chuc_vu_ta;
        $this->thoigiangiaohang = $hd->thoigiangiaohang;
        $this->phuongthucthanhtoan_ta = $hd->phuongthucthanhtoan_ta;
        $this->chatluong_ta = $hd->chatluong_ta;

        //$selectChatluong = ChatLuong::where('chatluong', $hd->chatluong_ta)->get();
        $selectDongGoi_ta = DongGoi::where('donggoi_ta', $hd->donggoi_ta)->get();

        // if($selectChatluong->count() == 0){

        //     $this->chatluong_ta = 'Khác';
        //     $this->chatluongkhac_ta = $hd->chatluong_ta;

        // }else{

        //     $this->chatluong_ta = $hd->chatluong_ta;
        //     $this->chatluongkhac_ta = '';

        // }

        if($selectDongGoi_ta->count() == 0){

            $this->donggoi_ta = 'Other';
            $this->donggoikhac_ta = $hd->donggoi_ta;

        }else{

            $this->donggoi_ta = $hd->donggoi_ta;
            $this->donggoikhac_ta = '';

        }

        $this->trungchuyen = $hd->trungchuyen;
        $this->loadingport = $hd->loadingport;
        $this->dischargport = $hd->dischargport;

        $this->giaohangtungphan = $hd->giaohangtungphan;

        $this->soluongbanin = $hd->soluongbanin;

        $this->cpt = $hd->cpt;
        $this->po = $hd->po;

        $sanpham = SanPham::where('sohd', $this->shd)->get();

        for ($i=1; $i <16 ; $i++) { 
            
            $this->{'quycach'.$i} = $sanpham[0]->{'quycach'.$i};
            $this->{'soluong'.$i} = $sanpham[0]->{'soluong'.$i};
            $this->{'dongia'.$i} = $sanpham[0]->{'dongia'.$i};

        }

    }

    public function updateHopDongXuatKhauTrucTiep(){
        
        if($this->shd){

            if($this->makhachhangbenb == ''){

                flash()->addFlash('error', 'Không tìm thấy khách hàng này','Thông báo');
    
            }else{

                if($this->soTDGTam != $this->soTDG){

                    $laySoTDG = ModelsHopDong::where('so_tdg', $this->soTDG)->first();
        
                    if($laySoTDG != null){
        
                        flash()->addFlash('error', 'Số TDG/TTĐH đã được sử dụng','Thông báo');
                        return;
        
                    }
        
                    $TDG = DB::table('phieu_tdg')
                    ->where('so_phieu', $this->soTDG)
                    ->get();
        
                    if($TDG->isEmpty()){
        
                        $TTDH = DB::table('phieu_ttdh')
                        ->where('so_phieu', $this->soTDG)
                        ->get();
        
                        if($TTDH->isEmpty()){
        
                            sweetalert()->addFlash('error', 'Số TDG/TTĐH không tồn tại','Thông báo');
                            return;
        
                        }
        
                    }
        
                }

                DB::transaction( function(){

                    $ben_a = BenA::where('id' , $this->bena)->first();
        
                    $ben_a_hop_dong = BenAHopDong::create([
        
                        'sohd' => $this->shd,
                        'ma_cong_ty' => $this->bena,

                        'ten_tv' => $ben_a->ten_tv,
                        'ten_ta' => $ben_a->ten_ta,

                        'dia_chi_tv' => $ben_a->dia_chi_tv,
                        'dia_chi_ta' => $ben_a->dia_chi_ta,

                        'ma_so_thue_tv' => $ben_a->ma_so_thue_tv,
                        'dien_thoai_tv' => $ben_a->dien_thoai_tv,
                        'fax_tv' => $ben_a->fax_tv,
        
                    ]);

                    BenB::where('ma_khach_hang', $this->makhachhangbenb)->update([

                        'dien_thoai_tv' => $this->sdtbenb,
                        'fax_tv' => $this->faxbenb,
                        'ten_ta' => $this->benb_ta,
                        'dia_chi_ta' => $this->diachibenb_ta,
                        // 'dai_dien_ta' => $this->daidienbenb_ta,
                        // 'chuc_vu_ta' => $this->chucvudaidienbenb_ta,
        
                    ]);
        
                    $ben_b_hop_dong = BenBHopDong::create([
        
                        'sohd' => $this->shd,
                        'ma_khach_hang' => $this->makhachhangbenb,
        
                        'ten_tv' => $this->benb,
                        'ten_ta' => $this->benb_ta,
                        'dia_chi_ta' => $this->diachibenb_ta,

                        'dien_thoai_tv' => $this->sdtbenb,
                        'fax_tv' => $this->faxbenb,
                        'dai_dien_tv' => $this->daidienbenb,
                        'chuc_vu_tv' => $this->chucvudaidienbenb,

                        'check_dien_thoai' => $this->check_sdt_ben_b,
                        'check_fax' => $this->check_fax_ben_b,
                        'check_dai_dien' => $this->check_dai_dien_ben_b,
                        'check_giay_uy_quyen' => $this->check_uyquyen_ben_b,

                        // 'dai_dien_ta' => $this->daidienbenb_ta,
                        // 'chuc_vu_ta' => $this->chucvudaidienbenb_ta,
                        
                    ]);

                    $dai_dien_ben_a = DaiDienBenA::where('id', $this->daidienbena)->first();

                    $dai_dien_ben_a_hop_dong = DaiDienBenAHopDong::create([

                        'sohd' => $this->shd,
                        'dai_dien_id' => $this->daidienbena,
                        'ben_a_id' => $this->bena,
                        'uy_quyen_tv'=> $dai_dien_ben_a->uy_quyen_tv,
                        'dai_dien_ta'=> $dai_dien_ben_a->dai_dien_ta,
                        'chuc_vu_ta'=> $dai_dien_ben_a->chuc_vu_ta,

                    ]);

                    $hopdong_update = ModelsHopDong::where('sohd', $this->shd)->first();

                    $hopdong_update->ngaylaphd = $this->ngaylaphd;
                    $hopdong_update->ngayhethanhd = Carbon::create($this->ngaylaphd)->addDays(30)->format('Y-m-d');
    
                    $hopdong_update->bena = $ben_a_hop_dong->id;
                    $hopdong_update->dai_dien_ben_a = $dai_dien_ben_a_hop_dong->id;
                    $hopdong_update->benb = $ben_b_hop_dong->id;

                    $hopdong_update->ben_nhan_ta = $this->benNhanTA;
                    $hopdong_update->ben_nhan_tv = $this->benNhanTV;
                    $hopdong_update->dia_chi_ben_nhan = $this->diaChiBenNhan;
                    $hopdong_update->sdt_ben_nhan = $this->sdtBenNhan;
                    $hopdong_update->dai_dien_ben_nhan = $this->daiDienBenNhan;
                    $hopdong_update->chuc_vu_ben_nhan = $this->chucVuDaiDienBenNhan;

                    $ngan_hang = TaiKhoanNganHangNgoaiLe::where('ma_khach_hang', $this->makhachhangbenb)
                                                    ->where('cong_ty_chi_nhanh', $this->bena)
                                                    ->where('noi_dia_xuat_khau', 'xk')
                                                    ->first();

                    if($ngan_hang != null){

                        $hopdong_update->sotaikhoan_ta = $ngan_hang->so_tai_khoan_ta;
                        $hopdong_update->chutaikhoan_ta = $ngan_hang->chu_tai_khoan_ta;

                    }else{

                        $sotaikhoan = TaiKhoanNganHang::where('cong_ty_chi_nhanh' , $this->bena)
                                    ->where('noi_dia_xuat_khau', 'xk')
                                    ->first();

                        $hopdong_update->sotaikhoan_ta = $sotaikhoan->so_tai_khoan_ta;
                        $hopdong_update->chutaikhoan_ta = $sotaikhoan->chu_tai_khoan_ta;

                    }
    
                    if($this->donggoikhac_ta != ''){
    
                        $hopdong_update->donggoi_ta = $this->donggoikhac_ta;
    
                    }else{
    
                        $hopdong_update->donggoi_ta = $this->donggoi_ta;
    
                    }

                    // Nếu số TDG cũ khác với số TDG nhập mới
                    if($this->soTDGTam != $this->soTDG){

                        $hopdong_update->so_tdg = $this->soTDG;
    
                    }

                    $hopdong_update->chatluong_ta = $this->chatluong_ta;
                    $hopdong_update->trungchuyen = $this->trungchuyen;
                    $hopdong_update->loadingport = $this->loadingport;
                    $hopdong_update->dischargport = $this->dischargport;

                    $hopdong_update->phuongthucthanhtoan_ta = $this->phuongthucthanhtoan_ta;
                    $hopdong_update->thoigiangiaohang = $this->thoigiangiaohang;
                    $hopdong_update->giaohangtungphan = $this->giaohangtungphan;
    
                    $hopdong_update->soluongbanin = $this->soluongbanin;

                    $hopdong_update->cpt = $this->cpt;

                    $hopdong_update->po = $this->po;
    
                    $hopdong_update->username = Auth::user()->username;

                    $hopdong_update->tinhtrang = 'New';

                    $hopdong_update->save();
    
                    HopDongLog::create([
        
                        'sohd' => $this->shd,
                        'loaihopdong' => '5',
                        'so_tdg' => $hopdong_update->so_tdg,
                        
                        'ngaylaphd' => $this->ngaylaphd,
                        'ngayhethanhd' => Carbon::create($this->ngaylaphd)->addDays(30)->format('Y-m-d'),
    
                        'bena' => $ben_a_hop_dong->id,
                        'dai_dien_ben_a' => $dai_dien_ben_a_hop_dong->id,
                        'benb' => $ben_b_hop_dong->id,

                        'ben_nhan_ta' => $this->benNhanTA,
                        'ben_nhan_tv' => $this->benNhanTV,
                        'dia_chi_ben_nhan' => $this->diaChiBenNhan,
                        'sdt_ben_nhan' >= $this->sdtBenNhan,
                        'dai_dien_ben_nhan' => $this->daiDienBenNhan,
                        'chuc_vu_ben_nhan' => $this->chucVuDaiDienBenNhan,

                        'sotaikhoan_ta' => $hopdong_update->sotaikhoan_ta,
                        'chutaikhoan_ta' => $hopdong_update->chutaikhoan_ta,
        
                        'chatluong_ta' => $hopdong_update->chatluong_ta,
                        'donggoi_ta' => $hopdong_update->donggoi_ta,
                        'phuongthucthanhtoan_ta' => $hopdong_update->phuongthucthanhtoan_ta,
                        
                        'trungchuyen' => $this->trungchuyen,
                        'loadingport' => $this->loadingport,
                        'dischargport' => $this->dischargport,

                        'thoigiangiaohang' => $this->thoigiangiaohang,
                        'giaohangtungphan' => $this->giaohangtungphan,
        
                        'soluongbanin' => $this->soluongbanin,

                        'cpt' => $this->cpt,
                        'po' => $this->po,

                        'tinhtrang' => $hopdong_update->tinhtrang,

                        'username_approve' => $hopdong_update->username_approve,
        
                        'username' => Auth::user()->username,
            
                        'trangthai' => 'Sửa'
        
                    ]);
    
                    $sanpham = [
                        'sohd' => $this->shd,
                    ];
        
                    for ($i=1; $i <16 ; $i++) { 
        
                        if($this->{'quycach'.$i} != '' && $this->{'soluong'.$i} && $this->{'dongia'.$i}){
        
                            $temp = [
            
                                'quycach'.$i => $this->{'quycach'.$i},
                                'soluong'.$i => $this->{'soluong'.$i},
                                'dongia'.$i => $this->{'dongia'.$i},
            
                            ];
            
                            $sanpham = array_merge($sanpham, $temp);
        
                            $temp = [];
        
                        }
                        
                    }
        
                    $sanpham = array_merge($sanpham,['username' => Auth::user()->username]);
        
                    $sanphamlog = array_merge($sanpham,['username' => Auth::user()->username, 'trangthai' => 'Sửa']);
                    
                    SanPham::where('sohd', (string)$this->shd)
                        ->update($sanpham);
        
                    SanPhamLog::create($sanphamlog);
        
                    });

                    $this->storeFileHopDongXuatKhauTrucTiep();
        
                    flash()->addFlash('success', 'Sửa thành công HĐ : ' . str_replace('_', '/',$this->shd),'Thông báo');
                    $this->resetInputField();
                    $this->emit('updateHDXKTT');

            }
        }
    }

    #endregion

    public function taifileHD($sohd, $tenfile){

        $hopdong = ModelsHopDong::where('sohd', $sohd)->first();

        if($hopdong->loaihopdong == '1' || $hopdong->loaihopdong == '2'){

            return response()->download(storage_path('app/public/HD/') . $sohd . '/' . $tenfile);

        }else{
        
            return response()->download(storage_path('app/public/HD/') . str_replace('/', '_', $sohd) . '/' . str_replace('/', '_', $tenfile));
        
        }
    }

    public function taifilePhuluc($sohd, $tenfile){

        $hopdong = ModelsHopDong::where('sohd', $sohd)->first();

        if($hopdong->loaihopdong == '1' || $hopdong->loaihopdong == '2'){

            return response()->download(storage_path('app/public/Addendum/') . $sohd . '/' . $tenfile);

        }else{
        
            return response()->download(storage_path('app/public/Addendum/') . str_replace('/', '_', $sohd) . '/' . str_replace('/', '_', $tenfile));
        
        }
    }

    public function taifileTDG($so_tdg){

        if(substr($so_tdg, 0, 3) == 'TDG')
            return Storage::disk('ftp')->download('TDG/' . $so_tdg . '/' . $so_tdg . '.xlsx');
        elseif(substr($so_tdg, 0, 3) == 'TTD')
            return Storage::disk('ftp')->download('TTDH/' . $so_tdg . '/' . $so_tdg . '.xlsx');
    }

    public function chiTietHopDong($sohd){

        $this->sohd_chitiethopdong = $sohd;

    }

    public function deleteConfirm($shd, $loaihopdong){

        $this->shd = $shd;
        $this->loaihopdong = $loaihopdong;

    }

    public function delete(){

        if($this->shd){

            DB::transaction( function (){

                // Thao tác xóa hợp đồng

                $hd =  ModelsHopDong::where('sohd', $this->shd)->first();

                HopDongLog::create([

                    'sohd' => $this->shd,
                    'loaihopdong' => $hd->loaihopdong,
                    'ngaylaphd' => $hd->ngaylaphd,
                    'ngayhethanhd' => $hd->ngayhethanhd,
                    'so_tdg' => $hd->so_tdg,
    
                    'bena' => $hd->bena,
                    'dai_dien_ben_a' => $hd->dai_dien_ben_a,
                    'benb' => $hd->benb,
    
                    'sotaikhoan' => $hd->sotaikhoan,
                    'chutaikhoan' => $hd->chutaikhoan,

                    'sotaikhoan_ta' => $hd->sotaikhoan_ta,
                    'chutaikhoan_ta' => $hd->chutaikhoan_ta,
    
                    'tygia' => $hd->tygia,
                    'chatluong' => $hd->chatluong,
                    'chatluong_ta' => $hd->chatluong_ta,

                    'thoigianthanhtoan' => $hd->thoigianthanhtoan,
                    'thoigianthanhtoan_ta' => $hd->thoigianthanhtoan_ta,

                    'phuongthucthanhtoan' => $hd->phuongthucthanhtoan,
                    'phuongthucthanhtoan_ta' => $hd->phuongthucthanhtoan_ta,

                    'diadiemgiaohang' => $hd->diadiemgiaohang,
                    'diadiemgiaohang_ta' => $hd->diadiemgiaohang_ta,

                    'diachi_diadiemgiaohang' => $hd->diachi_diadiemgiaohang,
                    'diachi_diadiemgiaohang_ta' => $hd->diachi_diadiemgiaohang_ta,

                    'thoigiangiaohang' => $hd->thoigiangiaohang,
                    
                    'phuongthucgiaohang' => $hd->phuongthucgiaohang,
                    'phuongthucgiaohang_ta' => $hd->phuongthucgiaohang_ta,

                    'giaohangtungphan' => $hd->giaohangtungphan,

                    'phivanchuyen' => $hd->phivanchuyen,
                    'phivanchuyen_ta' => $hd->phivanchuyen_ta,
    
                    'soluongbanin' => $hd->soluongbanin,

                    'cpt' => $hd->cpt,
                    'po' => $hd->po,

                    'trungchuyen' => $hd->trungchuyen,
                    'loadingport' => $hd->loadingport,
                    'dischargport' => $hd->dischargport,

                    'tinhtrang' => $hd->tinhtrang,

                    'username_approve' => $hd->username_approve,
    
                    'username' => Auth::user()->username,
        
                    'trangthai' => 'Xóa'
    
                ]);

                ModelsHopDong::where('sohd', $this->shd)->update([

                    'isDelete' => '1'

                ]);

                // Thao tác xóa sẩn phẩm

                $sp =  SanPham::where('sohd', $this->shd)->first();

                $sanphamlog = [
                    'sohd' => $sp->sohd,
                    'username' => Auth::user()->username,
                    'trangthai' => 'Xóa'
                ];
    
                for ($i=1; $i <16 ; $i++) { 
    
                    $temp = [
        
                        'quycach'.$i => $sp->{'quycach'.$i},
                        'soluong'.$i => $sp->{'soluong'.$i},
                        'dongia'.$i => $sp->{'dongia'.$i},
    
                    ];
    
                    $sanphamlog = array_merge($sanphamlog, $temp);

                    $temp = [];
                    
                }
                
                SanPhamLog::create($sanphamlog);

                SanPham::where('sohd', $this->shd)->update([

                    'isDelete' => '1'

                ]);

                flash()->addFlash('success', 'Xóa thành công HĐ : ' . $this->shd,'Thông báo');
                $this->resetInputField();
                $this->emit('deleteHD');

            });

        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function timthongtinbenb(){

        $thong_tin_thanh_toan = ModelsHopDong::join('ben_b_vs_hop_dong', 'hop_dong.benb', '=', 'ben_b_vs_hop_dong.id')
                                            ->where('ben_b_vs_hop_dong.ten_tv', $this->benb)
                                            ->where('hop_dong.loaihopdong', $this->loaihopdong)
                                            ->orderByDesc('hop_dong.id')
                                            ->select('hop_dong.chatluong','hop_dong.donggoi','hop_dong.vat','hop_dong.thoigianthanhtoan', 'hop_dong.phuongthucthanhtoan','hop_dong.diadiemgiaohang',
                                                      'hop_dong.diachi_diadiemgiaohang', 'hop_dong.thoigiangiaohang', 'hop_dong.phuongthucgiaohang',
                                                      'hop_dong.giaohangtungphan', 'hop_dong.phivanchuyen', 'hop_dong.soluongbanin',
                                                      'hop_dong.chatluong_ta','hop_dong.donggoi_ta', 'hop_dong.thoigianthanhtoan_ta', 'hop_dong.phuongthucthanhtoan_ta',
                                                      'hop_dong.diadiemgiaohang_ta', 'hop_dong.diachi_diadiemgiaohang_ta', 'hop_dong.phuongthucgiaohang_ta',
                                                      'hop_dong.phivanchuyen_ta', 'hop_dong.po','hop_dong.cpt','hop_dong.trungchuyen','hop_dong.loadingport','hop_dong.dischargport')
                                            ->first();

        if($thong_tin_thanh_toan != null){

            $selectDongGoi = DongGoi::where('donggoi', $thong_tin_thanh_toan->donggoi)->get();
            $selectPTGH = PhuongThucGiaoHang::where('phuongthucgiaohang', $thong_tin_thanh_toan->phuongthucgiaohang)->get();

            $selectDongGoi_ta = DongGoi::where('donggoi_ta', $thong_tin_thanh_toan->donggoi_ta)->get();
            $selectPTGH_ta = PhuongThucGiaoHang::where('phuongthucgiaohang_ta', $thong_tin_thanh_toan->phuongthucgiaohang_ta)->get();

            if($selectDongGoi->count() == 0){

                $this->donggoi = 'Khác';
                $this->donggoikhac = $thong_tin_thanh_toan->donggoi;

            }else{

                $this->donggoi = $thong_tin_thanh_toan->donggoi;
                $this->donggoikhac = '';

            }

            if($selectDongGoi_ta->count() == 0){

                $this->donggoi_ta = 'Other';
                $this->donggoikhac_ta = $thong_tin_thanh_toan->donggoi_ta;

            }else{

                $this->donggoi_ta = $thong_tin_thanh_toan->donggoi_ta;
                $this->donggoikhac_ta = '';

            }

            if($selectPTGH->count() == 0){

                $this->phuongthucgiaohang = 'Khác';
                $this->phuongthucgiaohangkhac = $thong_tin_thanh_toan->phuongthucgiaohang;

            }else{

                $this->phuongthucgiaohang = $thong_tin_thanh_toan->phuongthucgiaohang;
                $this->phuongthucgiaohangkhac = '';

            }

            if($selectPTGH_ta->count() == 0){

                $this->phuongthucgiaohang_ta = 'Other';
                $this->phuongthucgiaohangkhac_ta = $thong_tin_thanh_toan->phuongthucgiaohang_ta;

            }else{

                $this->phuongthucgiaohang_ta = $thong_tin_thanh_toan->phuongthucgiaohang_ta;
                $this->phuongthucgiaohangkhac_ta = '';

            }

            $this->chatluong = $thong_tin_thanh_toan->chatluong;
            $this->thoigianthanhtoan = $thong_tin_thanh_toan->thoigianthanhtoan;
            $this->phuongthucthanhtoan = $thong_tin_thanh_toan->phuongthucthanhtoan;
            $this->diadiemgiaohang = $thong_tin_thanh_toan->diadiemgiaohang;
            $this->diachi_diadiemgiaohang = $thong_tin_thanh_toan->diachi_diadiemgiaohang;
            $this->thoigiangiaohang = $thong_tin_thanh_toan->thoigiangiaohang;
            $this->giaohangtungphan = $thong_tin_thanh_toan->giaohangtungphan;
            $this->phivanchuyen = $thong_tin_thanh_toan->phivanchuyen;
            $this->soluongbanin = $thong_tin_thanh_toan->soluongbanin;
    
            $this->tygia = $thong_tin_thanh_toan->tygia;
            $this->vat = $thong_tin_thanh_toan->vat;
            $this->chatluong_ta = $thong_tin_thanh_toan->chatluong_ta;
            $this->thoigianthanhtoan_ta = $thong_tin_thanh_toan->thoigianthanhtoan_ta;
            $this->phuongthucthanhtoan_ta = $thong_tin_thanh_toan->phuongthucthanhtoan_ta;
            $this->diadiemgiaohang_ta = $thong_tin_thanh_toan->diadiemgiaohang_ta;
            $this->diachi_diadiemgiaohang_ta = $thong_tin_thanh_toan->diachi_diadiemgiaohang_ta;
            $this->thoigiangiaohang = $thong_tin_thanh_toan->thoigiangiaohang;
            $this->phuongthucgiaohang_ta = $thong_tin_thanh_toan->phuongthucgiaohang_ta;
            $this->giaohangtungphan = $thong_tin_thanh_toan->giaohangtungphan;
            $this->phivanchuyen_ta = $thong_tin_thanh_toan->phivanchuyen_ta;

            $this->cpt = $thong_tin_thanh_toan->cpt;
            $this->po = $thong_tin_thanh_toan->po;
            $this->trungchuyen = $thong_tin_thanh_toan->trungchuyen;
            $this->loadingport = $thong_tin_thanh_toan->loadingport;
            $this->dischargport = $thong_tin_thanh_toan->dischargport;

        }

        $thongtinbenb = BenB::where('ten_tv', $this->benb)->get();

        foreach ($thongtinbenb as $item) {

            $this->makhachhangbenb = $item->ma_khach_hang;
            $this->diachibenb = $item->dia_chi_tv;
            $this->masothuebenb = $item->ma_so_thue_tv;
            $this->taikhoansobenb = $item->tai_khoan_ngan_hang_tv;
            $this->sdtbenb = $item->dien_thoai_tv;
            $this->faxbenb = $item->fax_tv;
            $this->daidienbenb = $item->dai_dien_tv;
            $this->chucvudaidienbenb = $item->chuc_vu_tv;
            $this->uyquyendaidienbenb = $item->giay_uy_quyen_tv;

            $this->benb_ta = $item->ten_ta;
            $this->diachibenb_ta = $item->dia_chi_ta;
            $this->taikhoansobenb_ta = $item->tai_khoan_ngan_hang_ta;
            // $this->daidienbenb_ta = $item->dai_dien_ta;
            // $this->chucvudaidienbenb_ta = $item->chuc_vu_ta;

            $this->check_ma_so_thue_ben_b = $item->check_ma_so_thue;
            $this->check_tai_khoan_ngan_hang_ben_b = $item->check_tai_khoan_ngan_hang;
            $this->check_sdt_ben_b = $item->check_dien_thoai;
            $this->check_fax_ben_b = $item->check_fax;
            $this->check_dai_dien_ben_b = $item->check_dai_dien;
            $this->check_uyquyen_ben_b = $item->check_giay_uy_quyen;

        }

    }

    public function timthongtinbenbEdit(){

        $thongtinbenb = BenB::where('ten_tv', $this->benb)->get();

        foreach ($thongtinbenb as $item) {

            $this->makhachhangbenb = $item->ma_khach_hang;
            $this->diachibenb = $item->dia_chi_tv;
            $this->masothuebenb = $item->ma_so_thue_tv;
            $this->taikhoansobenb = $item->tai_khoan_ngan_hang_tv;
            $this->sdtbenb = $item->dien_thoai_tv;
            $this->faxbenb = $item->fax_tv;
            $this->daidienbenb = $item->dai_dien_tv;
            $this->chucvudaidienbenb = $item->chuc_vu_tv;
            $this->uyquyendaidienbenb = $item->giay_uy_quyen_tv;

            $this->benb_ta = $item->ten_ta;
            $this->diachibenb_ta = $item->dia_chi_ta;
            $this->taikhoansobenb_ta = $item->tai_khoan_ngan_hang_ta;
            // $this->daidienbenb_ta = $item->dai_dien_ta;
            // $this->chucvudaidienbenb_ta = $item->chuc_vu_ta;

            $this->check_ma_so_thue_ben_b = $item->check_ma_so_thue;
            $this->check_tai_khoan_ngan_hang_ben_b = $item->check_tai_khoan_ngan_hang;
            $this->check_sdt_ben_b = $item->check_dien_thoai;
            $this->check_fax_ben_b = $item->check_fax;
            $this->check_dai_dien_ben_b = $item->check_dai_dien;
            $this->check_uyquyen_ben_b = $item->check_giay_uy_quyen;

        }

    }

    public function approve1($sohd){

        DB::transaction( function() use($sohd){

            $hop_dong_update =  ModelsHopDong::where('sohd', $sohd)->first();

            $hop_dong_update->tinhtrang = 'Processing';
            $hop_dong_update->username_approve = Auth::user()->username;

            $hop_dong_update->save();

            HopDongLog::create([

                'sohd' => $sohd,
                'loaihopdong' => $hop_dong_update->loaihopdong,
                'ngaylaphd' => $hop_dong_update->ngaylaphd,
                'ngayhethanhd' => $hop_dong_update->ngayhethanhd,
                'so_tdg' => $hop_dong_update->so_tdg,
                'so' => $hop_dong_update->so,

                'bena' => $hop_dong_update->bena,
                'dai_dien_ben_a' => $hop_dong_update->dai_dien_ben_a,
                'benb' => $hop_dong_update->benb,

                'sotaikhoan' => $hop_dong_update->sotaikhoan,
                'chutaikhoan' => $hop_dong_update->chutaikhoan,

                'sotaikhoan_ta' => $hop_dong_update->sotaikhoan_ta,
                'chutaikhoan_ta' => $hop_dong_update->chutaikhoan_ta,

                'tygia' => $hop_dong_update->tygia,
                'vat' => $hop_dong_update->vat,

                'chatluong' => $hop_dong_update->chatluong,
                'chatluong_ta' => $hop_dong_update->chatluong_ta,

                'donggoi' => $hop_dong_update->donggoi,
                'donggoi_ta' => $hop_dong_update->donggoi_ta,

                'thoigianthanhtoan' => $hop_dong_update->thoigianthanhtoan,
                'thoigianthanhtoan_ta' => $hop_dong_update->thoigianthanhtoan_ta,

                'phuongthucthanhtoan' => $hop_dong_update->phuongthucthanhtoan,
                'phuongthucthanhtoan_ta' => $hop_dong_update->phuongthucthanhtoan_ta,

                'diadiemgiaohang' => $hop_dong_update->diadiemgiaohang,
                'diadiemgiaohang_ta' => $hop_dong_update->diadiemgiaohang_ta,

                'diachi_diadiemgiaohang' => $hop_dong_update->diachi_diadiemgiaohang,
                'diachi_diadiemgiaohang_ta' => $hop_dong_update->diachi_diadiemgiaohang_ta,

                'thoigiangiaohang' => $hop_dong_update->thoigiangiaohang,
                
                'phuongthucgiaohang' => $hop_dong_update->phuongthucgiaohang,
                'phuongthucgiaohang_ta' => $hop_dong_update->phuongthucgiaohang_ta,

                'giaohangtungphan' => $hop_dong_update->giaohangtungphan,

                'phivanchuyen' => $hop_dong_update->phivanchuyen,
                'phivanchuyen_ta' => $hop_dong_update->phivanchuyen_ta,

                'soluongbanin' => $hop_dong_update->soluongbanin,

                'cpt' => $hop_dong_update->cpt,
                'po' => $hop_dong_update->po,

                'trungchuyen' => $hop_dong_update->trungchuyen,
                'loadingport' => $hop_dong_update->loadingport,
                'dischargport' => $hop_dong_update->dischargport,

                'tinhtrang' => 'Processing',

                'username_approve' => Auth::user()->username,
    
                'trangthai' => 'Processing',

                'username' => $hop_dong_update->username

            ]);

            $user = User::permission('approve_contracts')->first();

            //Mail::to($user)->send(new AlertApproveMail($sohd, $hop_dong_update->loaihopdong));
            Mail::to($user->email)->cc('luongphan@soitheky.vn')->later(now()->addMinutes(1), new MailHopDong('processing', $hop_dong_update->loaihopdong, $sohd , Auth::user()->username, Carbon::now(), ''));
        });

        flash()->addFlash('success', 'Approve success - ' . $sohd,'Notification');

    }

    public function approve($sohd){

        DB::transaction( function() use($sohd){

            $hop_dong_update =  ModelsHopDong::where('sohd', $sohd)->first();

            $hop_dong_update->tinhtrang = 'Approved';
            $hop_dong_update->username_approve = Auth::user()->username;

            $hop_dong_update->save();

            HopDongLog::create([

                'sohd' => $sohd,
                'loaihopdong' => $hop_dong_update->loaihopdong,
                'ngaylaphd' => $hop_dong_update->ngaylaphd,
                'ngayhethanhd' => $hop_dong_update->ngayhethanhd,
                'so_tdg' => $hop_dong_update->so_tdg,
                'so' => $hop_dong_update->so,

                'bena' => $hop_dong_update->bena,
                'dai_dien_ben_a' => $hop_dong_update->dai_dien_ben_a,
                'benb' => $hop_dong_update->benb,

                'sotaikhoan' => $hop_dong_update->sotaikhoan,
                'chutaikhoan' => $hop_dong_update->chutaikhoan,

                'sotaikhoan_ta' => $hop_dong_update->sotaikhoan_ta,
                'chutaikhoan_ta' => $hop_dong_update->chutaikhoan_ta,

                'tygia' => $hop_dong_update->tygia,
                'vat' => $hop_dong_update->vat,

                'chatluong' => $hop_dong_update->chatluong,
                'chatluong_ta' => $hop_dong_update->chatluong_ta,

                'donggoi' => $hop_dong_update->donggoi,
                'donggoi_ta' => $hop_dong_update->donggoi_ta,

                'thoigianthanhtoan' => $hop_dong_update->thoigianthanhtoan,
                'thoigianthanhtoan_ta' => $hop_dong_update->thoigianthanhtoan_ta,

                'phuongthucthanhtoan' => $hop_dong_update->phuongthucthanhtoan,
                'phuongthucthanhtoan_ta' => $hop_dong_update->phuongthucthanhtoan_ta,

                'diadiemgiaohang' => $hop_dong_update->diadiemgiaohang,
                'diadiemgiaohang_ta' => $hop_dong_update->diadiemgiaohang_ta,

                'diachi_diadiemgiaohang' => $hop_dong_update->diachi_diadiemgiaohang,
                'diachi_diadiemgiaohang_ta' => $hop_dong_update->diachi_diadiemgiaohang_ta,

                'thoigiangiaohang' => $hop_dong_update->thoigiangiaohang,
                
                'phuongthucgiaohang' => $hop_dong_update->phuongthucgiaohang,
                'phuongthucgiaohang_ta' => $hop_dong_update->phuongthucgiaohang_ta,

                'giaohangtungphan' => $hop_dong_update->giaohangtungphan,

                'phivanchuyen' => $hop_dong_update->phivanchuyen,
                'phivanchuyen_ta' => $hop_dong_update->phivanchuyen_ta,

                'soluongbanin' => $hop_dong_update->soluongbanin,

                'cpt' => $hop_dong_update->cpt,
                'po' => $hop_dong_update->po,

                'trungchuyen' => $hop_dong_update->trungchuyen,
                'loadingport' => $hop_dong_update->loadingport,
                'dischargport' => $hop_dong_update->dischargport,

                'tinhtrang' => 'Approved',

                'username_approve' => Auth::user()->username,
    
                'trangthai' => 'Approved',

                'username' => $hop_dong_update->username

            ]);

            $user = User::where('username', $hop_dong_update->username)->first();

            //Mail::to($user)->send(new AlertApproveMail($sohd, $hop_dong_update->loaihopdong));
            Mail::to($user->email)->cc('luongphan@soitheky.vn')->later(now()->addMinutes(1), new MailHopDong('approved', $hop_dong_update->loaihopdong, $sohd , Auth::user()->username, Carbon::now(), ''));
        });

        flash()->addFlash('success', 'Approve success - ' . $sohd,'Notification');

    }

    public function rollback($sohd){

        DB::transaction( function() use ($sohd){

            $hop_dong_update =  ModelsHopDong::where('sohd', $sohd)->first();

            $hop_dong_update->tinhtrang = 'New';
            $hop_dong_update->username_approve = Auth::user()->username;

            $hop_dong_update->save();

            HopDongLog::create([

                'sohd' => $sohd,
                'loaihopdong' => $hop_dong_update->loaihopdong,
                'ngaylaphd' => $hop_dong_update->ngaylaphd,
                'ngayhethanhd' => $hop_dong_update->ngayhethanhd,
                'so_tdg' => $hop_dong_update->so_tdg,
                'so' => $hop_dong_update->so,

                'bena' => $hop_dong_update->bena,
                'dai_dien_ben_a' => $hop_dong_update->dai_dien_ben_a,
                'benb' => $hop_dong_update->benb,

                'sotaikhoan' => $hop_dong_update->sotaikhoan,
                'chutaikhoan' => $hop_dong_update->chutaikhoan,

                'sotaikhoan_ta' => $hop_dong_update->sotaikhoan_ta,
                'chutaikhoan_ta' => $hop_dong_update->chutaikhoan_ta,

                'tygia' => $hop_dong_update->tygia,
                'vat' => $hop_dong_update->vat,

                'chatluong' => $hop_dong_update->chatluong,
                'chatluong_ta' => $hop_dong_update->chatluong_ta,

                'donggoi' => $hop_dong_update->donggoi,
                'donggoi_ta' => $hop_dong_update->donggoi_ta,

                'thoigianthanhtoan' => $hop_dong_update->thoigianthanhtoan,
                'thoigianthanhtoan_ta' => $hop_dong_update->thoigianthanhtoan_ta,

                'phuongthucthanhtoan' => $hop_dong_update->phuongthucthanhtoan,
                'phuongthucthanhtoan_ta' => $hop_dong_update->phuongthucthanhtoan_ta,

                'diadiemgiaohang' => $hop_dong_update->diadiemgiaohang,
                'diadiemgiaohang_ta' => $hop_dong_update->diadiemgiaohang_ta,

                'diachi_diadiemgiaohang' => $hop_dong_update->diachi_diadiemgiaohang,
                'diachi_diadiemgiaohang_ta' => $hop_dong_update->diachi_diadiemgiaohang_ta,

                'thoigiangiaohang' => $hop_dong_update->thoigiangiaohang,
                
                'phuongthucgiaohang' => $hop_dong_update->phuongthucgiaohang,
                'phuongthucgiaohang_ta' => $hop_dong_update->phuongthucgiaohang_ta,

                'giaohangtungphan' => $hop_dong_update->giaohangtungphan,

                'phivanchuyen' => $hop_dong_update->phivanchuyen,
                'phivanchuyen_ta' => $hop_dong_update->phivanchuyen_ta,

                'soluongbanin' => $hop_dong_update->soluongbanin,

                'cpt' => $hop_dong_update->cpt,
                'po' => $hop_dong_update->po,

                'trungchuyen' => $hop_dong_update->trungchuyen,
                'loadingport' => $hop_dong_update->loadingport,
                'dischargport' => $hop_dong_update->dischargport,

                'tinhtrang' => 'New',

                'username_approve' => Auth::user()->username,
    
                'trangthai' => 'New',

                'username' => $hop_dong_update->username

            ]);

        });

        flash()->addFlash('success', 'Rollback success - ' . $sohd,'Notification');

    }

    public function rejectModal($sohd){

        $this->shd = $sohd;

    }

    public function reject(){

        DB::transaction( function(){

            $hop_dong_update =  ModelsHopDong::where('sohd', $this->shd)->first();

            $hop_dong_update->tinhtrang = 'Rejected';
            $hop_dong_update->ly_do_reject = $this->reject;
            $hop_dong_update->username_approve = Auth::user()->username;

            $hop_dong_update->save();

            HopDongLog::create([

                'sohd' => $this->shd,
                'loaihopdong' => $hop_dong_update->loaihopdong,
                'ngaylaphd' => $hop_dong_update->ngaylaphd,
                'ngayhethanhd' => $hop_dong_update->ngayhethanhd,
                'so_tdg' => $hop_dong_update->so_tdg,
                'so' => $hop_dong_update->so,

                'bena' => $hop_dong_update->bena,
                'dai_dien_ben_a' => $hop_dong_update->dai_dien_ben_a,
                'benb' => $hop_dong_update->benb,

                'sotaikhoan' => $hop_dong_update->sotaikhoan,
                'chutaikhoan' => $hop_dong_update->chutaikhoan,

                'sotaikhoan_ta' => $hop_dong_update->sotaikhoan_ta,
                'chutaikhoan_ta' => $hop_dong_update->chutaikhoan_ta,

                'tygia' => $hop_dong_update->tygia,
                'vat' => $hop_dong_update->vat,

                'chatluong' => $hop_dong_update->chatluong,
                'chatluong_ta' => $hop_dong_update->chatluong_ta,

                'donggoi' => $hop_dong_update->donggoi,
                'donggoi_ta' => $hop_dong_update->donggoi_ta,

                'thoigianthanhtoan' => $hop_dong_update->thoigianthanhtoan,
                'thoigianthanhtoan_ta' => $hop_dong_update->thoigianthanhtoan_ta,

                'phuongthucthanhtoan' => $hop_dong_update->phuongthucthanhtoan,
                'phuongthucthanhtoan_ta' => $hop_dong_update->phuongthucthanhtoan_ta,

                'diadiemgiaohang' => $hop_dong_update->diadiemgiaohang,
                'diadiemgiaohang_ta' => $hop_dong_update->diadiemgiaohang_ta,

                'diachi_diadiemgiaohang' => $hop_dong_update->diachi_diadiemgiaohang,
                'diachi_diadiemgiaohang_ta' => $hop_dong_update->diachi_diadiemgiaohang_ta,

                'thoigiangiaohang' => $hop_dong_update->thoigiangiaohang,
                
                'phuongthucgiaohang' => $hop_dong_update->phuongthucgiaohang,
                'phuongthucgiaohang_ta' => $hop_dong_update->phuongthucgiaohang_ta,

                'giaohangtungphan' => $hop_dong_update->giaohangtungphan,

                'phivanchuyen' => $hop_dong_update->phivanchuyen,
                'phivanchuyen_ta' => $hop_dong_update->phivanchuyen_ta,

                'soluongbanin' => $hop_dong_update->soluongbanin,

                'cpt' => $hop_dong_update->cpt,
                'po' => $hop_dong_update->po,

                'trungchuyen' => $hop_dong_update->trungchuyen,
                'loadingport' => $hop_dong_update->loadingport,
                'dischargport' => $hop_dong_update->dischargport,

                'tinhtrang' => 'Rejected',
                'ly_do_reject' => $this->reject,

                'username_approve' => Auth::user()->username,
    
                'trangthai' => 'Rejected',

                'username' => $hop_dong_update->username

            ]);

            $user = User::where('username', $hop_dong_update->username)->first();

            //Mail::to($user)->send(new AlertRejectMail($this->shd, $hop_dong_update->loaihopdong, $this->reject));
            Mail::to($user->email)->later(now()->addMinutes(1), new MailHopDong('rejected', $hop_dong_update->loaihopdong, $this->shd , Auth::user()->username, Carbon::now(), $this->reject));
        });


        flash()->addFlash('success', 'Rejected success - ' . $this->shd,'Notification');
        $this->emit('rejectModal');

    }

    public function uploadFileScanModal($sohd){

        $this->shd = $sohd;
        $this->filescan = '';

    }

    public function uploadFileScan(){

        if($this->filescan == null){

            flash()->addFlash('error', 'Thao tác quá nhanh, vui lòng bấm "Thực hiện" lại.','Thông báo');

        }else{

            $this->validate([
                'filescan' => 'mimes:pdf',
            ]);
    
            DB::transaction( function() {
    
                $hop_dong_update =  ModelsHopDong::where('sohd', $this->shd)->first();
    
                $hop_dong_update->tinhtrang = 'Scanned file received';
                $hop_dong_update->username = Auth::user()->username;
    
                $hop_dong_update->save();
    
                HopDongLog::create([
    
                    'sohd' => $this->shd,
                    'loaihopdong' => $hop_dong_update->loaihopdong,
                    'ngaylaphd' => $hop_dong_update->ngaylaphd,
                    'ngayhethanhd' => $hop_dong_update->ngayhethanhd,
                    'so_tdg' => $hop_dong_update->so_tdg,
                    'so' => $hop_dong_update->so,
    
                    'bena' => $hop_dong_update->bena,
                    'dai_dien_ben_a' => $hop_dong_update->dai_dien_ben_a,
                    'benb' => $hop_dong_update->benb,
    
                    'sotaikhoan' => $hop_dong_update->sotaikhoan,
                    'chutaikhoan' => $hop_dong_update->chutaikhoan,
    
                    'sotaikhoan_ta' => $hop_dong_update->sotaikhoan_ta,
                    'chutaikhoan_ta' => $hop_dong_update->chutaikhoan_ta,

                    'donggoi' => $hop_dong_update->donggoi,
                    'donggoi_ta' => $hop_dong_update->donggoi_ta,
    
                    'tygia' => $hop_dong_update->tygia,
                    'vat' => $hop_dong_update->vat,
    
                    'chatluong' => $hop_dong_update->chatluong,
                    'chatluong_ta' => $hop_dong_update->chatluong_ta,
    
                    'thoigianthanhtoan' => $hop_dong_update->thoigianthanhtoan,
                    'thoigianthanhtoan_ta' => $hop_dong_update->thoigianthanhtoan_ta,
    
                    'phuongthucthanhtoan' => $hop_dong_update->phuongthucthanhtoan,
                    'phuongthucthanhtoan_ta' => $hop_dong_update->phuongthucthanhtoan_ta,
    
                    'diadiemgiaohang' => $hop_dong_update->diadiemgiaohang,
                    'diadiemgiaohang_ta' => $hop_dong_update->diadiemgiaohang_ta,
    
                    'diachi_diadiemgiaohang' => $hop_dong_update->diachi_diadiemgiaohang,
                    'diachi_diadiemgiaohang_ta' => $hop_dong_update->diachi_diadiemgiaohang_ta,
    
                    'thoigiangiaohang' => $hop_dong_update->thoigiangiaohang,
                    
                    'phuongthucgiaohang' => $hop_dong_update->phuongthucgiaohang,
                    'phuongthucgiaohang_ta' => $hop_dong_update->phuongthucgiaohang_ta,
    
                    'giaohangtungphan' => $hop_dong_update->giaohangtungphan,
    
                    'phivanchuyen' => $hop_dong_update->phivanchuyen,
                    'phivanchuyen_ta' => $hop_dong_update->phivanchuyen_ta,
    
                    'soluongbanin' => $hop_dong_update->soluongbanin,
    
                    'cpt' => $hop_dong_update->cpt,
                    'po' => $hop_dong_update->po,
    
                    'trungchuyen' => $hop_dong_update->trungchuyen,
                    'loadingport' => $hop_dong_update->loadingport,
                    'dischargport' => $hop_dong_update->dischargport,
    
                    'tinhtrang' => 'Scanned file received',
                    'username_approve' => $hop_dong_update->username_approve,
    
                    'username' => Auth::user()->username,
        
                    'trangthai' => 'Scanned file received'
    
                ]);

                if($hop_dong_update->loaihopdong == '1' || $hop_dong_update->loaihopdong == '2'){

                    $this->filescan->storeAs('HD/' . $this->shd, $this->shd . ' - Scan ver.pdf', 'public');

                }else{

                    $this->filescan->storeAs('HD/' . str_replace('/','_',$this->shd), str_replace('/','_',$this->shd) . ' - Scan ver.pdf', 'public');
                
                }

            });
    
            flash()->addFlash('success', 'Upload thành công.','Thông báo');
            $this->filescan = '';
            $this->emit('uploadFileScan');

        }
    }

    public function uploadFileRootModal($sohd){

        $this->shd = $sohd;
        $this->fileroot = '';

    }

    public function uploadFileRoot(){

        if($this->fileroot == null){

            flash()->addFlash('error', 'Thao tác quá nhanh, vui lòng bấm "Thực hiện" lại.','Thông báo');

        }else{

            DB::transaction( function() {

                $hop_dong_update =  ModelsHopDong::where('sohd', $this->shd)->first();
    
                $hop_dong_update->tinhtrang = 'Success';
                $hop_dong_update->username = Auth::user()->username;
    
                $hop_dong_update->save();
    
                HopDongLog::create([
    
                    'sohd' => $this->shd,
                    'loaihopdong' => $hop_dong_update->loaihopdong,
                    'ngaylaphd' => $hop_dong_update->ngaylaphd,
                    'ngayhethanhd' => $hop_dong_update->ngayhethanhd,
                    'so_tdg' => $hop_dong_update->so_tdg,
                    'so' => $hop_dong_update->so,
    
                    'bena' => $hop_dong_update->bena,
                    'dai_dien_ben_a' => $hop_dong_update->dai_dien_ben_a,
                    'benb' => $hop_dong_update->benb,
    
                    'sotaikhoan' => $hop_dong_update->sotaikhoan,
                    'chutaikhoan' => $hop_dong_update->chutaikhoan,
    
                    'sotaikhoan_ta' => $hop_dong_update->sotaikhoan_ta,
                    'chutaikhoan_ta' => $hop_dong_update->chutaikhoan_ta,
    
                    'tygia' => $hop_dong_update->tygia,
                    'vat' => $hop_dong_update->vat,
    
                    'chatluong' => $hop_dong_update->chatluong,
                    'chatluong_ta' => $hop_dong_update->chatluong_ta,

                    'donggoi' => $hop_dong_update->donggoi,
                    'donggoi_ta' => $hop_dong_update->donggoi_ta,
    
                    'thoigianthanhtoan' => $hop_dong_update->thoigianthanhtoan,
                    'thoigianthanhtoan_ta' => $hop_dong_update->thoigianthanhtoan_ta,
    
                    'phuongthucthanhtoan' => $hop_dong_update->phuongthucthanhtoan,
                    'phuongthucthanhtoan_ta' => $hop_dong_update->phuongthucthanhtoan_ta,
    
                    'diadiemgiaohang' => $hop_dong_update->diadiemgiaohang,
                    'diadiemgiaohang_ta' => $hop_dong_update->diadiemgiaohang_ta,
    
                    'diachi_diadiemgiaohang' => $hop_dong_update->diachi_diadiemgiaohang,
                    'diachi_diadiemgiaohang_ta' => $hop_dong_update->diachi_diadiemgiaohang_ta,
    
                    'thoigiangiaohang' => $hop_dong_update->thoigiangiaohang,
                    
                    'phuongthucgiaohang' => $hop_dong_update->phuongthucgiaohang,
                    'phuongthucgiaohang_ta' => $hop_dong_update->phuongthucgiaohang_ta,
    
                    'giaohangtungphan' => $hop_dong_update->giaohangtungphan,
    
                    'phivanchuyen' => $hop_dong_update->phivanchuyen,
                    'phivanchuyen_ta' => $hop_dong_update->phivanchuyen_ta,
    
                    'soluongbanin' => $hop_dong_update->soluongbanin,
    
                    'cpt' => $hop_dong_update->cpt,
                    'po' => $hop_dong_update->po,
    
                    'trungchuyen' => $hop_dong_update->trungchuyen,
                    'loadingport' => $hop_dong_update->loadingport,
                    'dischargport' => $hop_dong_update->dischargport,
    
                    'tinhtrang' => 'Success',
                    'username_approve' => $hop_dong_update->username_approve,
    
                    'username' => Auth::user()->username,
        
                    'trangthai' => 'Success'
    
                ]);

                if($hop_dong_update->loaihopdong == '1' || $hop_dong_update->loaihopdong == '2'){

                    $this->filescan->storeAs('HD/' . $this->shd, $this->shd . ' - Original ver.pdf', 'public');

                }else{

                    $this->filescan->storeAs('HD/' . str_replace('/','_',$this->shd), str_replace('/','_',$this->shd) . ' - Original ver.pdf', 'public');
                
                }
    
            });
    
            flash()->addFlash('success', 'Upload thành công.','Thông báo');
            $this->fileroot = '';
            $this->emit('uploadFileRoot');

        }

    }

    public function uploadHopDongCoFileSanModal($loaihopdong){

        $this->loaihopdong = $loaihopdong;

    }

    public function uploadHopDongCoFileSan(){

        if($this->filehdcosan == null){

            flash()->addFlash('error', 'Thao tác quá nhanh, vui lòng bấm "Thực hiện" lại.','Thông báo');

        }else{
        
            $this->validate([
                'filehdcosan' => 'mimes:docx',
            ]);

            if($this->loaihopdong == '1' || $this->loaihopdong == '2'){

                $this->shd = IdGenerator::generate(['table' => 'hop_dong', 'field' => 'sohd', 'length' => '9', 'prefix' => Carbon::now()->format('Y'),'reset_on_prefix_change' => true]);

            }else{

                $ngaylaphopdong = Carbon::create($this->ngaylaphd)->isoFormat('YYMMDD');

                $this->shd = IdGenerator::generate(['table' => 'hop_dong', 'field' => 'sohd', 'length' => '15', 'prefix' => 'TKY-' . $ngaylaphopdong . '/EX-','reset_on_prefix_change' => true]);

            }
    
            if($this->makhachhangbenb == ''){
    
                flash()->addFlash('error', 'Không tìm thấy khách hàng này','Thông báo');
    
            }else{
    
                DB::transaction( function(){
        
                    ModelsHopDong::create([
        
                        'sohd' => $this->shd,
                        'loaihopdong' => $this->loaihopdong,
        
                        'bena' => $this->bena,
    
                        'tinhtrang' => 'New',
        
                        'username' => Auth::user()->username,
        
                    ]);
        
                    HopDongLog::create([
        
                        'sohd' => $this->shd,
                        'loaihopdong' => $this->loaihopdong,
    
                        'bena' => $this->bena,
    
                        'tinhtrang' => 'New',
        
                        'username' => Auth::user()->username,
        
                        'trangthai' => 'Tạo'
        
                    ]);
    
                });

                if($this->loaihopdong == '1' || $this->loaihopdong == '2'){

                    $this->filescan->storeAs('HD/' . $this->shd, $this->shd . '.docx', 'public');
                    flash()->addFlash('success', 'Tạo thành công HĐ : ' . substr($this->shd,4,5) . '/HĐMB-' . substr($this->shd,0,4),'Thông báo');

                }else{

                    $this->filescan->storeAs('HD/' . str_replace('/','_',$this->shd), str_replace('/','_',$this->shd) . '.docx', 'public');
                    flash()->addFlash('success', 'Tạo thành công HĐ : ' . $this->shd,'Thông báo');
                
                }
                
                $this->resetInputField();
                $this->emit('uploadHopDongCoFileSan');
    
            }

        }
        
    }

    public function uploadFilePhuLucModal($sohd){

        $this->shd = $sohd;
        $this->filephuluc = '';

    }

    public function uploadFilePhuLuc(){

        if($this->filephuluc == null){

            flash()->addFlash('error', 'Thao tác quá nhanh, vui lòng bấm "Thực hiện" lại.','Thông báo');

        }else{

            $hop_dong_update =  ModelsHopDong::where('sohd', $this->shd)->first();

            DB::transaction( function() use ($hop_dong_update) {
    
                HopDongLog::create([
    
                    'sohd' => $this->shd,
                    'loaihopdong' => $hop_dong_update->loaihopdong,
                    'ngaylaphd' => $hop_dong_update->ngaylaphd,
                    'ngayhethanhd' => $hop_dong_update->ngayhethanhd,
                    'so_tdg' => $hop_dong_update->so_tdg,
                    'so' => $hop_dong_update->so,
    
                    'bena' => $hop_dong_update->bena,
                    'dai_dien_ben_a' => $hop_dong_update->dai_dien_ben_a,
                    'benb' => $hop_dong_update->benb,
    
                    'sotaikhoan' => $hop_dong_update->sotaikhoan,
                    'chutaikhoan' => $hop_dong_update->chutaikhoan,
    
                    'sotaikhoan_ta' => $hop_dong_update->sotaikhoan_ta,
                    'chutaikhoan_ta' => $hop_dong_update->chutaikhoan_ta,
    
                    'tygia' => $hop_dong_update->tygia,
                    'vat' => $hop_dong_update->vat,
    
                    'chatluong' => $hop_dong_update->chatluong,
                    'chatluong_ta' => $hop_dong_update->chatluong_ta,

                    'donggoi' => $hop_dong_update->donggoi,
                    'donggoi_ta' => $hop_dong_update->donggoi_ta,
    
                    'thoigianthanhtoan' => $hop_dong_update->thoigianthanhtoan,
                    'thoigianthanhtoan_ta' => $hop_dong_update->thoigianthanhtoan_ta,
    
                    'phuongthucthanhtoan' => $hop_dong_update->phuongthucthanhtoan,
                    'phuongthucthanhtoan_ta' => $hop_dong_update->phuongthucthanhtoan_ta,
    
                    'diadiemgiaohang' => $hop_dong_update->diadiemgiaohang,
                    'diadiemgiaohang_ta' => $hop_dong_update->diadiemgiaohang_ta,
    
                    'diachi_diadiemgiaohang' => $hop_dong_update->diachi_diadiemgiaohang,
                    'diachi_diadiemgiaohang_ta' => $hop_dong_update->diachi_diadiemgiaohang_ta,
    
                    'thoigiangiaohang' => $hop_dong_update->thoigiangiaohang,
                    
                    'phuongthucgiaohang' => $hop_dong_update->phuongthucgiaohang,
                    'phuongthucgiaohang_ta' => $hop_dong_update->phuongthucgiaohang_ta,
    
                    'giaohangtungphan' => $hop_dong_update->giaohangtungphan,
    
                    'phivanchuyen' => $hop_dong_update->phivanchuyen,
                    'phivanchuyen_ta' => $hop_dong_update->phivanchuyen_ta,
    
                    'soluongbanin' => $hop_dong_update->soluongbanin,
    
                    'cpt' => $hop_dong_update->cpt,
                    'po' => $hop_dong_update->po,
    
                    'trungchuyen' => $hop_dong_update->trungchuyen,
                    'loadingport' => $hop_dong_update->loadingport,
                    'dischargport' => $hop_dong_update->dischargport,
    
                    'tinhtrang' => $hop_dong_update->tinhtrang,
                    'username_approve' => $hop_dong_update->username_approve,
    
                    'username' => Auth::user()->username,
        
                    'trangthai' => 'Up file Phu Luc'
    
                ]);
    
            });
            
            if($hop_dong_update->loaihopdong == '3' || $hop_dong_update->loaihopdong == '4' || $hop_dong_update->loaihopdong == '5'){

                $soHopDong = str_replace('/','_',$this->shd);

            }else{

                $soHopDong = $this->shd;

            }

            $numberFiles = count(Storage::disk('public')->allFiles('Addendum/' . $soHopDong));

            $ext = $this->filephuluc->extension();

            $this->filephuluc->storeAs('Addendum/' . $soHopDong, $this->shd . '- Annex ver - '. $numberFiles + 1 . '.' . $ext, 'public');

            flash()->addFlash('success', 'Upload thành công.','Thông báo');
            $this->filephuluc = '';
            $this->emit('uploadPhuLuc');

        };

    }

    public function uploadFileTDGModal($sohd){

        $this->shd = $sohd;
        $this->filetdg = '';

    }

    // public function uploadFileTDG(){

    //     if($this->filetdg == null){

    //         flash()->addFlash('error', 'Thao tác quá nhanh, vui lòng bấm "Thực hiện" lại.','Thông báo');

    //     }else{

    //         DB::transaction( function() {

    //             $hop_dong_update =  ModelsHopDong::where('sohd', $this->shd)->first();
    
    //             HopDongLog::create([
    
    //                 'sohd' => $this->shd,
    //                 'loaihopdong' => $hop_dong_update->loaihopdong,
    //                 'ngaylaphd' => $hop_dong_update->ngaylaphd,
    //                 'ngayhethanhd' => $hop_dong_update->ngayhethanhd,
    
    //                 'bena' => $hop_dong_update->bena,
    //                 'dai_dien_ben_a' => $hop_dong_update->dai_dien_ben_a,
    //                 'benb' => $hop_dong_update->benb,
    
    //                 'sotaikhoan' => $hop_dong_update->sotaikhoan,
    //                 'chutaikhoan' => $hop_dong_update->chutaikhoan,
    
    //                 'sotaikhoan_ta' => $hop_dong_update->sotaikhoan_ta,
    //                 'chutaikhoan_ta' => $hop_dong_update->chutaikhoan_ta,
    
    //                 'tygia' => $hop_dong_update->tygia,
    //                 'vat' => $hop_dong_update->vat,
    
    //                 'chatluong' => $hop_dong_update->chatluong,
    //                 'chatluong_ta' => $hop_dong_update->chatluong_ta,

    //                 'donggoi' => $hop_dong_update->donggoi,
    //                 'donggoi_ta' => $hop_dong_update->donggoi_ta,
    
    //                 'thoigianthanhtoan' => $hop_dong_update->thoigianthanhtoan,
    //                 'thoigianthanhtoan_ta' => $hop_dong_update->thoigianthanhtoan_ta,
    
    //                 'phuongthucthanhtoan' => $hop_dong_update->phuongthucthanhtoan,
    //                 'phuongthucthanhtoan_ta' => $hop_dong_update->phuongthucthanhtoan_ta,
    
    //                 'diadiemgiaohang' => $hop_dong_update->diadiemgiaohang,
    //                 'diadiemgiaohang_ta' => $hop_dong_update->diadiemgiaohang_ta,
    
    //                 'diachi_diadiemgiaohang' => $hop_dong_update->diachi_diadiemgiaohang,
    //                 'diachi_diadiemgiaohang_ta' => $hop_dong_update->diachi_diadiemgiaohang_ta,
    
    //                 'thoigiangiaohang' => $hop_dong_update->thoigiangiaohang,
                    
    //                 'phuongthucgiaohang' => $hop_dong_update->phuongthucgiaohang,
    //                 'phuongthucgiaohang_ta' => $hop_dong_update->phuongthucgiaohang_ta,
    
    //                 'giaohangtungphan' => $hop_dong_update->giaohangtungphan,
    
    //                 'phivanchuyen' => $hop_dong_update->phivanchuyen,
    //                 'phivanchuyen_ta' => $hop_dong_update->phivanchuyen_ta,
    
    //                 'soluongbanin' => $hop_dong_update->soluongbanin,
    
    //                 'cpt' => $hop_dong_update->cpt,
    //                 'po' => $hop_dong_update->po,
    
    //                 'trungchuyen' => $hop_dong_update->trungchuyen,
    //                 'loadingport' => $hop_dong_update->loadingport,
    //                 'dischargport' => $hop_dong_update->dischargport,
    
    //                 'tinhtrang' => $hop_dong_update->tinhtrang,
    //                 'username_approve' => $hop_dong_update->username_approve,
    
    //                 'username' => Auth::user()->username,
        
    //                 'trangthai' => 'Up file TDG'
    
    //             ]);
    
    //         });

    //         $numberFiles = count(Storage::disk('public')->allFiles('TDG/' . $this->shd));

    //         $ext = $this->filetdg->extension();

    //         $this->filetdg->storeAs('TDG/' . $this->shd, $this->shd . '- TDG ver - '. $numberFiles + 1 . '.' . $ext, 'public');

    //         flash()->addFlash('success', 'Upload thành công.','Thông báo');
    //         $this->filetdg = '';
    //         $this->emit('uploadTDG');

    //     };

    // }

    // public function search(){

    //     $search_fields = [
    //         'hop_dong.sohd',
    //         'ben_b_vs_hop_dong.ten_tv',
    //         'hop_dong.username',
    //         'hop_dong.tinhtrang'
    //     ];
    //     $search_terms = explode(',', $this->search);

    //     if($this->canhan_tatca == 'canhan'){

    //         $query = ModelsHopDong::query();

    //         $query->join('ben_a_vs_hop_dong', 'hop_dong.bena', '=', 'ben_a_vs_hop_dong.id');
    //         $query->join('ben_b_vs_hop_dong', 'hop_dong.benb', '=', 'ben_b_vs_hop_dong.id');
    //         $query->join('dai_dien_ben_a_vs_hop_dong', 'hop_dong.dai_dien_ben_a', '=', 'dai_dien_ben_a_vs_hop_dong.id');

    //         foreach ($search_terms as $term) {
    //             $query->orWhere(function ($query) use ($search_fields, $term) {

    //                 foreach ($search_fields as $field) {
    //                     $query->orWhere($field, 'LIKE', '%' . trim($term) . '%');
    //                 }
    //             });
    //         }

    //         if($this->tuNgay == null && $this->denNgay == null){

    //             $query->whereBetween('hop_dong.created_at', ['2023-05-01 00:00:00', '2099-01-01 00:00:00']);

    //         }elseif($this->tuNgay != null && $this->denNgay != null){

    //             $query->whereBetween('hop_dong.created_at', [$this->tuNgay . ' 00:00:00', $this->denNgay . ' 23:59:59']);

    //         }elseif($this->tuNgay == null && $this->denNgay != null){

    //             $query->whereBetween('hop_dong.created_at', ['2023-05-01 00:00:00', $this->denNgay . ' 23:59:59']);

    //         }
    //         elseif($this->tuNgay != null && $this->denNgay == null){

    //             $query->whereBetween('hop_dong.created_at', [$this->tuNgay . '00:00:00', '2099-01-01 00:00:00']);

    //         }

    //         $query->where('hop_dong.username', '=' , Auth::user()->username);
    //         $query->where('hop_dong.isDelete', null);
    //         $query->select('hop_dong.sohd', 'hop_dong.ngayhethanhd','hop_dong.loaihopdong', 'ben_b_vs_hop_dong.ten_tv', 'hop_dong.username', 'hop_dong.tinhtrang', 'hop_dong.created_at', 'hop_dong.updated_at');

    //         $this->search_result = $query->paginate($this->paginate);

    //     }elseif($this->canhan_tatca == 'tatca'){

    //         $query = ModelsHopDong::query();

    //         $query->join('ben_a_vs_hop_dong', 'hop_dong.bena', '=', 'ben_a_vs_hop_dong.id');
    //         $query->join('ben_b_vs_hop_dong', 'hop_dong.benb', '=', 'ben_b_vs_hop_dong.id');
    //         $query->join('dai_dien_ben_a_vs_hop_dong', 'hop_dong.dai_dien_ben_a', '=', 'dai_dien_ben_a_vs_hop_dong.id');

    //         foreach ($search_terms as $term) {
    //             $query->orWhere(function ($query) use ($search_fields, $term) {

    //                 foreach ($search_fields as $field) {
    //                     $query->orWhere($field, 'LIKE', '%' . trim($term) . '%');
    //                 }
    //             });
    //         }

    //         if($this->tuNgay == null && $this->denNgay == null){

    //             $query->whereBetween('hop_dong.created_at', ['2023-05-01 00:00:00', '2099-01-01 00:00:00']);

    //         }elseif($this->tuNgay != null && $this->denNgay != null){
    //             $query->whereBetween('hop_dong.created_at', [$this->tuNgay . ' 00:00:00', $this->denNgay . ' 23:59:59']);

    //         }elseif($this->tuNgay == null && $this->denNgay != null){
    //             $query->whereBetween('hop_dong.created_at', ['2023-05-01 00:00:00', $this->denNgay . ' 23:59:59']);

    //         }
    //         elseif($this->tuNgay != null && $this->denNgay == null){
    //             $query->whereBetween('hop_dong.created_at', [$this->tuNgay . ' 00:00:00', '2099-01-01 00:00:00']);

    //         }

    //         $query->where('hop_dong.isDelete', null);
    //         $query->select('hop_dong.sohd', 'hop_dong.ngayhethanhd','hop_dong.loaihopdong', 'ben_b_vs_hop_dong.ten_tv', 'hop_dong.username', 'hop_dong.tinhtrang', 'hop_dong.created_at', 'hop_dong.updated_at');

    //         $this->search_result = $query->paginate($this->paginate);

    //     }elseif($this->canhan_tatca == 'doiduyet'){

    //         $query = ModelsHopDong::query();

    //         $query->join('ben_a_vs_hop_dong', 'hop_dong.bena', '=', 'ben_a_vs_hop_dong.id');
    //         $query->join('ben_b_vs_hop_dong', 'hop_dong.benb', '=', 'ben_b_vs_hop_dong.id');
    //         $query->join('dai_dien_ben_a_vs_hop_dong', 'hop_dong.dai_dien_ben_a', '=', 'dai_dien_ben_a_vs_hop_dong.id');

    //         foreach ($search_terms as $term) {
    //             $query->orWhere(function ($query) use ($search_fields, $term) {

    //                 foreach ($search_fields as $field) {
    //                     $query->orWhere($field, 'LIKE', '%' . trim($term) . '%');
    //                 }
    //             });
    //         }

    //         if($this->tuNgay == null && $this->denNgay == null){

    //             $query->whereBetween('hop_dong.created_at', ['2023-05-01 00:00:00', '2099-01-01 00:00:00']);

    //         }elseif($this->tuNgay != null && $this->denNgay != null){
    //             $query->whereBetween('hop_dong.created_at', [$this->tuNgay . ' 00:00:00', $this->denNgay . ' 23:59:59']);

    //         }elseif($this->tuNgay == null && $this->denNgay != null){
    //             $query->whereBetween('hop_dong.created_at', ['2023-05-01 00:00:00', $this->denNgay . ' 23:59:59']);

    //         }
    //         elseif($this->tuNgay != null && $this->denNgay == null){
    //             $query->whereBetween('hop_dong.created_at', [$this->tuNgay . ' 00:00:00', '2099-01-01 00:00:00']);

    //         }

    //         $query->where('hop_dong.isDelete', null);
    //         $query->where('hop_dong.tinhtrang',  'New');
    //         $query->select('hop_dong.sohd', 'hop_dong.ngayhethanhd','hop_dong.loaihopdong', 'ben_b_vs_hop_dong.ten_tv', 'hop_dong.username', 'hop_dong.tinhtrang', 'hop_dong.created_at', 'hop_dong.updated_at');

    //         $this->search_result = $query->paginate($this->paginate);

    //     }elseif($this->canhan_tatca == 'daduyet'){

    //         $query = ModelsHopDong::query();

    //         $query->join('ben_a_vs_hop_dong', 'hop_dong.bena', '=', 'ben_a_vs_hop_dong.id');
    //         $query->join('ben_b_vs_hop_dong', 'hop_dong.benb', '=', 'ben_b_vs_hop_dong.id');
    //         $query->join('dai_dien_ben_a_vs_hop_dong', 'hop_dong.dai_dien_ben_a', '=', 'dai_dien_ben_a_vs_hop_dong.id');

    //         foreach ($search_terms as $term) {
    //             $query->orWhere(function ($query) use ($search_fields, $term) {

    //                 foreach ($search_fields as $field) {
    //                     $query->orWhere($field, 'LIKE', '%' . trim($term) . '%');
    //                 }
    //             });
    //         }

    //         if($this->tuNgay == null && $this->denNgay == null){

    //             $query->whereBetween('hop_dong.created_at', ['2023-05-01 00:00:00', '2099-01-01 00:00:00']);

    //         }elseif($this->tuNgay != null && $this->denNgay != null){
    //             $query->whereBetween('hop_dong.created_at', [$this->tuNgay . ' 00:00:00', $this->denNgay . ' 23:59:59']);

    //         }elseif($this->tuNgay == null && $this->denNgay != null){
    //             $query->whereBetween('hop_dong.created_at', ['2023-05-01 00:00:00', $this->denNgay . ' 23:59:59']);

    //         }
    //         elseif($this->tuNgay != null && $this->denNgay == null){
    //             $query->whereBetween('hop_dong.created_at', [$this->tuNgay . ' 00:00:00', '2099-01-01 00:00:00']);

    //         }

    //         $query->where('hop_dong.isDelete', null);
    //         $query->where('hop_dong.tinhtrang',  'Approved');
    //         $query->select('hop_dong.sohd', 'hop_dong.ngayhethanhd','hop_dong.loaihopdong', 'ben_b_vs_hop_dong.ten_tv', 'hop_dong.username', 'hop_dong.tinhtrang', 'hop_dong.created_at', 'hop_dong.updated_at');

    //         $this->search_result = $query->paginate($this->paginate);

    //     }

    // }

    public function timKiem(){

        $this->state = 'timKiem';

        $this->updatingSearch();

    }

    public function render()
    {
        if($this->sohd_chitiethopdong != ''){

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

            $hopdong = ModelsHopDong::join('ben_a_vs_hop_dong', 'hop_dong.bena', '=', 'ben_a_vs_hop_dong.id')
                                    ->join('ben_b_vs_hop_dong', 'hop_dong.benb', '=', 'ben_b_vs_hop_dong.id')
                                    ->join('dai_dien_ben_a_vs_hop_dong', 'hop_dong.dai_dien_ben_a', '=', 'dai_dien_ben_a_vs_hop_dong.id')
                                    ->join('loai_hop_dong', 'hop_dong.loaihopdong', '=', 'loai_hop_dong.id')
                                    ->where('hop_dong.sohd', $this->sohd_chitiethopdong)
                                    ->select($select)
                                    ->first();

            $sanpham = SanPham::where('sohd', $this->sohd_chitiethopdong)->first();

            if($hopdong->loaihopdong == '1' || $hopdong->loaihopdong == '2'){

                $danhsachfileHD = Storage::disk('public')->allFiles('HD/' . $this->sohd_chitiethopdong);
                $danhsachfilePhuluc = Storage::disk('public')->allFiles('Addendum/' . $this->sohd_chitiethopdong);
                //$danhsachfileTDG = Storage::disk('public')->allFiles('TDG/' . $this->sohd_chitiethopdong);

            }else{

                $danhsachfileHD = Storage::disk('public')->allFiles('HD/' . str_replace('/','_',$this->sohd_chitiethopdong));
                $danhsachfilePhuluc = Storage::disk('public')->allFiles('Addendum/' . str_replace('/','_',$this->sohd_chitiethopdong));
                //$danhsachfileTDG = Storage::disk('public')->allFiles('TDG/' . $this->sohd_chitiethopdong);
            }
        }else{

            $hopdong = null;
            $sanpham = null;
            $danhsachfileHD = null;
            $danhsachfilePhuluc = null;
            //$danhsachfileTDG = null;
        }

        $danhsachbena = $this->danhsachbena;

        $danhsachbenb = $this->danhsachbenb;

        $danhsachdaidienbena = $this->danhsachdaidienbena;

        $listdonggoi = $this->listdonggoi;

        $listphuongthucgiaohang = $this->listphuongthucgiaohang;

        if($this->donggoi != 'Khác'){

            $this->donggoikhac = '';
        }

        if($this->donggoi_ta != 'Other'){

            $this->donggoikhac_ta = '';
        }

        if($this->phuongthucgiaohang != 'Khác'){

            $this->phuongthucgiaohangkhac = '';

        }

        if($this->phuongthucgiaohang_ta != 'Other'){

            $this->phuongthucgiaohangkhac_ta = '';

        }
        if ($this->state == 'main' || $this->state == 'timKiem') {
            
            $query = ModelsHopDong::query();

            $query->join('ben_a_vs_hop_dong', 'hop_dong.bena', '=', 'ben_a_vs_hop_dong.id');
            $query->join('ben_b_vs_hop_dong', 'hop_dong.benb', '=', 'ben_b_vs_hop_dong.id');
            $query->join('dai_dien_ben_a_vs_hop_dong', 'hop_dong.dai_dien_ben_a', '=', 'dai_dien_ben_a_vs_hop_dong.id');
            $query->where('hop_dong.isDelete', null);

            if($this->tuNgay == null && $this->denNgay == null){

                $query->whereBetween('hop_dong.created_at', ['2023-05-01 00:00:00', '2099-01-01 00:00:00']);

            }elseif($this->tuNgay != null && $this->denNgay != null){

                $query->whereBetween('hop_dong.created_at', [$this->tuNgay . ' 00:00:00', $this->denNgay . ' 23:59:59']);

            }elseif($this->tuNgay == null && $this->denNgay != null){

                $query->whereBetween('hop_dong.created_at', ['2023-05-01 00:00:00', $this->denNgay . ' 23:59:59']);

            }
            elseif($this->tuNgay != null && $this->denNgay == null){

                $query->whereBetween('hop_dong.created_at', [$this->tuNgay . ' 00:00:00', '2099-01-01 00:00:00']);

            }

            $query->where(function ($query){

                $query->whereRaw("'" . $this->userTimKiem . "'" . "=''");
                $query->orWhere('hop_dong.username', $this->userTimKiem);

            });

            $query->where(function ($query){

                $query->whereRaw("'" . $this->soHDTimKiem . "'" . "=''");
                $query->orWhere('hop_dong.sohd','like', '%' . $this->soHDTimKiem . '%');

            });

            $query->where(function ($query){

                $query->whereRaw("'" . $this->tenKHTimKiem . "'" . "=''");
                $query->orWhere('ben_b_vs_hop_dong.ten_tv','like', '%' . $this->tenKHTimKiem . '%');

            });

            $query->where(function ($query){

                $query->whereRaw("'" . $this->loaiHDTimKiem . "'" . "=''");
                $query->orWhere('hop_dong.loaihopdong', $this->loaiHDTimKiem);

            });

            $query->where(function ($query){

                $query->whereRaw("'" . $this->trangThaiTimKiem . "'" . "='TatCa'");
                $query->orWhere('hop_dong.tinhtrang', $this->trangThaiTimKiem);

            });

            // $query->where(function($query){

            //     if($this->canhan_tatca == 'doiduyet'){

            //         if(Auth::user()->hasPermissionTo('create_contracts')){

            //             $query->orWhere(function($query){

            //                 $query->where('hop_dong.tinhtrang',  'New');
            //                 $query->where(function($query){

            //                     $query->where('hop_dong.username',  Auth::user()->username);
            //                     $query->orWhere('hop_dong.username', $this->userTimKiem);

            //                 });
    
            //             }); 

            //         }

            //         if(Auth::user()->hasPermissionTo('approve_contracts')){

            //             $query->orWhere(function($query){

            //                 $query->where('hop_dong.tinhtrang',  'New');
    
            //             }); 

            //         }

            //     }elseif($this->canhan_tatca == 'daduyet'){

            //         if(Auth::user()->hasPermissionTo('create_contracts')){

            //             $query->orWhere(function($query){

            //                 $query->where('hop_dong.tinhtrang', '<>',  'New');
            //                 $query->where(function($query){

            //                     $query->where('hop_dong.username',  Auth::user()->username);
            //                     $query->orWhere('hop_dong.username', $this->userTimKiem);

            //                 });
    
            //             }); 

            //         }

            //         if(Auth::user()->hasPermissionTo('approve_contracts')){

            //             $query->orWhere(function($query){

            //                 $query->where('hop_dong.tinhtrang', '<>',  'New');
    
            //             }); 

            //         }
            //     }
            // });

            $query->select('hop_dong.sohd', 'hop_dong.ngayhethanhd','hop_dong.loaihopdong', 'ben_b_vs_hop_dong.ten_tv', 'hop_dong.username', 'hop_dong.tinhtrang', 'hop_dong.created_at', 'hop_dong.updated_at');
                
            session(['main' => $query->paginate($this->paginate)]);

        }

        // if($this->search == ''){

        //     if($this->canhan_tatca == 'doiduyet'){

        //         $query = ModelsHopDong::query();

        //         $query->join('ben_a_vs_hop_dong', 'hop_dong.bena', '=', 'ben_a_vs_hop_dong.id');
        //         $query->join('ben_b_vs_hop_dong', 'hop_dong.benb', '=', 'ben_b_vs_hop_dong.id');
        //         $query->join('dai_dien_ben_a_vs_hop_dong', 'hop_dong.dai_dien_ben_a', '=', 'dai_dien_ben_a_vs_hop_dong.id');
        //         $query->where('hop_dong.isDelete', null);
        //         $query->where('hop_dong.tinhtrang',  'New');

        //         if($this->tuNgay == null && $this->denNgay == null){

        //             $query->whereBetween('hop_dong.created_at', ['2023-05-01 00:00:00', '2099-01-01 00:00:00']);

        //         }elseif($this->tuNgay != null && $this->denNgay != null){

        //             $query->whereBetween('hop_dong.created_at', [$this->tuNgay . ' 00:00:00', $this->denNgay . ' 23:59:59']);

        //         }elseif($this->tuNgay == null && $this->denNgay != null){

        //             $query->whereBetween('hop_dong.created_at', ['2023-05-01 00:00:00', $this->denNgay . ' 23:59:59']);

        //         }
        //         elseif($this->tuNgay != null && $this->denNgay == null){

        //             $query->whereBetween('hop_dong.created_at', [$this->tuNgay . ' 00:00:00', '2099-01-01 00:00:00']);

        //         }

        //         $query->select('hop_dong.sohd', 'hop_dong.ngayhethanhd','hop_dong.loaihopdong', 'ben_b_vs_hop_dong.ten_tv', 'hop_dong.username', 'hop_dong.tinhtrang', 'hop_dong.created_at', 'hop_dong.updated_at');
                
        //         $danhsachhopdong = $query->paginate($this->paginate);

        //     }elseif($this->canhan_tatca == 'daduyet'){

        //         $query = ModelsHopDong::query();

        //         $query->join('ben_a_vs_hop_dong', 'hop_dong.bena', '=', 'ben_a_vs_hop_dong.id');
        //         $query->join('ben_b_vs_hop_dong', 'hop_dong.benb', '=', 'ben_b_vs_hop_dong.id');
        //         $query->join('dai_dien_ben_a_vs_hop_dong', 'hop_dong.dai_dien_ben_a', '=', 'dai_dien_ben_a_vs_hop_dong.id');
        //         $query->where('hop_dong.isDelete', null);
        //         $query->where('hop_dong.tinhtrang',  'Approved');

        //         if($this->tuNgay == null && $this->denNgay == null){

        //             $query->whereBetween('hop_dong.created_at', ['2023-05-01 00:00:00', '2099-01-01 00:00:00']);

        //         }elseif($this->tuNgay != null && $this->denNgay != null){

        //             $query->whereBetween('hop_dong.created_at', [$this->tuNgay . ' 00:00:00', $this->denNgay . ' 23:59:59']);

        //         }elseif($this->tuNgay == null && $this->denNgay != null){

        //             $query->whereBetween('hop_dong.created_at', ['2023-05-01 00:00:00', $this->denNgay . ' 23:59:59']);

        //         }
        //         elseif($this->tuNgay != null && $this->denNgay == null){

        //             $query->whereBetween('hop_dong.created_at', [$this->tuNgay . ' 00:00:00', '2099-01-01 00:00:00']);

        //         }

        //         $query->select('hop_dong.sohd', 'hop_dong.ngayhethanhd','hop_dong.loaihopdong', 'ben_b_vs_hop_dong.ten_tv', 'hop_dong.username', 'hop_dong.tinhtrang', 'hop_dong.created_at', 'hop_dong.updated_at');
                
        //         $danhsachhopdong = $query->paginate($this->paginate);

        //     }elseif($this->canhan_tatca == 'tatca'){

        //         $query = ModelsHopDong::query();

        //         $query->join('ben_a_vs_hop_dong', 'hop_dong.bena', '=', 'ben_a_vs_hop_dong.id');
        //         $query->join('ben_b_vs_hop_dong', 'hop_dong.benb', '=', 'ben_b_vs_hop_dong.id');
        //         $query->join('dai_dien_ben_a_vs_hop_dong', 'hop_dong.dai_dien_ben_a', '=', 'dai_dien_ben_a_vs_hop_dong.id');
        //         $query->where('hop_dong.isDelete', null);

        //         if($this->tuNgay == null && $this->denNgay == null){

        //             $query->whereBetween('hop_dong.created_at', ['2023-05-01 00:00:00', '2099-01-01 00:00:00']);

        //         }elseif($this->tuNgay != null && $this->denNgay != null){

        //             $query->whereBetween('hop_dong.created_at', [$this->tuNgay . ' 00:00:00', $this->denNgay . ' 23:59:59']);

        //         }elseif($this->tuNgay == null && $this->denNgay != null){

        //             $query->whereBetween('hop_dong.created_at', ['2023-05-01 00:00:00', $this->denNgay . ' 23:59:59']);

        //         }
        //         elseif($this->tuNgay != null && $this->denNgay == null){

        //             $query->whereBetween('hop_dong.created_at', [$this->tuNgay . ' 00:00:00', '2099-01-01 00:00:00']);

        //         }

        //         $query->select('hop_dong.sohd', 'hop_dong.ngayhethanhd','hop_dong.loaihopdong', 'ben_b_vs_hop_dong.ten_tv', 'hop_dong.username', 'hop_dong.tinhtrang', 'hop_dong.created_at', 'hop_dong.updated_at');
                
        //         $danhsachhopdong = $query->paginate($this->paginate);

        //     }

        // }else{

        //     $this->search();
        //     $danhsachhopdong = $this->search_result;

        // }

        $this->danhSachSaleAdmin = User::permission('create_contracts')->get();

        return view('livewire.hop-dong', compact('danhsachbena','danhsachbenb','danhsachdaidienbena','hopdong','sanpham','danhsachfileHD','danhsachfilePhuluc','listdonggoi','listphuongthucgiaohang'));
    }
}
