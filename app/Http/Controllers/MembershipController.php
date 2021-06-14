<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Membership;
use App\Membership_Level;
use App\Student;
use App\Imports\MembershipImport;
use Maatwebsite\Excel\Facades\Excel;

class MembershipController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function view_membership()
    {
        $membership = Membership::orderBy('id','desc')->paginate(15);
        
        return view('admin.membership.membership', compact('membership'));
    }

    public function store_membership(Request $request)
    {
        $membership = Membership::orderBy('id','desc')->first();
        $membership_level = Membership_Level::orderBy('id','desc')->first();

        $auto_inc_mb = $membership->id + 1;
        $membership_id = 'MB' . 0 . 0 . $auto_inc_mb;
              
        Membership::create(array(

            'membership_id'=> $membership_id,
            'name' => $request->name

        ));  

        foreach($request->level as $keys => $values) {

            // $auto_inc_mbl = $membership_level->id + 1;
            $level_id = 'MBL' . uniqid();
                    
            Membership_Level::create(array(
                'level_id'=> $level_id,
                'name'=> $values,
                'membership_id'=> $membership_id
            ));
        }

       // dd($package->package_image);
        return redirect('membership')->with('success', 'Membership Successfully Created'); 
    }

    public function view_level($membership_id)
    {
        $membership = Membership::where('membership_id', $membership_id)->first();
        $membership_level = Membership_Level::where('membership_id', $membership_id)->paginate(15);

        $total = Student::where('membership_id', $membership_id)->count();
        // $totalsuccess = Payment::where('status','paid')->where('product_id', $product_id)->where('package_id', $package_id)->count();
        // $totalcancel = Payment::where('status','due')->where('product_id', $product_id)->where('package_id', $package_id)->count();
        
        return view('admin.membership.level', compact('membership', 'membership_level', 'total'));
    }

    public function view($membership_id, $level_id)
    {
        $student = Student::where('membership_id', $membership_id)->where('level_id', $level_id)->paginate(50);
        $membership = Membership::where('membership_id', $membership_id)->first();
        $membership_level = Membership_Level::where('membership_id', $membership_id)->where('level_id', $level_id)->first();

        $total = Student::where('membership_id', $membership_id)->where('level_id', $level_id)->count();
        // $totalsuccess = Payment::where('status','paid')->where('product_id', $product_id)->where('package_id', $package_id)->count();
        // $totalcancel = Payment::where('status','due')->where('product_id', $product_id)->where('package_id', $package_id)->count();
        
        return view('admin.membership.view', compact('student', 'membership', 'membership_level', 'total'));
    }

    public function track_members($membership_id, $level_id, $student_id)
    {
        $student = Student::where('membership_id', $membership_id)->where('level_id', $level_id)->first();
        $membership = Membership::where('membership_id', $membership_id)->first();
        $membership_level = Membership_Level::where('membership_id', $membership_id)->where('level_id', $level_id)->first();

        return view('admin.membership.view_member', compact('membership', 'membership_level', 'student'));

    }

    public function import($membership_id, $level_id)
    {
        $membership = Membership::where('membership_id', $membership_id)->first();
        $membership_level = Membership_Level::where('membership_id', $membership_id)->where('level_id', $level_id)->first();

        return view('admin.membership.import', compact('membership', 'membership_level'));
    }

    public function store_import($membership_id, $level_id)
    {
        $membership = Membership::where('membership_id', $membership_id)->first();
        $membership_level = Membership_Level::where('membership_id', $membership_id)->where('level_id', $level_id)->first();

        // $membership_id = $membership->membership_id;
        // $level_id = $membership_level->level_id;

        Excel::import(new MembershipImport($membership_id, $level_id), request()->file('file'));    
        
        return redirect('membership/level/'.$membership_id.'/'.$level_id)->with('importsuccess', 'The file has been inserted to queue, it may take a while to successfully import.');

    }

    public function store_members($membership_id, $level_id, Request $request)
    {
        $student = Student::where('ic', $request->ic)->first();
        
        if(Student::where('ic', $request->ic)->exists()){

            $student->ic = $request->ic;
            $student->phoneno = $request->phoneno;
            $student->first_name = $request->first_name;
            $student->last_name = $request->last_name;
            $student->email = $request->email;
            $student->membership_id = $membership_id;
            $student->level_id = $level_id;
            $student->save();

        }else{

            $stud_id = 'MI'.uniqid();
            
            Student::create(array(
                'stud_id'=> $stud_id,
                'first_name'=> $request->first_name,
                'last_name'=> $request->last_name,
                'ic' => $request->ic,
                'phoneno' => $request->phoneno,
                'email' => $request->email,
                'membership_id' => $request->membership_id,
                'level_id' => $request->level_id
            ));

        }

        return redirect('membership/level/'.$membership_id.'/'.$level_id)->with('addsuccess', 'Customer successfully added');

    }
}
