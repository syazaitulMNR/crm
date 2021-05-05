<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Student;

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
            echo 'student ada';
            // return redirect('langkah-pertama/' . $product_id . '/' . $package_id .'/'.$student->stud_id);

        }else{

            // return redirect('regnewstudent/'. $product_id . '/' . $package_id . '/' . $request->ic);
            echo 'student tak ada';
            // return redirect('maklumat-pembeli/'. $product_id . '/' . $package_id . '/' . $request->ic);

        }
    }
}
