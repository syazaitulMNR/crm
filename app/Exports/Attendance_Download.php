<?php

namespace App\Exports;

use App\Student;
use App\Product;
use App\Package;
use App\Payment;
use App\Ticket;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Session;
// use Maatwebsite\Excel\Concerns\FromCollection;

// class StudentExport implements FromCollection
class Attendance_Download implements FromView
{
    public function view(): View
    {
        $product_id = Session::get('product_id');
        $package_id = Session::get('package_id');

        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $payment = Payment::where('status','paid')->where('product_id',$product_id)->where('attendance','kehadiran disahkan')->get();
        $ticket = Ticket::where('ticket_type','paid')->where('product_id',$product_id)->where('attendance','kehadiran disahkan')->get();
        
        for ($i=0; $i < count($payment) ; $i++) { 
            $studentpay[$i] = Student::where('stud_id', $payment[$i]->stud_id)->get();
        }
        
        if(count($ticket) == 0){
            return view('admin.reports.download_attendance',compact('product','package','payment','ticket','studentpay'));

        }
        else{
            for ($i=0; $i < count($ticket) ; $i++) { 
                $studenttic[$i] = Student::where('stud_id', $ticket[$i]->stud_id)->get();
            }
            return view('admin.reports.download_attendance',compact('product','package','payment','ticket','studentpay','studenttic'));

        }
    }
}
