<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Student;
use App\User;
use App\Product;
use App\Package;
use App\Payment;
use Mail;
use PDF;

class StudentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | StudentController
    |--------------------------------------------------------------------------
    |   This controller is for managing the 
    |   customer in admin panel
    | 
    */

    public function __construct()
    {
        $this->middleware('auth');
    }

    /*-- Manage student ----------------------------------------------------------------*/
    // public function select_event(){
    //     $student = Student::orderBy('id','desc')->get();
    //     $product = Product::orderBy('id','asc')->paginate(15);
    //     $package = Package::orderBy('id','asc')->get();
    //     $payment = Payment::orderBy('id','asc')->get(); 

    //     // $totalcust = Student::count();
    //     // $totalpay = Payment::count();

    //     return view('admin.students.select_event', compact('student','product','package', 'payment'));
    // }

    // public function select_package($product_id){

    //     $product = Product::where('product_id', $product_id)->first();
    //     $package = Package::where('product_id', $product_id)->paginate(15);
    //     return view('admin.students.select_package', compact('product', 'package'));

    // }

    public function addstudents($product_id, $package_id)
    {
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        
        return view('admin.students.adddetails', compact('product','package'));
    }

    /*--                                   --------------------------------------*/
    public function getpackage($id) 
    {        
        $package = Package::where('package_id',$id)->get();
        return json_encode($package);
    }

    public function details($product_id, $package_id, Request $request)
    { 
        echo 'simpan';
        // $studId = uniqid();
        
        // Student::create(array(
        //     'stud_id'=> $studId,
        //     'name'=> $request->name,
        //     'ic' => $request->ic,
        //     'phoneno' => $request->phoneno,
        //     'email' => $request->email
        // ));

        // return redirect('viewstudents')->with('addsuccess','Customer Successfully Created!');
    }

    public function viewstudents()
    {
        $student = Student::orderBy('id','desc')->paginate(15);
        // $product = Product::orderBy('id', 'desc')->get();
        // $package = Package::orderBy('id', 'desc')->first();
        //$user = User::where('product_id', $id)->first();
        
        return view('admin.students.viewstudents', compact('student'));
    }

    public function viewdetails($id)
    {
        $student = Student::where('stud_id', $id)->first();
        $payment = Payment::where('stud_id', $id)->get();
        $product = Product::where('product_id', $student->product_id)->first();
        // $package = Package::where('package_id', $payment->package_id)->first();
        
        return view('admin.students.viewdetails', compact('student', 'payment', 'product'));    
    }

    public function editdetails($id, Request $request)
    {
        $student = Student::where('stud_id', $id)->first();        

        $student->name = $request->name;
        $student->ic = $request->ic;
        $student->address = $request->address;
        $student->phoneno = $request->phoneno;
        $student->birthdate = $request->birthdate;
        $student->gender = $request->gender;
        $student->company = $request->company;
        $student->position = $request->position;
        $student->salary = $request->salary;

        $student->save();

        return redirect('viewstudents')->with('success','Customer updated successfully!');      
    }

    public function destroystud($id)
    {
        $student = Student::where('stud_id', $id);
        
        $student->delete();
        return back()->with('delete','Customer Successfully Deleted!');
    }

    /*-- Manage email from admin panel --------------------------------------*/
    public function sendEmail($id)
    {
        $payment = Payment::where('stud_id', $id)->first();
        $student = Student::where('stud_id', $id)->first();

        $product = Product::where('product_id', $payment->product_id)->first();
        $package = Package::where('package_id', $payment->package_id)->first();
        
        $to_name = 'noreply@momentuminternet.com';
        $to_email = $student->email; 
        
        $data['name']=$student->name;
        $data['ic']=$student->ic;
        $data['email']=$student->email;
        $data['phoneno']=$student->phoneno;
        $data['total']=$payment->totalprice;
        $data['quantity']=$payment->quantity;

        $data['package_id']=$package->package_id;
        $data['package']=$package->name;
        $data['price']=$package->price;

        $data['date_receive']=date('d-m-Y');
        $data['payment_id']=$payment->payment_id;
        $data['product_id']=$product->product_id;        
        $data['student_id']=$id;
        
        $pdf = PDF::loadView('emails.receipt', $data);

        Mail::send('emails.mail', $data, function($message) use ($to_name, $to_email, $pdf) 
        {
            $message->to($to_email, $to_name)->subject('Pengesahan Pembelian');
            $message->from('noreply@momentuminternet.my','noreply');
            $message->attachData($pdf->output(), "Receipt.pdf");

            $test_message = array();
        });

        return back()->with('success','Email successfully sent!');
    }

}
