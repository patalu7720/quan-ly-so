<?php

namespace App\Console\Commands;

use App\Mail\WarningTimeOut_XNDH_TDG as MailWarningTimeOut_XNDH_TDG;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class WarningTimeOut_XNDH_TDG extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'warning-time-out_-x-n-d-h_-t-d-g';

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
        if(Carbon::now()->englishDayOfWeek != 'Sunday' &&  Carbon::now()->hour >= 8 && Carbon::now()->hour < 17){

            $danhSachPhieuTDG = DB::table('phieu_tdg')
            ->select('so_phieu_xac_nhan_don_hang')
            ->where('so_phieu_xac_nhan_don_hang', '<>', '')
            ->get();

            $array = [];

            foreach ($danhSachPhieuTDG as $item) {
                
                $array = array_merge($array,[$item->so_phieu_xac_nhan_don_hang]);

            }

            $danhSachXNDH = DB::table('xac_nhan_don_hang')
            ->select('so_phieu', 'updated_at', 'created_user')
            ->distinct('so_phieu', 'updated_at', 'created_user')
            ->where('status', 'Finish')
            ->whereNotIn('so_phieu',$array)
            ->get();

            foreach ($danhSachXNDH as $item) {

                if(Carbon::now()->isoFormat('DD/MM/YYYY') == Carbon::create($item->updated_at)->isoFormat('DD/MM/YYYY')){

                    if(Carbon::now()->hour - Carbon::create($item->updated_at)->hour > 3){

                        $user = User::where('username', $item->created_user)->first();

                        $users = User::role('sale_manager')->get();

                        Mail::to($user->email)
                            ->cc(array_merge($users->all(),['luongphan@soitheky.vn']))
                            ->send(new MailWarningTimeOut_XNDH_TDG($item->so_phieu, $item->created_user));

                    }

                }else{

                    if(Carbon::now()->diffInHours(Carbon::create($item->updated_at)) - 16 > 4){
    
                        $user = User::where('username', $item->created_user)->first();

                        $users = User::role('sale_manager')->get();

                        Mail::to($user->email)
                            ->cc(array_merge($users->all(),['luongphan@soitheky.vn']))
                            ->send(new MailWarningTimeOut_XNDH_TDG($item->so_phieu, $item->created_user));

                    }
                
                }

            }
        }
    }
}
