<?php

namespace App\Console\Commands;

use App\Mail\WarningTimeOutConfirmBaoGia as MailWarningTimeOutConfirmBaoGia;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class WarningTimeOutConfirmBaoGia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'warning-time-out-confirm-bao-gia';

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

            $danhSachBaoGia = DB::table('bao_gia')
            ->where('status', 'Finish')
            ->get();

            foreach ($danhSachBaoGia as $item) {

                if(Carbon::now()->diffInHours(Carbon::create($item->updated_at)) > 72 ){

                    $user = User::where('username', $item->created_user)->first();

                    $users = User::role('sale_manager')->get();

                    Mail::to($user->email)
                        ->cc($users)
                        ->send(new MailWarningTimeOutConfirmBaoGia($item->so_phieu, $item->created_user));

                }
                
            }
            
        }

    }
}
