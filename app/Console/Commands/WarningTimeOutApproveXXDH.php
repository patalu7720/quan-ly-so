<?php

namespace App\Console\Commands;

use App\Mail\WarningTimeOutApproveXXDH as MailWarningTimeOutApproveXXDH;
use App\Models\EmailQuanLy;
use App\Models\PhieuXXDH;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class WarningTimeOutApproveXXDH extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'warning-time-out-approve-x-x-d-h';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $danhSachPhieuXXDH = PhieuXXDH::where('is_delete', null)

        ->where('status', '<>', 'Finish')

        ->where(function($query){

            $query->where(function($query){

                $query->where('updated_at', '<', Carbon::now()->subMinutes(30));

                $query->whereNotIn('status', ['SM APPROVED', 'QA REQUESTED']);

            });
            
            $query->orWhere(function($query){

                $query->where('updated_at', '<', Carbon::now()->subMinutes(1440));
    
                $query->whereIn('status', ['SM APPROVED', 'QA REQUESTED']);
    
            });

        })
        ->get();

        if($danhSachPhieuXXDH != null){

            foreach ($danhSachPhieuXXDH as $item) {

                if($item->loai == 'dht'){

                    if($item->status == 'New'){
                    
                        $cc = [];

                        if($item->mailPhu1 != null){

                            $cc = array_merge($cc, [

                                $item->mailPhu1,

                            ]);

                        }

                        if($item->mailPhu2 != null){

                            $cc = array_merge($cc, [

                                $item->mailPhu2

                            ]);

                        }

                        $email = $item->mail_chinh;

                        Mail::to($email)->cc($cc)->send(new MailWarningTimeOutApproveXXDH($item->so_phieu, 'Sale'));
                        
    
                    }elseif($item->status == 'Sale APPROVED'){
    
                        $emailQuanLySale = EmailQuanLy::where('chuc_vu', 'quan_ly_sale')->first();

                        $email = $emailQuanLySale->email;
    
                        Mail::to($email)->send(new MailWarningTimeOutApproveXXDH($item->so_phieu, 'Sale Manager'));
    
                    }elseif($item->status == 'SM APPROVED'){
                        
                        if(Carbon::create($item->updated_at) < Carbon::now()->subHours(24)){

                            $email = 'khth@century.vn';
                            
                            Mail::to($email)->send(new MailWarningTimeOutApproveXXDH($item->so_phieu, 'KHST'));

                        }
                        
                    }elseif($item->status == 'KHST APPROVED'){
    
                        $email = 'qa@century.vn';

                        Mail::to('qa@century.vn')->send(new MailWarningTimeOutApproveXXDH($item->so_phieu, 'QA'));
    
                    }elseif($item->status == 'QA APPROVED'){
    
                        $email = $item->created_user;

                        Mail::to($email)->send(new MailWarningTimeOutApproveXXDH($item->so_phieu, 'Sale admin'));
    
                    }
                    
                    DB::table('canh_bao_log')
                    ->insert([

                        'loai' => 'Cảnh báo quá thời gian duyệt Phiếu TKSX',
                        'so_phieu' => $item->so_phieu,
                        'username' => $email,
                        'created_at' => Carbon::now()

                    ]);

                }else{

                    if($item->status == 'New'){

                        $cc = [];

                        if($item->mailPhu1 != null){

                            $cc = array_merge($cc, [

                                $item->mailPhu1,

                            ]);

                        }

                        if($item->mailPhu2 != null){

                            $cc = array_merge($cc, [

                                $item->mailPhu2

                            ]);

                        }
    
                        $email = $item->mail_chinh;

                        Mail::to($email)->cc($cc)->send(new MailWarningTimeOutApproveXXDH($item->so_phieu, 'Sale'));
    
                    }elseif($item->status == 'Sale APPROVED'){
    
                        $emailQuanLySale = EmailQuanLy::where('chuc_vu', 'quan_ly_sale')->first();

                        $email = $emailQuanLySale->email;
    
                        Mail::to($email)->send(new MailWarningTimeOutApproveXXDH($item->so_phieu, 'Sale Manager'));
    
                    }elseif($item->status == 'SM APPROVED'){
    
                        $email = 'qa@century.vn';

                        Mail::to($email)->send(new MailWarningTimeOutApproveXXDH($item->so_phieu, 'QA'));
    
                    }elseif($item->status == 'QA REQUESTED'){

                        if(Carbon::create($item->updated_at) < Carbon::now()->subHours(24)){

                            $email = 'khth@century.vn';

                            Mail::to('khth@century.vn')->send(new MailWarningTimeOutApproveXXDH($item->so_phieu, 'KHST'));

                        }
    
                    }elseif($item->status == 'KHST APPROVED'){
    
                        $email = 'qa@century.vn';

                        Mail::to('qa@century.vn')->send(new MailWarningTimeOutApproveXXDH($item->so_phieu, 'QA'));
    
                    }elseif($item->status == 'QA APPROVED'){

                        $email = $item->created_user;

                        Mail::to($email)->send(new MailWarningTimeOutApproveXXDH($item->so_phieu, 'Sale admin'));
    
                    }

                    DB::table('canh_bao_log')
                    ->insert([

                        'loai' => 'Cảnh báo quá thời gian duyệt Phiếu TKSX',
                        'so_phieu' => $item->so_phieu,
                        'username' => $email,
                        'created_at' => Carbon::now()

                    ]);
                    
                }
                
            }
        }

        return 0;
    }
}
