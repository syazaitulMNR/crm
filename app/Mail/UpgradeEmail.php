<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UpgradeEmail extends Mailable
{
    use Queueable, SerializesModels;
    protected $product_name, $date_from, $date_to, $time_from, $time_to, $packageId, $ticket_id, $productId, $student_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($product_name, $date_from, $date_to, $time_from, $time_to, $packageId, $ticket_id, $productId, $student_id)
    {
        $this->product_name = $product_name;       
        $this->date_from = $date_from;        
        $this->date_to = $date_to;        
        $this->time_from = $time_from;        
        $this->time_to = $time_to;
        $this->packageId = $packageId;
        $this->ticket_id = $ticket_id;
        $this->productId = $productId;
        $this->student_id = $student_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Pengesahan Naik Taraf Pakej')            
            ->view('emails.upgrade')
            ->with(
                [
                    'product_name' => $this->product_name,
                    'date_from' => $this->date_from,
                    'date_to' => $this->date_to,
                    'time_from' => $this->time_from,
                    'time_to' => $this->time_to,
                    'packageId' => $this->packageId,
                    'ticket_id' => $this->ticket_id,
                    'productId' => $this->productId,
                    'student_id' => $this->student_id,
                ]);
    }
}
