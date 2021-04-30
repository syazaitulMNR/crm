<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Package;
use App\Student;
use App\Payment;
use App\Feature;

class UpgradeController extends Controller
{
    public function choose_package($product_id, $package_id, $stud_id, $payment_id, Request $request){

        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('product_id', $product_id)->get();
        $current_package = Package::where('package_id', $package_id)->first();
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
            $new_package = new Payment();
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
            'quantity' => 'required|numeric',
            'totalprice'=> 'required|numeric'
        ]);

        $new_package = $request->session()->get('payment');
        $new_package->fill($validatedData);
        $request->session()->put('payment', $new_package);

        // dd($new_package);
        return redirect('pay-upgrade/'.  $product_id . '/' . $package_id . '/' . $stud_id . '/' . $payment_id);
    }

    public function pay_upgrade($product_id, $package_id, $stud_id, $payment_id, Request $request){

        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('product_id', $product_id)->first();
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
        $package = Package::where('product_id', $product_id)->first();
        $current_package = Package::where('package_id', $package_id)->first();
        $student = Student::where('stud_id', $stud_id)->first();
        $payment = Payment::where('payment_id', $payment_id)->first();

        $new_package = $request->session()->get('payment');
  
        dd($new_package);
        //Check if form has been key in
        // if($new_package->pay_method == 'Debit/Credit Card'){

        //     return redirect('card-method/'.  $product_id . '/' . $package_id . '/' . $stud_id . '/' . $payment_id );

        // }else if($new_package->pay_method == 'FPX'){

        //     return redirect('data-billplz/'.  $product_id . '/' . $package_id . '/' . $stud_id . '/' . $payment_id );

        // }else{
        //     echo 'Error 404';
        // }
    }

    public function card_method($product_id, $package_id, $stud_id, Request $request){

        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('product_id', $product_id)->first();
        $current_package = Package::where('package_id', $package_id)->first();
        $student = Student::where('stud_id', $stud_id)->first();
        $payment = Payment::where('payment_id', $payment_id)->first();

        $new_package = $request->session()->get('payment');

        dd($new_package);
        // return view('upgrade.use_card', compact('product', 'package', 'current_package', 'student', 'payment', 'new_package'));
    }
}
