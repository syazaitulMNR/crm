<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\BlastQueueEmail;
use App\Jobs\PengesahanJob;
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
        $product = Product::orderBy('id','desc')->paginate(15);
        
        return view('admin.emailblast', compact('product'));
    }

    public function package($product_id) 
    {
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('product_id', $product_id)->paginate(15);

        return view('admin.blasting_email.package', compact('product', 'package'));
    }

    public function show($product_id, $package_id)
    {
        $payment = Payment::orderBy('id','desc')->where('product_id', $product_id)->where('package_id', $package_id)->where('offer_id', 'Import')->paginate(15);
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $student = Student::orderBy('id','desc')->get();

        // $product = Product::where('product_id', $product_id)->get();
        // $student = Student::orderBy('id','desc')->paginate(15);
        // // $student = Student::where('product_id', $product_id)->get();
        // $package = Package::where('product_id', $product_id)->get(); 
        // $payment = Payment::where('product_id', $product_id)->get();

        $total = Payment::orderBy('id','desc')->where('product_id', $product_id)->where('package_id', $package_id)->where('offer_id', 'Import')->count();
        
        // dd($student);
        return view('admin.viewblast', compact('student', 'product', 'package', 'payment', 'total'));
    }

    public function view_student($product_id, $package_id, $payment_id, $student_id)
    {
        $paginate = Payment::where('product_id', $product_id)->paginate(15);
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $payment = Payment::where('payment_id', $payment_id)->first();
        $student = Student::where('stud_id', $student_id)->first();
        
        return view('admin.blasting_email.view_customer', compact('paginate', 'product', 'package', 'payment', 'student'));
    }
    
    public function send_mail($product_id, $package_id, $payment_id, $student_id)
    {
        /*-- Manage Email ---------------------------------------------------*/

        $payment = Payment::where('payment_id', $payment_id)->where('product_id', $product_id)->where('package_id', $package_id)->where('email_status', 'Hold')->first();
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $student = Student::where('stud_id', $student_id)->first();

        $send_mail = $student->email;
        $product_name = $product->name;        
        $date_from = $product->date_from;
        $date_to = $product->date_to;
        $time_from = $product->time_from;
        $time_to = $product->time_to;
        $packageId = $package_id;
        $payment_id = $payment->payment_id;
        $productId = $product_id;        
        $student_id = $student->stud_id;

        // echo 'sent email';
        // $payment->offer_id = 'OFF002'; //buy1free1
        // $payment->save();

        dispatch(new PengesahanJob($send_mail, $product_name, $date_from, $date_to, $time_from, $time_to, $packageId, $payment_id, $productId, $student_id));

        return redirect('view-event/' . $product_id . '/' . $package_id)->with('sent-success', 'Purchased Confirmation Email Successfully Sent') ;
    }
    
    //testing
    // public function sendBulkMail()
    // {
    //     $data = array('name'=>"Virat Gandhi");
   
    //     Mail::send(['text'=>'mail'], $data, function($message) {
    //         $message->to('zarina4.11@gmail.com', 'Tutorials Point')->subject
    //             ('Laravel Basic Testing Mail');
    //         $message->from('xyz@gmail.com','Virat Gandhi');
    //     });
    //     echo "Basic Email Sent. Check your inbox.";

    // 	// $details = [
    // 	// 	'subject' => 'Pengesahan Pembelian'
    // 	// ];

    // 	// // send all mail in the queue.
    //     // $job = (new BlastQueueEmail($details))->delay(now()->addSeconds(2)); 

    //     // dispatch($job);

    //     // echo "Bulk mail send successfully in the background...";
    // }
}
