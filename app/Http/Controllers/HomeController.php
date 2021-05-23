<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
// use App\Mail\SendMailable;
use App\Jobs\TiketJob;
// use App\Mail\TestMail;
use App\Product;
use App\Feature;
use App\Package;
use App\Payment;
use App\Student;
use App\Ticket;
use Illuminate\Support\Facades\Mail;
use PDF;

class HomeController extends Controller
{    
    /*
    |--------------------------------------------------------------------------
    | HomeController
    |--------------------------------------------------------------------------
    |   This controller is for managing customer page
    | 
    */

    /*-- Landing Page -------------------------------------------------------*/
    public function viewproduct()
    {
        $product = Product::orderBy('id','asc')->paginate(10);

        // return view('index', compact('product'));
        abort(404);
    }

    public function view($id)
    {        
        $feature = Feature::where('product_id', $id)->get();
        $product = Product::where('product_id', $id)->first();
        $package = Package::where('product_id', $id)->get();
        
        return view('customer/package', compact('feature','product', 'package'));
    }

    /*-- Buyer Registration -----------------------------------------------*/
    public function register($product_id,$package_id)
    {
        $package = Package::where('package_id', $package_id)->first();
        $product = Product::where('product_id', $product_id)->first();

        // return view('customer/main', compact('product', 'package'));
        return view('customer_new/check_ic', compact('product', 'package'));
    }

    public function detailsic($product_id, $package_id, Request $request)
    {
        // Check if ic exist
        if(Student::where('ic', $request->ic)->exists()){
            
            $student = Student::where('ic', $request->ic)->first();
            return redirect('langkah-pertama/' . $product_id . '/' . $package_id .'/'.$student->stud_id);

        }else{

            // return redirect('regnewstudent/'. $product_id . '/' . $package_id . '/' . $request->ic);
            return redirect('maklumat-pembeli/'. $product_id . '/' . $package_id . '/' . $request->ic);

        }
    }

    public function thankyou() 
    {
        // $student = Student::where('stud_id', $stud_id)->first();
        // $product = Product::where('product_id',$product_id)->first();
        // $package = Package::where('package_id', $package_id)->first();
        // $payment = Payment::where('payment_id', $payment_id)->first();

        return view('customer/thankyou');
    }

    /*-- Participant Registration ------------------------------------------*/
    public function participant_form($product_id, $package_id, $stud_id, $payment_id)
    {
        $student = Student::where('stud_id', $stud_id)->first();
        $product = Product::where('product_id',$product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $payment = Payment::where('stud_id', $stud_id)->where('product_id',$product_id)->where('package_id',$package_id)->where('payment_id',$payment_id)->first();

        $count=2;
        $phonecode=1;

        // Check if form has been key in
        if($payment->update_count == 1){

            return view('customer/exceed_limit');

        }else{

            if($payment->offer_id == 'OFF001') {
                //for no offer ticket
                return view('customer.loopingform', compact('student','product', 'package', 'payment', 'count', 'phonecode'));
    
            } else if($payment->offer_id == 'OFF002') {
                //for Buy 1 Get 1 (Same Ticket)
                
                return view('customer.get1free1same', compact('student','product', 'package', 'payment', 'count', 'phonecode'));
    
            } else if($payment->offer_id == 'OFF003') {
                //For No Offer or Bulk Ticket
                
                return view('customer.loopingform', compact('student','product', 'package', 'payment', 'count', 'phonecode'));
    
            } else {
    
                echo 'No Such Offer';
    
            }


        }
    }
    
    //For No Offer or Bulk Ticket
    public function register_bulk($product_id, $package_id, $stud_id, $payment_id, Request $request)
    {
        if($request->myButton == 'Simpan'){
            echo 'simpan';
        }else{

            $student = Student::where('stud_id', $stud_id)->first();
            $payment = Payment::where('payment_id', $payment_id)->first();

            // Check if form has been key in
            if($payment->update_count == 1){
                return view('customer/exceed_limit');
            }else{

                // To tell system the participant form has been key in
                $payment->update_count = 1;
                $payment->save();
                
                if(Student::where('ic', $request->ic)->exists())
                {
                    // If the ic at single form exist

                    if ($payment->quantity == 1){
                        // Can access single form

                    }else{
                        
                        // Can access looping form
                        foreach($request->ic_peserta as $key => $value)
                        {
                            // Check if the ic at looping form exist
                            if(Student::where('ic', $value)->exists())
                            {    
                                // Process for Paid Ticket form
                                $ticket = Ticket::orderBy('id','Desc')->first();
                                $auto_inc_tik = $ticket->id + 1;
                                $ticket_id = 'TIK' . 0 . 0 . $auto_inc_tik;

                                Ticket::create(array(
                                    'ticket_id' => $ticket_id,
                                    'ticket_type' => 'paid',
                                    'stud_id' => $stud_id,
                                    'product_id' => $product_id,
                                    'package_id' => $package_id,
                                    'payment_id' => $payment_id
                                ));

                                // Manage email (for existed ic in looping form) 
                                $product = Product::where('product_id', $product_id)->first();
                                $package = Package::where('package_id', $package_id)->first();

                                $email = $request->email_peserta[$key]; 
                                $product_name = $product->name;
                                $date_from = $product->date_from;
                                $date_to = $product->date_to;
                                $time_from = $product->time_from;
                                $time_to = $product->time_to;
                                $packageId = $package_id;
                                $payment_id = $payment->payment_id;
                                $productId = $product_id;        
                                $student_id = $student->stud_id;
                                
                                dispatch(new TiketJob($email, $product_name, $date_from, $date_to, $time_from, $time_to, $packageId, $payment_id, $productId, $student_id));
                                
                                continue;
                            }

                            // If ic at looping form not exist
                            $stud_id_looping = 'MI'.uniqid();

                            Student::create(array(

                                'stud_id' => $stud_id_looping,
                                'first_name' => $request->firstname_peserta[$key],
                                'last_name' => $request->lastname_peserta[$key],
                                'ic' => $value,
                                'email' => $request->email_peserta[$key],
                                'phoneno' => $request->phoneno_peserta[$key],
                                'product_id' => $product_id,
                                'package_id' => $package_id
                    
                            ));

                            // Process for Paid Ticket form
                            $ticket = Ticket::orderBy('id','Desc')->first();
                            $auto_inc_tik = $ticket->id + 1;
                            $ticket_id = 'TIK' . 0 . 0 . $auto_inc_tik;

                            Ticket::create(array(
                                'ticket_id' => $ticket_id,
                                'ticket_type' => 'paid',
                                'stud_id' => $stud_id_looping,
                                'product_id' => $product_id,
                                'package_id' => $package_id,
                                'payment_id' => $payment_id
                            ));
                
                            // Manage email (for existed ic in looping form) 
                            $product = Product::where('product_id', $product_id)->first();
                            $package = Package::where('package_id', $package_id)->first();

                            $email = $request->email_peserta[$key]; 
                            $product_name = $product->name;
                            $date_from = $product->date_from;
                            $date_to = $product->date_to;
                            $time_from = $product->time_from;
                            $time_to = $product->time_to;
                            $packageId = $package_id;
                            $payment_id = $payment->payment_id;
                            $productId = $product_id;        
                            $student_id = $stud_id_looping;
                            
                            dispatch(new TiketJob($email, $product_name, $date_from, $date_to, $time_from, $time_to, $packageId, $payment_id, $productId, $student_id));
                            
                        }
                    }

                    // Process for Paid Ticket form
                    $ticket = Ticket::orderBy('id','Desc')->first();
                    $auto_inc_tik = $ticket->id + 1;
                    $ticket_id = 'TIK' . 0 . 0 . $auto_inc_tik;

                    Ticket::create(array(
                        'ticket_id' => $ticket_id,
                        'ticket_type' => 'paid',
                        'stud_id' => $stud_id,
                        'product_id' => $product_id,
                        'package_id' => $package_id,
                        'payment_id' => $payment_id
                    ));

                    // Manage email (for existed ic in looping form) 
                    $product = Product::where('product_id', $product_id)->first();
                    $package = Package::where('package_id', $package_id)->first();

                    $email = $request->email; 
                    $product_name = $product->name;
                    $date_from = $product->date_from;
                    $date_to = $product->date_to;
                    $time_from = $product->time_from;
                    $time_to = $product->time_to;
                    $packageId = $package_id;
                    $payment_id = $payment->payment_id;
                    $productId = $product_id;        
                    $student_id = $student->stud_id;
                    
                    dispatch(new TiketJob($email, $product_name, $date_from, $date_to, $time_from, $time_to, $packageId, $payment_id, $productId, $student_id)); 

                }else{

                    // If the ic at single form not exist
                    $stud_id_single = 'MI'.uniqid();
                            
                    Student::create(array(

                        'stud_id'=> $stud_id_single,
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'ic' => $request->ic,
                        'email' => $request->email,
                        'phoneno' => $request->phoneno,
                        'product_id' => $product_id,
                        'package_id' => $package_id
            
                    ));
                           
                    // Process for Paid Ticket form
                    $ticket = Ticket::orderBy('id','Desc')->first();
                    $auto_inc_tik = $ticket->id + 1;
                    $ticket_id = 'TIK' . 0 . 0 . $auto_inc_tik;

                    Ticket::create(array(
                        'ticket_id' => $ticket_id,
                        'ticket_type' => 'paid',
                        'stud_id' => $stud_id_single,
                        'product_id' => $product_id,
                        'package_id' => $package_id,
                        'payment_id' => $payment_id
                    ));

                    // Manage email (for new ic in single form)                    
                    $product = Product::where('product_id', $product_id)->first();
                    $package = Package::where('package_id', $package_id)->first();

                    $email = $request->email; 
                    $product_name = $product->name;
                    $date_from = $product->date_from;
                    $date_to = $product->date_to;
                    $time_from = $product->time_from;
                    $time_to = $product->time_to;
                    $packageId = $package_id;
                    $payment_id = $payment->payment_id;
                    $productId = $product_id;        
                    $student_id = $stud_id_single;
                    
                    dispatch(new TiketJob($email, $product_name, $date_from, $date_to, $time_from, $time_to, $packageId, $payment_id, $productId, $student_id));
                    // Mail::to($email_buyer2)->send(new SendMailable($name, $package, $products, $date_from, $date_to, $time_from, $time_to));
                
                    // If quantity = 1
                    if ($payment->quantity == 1){
                        // Can access single form
                    }else{

                        // Can access looping form
                        foreach($request->ic_peserta as $key => $value){

                            // If the ic at looping form exist
                            if(Student::where('ic', $value)->exists())
                            {
                                // Process for Paid Ticket form
                                $ticket = Ticket::orderBy('id','Desc')->first();
                                $auto_inc_tik = $ticket->id + 1;
                                $ticket_id = 'TIK' . 0 . 0 . $auto_inc_tik;

                                Ticket::create(array(
                                    'ticket_id' => $ticket_id,
                                    'ticket_type' => 'paid',
                                    'stud_id' => $stud_id,
                                    'product_id' => $product_id,
                                    'package_id' => $package_id,
                                    'payment_id' => $payment_id
                                ));

                                // Manage email (for existed ic in single form)                        
                                $product = Product::where('product_id', $product_id)->first();
                                $package = Package::where('package_id', $package_id)->first();

                                $email = $request->email_peserta[$key];
                                $product_name = $product->name;
                                $date_from = $product->date_from;
                                $date_to = $product->date_to;
                                $time_from = $product->time_from;
                                $time_to = $product->time_to;
                                $packageId = $package_id;
                                $payment_id = $payment->payment_id;
                                $productId = $product_id;        
                                $student_id = $student->stud_id;
                                
                                dispatch(new TiketJob($email, $product_name, $date_from, $date_to, $time_from, $time_to, $packageId, $payment_id, $productId, $student_id));
                                
                                continue;
                            }

                            // If the ic at looping form not exist
                            $stud_id_looping = 'MI'.uniqid();

                            Student::create(array(

                                'stud_id'=> $stud_id_looping,
                                'first_name' => $request->firstname_peserta[$key],
                                'last_name' => $request->lastname_peserta[$key],
                                'ic' => $value,
                                'email' => $request->email_peserta[$key],
                                'phoneno' => $request->phoneno_peserta[$key],
                                'product_id' => $product_id,
                                'package_id' => $package_id
                    
                            ));

                            // Process for Paid Ticket form
                            $ticket = Ticket::orderBy('id','Desc')->first();
                            $auto_inc_tik = $ticket->id + 1;
                            $ticket_id = 'TIK' . 0 . 0 . $auto_inc_tik;

                            Ticket::create(array(
                                'ticket_id' => $ticket_id,
                                'ticket_type' => 'paid',
                                'stud_id' => $stud_id_looping,
                                'product_id' => $product_id,
                                'package_id' => $package_id,
                                'payment_id' => $payment_id
                            ));
                                                    
                            // Manage email (for new ic in looping form)
                            $product = Product::where('product_id', $product_id)->first();
                            $package = Package::where('package_id', $package_id)->first();

                            $email = $request->email_peserta[$key];
                            $product_name = $product->name;
                            $date_from = $product->date_from;
                            $date_to = $product->date_to;
                            $time_from = $product->time_from;
                            $time_to = $product->time_to;
                            $packageId = $package_id;
                            $payment_id = $payment->payment_id;
                            $productId = $product_id;        
                            $student_id = $stud_id_looping;
                            
                            dispatch(new TiketJob($email, $product_name, $date_from, $date_to, $time_from, $time_to, $packageId, $payment_id, $productId, $student_id));
                            // Mail::to($email_participant4)->send(new SendMailable($name, $package, $products, $date_from, $date_to, $time_from, $time_to));
                            
                        }
                    }
                }

                return redirect('thankyou-update');
            }
        }

    }

    public function register_get1free1same($product_id, $package_id, $stud_id, $payment_id, Request $request)
    {
        if($request->myButton == 'Simpan'){
            echo 'simpan';
        }else{

            $student = Student::where('stud_id', $stud_id)->first();
            $payment = Payment::where('payment_id', $payment_id)->first();

            // Check if form has been key in
            if($payment->update_count == 1){
                return view('customer/exceed_limit');
            }else{

                // To tell system the participant form has been key in
                $payment->update_count = 1;
                $payment->save();
                
                if(Student::where('ic', $request->ic)->exists())
                {
                    // If the ic at paid ticket form exist
                    // Process for Paid Ticket form
                    $ticket = Ticket::orderBy('id','Desc')->first();
                    $auto_inc_tik = $ticket->id + 1;
                    $ticket_id = 'TIK' . 0 . 0 . $auto_inc_tik;

                    Ticket::create(array(
                        'ticket_id' => $ticket_id,
                        'ticket_type' => 'paid',
                        'stud_id' => $stud_id,
                        'product_id' => $product_id,
                        'package_id' => $package_id,
                        'payment_id' => $payment_id
                    ));

                    // Manage email (for existed ic in paid ticket form)  
                    $product = Product::where('product_id', $product_id)->first();
                    $package = Package::where('package_id', $package_id)->first();

                    $email = $request->email;
                    $product_name = $product->name;
                    $date_from = $product->date_from;
                    $date_to = $product->date_to;
                    $time_from = $product->time_from;
                    $time_to = $product->time_to;
                    $packageId = $package_id;
                    $payment_id = $payment->payment_id;
                    $productId = $product_id;        
                    $student_id = $student->stud_id;
                    
                    dispatch(new TiketJob($email, $product_name, $date_from, $date_to, $time_from, $time_to, $packageId, $payment_id, $productId, $student_id));
                        
                    // Process for free ticket form
                    // Check if the ic at free ticket form exist
                    if(Student::where('ic', $request->ic_free1)->exists())
                    {    
                        $ticket = Ticket::orderBy('id','Desc')->first();
                        $auto_inc_tik = $ticket->id + 1;
                        $ticket_id = 'TIK' . 0 . 0 . $auto_inc_tik;

                        Ticket::create(array(
                            'ticket_id' => $ticket_id,
                            'ticket_type' => 'free',
                            'stud_id' => $stud_id,
                            'product_id' => $product_id,
                            'package_id' => $package_id,
                            'payment_id' => $payment_id
                        ));

                        // Manage email (for existed ic in looping form) 
                        $product = Product::where('product_id', $product_id)->first();
                        $package = Package::where('package_id', $package_id)->first();

                        $email = $request->email_free1;
                        $product_name = $product->name;
                        $date_from = $product->date_from;
                        $date_to = $product->date_to;
                        $time_from = $product->time_from;
                        $time_to = $product->time_to;
                        $packageId = $package_id;
                        $payment_id = $payment->payment_id;
                        $productId = $product_id;        
                        $student_id = $student->stud_id;
                        
                        dispatch(new TiketJob($email, $product_name, $date_from, $date_to, $time_from, $time_to, $packageId, $payment_id, $productId, $student_id));
                        // Mail::to($email_participant1)->send(new SendMailable($name, $package, $products, $date_from, $date_to, $time_from, $time_to));
                        
                        // continue;
                    } else {

                        // If ic at free ticket form not exist
                        $stud_id_free = 'MI'.uniqid();

                        Student::create(array(

                            'stud_id'=> $stud_id_free,
                            'first_name' => $request->firstname_free1,
                            'last_name' => $request->lastname_free1,
                            'ic' => $request->ic_free1,
                            'email' => $request->email_free1,
                            'phoneno' => $request->phoneno_free1,
                            'product_id' => $product_id,
                            'package_id' => $package_id
                
                        ));

                        $ticket = Ticket::orderBy('id','Desc')->first();
                        $auto_inc_tik = $ticket->id + 1;
                        $ticket_id = 'TIK' . 0 . 0 . $auto_inc_tik;

                        Ticket::create(array(
                            'ticket_id' => $ticket_id,
                            'ticket_type' => 'free',
                            'stud_id' => $stud_id_free,
                            'product_id' => $product_id,
                            'package_id' => $package_id,
                            'payment_id' => $payment_id
                        ));
            
                        // Manage email (for new ic in looping form)
                        $product = Product::where('product_id', $product_id)->first();
                        $package = Package::where('package_id', $package_id)->first();

                        $email = $request->email_free1;
                        $product_name = $product->name;
                        $date_from = $product->date_from;
                        $date_to = $product->date_to;
                        $time_from = $product->time_from;
                        $time_to = $product->time_to;
                        $packageId = $package_id;
                        $payment_id = $payment->payment_id;
                        $productId = $product_id;        
                        $student_id = $stud_id_free;
                        
                        dispatch(new TiketJob($email, $product_name, $date_from, $date_to, $time_from, $time_to, $packageId, $payment_id, $productId, $student_id));                            
                        // Mail::to($email_participant2)->send(new SendMailable($name, $package, $products, $date_from, $date_to, $time_from, $time_to));
                    }

                }else{

                    // If the ic at paid ticket form not exist

                    $stud_id_paid = 'MI'.uniqid();

                    Student::create(array(

                        'stud_id'=> $stud_id_paid,
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'ic' => $request->ic,
                        'email' => $request->email,
                        'phoneno' => $request->phoneno,
                        'product_id' => $product_id,
                        'package_id' => $package_id
            
                    ));

                    $ticket = Ticket::orderBy('id','Desc')->first();
                    $auto_inc_tik = $ticket->id + 1;
                    $ticket_id = 'TIK' . 0 . 0 . $auto_inc_tik;

                    Ticket::create(array(
                        'ticket_id' => $ticket_id,
                        'ticket_type' => 'paid',
                        'stud_id' => $stud_id_paid,
                        'product_id' => $product_id,
                        'package_id' => $package_id,
                        'payment_id' => $payment_id
                    ));
                                    
                    // Manage email (for new ic in paid ticket form)   
                    $product = Product::where('product_id', $product_id)->first();
                    $package = Package::where('package_id', $package_id)->first();

                    $email = $request->email;
                    $product_name = $product->name;
                    $date_from = $product->date_from;
                    $date_to = $product->date_to;
                    $time_from = $product->time_from;
                    $time_to = $product->time_to;
                    $packageId = $package_id;
                    $payment_id = $payment->payment_id;
                    $productId = $product_id;        
                    $student_id = $stud_id_paid;
                    
                    dispatch(new TiketJob($email, $product_name, $date_from, $date_to, $time_from, $time_to, $packageId, $payment_id, $productId, $student_id));        
                
                    // Process for free ticket form
                    // If the ic at free ticket form exist
                    if(Student::where('ic', $request->ic_free1)->exists())
                    {
                        $ticket = Ticket::orderBy('id','Desc')->first();
                        $auto_inc_tik = $ticket->id + 1;
                        $ticket_id = 'TIK' . 0 . 0 . $auto_inc_tik;

                        Ticket::create(array(
                            'ticket_id' => $ticket_id,
                            'ticket_type' => 'free',
                            'stud_id' => $stud_id,
                            'product_id' => $product_id,
                            'package_id' => $package_id,
                            'payment_id' => $payment_id
                        ));

                        // Manage email (for existed ic in free ticket form)      
                        $product = Product::where('product_id', $product_id)->first();
                        $package = Package::where('package_id', $package_id)->first();

                        $email = $request->email_free1;
                        $product_name = $product->name;
                        $date_from = $product->date_from;
                        $date_to = $product->date_to;
                        $time_from = $product->time_from;
                        $time_to = $product->time_to;
                        $packageId = $package_id;
                        $payment_id = $payment->payment_id;
                        $productId = $product_id;        
                        $student_id = $student->stud_id;
                        
                        dispatch(new TiketJob($email, $product_name, $date_from, $date_to, $time_from, $time_to, $packageId, $payment_id, $productId, $student_id));          

                        // continue;
                    } else {

                        // If the ic at free ticket form not exist
                        $stud_id_free = 'MI'.uniqid();

                        Student::create(array(

                            'stud_id' => $stud_id_free,
                            'first_name' => $request->firstname_free1,
                            'last_name' => $request->lastname_free1,
                            'ic' => $request->ic_free1,
                            'email' => $request->email_free1,
                            'phoneno' => $request->phoneno_free1,
                            'product_id' => $product_id,
                            'package_id' => $package_id
                
                        ));
                                
                        $ticket = Ticket::orderBy('id','Desc')->first();
                        $auto_inc_tik = $ticket->id + 1;
                        $ticket_id = 'TIK' . 0 . 0 . $auto_inc_tik;

                        Ticket::create(array(
                            'ticket_id' => $ticket_id,
                            'ticket_type' => 'free',
                            'stud_id' => $stud_id_free,
                            'product_id' => $product_id,
                            'package_id' => $package_id,
                            'payment_id' => $payment_id
                        ));

                        // Manage email (for new ic in looping form)
                        $product = Product::where('product_id', $product_id)->first();
                        $package = Package::where('package_id', $package_id)->first();

                        $email = $request->email_free1;
                        $product_name = $product->name;
                        $date_from = $product->date_from;
                        $date_to = $product->date_to;
                        $time_from = $product->time_from;
                        $time_to = $product->time_to;
                        $packageId = $package_id;
                        $payment_id = $payment->payment_id;
                        $productId = $product_id;        
                        $student_id = $stud_id_free;
                        
                        dispatch(new TiketJob($email, $product_name, $date_from, $date_to, $time_from, $time_to, $packageId, $payment_id, $productId, $student_id));
                        
                    }
                }

                return redirect('thankyou-update');
            }
        }

    }

    public function exportInvoice($product_id, $package_id, $stud_id, $payment_id){
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $student = Student::where('stud_id', $stud_id)->first();
        $payment = Payment::where('payment_id', $payment_id)->first();
                
        $data['name']=$student->first_name;
        $data['ic']=$student->ic;
        $data['email']=$student->email;
        $data['phoneno']=$student->phoneno;
        $data['total']=$payment->totalprice;
        $data['quantity']=$payment->quantity;
        $data['upgrade_count']=$payment->upgrade_count;

        $data['product']=$product->name;
        $data['package_id']=$package_id;
        $data['package']=$package->name;
        $data['price']=$payment->pay_price;

        $data['date_receive']=date('d-m-Y');
        $data['payment_id']=$payment_id;
        $data['product_id']=$product_id;        
        $data['student_id']=$stud_id;

        $pdf = PDF::loadView('emails.invoice', $data);

        return $pdf->download('Invoice.pdf');
    }

    public function exportReceipt($product_id, $package_id, $stud_id, $payment_id){
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $student = Student::where('stud_id', $stud_id)->first();
        $payment = Payment::where('payment_id', $payment_id)->first();
                
        $data['name']=$student->first_name;
        $data['ic']=$student->ic;
        $data['email']=$student->email;
        $data['phoneno']=$student->phoneno;
        $data['total']=$payment->totalprice;
        $data['quantity']=$payment->quantity;
        $data['upgrade_count']=$payment->upgrade_count;

        $data['product']=$product->name;
        $data['package_id']=$package_id;
        $data['package']=$package->name;
        $data['price']=$payment->pay_price;

        $data['date_receive']=date('d-m-Y');
        $data['payment_id']=$payment_id;
        $data['product_id']=$product_id;        
        $data['student_id']=$stud_id;

        $pdf = PDF::loadView('emails.receipt', $data);
        return $pdf->download('Receipt.pdf');
    }

    public function thankyou_update() 
    {
        return view('customer.thankyou_update');
    }

    public function try()
    {
        $apikey = env('MAIL_PASSWORD');
        $sendgrid = new \SendGrid($apikey);
            
        $email = new \SendGrid\Mail\Mail(); 
        $email->setFrom("noreply@momentuminternet.my", "Momentum Internet Sdn Bhd");
        $email->setSubject("DANIAL LIHAT EMEL INI SEKARANG!");
        $email->addTo("zarina4.11@gmail.com", "Danial Sangat Hensem");
        $email->addContent("text/html", "Danial sangatlah hensem sangat, terima kasih!");
                
        try {

            $response = $sendgrid->send($email);
            //print $response->statusCode() . "\n";
            //print_r($response->headers());
            //print $response->body() . "\n";

        } catch (Exception $e) {

            echo 'Caught exception: '. $e->getMessage() ."\n";

        }
    }
    public function tryemail()
    {
        // Manage email (for new ic in single form)                    
        $product = 'PRD003';
        $package = 'PKD007';

        // $from_name = 'noreply@momentuminternet.com';
        $email_pkg2 = 'zarina4.11@gmail.com'; 
        
        $name = 'noreply'; 
        $products = 'product';
        $package = 'package';
        $date_from = '1-1-2021';
        $date_to = '2-2-2021';
        $time_from = '04:21AM';
        $time_to = '05:21AM';
        
        Mail::to($email_pkg2)->send(new SendMailable($name, $package, $products, $date_from, $date_to, $time_from, $time_to));
    }
}


