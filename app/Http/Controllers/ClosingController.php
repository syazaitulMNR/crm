<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;
use App\Student;

class ClosingController extends Controller
{
    public function view()
    {
        $payment = Payment::orderBy('id','desc')->paginate(15);
        dd($payment);
        // $student = Student::orderBy('id','desc')->get();
        // return view('admin.closing.view', compact('payment'));
    }
}
