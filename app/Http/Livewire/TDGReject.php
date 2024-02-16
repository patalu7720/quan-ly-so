<?php

namespace App\Http\Livewire;

use App\Mail\TDG;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class TDGReject extends Component
{
    public $username, $password, $capTuChoi, $soPhieu, $reject;

    public function mount($cap_tu_choi,$so_phieu){

        $this->capTuChoi = $cap_tu_choi;
        $this->soPhieu = $so_phieu;

    }

    public function rejectOutlook(){

        if (Auth::attempt(['username' => $this->username, 'password' => $this->password])) { 

            if(Auth::user()->hasPermissionTo('approve_'. $this->capTuChoi .'_tdg')){

                $phieuTDG = DB::table('phieu_tdg')
                ->where('so_phieu', $this->soPhieu)
                ->first();

                if($phieuTDG->{ 'approved_' . $this->capTuChoi } != ''){

                    sweetalert()->addError('Phiếu đã được duyệt tại cấp ' . $this->capTuChoi . '.');
                    return;

                }

                if($phieuTDG->reject == ''){

                    DB::table('phieu_tdg')
                    ->where('so_phieu', $this->soPhieu)
                    ->update([

                        'reject' => Auth::user()->username,
                        'reject_at' => Carbon::now(),
                        'reason_for_reject' => $this->reject,

                        'status' => 'Reject ' . $this->capTuChoi,
    
                        'updated_user' => Auth::user()->username,
                        'updated_at' => Carbon::now(),
    
                    ]);
    
                    DB::table('phieu_tdg_log')->insert([
    
                        'so_phieu' => $phieuTDG->so_phieu,
                        'status' => 'Reject ' . $this->capTuChoi,
                        'status_log' => 'Rejected',
    
                        'created_user' => Auth::user()->username,
                        'updated_user' => Auth::user()->username,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                        
                    ]);

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

                    Mail::to($content->mail_to)
                    ->cc($ccMail)
                    ->send(new TDG($this->soPhieu, 'Reject', $phieuTDG->customer, $content->content, Carbon::now()));
                    sweetalert()->addSuccess('Thành công.');
    
                }else{
                    sweetalert()->addError('Phiếu đã được bị Reject.');
                    return;
                }

            }else{
                sweetalert()->addError('Tài khoản này không có quyền Reject tại cấp ' . $this->capTuChoi . '.');
                return;
            }

        }else{
            sweetalert()->addError('Thông tin đăng nhập không chính xác.');
            return;
        }

    }

    public function render()
    {
        return view('livewire.t-d-g-reject')->layout('layouts.tdgLayout');
    }
}
