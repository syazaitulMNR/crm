<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Package;
use App\Student;
use App\Payment;
use App\Ticket;

class customerProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function customerPayment($id, $event_id, Request $request) {
        $customer = Student::where('id', $id)->first();
        $ticket = Ticket::where('ic', $customer['ic'])->get();
        $product = Product::where('product_id', $event_id)->first();
        $payment = Payment::where('product_id', $event_id)
        ->where('stud_id', $customer['stud_id'])->get();

        return view('customer.customer_payment', compact('payment', 'ticket', 'product'));
    }
	
	public function customerProfiles(Request $request) {
        $search = $request->query('search');

        if($search) {
            $customers = Student::where('first_name', 'LIKE', '%'.$search.'%')
            ->orWhere('last_name', 'LIKE', '%'.$search.'%')
            ->orWhere('ic', 'LIKE', '%'.$search.'%')
            ->paginate(10);

        }else {
            $customers = Student::paginate(10);
        }
        
        return view('customer.customer_profiles', compact('customers'));
    }

    public function customerProfile($id, Request $request) {
        $customer = Student::where('id', $id)->first();
        $payment = Payment::where('stud_id', $customer['stud_id'])->get();
        // $package = Package::where('package_id', $payment['package_id'])->first();
        $ticket = Ticket::where('ic', $customer['ic'])->get();
        $data = [];
        
        foreach($ticket as $t) {
            $product = Product::where('product_id', $t->product_id);

            if($product->count() > 0){
                $product = $product->first();
                // $t->product = $product;
                $data[] = $product;
            }
        }
        return view('customer.customer_profile', compact('customer', 'payment', 'data'));
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
