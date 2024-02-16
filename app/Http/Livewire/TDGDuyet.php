<?php

namespace App\Http\Livewire;

use App\Mail\TDG;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class TDGDuyet extends Component
{
    public $username, $password, $capDuyet, $soPhieu;

    public function mount($cap_duyet,$so_phieu){

        $this->capDuyet = $cap_duyet;
        $this->soPhieu = $so_phieu;

    }

    public function duyetOutlook(){

        if (Auth::attempt(['username' => $this->username, 'password' => $this->password])) { 

            if(Auth::user()->hasPermissionTo('approve_'. $this->capDuyet .'_tdg')){

                $phieuTDG = DB::table('phieu_tdg')
                ->where('so_phieu', $this->soPhieu)
                ->first();

                if($phieuTDG->{ 'approved_' . $this->capDuyet } == ''){

                    DB::table('phieu_tdg')
                    ->where('so_phieu', $this->soPhieu)
                    ->update([
    
                        'approved_' . $this->capDuyet => Auth::user()->username,
                        'approved_'. $this->capDuyet .'_at' => Carbon::now(),

                        'status' => 'Approve ' . $this->capDuyet,
    
                        'updated_user' => Auth::user()->username,
                        'updated_at' => Carbon::now(),
    
                    ]);
    
                    DB::table('phieu_tdg_log')->insert([
    
                        'so_phieu' => $phieuTDG->so_phieu,
                        'status' => 'Approve ' . $this->capDuyet,
                        'status_log' => 'Approved',
    
                        'created_user' => Auth::user()->username,
                        'updated_user' => Auth::user()->username,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                        
                    ]);

                    $content = DB::table('phieu_tdg_content')
                    ->where('so_phieu', $this->soPhieu)
                    ->first();

                    $ccMail = [];

                    $ccMail = array_merge($ccMail, [$content->mail_to, $content->mail_admin]);

                    if($content->mail_cc_1 != ''){

                        $ccMail = array_merge($ccMail, [$content->mail_cc_1]);

                    }

                    if($content->mail_cc_2 != ''){

                        $ccMail = array_merge($ccMail, [$content->mail_cc_1]);

                    }

                    if($this->capDuyet == '1' || $this->capDuyet == '2'){

                        $user = User::permission('approve_'. (int)$this->capDuyet + 1 .'_tdg')->first();

                        Mail::to($user->email)
                        ->cc($ccMail)
                        ->send(new TDG($this->soPhieu, 'Approve ' . (int)$this->capDuyet + 1, $phieuTDG->customer, $content->content, Carbon::now()));
                        flash()->addSuccess('Thành công.');

                    }elseif($this->capDuyet == '3'){

                        Mail::to('md@century.vn')->send(new TDG($this->soPhieu, 'Approve ' . (int)$this->capDuyet + 1, $phieuTDG->customer, $content->content, Carbon::now()));
                        flash()->addSuccess('Thành công.');

                    }
    
                }else{
                    sweetalert()->addError('Phiếu đã được duyệt cấp ' . $this->capDuyet . '.');
                    return;
                }

            }else{
                sweetalert()->addError('Tài khoản này không có quyền duyệt cấp ' . $this->capDuyet . '.');
                return;
            }

        }else{
            sweetalert()->addError('Thông tin đăng nhập không chính xác.');
            return;
        }

    }

    public function render()
    {
        if($this->capDuyet == '4'){

            $phieuTDG = DB::table('phieu_tdg')
            ->where('so_phieu', $this->soPhieu)
            ->first();

            if($phieuTDG->approved_4 == ''){

                DB::table('phieu_tdg')
                ->where('so_phieu', $this->soPhieu)
                ->update([

                    'approved_4' => 'MD',
                    'approved_4_at' => Carbon::now(),

                    'status' => 'Finish',

                    'updated_user' => 'MD',
                    'updated_at' => Carbon::now(),

                ]);

                DB::table('phieu_tdg_log')->insert([

                    'so_phieu' => $phieuTDG->so_phieu,
                    'status' => 'Finish',
                    'status_log' => 'Approved',

                    'created_user' => 'MD',
                    'updated_user' => 'MD',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

                $danhsachfile = Storage::disk('ftp')->allFiles('TDG/' . $this->soPhieu);

                if(count($danhsachfile) > 0){

                    $file_ftp = Storage::disk('ftp')->get('TDG/' . $this->soPhieu . '/' . $this->soPhieu . '.xlsx');

                    Storage::disk('public')->put('TDG/' . $this->soPhieu . '.xlsx', $file_ftp);

                    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(Storage::disk('public')->path('TDG/' . $this->soPhieu . '.xlsx'));

                    $TDG = DB::table('phieu_tdg')
                    ->where('so_phieu', $this->soPhieu)
                    ->get();

                    $sheet = $spreadsheet->getActiveSheet();

                    $sheet->setCellValue('A' . count($TDG) + 34, $TDG[0]->approved_1_at);
                    $sheet->setCellValue('C' . count($TDG) + 34, $TDG[0]->approved_2_at);
                    $sheet->setCellValue('E' . count($TDG) + 34, $TDG[0]->approved_3_at);
                    $sheet->setCellValue('G' . count($TDG) + 34, $TDG[0]->approved_4_at);

                    $user1 = User::where('username', $TDG[0]->approved_1)->first();

                    $sheet->setCellValue('A' . count($TDG) + 36, $user1->name);

                    $user2 = User::where('username', $TDG[0]->approved_2)->first();

                    $sheet->setCellValue('C' . count($TDG) + 35, $user2->name);

                    $user3 = User::where('username', $TDG[0]->approved_3)->first();

                    $sheet->setCellValue('E' . count($TDG) + 35, $user3->name);

                    $sheet->setCellValue('G' . count($TDG) + 35, 'DANG TRIEU HOA');
            
                    $writer = new Xlsx($spreadsheet);
            
                    ob_start();
                    $writer->save('php://output');
                    $content = ob_get_contents();
                    ob_end_clean();
            
                    Storage::disk('ftp')->put('TDG/' . $this->soPhieu . '/' . $this->soPhieu . '.xlsx', $content);
            
                    Storage::disk('public')->delete('TDG/' . $this->soPhieu . '.xlsx');

                }

                $content = DB::table('phieu_tdg_content')
                ->where('so_phieu', $this->soPhieu)
                ->first();

                $ccMail = [];

                if($content->mail_cc_1 != ''){

                    $ccMail = array_merge($ccMail, [$content->mail_cc_1]);

                }

                if($content->mail_cc_2 != ''){

                    $ccMail = array_merge($ccMail, [$content->mail_cc_1]);

                }

                $ccMail = array_merge($ccMail, [$content->mail_to]);

                Mail::to($content->mail_admin)
                ->cc($ccMail)
                ->send(new TDG($this->soPhieu, 'Finish', $phieuTDG->customer, $content->content, Carbon::now()));
                sweetalert()->addSuccess('Thành công.');
                
            }else{
                sweetalert()->addError('Phiếu đã được duyệt cấp ' . $this->capDuyet . '.');
            }
        }

        return view('livewire.t-d-g-duyet')->layout('layouts.tdgLayout');
    }
}
