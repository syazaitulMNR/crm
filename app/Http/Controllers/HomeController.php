<?php

namespace App\Http\Controllers;

use DB;
use App\Exports\SurveyFormExport;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use App\Jobs\TiketJob;
use App\Product;
use App\Feature;
use App\StudentStaff;
use App\Package;
use App\Payment;
use App\Student;
use App\Income;
use App\Ticket;
use App\BusinessDetail;
use Illuminate\Support\Facades\Mail;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
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

    public function inviteCustomerForm($user_id) {
        Session::put('student', $user_id);
        
        return view('studentportal.inviteCustomer');
    }

    public function saveinviteCustomer(Request $request) {
        
        $validatedData = $request->validate([
            'ic' => 'required|numeric',
            'first_name'=> 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phoneno' => 'required'
        ]);

        $studstaff_id = 'ST'.uniqid();

        $studentstaff_insert = StudentStaff::create([
            'user_id' => $studstaff_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'ic' => $request->ic,
            'email' => $request->email,
            'no_phone' => $request->phoneno,
            'student_invite_id' => Session::get('student')
        ]);

        if($studentstaff_insert) {
            // succcess
            Session::forget('student');
            return redirect('invite-customer-thankyou');
        }
        
    }

    public function inviteCustomerThankyou() {
        return view('studentportal.thankyou');
    }

    // Business Details
    public function saveBusinessDetails(Request $request, $ticket_id) {
        
        $tiket = Ticket::where('ticket_id', $ticket_id)->first();
        $product = Product::where('product_id', $tiket->product_id)->first();
        $package = $request->session()->get('package');

        if(($request->session()->get('offer_id')) == 'OFF006'){
            if(Session::get('validatedIC')) {
                if(!BusinessDetail::where('ticket_id', $ticket_id)->exists()) {
                    $validatedData = $request->validate([
                        'business' => 'required',
                        'income'=> 'required',
                        'role' => 'required'
                    ]);
    
                    $data = Ticket::where('ticket_id', $ticket_id)->first();
                    $dataStudent = Student::where('ic', $data->ic)->first();
                    $name = $dataStudent->first_name . ' ' . $dataStudent->last_name;
                    if($request->business == 'Lain-lain'){
                        $type=$request->lain;
                        
                    }
                    else{
                        $type=$request->business;
                    }
                    $bussInsert = BusinessDetail::create([
                        'ticket_id' => $ticket_id,
                        'business_role' => $request->role,
                        'business_type' => $type,
                        'business_amount' => $request->income,
                        'business_name' => $type
                    ]);
    
                    $student = $request->session()->get('student');
                    $student->save();
                    
                    if($bussInsert) {
                        Session::put('product_id_session', $data->product_id);
                        Session::put('package_id_session', $data->package_id);
                        if($product->offer_id == 'OFF005'){
                            $request->session()->forget('student');
                            Session::forget('validatedIC');
                        }
                        elseif ($product->offer_id == 'OFF006'){

                        }
                        else{
                            $request->session()->forget('student');
                            Session::forget('validatedIC');
                        }

    
                        return redirect('jenis-pembayaran/'. $request->session()->get('product_id') .'/'. $request->session()->get('package_id'));
                    }
                }else {
                    return redirect('business_details/'. $ticket_id);
                }
            }else {
                return redirect('business_details/'. $ticket_id);
            }
        }
        else{
            if(Session::get('validatedIC')) {
                if(!BusinessDetail::where('ticket_id', $ticket_id)->exists()) {
                    $validatedData = $request->validate([
                        'business' => 'required',
                        'income'=> 'required',
                        'role' => 'required'
                    ]);
    
                    $data = Ticket::where('ticket_id', $ticket_id)->first();
                    $dataStudent = Student::where('ic', $data->ic)->first();
                    $name = $dataStudent->first_name . ' ' . $dataStudent->last_name;
    
                    if($request->business == 'Lain-lain'){
                        $type=$request->lain;
                        
                    }
                    else{
                        $type=$request->business;
                    }

                    $bussInsert = BusinessDetail::create([
                        'ticket_id' => $ticket_id,
                        'business_role' => $request->role,
                        'business_type' => $type,
                        'business_amount' => $request->income,
                        'business_name' => $type
                    ]);
    
                    $student = $request->session()->get('student');
                    $student->save();
                    
                    if($bussInsert) {
                        Session::put('product_id_session', $data->product_id);
                        Session::put('package_id_session', $data->package_id);
                        $request->session()->forget('student');
                        Session::forget('validatedIC');
    
                        return redirect('pendaftaran-berjaya-ticket');
                    }
                }else {
                    return redirect('business_details/'. $ticket_id);
                }
            }else {
                return redirect('business_details/'. $ticket_id);
            }
        }
    }

    public function ICValidation(Request $request, $ticket_id) {
        $data = Ticket::where('ticket_id', $ticket_id)->first();
        $dataStudent = Student::where('stud_id', $data->stud_id)->first();
        if($dataStudent->ic === $request->ic) {
            Session::put('validatedIC', 1);

            return redirect('user-details/'. $ticket_id);
            // return redirect('next-details/'. $ticket_id);
        }else {
            return redirect('business_details/'. $ticket_id);
        }
    }

    public function userDetails($ticket_id){
        if(Session::get('validatedIC')) {
            $ticket = Ticket::where('ticket_id', $ticket_id)->first();
            $student = Student::where('ic', $ticket->ic)->first();
            $product = Product::where('product_id', $ticket->product_id)->first();

            return view('ticket.userDetails', compact('student','product', 'ticket_id'));
        }else {
            return redirect('business_details/'. $ticket_id);
        }
    }

    public function businessForm($ticket_id, Request $request) {
        
        $product_id = $request->session()->get('product_id');
        $package_id = $request->session()->get('package_id');
        $student = $request->session()->get('student');
        $payment = $request->session()->get('payment');

        $data = Ticket::where('ticket_id', $ticket_id)->first();
        $dataStudent = Student::where('stud_id', $data->stud_id)->first();
        Session::put('validatedIC', 1);

        if(Session::get('validatedIC')) {
            
            $ticket = Ticket::where('ticket_id', $ticket_id)->first();
            $product = Product::where('product_id', $ticket->product_id)->first();
            $package = Package::where('package_id', $ticket->package_id)->first();
            $packageName = $package->name;
            $productName = $product->name;
            $incomeOptions = Income::all();

            $stud = Student::where('stud_id', $ticket->stud_id)->first();
            $request->session()->put('student', $stud);

            if ($product->offer_id == 'OFF005') {
                $request->session()->forget('ticket');
            } else if ($product->offer_id == 'OFF006') {
            }
            else{
                $request->session()->forget('ticket');
            }

            return view('ticket.businessDetail', compact('productName', 'packageName', 'ticket_id', 'incomeOptions', 'student', 'payment'));
        }else {
        }
    }

    public function showIC($ticket_id) {

        $ticket = Ticket::where('ticket_id', $ticket_id)->first();
        $product = Product::where('product_id', $ticket->product_id)->first();
        $package = Package::where('package_id', $ticket->package_id)->first();
        $packageName = $package->name;
        $productName = $product->name;

        return view('ticket.checkIC', compact('productName', 'packageName', 'ticket_id'));
    }

    public function saveUserDetails(Request $request, $ticket_id) {
        
        if(Session::get('validatedIC')) {
            $validatedData = $request->validate([
                'stud_id' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'ic' => 'required',
                'email' => 'required',
                'phoneno' => 'required'
            ]);

            $stud = Student::where('stud_id', $request->stud_id)->first();
            $stud->fill($validatedData);
            $request->session()->put('student', $stud);

            return redirect('next-details/'. $ticket_id);
        }else {
            return redirect('business_details/'. $ticket_id);
        }

    }

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
    // public function register_user_invite($product_id,$package_id, $user_invite)
    // {
    //     Session::put('user_invite', $user_invite);
        
    //     $package = Package::where('package_id', $package_id)->first();
    //     $product = Product::where('product_id', $product_id)->first();

    //     return view('customer_new/check_ic', compact('product', 'package'));
    //     // abort(404); 
    // }
    public function register($product_id,$package_id)
    {
        // Session::put('user_invite', $user_invite);
        
        $package = Package::where('package_id', $package_id)->first();
        $product = Product::where('product_id', $product_id)->first();

        return view('customer_new/check_ic', compact('product', 'package'));
        // abort(404); 
    }

    public function detailsic($product_id, $package_id, Request $request)
    {
        // Check if ic exist
        if(Student::where('ic', $request->ic)->exists()){
            $student = Student::where('ic', $request->ic)->first();
            return redirect('langkah-pertama/' . $product_id . '/' . $package_id .'/'.$student->stud_id);

        }else{
            return redirect('maklumat-pembeli/'. $product_id . '/' . $package_id . '/' . $request->ic);
        }
    }

    //for check if data exist from ARB Reunion
    public function detailAlumni($product_id, $package_id, Request $request)
    {
        $studid = Student::where('ic', $request->ic)->value('stud_id');
        //Package code for ARB Reunioin data
        if(Payment::where('package_id','PKD00136')->where('stud_id', $studid)->exists()) {
            // Check if ic exist
            if(Student::where('ic', $request->ic)->exists()){
                $student = Student::where('ic', $request->ic)->first();
                return redirect('langkah-pertama/' . $product_id . '/' . $package_id .'/'.$student->stud_id);

            }else{
                return redirect('maklumat-pembeli/'. $product_id . '/' . $package_id . '/' . $request->ic);
            }
        }else{
            return redirect()->back()->with('error', 'Mohon maaf maklumat anda tidak wujud. Sila hubungi Team kami.');
        }
        
    }
	
    public function thankyouTicket() {

        $product_link = Product::where('product_id', Session::get('product_id_session'))->first();
        $package_link = Package::where('package_id', Session::get('package_id_session'))->first();
        $package = $package_link->package_id;
        // $url = $product->tq_page;

        if(!is_null($product_link)) {
            $product_link = $product_link->zoom_link;
            // $tq_link = $url;
        }else {
            $product_link = "";
        }

        // Session::forget('product_id_session');
        
        return view('ticket.thankyou', compact('product_link','package'));
    }

    public function thankyou($product_id) 
    {
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('product_id', $product->product_id)->get();
        
        return view('customer/thankyou', compact('product', 'package'));
    }

    public function failed_payment() 
    {
        return view('customer/failed_payment');
    }

    /*-- Participant Registration ------------------------------------------*/
    public function check_ic($product_id)
    {
        $product = Product::where('product_id', $product_id)->first();

        return view('customer.update_participant', compact('product'));
    }

    public function verify_ic($product_id, Request $request)
    {
        // Check if ic exist
        if(Student::where('ic', $request->ic)->exists()){
            
            $student = Student::where('ic', $request->ic)->first();
            $payment = Payment::where('stud_id', $student->stud_id)->where('product_id', $product_id)->where('status', 'paid')->first();

            if ($payment) {

                //if payment success
                return redirect('updateform/' . $product_id . '/' . $payment->package_id . '/' . $student->stud_id . '/' . $payment->payment_id);

            }else{

                //if payment failed
                return view('certificate.not_found');

            }

        }else{

            //if customer not found in database
            return view('certificate.not_found');

        }
    }

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

                //for Bulk Ticket
                return view('customer.loopingform', compact('student','product', 'package', 'payment', 'count', 'phonecode'));
                
            } else if($payment->offer_id == 'OFF004') {

                //for Bulk Ticket
                return view('customer.loopingform', compact('student','product', 'package', 'payment', 'count', 'phonecode'));    

            } else if($payment->offer_id == 'OFF005') {

                //for Bulk Ticket
                return view('customer.loopingform', compact('student','product', 'package', 'payment', 'count', 'phonecode'));
        
            } else if($payment->offer_id == 'OFF006') {

                //for Bulk Ticket
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

                switch ($request->input('kehadiran')) {
                    case 'hadir':
                        // To tell system the participant form has been key in
                        $payment->attendance = "hadir";
                        $payment->save();
                        break;
            
                    case 'tidak hadir':
                        // To tell system the participant form has been key in
                        $payment->attendance = "tidak hadir";
                        $payment->save();
                        break;
                }
                
                if(Student::where('ic', $request->ic)->exists())  //If the ic at single form exist
                {
                    if ($payment->quantity == 1){

                        // Can access single form

                    }else{
                        
                        // Can access looping form
                        foreach($request->ic_peserta as $key => $value)
                        {
                            // Check if the ic at looping form exist
                            if(Student::where('ic', $value)->exists())
                            {    
                                $participant = Student::where('ic', $value)->first();
                                $participant_id = $participant->stud_id;

                                // Process for Paid Ticket form
                                $ticket = Ticket::orderBy('id','Desc')->first();
                                $auto_inc_tik = $ticket->id + 1;
                                $ticket_id = 'TIK' . 0 . 0 . $auto_inc_tik;

                                Ticket::create(array(
                                    'ticket_id' => $ticket_id,
                                    'ticket_type' => 'paid',
                                    'ic' => $value,
                                    'pay_price' => $payment->pay_price,
                                    'stud_id' => $participant_id,
                                    'product_id' => $product_id,
                                    'package_id' => $package_id,
                                    'payment_id' => $payment_id,
                                    'pay_method' => $payment->pay_method,
                                    'receipt_path' => $payment->receipt_path,
                                    'pay_datetime' => $payment->pay_datetime,
                                    'pic' => $payment->pic
                                ));

                                // Manage email (for existed ic in looping form) 
                                $product = Product::where('product_id', $product_id)->first();
                                $package = Package::where('package_id', $package_id)->first();

                                $email = $request->email_peserta[$key]; 
                                $product_name = $product->name; 
                                $package_name = $package->name; 
                                $date_from = $product->date_from;
                                $date_to = $product->date_to;
                                $time_from = $product->time_from;
                                $time_to = $product->time_to;
                                $packageId = $package_id;
                                $productId = $product_id;        
                                $student_id = $participant_id;
                                $survey_form = $product->survey_form;
                                
                                dispatch(new TiketJob($email, $product_name, $package_name, $date_from, $date_to, $time_from, $time_to, $packageId, $productId, $student_id, $survey_form));
                                
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
                                'ic' => $value,
                                'pay_price' => $payment->pay_price,
                                'stud_id' => $stud_id_looping,
                                'product_id' => $product_id,
                                'package_id' => $package_id,
                                'payment_id' => $payment_id,
                                'pay_method' => $payment->pay_method,
                                'receipt_path' => $payment->receipt_path,
                                'pay_datetime' => $payment->pay_datetime,
                                'pic' => $payment->pic
                            ));
                
                            // Manage email (for existed ic in looping form) 
                            $product = Product::where('product_id', $product_id)->first();
                            $package = Package::where('package_id', $package_id)->first();

                            $email = $request->email_peserta[$key]; 
                            $product_name = $product->name; 
                            $package_name = $package->name; 
                            $date_from = $product->date_from;
                            $date_to = $product->date_to;
                            $time_from = $product->time_from;
                            $time_to = $product->time_to;
                            $packageId = $package_id;
                            $productId = $product_id;        
                            $student_id = $stud_id_looping;
                            $survey_form = $product->survey_form;
                            
                            dispatch(new TiketJob($email, $product_name, $package_name, $date_from, $date_to, $time_from, $time_to, $packageId, $productId, $student_id, $survey_form));
                            
                        }
                    }

                    $participant = Student::where('ic', $request->ic)->first();
                    $participant_id = $participant->stud_id;

                    // Process for Paid Ticket form
                    $ticket = Ticket::orderBy('id','Desc')->first();
                    $auto_inc_tik = $ticket->id + 1;
                    $ticket_id = 'TIK' . 0 . 0 . $auto_inc_tik;

                    Ticket::create(array(
                        'ticket_id' => $ticket_id,
                        'ticket_type' => 'paid',
                        'ic' => $request->ic,
                        'pay_price' => $payment->pay_price,
                        'stud_id' => $participant_id,
                        'product_id' => $product_id,
                        'package_id' => $package_id,
                        'payment_id' => $payment_id,
                        'pay_method' => $payment->pay_method,
                        'receipt_path' => $payment->receipt_path,
                        'pay_datetime' => $payment->pay_datetime,
                        'pic' => $payment->pic
                    ));

                    // Manage email (for existed ic in looping form) 
                    $product = Product::where('product_id', $product_id)->first();
                    $package = Package::where('package_id', $package_id)->first();

                    $email = $request->email; 
                    $product_name = $product->name; 
                    $package_name = $package->name; 
                    $date_from = $product->date_from;
                    $date_to = $product->date_to;
                    $time_from = $product->time_from;
                    $time_to = $product->time_to;
                    $packageId = $package_id;
                    $productId = $product_id;        
                    $student_id = $participant_id;
                    $survey_form = $product->survey_form;
                    
                    dispatch(new TiketJob($email, $product_name, $package_name, $date_from, $date_to, $time_from, $time_to, $packageId, $productId, $student_id, $survey_form)); 

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
                        'ic' => $request->ic,
                        'pay_price' => $payment->pay_price,
                        'stud_id' => $stud_id_single,
                        'product_id' => $product_id,
                        'package_id' => $package_id,
                        'payment_id' => $payment_id,
                        'pay_method' => $payment->pay_method,
                        'receipt_path' => $payment->receipt_path,
                        'pay_datetime' => $payment->pay_datetime,
                        'pic' => $payment->pic
                    ));

                    // Manage email (for new ic in single form)                    
                    $product = Product::where('product_id', $product_id)->first();
                    $package = Package::where('package_id', $package_id)->first();

                    $email = $request->email; 
                    $product_name = $product->name; 
                    $package_name = $package->name; 
                    $date_from = $product->date_from;
                    $date_to = $product->date_to;
                    $time_from = $product->time_from;
                    $time_to = $product->time_to;
                    $packageId = $package_id;
                    $productId = $product_id;        
                    $student_id = $stud_id_single;
                    $survey_form = $product->survey_form;
                    
                    dispatch(new TiketJob($email, $product_name, $package_name, $date_from, $date_to, $time_from, $time_to, $packageId, $productId, $student_id, $survey_form));
            
                    if ($payment->quantity == 1){ //If quantity = 1
                        // Can access single form
                    }else{

                        // Can access looping form
                        foreach($request->ic_peserta as $key => $value){

                            // If the ic at looping form exist
                            if(Student::where('ic', $value)->exists())
                            {
                                $participant = Student::where('ic', $value)->first();
                                $participant_id = $participant->stud_id;
                                
                                // Process for Paid Ticket form
                                $ticket = Ticket::orderBy('id','Desc')->first();
                                $auto_inc_tik = $ticket->id + 1;
                                $ticket_id = 'TIK' . 0 . 0 . $auto_inc_tik;

                                Ticket::create(array(
                                    'ticket_id' => $ticket_id,
                                    'ticket_type' => 'paid',
                                    'ic' => $value,
                                    'pay_price' => $payment->pay_price,
                                    'stud_id' => $participant_id,
                                    'product_id' => $product_id,
                                    'package_id' => $package_id,
                                    'payment_id' => $payment_id,
                                    'pay_method' => $payment->pay_method,
                                    'receipt_path' => $payment->receipt_path,
                                    'pay_datetime' => $payment->pay_datetime,
                                    'pic' => $payment->pic
                                ));

                                // Manage email (for existed ic in single form)                        
                                $product = Product::where('product_id', $product_id)->first();
                                $package = Package::where('package_id', $package_id)->first();

                                $email = $request->email_peserta[$key];
                                $product_name = $product->name; 
                                $package_name = $package->name; 
                                $date_from = $product->date_from;
                                $date_to = $product->date_to;
                                $time_from = $product->time_from;
                                $time_to = $product->time_to;
                                $packageId = $package_id;
                                $productId = $product_id;        
                                $student_id = $participant_id;
                                $survey_form = $product->survey_form;
                                
                                dispatch(new TiketJob($email, $product_name, $package_name, $date_from, $date_to, $time_from, $time_to, $packageId, $productId, $student_id, $survey_form));
                                
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
                                'ic' => $value,
                                'pay_price' => $payment->pay_price,
                                'stud_id' => $stud_id_looping,
                                'product_id' => $product_id,
                                'package_id' => $package_id,
                                'payment_id' => $payment_id,
                                'pay_method' => $payment->pay_method,
                                'receipt_path' => $payment->receipt_path,
                                'pay_datetime' => $payment->pay_datetime,
                                'pic' => $payment->pic
                            ));
                                                    
                            // Manage email (for new ic in looping form)
                            $product = Product::where('product_id', $product_id)->first();
                            $package = Package::where('package_id', $package_id)->first();

                            $email = $request->email_peserta[$key];
                            $product_name = $product->name; 
                            $package_name = $package->name; 
                            $date_from = $product->date_from;
                            $date_to = $product->date_to;
                            $time_from = $product->time_from;
                            $time_to = $product->time_to;
                            $packageId = $package_id;
                            $productId = $product_id;        
                            $student_id = $stud_id_looping;
                            $survey_form = $product->survey_form;
                            
                            dispatch(new TiketJob($email, $product_name, $package_name, $date_from, $date_to, $time_from, $time_to, $packageId, $productId, $student_id, $survey_form));
                            
                        }
                    }
                }

                return redirect('thankyou-update/' . $product_id );
            }
        }

    }

    //For buy 1 free 1
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
                
                if(Student::where('ic', $request->ic)->exists()) // If the ic at paid ticket form exist
                {
                    $participant = Student::where('ic', $request->ic)->first();
                    $participant_id = $participant->stud_id;

                    // Process for Paid Ticket form
                    $ticket = Ticket::orderBy('id','Desc')->first();
                    $auto_inc_tik = $ticket->id + 1;
                    $ticket_id = 'TIK' . 0 . 0 . $auto_inc_tik;

                    Ticket::create(array(
                        'ticket_id' => $ticket_id,
                        'ticket_type' => 'paid',
                        'ic' => $request->ic,
                        'pay_price' => $payment->pay_price,
                        'stud_id' => $participant_id,
                        'product_id' => $product_id,
                        'package_id' => $package_id,
                        'payment_id' => $payment_id,
                        'pay_method' => $payment->pay_method,
                        'receipt_path' => $payment->receipt_path,
                        'pay_datetime' => $payment->pay_datetime,
                        'pic' => $payment->pic
                    ));

                    // Manage email (for existed ic in paid ticket form)  
                    $product = Product::where('product_id', $product_id)->first();
                    $package = Package::where('package_id', $package_id)->first();

                    $email = $request->email;
                    $product_name = $product->name; 
                    $package_name = $package->name; 
                    $date_from = $product->date_from;
                    $date_to = $product->date_to;
                    $time_from = $product->time_from;
                    $time_to = $product->time_to;
                    $packageId = $package_id;
                    $productId = $product_id;        
                    $student_id = $participant_id;
                    $survey_form = $product->survey_form;
                    
                    dispatch(new TiketJob($email, $product_name, $package_name, $date_from, $date_to, $time_from, $time_to, $packageId, $productId, $student_id, $survey_form));
                        
                    // Process for free ticket form
                    if(Student::where('ic', $request->ic_free1)->exists()) // Check if the ic at free ticket form exist
                    {    
                        $participant = Student::where('ic', $request->ic_free1)->first();
                        $participant_id = $participant->stud_id;

                        $ticket = Ticket::orderBy('id','Desc')->first();
                        $auto_inc_tik = $ticket->id + 1;
                        $ticket_id = 'TIK' . 0 . 0 . $auto_inc_tik;

                        Ticket::create(array(
                            'ticket_id' => $ticket_id,
                            'ticket_type' => 'free',
                            'ic' => $request->ic_free1,
                            'pay_price' => $payment->pay_price,
                            'stud_id' => $participant_id,
                            'product_id' => $product_id,
                            'package_id' => $package_id,
                            'payment_id' => $payment_id,
                            'pay_method' => $payment->pay_method,
                            'receipt_path' => $payment->receipt_path,
                            'pay_datetime' => $payment->pay_datetime,
                            'pic' => $payment->pic
                        ));

                        // Manage email (for existed ic in looping form) 
                        $product = Product::where('product_id', $product_id)->first();
                        $package = Package::where('package_id', $package_id)->first();

                        $email = $request->email_free1;
                        $product_name = $product->name; 
                        $package_name = $package->name; 
                        $date_from = $product->date_from;
                        $date_to = $product->date_to;
                        $time_from = $product->time_from;
                        $time_to = $product->time_to;
                        $packageId = $package_id;
                        $productId = $product_id;        
                        $student_id = $participant_id;
                        $survey_form = $product->survey_form;
                        
                        dispatch(new TiketJob($email, $product_name, $package_name, $date_from, $date_to, $time_from, $time_to, $packageId, $productId, $student_id, $survey_form));

                    } else {

                        // If ic at free ticket form not exist
                        $stud_id_free = 'MI'.uniqid();

                        Student::create(array(

                            'stud_id'=> $stud_id_free,
                            'first_name' => $request->firstname_free1,
                            'last_name' => $request->lastname_free1,
                            'ic' => $request->ic_free1,
                            'pay_price' => $payment->pay_price,
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
                            'ic' => $request->ic_free1,
                            'pay_price' => $payment->pay_price,
                            'stud_id' => $stud_id_free,
                            'product_id' => $product_id,
                            'package_id' => $package_id,
                            'payment_id' => $payment_id,
                            'pay_method' => $payment->pay_method,
                            'receipt_path' => $payment->receipt_path,
                            'pay_datetime' => $payment->pay_datetime,
                            'pic' => $payment->pic
                        ));
            
                        // Manage email (for new ic in looping form)
                        $product = Product::where('product_id', $product_id)->first();
                        $package = Package::where('package_id', $package_id)->first();

                        $email = $request->email_free1;
                        $product_name = $product->name; 
                        $package_name = $package->name; 
                        $date_from = $product->date_from;
                        $date_to = $product->date_to;
                        $time_from = $product->time_from;
                        $time_to = $product->time_to;
                        $packageId = $package_id;
                        $productId = $product_id;        
                        $student_id = $stud_id_free;
                        $survey_form = $product->survey_form;
                        
                        dispatch(new TiketJob($email, $product_name, $package_name, $date_from, $date_to, $time_from, $time_to, $packageId, $productId, $student_id, $survey_form));     
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
                        'ic' => $request->ic,
                        'pay_price' => $payment->pay_price,
                        'stud_id' => $stud_id_paid,
                        'product_id' => $product_id,
                        'package_id' => $package_id,
                        'payment_id' => $payment_id,
                        'pay_method' => $payment->pay_method,
                        'receipt_path' => $payment->receipt_path,
                        'pay_datetime' => $payment->pay_datetime,
                        'pic' => $payment->pic
                    ));
                                    
                    // Manage email (for new ic in paid ticket form)   
                    $product = Product::where('product_id', $product_id)->first();
                    $package = Package::where('package_id', $package_id)->first();

                    $email = $request->email;
                    $product_name = $product->name; 
                    $package_name = $package->name; 
                    $date_from = $product->date_from;
                    $date_to = $product->date_to;
                    $time_from = $product->time_from;
                    $time_to = $product->time_to;
                    $packageId = $package_id;
                    $productId = $product_id;        
                    $student_id = $stud_id_paid;
                    $survey_form = $product->survey_form;
                    
                    dispatch(new TiketJob($email, $product_name, $package_name, $date_from, $date_to, $time_from, $time_to, $packageId, $productId, $student_id, $survey_form));        
                
                    // Process for free ticket form
                    if(Student::where('ic', $request->ic_free1)->exists()) // If the ic at free ticket form exist
                    {
                        $participant = Student::where('ic', $request->ic_free1)->first();
                        $participant_id = $participant->stud_id;

                        $ticket = Ticket::orderBy('id','Desc')->first();
                        $auto_inc_tik = $ticket->id + 1;
                        $ticket_id = 'TIK' . 0 . 0 . $auto_inc_tik;

                        Ticket::create(array(
                            'ticket_id' => $ticket_id,
                            'ticket_type' => 'free',
                            'ic' => $request->ic_free1,
                            'pay_price' => $payment->pay_price,
                            'stud_id' => $participant_id,
                            'product_id' => $product_id,
                            'package_id' => $package_id,
                            'payment_id' => $payment_id,
                            'pay_method' => $payment->pay_method,
                            'receipt_path' => $payment->receipt_path,
                            'pay_datetime' => $payment->pay_datetime,
                            'pic' => $payment->pic
                        ));

                        // Manage email (for existed ic in free ticket form)      
                        $product = Product::where('product_id', $product_id)->first();
                        $package = Package::where('package_id', $package_id)->first();

                        $email = $request->email_free1;
                        $product_name = $product->name; 
                        $package_name = $package->name; 
                        $date_from = $product->date_from;
                        $date_to = $product->date_to;
                        $time_from = $product->time_from;
                        $time_to = $product->time_to;
                        $packageId = $package_id;
                        $productId = $product_id;        
                        $student_id = $participant_id;
                        $survey_form = $product->survey_form;
                        
                        dispatch(new TiketJob($email, $product_name, $package_name, $date_from, $date_to, $time_from, $time_to, $packageId, $productId, $student_id, $survey_form));          

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
                            'ic' => $request->ic_free1,
                            'pay_price' => $payment->pay_price,
                            'stud_id' => $stud_id_free,
                            'product_id' => $product_id,
                            'package_id' => $package_id,
                            'payment_id' => $payment_id,
                            'pay_method' => $payment->pay_method,
                            'receipt_path' => $payment->receipt_path,
                            'pay_datetime' => $payment->pay_datetime,
                            'pic' => $payment->pic
                        ));

                        // Manage email (for new ic in looping form)
                        $product = Product::where('product_id', $product_id)->first();
                        $package = Package::where('package_id', $package_id)->first();

                        $email = $request->email_free1;
                        $product_name = $product->name; 
                        $package_name = $package->name; 
                        $date_from = $product->date_from;
                        $date_to = $product->date_to;
                        $time_from = $product->time_from;
                        $time_to = $product->time_to;
                        $packageId = $package_id;
                        $productId = $product_id;        
                        $student_id = $stud_id_free;
                        $survey_form = $product->survey_form;
                        
                        dispatch(new TiketJob($email, $product_name, $package_name, $date_from, $date_to, $time_from, $time_to, $packageId, $productId, $student_id, $survey_form));
                        
                    }
                }

                return redirect('thankyou-update/' . $product_id );
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

    public function thankyou_update($product_id) 
    {
        $product = Product::where('product_id', $product_id)->first();
        $url = $product->tq_page;

        return new RedirectResponse($url);
        // return view('customer.thankyou_update', compact('product'));
    }

    public function exportsurveyform($product_id)
    {   

        // $business = DB::table('business_details')->get();
        // // $ticket = DB::table('ticket')->where('product_id','PRD0034')->get();
        // $ticket = DB::table('ticket')->where('ticket_type','paid')->where('product_id','PRD0037')->get();
        // $student = DB::table('student')->get();
        $product = DB::table('product')->where('product_id',$product_id)->first();

        Session::put('product_id',$product_id);

        return Excel::download(new SurveyFormExport(), '' .$product->name.'.xlsx');
    }

    public function exporttest() 
    {
        return Excel::download(new UsersExport, 'student.xlsx');
    }

    
    ///////////////////////////////    Manual Export Survey Form   ////////////////////////////////////////
    public function surveyform()
    {   

        $business = DB::table('business_details')->get();
        // $ticket = DB::table('ticket')->where('product_id','PRD0034')->get();
        $ticket = DB::table('ticket')->where('ticket_type','paid')->where('product_id', 'PRD0083')->get();
        $student = DB::table('student')->get();
        $product = DB::table('product')->where('product_id', 'PRD0083')->first();
        // dd($ticket);
        // $package = DB::table('package')->where('package_id', 'PKD0065')->first();

            /*-- Success Payment ---------------------------------------------------*/
            $fileName = $product->product_id.' '. uniqid() .'.csv';
            $columnNames = [
                'First Name',
                'Last Name',
                'IC No',
                'Phone No',
                'Email',
                'Gender',
                'Business Type',
                'Business Role',
                'Business Amount',
                'Class',
                'Pay Price',
                'Registered At'
            ];
            
            $file = fopen(public_path('export/') . $fileName, 'w');
            fputcsv($file, $columnNames);
            
            foreach ($student as $students) {
                foreach($ticket as $tickets){
                    if ($tickets->ic == $students->ic){
                        foreach($business as $businessdetails){
                            if ($tickets->ticket_id == $businessdetails->ticket_id){
                                    
                                    fputcsv($file, [
                                    $students->first_name,
                                    $students->last_name,
                                    $students->ic,
                                    $students->phoneno,
                                    $students->email,
                                    $students->gender,
                                    $businessdetails->business_type,
                                    $businessdetails->business_role,
                                    $businessdetails->business_amount,
                                    $product->name,
                                    $tickets->pay_price,
                                    $tickets->created_at,
                                ]);
                            }
                        }
                    }
                }
            }

            fclose($file);

        
        // Mail::send('emails.export_mail', [], function($message) use ($fileName)
        // {
        //     // $message->to(request()->receipient_mail)->subject('ATTACHMENT OF PARTICIPANT DETAILS');
        //     $message->to('adessnoob99@gmail.com')->subject('ATTACHMENT OF PARTICIPANT DETAILS');
        //     $message->attach(public_path('export/') . $fileName);
        // });


        return redirect('customer_details/')->with('export-participant','The participant details has been successfully sent to the email given.');

    }

}


