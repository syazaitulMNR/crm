<?php

namespace App\Mail;

use App\Email;
use App\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;

class InvoiceRemindEmail extends Mailable
{
    use Queueable, SerializesModels;
    protected $student_id, $student;

    // public $data;

    public function __construct($student_id, $student)
    {
        $this->student_id = $student_id;
        $this->student = $student;
    }

    public function build()
    {
        $payment = $this->student_id;

        $currentDate = Carbon::now()->toFormattedDateString();

        $product = Product::where('product_id', $payment['product_id'])->first();

        //content->payment

        return $this->view('invoice.invoice')
                    ->with([ 
                        'contents' => $this->student_id, 
                        'student' => $this->student, 
                        'product' => $product,
                        'current_date' => $currentDate
                    ]);
    }
}
