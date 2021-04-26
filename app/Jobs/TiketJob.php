<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\SendMailable;

class TiketJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $email, $name, $product_name, $package_name, $date_from, $date_to, $time_from, $time_to;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $name, $product_name, $package_name, $date_from, $date_to, $time_from, $time_to)
    {
        $this->email = $email;
        $this->name = $name;    
        $this->product_name = $product_name;    
        $this->package_name = $package_name;
        $this->date_from = $date_from;
        $this->date_to = $date_to;
        $this->time_from = $time_from;
        $this->time_to = $time_to;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send(new SendMailable(   $this->name,
                                                                $this->product_name,
                                                                $this->package_name,
                                                                $this->date_from,
                                                                $this->date_to,
                                                                $this->time_from,
                                                                $this->time_to ));
    }
}
