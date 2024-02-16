<?php

namespace App\Http\Livewire;

use App\Mail\TTDHMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class TTDHDuyet extends Component
{
    public $username, $password, $capDuyet, $soPhieu;

    public function mount($cap_duyet,$so_phieu){

        $this->capDuyet = $cap_duyet;
        $this->soPhieu = $so_phieu;

    }

    public function duyetOutlook(){

        if (Auth::attempt(['username' => $this->username, 'password' => $this->password])) { 

            if(Auth::user()->hasPermissionTo('approve_'. $this->capDuyet .'_ttdh')){

                if($this->capDuyet == '3'){

                    $phieuTTDH = DB::table('phieu_ttdh')
                    ->where('so_phieu', $this->soPhieu)
                    ->first();

                    if($phieuTTDH->approved_3 == ''){
    
                        DB::table('phieu_ttdh')
                        ->where('so_phieu', $this->soPhieu)
                        ->update([
        
                            'approved_3' => Auth::user()->username,
                            'approved_3_at' => Carbon::now(),
    
                            'status' => 'Finish',
        
                            'updated_user' => Auth::user()->username,
                            'updated_at' => Carbon::now(),
        
                        ]);
        
                        DB::table('phieu_ttdh_log')->insert([
        
                            'so_phieu' => $phieuTTDH->so_phieu,
                            'status' => 'Finish',
                            'status_log' => 'Approved',
        
                            'created_user' => Auth::user()->username,
                            'updated_user' => Auth::user()->username,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                            
                        ]);
    
                        $danhsachfile = Storage::disk('ftp')->allFiles('TTDH/' . $this->soPhieu);
    
                        if(count($danhsachfile) > 0){
    
                            $file_ftp = Storage::disk('ftp')->get('TTDH/' . $this->soPhieu . '/' . $this->soPhieu . '.xlsx');
    
                            Storage::disk('public')->put('TTDH/' . $this->soPhieu . '.xlsx', $file_ftp);
    
                            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(Storage::disk('public')->path('TTDH/' . $this->soPhieu . '.xlsx'));
    
                            $TTDH = DB::table('phieu_ttdh')
                            ->where('so_phieu', $this->soPhieu)
                            ->get();
    
                            $sheet = $spreadsheet->getActiveSheet();
    
                            $sheet->setCellValue('A' . count($TTDH) + 34, $TTDH[0]->approved_1_at);
                            $sheet->setCellValue('C' . count($TTDH) + 34, $TTDH[0]->approved_2_at);
                            $sheet->setCellValue('E' . count($TTDH) + 34, $TTDH[0]->approved_3_at);

                            $user1 = User::where('username', $TTDH[0]->approved_1)->first();

                            $sheet->setCellValue('C' . count($TTDH) + 35, $user1->name);

                            $user2 = User::where('username', $TTDH[0]->approved_2)->first();

                            $sheet->setCellValue('C' . count($TTDH) + 35, $user2->name);

                            $user3 = User::where('username', $TTDH[0]->approved_3)->first();

                            $sheet->setCellValue('E' . count($TTDH) + 35, $user3->name);
                    
                            $writer = new Xlsx($spreadsheet);
                    
                            ob_start();
                            $writer->save('php://output');
                            $content = ob_get_contents();
                            ob_end_clean();
                    
                            Storage::disk('ftp')->put('TTDH/' . $this->soPhieu . '/' . $this->soPhieu . '.xlsx', $content);
                    
                            Storage::disk('public')->delete('TTDH/' . $this->soPhieu . '.xlsx');
    
                        }
    
                        $content = DB::table('phieu_ttdh_content')
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
                        ->send(new TTDHMail($this->soPhieu, 'Finish', $phieuTTDH->customer, $content->content, Carbon::now()));
                        flash()->addSuccess('Thành công.');
                        $this->emit('duyetWebModal');
        
                    }else{
                        sweetalert()->addError('Phiếu đã được duyệt cấp ' . $this->capDuyet . '.');
                        return;
                    }

                }else{

                    $phieuTTDH = DB::table('phieu_ttdh')
                    ->where('so_phieu', $this->soPhieu)
                    ->first();
    
                    if($phieuTTDH->{ 'approved_' . $this->capDuyet } == ''){
    
                        DB::table('phieu_ttdh')
                        ->where('so_phieu', $this->soPhieu)
                        ->update([
        
                            'approved_' . $this->capDuyet => Auth::user()->username,
                            'approved_' . $this->capDuyet . '_at' => Carbon::now(),
    
                            'status' => 'Approve ' . $this->capDuyet,
        
                            'updated_user' => Auth::user()->username,
                            'updated_at' => Carbon::now(),
        
                        ]);
        
                        DB::table('phieu_ttdh_log')->insert([
        
                            'so_phieu' => $phieuTTDH->so_phieu,
                            'status' => 'Approve ' . $this->capDuyet,
                            'status_log' => 'Approved',
        
                            'created_user' => Auth::user()->username,
                            'updated_user' => Auth::user()->username,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                            
                        ]);
    
                        $content = DB::table('phieu_ttdh_content')
                        ->where('so_phieu', $this->soPhieu)
                        ->first();
    
                        $ccMail = [];
    
                        if($content->mail_cc_1 != ''){
    
                            $ccMail = array_merge($ccMail, [$content->mail_cc_1]);
    
                        }
    
                        if($content->mail_cc_2 != ''){
    
                            $ccMail = array_merge($ccMail, [$content->mail_cc_1]);
    
                        }
    
                        $ccMail = array_merge($ccMail, [$content->mail_to, $content->mail_admin]);
    
                        $user = User::permission('approve_'. (int)$this->capDuyet + 1 .'_ttdh')->first();
    
                        Mail::to($user->email)
                        ->cc($ccMail)
                        ->send(new TTDHMail($this->soPhieu, 'Approve ' . (int)$this->capDuyet + 1, $phieuTTDH->customer, $content->content, Carbon::now()));
                        flash()->addSuccess('Thành công.');
                        $this->emit('duyetWebModal');
        
                    }else{
                        sweetalert()->addError('Phiếu đã được duyệt cấp ' . $this->capDuyet . '.');
                        return;
                    }

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
        return view('livewire.t-t-d-h-duyet')->layout('layouts.TTDHLayout');
    }
}
