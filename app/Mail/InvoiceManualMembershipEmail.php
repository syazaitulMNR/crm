<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceManualMembershipEmail extends Mailable
{
    use Queueable, SerializesModels;
    protected $inv, $subtotal, $name, $secondname, $invoices , $invoice , $arrayfeat , $arrayquan , $listoffeatures , $datesum , $no , $price , $balance , $quantity , $date_receive , $due_date , $bulan , $member , $membership;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($inv, $subtotal, $name, $secondname, $invoices , $invoice , $arrayfeat , $arrayquan , $listoffeatures , $datesum , $no , $price , $balance , $quantity , $date_receive , $due_date , $bulan , $member , $membership)
    {         
        $this->inv = $inv; //
        $this->subtotal = $subtotal; //
        $this->name = $name; //
        $this->secondname = $secondname; //
        $this->invoices = $invoices; //
        $this->invoice = $invoice; //
        $this->arrayfeat = $arrayfeat; //
        $this->arrayquan = $arrayquan; //
        $this->listoffeatures = $listoffeatures; //
        $this->datesum = $datesum; //
        $this->no = $no; //
        $this->price = $price; //
        $this->balance = $balance; //
        $this->quantity = $quantity;
        $this->date_receive = $date_receive; //
        $this->due_date = $due_date; //
        $this->bulan = $bulan; //
        $this->member = $member; //
        $this->membership = $membership; //

        // $this->product_name = $product_name;      
        // $this->package_name = $package_name; 
        // $this->date_from = $date_from;        
        // $this->date_to = $date_to;        
        // $this->time_from = $time_from;        
        // $this->time_to = $time_to;
        // $this->packageId = $packageId;
        // $this->payment_id = $payment_id;
        // $this->productId = $productId;
        // $this->student_id = $student_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // $statement = $this->send_statementmember($membership_id , $level_id , $student_id);
        // $invoice = $this->send_invoicemember($membership_id , $level_id , $student_id);
        // $receipt = $this->send_receiptmember($membership_id , $level_id , $student_id);
        
        return $this->subject('Invois Momentum Internet')            
            ->view('emails.sendmanualinvoice')
            ->with(
                [   
                    
                    'name' => $this->name , //
                    'no' => $this->no , //
                    'member' => $this->member , //
                    'inv' => $this->inv , //
                    'secondname' => $this->secondname , //
                    'invoice' => $this->invoice , //
                    'invoices' => $this->invoices , //
                    'membership' => $this->membership , //
                    'price' => $this->price , //
                    'subtotal' => $this->subtotal , //
                    'date_receive' => $this->date_receive , //
                    'due_datesum' => $this->due_date , //
                    'bulan' => $this->bulan , //
                    'listoffeatures' => $this->listoffeatures , //
                    'balance' => $this->balance , //
                    'arrayfeat' => $this->arrayfeat , //
                    'arrayquan' => $this->arrayquan , //
                    'datesum' => $this->datesum , //
                ]);
    }

    // public function build()
    // {
    //     return $this->subject('Penyata Akaun Momentum Internet')            
    //         ->view('emails.statement')
    //         ->with(
    //             [
    //                 'product_name' => $this->product_name,
    //                 'package_name' => $this->package_name,
    //                 'date_from' => $this->date_from,
    //                 'date_to' => $this->date_to,
    //                 'time_from' => $this->time_from,
    //                 'time_to' => $this->time_to,
    //                 'packageId' => $this->packageId,
    //                 'payment_id' => $this->payment_id,
    //                 'productId' => $this->productId,
    //                 'student_id' => $this->student_id,
    //             ]);
    // }
}
