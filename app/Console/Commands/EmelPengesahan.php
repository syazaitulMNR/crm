<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Student;
use Illuminate\Support\Facades\Mail;

class EmelPengesahan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emel:pengesahan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menghantar emel pengesahan pembelian selepas pelanggan selesai mendaftar dan membuat bayaran';

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
        $apikey = env('MAIL_PASSWORD');
        $sendgrid = new \SendGrid($apikey);
            
        $email = new \SendGrid\Mail\Mail(); 
        $email->setFrom("noreply@momentuminternet.my", "Momentum Internet Sdn Bhd");
        $email->setSubject("CRON JOB");
        $email->addTo("zarina4.11@gmail.com", "Nurzarinah Zakaria");
        $email->addContent("text/html", "Cron Job Testing");
        

            $response = $sendgrid->send($email);
            //print $response->statusCode() . "\n";
            //print_r($response->headers());
            //print $response->body() . "\n";

        
        $this->info('Emel Pengesahan Pembelian Dihantar Kepada Pembeli');
    }
}
