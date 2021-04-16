<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Mail\InvoiceSendEmail;
use App\Jobs\InvoiceEmail;
use App\Product;
use App\Package;
use App\Payment;
use App\Student;
use Carbon\Carbon;
use Stripe;
use Mail;
use PDF;

class ExistStudentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ExistStudentController
    |--------------------------------------------------------------------------
    |   This controller is for managing exist student data
    | 
    */
    
    public function existedstudent($product_id, $package_id, $stud_id){

        $student = Student::where('stud_id', $stud_id)->first();
        $product = Product::where('product_id',$product_id)->first();
        $package = Package::where('package_id', $package_id)->first();

        return view('customer/student', compact('student','product', 'package'));

    }

    public function updatestd($product_id, $package_id, $stud_id, Request $request){
        $student = Student::where('stud_id', $stud_id)->first();
        $payment = Payment::orderBy('id','Desc')->first();

        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->ic = $request->ic;
        $student->email = $request->email;
        $student->phoneno = $request->phoneno;
        $student->save();

        
        /*-- Stripe ---------------------------------------------------------*/
        // Make Payment
        $stripe = Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY','sk_test_3hkk4U4iBvTAO5Y5yV9YisD600VdfR6nrR'));

        // Generate token
        try {
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
            
            }else{

                // Create a Customer:
                $customer = \Stripe\Customer::create([

                    'name' => "Mohammad Danial",
                    'source' => $token['id'],
                    'email' => "danialhensem@gmail.com",
                ]);

                // Make a Payment
                Stripe\Charge::create([
                    // "amount" => number_format($course->sales_price - ($course->sales_price * 10/100), 2) * 100,
                    "currency" => "myr",
                    "description" => "Membership Platinum",
                    'customer' => $customer->id,
                    "amount" => $request->jumlah * 100,
                ]);
            }

            // Manage Payment 
            $auto_inc_payment = $payment->id + 1;
            $paymentId = 'OD' . 0 . 0 . $auto_inc_payment;

            Payment::create(array(

                'payment_id'=> $paymentId,
                'quantity' => $request->quantity,
                'status' => 'success',
                'totalprice'=> $request->item_total,
                'pay_method' => $request->pay_method,
                'stud_id'=> $stud_id,
                'product_id' => $product_id,
                'package_id' => $package_id,
                'stripe_id' => $customer->id

            ));

        } catch (\Exception $ex) {
            return redirect()->back()->with('error', 'Stripe');
        }
        /*-- End Stripe -----------------------------------------------------*/

        /*-- Manage Email ---------------------------------------------------*/
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        
        $to_name = 'noreply@momentuminternet.com';
        $to_email = $request->email; 
        
        $data['name']=$request->first_name;
        $data['ic']=$request->ic;
        $data['email']=$request->email;
        $data['phoneno']=$request->phoneno;
        $data['total']=$request->item_total;
        $data['quantity']=$request->quantity;

        $data['product']=$product->name;
        $data['package_id']=$package->package_id;
        $data['package']=$package->name;
        $data['price']=$package->price;

        $data['date_receive']=date('d-m-Y');
        $data['payment_id']=$paymentId;
        $data['product_id']=$product->product_id;        
        $data['student_id']=$stud_id;
        
        // $invoice = PDF::loadView('emails.invoice', $data);
        // $receipt = PDF::loadView('emails.receipt', $data);

        // $emailJob = (new InvoiceEmail($name, $ic, $email, $phoneno, $total, $quantity, $package_id, $package, $price, $date_receive, $payment_id, $product_id, $student_id))->delay(Carbon::now()->addSeconds(3));
        // dispatch($emailJob);

        // Mail::send('emails.mail', $data, function($message) use ($to_name, $to_email, $invoice, $receipt) 
        Mail::send('emails.mail', $data, function($message) use ($to_name, $to_email)
        {
            $message->to($to_email, $to_name)->subject('Pengesahan Pembelian');
            $message->from('noreply@momentuminternet.my','noreply');
            // $message->attachData($invoice->output(), "Invoice.pdf");
            // $message->attachData($receipt->output(), "Receipt.pdf");

        });
        
        return redirect('thankyoupage/'.  $product_id . '/' . $package_id . '/' . $stud_id . '/' . $paymentId);
        //dd($package_id);
    }

}
