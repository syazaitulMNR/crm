<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Student;
use App\Payment;
use PDF;

class CertController extends Controller
{
    /*-- Check IC Page -----------------------------------------------*/
    public function ic_check($product_id)
    {
        $product = Product::where('product_id', $product_id)->first();

        return view('certificate.get_ic', compact('product'));
    }

    public function checking_ic($product_id, Request $request)
    {
        $student = Student::where('ic', $request->ic)->first();
        $payment = Payment::where('stud_id', $student->stud_id)->where('product_id', $product_id)->first();
        
        // Check if ic exist
        if($student->stud_id == $payment->stud_id){
            
            dd($student);
            // return redirect('check-cert/' . $product_id . '/' . $student->stud_id);

        }else{

            return view('certificate.not_found');

        }
    }

    public function checking_cert($product_id, $stud_id)
    {
        $product = Product::where('product_id', $product_id)->first();
        $student = Student::where('stud_id', $stud_id)->first();
        // $payment = Payment::where('product_id', $product_id)->where('stud_id', $stud_id)->first();

        return view('certificate.check_detail', compact('product', 'student'));
    }

    public function extract_cert($product_id, $stud_id){
        $product = Product::where('product_id', $product_id)->first();
        $student = Student::where('stud_id', $stud_id)->first();
                
        $data['first_name']=$student->first_name;
        $data['last_name']=$student->last_name;
        $data['ic']=$student->ic;

        $data['program_name']=$product->name;
        $data['cert_image']=$product->cert_image;

        $data['date_from']=date('d/m/Y', strtotime($product->date_from));        
        $data['date_to']=date('d/m/Y', strtotime($product->date_to));
        $data['product_id']=$product_id;        
        $data['student_id']=$stud_id;

        // dd($product->cert_image);

        $pdf = PDF::loadView('certificate.cert', $data);
        return $pdf->download( $product->name . '.pdf');
    }

}
