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
use App\User;
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

    public function maklumatPeserta($product_id,$package_id)
    {
        $package = Package::where('package_id',$package_id)->first();
        $product = Product::where('product_id',$product_id)->first();

        return view('attendance.caripeserta', compact('package','product'));
    }

    public function icPeserta($product_id, $package_id, Request $request)
    {
        $package = Package::where('package_id',$package_id)->first();
        $product = Product::where('product_id',$product_id)->first();

        $student = Student::where('ic', $request->ic)->first();
        $payment = Payment::where('stud_id',$student->stud_id)->where('product_id',$product_id)->where('package_id',$package_id)->first();
        
        // kalau orang beli lebih dari 1 dia cari kat table ticket
        if ($payment == NULL){
            $ticket = Ticket::where('stud_id',$student->stud_id)->where('product_id',$product_id)->where('package_id',$package_id)->first();
            if ($ticket->ticket_type == 'paid'){
                $pay = Payment::where('payment_id',$ticket->payment_id)->where('status','paid')->where('product_id',$product_id)->where('package_id',$package_id)->first();
                $peserta = Student::where('ic', $ticket->ic)->first();
    
                return redirect('data-peserta/'. $pay->product_id . '/' . $pay->package_id . '/' . $ticket->ticket_id . '/' . $pay->payment_id . '/' . $peserta->ic);
            }
            else {
                return view('customer.failed_payment');
            }
        }

        // tiket selesai bayar
        elseif ($payment->status == 'paid'){

            $ticket = Ticket::orderBy('id','desc')->where('payment_id',$payment->payment_id)->where('product_id',$product_id)->where('package_id',$package_id)->first();
            $businessdetail = BusinessDetail::where('ticket_id', $ticket->ticket_id)->first();
            $peserta = Student::where('ic', $ticket->ic)->first();
            $pay = Payment::where('payment_id', $ticket->payment_id)->first();
    
            return redirect('data-peserta/'. $pay->product_id . '/' . $pay->package_id . '/' . $ticket->ticket_id . '/' . $pay->payment_id . '/' . $peserta->ic);
        }
        else { // belum buat pembayaran
            return view('customer.failed_payment');
        }

        // $student = Student::where('ic', $request->ic)->first();
        // $payment = Payment::orderBy('id','desc')->where('stud_id',$student->stud_id)->get();
        // dd($payment);

        // foreach ($payment as $keypay => $payval){
            
        //     $payinfo = Product::where('product_id',$payval->product_id)->first();

        //         if ($payinfo->class == 'MMB'){

        //             $ticket = Ticket::orderBy('id','desc')->where('payment_id',$payval->payment_id)->where('product_id',$payinfo->product_id)->first();
        //             $businessdetail = BusinessDetail::where('ticket_id', $ticket->ticket_id)->first();
        //             $peserta = Student::where('ic', $ticket->ic)->first();
        //             $pay = Payment::where('payment_id', $ticket->payment_id)->first();

        //             return redirect('data-peserta/'. $pay->product_id . '/' . $pay->package_id . '/' . $ticket->ticket_id . '/' . $pay->payment_id . '/' . $peserta->ic);
        //         }
        // }
        // dd('bukan MMB');
    }

    public function dataPeserta($product_id, $package_id, $ticket_id, $payment_id, $ic, Request $request)
    {
        $student = Student::where('ic', $ic)->first();
        $package = Package::where('package_id', $package_id)->first();
        $product = Product::where('product_id', $product_id)->first();
        $payment = Payment::where('payment_id', $payment_id)->first();
        $ticket = Ticket::where('ticket_id', $ticket_id)->first();
        $businessdetail = BusinessDetail::where('ticket_id', $ticket_id)->first();

        return view('attendance.maklumatpeserta', compact('student', 'package', 'product', 'payment', 'ticket', 'businessdetail'));
    }

    public function adminDataPeserta($product_id, $package_id, $ticket_id, $payment_id, $ic, Request $request)
    {
        $student = Student::where('ic', $ic)->first();
        $package = Package::where('package_id', $package_id)->first();
        $product = Product::where('product_id', $product_id)->first();
        $payment = Payment::where('payment_id', $payment_id)->first();
        $ticket = Ticket::where('payment_id', $payment_id)->first();
        $businessdetail = BusinessDetail::where('ticket_id', $ticket_id)->first();

        return view('attendance.admin.maklumatdatapeserta', compact('student', 'package', 'product', 'payment', 'ticket', 'businessdetail'));
    }

    public function pengesahanKehadiranPeserta($product_id, $package_id, $ticket_id, $payment_id, $ic, Request $request)
    {
        $student = Student::where('ic', $ic)->first();
        $package = Package::where('package_id', $package_id)->first();
        $product = Product::where('product_id', $product_id)->first();
        $payment = Payment::where('payment_id', $payment_id)->first();
        $ticket = Ticket::where('ticket_id', $ticket_id)->first();
        $businessdetail = BusinessDetail::where('ticket_id', $ticket_id)->first();
        
        // kalau peserta beli ticket lebih dari satu
        if($payment->quantity > 1){
            // ubah kat table payment kalau orang yang beli yang discan
            if($student->stud_id == $payment->stud_id){
                if ($payment->attendance == 'kehadiran disahkan'){
                    // dd('a');
                    return view('attendance.sudahdisahkan'); 
                }
                else {
                    // dd('b');
                    $payment->attendance = "kehadiran disahkan";
                    $payment->save();

                    $ticket->attendance = "kehadiran disahkan";
                    $ticket->save();
                }
            }
            // kalau orang bukan yang beli tiket scan
            else {
                if ($ticket->attendance == 'kehadiran disahkan'){
                    // dd('c');
                    return view('attendance.sudahdisahkan'); 
                }else {
                    // dd('d');
                    $ticket->attendance = "kehadiran disahkan";
                    $ticket->save();
                }
            }
        }
        // beli 1 tiket je
        else {
            if ($payment->attendance == 'kehadiran disahkan'){
                return view('attendance.sudahdisahkan'); 
            }else {
                $payment->attendance = "kehadiran disahkan";
                $payment->save();
            }
        }

        return view('attendance.kehadirandisahkan', compact('student', 'package', 'product', 'payment', 'ticket', 'businessdetail'));
    }

    public function download_attendance($product_id, $package_id, Request $request)
    {
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $payment = Payment::where('status','paid')->where('product_id',$product_id)->where('package_id',$package_id)->where('attendance','kehadiran disahkan')->get();
        $ticket = Ticket::where('ticket_type','paid')->where('product_id',$product_id)->where('package_id',$package_id)->where('attendance','kehadiran disahkan')->get();
        
        for ($i=0; $i < count($payment) ; $i++) { 
            $studentpay[$i] = Student::where('stud_id', $payment[$i]->stud_id)->get();
        }
        for ($i=0; $i < count($ticket) ; $i++) { 
            $studenttic[$i] = Student::where('stud_id', $ticket[$i]->stud_id)->get();
        }

        // foreach ($payment as $keypay) {
        //     $studentpay = Student::where('stud_id', $keypay->stud_id)->first();
        // }

        // foreach ($ticket as $keytic) {
        //     $studenttic = Student::where('ic', $keytic->ic)->first();
        // }
        // dd(count($ticket) == 0);

        $fileName = $product->name.' Kehadiran'.'.csv';
            $columnNames = [
                'First Name',
                'Last Name',
                'IC No',
                'Phone No',
                'Email',
                'Product',
            ];
            
            $file = fopen(public_path('export/') . $fileName, 'w');
            fputcsv($file, $columnNames);
            
            foreach ($studentpay as $keystud => $valpay) {
                foreach ($valpay as $datastud) {
                    fputcsv($file, [
                        $datastud->first_name,
                        $datastud->last_name,
                        $datastud->ic,
                        $datastud->phoneno,
                        $datastud->email,
                        $product->name,
                    ]);
                }
            }

            if (count($ticket) >= 1){
                foreach ($studenttic as $keytic => $valtic){
                    foreach ($valtic as $datatic) {
                        fputcsv($file, [
                            $datatic->first_name,
                            $datatic->last_name,
                            $datatic->ic,
                            $datatic->phoneno,
                            $datatic->email,
                            $product->name,
                            ]);
                    }
                }
            }

            fclose($file);

        return redirect('trackpackage/'. $product->product_id)->with('success', 'User Successfully Created');
    }
}

