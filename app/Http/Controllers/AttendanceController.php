<?php

namespace App\Http\Controllers;

use DB;
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


class AttendanceController extends Controller
{

    public function ICdetails($product_id,$package_id) {
        {
            // Session::put('user_invite', $user_invite);
            $package = Package::where('package_id', $package_id)->first();
            $product = Product::where('product_id', $product_id)->first();
    
            return view('attendance.ICdetails', compact('product', 'package'));
            // abort(404); 
        }   
    }

    public function validation($product_id, $package_id, Request $request)
    {
        $package = Package::where('package_id', $package_id)->first();
        $student = Student::where('ic',$request->ic)->first();
        $product = Product::where('product_id', $product_id)->first();
        $payment = Payment::where('product_id', $product->product_id)->where('package_id', $package->package_id)->where('stud_id',$student->stud_id)->first();
        $check = Product::where('product_id',$payment->product_id)->first();

        // Check if ic exist
        if ($check->class == 'MMB'){
            $student = Student::where('ic', $request->ic)->first();
            return redirect('pengesahan-maklumat/' . $product_id . '/' . $package_id .'/'.$student->stud_id);
        }else{
            return view('attendance.unregister');
        }
    }

    
    public function detailconfirmation($product_id, $package_id, $stud_id, Request $request)
    {
        
        $student = Student::where('stud_id', $stud_id)->first();
        $product = Product::where('product_id',$product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $payment = Payment::where('stud_id',$student->stud_id)->first();

        Session::put('product_id', $product_id);
        Session::put('package_id', $package_id);
        Session::put('payment', $payment);

        $stud = $request->session()->get('student');
        $payment = $request->session()->get('payment');
         
       
        return view('attendance.detailconfirmation',compact('student', 'stud', 'payment', 'product', 'package'));
    }

    public function simpanmaklumat(Request $request,$product_id, $package_id, $stud_id )
    {
        
        $student = Student::where('stud_id', $stud_id)->first();
        $product = Product::where('product_id',$product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $payment = Payment::where('stud_id',$student->stud_id)->first();

        // dd($request->kehadiran);

        switch ($request->input('kehadiran')) {
            case 'hadir':
                // To t)ell system the participant form has been key in
                $payment->attendance = "hadir";
                $payment->save();
                return view('attendance.hadirattendance',compact('student', 'payment', 'product', 'package'));

                break;
    
            case 'tidak hadir':
                // To tell system the participant form has been key in
                $payment->attendance = "tidak hadir";
                $payment->save();
                return view('attendance.tidakhadirattendance',compact('student', 'payment', 'product', 'package'));
                break;
        }
         
       
    }

}

