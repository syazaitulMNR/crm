<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Product;
use App\Package;
use App\Student;
use App\Payment;
use App\Ticket;
use Carbon\Carbon;
use Stripe;
use Mail;
use Billplz\Client;
use App\Jobs\PengesahanJob;
use App\Jobs\TiketJob;

class NewCustomerController extends Controller
{
    public function index($product_id, $package_id)
    {
        $student = Student::all();
        $product = Product::where('product_id',$product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
  
        return view('customer_new.check_ic',compact('student', 'product', 'package'));
    }
  
    /**
     * Show the step One Form for creating a new product.
     *
     * @return \Illuminate\Http\Response
     */
    public function createStepOne($product_id, $package_id, $get_ic, Request $request)
    {
        $stud_ic = $get_ic;
        $product = Product::where('product_id',$product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $student = $request->session()->get('student');
        
        //generate id
        $stud_id = 'MI'.uniqid();
  
        return view('customer_new.step1',compact('student', 'product', 'package', 'stud_ic', 'stud_id'));
    }
  
    /**  
     * Post Request to store step1 info in session
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postCreateStepOne($product_id, $package_id, Request $request)
    {      
        $validatedData = $request->validate([
            'stud_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'ic' => 'required',
            'email' => 'required',
            'phoneno' => 'required'
        ]);

        $validatedData['student_password'] = "";
  
        if(empty($request->session()->get('student'))){
            $student = new Student();
            $student->fill($validatedData);
            $request->session()->put('student', $student);
        }else{
            $student = $request->session()->get('student');
            $student->fill($validatedData);
            $request->session()->put('student', $student);
        }
  
        return redirect('maklumat-tiket/'.  $product_id . '/' . $package_id );
    }
  
    /**
     * Show the step One Form for creating a new product.
     *
     * @return \Illuminate\Http\Response
     */
    public function createStepTwo($product_id, $package_id, Request $request)
    {
        $product = Product::where('product_id',$product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $package_name = Package::where('product_id', $product_id)->get();
		$count_package = Package::where('product_id', $product_id)->count();
        $student = $request->session()->get('student');
        $payment = $request->session()->get('payment');
        $ticket = $request->session()->get('ticket');
        // dd($product->offer_id);

        //generate id
        $payment_id = 'OD'.uniqid();
        $ticket_id = 'TIK'.uniqid();
        $ticket_type = 'paid';
        
        if($product->offer_id == 'OFF001') {

            //for no offer ticket
            return view('customer_new.step2_nooffer',compact('student', 'payment', 'product', 'package', 'payment_id', 'ticket_id', 'ticket_type', 'package_name'));

        } else if($product->offer_id == 'OFF002') {

            //for Buy 1 Get 1 (Same Ticket)
            return view('customer_new.step2_get1free1same',compact('student', 'payment', 'product', 'package', 'payment_id', 'ticket_id', 'ticket_type', 'package_name'));

        } else if($product->offer_id == 'OFF003') {

            //for Bulk Ticket (1,2,3)
            if($count_package == 1){
                
                //if only one package for the event
                return view('customer_new.step2_bulkticket1',compact('student', 'payment', 'product', 'package', 'payment_id', 'ticket_id', 'ticket_type', 'package_name'));
      
            } else {
      
                //if has 3 package for the event
                return view('customer_new.step2_bulkticket',compact('student', 'payment', 'product', 'package', 'payment_id', 'ticket_id', 'ticket_type', 'package_name'));
      
            }
            
        } else if($product->offer_id == 'OFF004') {
      
            //for Bulk Ticket (1,3,5)
            if($count_package == 1){
      
                //if only one package for the event
                return view('customer_new.step2_bulkticket1',compact('student', 'payment', 'product', 'package', 'payment_id', 'ticket_id', 'ticket_type', 'package_name'));
      
            } else {
      
                //if has 3 package for the event
                return view('customer_new.step2_bulkticket',compact('student', 'payment', 'product', 'package', 'payment_id', 'ticket_id', 'ticket_type', 'package_name'));
      
            }

        } else if($product->offer_id == 'OFF005') {
      
            //for free ticket
            return view('customer_new.step2_freeticket',compact('student', 'payment', 'product', 'package', 'payment_id', 'ticket_id', 'ticket_type', 'package_name'));

        } else if($product->offer_id == 'OFF006') {
    
            //for paid ticket
            return view('customer_new.step2_paidticket',compact('student', 'payment', 'product', 'package', 'payment_id', 'ticket_id', 'ticket_type', 'package_name'));

        } else {

            echo 'No Such Offer test';

        }
        
    }
  
    /**
     * Show the step One Form for creating a new product.
     *
     * @return \Illuminate\Http\Response
     */
    public function postCreateStepTwo($product_id, $package_id, Request $request)
    {
        $product = Product::where('product_id',$product_id)->first();

        if ($product->offer_id == 'OFF005' || $product->offer_id == 'OFF006') {
            $validatedPayment = $request->validate([
                'payment_id' => 'required',
                'pay_price'=> 'required|numeric',
                'quantity' => 'required|numeric',
                'totalprice'=> 'numeric',
                'stud_id' => 'required',
                'product_id' => 'required',
                'package_id' => 'required',
                'offer_id' => 'required'
            ]);
    
            $validatedTicket = $request->validate([
                'ticket_id' => 'required',
                'ticket_type'=> 'required',
                'ic' => 'required',
                'pay_price'=> 'required|numeric',
                'stud_id' => 'required',
                'product_id' => 'required',
                'package_id' => 'required',
                'payment_id' => 'required'
            ]);
        } else {
            $validatedPayment = $request->validate([
                'payment_id' => 'required',
                'pay_price'=> 'required|numeric',
                'quantity' => 'required|numeric',
                'totalprice'=> 'required|numeric',
                'stud_id' => 'required',
                'product_id' => 'required',
                'package_id' => 'required',
                'offer_id' => 'required'
            ]);
    
            $validatedTicket = $request->validate([
                'ticket_id' => 'required',
                'ticket_type'=> 'required',
                'ic' => 'required',
                'pay_price'=> 'required|numeric',
                'stud_id' => 'required',
                'product_id' => 'required',
                'package_id' => 'required',
                'payment_id' => 'required'
            ]);
        }
        
        if ($product->offer_id == 'OFF005' || $product->offer_id == 'OFF006'){
            $student = $request->session()->get('student');

            $request->session()->get('payment');
            $payment = new Payment();
            $payment->fill($validatedPayment);
            $request->session()->put('payment', $payment);

            $request->session()->get('ticket');
            $ticket = new Ticket();
            $ticket->fill($validatedTicket);
            $request->session()->put('ticket', $ticket);

            return redirect('pengesahan-pembelian/'.  $product_id . '/' . $package_id );
        }
        else {
            if($request->quantity == 1){
                
                $student = $request->session()->get('student');

                $request->session()->get('payment');
                $payment = new Payment();
                $payment->fill($validatedPayment);
                $request->session()->put('payment', $payment);

                $request->session()->get('ticket');
                $ticket = new Ticket();
                $ticket->fill($validatedTicket);
                $request->session()->put('ticket', $ticket);
        
                return redirect('pengesahan-pembelian/'.  $product_id . '/' . $package_id );

            }else{

                $request->session()->get('payment');
                $payment = new Payment();
                $payment->fill($validatedPayment);
                $request->session()->put('payment', $payment);
        
                return redirect('pengesahan-pembelian/'.  $product_id . '/' . $package_id );
            }
        }
    }
  
    /**
     * Show the step One Form for creating a new product.
     *
     * @return \Illuminate\Http\Response
     */
    public function createStepThree($product_id, $package_id, Request $request)
    {
        $product = Product::where('product_id',$product_id)->first();
        $package = Package::where('package_id', $package_id)->first();

        $student = $request->session()->get('student');
        $payment = $request->session()->get('payment');

        Session::put('offer_id', $product->offer_id);
        Session::put('product_id', $product_id);
        Session::put('package_id', $package_id);
        Session::put('payment', $payment);

        return view('customer_new.step3',compact('student', 'payment', 'product', 'package'));
    }

    /**
     * Show the step One Form for creating a new product.
     *
     * @return \Illuminate\Http\Response
     */
    public function createStepFour($product_id, $package_id, Request $request)
    {
        $product = Product::where('product_id',$product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $student = $request->session()->get('student');
        $payment = $request->session()->get('payment');
        
        $card = 'Debit/Credit Card';
        $fpx = 'FPX';
        $manual = 'Manual';

        return view('customer_new.step4',compact('student', 'payment', 'product', 'package', 'card', 'fpx', 'manual'));
    }

    /**
     * Show the step One Form for creating a new product.
     *
     * @return \Illuminate\Http\Response
     */
    public function postCreateStepFour($product_id, $package_id, Request $request)
    {
        $ticket = $request->session()->get('ticket');

        $validatedData = $request->validate([
            'pay_method' => 'required',
        ]);

        // $package = $request->session()->get('package');
        // dd($package);
        $payment = $request->session()->get('payment');
        $payment->fill($validatedData);
        $request->session()->put('payment', $payment);

        return redirect('payment-method/'.  $product_id . '/' . $package_id );
    }

    public function payment_method($product_id, $package_id, Request $request)
    {
        $product = Product::where('product_id',$product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $student = $request->session()->get('student');
        $payment = $request->session()->get('payment');

        //Check if form has been key in
        if($payment->pay_method == 'Debit/Credit Card'){

            return redirect('maklumat-kad/'.  $product_id . '/' . $package_id );

        }else if($payment->pay_method == 'FPX'){

            return redirect('data-fpx/'.  $product_id . '/' . $package_id );

        }else if($payment->pay_method == 'Manual'){

            return redirect('maklumat-pembayaran/'.  $product_id . '/' . $package_id );

        }else{

            echo 'invalid';

        }
    }

    public function card_payment($product_id, $package_id, Request $request)
    {
        $product = Product::where('product_id',$product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $student = $request->session()->get('student');
        $payment = $request->session()->get('payment');

        return view('customer_new.card_method',compact('product', 'package', 'student', 'payment'));
    }

    public function postCardMethod($product_id, $package_id, Request $request)
    {        
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $payment = $request->session()->get('payment');
        $student = $request->session()->get('student');

        /*-- Stripe ---------------------------------------------------------*/
        //Make Payment
        $stripe = Stripe\Stripe::setApiKey('sk_live_B9VWddnqzpICNS9gsPBI4jSc00v60OUVak');

        try {

            // Generate token
            $token = Stripe\Token::create(array(
                "card" => array(
                    "number"    => $request->cardnumber,
                    "exp_month" => $request->month,
                    "exp_year"  => $request->year,
                    "cvc"       => $request->cvc,
                    "name"      => $request->cardholder
                )
            ));

            // If not generate view error
            if (!isset($token['id'])) {

                return redirect()->back()->with('error','Token is not generate correct');
            
            }   else{
    
                // Create a Customer:
                $customer = \Stripe\Customer::create([

                    'name' => $student->first_name,
                    'source' => $token['id'],
                    'email' => $student->email,
                ]);

                // Make a Payment
                Stripe\Charge::create([
                    "currency" => "myr",
                    "description" => "MIMS - ".$package->name,
                    "customer" => $customer->id,
                    "amount" => $payment->totalprice * 100,
                ]);
            }

            $addData = array(
                'status' => 'paid',
                'stripe_id' => $customer->id
            );

            $payment->fill($addData);
            $request->session()->put('payment', $payment);

        } catch (\Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
        /*-- End Stripe -----------------------------------------------------*/

        /*-- Manage Email ---------------------------------------------------*/

        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();

        if($payment->quantity == 1){

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
            $ticket_id = $ticket->ticket_id;
            $survey_form = $product->survey_form;

            $student->save();
            $payment->save();
            $ticket->save();
            
            dispatch(new TiketJob($email, $product_name, $package_name, $date_from, $date_to, $time_from, $time_to, $packageId, $productId, $student_id, $survey_form));
                
            $request->session()->forget('student');
            $request->session()->forget('payment');
            $request->session()->forget('ticket');
            
            return redirect('pendaftaran-berjaya/' . $product_id );

        }else{

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

            $student->save();
            $payment->save();

            dispatch(new PengesahanJob($send_mail, $product_name, $package_name, $date_from, $date_to, $time_from, $time_to, $packageId, $payment_id, $productId, $student_id));
            
            $request->session()->forget('student');
            $request->session()->forget('payment');
            $request->session()->forget('ticket');
            
            return redirect('pendaftaran-berjaya/' . $product_id );
        }

        /*-- End Email -----------------------------------------------------------*/
  
    }

    public function pay_billplz($product_id, $package_id, Request $request)
    {
        $product = Product::where('product_id',$product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $student = $request->session()->get('student');
        $payment = $request->session()->get('payment');
        $ticket = $request->session()->get('ticket');

        $billplz = Client::make(env('BILLPLZ_API_KEY', '3f78dfad-7997-45e0-8428-9280ba537215'), env('BILLPLZ_X_SIGNATURE', 'S-jtSalzkEawdSZ0Mb0sqmgA'));

        $bill = $billplz->bill();

        try {
            
                $response = $bill->create(
                $product->collection_id,
                $student->email,
                $student->phoneno,
                $student->first_name,
                \Duit\MYR::given($payment->totalprice * 100),
                'https://mims.momentuminternet.my/callback-payment/'.  $product_id . '/' . $package_id,
                $product->name . ' - ' . $package->name,
                ['redirect_url' => 'https://mims.momentuminternet.my/redirect-payment/'.  $product_id . '/' . $package_id]
            );

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Maaf! Emel atau No Telefon Anda Tidak Tepat.');
        }
        
        $pay_data = $response->toArray();
        
        $addData = array(
            'billplz_id' => $pay_data['id']
        );

        $payment->fill($addData);
        $request->session()->put('payment', $payment);

        return redirect($pay_data['url']);
    }

    public function callback_payment($product_id, $package_id, Request $request)
    {
        $student = $request->session()->get('student');
        $payment = $request->session()->get('payment');
		
		Session::put('product_id_session', $product_id);
		
        $addDataPassword = array(
            'student_password' => ""
        );

        $student->fill($addDataPassword);
		
        $ticket = $request->session()->get('ticket');
        $billplz = Client::make(env('BILLPLZ_API_KEY', '3f78dfad-7997-45e0-8428-9280ba537215'), env('BILLPLZ_X_SIGNATURE', 'S-jtSalzkEawdSZ0Mb0sqmgA'));
        //get the bill
        $bill = $billplz->bill();
        $response = $bill->get($payment->billplz_id);
        
        $pay_data = $response->toArray();

        //update payment history status to database
        $addData = array(
            'status' => $pay_data['state']
        );

        $payment->fill($addData);
        $request->session()->put('payment', $payment);
        
        if ($payment->status == 'paid'|| 1)
        {
            $addDataUserInvite = array(
                'user_invite' => Session::get('user_invite')
            );
    
            $payment->fill($addDataUserInvite);
            
            /*-- Manage Email ---------------------------------------------------*/

            $product = Product::where('product_id', $product_id)->first();
            $package = Package::where('package_id', $package_id)->first();

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

            $student->save();
            $payment->save();

            
            dispatch(new PengesahanJob($send_mail, $product_name, $package_name, $date_from, $date_to, $time_from, $time_to, $packageId, $payment_id, $productId, $student_id));          
            /*-- End Email -----------------------------------------------------------*/
            
            $request->session()->forget('student');
            $request->session()->forget('payment');
            Session::forget('user_invite');
			
            if($payment->quantity == 1){
    
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
                $ticket_id = $ticket->ticket_id;
                $survey_form = $product->survey_form;

                //update participant form to database
                $updateform = array(
                    'update_count' => 1
                );

                $payment->fill($updateform);
                $request->session()->put('payment', $payment);
    
                $student->save();
                $payment->save();
                $ticket->save();
                
                dispatch(new TiketJob($email, $product_name, $package_name, $date_from, $date_to, $time_from, $time_to, $packageId, $productId, $student_id, $survey_form));
                
                $request->session()->forget('student');
                $request->session()->forget('payment');
                $request->session()->forget('ticket');
                
                return redirect('pendaftaran-berjaya/' . $product_id);

            }else{
    
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
    
                $student->save();
                $payment->save();
    
                dispatch(new PengesahanJob($send_mail, $product_name, $package_name, $date_from, $date_to, $time_from, $time_to, $packageId, $payment_id, $productId, $student_id));
                
                $request->session()->forget('student');
                $request->session()->forget('payment');
                $request->session()->forget('ticket');

                return redirect('pendaftaran-berjaya/' . $product_id);

            }

            /*-- End Email -----------------------------------------------------------*/  

        } else {

            $student->save();
            $payment->save();
    
            $request->session()->forget('student');
            $request->session()->forget('payment');
            $request->session()->forget('ticket');

            return redirect('pendaftaran-tidak-berjaya');
        }
        
    }

    public function redirect_payment($product_id, $package_id, Request $request)
    {
        $student = $request->session()->get('student');
        $payment = $request->session()->get('payment');
        $ticket = $request->session()->get('ticket');

        $billplz = Client::make(env('BILLPLZ_API_KEY', '3f78dfad-7997-45e0-8428-9280ba537215'), env('BILLPLZ_X_SIGNATURE', 'S-jtSalzkEawdSZ0Mb0sqmgA'));

        //get the bill
        $bill = $billplz->bill();
        $response = $bill->get($payment->billplz_id);
        $pay_data = $response->toArray();

        //update payment history status to database
        $addData = array(
            'status' => $pay_data['state']
        );

        $payment->fill($addData);
        $request->session()->put('payment', $payment);

        if ($payment->status == 'paid')
        {
            /*-- Manage Email ---------------------------------------------------*/

            $product = Product::where('product_id', $product_id)->first();
            $package = Package::where('package_id', $package_id)->first();

            if($payment->quantity == 1){
    
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
                $ticket_id = $ticket->ticket_id;
                $survey_form = $product->survey_form;
                
                //update participant form to database
                $updateform = array(
                    'update_count' => 1
                );

                $payment->fill($updateform);
                $request->session()->put('payment', $payment);

                $student->save();
                $payment->save();
                $ticket->save();
                
                dispatch(new TiketJob($email, $product_name, $package_name, $date_from, $date_to, $time_from, $time_to, $packageId, $productId, $student_id, $survey_form));
                
                $request->session()->forget('student');
                $request->session()->forget('payment');
                $request->session()->forget('ticket');
                
                return redirect('pendaftaran-berjaya/' . $product_id);

            }else{
    
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
    
                $student->save();
                $payment->save();
    
                dispatch(new PengesahanJob($send_mail, $product_name, $package_name, $date_from, $date_to, $time_from, $time_to, $packageId, $payment_id, $productId, $student_id));
                
                $request->session()->forget('student');
                $request->session()->forget('payment');
                $request->session()->forget('ticket');

                return redirect('pendaftaran-berjaya/' . $product_id);

            }

            /*-- End Email -----------------------------------------------------------*/  

        } else {

            $student->save();
            $payment->save();

            Session::forget('user_invite');
            $request->session()->forget('student');
            $request->session()->forget('payment');
            $request->session()->forget('ticket');

            return redirect('pendaftaran-tidak-berjaya');
        }
        
    }
    
    //Added for to view manual payment
    public function manual_payment($product_id, $package_id, Request $request)
    {
        $tomorrow = Carbon::tomorrow()->format('Y-m-d\TH:i');
        $product = Product::where('product_id',$product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $student = $request->session()->get('student');
        $payment = $request->session()->get('payment');
        $ticket = $request->session()->get('ticket');

        return view('customer_new.manual_method',compact('tomorrow', 'product', 'package', 'student', 'payment'));
    }

    //Added to save manual payment & upload receipt
    public function manual_paymentprocess($product_id, $package_id, Request $request)
    {
        $product = Product::where('product_id',$product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $student = $request->session()->get('student');
        $payment = $request->session()->get('payment');
        $ticket = $request->session()->get('ticket');

        // Start receipt
        $filename = $request->file('receipt_path');
        $extension = $filename->getClientOriginalExtension();
        
        if($extension == 'jpeg' || $extension == 'jpg' || $extension == 'png' || $extension == 'pdf' || $extension == 'JPEG' || $extension == 'JPG' || $extension == 'PNG' || $extension == 'PDF')
        {
            $name = $filename->getClientOriginalName();
            $uniqe = 'RE'. uniqid() . '.' . $extension;
            $dirpath = public_path('assets/receipts/');
            $filename->move($dirpath, $uniqe);
            $receipt_name = 'assets/receipts/'.$uniqe;
        } else {
            return redirect()->back()->with('error','Sila muat naik fail bukti pembayaran dalam JPG, JPEG, PNG, atau PDF.');
        }
        // End receipt

        if($payment->quantity == 1){

            $product_name = $product->name; 
            $package_name = $package->name; 
            $date_from = $product->date_from;
            $date_to = $product->date_to;
            $time_from = $product->time_from;
            $time_to = $product->time_to;
            $packageId = $package_id;
            $productId = $product_id;        
            $student_id = $student->stud_id;
            $ticket_id = $ticket->ticket_id;
            $ticket->pay_method = 'Manual';
            $survey_form = $product->survey_form;
            $payment->pic = $request->pic;
            $payment->pay_datetime = $request->pay_datetime;
            $payment->receipt_path = $receipt_name;
            $payment->status = 'not approve';

            $student->save();
            $payment->save();
            $ticket->save(); 
            $request->session()->forget('student');
            $request->session()->forget('payment');
            $request->session()->forget('ticket');
            
            return redirect('pendaftaran-berjaya/' . $product_id );

        }else{

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
            $payment->pic = $request->pic;
            $payment->pay_datetime = $request->pay_datetime;
            $payment->receipt_path = $receipt_name;
            $payment->status = 'not approve';

            $student->save();
            $payment->save();

            $request->session()->forget('student');
            $request->session()->forget('payment');
            $request->session()->forget('ticket');
            
            return redirect('pendaftaran-berjaya/' . $product_id );
        }
    }

    public function free_payment($product_id, $package_id, Request $request)
    {
        $tomorrow = Carbon::tomorrow()->format('Y-m-d\TH:i');
        $product = Product::where('product_id',$product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $student = $request->session()->get('student');
        $payment = $request->session()->get('payment');
        $ticket = $request->session()->get('ticket');

        return view('customer_new.manual_method',compact('tomorrow', 'product', 'package', 'student', 'payment'));
    }

    //Added to save free payment
    public function free_paymentprocess($product_id, $package_id, Request $request)
    {
        $product = Product::where('product_id',$product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $ticket = Ticket::where('package_id', $package_id)->first();
        $student = $request->session()->get('student');
        $payment = $request->session()->get('payment');
        $ticket = $request->session()->get('ticket');

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
            $ticket_id = $ticket->ticket_id;

            dispatch(new TiketJob($email, $product_name, $package_name, $date_from, $date_to, $time_from, $time_to, $packageId, $productId, $student_id, $survey_form, $ticket_id));
            
            $payment->status = 'paid';
            $updateform = array(
                'update_count' => 1
            );

            $student->save();
            $payment->save();
            $ticket->save(); 


            $request->session()->forget('student');
            $request->session()->forget('payment');
            // $request->session()->forget('ticket');
            
            // return redirect('next_details/' . $ticket_id );

        
        return redirect('next-details/' . $ticket_id );
    }
        
    //Added to save free payment
    public function paid_paymentprocess($product_id, $package_id, Request $request)
    {
        $product = Product::where('product_id',$product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $ticket = Ticket::where('package_id', $package_id)->first();

        $student = $request->session()->get('student');
        $payment = $request->session()->get('payment');
        $ticket = $request->session()->get('ticket');

        $billplz = Client::make(env('BILLPLZ_API_KEY', '3f78dfad-7997-45e0-8428-9280ba537215'), env('BILLPLZ_X_SIGNATURE', 'S-jtSalzkEawdSZ0Mb0sqmgA'));

        //get the bill
        $bill = $billplz->bill();
        $response = $bill->get($payment->billplz_id);
        $pay_data = $response->toArray();

        //update payment history status to database
        $addData = array(
            'status' => $pay_data['state']
        );

        $payment->fill($addData);
        $request->session()->put('payment', $payment);

        if ($payment->status == 'paid')
        {

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
            $ticket_id = $ticket->ticket_id;

            dispatch(new TiketJob($email, $product_name, $package_name, $date_from, $date_to, $time_from, $time_to, $packageId, $productId, $student_id,  $survey_form, $ticket_id));

            // $payment->status = 'not paid';
            $updateform = array(
                'update_count' => 1
            );

            $student->save();
            $payment->save();
            $ticket->save(); 


            if ($product->offer_id == 'OFF005'){
                $request->session()->forget('student');
                $request->session()->forget('payment');
            }
            elseif ($product->offer_id == 'OFF006'){
            }
            else{
                $request->session()->forget('student');
                $request->session()->forget('payment');
            }
        } else {

            $student->save();
            $payment->save();

            Session::forget('user_invite');
            $request->session()->forget('student');
            $request->session()->forget('payment');
            $request->session()->forget('ticket');

            return redirect('pendaftaran-tidak-berjaya');
        }
            // $request->session()->forget('ticket');
        
        return redirect('next-details/' . $ticket_id );
    }
}
