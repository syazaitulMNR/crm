<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Student;
use PDF;

class CertController extends Controller
{
    /*-- Check IC Page -----------------------------------------------*/
    public function ic_check($product_id)
    {
        // $package = Package::where('package_id', $package_id)->first();
        $product = Product::where('product_id', $product_id)->first();

        return view('certificate.get_ic', compact('product'));
    }

    public function checking_ic($product_id, Request $request)
    {
        // Check if ic exist
        if(Student::where('ic', $request->ic)->exists()){
            
            $student = Student::where('ic', $request->ic)->first();
            return redirect('get-cert/' . $product_id . '/'.$student->stud_id);

        }else{

            return view('certificate.not_found');

        }
    }

    public function get_cert($product_id, $stud_id)
    {
        $product = Product::where('product_id', $product_id)->first();
        $student = Student::where('stud_id', $stud_id)->first();

        return view('certificate.e-cert', compact('product', 'student'));
    }

    public function extract_cert($product_id, $stud_id){
        $product = Product::where('product_id', $product_id)->first();
        $student = Student::where('stud_id', $stud_id)->first();
                
        $data['name']=$student->first_name;
        $data['ic']=$student->ic;

        $data['program_name']=$product->name;

        $data['date_receive']=date('d-m-Y');
        $data['product_id']=$product_id;        
        $data['student_id']=$stud_id;

        $pdf = PDF::loadView('certificate.cert', $data);
        return $pdf->download( $product->name . '.pdf');
    }

}
