<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Product;
use App\Package;
use App\BusinessDetail;
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

    public function maklumatPeserta()
    {
        $package = Package::all();
        $product = Product::all();

        return view('attendance.caripeserta', compact('package','product'));
    }

    public function icPeserta(Request $request)
    {
        $student = Student::where('ic', $request->ic)->first();
        $payment = Payment::orderBy('id','desc')->where('stud_id',$student->stud_id)->get();

        foreach ($payment as $keypay => $payval){
            
            $payinfo = Product::where('product_id',$payval->product_id)->first();

                if ($payinfo->class == 'MMB'){

                    $ticket = Ticket::orderBy('id','desc')->where('payment_id',$payval->payment_id)->where('product_id',$payinfo->product_id)->first();
                    $businessdetail = BusinessDetail::where('ticket_id', $ticket->ticket_id)->first();
                    $peserta = Student::where('ic', $ticket->ic)->first();
                    $pay = Payment::where('payment_id', $ticket->payment_id)->first();

                    return redirect('data-peserta/'. $pay->product_id . '/' . $pay->package_id . '/' . $ticket->ticket_id . '/' . $pay->payment_id . '/' . $peserta->ic);
                }
        }
        dd('bukan MMB');
    }

    public function dataPeserta($product_id, $package_id, $ticket_id, $payment_id, $ic, Request $request)
    {
        $student = Student::where('ic', $ic)->first();
        $package = Package::where('package_id', $package_id)->first();
        $product = Product::where('product_id', $product_id)->first();
        $payment = Payment::where('payment_id', $payment_id)->first();
        $ticket = Ticket::where('payment_id', $payment_id)->first();
        $businessdetail = BusinessDetail::where('ticket_id', $ticket_id)->first();

        return view('attendance.maklumatpeserta', compact('student', 'package', 'product', 'payment', 'ticket', 'businessdetail'));
    }

    public function pengesahanKehadiranPeserta($product_id, $package_id, $ticket_id, $payment_id, $ic, Request $request)
    {
        $student = Student::where('ic', $ic)->first();
        $package = Package::where('package_id', $package_id)->first();
        $product = Product::where('product_id', $product_id)->first();
        $payment = Payment::where('payment_id', $payment_id)->first();
        $ticket = Ticket::where('payment_id', $payment_id)->first();
        $businessdetail = BusinessDetail::where('ticket_id', $ticket_id)->first();

        if ($payment->attendance == 'kehadiran disahkan'){
            return view('attendance.sudahdisahkan'); 
        }else {
            $payment->attendance = "kehadiran disahkan";
            $payment->save();
        }

        return view('attendance.kehadirandisahkan', compact('student', 'package', 'product', 'payment', 'ticket', 'businessdetail'));
    }
}

