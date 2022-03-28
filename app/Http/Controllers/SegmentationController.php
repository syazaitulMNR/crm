<?php

namespace App\Http\Controllers;

use App\Segmentation;
use Illuminate\Http\Request;
use App\Product;
use App\Package;
use App\Payment;
use App\Student;
use App\Feature;
use App\Offer;
use App\BusinessDetail;
use DB;

class SegmentationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $segment = Segmentation::orderBy('id','asc')->get();
        
        return view('admin.segmentation', compact('segment'));
    }

    public function updateclass($id, Request $request)
    {
        $segdata = Segmentation::where('id',$id)->first();

        $segdata->name = $request->name;
        $segdata->description = $request->description;
        $segdata->classification = $request->classification;

        $segdata->save();
        
        return redirect('segmentation')->with('success', 'Success!');
    }

    public function classdata($id ,Request $request)
    {
        // $a = DB::table('Payment')
        //     ->join('student','student.stud_id','=','payment.stud_id')
        //     ->select('student.stud_id')
        //     ->first();


        // $cdn = DB::table('Segmentations')
        //     ->join('product','product.class','=','segmentations.name')
        //     ->select('product.product_id','product.name')
        //     ->get();

        // $cdp = DB ::table('Product')
        //     ->join('payment','payment.product_id','=','product.product_id')
        //     ->select('payment.stud_id')
        //     ->get();
        
        // $cdd = DB::table('Payment')
        //     ->join('student','student.stud_id','=','payment.stud_id')
        //     ->select('student.first_name','student.last_name','student.ic','student.email','student.phoneno')
        //     ->get();

        $a = Segmentation::where('id', $id)->first();
        $cdn =  Product::where('class', $a->name)->pluck('product_id');

        for ($i=0; $i <count($cdn) ; $i++) { 
            $cdp[$i] = Payment::where('status','paid')->where('product_id',$cdn)->get();
        }

        $stud =DB::table('student')->get();

        foreach ($cdp as $cdpkey => $cdpdata){
            foreach ($stud as $kstud => $studval){
                foreach ($cdpdata as $key => $cdpval){
                    if ($studval->stud_id == $cdpval->stud_id){
                        $test = $studval;    
                    }
                }
            }
        }


        // $cdp =  ;
        // $cdd =  ;    
        return view('admin.classdata', compact('a','cdn','stud','test'));

        
    }   
    /** 
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Segmentation::create(array(
            'name' => $request->name,
            'description' => $request->description,
            'classification' => $request->classification
        ));  

        return redirect()->back()->with('success', 'Success!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\segmentation  $segmentation
     * @return \Illuminate\Http\Response
     */
    public function show(segmentation $segmentation)
    {

    }

    public function edit($id)
    {
        $segment = Segmentation::where('id',$id)->first();

        return view('admin.updateclass', compact('segment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\segmentation  $segmentation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, segmentation $segmentation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\segmentation  $segmentation
     * @return \Illuminate\Http\Response
     */
    public function destroy(segmentation $segmentation)
    {
        //
    }
}
