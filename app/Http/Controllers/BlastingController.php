<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\BlastQueueEmail;
use App\Student;
use App\Product;
use App\Package;
use App\Payment;

// use Session;
// use Stripe;

class BlastingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function emailblast()
    {
        // $student = Student::orderBy('id','desc')->get();
        $product = Product::orderBy('id','desc')->paginate(15);
        // $package = Package::orderBy('id','asc')->get(); 

        // $totalcust = Student::count();
        
        return view('admin.emailblast', compact('product'));
    }

    public function package($product_id) 
    {
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('product_id', $product_id)->paginate(15);

        return view('admin.blasting_email.package', compact('product', 'package'))
    }

    public function show($product_id)
    {
        $payment = Payment::orderBy('id','desc')->where('product_id', $product_id)->where('offer_id', 'Import')->paginate(15);
        $product = Product::where('product_id', $product_id)->first();
        // $package = Package::where('package_id', $package_id)->first();
        $student = Student::orderBy('id','desc')->get();

        // $product = Product::where('product_id', $product_id)->get();
        // $student = Student::orderBy('id','desc')->paginate(15);
        // // $student = Student::where('product_id', $product_id)->get();
        // $package = Package::where('product_id', $product_id)->get(); 
        // $payment = Payment::where('product_id', $product_id)->get();

        $totalcust = Student::orderBy('id','desc')->count();
        
        // dd($student);
        return view('admin.viewblast', compact('student', 'product', 'payment', 'totalcust'));
    }
    
    public function send_mail()
    {

    }
    
    //testing
    public function sendBulkMail()
    {
        $data = array('name'=>"Virat Gandhi");
   
        Mail::send(['text'=>'mail'], $data, function($message) {
            $message->to('zarina4.11@gmail.com', 'Tutorials Point')->subject
                ('Laravel Basic Testing Mail');
            $message->from('xyz@gmail.com','Virat Gandhi');
        });
        echo "Basic Email Sent. Check your inbox.";

    	// $details = [
    	// 	'subject' => 'Pengesahan Pembelian'
    	// ];

    	// // send all mail in the queue.
        // $job = (new BlastQueueEmail($details))->delay(now()->addSeconds(2)); 

        // dispatch($job);

        // echo "Bulk mail send successfully in the background...";
    }
}
