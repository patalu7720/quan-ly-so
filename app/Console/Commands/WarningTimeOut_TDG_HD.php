<?php

namespace App\Console\Commands;

use App\Mail\WarningTimeOut_TDG_HD as MailWarningTimeOut_TDG_HD;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class WarningTimeOut_TDG_HD extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'warning-time-out_-t-d-g_-h-d';

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

            $danhSachHopDong = DB::table('hop_dong')
            ->select('so_tdg')
            ->where('so_tdg', '<>', '')
            ->get();

            $array = [];

            foreach ($danhSachHopDong as $item) {
                
                $array = array_merge($array,[$item->so_tdg]);

            }

            $danhSachTDG = DB::table('phieu_tdg')
            ->join('phieu_tdg_content', 'phieu_tdg.so_phieu', 'phieu_tdg_content.so_phieu')
            ->select('phieu_tdg.so_phieu', 'phieu_tdg.updated_at', 'phieu_tdg_content.mail_admin', 'phieu_tdg_content.mail_to', 'phieu_tdg_content.canh_bao', 'phieu_tdg.created_user')
            ->distinct('phieu_tdg.so_phieu', 'phieu_tdg.updated_at', 'phieu_tdg.created_user')
            ->where('phieu_tdg.status', 'Finish')
            ->whereNull('phieu_tdg.is_delete')
            ->whereNull('phieu_tdg_content.canh_bao')
            ->whereNotIn('phieu_tdg.so_phieu',$array)
            ->get();

            foreach ($danhSachTDG as $item) {

                if(Carbon::now()->isoFormat('DD/MM/YYYY') == Carbon::create($item->updated_at)->isoFormat('DD/MM/YYYY')){

                    if(Carbon::now()->hour - Carbon::create($item->updated_at)->hour > 7){

                        $users = User::role('sale_manager')->get();

                        Mail::to($item->mail_admin)
                            ->cc(array_merge($users->all(),['luongphan@soitheky.vn', $item->mail_to]))
                            ->send(new MailWarningTimeOut_TDG_HD($item->so_phieu, $item->created_user));

                        DB::table('canh_bao_log')
                        ->insert([

                            'loai' => 'Cảnh báo quá hạn tạo HD của TDG',
                            'so_phieu' => $item->so_phieu,
                            'username' => $item->created_user,
                            'created_at' => Carbon::now()

                        ]);

                    }

                }else{

                    if(Carbon::now()->diffInHours(Carbon::create($item->updated_at)) - 16 > 7){

                        $users = User::role('sale_manager')->get();

                        Mail::to($item->mail_admin)
                            ->cc(array_merge($users->all(),['luongphan@soitheky.vn', $item->mail_to]))
                            ->send(new MailWarningTimeOut_TDG_HD($item->so_phieu, $item->created_user));

                        DB::table('canh_bao_log')
                        ->insert([

                            'loai' => 'Cảnh báo quá hạn tạo HD của TDG',
                            'so_phieu' => $item->so_phieu,
                            'username' => $item->created_user,
                            'created_at' => Carbon::now()

                        ]);
                    }
                }
            }
        }
    }
}
