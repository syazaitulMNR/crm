<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
// use Illuminate\Support\Facades\Storage;
// use PDF;

class InvoiceSendEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $name, $ic, $email, $phoneno, $total, $quantity, $package_id, $package, $price, $date_receive, $payment_id, $product_id, $student_id;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $ic, $email, $phoneno, $total, $quantity, $package_id, $package, $price, $date_receive, $payment_id, $product_id, $student_id)
    {
        $this->name = $name;
        $this->ic = $ic;
        $this->email = $email;
        $this->phoneno = $phoneno;
        $this->total = $total;
        $this->quantity = $quantity;
        $this->package_id = $package_id;
        $this->package = $package;
        $this->price = $price;
        $this->date_receive = $date_receive;
        $this->payment_id = $payment_id;
        $this->product_id = $product_id;
        $this->student_id = $student_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.mail')
        ->subject('Pengesahan Pembelian')
        ->with(
            [
                'name' => $this->name,
                'ic' => $this->ic,
                'email' => $this->email,
                'phoneno' => $this->phoneno,
                'total' => $this->total,
                'quantity' => $this->quantity,
                'package_id' => $this->package_id,
                'package' => $this->package,
                'price' => $this->price,
                'date_receive' => $this->date_receive,
                'payment_id' => $this->payment_id,
                'product_id' => $this->product_id,
                'student_id' => $this->student_id,
            ]);
        // ->attachData($invoice->output(), "Invoice.pdf")
        // ->attachData($receipt->output(), "Receipt.pdf");
    }
}
