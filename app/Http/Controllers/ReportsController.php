<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Product;
use App\Package;
use App\Payment;
use App\Ticket;
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

    // public function trackcustomer()
    // {
    //     $student = Student::orderBy('id','desc')->paginate(15);
    //     $product = Product::orderBy('id', 'desc')->get();
         
    //     $totalcust = Student::count();
    //     $totalpay = Payment::count();

    //     return view('admin.reports.trackcustomer', compact('student','product','totalcust','totalpay'));
    // }

    public function trackprogram(Request $request)
    {
        // $q = $request->search;
        // $product = Product::where('name', 'LIKE', '%' . $q . '%')
        // ->orWhere('product_id', 'LIKE', '%' . $q . '%')
        // ->paginate(15);
        // $product->appends(['search' => $q]);

        $student = Student::orderBy('id','desc')->get();
        $product = Product::orderBy('id','desc')->paginate(15);
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
        $package = Package::where('product_id', $product_id)->paginate(15);
        $student = Student::orderBy('id','desc')->paginate(15);

        $counter = Student::count();
        $totalsuccess = Payment::where('status','paid')->where('product_id', $product_id)->count();
        $totalcancel = Payment::where('status','due')->where('product_id', $product_id)->count();
        $paidticket = Ticket::where('ticket_type', 'paid')->where('product_id', $product_id)->count();
        $freeticket = Ticket::where('ticket_type', 'free')->where('product_id', $product_id)->count();
        // $count_package = Payment::where('product_id', $product_id)->count();
        
        // dd($student);
        return view('admin.reports.trackpackage', compact('product', 'package', 'payment', 'student', 'counter', 'totalsuccess', 'totalcancel', 'paidticket', 'freeticket'));
    }

    public function viewbypackage($product_id, $package_id)
    {
        $payment = Payment::where('product_id', $product_id)->where('package_id', $package_id)->get();
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $ticket = Ticket::where('product_id', $product_id)->where('package_id', $package_id)->paginate(15);
        $student = Student::orderBy('id', 'desc')->get();

        $total = Payment::where('product_id', $product_id)->where('package_id', $package_id)->count();
        $totalsuccess = Payment::where('status','paid')->where('product_id', $product_id)->where('package_id', $package_id)->count();
        $totalcancel = Payment::where('status','due')->where('product_id', $product_id)->where('package_id', $package_id)->count();
        
        return view('admin.reports.viewbypackage', compact('product', 'package', 'payment', 'ticket', 'student', 'total', 'totalsuccess', 'totalcancel'));
    }

    public function save_customer($product_id, $package_id, Request $request)
    { 
        $stud_id = 'MI'.uniqid();
        
        Student::create(array(
            'stud_id'=> $stud_id,
            'first_name'=> $request->first_name,
            'last_name'=> $request->last_name,
            'ic' => $request->ic,
            'phoneno' => $request->phoneno,
            'email' => $request->email
        ));

        $payment_id = 'OD'.uniqid();

        Payment::create(array(
            'payment_id'=> $payment_id,
            'pay_price'=> $request->pay_price,
            'totalprice'=> $request->totalprice,
            'quantity' => $request->quantity,
            'status' => 'paid',
            'pay_method' => 'FPX',
            'stud_id' => $stud_id,
            'product_id' => $product_id,
            'package_id' => $package_id
        ));

        return redirect('viewbypackage/'.$product_id.'/'.$package_id)->with('addsuccess','Customer Successfully Added!');
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
        $student = Student::orderBy('id','desc')->get();
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('product_id', $product_id)->get();
        $ticket = Ticket::where('product_id', $product_id)->get();

        return Excel::download(new ProgramExport($payment, $student, $package, $ticket), $product->name.'.xlsx');
    }
}
