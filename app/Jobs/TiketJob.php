<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\SendMailable;
use Mail;

class TiketJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $email, $product_name, $date_from, $date_to, $time_from, $time_to, $payment_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $product_name, $date_from, $date_to, $time_from, $time_to, $payment_id)
    {
        $this->email = $email;
        $this->product_name = $product_name;        
        $this->date_from = $date_from;        
        $this->date_to = $date_to;        
        $this->time_from = $time_from;        
        $this->time_to = $time_to;
        $this->packageId = $packageId;
        $this->payment_id = $payment_id;
        $this->productId = $productId;
        $this->student_id = $student_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send(new SendMailable(  $this->product_name,
                                                        $this->date_from,
                                                        $this->date_to,
                                                        $this->time_from,
                                                        $this->time_to,
                                                        $this->packageId,
                                                        $this->payment_id,
                                                        $this->productId,
                                                        $this->student_id ));
    }
}
