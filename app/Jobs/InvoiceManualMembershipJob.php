<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\InvoiceManualMembershipEmail;
use Mail;

class InvoiceManualMembershipJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $send_mail, $inv, $subtotal, $name, $secondname, $invoices , $invoice , $arrayfeat , $arrayquan , $listoffeatures , $datesum , $no , $price , $balance , $quantity , $date_receive , $due_date , $bulan , $member , $membership;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($send_mail, $inv, $subtotal, $name, $secondname, $invoices , $invoice , $arrayfeat , $arrayquan , $listoffeatures , $datesum , $no , $price , $balance , $quantity , $date_receive , $due_date , $bulan , $member , $membership)
    {
        // $this->send_mail = $send_mail;
        // $this->inv = $inv;
        // $this->member = $member;
        // $this->subtotal = $subtotal;
        // $this->name = $name;
        // $this->no = $no;
        // $this->secondname = $secondname;
        // $this->invoice = $invoice;
        // $this->membership = $membership;
        // $this->price = $price;
        // $this->total = $total;
        // $this->date_receive = $date_receive;
        // $this->datesum = $datesum;
        // $this->invoice_amount = $invoice_amount;
        // $this->amount_received = $amount_received;
        // $this->balance = $balance;
        // $this->balance_due = $balance_due;

        $this->send_mail = $send_mail;
        $this->inv = $inv;
        $this->subtotal = $subtotal;
        $this->name = $name;
        $this->secondname = $secondname;
        $this->invoices = $invoices;
        $this->invoice = $invoice;
        $this->arrayfeat = $arrayfeat;
        $this->arrayquan = $arrayquan;
        $this->listoffeatures = $listoffeatures;
        $this->datesum = $datesum;
        $this->no = $no;
        $this->price = $price;
        $this->balance = $balance;
        $this->quantity = $quantity;
        $this->date_receive = $date_receive;
        $this->due_date = $due_date;
        $this->bulan = $bulan;
        $this->member = $member;
        $this->membership = $membership;

    }
    
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {   
        Mail::to($this->send_mail)->send(new InvoiceManualMembershipEmail(  
                                                                        $this->inv ,
                                                                        $this->subtotal , 
                                                                        $this->name ,
                                                                        $this->secondname ,
                                                                        $this->invoices ,
                                                                        $this->invoice ,
                                                                        $this->arrayfeat ,
                                                                        $this->arrayquan ,
                                                                        $this->listoffeatures ,
                                                                        $this->datesum ,
                                                                        $this->no ,
                                                                        $this->price ,
                                                                        $this->balance ,
                                                                        $this->quantity ,
                                                                        $this->date_receive ,
                                                                        $this->due_date ,
                                                                        $this->bulan ,
                                                                        $this->member ,
                                                                        $this->membership ));
        
    }
}