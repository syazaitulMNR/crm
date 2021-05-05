<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Student;

class CertController extends Controller
{
    /*-- Check IC Page -----------------------------------------------*/
    public function ic_check($product_id)
    {
        // $package = Package::where('package_id', $package_id)->first();
        $product = Product::where('product_id', $product_id)->first();

        return view('certificate.get_ic', compact('product'));
    }

    public function checking_ic($product_id, Request $request)
    {
        // Check if ic exist
        if(Student::where('ic', $request->ic)->exists()){
            
            $student = Student::where('ic', $request->ic)->first();
            return redirect('butiran-peserta/' . $product_id . '/'.$student->stud_id);

        }else{

            return view('certificate.not_found');

        }
    }

    public function show_info($product_id, $stud_id, Request $request)
    {
        $product = Product::where('product_id',$product_id)->first();
        $student = Student::where('stud_id', $stud_id)->first();

        return view('certificate.show_info');
    }

    public function payment_method($product_id, $stud_id, Request $request)
    {
        $product = Product::where('product_id',$product_id)->first();
        $student = Student::where('stud_id', $stud_id)->first();

        $payment = $request->session()->get('payment');
        
        $payment_id = 'OD'.uniqid();
        $stripe = 'Debit/Credit Card';
        $billplz = 'FPX';

        return view('certificate.method_pay', compact('product', 'student', 'payment', 'payment_id', 'stripe', 'billplz'));
    }

    public function store_method($product_id, $stud_id, Request $request)
    {
        // echo 'bayo laa apa lagi';
        $validatedData = $request->validate([
            'payment_id' => 'required',
            'pay_price'=> 'required|numeric',
            'quantity' => 'required|numeric',
            'totalprice'=> 'required|numeric',
            'product_type' => 'required',
            'stud_id' => 'required',
            'cert_id' => 'required'
        ]);

        $request->session()->get('payment');
        $payment = new Payment();
        $payment->fill($validatedData);
        $request->session()->put('payment', $payment);


    }
}
