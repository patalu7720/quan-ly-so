<?php

namespace App\Console\Commands;

use App\Mail\WarningTimeOut_HD_Scan as MailWarningTimeOut_HD_Scan;
use App\Mail\WarningTimeOut_HĐ_Goc;
use App\Mail\WarningTimeOut_TDG_HD;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class WarningTimeOut_HD_Scan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'warning-time-out_-h-d_-scan';

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

            $danhSachHopDong1 = DB::table('hop_dong')
            ->where('tinhtrang', 'Approved')
            ->whereNull('isDelete')
            ->get();

            foreach ($danhSachHopDong1 as $item) {
                
                if(Carbon::now()->diffInHours(Carbon::create($item->updated_at)) > 24){

                    $user = User::where('username', $item->username)->first();

                    $users = User::role('sale_manager')->get();

                    if($item->loaihopdong == 1 || $item->loaihopdong == 2){

                        $soHD = substr($item->sohd,4,5) . '/HĐMB-' . substr($item->sohd,0,4);

                    }else{
                    
                        $soHD = $item->sohd;
                    
                    }

                    Mail::to($user->email)
                        ->cc(array_merge($users->all(),['luongphan@soitheky.vn']))
                        ->send(new MailWarningTimeOut_HD_Scan($soHD, $item->username));

                    DB::table('canh_bao_log')
                        ->insert([

                            'loai' => 'Cảnh báo quá hạn tạo upload bản Scan',
                            'so_phieu' => $soHD,
                            'username' => $item->username,
                            'created_at' => Carbon::now()

                        ]);

                }

            }

            $danhSachHopDong2 = DB::table('hop_dong')
                ->where('tinhtrang', 'Scanned file received')
                ->whereNull('isDelete')
                ->get();
                
            foreach ($danhSachHopDong2 as $item) {
            
                if(Carbon::now()->diffInHours(Carbon::create($item->updated_at)) > 120){

                    $user = User::where('username', $item->username)->first();

                    $users = User::role('sale_manager')->get();

                    Mail::to($user->email)
                        ->cc(array_merge($users->all(),['luongphan@soitheky.vn']))
                        ->send(new WarningTimeOut_HĐ_Goc($soHD, $item->username));

                    DB::table('canh_bao_log')
                        ->insert([

                            'loai' => 'Cảnh báo quá hạn tạo upload bản Gốc',
                            'so_phieu' => $soHD,
                            'username' => $item->username,
                            'created_at' => Carbon::now()

                        ]);

                }

            } 

        }
        
    }
}
