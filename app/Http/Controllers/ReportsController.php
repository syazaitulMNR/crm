<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Product;
use App\Package;
use App\Payment;
use App\Exports\ProgramExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportsController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ReportsController
    |--------------------------------------------------------------------------
    |   This controller is for managing the sales report
    | 
    */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function trackcustomer()
    {
        $student = Student::orderBy('id','desc')->paginate(15);
        $product = Product::orderBy('id', 'desc')->get();
         
        $totalcust = Student::count();
        $totalpay = Payment::count();

        return view('admin.reports.trackcustomer', compact('student','product','totalcust','totalpay'));
    }

    public function trackprogram()
    {
        $student = Student::orderBy('id','desc')->get();
        $product = Product::orderBy('id','asc')->paginate(15);
        $package = Package::orderBy('id','asc')->get();
        $payment = Payment::orderBy('id','asc')->get(); 

        $totalcust = Student::count();
        $totalpay = Payment::count();
        
        return view('admin.reports.trackprogram', compact('student','product','package', 'payment', 'totalcust','totalpay'));
    }

    public function trackpackage($product_id)
    {
        $payment = Payment::where('product_id', $product_id)->get();
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('product_id', $product_id)->get();
        $student = Student::orderBy('id','desc')->paginate(15);

        $counter = Student::count();
        $totalsuccess = Payment::where('status','succeeded')->where('product_id', $product_id)->count();
        $totalcancel = Payment::where('status','cancelled')->where('product_id', $product_id)->count();
        // $count_package = Payment::where('product_id', $product_id)->count();
        
        // dd($student);
        return view('admin.reports.trackpackage', compact('product', 'package', 'payment', 'student', 'counter', 'totalsuccess', 'totalcancel'));
    }

    public function viewbypackage($product_id, $package_id)
    {
        $payment = Payment::where('product_id', $product_id)->where('package_id', $package_id)->paginate(15);
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();

        $total = Payment::where('product_id', $product_id)->where('package_id', $package_id)->count();
        $totalsuccess = Payment::where('status','succeeded')->where('product_id', $product_id)->where('package_id', $package_id)->count();
        $totalcancel = Payment::where('status','cancelled')->where('product_id', $product_id)->where('package_id', $package_id)->count();
        
        return view('admin.reports.viewbypackage', compact('product', 'package', 'payment', 'total', 'totalsuccess', 'totalcancel'));
    }

    public function trackpayment($product_id, $package_id, $payment_id, $student_id)
    {
        $paginate = Payment::where('product_id', $product_id)->paginate(15);
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $payment = Payment::where('payment_id', $payment_id)->first();
        $student = Student::where('stud_id', $student_id)->first();

        $counter = Student::count();
        
        // dd($payment);
        return view('admin.reports.trackpayment', compact('paginate', 'product', 'package', 'payment', 'student', 'counter'));
    }

    public function updatepayment($product_id, $package_id, $payment_id, $student_id, Request $request)
    {
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $payment = Payment::where('payment_id', $payment_id)->first();
        $student = Student::where('stud_id', $student_id)->first();

        $payment->status = $request->status;
        $payment->save();

        // dd($request->status);
        return redirect('viewpayment/'.$product_id.'/'.$package_id.'/'.$payment_id.'/'.$student_id)->with('updatesuccess','Payment Status Successfully Updated!');
    }

    public function exportProgram($product_id)
    {
        $payment = Payment::where('product_id', $product_id)->get();
        // $product = Product::where('product_id', $product_id)->first();
        // $package = Package::where('product_id', $product_id)->get();
        // $student = Student::orderBy('id','desc')->get();

        // dd($product);
        return Excel::download(new ProgramExport($payment), 'Students.xlsx');
        // return Excel::download(new ProgramExport, 'Students.xlsx');
    }
}
