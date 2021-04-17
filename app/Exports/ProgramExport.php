<?php

namespace App\Exports;

use App\Student;
use App\Product;
use App\Package;
use App\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class ProgramExport implements FromCollection
{
    // /**
    // * @return \Illuminate\Support\Collection
    // */
    // public function collection()
    // {
    //     return Payment::all();
    // }

    use Exportable;

    private $data  = [];

    public function __construct($data_list){
        $this->data = $data_list;
    }

    public function view(): View
    {
        return view('admin.reports.trackpackage', [
            'data' => $this->data,
        ]);
    }
}

// $product = Product::where('product_id', $product_id)->first();
        // $package = Package::where('package_id', $package_id)->first();

        // $to_name = 'noreply@momentuminternet.com';
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
          
        // // $invoice = PDF::loadView('emails.invoice', $data);
        // // $receipt = PDF::loadView('emails.receipt', $data);

        // // Mail::send('emails.mail', $data, function($message) use ($to_name, $to_email, $invoice, $receipt)
        // Mail::send('emails.mail', $data, function($message) use ($to_name, $to_email) 
        // {
        //     $message->to($to_email, $to_name)->subject('Pengesahan Pembelian');
        //     $message->from('noreply@momentuminternet.my','noreply');
        //     // $message->attachData($invoice->output(), "Invoice.pdf");
        //     // $message->attachData($receipt->output(), "Receipt.pdf");
