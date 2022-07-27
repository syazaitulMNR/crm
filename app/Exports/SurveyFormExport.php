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
    private $product_id;

    public function __construct($product_id)
    {
        $this->product_id = $product_id;
    }

    public function view(): View
    {
        
        $business = BusinessDetail::where('product_id', $this->product_id)->get();


        return view('admin.reports.download_surveyform',compact('business'));
    }
}