<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Package;
use App\Student;
use App\Payment;
use App\Feature;
use Stripe;
use Billplz\Client;
use App\Jobs\UpgradeJob;

class UpgradeController extends Controller
{
    public function upgrade_ticket($product_id, $package_id, $stud_id, $payment_id, Request $request){

        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('product_id', $product_id)->get(); //Show all package
        $current_package = Package::where('package_id', $package_id)->first(); //Package registered
        $student = Student::where('stud_id', $stud_id)->first();
        $feature = Feature::orderBy('id','asc')->get();
        $payment = Payment::where('payment_id', $payment_id)->first();

        $new_package = $request->session()->get('payment');

        return view('upgrade_ticket.choose_package', compact('product', 'package', 'current_package', 'student', 'feature', 'payment', 'new_package'));
    }

    public function store_package($product_id, $package_id, $stud_id, $payment_id, Request $request){
        $validatedData = $request->validate([
            'product_id' => 'required',
            'package_id' => 'required'
        ]);

        if(empty($request->session()->get('payment'))){
            $new_package = Payment::where('payment_id', $payment_id)->where('product_id', $product_id)->where('package_id', $package_id)->where('stud_id', $stud_id)->first(); //Upgrade new package payment
            $new_package->fill($validatedData);
            $request->session()->put('payment', $new_package);
        }else{
            $new_package = $request->session()->get('payment');
            $new_package->fill($validatedData);
            $request->session()->put('payment', $new_package);
        }

        return redirect('ticket-details/'.  $product_id . '/' . $package_id . '/' . $stud_id . '/' . $payment_id);
    }

    public function ticket_details($product_id, $package_id, $stud_id, $payment_id, Request $request){

        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('product_id', $product_id)->get();
        $current_package = Package::where('package_id', $package_id)->first();
        $student = Student::where('stud_id', $stud_id)->first();
        $payment = Payment::where('payment_id', $payment_id)->first();

        $new_package = $request->session()->get('payment');

        // dd($new_package);
        return view('upgrade_ticket.details', compact('product', 'package', 'current_package', 'student', 'payment', 'new_package'));
    }

    public function store_details($product_id, $package_id, $stud_id, $payment_id, Request $request){
        $validatedData = $request->validate([
            'pay_price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'totalprice'=> 'required|numeric'
        ]);

        $new_package = $request->session()->get('payment');
        $new_package->fill($validatedData);
        $request->session()->put('payment', $new_package);

        // dd($new_package->pay_price);
        return redirect('upgrade-payment/'.  $product_id . '/' . $package_id . '/' . $stud_id . '/' . $payment_id);
    }

    public function upgrade_payment($product_id, $package_id, $stud_id, $payment_id, Request $request){

        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $current_package = Package::where('package_id', $package_id)->first();
        $student = Student::where('stud_id', $stud_id)->first();
        $payment = Payment::where('payment_id', $payment_id)->first();

        $new_package = $request->session()->get('payment');
        $stripe = 'Debit/Credit Card';
        $billplz = 'FPX';
        // dd($new_package);
        return view('upgrade_ticket.payment', compact('product', 'package', 'current_package', 'student', 'payment', 'new_package', 'stripe', 'billplz'));
    }

    public function store_payment($product_id, $package_id, $stud_id, $payment_id, Request $request){
        $validatedData = $request->validate([
            'pay_method' => 'required',
        ]);

        $new_package = $request->session()->get('payment');
        $new_package->fill($validatedData);
        $request->session()->put('payment', $new_package);

        // dd($new_package);
        return redirect('payment-option/'.  $product_id . '/' . $package_id . '/' . $stud_id . '/' . $payment_id);
    }

    public function payment_option($product_id, $package_id, $stud_id, $payment_id, Request $request)
    {
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $current_package = Package::where('package_id', $package_id)->first();
        $student = Student::where('stud_id', $stud_id)->first();
        $payment = Payment::where('payment_id', $payment_id)->first();

        $new_package = $request->session()->get('payment');
  
        // dd($new_package);
        //Check the payment method
        if($new_package->pay_method == 'Debit/Credit Card'){

            return redirect('card-option/'.  $product_id . '/' . $package_id . '/' . $stud_id . '/' . $payment_id );

        }else if($new_package->pay_method == 'FPX'){

            return redirect('billplz-option/'.  $product_id . '/' . $package_id . '/' . $stud_id . '/' . $payment_id );

        }else{

            abort(404);

        }
    }

    public function card_option($product_id, $package_id, $stud_id, $payment_id, Request $request){

        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $current_package = Package::where('package_id', $package_id)->first();
        $student = Student::where('stud_id', $stud_id)->first();
        $payment = Payment::where('payment_id', $payment_id)->first();

        $new_package = $request->session()->get('payment');

        // dd($new_package);
        return view('upgrade_ticket.use_card', compact('product', 'package', 'current_package', 'student', 'payment', 'new_package'));
    }

    public function store_stripe($product_id, $package_id, $stud_id, $payment_id, Request $request)
    {        
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $current_package = Package::where('package_id', $package_id)->first();
        $student = Student::where('stud_id', $stud_id)->first();
        $payment = Payment::where('payment_id', $payment_id)->first();

        $new_package = $request->session()->get('payment');

        /*-- Stripe ---------------------------------------------------------*/
        //Make Payment
        $stripe = Stripe\Stripe::setApiKey('sk_test_3hkk4U4iBvTAO5Y5yV9YisD600VdfR6nrR');

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
                    "amount" => $new_package->totalprice * 100,
                ]);
            }

            $addData = array(
                'status' => 'paid',
                'upgrade_count' => '1',
                'stripe_id' => $customer->id
            );

            $new_package->fill($addData);
            $request->session()->put('payment', $new_package);

        } catch (\Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
        /*-- End Stripe -----------------------------------------------------*/

        /*-- Manage Email ---------------------------------------------------*/
                
        $send_mail = $student->email;
        $product_name = $product->name;    
        $date_from = $product->date_from;
        $date_to = $product->date_to;
        $time_from = $product->time_from;
        $time_to = $product->time_to;
        $packageId = $new_package->package_id;
        $payment_id = $payment->payment_id;
        $productId = $product_id;        
        $student_id = $student->stud_id;

        $new_package->save();

        dispatch(new UpgradeJob($send_mail, $product_name, $date_from, $date_to, $time_from, $time_to, $packageId, $payment_id, $productId, $student_id));
        
        /*-- End Email -----------------------------------------------------------*/
  
        $request->session()->forget('package');
        $request->session()->forget('payment');
        
        return redirect('naik-taraf-berjaya');
    }

    public function billplz_option($product_id, $package_id, $stud_id, $payment_id, Request $request)
    {        
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $current_package = Package::where('package_id', $package_id)->first();
        $student = Student::where('stud_id', $stud_id)->first();
        $payment = Payment::where('payment_id', $payment_id)->first();

        $new_package = $request->session()->get('payment');

        $billplz = Client::make(env('BILLPLZ_API_KEY', '3f78dfad-7997-45e0-8428-9280ba537215'), env('BILLPLZ_X_SIGNATURE', 'S-jtSalzkEawdSZ0Mb0sqmgA'));

        $bill = $billplz->bill();

        $response = $bill->create(
            'dlzmocfv',
            $student->email,
            $student->phoneno,
            $student->first_name,
            \Duit\MYR::given($new_package->totalprice * 100),
            'https://mims.momentuminternet.my/redirect-page/'.  $product_id . '/' . $package_id . '/' . $stud_id . '/' . $payment_id,
            $product->name . ' - ' . $package->name,
            ['redirect_url' => 'https://mims.momentuminternet.my/redirect-page/'.  $product_id . '/' . $package_id . '/' . $stud_id . '/' . $payment_id]
        );

        $pay_data = $response->toArray();
        
        $addData = array(
            'upgrade_count' => '1',
            'billplz_id' => $pay_data['id']
        );

        $new_package->fill($addData);
        $request->session()->put('payment', $new_package);

        // dd($pay_data);
        return redirect($pay_data['url']);
    }

    public function redirect_page($product_id, $package_id, $stud_id, $payment_id,Request $request)
    {
        $new_package = $request->session()->get('payment');

        $billplz = Client::make(env('BILLPLZ_API_KEY', '3f78dfad-7997-45e0-8428-9280ba537215'), env('BILLPLZ_X_SIGNATURE', 'S-jtSalzkEawdSZ0Mb0sqmgA'));

        $bill = $billplz->bill();
        $response = $bill->get($new_package->billplz_id);

        $pay_data = $response->toArray();

        $addData = array(
            'status' => $pay_data['state']
        );

        $new_package->fill($addData);
        $request->session()->put('payment', $new_package);

        if ($new_package->status == 'paid')
        {
            /*-- Manage Email ---------------------------------------------------*/

            $product = Product::where('product_id', $product_id)->first();
            $package = Package::where('package_id', $package_id)->first();
            $student = Student::where('stud_id', $stud_id)->first();

            $send_mail = $student->email;
            $product_name = $product->name;        
            $date_from = $product->date_from;
            $date_to = $product->date_to;
            $time_from = $product->time_from;
            $time_to = $product->time_to;
            $packageId = $package_id;
            $payment_id = $payment_id;
            $productId = $product_id;        
            $student_id = $student->stud_id;

            $new_package->save();

            dispatch(new UpgradeJob($send_mail, $product_name, $date_from, $date_to, $time_from, $time_to, $packageId, $payment_id, $productId, $stud_id));
            
            /*-- End Email -----------------------------------------------------------*/
    
            $request->session()->forget('student');
            $request->session()->forget('payment');

            return redirect('naik-taraf-berjaya');  

        } else {

            $new_package->save();
    
            $request->session()->forget('student');
            $request->session()->forget('payment');

            return redirect('pendaftaran-tidak-berjaya');
            
        }
        
    }



    //--------------------------------------------------------------------------------------------------------------------------//
    //--------------------------------------------------- Upgrade by payment ---------------------------------------------------//
    //--------------------------------------------------------------------------------------------------------------------------//

    public function choose_package($product_id, $package_id, $stud_id, $payment_id, Request $request){

        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('product_id', $product_id)->get(); //Show all package
        $current_package = Package::where('package_id', $package_id)->first(); //Package registered
        $student = Student::where('stud_id', $stud_id)->first();
        $feature = Feature::orderBy('id','asc')->get();
        $payment = Payment::where('payment_id', $payment_id)->first();

        $new_package = $request->session()->get('payment');

        return view('upgrade.choose_package', compact('product', 'package', 'current_package', 'student', 'feature', 'payment', 'new_package'));
    }

    public function save_package($product_id, $package_id, $stud_id, $payment_id, Request $request){
        $validatedData = $request->validate([
            'product_id' => 'required',
            'package_id' => 'required'
        ]);

        if(empty($request->session()->get('payment'))){
            $new_package = Payment::where('payment_id', $payment_id)->where('product_id', $product_id)->where('package_id', $package_id)->where('stud_id', $stud_id)->first(); //Upgrade new package payment
            $new_package->fill($validatedData);
            $request->session()->put('payment', $new_package);
        }else{
            $new_package = $request->session()->get('payment');
            $new_package->fill($validatedData);
            $request->session()->put('payment', $new_package);
        }

        return redirect('upgrade-details/'.  $product_id . '/' . $package_id . '/' . $stud_id . '/' . $payment_id);
    }

    public function details_upgrade($product_id, $package_id, $stud_id, $payment_id, Request $request){

        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('product_id', $product_id)->get();
        $current_package = Package::where('package_id', $package_id)->first();
        $student = Student::where('stud_id', $stud_id)->first();
        $payment = Payment::where('payment_id', $payment_id)->first();

        $new_package = $request->session()->get('payment');

        // dd($new_package);
        return view('upgrade.details_upgrade', compact('product', 'package', 'current_package', 'student', 'payment', 'new_package'));
    }

    public function save_details($product_id, $package_id, $stud_id, $payment_id, Request $request){
        $validatedData = $request->validate([
            'pay_price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'totalprice'=> 'required|numeric'
        ]);

        $new_package = $request->session()->get('payment');
        $new_package->fill($validatedData);
        $request->session()->put('payment', $new_package);

        // dd($new_package->pay_price);
        return redirect('pay-upgrade/'.  $product_id . '/' . $package_id . '/' . $stud_id . '/' . $payment_id);
    }

    public function pay_upgrade($product_id, $package_id, $stud_id, $payment_id, Request $request){

        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $current_package = Package::where('package_id', $package_id)->first();
        $student = Student::where('stud_id', $stud_id)->first();
        $payment = Payment::where('payment_id', $payment_id)->first();

        $new_package = $request->session()->get('payment');
        $stripe = 'Debit/Credit Card';
        $billplz = 'FPX';
        // dd($new_package);
        return view('upgrade.pay_upgrade', compact('product', 'package', 'current_package', 'student', 'payment', 'new_package', 'stripe', 'billplz'));
    }

    public function save_payment($product_id, $package_id, $stud_id, $payment_id, Request $request){
        $validatedData = $request->validate([
            'pay_method' => 'required',
        ]);

        $new_package = $request->session()->get('payment');
        $new_package->fill($validatedData);
        $request->session()->put('payment', $new_package);

        // dd($new_package);
        return redirect('choose-method/'.  $product_id . '/' . $package_id . '/' . $stud_id . '/' . $payment_id);
    }

    public function choose_method($product_id, $package_id, $stud_id, $payment_id, Request $request)
    {
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $current_package = Package::where('package_id', $package_id)->first();
        $student = Student::where('stud_id', $stud_id)->first();
        $payment = Payment::where('payment_id', $payment_id)->first();

        $new_package = $request->session()->get('payment');
  
        // dd($new_package);
        //Check the payment method
        if($new_package->pay_method == 'Debit/Credit Card'){

            return redirect('card-method/'.  $product_id . '/' . $package_id . '/' . $stud_id . '/' . $payment_id );

        }else if($new_package->pay_method == 'FPX'){

            return redirect('pay-billplz/'.  $product_id . '/' . $package_id . '/' . $stud_id . '/' . $payment_id );

        }else{
            echo 'Error 404';
        }
    }

    public function card_method($product_id, $package_id, $stud_id, $payment_id, Request $request){

        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $current_package = Package::where('package_id', $package_id)->first();
        $student = Student::where('stud_id', $stud_id)->first();
        $payment = Payment::where('payment_id', $payment_id)->first();

        $new_package = $request->session()->get('payment');

        // dd($new_package);
        return view('upgrade.use_card', compact('product', 'package', 'current_package', 'student', 'payment', 'new_package'));
    }

    public function save_stripe($product_id, $package_id, $stud_id, $payment_id, Request $request)
    {        
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $current_package = Package::where('package_id', $package_id)->first();
        $student = Student::where('stud_id', $stud_id)->first();
        $payment = Payment::where('payment_id', $payment_id)->first();

        $new_package = $request->session()->get('payment');

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
                    "amount" => $new_package->totalprice * 100,
                ]);
            }

            $addData = array(
                'status' => 'paid',
                'upgrade_count' => '1',
                'stripe_id' => $customer->id
            );

            $new_package->fill($addData);
            $request->session()->put('payment', $new_package);

        } catch (\Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
        /*-- End Stripe -----------------------------------------------------*/

        /*-- Manage Email ---------------------------------------------------*/
                
        $send_mail = $student->email;
        $product_name = $product->name;    
        $date_from = $product->date_from;
        $date_to = $product->date_to;
        $time_from = $product->time_from;
        $time_to = $product->time_to;
        $packageId = $new_package->package_id;
        $payment_id = $payment->payment_id;
        $productId = $product_id;        
        $student_id = $student->stud_id;

        $new_package->save();

        dispatch(new UpgradeJob($send_mail, $product_name, $date_from, $date_to, $time_from, $time_to, $packageId, $payment_id, $productId, $student_id));
        
        /*-- End Email -----------------------------------------------------------*/
  
        $request->session()->forget('package');
        $request->session()->forget('payment');
        
        return redirect('naik-taraf-berjaya');
    }

    public function billplz_pay($product_id, $package_id, $stud_id, $payment_id, Request $request)
    {        
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $current_package = Package::where('package_id', $package_id)->first();
        $student = Student::where('stud_id', $stud_id)->first();
        $payment = Payment::where('payment_id', $payment_id)->first();

        $new_package = $request->session()->get('payment');

        $billplz = Client::make(env('BILLPLZ_API_KEY', '3f78dfad-7997-45e0-8428-9280ba537215'), env('BILLPLZ_X_SIGNATURE', 'S-jtSalzkEawdSZ0Mb0sqmgA'));

        $bill = $billplz->bill();

        $response = $bill->create(
            'dlzmocfv',
            $student->email,
            $student->phoneno,
            $student->first_name,
            \Duit\MYR::given($new_package->totalprice * 100),
            'https://mims.momentuminternet.my/redirect-pay/'.  $product_id . '/' . $package_id . '/' . $stud_id . '/' . $payment_id,
            $product->name . ' - ' . $package->name,
            ['redirect_url' => 'https://mims.momentuminternet.my/redirect-pay/'.  $product_id . '/' . $package_id . '/' . $stud_id . '/' . $payment_id]
        );

        $pay_data = $response->toArray();
        
        $addData = array(
            'upgrade_count' => '1',
            'billplz_id' => $pay_data['id']
        );

        $new_package->fill($addData);
        $request->session()->put('payment', $new_package);

        // dd($pay_data);
        return redirect($pay_data['url']);
    }

    public function redirect_pay($product_id, $package_id, $stud_id, $payment_id,Request $request)
    {
        $new_package = $request->session()->get('payment');

        $billplz = Client::make(env('BILLPLZ_API_KEY', '3f78dfad-7997-45e0-8428-9280ba537215'), env('BILLPLZ_X_SIGNATURE', 'S-jtSalzkEawdSZ0Mb0sqmgA'));

        $bill = $billplz->bill();
        $response = $bill->get($new_package->billplz_id);

        $pay_data = $response->toArray();

        $addData = array(
            'status' => $pay_data['state']
        );

        $new_package->fill($addData);
        $request->session()->put('payment', $new_package);

        if ($new_package->status == 'paid')
        {
            /*-- Manage Email ---------------------------------------------------*/

            $product = Product::where('product_id', $product_id)->first();
            $package = Package::where('package_id', $package_id)->first();
            $student = Student::where('stud_id', $stud_id)->first();

            $send_mail = $student->email;
            $product_name = $product->name;        
            $date_from = $product->date_from;
            $date_to = $product->date_to;
            $time_from = $product->time_from;
            $time_to = $product->time_to;
            $packageId = $package_id;
            $payment_id = $payment_id;
            $productId = $product_id;        
            $student_id = $student->stud_id;

            $new_package->save();

            dispatch(new UpgradeJob($send_mail, $product_name, $date_from, $date_to, $time_from, $time_to, $packageId, $payment_id, $productId, $stud_id));
            
            /*-- End Email -----------------------------------------------------------*/
    
            $request->session()->forget('student');
            $request->session()->forget('payment');

            return redirect('naik-taraf-berjaya');  

        } else {

            $new_package->save();
    
            $request->session()->forget('student');
            $request->session()->forget('payment');

            return redirect('pendaftaran-tidak-berjaya');
            
        }
        
    }

    public function success_upgrade()
    {
        return view('upgrade.thankyou_upgrade');
    }
}
