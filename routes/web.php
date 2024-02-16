<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HDController;
use App\Http\Controllers\UserController;
use App\Http\Livewire\Admin;
use App\Http\Livewire\Admin\TDG as AdminTDG;
use App\Http\Livewire\BaoCao\BCTDG;
use App\Http\Livewire\BaoGia;
use App\Http\Livewire\BCHopDong;
use App\Http\Livewire\BCTTDH;
use App\Http\Livewire\CancleRevisedSo;
use App\Http\Livewire\ChiTietHopDong;
use App\Http\Livewire\ChiTietPhieuXXDH;
use App\Http\Livewire\Counter;
use App\Http\Livewire\HopDong;
use App\Http\Livewire\HopDongXuatKhau;
use App\Http\Livewire\MoPhong;
use App\Http\Livewire\Permissions;
use App\Http\Livewire\PhieuThayDoiMaHang;
use App\Http\Livewire\PhieuTKSXFDY;
use App\Http\Livewire\PhieuXXDH;
use App\Http\Livewire\QuanLyUser;
use App\Http\Livewire\Roles;
use App\Http\Livewire\SO;
use App\Http\Livewire\SOFile;
use App\Http\Livewire\SOTam;
use App\Http\Livewire\TC;
use App\Http\Livewire\TDG;
use App\Http\Livewire\TDGDuyet;
use App\Http\Livewire\TDGDuyetCap1;
use App\Http\Livewire\TDGDuyetCap2;
use App\Http\Livewire\TDGDuyetCap3;
use App\Http\Livewire\TDGDuyetCap4;
use App\Http\Livewire\TDGReject;
use App\Http\Livewire\ThayDoiPassWord;
use App\Http\Livewire\TheoDoiThuMau;
use App\Http\Livewire\TheoDoiTKSXDTY;
use App\Http\Livewire\TieuChuanKhachHang;
use App\Http\Livewire\TTDH;
use App\Http\Livewire\TTDHDuyet;
use App\Http\Livewire\TTDHReject;
use App\Http\Livewire\XacNhanDonHang;
use App\Jobs\SendMailPhieuXXDHJob;
use App\Mail\AlertContractMail;
use App\Mail\PhieuMHDTY;
use App\Mail\PhieuXXDH as MailPhieuXXDH;
use App\Models\HopDong as ModelsHopDong;
use App\Models\PhieuTBTDMHDTY;
use App\Models\PhieuTKSX;
use App\Models\PhieuXXDH as ModelsPhieuXXDH;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {

    session(['url.intended' => url()->previous()]);
    
    return view('client.dangnhap');

})->name('dangnhapform');

Route::post('/', [UserController::class,'dangnhap'])->name('dangnhap');

Route::post('/dangxuat', [UserController::class,'dangxuat'])->name('dangxuat');

Route::get('/thay-doi-mat-khau', ThayDoiPassWord::class)->name('thay-doi-mat-khau')->middleware('auth');

// Báo giá

Route::get('/bao-gia', BaoGia::class)->name('bao-gia')->middleware('auth');

// Xác nhận đơn hàng

Route::get('/xac-nhan-don-hang', XacNhanDonHang::class)->name('xac-nhan-don-hang')->middleware('auth');

// TDG

Route::get('/tdg', TDG::class)->name('tdg')->middleware('auth');

Route::get('/tdg-duyet/{cap_duyet}/{so_phieu}', TDGDuyet::class)->name('tdg-duyet');

Route::get('/tdg-tu-choi/{cap_tu_choi}/{so_phieu}', TDGReject::class)->name('tdg-tu-choi');

// TTDH

Route::get('/ttdh', TTDH::class)->name('ttdh')->middleware('auth');

Route::get('/ttdh-duyet/{cap_duyet}/{so_phieu}', TTDHDuyet::class)->name('ttdh-duyet');

Route::get('/ttdh-tu-choi/{cap_tu_choi}/{so_phieu}', TTDHReject::class)->name('ttdh-tu-choi');


// Hợp đồng

Route::get('/hop-dong', HopDong::class)->name('hop-dong')->middleware('auth');

// SO

Route::get('/so', SO::class)->name('so')->middleware('auth');

Route::get('/so/file/{so}', SOFile::class)->name('so-file')->middleware('auth');

// TC

Route::get('/tc', TC::class)->name('tc');

// Phiếu xem xét đơn hàng

Route::get('/phieu-xxdh', PhieuXXDH::class)->name('phieu-xxdh')->middleware('auth');

// Phiếu TKSX DTY

Route::get('/phieu-trien-khai-san-xuat-dty', PhieuThayDoiMaHang::class)->name('phieu-tbtdmhdty')->middleware('auth');

// Phiếu TKSX FDY

Route::get('/phieu-trien-khai-san-xuat-fdy', PhieuTKSXFDY::class)->name('phieu-tksx-fdy')->middleware('auth');

// Mô phỏng

Route::get('/mo-phong', MoPhong::class)->name('mo-phong')->middleware('auth');

// Mô phỏng

Route::get('/theo-doi-tksx-dty', TheoDoiTKSXDTY::class)->name('theo-doi-tksx-dty')->middleware('auth');

// Báo cáo

Route::get('/bc-hop-dong', BCHopDong::class)->name('bc-hop-dong')->middleware('auth');

Route::get('/bc-tdg', BCTDG::class)->name('bc-tdg')->middleware('auth');

Route::get('/bc-ttdh', BCTTDH::class)->name('bc-ttdh')->middleware('auth');

// Cancel Revised SO

Route::get('/cancel-revised-so', CancleRevisedSo::class)->name('cancel-revised-so')->middleware('auth');

// Cancel Revised SO

Route::get('/so-tam', SOTam::class)->name('so-tam')->middleware('auth');

// Tiêu chuẩn khách hàng

Route::get('/tieu-chuan-khach-hang', TieuChuanKhachHang::class)->name('tieu-chuan-khach-hang')->middleware('auth');

// Tiêu chuẩn khách hàng

Route::get('/theo-doi-thu-mau', TheoDoiThuMau::class)->name('theo-doi-thu-mau')->middleware('auth');

// Admin

Route::get('/admin', function () {

    return view('admin.login');
    
})->name('admin.login.form');

Route::post('/admin', [AdminController::class,'login'])->name('admin.login');

Route::post('/admin/logout', [AdminController::class,'logout'])->name('admin.logout');

Route::group(['prefix' => 'admin','middleware' => ['admin.auth']], function (){

    Route::get('/quan-ly-user', QuanLyUser::class)->name('admin.quan.ly.user');

    Route::get('/roles', Roles::class)->name('admin.roles');

    Route::get('/permissions', Permissions::class)->name('admin.permissions');

    Route::get('/tdg', AdminTDG::class)->name('admin.tdg');

});

Route::get('/test',[UserController::class, 'test']);


