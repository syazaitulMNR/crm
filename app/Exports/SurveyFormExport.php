<?php

namespace App\Exports;

use DB;
use App\Student;
use App\Product;
use App\Ticket;
use App\BusinessDetail;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Session;


class SurveyFormExport implements FromView
{
    public function view(): View
    {
        $product_id = Session::get('product_id');

        // $product = DB::table('product')->where('product_id',$product_id)->first();
        $product = Product::where('product_id', $product_id)->first();
        $student = Student::orderBy('id','desc')->get();
        // $student = DB::table('student')->get();
        // $ticket = DB::table('ticket')->where('ticket_type','paid')->where('product_id', $product_id)->get();
        // $ticket = Ticket::orderBy('id','desc')->where('product_id', $product_id)->get();
        $ticket = DB::table('ticket')->where('product_id', $product_id)->get(); 
        $business = DB::table('business_details')->get();
        // $business = BusinessDetail::orderBy('id','desc')->get();


        return view('admin.reports.download_surveyform',compact('product','student','ticket','business'));
    }
}