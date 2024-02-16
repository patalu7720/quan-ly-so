<?php

namespace App\Http\Controllers;

use App\Mail\HopDong;
use App\Mail\PhieuTKSX as MailPhieuTKSX;
use App\Mail\PhieuXXDH as MailPhieuXXDH;
use App\Mail\TTDHMail;
use App\Mail\WarningTimeOut_HD_Scan;
use App\Mail\WarningTimeOut_TDG_HD;
use App\Mail\WarningTimeOutApproveXXDH;
use App\Models\EmailQuanLy;
use App\Models\PhieuTKSX;
use App\Models\PhieuXXDH;
use App\Models\SO;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;
use File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use OpenSpout\Common\Entity\Style\Border;
use OpenSpout\Common\Helper\Escaper\XLSX as EscaperXLSX;
use PhpOffice\PhpSpreadsheet\Reader\Xls\Style\Border as StyleBorder;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border as PhpSpreadsheetStyleBorder;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriterXlsx;

class UserController extends Controller
{
    public $redirectTo;


    public function dangnhap(Request $request){
        $messages = [
            'username.required' => 'Tài khoản không được để trống',
            'password.required' => 'Mật khẩu không được để trống',
        ];

        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ],$messages);

        $username = $request->input('username');
        $password = $request->input('password');

        if (Auth::attempt(['username' => $username, 'password' => $password, 'isLock' => '0'])) { 

            session()->regenerate();

            // if (session()->has('url.intended')) {
            //     $redirectTo = session()->get('url.intended');
            //     session()->forget('url.intended');

            //     return redirect($redirectTo);
            // }else 
            return redirect()->route('so'); 
        }

        return back()->withErrors([
            'username' => 'Thông tin đăng nhập không chính xác.',
        ])->onlyInput('username');
    }

    public function dangxuat(Request $request)
    {
        Auth::logout();
 
        $request->session()->invalidate();
        $request->session()->regenerateToken();
 
        return redirect('/');
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

    public function test()
    {
        // $danhSachSo = SO::whereNotNull('phieu_tksx')->get();

        // foreach ($danhSachSo as $item) {

        //     $danhSachTKSX = PhieuTKSX::where('so', $item->so)->get();

        //     $string = '';

        //     foreach ($danhSachTKSX as $item2) {
        //         if($string == '')
        //         {
        //             $string = $item2->so_phieu;
        //         }else{
        //             $string = $string . ',' . $item2->so_phieu;
        //         }
        //     }

        //     $so = SO::where('so', $item->so)->first();
        //     $so->phieu_tksx = $string;
        //     $so->save();

        // }

    }

}
