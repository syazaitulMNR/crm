<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;

class MembershipController extends Controller
{
    public function view()
    {
        $student = Student::orderBy('id','desc')->get();

        // $total = Payment::where('product_id', $product_id)->where('package_id', $package_id)->count();
        // $totalsuccess = Payment::where('status','paid')->where('product_id', $product_id)->where('package_id', $package_id)->count();
        // $totalcancel = Payment::where('status','due')->where('product_id', $product_id)->where('package_id', $package_id)->count();
        
        return view('admin.membership.view', compact('student'));
    }
}
