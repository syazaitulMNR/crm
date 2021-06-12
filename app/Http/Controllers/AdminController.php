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
    | Admin Panel
    |--------------------------------------------------------------------------
    |   This controller is for managing Admin Panel
    | 
    */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.dashboard');
    }

    public function dashboard(Request $request){      
        $student = Student::count();
        $today = Payment::whereBetween('created_at', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])->sum('totalprice');
        $monthly = Payment::whereBetween('created_at', [date('Y-m-01 00:00:00'), date('Y-m-31 23:59:59')])->sum('totalprice');
        $yearly = Payment::whereBetween('created_at', [date('Y-01-01 00:00:00'), date('Y-12-31 23:59:59')])->sum('totalprice');
        
        $jan = Payment::whereBetween('created_at', [date('Y-01-01 00:00:00'), date('Y-01-31 23:59:59')])->sum('totalprice');
        $feb = Payment::whereBetween('created_at', [date('Y-02-01 00:00:00'), date('Y-02-29 23:59:59')])->sum('totalprice');
        $mar = Payment::whereBetween('created_at', [date('Y-03-01 00:00:00'), date('Y-03-31 23:59:59')])->sum('totalprice');
        $apr = Payment::whereBetween('created_at', [date('Y-04-01 00:00:00'), date('Y-04-30 23:59:59')])->sum('totalprice');
        $may = Payment::whereBetween('created_at', [date('Y-05-01 00:00:00'), date('Y-05-31 23:59:59')])->sum('totalprice');
        $jun = Payment::whereBetween('created_at', [date('Y-06-01 00:00:00'), date('Y-06-30 23:59:59')])->sum('totalprice');
        $jul = Payment::whereBetween('created_at', [date('Y-07-01 00:00:00'), date('Y-07-31 23:59:59')])->sum('totalprice');
        $aug = Payment::whereBetween('created_at', [date('Y-08-01 00:00:00'), date('Y-08-31 23:59:59')])->sum('totalprice');
        $sep = Payment::whereBetween('created_at', [date('Y-09-01 00:00:00'), date('Y-09-30 23:59:59')])->sum('totalprice');
        $oct = Payment::whereBetween('created_at', [date('Y-10-01 00:00:00'), date('Y-10-31 23:59:59')])->sum('totalprice');
        $nov = Payment::whereBetween('created_at', [date('Y-11-01 00:00:00'), date('Y-11-30 23:59:59')])->sum('totalprice');
        $dec = Payment::whereBetween('created_at', [date('Y-12-01 00:00:00'), date('Y-12-31 23:59:59')])->sum('totalprice');

        $greetings = "";       
        $time = date("H"); /* This sets the $time variable to the current hour in the 24 hour clock format */     
        $times = date("h:i"); /* This sets the $time variable to the current hour in the 12 hour clock format */
        $timezone = date("e"); /* Set the $timezone variable to become the current timezone */
        
        if ($timezone < "12") {
            $greetings = "Good morning"; /* If the time is less than 1200 hours, show good morning */
        } elseif ($timezone >= "12" && $timezone < "17") {
            $greetings = "Good afternoon"; /* If the time is grater than or equal to 1200 hours, but less than 1700 hours, so good afternoon */
        } elseif ($timezone >= "17" && $timezone < "19") {
            $greetings = "Good evening"; /* Should the time be between or equal to 1700 and 1900 hours, show good evening */
        } elseif ($timezone >= "19") {
            $greetings = "Good night"; /* Finally, show good night if the time is greater than or equal to 1900 hours */
        } else {
            $greetings = "Hi";
        }

        // Report Table

        $date_today = date('d-m-Y');
        $current_time = Carbon::now('Asia/Kuala_Lumpur')->format('h:i a');
        $time = Carbon::now('Asia/Kuala_Lumpur')->format('H');
        
        // show the duration of current 2 hours
        if ($time < 8) {

            $duration = "12 am - 8 am"; 

        } elseif ($time >= 8 && $time < 10) {

            $duration = "8 am - 10 am"; 

        } elseif ($time >= 10 && $time < 12) {

            $duration = "10 am - 12 pm"; 

        } elseif ($time >= 12 && $time < 14) {

            $duration = "12 pm - 2 pm"; 

        } elseif ($time >= 14 && $time < 16) {

            $duration = "2 pm - 4 pm"; 

        } elseif ($time >= 16 && $time < 18) {

            $duration = "4 pm - 6 pm"; 

        } elseif ($time >= 18 && $time < 20) {

            $duration = "6 pm - 8 pm"; 
            
        } elseif ($time >= 20 && $time < 22) {

            $duration = "8 pm - 10 pm"; 

        } elseif ($time >= 22 && $time <= 24) {

            $duration = "10 pm - 12 am";

        } else {

            $duration = "undefined";

        }

        // get product id
        $product = Product::where('status', 'active')->first();
        $product_id = $product->product_id;

        // get package id
        $package = Package::where('product_id', $product_id)->get();
        $package_id = Package::where('product_id', $product_id)->pluck('package_id');

        $registration = Payment::whereIn('package_id', $package_id)->where('status','paid')->count();
        $paidticket = Ticket::where('ticket_type', 'paid')->where('product_id', $product_id)->whereIn('package_id', $package_id)->count();
        $freeticket = Ticket::where('ticket_type', 'free')->where('product_id', $product_id)->whereIn('package_id', $package_id)->count();

        // get the grand total
        $totalregister = Payment::where('status','paid')->where('product_id', $product_id)->count();
        $totalpaid = Ticket::where('ticket_type', 'paid')->where('product_id', $product_id)->count();
        $totalfree = Ticket::where('ticket_type', 'free')->where('product_id', $product_id)->count();
        $totalticket = Ticket::where('product_id', $product_id)->count();
        
        // dd($package_id[0]);
        // dd($registration);
        return view('admin.dashboard', compact('student','today','monthly','yearly','jan','feb','mar','apr','may','jun','jul','aug','sep','oct','nov','dec','greetings', 'product', 'package', 'date_today', 'current_time', 'duration', 'registration', 'paidticket', 'freeticket', 'totalregister', 'totalpaid', 'totalfree', 'totalticket'));
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
        /*foreach($request->permission as $key => $value){

        $roles = Role::where('role_id', $id)->first();

        $roles->name = $request->name;
        $roles->description = $request->description;
        $roles->permission = $value;
        $roles->save();
        }*/

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
        // $users = User::where('user_id', $id)->first();
        // $roles = Role::orderBy('id','asc')->get();

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

