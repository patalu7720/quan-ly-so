<?php

namespace App\Console\Commands;

use App\Mail\WarningTimeOutApproveTKSX as MailWarningTimeOutApproveTKSX;
use App\Models\EmailQuanLy;
use App\Models\PhieuTKSX;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class WarningTimeOutApproveTKSX extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'warning-time-out-approve-t-k-s-x';

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
        $danhSachPhieuTKSX = PhieuTKSX::where('updated_at', '<', Carbon::now()->subMinutes(30))
        ->where('status', '<>', 'Finish')
        ->where('is_delete', null)
        ->get();

        if($danhSachPhieuTKSX != null){

            foreach ($danhSachPhieuTKSX as $item) {

                if($item->status == 'New'){

                    $emailQuanLyKHST = EmailQuanLy::where('chuc_vu', 'quan_ly_khst')->first();

                    $email = $emailQuanLyKHST->email;

                    Mail::to($email)->send(new MailWarningTimeOutApproveTKSX($item->so_phieu, 'KHST'));

                }elseif($item->status == 'KHST APPROVED'){
                    
                    $email = 'qa@century.vn';

                    Mail::to($email)->send(new MailWarningTimeOutApproveTKSX($item->so_phieu, 'QA'));

                }elseif($item->status == 'QA APPROVED'){

                    $emailQuanLySale = EmailQuanLy::where('chuc_vu', 'quan_ly_sale')->first();

                    $email = $item->sale;

                    Mail::to($email)->cc($emailQuanLySale->email)->send(new MailWarningTimeOutApproveTKSX($item->so_phieu, 'Sale'));

                }elseif($item->status == 'Sale APPROVED'){

                    $emailQuanLySale = EmailQuanLy::where('chuc_vu', 'quan_ly_sale')->first();

                    $email = $emailQuanLySale->email;
    
                    Mail::to($email)->send(new MailWarningTimeOutApproveTKSX($item->so_phieu, 'Sale Manager'));

                }elseif($item->status == 'SM APPROVED'){

                    $emailUserCreate = User::where('username', $item->created_user)->first();

                    $email = $emailUserCreate->email;

                    Mail::to($email)->send(new MailWarningTimeOutApproveTKSX($item->so_phieu, 'NV KHST'));

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

        return 0;
    }
}
