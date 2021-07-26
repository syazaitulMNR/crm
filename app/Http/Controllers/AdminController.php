<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Role;
use App\Permission;
use App\Student;
use App\Payment;
use App\Product;
use App\Package;
use App\Ticket;
use Carbon\Carbon;

class AdminController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | AdminController
    |--------------------------------------------------------------------------
    |   This controller is for managing user, role and dashboard
    | 
    */

    public function __construct()
    {
        $this->middleware('auth');
    }

    /*-- Dashboard --------------------------------------------------------*/
    public function dashboard(Request $request){      
        
        // get date and time
        $date_today = Carbon::now('Asia/Kuala_Lumpur')->format('d-m-Y');
        $current_time = Carbon::now('Asia/Kuala_Lumpur')->format('h:i a');
        $time = Carbon::now('Asia/Kuala_Lumpur')->format('H');
        
        // show the duration of current 2 hours
        // the $time is +1 hour from the duration
        if ($time < 9) {

            $from = date('Y-m-d 16:00:00');
            $to = date('Y-m-d 23:59:59');
            $duration = "12 am - 8 am"; 
            $greetings = "Good Morning!";

        } elseif ($time >= 9 && $time < 11) {

            $from = date('Y-m-d 00:00:00');
            $to = date('Y-m-d 01:59:59');
            $duration = "8 am - 10 am"; 
            $greetings = "Good Morning!";

        } elseif ($time >= 11 && $time < 13) {

            $from = date('Y-m-d 02:00:00');
            $to = date('Y-m-d 03:59:59');
            $duration = "10 am - 12 pm"; 
            $greetings = "Good Morning!";

        } elseif ($time >= 13 && $time < 15) {

            $from = date('Y-m-d 04:00:00');
            $to = date('Y-m-d 05:59:59');
            $duration = "12 pm - 2 pm"; 
            $greetings = "Good Afternoon!";

        } elseif ($time >= 15 && $time < 17) {

            $from = date('Y-m-d 06:00:00');
            $to = date('Y-m-d 07:59:59');
            $duration = "2 pm - 4 pm"; 
            $greetings = "Good Evening!";

        } elseif ($time >= 17 && $time < 19) {

            $from = date('Y-m-d 08:00:00');
            $to = date('Y-m-d 09:59:59');
            $duration = "4 pm - 6 pm"; 
            $greetings = "Good Evening!";

        } elseif ($time >= 19 && $time < 21) {

            $from = date('Y-m-d 10:00:00');
            $to = date('Y-m-d 11:59:59');
            $duration = "6 pm - 8 pm"; 
            $greetings = "Good Evening!";
            
        } elseif ($time >= 21 && $time < 23) {

            $from = date('Y-m-d 12:00:00');
            $to = date('Y-m-d 13:59:59');
            $duration = "8 pm - 10 pm"; 
            $greetings = "Good Evening!";

        } elseif ($time >= 23 && $time <= 24) {

            $from = date('Y-m-d 14:00:00');
            $to = date('Y-m-d 15:59:59');
            $duration = "10 pm - 12 am";
            $greetings = "Good Evening!";

        } else {

            $duration = "undefined";

        }

        // get product id
        $product = Product::where('status', 'active')->first();
        $product_id = $product->product_id;

        // get package
        $package = Package::where('product_id', $product_id)->get();
        // $package_id = Package::where('product_id', $product_id)->pluck('package_id');
        $package1 = $package[0]->name;
        $package2 = $package[1]->name;
        $package3 = $package[2]->name;

        // get package1 report by 2 hours
        $registration1 = Payment::where('status','paid')->where('product_id', $product_id)->where('package_id', $package[0]->package_id)->whereBetween('created_at', [ $from , $to ])->count();
        $paidticket1 = Ticket::where('ticket_type', 'paid')->where('product_id', $product_id)->where('package_id', $package[0]->package_id)->whereBetween('created_at', [ $from , $to ])->count();
        $freeticket1 = Ticket::where('ticket_type', 'free')->where('product_id', $product_id)->where('package_id', $package[0]->package_id)->whereBetween('created_at', [ $from , $to ])->count();
        $totalpackage1 = Payment::where('status','paid')->where('product_id', $product_id)->where('package_id', $package[0]->package_id)->count();
        // get package2 report by 2 hours
        $registration2 = Payment::where('status','paid')->where('product_id', $product_id)->where('package_id', $package[1]->package_id)->whereBetween('created_at', [ $from , $to ])->count();
        $paidticket2 = Ticket::where('ticket_type', 'paid')->where('product_id', $product_id)->where('package_id', $package[1]->package_id)->whereBetween('created_at', [ $from , $to ])->count();
        $freeticket2 = Ticket::where('ticket_type', 'free')->where('product_id', $product_id)->where('package_id', $package[1]->package_id)->whereBetween('created_at', [ $from , $to ])->count();
        $totalpackage2 = Payment::where('status','paid')->where('product_id', $product_id)->where('package_id', $package[1]->package_id)->count();
        // get package3 report by 2 hours
        $registration3 = Payment::where('status','paid')->where('product_id', $product_id)->where('package_id', $package[2]->package_id)->whereBetween('created_at', [ $from , $to ])->count();
        $paidticket3 = Ticket::where('ticket_type', 'paid')->where('product_id', $product_id)->where('package_id', $package[2]->package_id)->whereBetween('created_at', [ $from , $to ])->count();
        $freeticket3 = Ticket::where('ticket_type', 'free')->where('product_id', $product_id)->where('package_id', $package[2]->package_id)->whereBetween('created_at', [ $from , $to ])->count();
        $totalpackage3 = Payment::where('status','paid')->where('product_id', $product_id)->where('package_id', $package[2]->package_id)->count();

        // get the total
        $register = Payment::where('status','paid')->where('product_id', $product_id)->whereBetween('created_at', [ date('Y-m-d 16:00:00') , date('Y-m-d 15:59:59', strtotime('+1 day')) ])->count();
        $paid = Ticket::where('ticket_type', 'paid')->where('product_id', $product_id)->whereBetween('created_at', [ date('Y-m-d 16:00:00') , date('Y-m-d 15:59:59', strtotime('+1 day')) ])->count();
        $free = Ticket::where('ticket_type', 'free')->where('product_id', $product_id)->whereBetween('created_at', [ date('Y-m-d 16:00:00') , date('Y-m-d 15:59:59', strtotime('+1 day')) ])->count();

        // get the grand total
        $totalregister = Payment::where('status','paid')->where('product_id', $product_id)->count();
        $totalpaid = Ticket::where('ticket_type', 'paid')->where('product_id', $product_id)->count();
        $totalfree = Ticket::where('ticket_type', 'free')->where('product_id', $product_id)->count();
        $totalticket = Ticket::where('product_id', $product_id)->count();
        $pendingticket = $totalregister - $totalpaid;

        // get total collection
        $collection1 = Payment::where('status','paid')->where('product_id', $product_id)->where('package_id', $package[0]->package_id)->sum('totalprice');
        $collection2 = Payment::where('status','paid')->where('product_id', $product_id)->where('package_id', $package[1]->package_id)->sum('totalprice');
        $collection3 = Payment::where('status','paid')->where('product_id', $product_id)->where('package_id', $package[2]->package_id)->sum('totalprice');
        
        return view('admin.dashboard', compact('product', 'package', 'package1', 'package2', 'package3', 'date_today', 'current_time', 'from', 'to', 'duration', 'greetings', 'register', 'paid', 'free', 'totalregister', 'totalpaid', 'totalfree', 'totalticket', 'registration1', 'paidticket1', 'freeticket1', 'totalpackage1', 'registration2', 'paidticket2', 'freeticket2', 'totalpackage2', 'registration3', 'paidticket3', 'freeticket3', 'totalpackage3', 'pendingticket', 'collection1', 'collection2', 'collection3'));
    }

    /*-- Manage User --------------------------------------------------------*/
    public function manage()
    {
        $users = User::orderBy('id', 'asc')->paginate(15);
        $roles = Role::orderBy('id','asc')->get();
        return view('admin.manageuser', compact('users','roles'));
        
    }

    public function create()
    {
        $roles = Role::orderBy('id','asc')->paginate(10);
        return view('admin.adduser', compact('roles'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(Request $request)
    {
        return Validator::make($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function adduser(Request $request)
    {
        $user = User::orderBy('id','desc')->first();

        $auto_inc_user = $user->id + 1;
        $userId = 'UID' . 0 . 0 . $auto_inc_user;

        User::create(array(
            'user_id'=> $userId,
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'role_id' => $request['optradio'],
            
        ));

        return redirect('manageuser')->with('success', 'User Successfully Created');
    }

    public function update($id, Request $request)
    {
        $users = User::where('user_id', $id)->first();
        $roles = Role::orderBy('id','asc')->get();

        return view('admin.updateuser', compact('users','roles'));
    }

    public function updateuser($id, Request $request){
        
        foreach($request->optradio as $key => $value){

            $users = User::where('user_id', $id)->first();  

            $users->name = $request->name;
            $users->email = $request->email;
            $users->password = Hash::make($request['password']);
            $users->role_id = $value;
            $users->save();
            
        }

        return redirect('manageuser')->with('updatesuccess','User updated successfully!');      
    }

    public function destroy($id){
        $users = User::where('user_id', $id);
        
        $users->delete();
        return redirect('manageuser')->with('delete','User Successfully Deleted!');
    }

    /*-- Manage Role --------------------------------------------------------*/
    public function managerole()
    {
        $roles = Role::orderBy('id','asc')->paginate(10);
        return view('admin.managerole', compact('roles'));
    }

    public function addrole(Request $request){
        
        $role = Role::orderBy('id','desc')->first();

        $auto_inc_role = $role->id + 1;
        $roleId = 'ROD' . 0 . 0 . $auto_inc_role;

        Role::create(array(
            'role_id'=> $roleId,
            'name' => $request['name'],
            'description' => $request['description'],
            'permission' => $request['permission'],
            
        ));

        return redirect()->back()->with('rolesuccess', 'Role Successfully Created!');
    }

    public function details($id)
    {
        $roles = Role::where('role_id', $id)->first();
        return view('admin.updaterole', compact('roles'));
    }

    public function updaterole($id, Request $request)
    {
        $roles = Role::where('role_id', $id)->first();        

        $roles->name = $request->name;
        $roles->description = $request->description;

        $roles->save();

        foreach($request->permission as $key => $value){

            $p = Permission::where('role_id', $id)->where('permission_id', $request->permission_id[$key])->first();

            $p->name = $value;

            $p->save();
            

        }

        return redirect('managerole')->with('updatesuccess','Role Successfully Updated!');
    }

    public function deleterole($id){
        $roles = Role::where('role_id', $id);
        
        $roles->delete();
        return redirect('managerole')->with('deletesuccess','Role Successfully Deleted!');
    }

    /*-- Manage Profile --------------------------------------------------------*/
    public function profile()
    {
        return view('admin.updateprofile');
    }

    public function manageprofile($id, Request $request){
        
        $users = User::where('user_id', $id)->first();  

        // $users->name = $request->name;
        // $users->email = $request->email;
        $users->password = Hash::make($request['password']);
        $users->save();

        return redirect('dashboard')->with('updateprofile','Password Successfully Updated!');      
    }
}

