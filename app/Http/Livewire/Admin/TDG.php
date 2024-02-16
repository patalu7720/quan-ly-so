<?php

namespace App\Http\Livewire\Admin;

use App\Mail\TDG as MailTDG;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class TDG extends Component
{
    public $soTDG, $capDuyet;

    public function submit(){

        $phieuTDG = DB::table('phieu_tdg')
        ->where('so_phieu', $this->soTDG)
        ->first();

        $content = DB::table('phieu_tdg_content')
        ->where('so_phieu', $this->soTDG)
        ->first();

        if(in_array($this->capDuyet, ['1','2','3'])){

            $ccMail = [];

            $ccMail = array_merge($ccMail, [$content->mail_to]);
    
            $ccMail = array_merge($ccMail, [$content->mail_admin]);

            if($content->mail_cc_1 != ''){

                $ccMail = array_merge($ccMail, [$content->mail_cc_1]);
    
            }
    
            if($content->mail_cc_2 != ''){
    
                $ccMail = array_merge($ccMail, [$content->mail_cc_1]);
    
            }

            $user = User::permission('approve_' . $this->capDuyet . '_tdg')->first();

            Mail::to($user->email)
            ->cc($ccMail)
            ->send(new MailTDG($this->soTDG, 'Approve ' . $this->capDuyet, $phieuTDG->customer, $content->content, Carbon::now()));
            
            flash()->addSuccess('Thành công.');

        }elseif($this->capDuyet == '4'){
        
            Mail::to('md@century.vn')->send(new MailTDG($this->soTDG, 'Approve 4', $phieuTDG->customer, $content->content, Carbon::now()));
            flash()->addSuccess('Thành công.');
        
        }

    }

    public function render()
    {
        return view('livewire.admin.t-d-g')->layout('layouts.adminApp');
    }
}
