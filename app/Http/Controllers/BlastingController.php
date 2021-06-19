<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\BlastQueueEmail;
use App\Jobs\PengesahanJob;
use App\Student;
use App\Product;
use App\Package;
use App\Payment;
use App\Ticket;

class BlastingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function emailblast()
    {
        $product = Product::orderBy('id','desc')->paginate(15);
        
        return view('admin.blasting_email.emailblast', compact('product'));
    }

    public function package($product_id) 
    {
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('product_id', $product_id)->paginate(15);

        return view('admin.blasting_email.package', compact('product', 'package'));
    }

    public function show($product_id, $package_id)
    {
        $payment = Payment::orderBy('id','desc')->where('product_id', $product_id)->where('package_id', $package_id)->where('email_status', 'Hold')->paginate(15);
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $student = Student::orderBy('id','desc')->get();

        $total = Payment::orderBy('id','desc')->where('product_id', $product_id)->where('package_id', $package_id)->where('email_status', 'Hold')->count();
        
        return view('admin.blasting_email.viewblast', compact('student', 'product', 'package', 'payment', 'total'));
    }

    public function blast_participant($product_id, $package_id)
    {
        $ticket = Ticket::orderBy('id','desc')->where('product_id', $product_id)->where('package_id', $package_id)->where('email_status', 'Hold')->paginate(15);
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $student = Student::orderBy('id','desc')->get();

        $total = Payment::orderBy('id','desc')->where('product_id', $product_id)->where('package_id', $package_id)->where('email_status', 'Hold')->count();
        
        return view('admin.blasting_email.blast_participant', compact('student', 'product', 'package', 'ticket', 'total'));
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

    public function update_mail($product_id, $package_id, $payment_id, $student_id, Request $request)
    {
        $payment = Payment::where('payment_id', $payment_id)->where('product_id', $product_id)->where('package_id', $package_id)->where('email_status', 'Hold')->first();
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $student = Student::where('stud_id', $student_id)->first();

        $student->ic = $request->ic;
        $student->phoneno = $request->phoneno;
        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->email = $request->email;

        $student->save();

        return redirect('view-student/' . $product_id . '/' . $package_id. '/' . $payment_id . '/' . $student_id)->with('update-mail','Customer Successfully Updated!');
    }
    
    public function send_mail($product_id, $package_id, $payment_id, $student_id)
    {
        $payment = Payment::where('payment_id', $payment_id)->where('product_id', $product_id)->where('package_id', $package_id)->where('email_status', 'Hold')->first();
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $student = Student::where('stud_id', $student_id)->first();

        // Email content
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

        // change email status
        $payment->email_status = 'Sent';

        // send the email
        dispatch(new PengesahanJob($send_mail, $product_name, $date_from, $date_to, $time_from, $time_to, $packageId, $payment_id, $productId, $student_id));

        $payment->save();

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
