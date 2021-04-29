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
    public function choose_package($product_id, $package_id, $stud_id, Request $request){

        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('product_id', $product_id)->get();
        $current_package = Package::where('package_id', $package_id)->first();
        $student = Student::where('stud_id', $stud_id)->first();
        $feature = Feature::orderBy('id','asc')->get();

        // dd($student);
        return view('upgrade.choose_package', compact('product', 'package', 'current_package', 'student', 'feature'));
    }

    public function details_upgrade($product_id, $package_id, $stud_id, Request $request){

        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('product_id', $product_id)->first();
        $current_package = Package::where('package_id', $package_id)->first();
        $student = Student::where('stud_id', $stud_id)->first();
        $feature = Feature::orderBy('id','asc')->get();
        $payment = Payment::where('stud_id', $stud_id)->first();

        // dd($student);
        return view('upgrade.details_upgrade', compact('product', 'package', 'current_package', 'student', 'feature', 'payment'));
    }

    public function pay_upgrade($product_id, $package_id, $stud_id, Request $request){

        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('product_id', $product_id)->first();
        $current_package = Package::where('package_id', $package_id)->first();
        $student = Student::where('stud_id', $stud_id)->first();
        $feature = Feature::orderBy('id','asc')->get();
        $payment = Payment::where('stud_id', $stud_id)->first();

        // dd($student);
        return view('upgrade.pay_upgrade', compact('product', 'package', 'current_package', 'student', 'feature', 'payment'));
    }

    public function card_method($product_id, $package_id, $stud_id, Request $request){

        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('product_id', $product_id)->first();
        $current_package = Package::where('package_id', $package_id)->first();
        $student = Student::where('stud_id', $stud_id)->first();
        $feature = Feature::orderBy('id','asc')->get();
        $payment = Payment::where('stud_id', $stud_id)->first();

        // dd($student);
        return view('upgrade.pay_upgrade', compact('product', 'package', 'current_package', 'student', 'feature', 'payment'));
    }
}
