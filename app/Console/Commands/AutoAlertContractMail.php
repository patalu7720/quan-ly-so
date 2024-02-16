<?php

namespace App\Console\Commands;

use App\Http\Livewire\HopDong;
use App\Mail\AlertContractMail;
use App\Models\HopDongLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class AutoAlertContractMail extends Command
{

    protected $commands = [
        Commands\InactiveUsers::class,
    ];
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto-alert-contract-mail';

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

        $ngayQuaHan = Carbon::now()->sub('7 day')->format('Y-m-d H:m:s');

        $hopdong = HopDong::where('tinhtrang', 'Scanned file received')
                            ->where('updated_at', '<' , $ngayQuaHan)
                            ->whereIn('loaihopdong', ['1','2'])
                            ->get();

        $mail = User::select('email')->get();

        if($hopdong != null){

            foreach ($mail as $recipient) {

                Mail::to($recipient)->send(new AlertContractMail($hopdong));

            }

        }

        return 0;
    }
}
