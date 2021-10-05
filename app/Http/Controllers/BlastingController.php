<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\BlastQueueEmail;
use App\Jobs\PengesahanJob;
use App\Jobs\TiketJob;
use App\Student;
use App\Product;
use App\Package;
use App\Payment;
use App\Ticket;
use App\Email;
use App\Jobs\TestJobMail;

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

    /*-- imported buyer --------------------------------------------------------*/
    public function show($product_id, $package_id)
    {
        $payment = Payment::orderBy('id','desc')->where('product_id', $product_id)->where('package_id', $package_id)->where('email_status', 'Hold')->paginate(15);
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $student = Student::orderBy('id','desc')->get();
        $emails = Email::all();

        $total = Payment::orderBy('id','desc')->where('product_id', $product_id)->where('package_id', $package_id)->where('email_status', 'Hold')->count();
        
        return view('admin.blasting_email.viewblast', compact('student', 'product', 'package', 'payment', 'total', 'emails', 'product_id', 'package_id'));
    }

    public function view_student($product_id, $package_id, $payment_id, $student_id)
    {
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $payment = Payment::where('payment_id', $payment_id)->first();
        $student = Student::where('stud_id', $student_id)->first();
        
        return view('admin.blasting_email.view_customer', compact('product', 'package', 'payment', 'student'));
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
        $package_name = $package->name;      
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
        dispatch(new PengesahanJob($send_mail, $product_name, $package_name, $date_from, $date_to, $time_from, $time_to, $packageId, $payment_id, $productId, $student_id));

        $payment->save();

        return redirect('view-event/' . $product_id . '/' . $package_id)->with('sent-success', 'Purchased confirmation email has been sent successfully') ;
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
        $payment->status = $request->status;

        $student->save();
        $payment->save();

        return redirect('view-student/' . $product_id . '/' . $package_id. '/' . $payment_id . '/' . $student_id)->with('update-mail','Customer details successfully updated');
    }
    
    /*-- imported participant --------------------------------------------------------*/
    public function blast_participant($product_id, $package_id)
    {
        $ticket = Ticket::orderBy('id','desc')->where('product_id', $product_id)->where('package_id', $package_id)->where('email_status', 'Hold')->paginate(15);
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $student = Student::orderBy('id','desc')->get();

        $total = Ticket::orderBy('id','desc')->where('product_id', $product_id)->where('package_id', $package_id)->where('email_status', 'Hold')->count();
        
        return view('admin.blasting_email.blast_participant', compact('student', 'product', 'package', 'ticket', 'total'));
    }
    
    public function view_participant($product_id, $package_id, $ticket_id, $student_id)
    {
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $ticket = Ticket::where('ticket_id', $ticket_id)->first();
        $student = Student::where('stud_id', $student_id)->first();
        
        return view('admin.blasting_email.view_participant', compact('product', 'package', 'ticket', 'student'));
    }

    public function participant_mail($product_id, $package_id, $ticket_id, $student_id)
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->where('product_id', $product_id)->where('package_id', $package_id)->where('email_status', 'Hold')->first();
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $student = Student::where('stud_id', $student_id)->first();

        // Email content
        $email = $student->email;
        $product_name = $product->name;  
        $package_name = $package->name;       
        $date_from = $product->date_from;
        $date_to = $product->date_to;
        $time_from = $product->time_from;
        $time_to = $product->time_to;
        $packageId = $package_id;
        $productId = $product_id;        
        $student_id = $student->stud_id;
        $survey_form = $product->survey_form;

        // change email status
        $ticket->email_status = 'Sent';

        // send the email
        dispatch(new TiketJob($email, $product_name, $package_name, $date_from, $date_to, $time_from, $time_to, $packageId, $productId, $student_id, $ticket_id, $survey_form));

        $ticket->save();

        return redirect('blast-participant/' . $product_id . '/' . $package_id)->with('sent-success', 'Participant confirmation email has been sent successfully') ;
    }

    public function update_participant_mail($product_id, $package_id, $ticket_id, $student_id, Request $request)
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->where('product_id', $product_id)->where('package_id', $package_id)->where('email_status', 'Hold')->first();
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $student = Student::where('stud_id', $student_id)->first();

        $student->ic = $request->ic;
        $student->phoneno = $request->phoneno;
        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->email = $request->email;

        $student->save();

        return redirect('view-participant/' . $product_id . '/' . $package_id. '/' . $ticket_id . '/' . $student_id)->with('update-mail','Participant details successfully updated');
    }
    
    public function blastBulkEmail(Request $request){

        $product_id = $request->prod_id;
        $package_id = $request->pack_id;
        $email = Email::where('id', $request->emailId)->first();

        preg_match_all("/(?<={).*?(?=})/", $email->content, $regex_content);
			
        if(count($regex_content) > 0){
            if(count($regex_content[0]) > 0){
                $regex_content = $regex_content[0];
            }else{
                $regex_content = [];
            }
        }else{
            $regex_content = [];
        }

        $paymentIds = $request->paymentId;
        $reqEmails = $request->emailList;

        for($i=0; $i < sizeof($request->paymentId); $i++){
            $payment = Payment::where('id', $paymentIds[$i])->first();

            if($reqEmails[$i] != (null || "")){
                $payment->email_status = 'Sent';
                $payment->save();
            }
            $payment->save();
        }

        dispatch(new TestJobMail($request->all(), $regex_content));

        return redirect('view-event/'.$product_id.'/'.$package_id)->with('success', 'List email has been qued for sending with template.');

        
    }
    
}
