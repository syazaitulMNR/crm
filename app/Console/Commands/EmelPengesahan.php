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
        $name = "Nurzarinah Zakaria";
        $email = "zarina4.11@gmail.com";

        $data = array(
            'name'=>"Nurzarinah Zakaria",
            'ic'=>"123456789874",
            'email'=>"zarina4.11@gmail.com",
            'phoneno'=>"0102654231",
            'total'=>"111",
            'quantity'=>"1",
            'product'=>"Product Test",
            'package_id'=>"PKD001",
            'package'=>"Package Test",
            'price'=>"Nurzarinah Zakaria",
            'date_receive'=>"01/01/01",
            'payment_id'=>"OD001",
            'product_id'=>"PRD001",
            'student_id'=>"MI001",
        );
     
        Mail::send('emails.mail', $data, function($message) use ($name, $email) {
           $message->to($name, $email)->subject('Laravel Basic Testing Mail');
           $message->from('noreply@momentuminternet.my','noreply');
        });

        $this->info('Emel Pengesahan Pembelian Dihantar Kepada Pembeli');
     
    }
}


// $product = Product::where('product_id', $product_id)->first();
// $package = Package::where('package_id', $package_id)->first();

// $to_name = $student->first_name;
// $to_email = $student->email; 

// $data['name']=$student->first_name;
// $data['ic']=$student->ic;
// $data['email']=$student->email;
// $data['phoneno']=$student->phoneno;
// $data['total']=$payment->item_total;
// $data['quantity']=$payment->quantity;

// $data['product']=$product->name;
// $data['package_id']=$package->package_id;
// $data['package']=$package->name;
// $data['price']=$package->price;

// $data['date_receive']=date('d-m-Y');
// $data['payment_id']=$payment->payment_id;
// $data['product_id']=$product->product_id;        
// $data['student_id']=$student->stud_id;
  
// Mail::send('emails.mail', $data, function($message) use ($to_name, $to_email) 
// {
//     $message->to($to_email, $to_name)->subject('Pengesahan Pembelian');
//     $message->from('noreply@momentuminternet.my','noreply');
// });

// $this->info('Emel Pengesahan Pembelian Dihantar Kepada Pembeli');