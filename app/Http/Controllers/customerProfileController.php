<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Product;
use App\Offer;
use App\Package;
use App\Student;
use App\Payment;
use App\Income;
use App\Ticket;
use App\Membership_Level;
use App\Comment;
use Carbon\Carbon;
use App\User;
use App\BusinessDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class customerProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    

    public function customerDetails(Request $request) {

        $search = (is_null($request->query('search')) ? "" : $request->query('search'));
        $price = (is_null($request->query('price')) ? "" : $request->query('price'));
        $role = (is_null($request->query('role')) ? "" : $request->query('role'));
        $type = (is_null($request->query('business')) ? "" : $request->query('business'));

        $incomeOptions = Income::all();
        $business_details = [];
        $q = (new BusinessDetail)->newQuery();
        $hasReq = 0;

        // if($request->filled('search')) {
        //     $hasReq = 1;
        //     $search = $request->query('search');

        //     $q->where(function($query) use($search){
        //         $query->where('business_name', 'LIKE', '%'.$search.'%')
        //                 ->orWhere('business_type', 'LIKE', '%'.$search.'%');
        //     });
        // }

        // if($request->filled('type')) {
        //     $hasReq = 1;
        //     $type = $request->query('type');
        //     $q->where('business_name', '=', $type);
        // }

        // if($request->filled('role')) {
        //     $hasReq = 1;
        //     $role = $request->query('role');
        //     $q->where('business_role', '=', $role);
        // }

        // if($request->filled('price')) {
        //     $hasReq = 1;
        //     $price = $request->query('price');
        //     $q->where('business_amount', '=', $price);
        // }

        // if($hasReq) {
        //     $customers = $q->get();
        // }else {
        //     // $customers = BusinessDetail::all();
        //     $customers = DB::table('business_details')->get();
        // }

        // if(count($customers) != 0) {
        //     foreach($customers as $c) {
        //         // $ticketname = Ticket::where('ticket_id', $c->ticket_id);
        //         $ticketname = DB::table('ticket')->where('ticket_id',$c->ticket_id);
        //         if($ticketname->count() > 0) {
        //             $ticketname = $ticketname->first();

        //             // $productname = Product::where('product_id', $ticketname->product_id)->first();
        //             // $user = Student::where('stud_id', $ticketname->stud_id)->first();
        //             $productname = DB::table('product')->where('product_id',$ticketname->product_id)->first();
        //             $user = DB::table('student')->where('stud_id',$ticketname->stud_id)->first();

        //             $c->class = $productname->name;
        //             $c->student = $user;

        //         }else {
        //             $c->class = '';
        //             $c->student = '';
        //         }
        //         $business_details[] = $c;
        //     }
        // }

        // $data = $this->paginate($business_details, 10);
        // $data->setPath('business_details');
        $data = BusinessDetail::all();

        $role = ['Role', 'Stokis', 'Team / Pekerja Syarikat', 'Employee', 'Dropship', 'Agent', 'Founder', 'Lain-lain'];
        $type = ['Type', 'Fashion', 'Makanan', 'Katering & Perkahwinan', 'Kesihatan', 'Kecantikan', 'Pelancongan & Travel', 'Automotif', 'Hartanah', 'Umrah', 'Takaful / Insuran', 'Perunding Kewangan', 'Home Deco & Interior Design', 'Pecetakan / Printing', 'Belum Berniaga', 'Lain-lain'];

        return view('customer.business_details', compact('data', 'incomeOptions', 'role', 'type'));
    }

    public function customerSurveyForm(Request $request) {

        $incomeOptions = Income::all();
        $business_details = [];
        $q = (new BusinessDetail)->newQuery();
        $hasReq = 0;

        $offers = Offer::orderBy('id','desc')->get();
        $prod = Product::orderBy('id','desc')->get();
        $product = Product::orderBy('id','desc')->paginate(15);

        // $data = BusinessDetail::all();
        $data = BusinessDetail::orderBy('id','asc')->paginate(20);

        foreach ($data as $key => $valuedata){
            $ticket = Ticket::where('ticket_id',$valuedata->ticket_id)->first();
            $student = Student::where('ic',$ticket->ic)->first();
        }

        $role = ['Role', 'Stokis', 'Team / Pekerja Syarikat', 'Employee', 'Dropship', 'Agent', 'Founder', 'Lain-lain'];
        $type = ['Type', 'Fashion', 'Makanan', 'Katering & Perkahwinan', 'Kesihatan', 'Kecantikan', 'Pelancongan & Travel', 'Automotif', 'Hartanah', 'Umrah', 'Takaful / Insuran', 'Perunding Kewangan', 'Home Deco & Interior Design', 'Pecetakan / Printing', 'Belum Berniaga', 'Lain-lain'];

        return view('customer.business_details', compact('data', 'incomeOptions', 'role', 'type', 'ticket', 'student', 'offers', 'product', 'prod'));
    }
    public function businessSurveyForm($product_id, Request $request) {

        $incomeOptions = Income::all();
        $business_details = [];
        $q = (new BusinessDetail)->newQuery();
        $hasReq = 0;

        $offers = Offer::orderBy('id','desc')->get();
        $prod = Product::orderBy('id','desc')->get();

        $product = Product::where('product_id',$product_id)->first();

        // $data = BusinessDetail::all();
        $data = BusinessDetail::orderBy('id','asc')->paginate(20);

        // $students = Student::all();
        // $ticketss = Ticket::where('product_id',$product_id)->get();
        // $datas = BusinessDetail::orderBy('id','asc')->get();

        $studentsdata = DB::table('student')->orderBy('id','asc')->get();
        $ticketsdata = DB::table('ticket')->where('product_id', $product_id)->get();
        $datasdata = DB::table('business_details')->orderBy('id','asc')->get();

        $students = $studentsdata->chunk(1000);
        $tickets = $ticketsdata->chunk(1000);
        $datas = $datasdata->chunk(1000);

        // foreach ($students as $stud => $stu){
        //     foreach ($stu as $st => $s){
        //         dd($s->stud_id);
        //     }
        // }

        $role = ['Role', 'Stokis', 'Team / Pekerja Syarikat', 'Employee', 'Dropship', 'Agent', 'Founder', 'Lain-lain'];
        $type = ['Type', 'Fashion', 'Makanan', 'Katering & Perkahwinan', 'Kesihatan', 'Kecantikan', 'Pelancongan & Travel', 'Automotif', 'Hartanah', 'Umrah', 'Takaful / Insuran', 'Perunding Kewangan', 'Home Deco & Interior Design', 'Pecetakan / Printing', 'Belum Berniaga', 'Lain-lain'];

        return view('customer.business_survey', compact('data', 'datas', 'tickets', 'students', 'incomeOptions', 'role', 'type', 'offers', 'product', 'prod'));
    }

    public function paginate($items, $perPage, $page = null, $options = []){
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function customerAddComment($cust_id, Request $request) {
        $customer = Student::where('id', $cust_id)->first();
        
        $comment = Comment::create([
            'stud_id' => $customer['stud_id'],
            'comment' => $request->comment,
            'add_user' => Auth::user()->user_id
        ]);
        
        if($comment) {
            return redirect('customer_profiles/'.$cust_id)->with('commentSuccess', 'Comments Added Successfully!');
        }else {
            return redirect('customer_profiles/'.$cust_id)->with('commentError', 'There is a problem on adding comment!');
        }
    }

    public function customerUpdate($cust_id, Request $request) {
        $customer = Student::where('id', $cust_id)->update(['isSubscribe' => $request->subs]);

        if($customer) {
            return redirect('customer_profiles/'.$cust_id)->with('subsSuccess','Customer Subscribe Updated!');
        } else {
            return redirect('customer_profiles/'.$cust_id)->with('subsError','There is a problem on updating customer subscribe!');
        }
    }
	
	public function customerProfiles(Request $request) {
        $search = $request->query('search');

        if($search) {
            // $customers = Student::whereNotNull('membership_id')
            // ->where(function($query) use ($search){
            //     $query->where('first_name', 'LIKE', '%'.$search.'%')
            //     ->orWhere('last_name', 'LIKE', '%'.$search.'%')
            //     ->orWhere('ic', 'LIKE', '%'.$search.'%')
            //     ->orWhere('email', 'LIKE', '%'.$search.'%');
            // })->paginate(10);
            $customers = Student::where(function ($query) use ($search) {
                $query->where('first_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('ic', 'LIKE', '%' . $search . '%')
                    ->orWhere('email', 'LIKE', '%' . $search . '%');
            })->paginate(10);
        }else {
            $customers = Student::whereNotNull('membership_id')->paginate(10);
            //$customers = Student::paginate(10);
        }
        
        return view('customer.customer_profiles', compact('customers'));
    }

    public function customerProfile($id, Request $request) 
    {

        $customer = Student::where('id', $id)->first();
        
        $payment = Payment::where('stud_id', $customer['stud_id'])
        ->orderBy('created_at', 'DESC')
        ->get();
        
        if($member_lvl = Membership_Level::where('level_id', $customer->level_id)->get()->isEmpty())
        {
            $member_lvl = '-';
            $comment = Comment::where('stud_id', $customer['stud_id'])->get();

            $ncomment = [];

            if (count($comment) != 0) {
                foreach ($comment as $c) {
                    $name = User::where('user_id', $c->add_user);

                    if ($name->count() > 0) {
                        $name = $name->first();
                        $c->author = $name->name;
                    } else {
                        $c->author = "";
                    }

                    $ncomment[] = $c;
                }
            }

            $paymentMonth = Payment::where('stud_id', $customer['stud_id'])
                ->whereYear('created_at', Carbon::now()->year)
                ->whereMonth('created_at', Carbon::now()->month)
                ->get();

            $total_paid_month = 0;

            if (count($paymentMonth) != 0) {
                foreach ($paymentMonth as $pm) {
                    $total_paid_month += (int) $pm->pay_price;
                }
            }

            $total_paid = 0;

            if (count($payment) != 0) {
                foreach ($payment as $p) {
                    $total_paid += (int) $p->pay_price;
                }
            }

            $payment_data = [];

            foreach ($payment as $pt) {
                $product1 = Product::where('product_id', $pt->product_id);

                if ($product1->count() > 0) {
                    $product1 = $product1->first();
                    $payment_data[] = $product1;
                }
            }

            $ticket = Ticket::where('ic', $customer['ic'])->get();
            $total_event = count($ticket);
            $data = [];

            foreach ($ticket as $t) {
                $product = Product::where('product_id', $t->product_id);

                if ($product->count() > 0) {
                    $product = $product->first();
                    $data[] = $product;
                }
            }

            return view('customer.customer_profile', compact('customer', 'payment', 'data', 'total_paid', 'total_event',
            'member_lvl', 'total_paid_month', 'payment_data', 'ncomment'));

        }else{

            $member_lvl = Membership_Level::where('level_id', $customer->level_id)->first()->name;
            $comment = Comment::where('stud_id', $customer['stud_id'])->get();

            $ncomment = [];

            if (count($comment) != 0) {
                foreach ($comment as $c) {
                    $name = User::where('user_id', $c->add_user);

                    if ($name->count() > 0) {
                        $name = $name->first();
                        $c->author = $name->name;
                    } else {
                        $c->author = "";
                    }

                    $ncomment[] = $c;
                }
            }

            $paymentMonth = Payment::where('stud_id', $customer['stud_id'])
                ->whereYear('created_at', Carbon::now()->year)
                ->whereMonth('created_at', Carbon::now()->month)
                ->get();

            $total_paid_month = 0;

            if (count($paymentMonth) != 0) {
                foreach ($paymentMonth as $pm) {
                    $total_paid_month += (int) $pm->pay_price;
                }
            }

            $total_paid = 0;

            if (count($payment) != 0) {
                foreach ($payment as $p) {
                    $total_paid += (int) $p->pay_price;
                }
            }

            $payment_data = [];

            foreach ($payment as $pt) {
                $product1 = Product::where('product_id', $pt->product_id);

                if ($product1->count() > 0) {
                    $product1 = $product1->first();
                    $payment_data[] = $product1;
                }
            }

            $ticket = Ticket::where('ic', $customer['ic'])->get();
            $total_event = count($ticket);
            $data = [];

            foreach ($ticket as $t) {
                $product = Product::where('product_id', $t->product_id);

                if ($product->count() > 0) {
                    $product = $product->first();
                    $data[] = $product;
                }
            }

            return view('customer.customer_profile', compact('customer', 'payment', 'data', 'total_paid', 'total_event',
            'member_lvl', 'total_paid_month', 'payment_data', 'ncomment'));

        }
    }

    public function customerInvite() {
        $staff = User::where('role_id', 'ROD005')->get(); // get staff
        $user_list = [];
        foreach($staff as $s) {
            
            $payment = Payment::where('user_invite', $s->user_id)->get();
            $s->total = count($payment);
            $s->role = 'Staff';

            $user_list[] = $s;
        }

        $student = Student::whereNotNull('membership_id')->get();

        foreach($student as $st) {
            
            $payment = Payment::where('user_invite', $st->user_id)->get();
            $st->name =  $st->first_name . ' ' . $st->last_name;
            $st->total = count($payment);
            $st->role = 'Student';

            $user_list[] = $st;
        }
        $data = $this->paginate($user_list, 10);
        $data->setPath('customer-invite');

        return view('customer.business_invite', compact('data'));
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
