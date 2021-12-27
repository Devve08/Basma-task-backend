<?php

namespace App\Console\Commands;

use App\Mail\DailyEmail as MailDailyEmail;
use App\Models\Admin;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class DailyEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send email daily';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $emails = Admin::pluck('email')->toArray();
       
            $date = Carbon::now();
            $yesterdate = Carbon::yesterday();
    
            $data = User::whereBetween('created_at', [
                $yesterdate,
                $date,
            ])->count();
            
        
        foreach($emails as $email){
             Mail::to($email)->send(new MailDailyEmail($data));
        }
    }
}
