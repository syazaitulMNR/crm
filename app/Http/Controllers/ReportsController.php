<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Product;
use App\Package;
use App\Payment;
use App\Ticket;
use App\Offer;
use App\User;
use Carbon\Carbon;
use DB;
use App\Imports\ParticipantImport;
// use App\Exports\ProgramExport;
use App\Exports\ParticipantFormat;
// use App\Exports\PaidTicket_Export;
// use App\Exports\FreeTicket_Export;
// use Rap2hpoutre\FastExcel\FastExcel;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\PengesahanJob;
use App\Jobs\TiketJob;
use Mail;
use Auth;

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

    public function trackprogram()
    {
        $product = Product::orderBy('id','desc')->paginate(15);
        
        return view('admin.reports.trackprogram', compact('product'));
    }

    public function trackpackage($product_id)
    {
        $payment = Payment::where('product_id', $product_id)->get();
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('product_id', $product_id)->paginate(15);
        $student = Student::orderBy('id','desc')->paginate(15);
        $link = 'https://mims.momentuminternet.my/upgrade/'. $product->product_id . '/';

        // Testing //////////////////////////////////////////////////////////////////

        // $count_package = Package::where('product_id', $product_id)->count();
        // for ($i = 0; $i < $count_package; $i++)
        // {
        //     $date_yesterday[$i] = Payment::where('created_at', $product_id)->where('status', 'paid')->subDays($i)->format('d M Y');
        //     dd($date_yesterday[$i]);
        //     $total_yesterday = Payment::where('product_id', $product_id)->where('status', 'paid')->whereBetween('created_at', [ date('Y-m-d 00:00:00', strtotime("-[$i] day")) , date('Y-m-d 23:59:59', strtotime("-[$i] day")) ])->count();        
        //     // $packageinfo[$i] = Payment::where('status','paid')->where('product_id', $product_id)->where('package_id', $package[$i]->package_id)->whereBetween('created_at', [ $from , $to ])->count();
        // }

        // $visitorTraffic = Payment::where('created_at', '>=', \Carbon\Carbon::now->subMonth())
        //                 ->groupBy(DB::raw('Date(created_at)'))
        //                 ->orderBy('created_at', 'DESC')->get();

        // $hingga = Payment::where('created_at', '>=', Carbon::now()->subDays(14));
        // $dari = Payment::where('created_at', '==', Carbon::now());

        // $visitors = Payment::select(
        //                     "id" ,
        //                     DB::raw("(sum(quantity)) as total_quantity"),
        //                     DB::raw("(DATE_FORMAT(created_at, '%d-%m-%Y')) as my_date")
        //                     )
        //                     ->orderBy('created_at')
        //                     ->groupBy(DB::raw("DATE_FORMAT(created_at, '%d-%m-%Y')"))
        //                     ->get();
        // dd($visitors);

        // worked  latest ambik latest buyer, oldest ambik oldest buyer
        // $latest = Payment::latest('created_at')->where('status', 'paid')->where('product_id', $product_id)->where('package_id', 'PKD0046')->get();
        // $oldest = Payment::oldest('created_at')->where('status', 'paid')->where('product_id', $product_id)->where('package_id', 'PKD0046')->first();

        // dd($latest);

        $startDate = Carbon::createFromFormat('Y-m-d', '2021-09-01');
        $endDate = Carbon::createFromFormat('Y-m-d', '2021-09-30');

        // $posts = Payment::where('status', 'paid')->where('product_id', $product_id)->where('package_id', 'PKD0023')->orderBy('created_at', 'desc')->whereBetween('created_at', [$startDate, $endDate])->groupBy(function($date) {
        //     return Carbon::parse($date->created_at)->format('D');})->get();

        // $data= Payment::where('status', 'paid')->where('product_id', $product_id)->where('package_id', 'PKD0046')->orderBy('created_at', 'desc')
        //     ->get()
        //     ->groupBy(function($val) {
        //     return Carbon::parse($val->created_at)->format('d M Y');
        //     });

        $visitorTraffic = Payment::where('status', 'paid')->where('product_id', $product_id)->where('package_id', 'PKD0046')->orderBy('created_at', 'desc')->get()->groupBy(function($date) {
                            return Carbon::parse($date->created_at)->format('D'); // grouping by years
                            });
        $results = Payment::where('status', 'paid')->where('product_id', $product_id)->where('package_id', 'PKD0046')->orderBy('created_at', 'desc')->latest()->get();

        // worked
        $order = Payment::where('status', 'paid')->where('product_id', $product_id)->where('package_id', 'PKD0046')->groupBy(function($date){
                $created_at = Carbon::parse($date->created_at);
                $start = $created_at->startOfWeek()->format('d-m-Y');
                $end = $created_at->endOfWeek()->format('d-m-Y');
                return "{$start} - {$end}";
                });

        //////////////////////      ////////////////////////

        $productfirst = Payment::where('status', 'paid')->where('product_id', $product_id)->orderBy('created_at', 'asc')->first();
        $test = $productfirst->created_at->format('Y-m-d H:i:s');

        $hingga = Carbon::now('Asia/Kuala_Lumpur')->format('Y-m-d H:i:s');
        $dari = $test;

        $packageinfo = Payment::where('status', 'paid')->where('product_id', $product_id)->whereBetween('created_at',[ date('Y-m-d 00:00:00', strtotime("-1 days")) , date('Y-m-d 23:59:59', strtotime("-1 days")) ])->get();
        $count_package = Package::where('product_id', $product_id)->count();

        for ($i = 0; $i < $count_package; $i++)
        {
            $packageinfo[$i] = Payment::where('status','paid')->where('product_id', $product_id)->where('package_id', $package[$i]->package_id)->whereBetween('created_at', [ $dari , $hingga ])->count();
            $registration[$i] = Payment::where('status','paid')->where('product_id', $product_id)->where('package_id', $package[$i]->package_id)->whereBetween('created_at', [ $dari , $hingga ])->count();
            $packageinfo = Payment::where('status', 'paid')->where('product_id', $product_id)->where('package_id', $package[$i]->package_id)->whereBetween('created_at', [ $dari , $hingga ])->get();

            for ($i = 0; $i < $count_package; $i++)
            {
                $totalpackage[$i] = Payment::where('status','paid')->where('product_id', $product_id)->where('package_id', $package[$i]->package_id)->whereBetween('created_at', [ $dari , $hingga ])->orderBy('created_at', 'desc')->count();
            }
            $data = Payment::where('status', 'paid')->where('product_id', $product_id)->whereBetween('created_at', [ $dari , $hingga ])->orderBy('created_at', 'desc')
                    ->get()
                    ->groupBy(function($val) {
                    return Carbon::parse($val->created_at)->format('Y-m-d','[A-Za-z0-9-]+');
                    });
            $data1 = Payment::where('status', 'paid')->where('product_id', $product_id)->whereBetween('created_at', [ $dari , $hingga ])->orderBy('created_at', 'desc')
                    ->get()
                    ->groupBy(function($val) {
                    return Carbon::parse($val->created_at)->format('Y-m-d');
                    })->first(); 
            $data2 = Payment::where('status', 'paid')->where('product_id', $product_id)->whereBetween('created_at', [ $dari , $hingga ])->orderBy('created_at', 'desc')
                    ->get()
                    ->groupBy(function($val) {
                    return Carbon::parse($val->created_at)->format('Y-m-d');
                    })->skip(1)->first(); 
            $totalquantity = Payment::where('status', 'paid')->where('product_id', $product_id)->whereBetween('created_at', [ $dari , $hingga ])->orderBy('created_at', 'desc')
                            ->get()
                            ->groupBy(function($val) {
                                return Carbon::parse($val->created_at)->format('d M Y');
                                });
            $total_listproduct[$i] = Payment::where('package_id', $product_id)->where('status', 'paid')->whereBetween('created_at', [ date('Y-m-d 00:00:00', strtotime("-1 day")) , date('Y-m-d 23:59:59', strtotime("-1 day")) ])->count();        
        }

        // foreach($data1 as $key1 => $value1){
        //     foreach($data2 as $key2 => $value2){
        //         $testdate1 =  $value1->created_at->format('Y-m-d');
        //         $testdate2 =  $value2->created_at->format('Y-m-d');
        //     }
        // }
        
        $totalpackageall = Payment::where('status','paid')->where('product_id', $product_id)->whereBetween('created_at', [ $dari , $hingga ])->orderBy('created_at', 'desc')->first();
        $totaldays = $data->count();
        // dd($totalpackageall);
        // for ($j = 0; $j < $count_package; $j++){
        //     for($i = 0; $i < $totaldays; $i++){
        //         foreach($data as $key => $value){
        //             // dd($testdate2);
        //             // $q = Payment::where('status','paid')->where('product_id', 'PRD0022')->where('package_id' , 'PKD0046')->orderBy('created_at', 'desc')->where('created_at', '>', '2021-12-1 00:00:00')->where('created_at', '<=','2021-12-17 00:00:00')->get();
        //             $t[$i] = Payment::where('status','paid')->where('product_id', $product_id)->where('package_id' , $package[$j]->package_id)->orderBy('created_at', 'desc')->whereBetween('created_at',array($testdate2,$testdate1))->get();//

        //             $te[$i] = count($t['status'== 'paid']);
        //             // dd($te);
        //         }
        //     }    
        // }
        
        // $testingla = $q->where('startdate', '>', '16 Dec 2021')->where('startdate', '<=', '17 Dec 2021')->get();

        // for ($i = 0; $i < $count_package; $i++)
        // {
        // $total_package_date[$i] = 0;
        // $package_date[$i] = Payment::where('product_id', $product_id)->where('package_id', $package[$i]->package_id)->where('status','paid')->whereBetween('created_at',)->count();
        // $total_package_date[$i] = $total_package_date[$i] + $package_date[$i];
        // }

        for ($i = 0; $i < $count_package; $i++)
        {
            $totalpackagealls = Payment::where('status','paid')->where('product_id', $product_id)->where('package_id', $package[$i]->package_id)->whereBetween('created_at', [ $dari , $hingga ])->orderBy('created_at', 'desc')->count();
            $totalperpackage[$i] = Payment::where('status','paid')->where('product_id', $product_id)->where('package_id', $package[$i]->package_id)->whereBetween('created_at', [ $dari , $hingga ])->orderBy('created_at', 'desc')->count();
            $registration[$i] = Payment::where('status','paid')->where('product_id', $product_id)->where('package_id', $package[$i]->package_id)->whereBetween('created_at', [ $dari , $hingga ])->count();
        }

        $selectedID = 1;
        // End Testing ///////////////////////////////////////////////////////////////

        $counter = Student::count();
        $totalsuccess = Payment::where('status','paid')->where('product_id', $product_id)->count();
        $totalcancel = Payment::where('status','due')->where('product_id', $product_id)->count();
        $paidticket = Ticket::where('ticket_type', 'paid')->where('product_id', $product_id)->count();
        $freeticket = Ticket::where('ticket_type', 'free')->where('product_id', $product_id)->count();
        
        return view('admin.reports.trackpackage', compact('selectedID','totalpackageall','totalperpackage', 'totalpackage', 'totalquantity', 'registration', 'data', 'visitorTraffic', 'results', 'order', 'count_package', 'product', 'package', 'payment', 'student', 'counter', 'totalsuccess', 'totalcancel', 'paidticket', 'freeticket' , 'link'));
    }

    public function exportProgram($product_id, Request $request)
    {
        $student = Student::orderBy('id','desc')->get();
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('product_id', $product_id)->get();
        $users = User::all();
    
        $filter = $request->filter_export;
        $receipient_mail = $request->receipient_mail;

        if($filter == 'success_payment') {

            $payment = Payment::where('product_id', $product_id)->where('status', 'paid')->get();

            /*-- Success Payment ---------------------------------------------------*/
            $fileName = $product->product_id.' - Success_Payment.csv';
            $columnNames = [
                'Customer ID',
                'First Name',
                'Last Name',
                'IC No',
                'Phone No',
                'Email',
                'Quantity',
                'Payment',
                'Status',
                'Payment Method',
                'Package',
                'Offer ID',
                'Update Participant',
                'Payment Source',
                'Purchased At',
                'Payment Date Time'
            ];

            
            $file = fopen(public_path('export/') . $fileName, 'w');
            fputcsv($file, $columnNames);
            
            foreach ($student as $students) {
                foreach($payment as $payments){
                    foreach($package as $packages){
                            if($payments->stud_id == $students->stud_id){
                                if($payments->package_id == $packages->package_id){
                                        fputcsv($file, [
                                            $payments->payment_id,
                                            $students->first_name,
                                            $students->last_name,
                                            $students->ic,
                                            $students->phoneno,
                                            $students->email,
                                            $payments->quantity,
                                            $payments->totalprice,
                                            $payments->status,
                                            $payments->pay_method,
                                            $packages->name,
                                            $payments->offer_id,
                                            $payments->update_count,
                                            $payments->user_id,
                                            $payments->created_at,
                                            $payments->pay_datetime
                                        ]);
                                }
                            }
                    }
                }
                
            }
            
            fclose($file);

        } elseif ($filter == 'updated_participant') {

            $payment = Payment::where('product_id', $product_id)->where('status', 'paid')->where('update_count', 1)->get();

            /*-- Updated Participant ---------------------------------------------------*/
            $fileName = $product->product_id.' - Updated_Participant.csv';
            $columnNames = [
                'Customer ID',
                'First Name',
                'Last Name',
                'IC No',
                'Phone No',
                'Email',
                'Quantity',
                'Payment',
                'Status',
                'Payment Method',
                'Package',
                'Offer ID',
                'Update Participant',
                'Payment Source',
                'Purchased At',
                'Payment Date Time'
            ];

            
            $file = fopen(public_path('export/') . $fileName, 'w');
            fputcsv($file, $columnNames);
            
            foreach ($student as $students) {
                foreach($payment as $payments){
                    foreach($package as $packages){
                            if($payments->stud_id == $students->stud_id){
                                if($payments->package_id == $packages->package_id){
                                        fputcsv($file, [
                                            $payments->payment_id,
                                            $students->first_name,
                                            $students->last_name,
                                            $students->ic,
                                            $students->phoneno,
                                            $students->email,
                                            $payments->quantity,
                                            $payments->totalprice,
                                            $payments->status,
                                            $payments->pay_method,
                                            $packages->name,
                                            $payments->offer_id,
                                            $payments->update_count,
                                            $payments->user_id,
                                            $payments->created_at,
                                            $payments->pay_datetime
                                        ]);

                                }
                            }
                    }
                }
                
            }
            
            fclose($file);

        } elseif ($filter == 'manual_register') {

            $payment = Payment::where('product_id', $product_id)->get();
            
            /*-- All Buyer ---------------------------------------------------*/
            $fileName = $product->product_id.' - Manual_Registration.csv';
            $columnNames = [
                'Customer ID',
                'First Name',
                'Last Name',
                'IC No',
                'Phone No',
                'Email',
                'Quantity',
                'Payment',
                'Status',
                'Payment Method',
                'Package',
                'Offer ID',
                'Update Participant',
                'Payment Source',
                'Purchased At',
                'Payment Date Time'
            ];

            
            $file = fopen(public_path('export/') . $fileName, 'w');
            fputcsv($file, $columnNames);
            
            foreach ($student as $students) {
                foreach($payment as $payments){
                    foreach($package as $packages){
                        foreach($users as $user){
                            if($payments->stud_id == $students->stud_id){
                                if($payments->package_id == $packages->package_id){
                                    if($payments->user_id == $user->user_id){

                                        fputcsv($file, [
                                            $payments->payment_id,
                                            $students->first_name,
                                            $students->last_name,
                                            $students->ic,
                                            $students->phoneno,
                                            $students->email,
                                            $payments->quantity,
                                            $payments->totalprice,
                                            $payments->status,
                                            $payments->pay_method,
                                            $packages->name,
                                            $payments->offer_id,
                                            $payments->update_count,
                                            $user->email,
                                            $payments->created_at,
                                            $payments->pay_datetime
                                        ]);

                                    }
                                }
                            }
                        }
                    }
                }
                
            }
            
            fclose($file);

        } else {
            
            $payment = Payment::where('product_id', $product_id)->get();
            
            /*-- All Buyer ---------------------------------------------------*/
            $fileName = $product->product_id.' - All_Buyer.csv';
            $columnNames = [
                'Customer ID',
                'First Name',
                'Last Name',
                'IC No',
                'Phone No',
                'Email',
                'Quantity',
                'Payment',
                'Status',
                'Payment Method',
                'Package',
                'Offer ID',
                'Update Participant',
                'Payment Source',
                'Purchased At',
                'Payment Date Time'
            ];

            
            $file = fopen(public_path('export/') . $fileName, 'w');
            fputcsv($file, $columnNames);
            
            foreach ($student as $students) {
                foreach($payment as $payments){
                    foreach($package as $packages){
                        // foreach($users as $user){
                            if($payments->stud_id == $students->stud_id){
                                if($payments->package_id == $packages->package_id){
                                    // if($payments->user_id == $user->user_id){

                                        fputcsv($file, [
                                            $payments->payment_id,
                                            $students->first_name,
                                            $students->last_name,
                                            $students->ic,
                                            $students->phoneno,
                                            $students->email,
                                            $payments->quantity,
                                            $payments->totalprice,
                                            $payments->status,
                                            $payments->pay_method,
                                            $packages->name,
                                            $payments->offer_id,
                                            $payments->update_count,
                                            $payments->user_id,
                                            $payments->created_at,
                                            $payments->pay_datetime
                                        ]);

                                    // }
                                }
                            }
                        // }
                    }
                }
                
            }
            
            fclose($file);

        }
                
        Mail::send('emails.export_mail', [], function($message) use ($fileName)
        {
            $message->to(request()->receipient_mail)->subject('ATTACHMENT OF BUYER DETAILS');
            $message->attach(public_path('export/') . $fileName);
        });

        return redirect('trackpackage/'.$product_id)->with('export-buyer','The registration details has been successfully sent to the email given.');

    }

    public function exportParticipant($product_id, Request $request)
    {
        $ticket = Ticket::where('product_id', $product_id)->get();
        $student = Student::orderBy('id','desc')->get();
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('product_id', $product_id)->get();
        $users = User::all();
        
        $filter = $request->filter_export;

        if($filter == 'manual_participant') {
            // return Excel::download(new ProgramExport($payment, $student, $package), $product->name.'.xlsx');
            /*-- Manage Email ---------------------------------------------------*/
            $fileName = $product->product_id.' - Manual_Participant.csv';
            $columnNames = [
                'Ticket ID',
                'First Name',
                'Last Name',
                'IC No',
                'Phone No',
                'Email',
                'Package',
                'Ticket Type',
                'Ticket Source',
                'Registered At'
            ];
            
            $file = fopen(public_path('export/') . $fileName, 'w');
            fputcsv($file, $columnNames);
            
            foreach ($student as $students) {
                foreach($ticket as $tickets){
                    foreach($package as $packages){
                        foreach($users as $user){
                            if($tickets->ic == $students->ic){
                                if($tickets->package_id == $packages->package_id){
                                    if($tickets->user_id == $user->user_id){
                                        
                                        fputcsv($file, [
                                            $tickets->ticket_id,
                                            $students->first_name,
                                            $students->last_name,
                                            $students->ic,
                                            $students->phoneno,
                                            $students->email,
                                            $packages->name,
                                            $tickets->ticket_type,
                                            $user->email,
                                            $tickets->created_at,
                                        ]);

                                    }

                                }
                            }
                        }
                    }
                }
                
            }
            
            fclose($file);

        } else {

            /*-- Manage Email ---------------------------------------------------*/
            $fileName = $product->product_id.' - All_Participant.csv';
            $columnNames = [
                'Ticket ID',
                'First Name',
                'Last Name',
                'IC No',
                'Phone No',
                'Email',
                'Package',
                'Ticket Type',
                'Ticket Source',
                'Registered At'
            ];
            
            $file = fopen(public_path('export/') . $fileName, 'w');
            fputcsv($file, $columnNames);
            
            foreach ($student as $students) {
                foreach($ticket as $tickets){
                    foreach($package as $packages){
                        // foreach($users as $user){
                            if($tickets->ic == $students->ic){
                                if($tickets->package_id == $packages->package_id){
                                    // if($tickets->user_id == $user->user_id){
                                        
                                        fputcsv($file, [
                                            $tickets->ticket_id,
                                            $students->first_name,
                                            $students->last_name,
                                            $students->ic,
                                            $students->phoneno,
                                            $students->email,
                                            $packages->name,
                                            $tickets->ticket_type,
                                            $tickets->user_id,
                                            $tickets->created_at,
                                        ]);

                                    // }

                                }
                            }
                        // }
                    }
                }
                
            }
            
            fclose($file);

        }

        
        Mail::send('emails.export_mail', [], function($message) use ($fileName)
        {
            $message->to(request()->receipient_mail)->subject('ATTACHMENT OF PARTICIPANT DETAILS');
            $message->attach(public_path('export/') . $fileName);
        });

        return redirect('trackpackage/'.$product_id)->with('export-participant','The participant details has been successfully sent to the email given.');

    }

    /*-- Buyer ---------------------------------------------------*/
    public function viewbypackage($product_id, $package_id)
    {
        //Get the details
        $ticket = Ticket::orderBy('id','desc')->where('product_id', $product_id)->where('package_id', $package_id)->paginate(15);
        $payment = Payment::orderBy('id','desc')->where('product_id', $product_id)->where('package_id', $package_id)->paginate(15);
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $offer = Offer::orderBy('id','desc')->get();
        $student = Student::orderBy('id','desc')->get();

        //Count the data
        $count = 1;
        $total = Payment::where('product_id', $product_id)->where('package_id', $package_id)->count();
        $totalsuccess = Payment::where('status','paid')->where('product_id', $product_id)->where('package_id', $package_id)->count();
        $totalcancel = Payment::where('status','due')->where('product_id', $product_id)->where('package_id', $package_id)->count();
        $paidticket = Ticket::where('ticket_type', 'paid')->where('product_id', $product_id)->where('package_id', $package_id)->count();
        $freeticket = Ticket::where('ticket_type', 'free')->where('product_id', $product_id)->where('package_id', $package_id)->count();
        
        return view('admin.reports.viewbypackage', compact( 'ticket', 'product', 'package', 'payment', 'offer', 'student', 'count', 'total', 'totalsuccess', 'totalcancel', 'paidticket', 'freeticket'));
    }

    public function destroy($payment_id, $product_id, $package_id) 
    {
        $payment = Payment::where('payment_id', $payment_id)->where('product_id', $product_id)->where('package_id', $package_id);
        $payment->delete();

        return redirect('view/buyer/'.$product_id.'/'.$package_id)->with('deletepayment', 'Payment Successfully Deleted');
    }

    public function approveaccount($payment_id, $product_id, $package_id, Request $request) 
    {
        $payment = Payment::where('payment_id', $payment_id)->where('product_id', $product_id)->where('package_id', $package_id)->first();

        if($payment->status == 'approve by sales'){
            $payment->status = 'paid';
            $payment->save();
            $request->session()->forget('payment');
        }
        else if($payment->status == 'not approve'){
            $payment->status = 'approve by account';
            $payment->save();
            $request->session()->forget('payment');
        }    

        return redirect('view/buyer/'.$product_id.'/'.$package_id)->with('accountapprove', 'Account Approve Successfully');
    }

    public function approvesales($payment_id, $product_id, $package_id, Request $request) 
    {
        $payment = Payment::where('payment_id', $payment_id)->where('product_id', $product_id)->where('package_id', $package_id)->first();

        if($payment->status == 'approve by account'){
            $payment->status = 'paid';
            $payment->save();
            $request->session()->forget('payment');
        }
        else if($payment->status == 'not approve'){
            $payment->status = 'approve by sales';
            $payment->save();
            $request->session()->forget('payment');
        }    

        return redirect('view/buyer/'.$product_id.'/'.$package_id)->with('accountapprove', 'Account Approve Successfully');
    }

    //insert pay_datetime, receipt_path & PIC_name
    public function save_customer($product_id, $package_id, Request $request)
    { 
        $student = Student::where('ic', $request->ic)->first();
        
        if(Student::where('ic', $request->ic)->exists()){

            // Start Receipt
            $filename = $request->file('receipt_path');
            if($filename != '')
            {   
                $extension = $filename->getClientOriginalExtension();
                
                if($extension == 'jpeg' || $extension == 'jpg' || $extension == 'png' || $extension == 'pdf' || $extension == 'JPEG' || $extension == 'JPG' || $extension == 'PNG' || $extension == 'PDF')
                {
                    $name = $filename->getClientOriginalName();
                    $uniqe = 'RE'. uniqid() . '.' . $extension;
                    $dirpath = public_path('assets/receipts/');
                    $filename->move($dirpath, $uniqe); 

                    $receipt_name = 'assets/receipts/'.$uniqe;
                } else {
                    return redirect()->back()->with('error','Not valid file. Please insert pdf, jpeg, jpg & png only.');
                }
            } else {
                $receipt_name = NULL;
            }
            // End Receipt

            $payment_id = 'OD'.uniqid();
            Payment::create(array(
                'payment_id'=> $payment_id,
                'pay_price'=> $request->pay_price,
                'totalprice'=> $request->totalprice,
                'quantity' => $request->quantity,
                'status' => 'paid',
                'pay_method' => 'Manual',
                'email_status'  => 'Hold',
                'stud_id' => $student->stud_id,
                'product_id' => $product_id,
                'package_id' => $package_id,
                'offer_id' => $request->offer_id,
                'user_id' => Auth::user()->user_id,
                'pay_datetime' => $request->pay_datetime,
                'pic' => $request->pic,
                'receipt_path' => $receipt_name
            ));

        }else{

            $stud_id = 'MI'.uniqid();
            
            Student::create(array(
                'stud_id'=> $stud_id,
                'first_name'=> ucwords(strtolower($request->first_name)),
                'last_name'=> ucwords(strtolower($request->last_name)),
                'ic' => $request->ic,
                'phoneno' => $request->phoneno,
                'email' => $request->email
            ));

            // Start Receipt
            $filename = $request->file('receipt_path');
            if($filename != '')
            {   
                $extension = $filename->getClientOriginalExtension();
                
                if($extension == 'jpeg' || $extension == 'jpg' || $extension == 'png' || $extension == 'pdf' || $extension == 'JPEG' || $extension == 'JPG' || $extension == 'PNG' || $extension == 'PDF')
                {
                    $name = $filename->getClientOriginalName();
                    $uniqe = 'RE'. uniqid() . '.' . $extension;
                    $dirpath = public_path('assets/receipts/');
                    $filename->move($dirpath, $uniqe); 

                    $receipt_name = 'assets/receipts/'.$uniqe;
                } else {
                    return redirect()->back()->with('error','Not valid file. Please insert pdf, jpeg, jpg & png only.');
                }
            } else {
                $receipt_name = NULL;
            }
            // End Receipt

            $payment_id = 'OD'.uniqid();

            Payment::create(array(
                'payment_id'=> $payment_id,
                'pay_price'=> $request->pay_price,
                'totalprice'=> $request->totalprice,
                'quantity' => $request->quantity,
                'status' => 'paid',
                'pay_method' => 'Manual',
                'email_status'  => 'Hold',
                'stud_id' => $stud_id,
                'product_id' => $product_id,
                'package_id' => $package_id,
                'offer_id' => $request->offer_id,
                'user_id' => Auth::user()->user_id,
                'pay_datetime' => $request->pay_datetime,
                'pic' => $request->pic,
                'receipt_path' => $receipt_name
            ));

        }

        return redirect('view/buyer/'.$product_id.'/'.$package_id)->with('addsuccess','Customer Successfully Added!');
    }
    
    public function trackpayment($product_id, $package_id, $payment_id, $student_id)
    {
        $paginate = Payment::where('product_id', $product_id)->paginate(15);
        $student = Student::where('stud_id', $student_id)->first();
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $payment = Payment::where('payment_id', $payment_id)->first();
        $ticket = Ticket::where('ic', $student->ic)->where('payment_id')->first();

        $counter = Student::count();
        
        return view('admin.reports.trackpayment', compact('paginate', 'product', 'package', 'payment', 'ticket', 'student', 'counter'));
    }

    public function updatepayment($product_id, $package_id, $payment_id, $student_id, Request $request)
    {
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $payment = Payment::where('payment_id', $payment_id)->first();
        $student = Student::where('stud_id', $student_id)->first();

        $student->ic = $request->ic;
        $student->phoneno = $request->phoneno;
        $student->first_name = ucwords(strtolower($request->first_name));
        $student->last_name = ucwords(strtolower($request->last_name));
        $student->email = $request->email;
        $student->save();

        $payment->attendance = $request->attendance;
        $payment->status = $request->status;
        $payment->offer_id = $request->offer_id;
        $payment->save();

        return redirect('view/buyer/'.$product_id.'/'.$package_id)->with('updatepayment','Customer Successfully Updated!');
    }

    // search buyer
    public function search($product_id, $package_id, Request $request)
    {   
        // $payment = Payment::orderBy('id','desc')->where('product_id', $product_id)->where('package_id', $package_id)->paginate(15);
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $student = Student::orderBy('id','desc')->get();
        $offer = Offer::orderBy('id','desc')->get();

        //Count the data
        $count = 1;
        $total = Payment::where('product_id', $product_id)->where('package_id', $package_id)->count();
        $totalsuccess = Payment::where('status','paid')->where('product_id', $product_id)->where('package_id', $package_id)->count();
        $totalcancel = Payment::where('status','due')->where('product_id', $product_id)->where('package_id', $package_id)->count();
        $paidticket = Ticket::where('ticket_type', 'paid')->where('product_id', $product_id)->where('package_id', $package_id)->count();
        $freeticket = Ticket::where('ticket_type', 'free')->where('product_id', $product_id)->where('package_id', $package_id)->count();

        //get details from search
        $student_id = Student::where('ic', $request->search)->orWhere('first_name', $request->search)->orWhere('last_name', $request->search)->orWhere('email', $request->search)->first();
        $attendance_id = Payment::where('attendance',$request->kehadiran)->first();

        if ($student_id == NULL)
        {
            return redirect()->back()->with('search-error', 'Buyer not exist!');

        }else{

            $stud_id = $student_id->stud_id;

            $payment = Payment::where('stud_id','LIKE','%'. $stud_id.'%')->where('product_id', $product_id)->where('package_id', $package_id)->paginate(15);

            if(count($payment) > 0)
            {
                return view('admin.reports.viewbypackage', compact('product', 'package', 'payment', 'student', 'offer', 'count', 'total', 'totalsuccess', 'totalcancel', 'paidticket', 'freeticket'));

            }else{

                return redirect()->back()->with('search-error', 'Buyer not found!');

            }

        }  
        
    }

    public function attendance($product_id, $package_id, Request $request, $attendance)
    {   
        // $payment = Payment::orderBy('id','desc')->where('product_id', $product_id)->where('package_id', $package_id)->paginate(15);
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $student = Student::orderBy('id','desc')->get();
        $offer = Offer::orderBy('id','desc')->get();

        //Count the data
        $count = 1;
        $total = Payment::where('product_id', $product_id)->where('package_id', $package_id)->count();
        $totalsuccess = Payment::where('status','paid')->where('product_id', $product_id)->where('package_id', $package_id)->count();
        $totalcancel = Payment::where('status','due')->where('product_id', $product_id)->where('package_id', $package_id)->count();
        $paidticket = Ticket::where('ticket_type', 'paid')->where('product_id', $product_id)->where('package_id', $package_id)->count();
        $freeticket = Ticket::where('ticket_type', 'free')->where('product_id', $product_id)->where('package_id', $package_id)->count();

        //get details from search
        $student_id = Student::where('ic', $request->search)->orWhere('first_name', $request->search)->orWhere('last_name', $request->search)->orWhere('email', $request->search)->first();
        $attendance_id = Payment::where('product_id',$product_id)->where('package_id',$package_id)->where('attendance',$request->kehadiran)->get();

        if($attendance_id->isEmpty())
        {
            return redirect('view/buyer/'. $product_id . '/' .$package_id)->with('search-error', 'Buyer not exist!');

        }else{
            
            foreach ($attendance_id as $attend_id) 
            {
                $att_id = $attend_id->attendance;

                $payment = Payment::where('attendance', $attendance)->where('product_id', $product_id)->where('package_id', $package_id)->paginate(15);

                return view('admin.reports.viewbypackage', compact('product', 'package', 'payment', 'student', 'offer', 'count', 'total', 'totalsuccess', 'totalcancel', 'paidticket', 'freeticket'));
            }
        }
    }

    public function purchased_mail($product_id, $package_id, $payment_id, $student_id)
    {
        /*-- Manage Email ---------------------------------------------------*/

        $payment = Payment::where('payment_id', $payment_id)->where('product_id', $product_id)->where('package_id', $package_id)->first();
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $student = Student::where('stud_id', $student_id)->first();

        $send_mail = $student->email;
        $product_name = $product->name;  
        $package_name = $package->name;        
        $date_from = $product->date_from;
        $date_to = $product->date_to;
        $time_from = $product->time_from;
        $time_to = $product->time_to;
        $packageId = $package_id;
        $payment_id = $payment->payment_id;
        $productId = $product_id;        
        $student_id = $student->stud_id;

        // change email status
        $payment->email_status = 'Sent';

        dispatch(new PengesahanJob($send_mail, $product_name, $package_name, $date_from, $date_to, $time_from, $time_to, $packageId, $payment_id, $productId, $student_id));

        $payment->save();

        return redirect()->back()->with('purchased-sent', 'Purchased confirmation email has been sent successfully') ;
    }

    /*-- Participant ---------------------------------------------------*/
    public function paid_ticket($product_id, $package_id)
    {
        //Get the details
        // $ticket = Ticket::orderBy('id','desc')->where('product_id', $product_id)->where('package_id', $package_id)->where('ticket_type', 'paid')->paginate(15);
        $ticket = Ticket::orderBy('id','desc')->where('product_id', $product_id)->where('package_id', $package_id)->paginate(15);
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $student = Student::orderBy('id','desc')->get();

        //Count the data
        $count = 1;        
        $paidticket = Ticket::where('ticket_type', 'paid')->where('product_id', $product_id)->where('package_id', $package_id)->count();
        $freeticket = Ticket::where('ticket_type', 'free')->where('product_id', $product_id)->where('package_id', $package_id)->count();
        
        return view('admin.reports.participant', compact('ticket', 'product', 'package', 'student', 'count', 'paidticket', 'freeticket'));
    }

    public function export_paid($product_id, $package_id)
    {
        $ticket = Ticket::where('product_id', $product_id)->where('package_id', $package_id)->where('ticket_type','paid')->get();
        $student = Student::orderBy('id','desc')->get();
        $product = Product::where('product_id', $product_id)->first();
        $package_name = Package::where('product_id', $product_id)->where('package_id', $package_id)->first();
        $package = Package::where('product_id', $product_id)->where('package_id', $package_id)->get();

        // return (new FastExcel($ticket, $student, $product, $package))->download('paid.xlsx');
        // return Excel::download(new PaidTicket_Export($ticket, $student, $package), $package_name->name.'_paid.xlsx');

        /*-- Manage Email ---------------------------------------------------*/
        $fileName = $package_name->name.'_paid.csv';
        $columnNames = [
            'Ticket ID',
            'First Name',
            'Last Name',
            'IC No',
            'Phone No',
            'Email',
            'Package',
            'Ticket Type',
            'Registered At'
        ];
        
        $file = fopen(public_path('export/') . $fileName, 'w');
        fputcsv($file, $columnNames);
        
        foreach ($student as $students) {
            foreach($ticket as $tickets){
                foreach($package as $packages){
                    if($tickets->ic == $students->ic){
                        if($tickets->package_id == $packages->package_id){

                            fputcsv($file, [
                                $tickets->ticket_id,
                                $students->first_name,
                                $students->last_name,
                                $students->ic,
                                $students->phoneno,
                                $students->email,
                                $packages->name,
                                $tickets->ticket_type,
                                $tickets->created_at,
                            ]);

                        }
                    }
                }
            }
            
        }
        
        fclose($file);

        
        Mail::send('emails.export_mail', [], function($message) use ($fileName)
        {
            $message->to(Auth::user()->email)->subject('ATTACHMENT OF PARTICIPANT DETAILS');
            $message->attach(public_path('export/') . $fileName);
        });

        return redirect('view/participant/'.$product_id.'/'.$package_id)->with('export-paid','The data will be sent to your email. It may take a few minutes to successfully received.');

    }

    public function save_participant($product_id, $package_id, Request $request)
    { 
        $student = Student::where('ic', $request->ic)->first();
        
        if(Student::where('ic', $request->ic)->exists()){

            $ticket_id = 'TIK' . uniqid();

            Ticket::create([
                'ticket_id'     => $ticket_id,
                'ticket_type'   => $request->ticket_type,
                'ic'            => $request->ic,
                'email_status'  => 'Hold',
                'stud_id'       => $student->stud_id,
                'product_id'    => $product_id,
                'package_id'    => $package_id
            ]);

        }else{

            $stud_id = 'MI'.uniqid();
            
            Student::create(array(
                'stud_id'=> $stud_id,
                'first_name'=> ucwords(strtolower($request->first_name)),
                'last_name'=> ucwords(strtolower($request->last_name)),
                'ic' => $request->ic,
                'phoneno' => $request->phoneno,
                'email' => $request->email
            ));

            $ticket_id = 'TIK' . uniqid();

            Ticket::create([
                'ticket_id'     => $ticket_id,
                'ticket_type'   => $request->ticket_type,
                'ic'            => $request->ic,
                'email_status'  => 'Hold',
                'stud_id'       => $stud_id,
                'product_id'    => $product_id,
                'package_id'    => $package_id
            ]);
        }

        return redirect('view/participant/'.$product_id.'/'.$package_id)->with('addsuccess','Customer Successfully Added!');
    }

    public function import_participant($product_id, $package_id)
    {
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        return view('admin.reports.import_participant', compact('product', 'package'));
    }

    public function participant_format($product_id, $package_id)
    {
        return Excel::download(new ParticipantFormat, 'Participant.xlsx');
    }

    function store_participant($product_id, $package_id)
    {
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();

        $prd_id = $product->product_id;
        $pkd_id = $package->package_id;
        $user_id = Auth::user()->user_id;

        Excel::import(new ParticipantImport($prd_id, $pkd_id, $user_id), request()->file('file'));

        return redirect('view/participant/'.$product_id.'/'.$package_id)->with('importsuccess', 'The file has been inserted to queue, it may take a while to successfully import.');
    }

    public function track_ticket($product_id, $package_id, $ticket_id)
    {
        //Get the details
        $ticket = Ticket::where('ticket_id', $ticket_id)->where('product_id', $product_id)->where('package_id', $package_id)->first();
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $student = Student::where('ic', $ticket->ic)->first();
        $payment = Payment::where('payment_id', $ticket->payment_id)->first();
        $buyer = Student::where('stud_id', $payment->stud_id)->first();

        //Count the data
        $count = 1;
        
        return view('admin.reports.trackticket', compact('ticket', 'product', 'package', 'student', 'payment', 'buyer', 'count'));
    }

    //upload receipt for existing data participant (modal)
    public function update_receipt($product_id, $package_id, $ticket_id, Request $request)
    {
        //Get the details
        $ticket = Ticket::where('ticket_id', $ticket_id)->where('product_id', $product_id)->where('package_id', $package_id)->first();
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $student = Student::where('ic', $ticket->ic)->first();
        
        // Start receipt
        $filename = $request->file('receipt_path');
        $extension = $filename->getClientOriginalExtension();
        
        if($extension == 'jpeg' || $extension == 'jpg' || $extension == 'png' || $extension == 'pdf' || $extension == 'JPEG' || $extension == 'JPG' || $extension == 'PNG' || $extension == 'PDF')
        {
            $name = $filename->getClientOriginalName();
            $uniqe = 'UP_RE' . uniqid() . '.' . $extension;
            $dirpath = public_path('assets/receipts/');
            $filename->move($dirpath, $uniqe);
            $receipt_name = 'assets/receipts/'.$uniqe;

            $ticket->receipt_path = $receipt_name;
            $ticket->save();

            return redirect()->back()->with('uploadSuccess','Receipt has been successfully saved!');
        } else {
            return redirect()->back()->with('error','Not valid file. Please insert pdf, jpeg, jpg & png only.');
        }
        // End receipt
    }

    public function update_ticket($product_id, $package_id, $ticket_id, $student_id, Request $request)
    {
        //Get the details
        $ticket = Ticket::where('ticket_id', $ticket_id)->where('product_id', $product_id)->where('package_id', $package_id)->first();
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $student = Student::where('stud_id', $student_id)->first();

        $student->ic = $request->ic;
        $student->phoneno = $request->phoneno;
        $student->first_name = ucwords(strtolower($request->first_name));
        $student->last_name = ucwords(strtolower($request->last_name));
        $student->email = $request->email;

        $student->save();

        return redirect('view/participant/'.$product_id.'/'.$package_id)->with('update-paid','Customer Successfully Updated!');
    }

    public function destroy_ticket($ticket_id, $product_id, $package_id) 
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->where('product_id', $product_id)->where('package_id', $package_id);
        $ticket->delete();

        return redirect('view/participant/'.$product_id.'/'.$package_id)->with('deleteticket', 'Participant successfully deleted');
    }

    public function track_paid($product_id, $package_id, $ticket_id)
    {
        //Get the details
        $ticket = Ticket::where('ticket_id', $ticket_id)->where('product_id', $product_id)->where('package_id', $package_id)->first();
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $student = Student::where('ic', $ticket->ic)->first();

        //Count the data
        $count = 1;
        
        return view('admin.reports.trackpaidticket', compact('ticket', 'product', 'package', 'student', 'count'));
    }

    public function update_paid($product_id, $package_id, $ticket_id, $student_id, Request $request)
    {
        //Get the details
        $ticket = Ticket::where('ticket_id', $ticket_id)->where('product_id', $product_id)->where('package_id', $package_id)->first();
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $student = Student::where('stud_id', $student_id)->first();

        $student->ic = $request->ic;
        $student->phoneno = $request->phoneno;
        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->email = $request->email;
        $student->save();

        return redirect('view/participant/'.$product_id.'/'.$package_id)->with('update-paid','Customer Successfully Updated!');
    }

    // search paid participant
    public function search_participant($product_id, $package_id, Request $request)
    {   
        //Get the details
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $student = Student::orderBy('id','desc')->get();

        //Count the data
        $count = 1;        
        $paidticket = Ticket::where('ticket_type', 'paid')->where('product_id', $product_id)->where('package_id', $package_id)->count();
        $freeticket = Ticket::where('ticket_type', 'free')->where('product_id', $product_id)->where('package_id', $package_id)->count();

        //get details from search
        $student_id = Student::where('ic', $request->search)->orWhere('first_name', $request->search)->orWhere('last_name', $request->search)->orWhere('email', $request->search)->first();
        
        if ($student_id == NULL)
        {

            return redirect()->back()->with('search-error', 'Participant not exist!');

        }else{
            
            $stud_id = $student_id->stud_id;

            $ticket = Ticket::where('stud_id','LIKE','%'. $stud_id.'%')->where('product_id', $product_id)->where('package_id', $package_id)->get();

            if(count($ticket) > 0)
            {
            
                return view('admin.reports.participant', compact('ticket', 'product', 'package', 'student', 'count', 'paidticket', 'freeticket'));

            }else{

                return redirect()->back()->with('search-error', 'Participant not found!');

            }
        }
    }

    public function free_ticket($product_id, $package_id)
    {
        //Get the details
        $ticket = Ticket::orderBy('id','desc')->where('product_id', $product_id)->where('package_id', $package_id)->where('ticket_type', 'free')->paginate(100);
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $student = Student::orderBy('id','desc')->get();

        //Count the data
        $count = 1;
        
        return view('admin.reports.freeticket', compact('ticket', 'product', 'package', 'student', 'count'));
    }

    public function export_free($product_id, $package_id)
    {
        $ticket = Ticket::where('product_id', $product_id)->where('package_id', $package_id)->where('ticket_type','free')->get();
        $student = Student::orderBy('id','desc')->get();
        $product = Product::where('product_id', $product_id)->first();
        $package_name = Package::where('product_id', $product_id)->where('package_id', $package_id)->first();
        $package = Package::where('product_id', $product_id)->where('package_id', $package_id)->get();

        /*-- Manage Email ---------------------------------------------------*/
        $fileName = $package_name->name.'_free.csv';
        $columnNames = [
            'Ticket ID',
            'First Name',
            'Last Name',
            'IC No',
            'Phone No',
            'Email',
            'Package',
            'Ticket Type',
            'Registered At'
        ];
        
        $file = fopen(public_path('export/') . $fileName, 'w');
        fputcsv($file, $columnNames);
        
        foreach ($student as $students) {
            foreach($ticket as $tickets){
                foreach($package as $packages){
                    if($tickets->ic == $students->ic){
                        if($tickets->package_id == $packages->package_id){

                            fputcsv($file, [
                                $tickets->ticket_id,
                                $students->first_name,
                                $students->last_name,
                                $students->ic,
                                $students->phoneno,
                                $students->email,
                                $packages->name,
                                $tickets->ticket_type,
                                $tickets->created_at,
                            ]);

                        }
                    }
                }
            }
            
        }
        
        fclose($file);

        
        Mail::send('emails.export_mail', [], function($message) use ($fileName)
        {
            $message->to(Auth::user()->email)->subject('ATTACHMENT OF PARTICIPANT DETAILS');
            $message->attach(public_path('export/') . $fileName);
        });

        return redirect('free-ticket/'.$product_id.'/'.$package_id)->with('export-free','The data will be sent to your email. It may take a few minutes to successfully received.');

    }

    public function track_free($product_id, $package_id, $ticket_id)
    {
        //Get the details
        $ticket = Ticket::where('ticket_id', $ticket_id)->where('product_id', $product_id)->where('package_id', $package_id)->first();
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $student = Student::where('ic', $ticket->ic)->first();

        //Count the data
        $count = 1;
        
        return view('admin.reports.trackfreeticket', compact('ticket', 'product', 'package', 'student', 'count'));
    }

    public function update_free($product_id, $package_id, $ticket_id, $student_id, Request $request)
    {
        //Get the details
        $ticket = Ticket::where('ticket_id', $ticket_id)->where('product_id', $product_id)->where('package_id', $package_id)->first();
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $student = Student::where('stud_id', $student_id)->first();

        $student->ic = $request->ic;
        $student->phoneno = $request->phoneno;
        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->email = $request->email;
        $student->save();

        return redirect('free-ticket/'.$product_id.'/'.$package_id)->with('update-free','Customer Successfully Updated!');
    }

    // search free participant
    public function search_free($product_id, $package_id, Request $request)
    {   
        //Get the details
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $student = Student::orderBy('id','desc')->get();

        //Count the data
        $count = 1;

        $ticket = Ticket::where('ic','LIKE','%'. $request->search .'%')->where('product_id', $product_id)->where('package_id', $package_id)->where('ticket_type', 'free')->get();

        if(count($ticket) > 0)
        {
            return view('admin.reports.freeticket', compact('ticket', 'product', 'package', 'student', 'count'));

        }else{

            return redirect()->back()->with('search-error', 'Customer not found!');

        }
    }

    public function updated_mail($product_id, $package_id, $ticket_id, $student_id)
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->where('product_id', $product_id)->where('package_id', $package_id)->first();
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $student = Student::where('stud_id', $student_id)->first();

        $email = $student->email; 
        $product_name = $product->name;
        $package_name = $package->name; 
        $date_from = $product->date_from;
        $date_to = $product->date_to;
        $time_from = $product->time_from;
        $time_to = $product->time_to;
        $packageId = $package_id;
        $productId = $product_id;        
        $student_id = $student->stud_id;
        $survey_form = $product->survey_form;

        // change email status
        $ticket->email_status = 'Sent';
                
        dispatch(new TiketJob($email, $product_name, $package_name, $date_from, $date_to, $time_from, $time_to, $packageId, $productId, $student_id, $ticket_id, $survey_form));
        
        $ticket->save();
        
        return redirect()->back()->with('updated-sent', 'Participant confirmation email has been sent successfully') ;
    }

    //upload receipt for existing data buyer (modal)
    public function uploadFile($product_id, $package_id, $payment_id, $student_id, Request $request)
    {
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $payment = Payment::where('payment_id', $payment_id)->first();
        $student = Student::where('stud_id', $student_id)->first();

        // Start receipt
        $filename = $request->file('receipt_path');
        $extension = $filename->getClientOriginalExtension();
        
        if($extension == 'jpeg' || $extension == 'jpg' || $extension == 'png' || $extension == 'pdf' || $extension == 'JPEG' || $extension == 'JPG' || $extension == 'PNG' || $extension == 'PDF')
        {
            $name = $filename->getClientOriginalName();
            $uniqe = 'RE'. uniqid() . '.' . $extension;
            $dirpath = public_path('assets/receipts/');
            $filename->move($dirpath, $uniqe);
            $receipt_name = 'assets/receipts/'.$uniqe;

            $payment->receipt_path = $receipt_name;
            $payment->save();

            return redirect()->back()->with('uploadSuccess','Receipt has been successfully saved!');
        } else {
            return redirect()->back()->with('error','Not valid file. Please insert pdf, jpeg, jpg & png only.');
        }
        // End receipt
    }

    public function search_report($product_id, Request $request)
    {
        // $search = Payment::where('product_id', $product_id)->get();
        $payment = Payment::where('product_id', $product_id)->get();
        $product = Product::where('product_id', $product_id)->first();

        // $product = Product::where('product_id', $product_id)->first();

        $productfirst = Payment::where('status', 'paid')->where('product_id', $product)->orderBy('created_at', 'asc')->first();
        $test = $productfirst->created_at->format('Y-m-d H:i:s');

        $hingga = Carbon::now('Asia/Kuala_Lumpur')->format('Y-m-d H:i:s');
        $dari = $test;

        $data = Payment::where('status', 'paid')->where('product_id', $product_id)->whereBetween('created_at', [ $dari , $hingga ])->orderBy('created_at', 'desc')
                    ->get()
                    ->groupBy(function($val) {
                    return Carbon::parse($val->created_at)->format('Y-m-d','[A-Za-z0-9-]+');
                    });

        $start_date = Carbon::parse($request->start_date)->toDateTimeString();
        $end_date = Carbon::parse($request->end_date)->toDateTimeString();
        $exact_date = Carbon::parse()->toDateTimeString();

        $searchresult = Payment::whereBetween('created_at',[$start_date,$end_date])->get();

        return redirect()->back()->with('Search Found', 'List of buyer based on the date') ;
    }
}
