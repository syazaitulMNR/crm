<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Membership;
use App\Membership_Level;
use App\Student;

class MembershipController extends Controller
{
    public function view_level()
    {
        $membership = Membership::orderBy('id','desc')->paginate(15);
        
        return view('admin.membership.level', compact('membership'));
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

            $auto_inc_mbl = $membership_level->id + 1;
            $level_id = 'MB' . 0 . 0 . $auto_inc_mbl;
                    
            Membership_Level::create(array(
                'level_id'=> $level_id,
                'name'=> $values,
                'membership_id'=> $membership_id
            ));
        }

       // dd($package->package_image);
        return redirect('ultimate')->with('success', 'Membership Successfully Created'); 
    }

    public function view()
    {
        $student = Student::orderBy('id','desc')->paginate(15);

        // $total = Payment::where('product_id', $product_id)->where('package_id', $package_id)->count();
        // $totalsuccess = Payment::where('status','paid')->where('product_id', $product_id)->where('package_id', $package_id)->count();
        // $totalcancel = Payment::where('status','due')->where('product_id', $product_id)->where('package_id', $package_id)->count();
        
        return view('admin.membership.view', compact('student'));
    }
}
