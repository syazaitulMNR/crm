<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $name, $package, $product, $date_from, $date_to, $time_from, $time_to;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $package, $product, $date_from, $date_to, $time_from, $time_to)
    {
        $this->name = $name;
        $this->package = $package;
        $this->product = $product;
        $this->date_from = $date_from;
        $this->date_to = $date_to;
        $this->time_from = $time_from;
        $this->time_to = $time_to;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {        
        return $this->view('emails.zoom_link')
        ->from('noreply@noreply.com', 'noreply')
        ->subject('noreply')
        ->with(
            [
                  'name' => $this->name,
                  'package' => $this->package,
                  'product' => $this->product,
                  'date_from' => $this->date_from,
                  'date_to' => $this->date_to,
                  'time_from' => $this->time_from,
                  'time_to' => $this->time_to,
            ]);
    }
}
