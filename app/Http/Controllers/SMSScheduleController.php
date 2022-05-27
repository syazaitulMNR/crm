<?php

namespace App\Http\Controllers;

use App\SMSSchedule;
use App\Product;
use App\SMSTemplateModel;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SMSScheduleController extends Controller
{
    public function index()
    {
        $schedules = SMSSchedule::orderBy("id", "desc")->paginate(20);
        $templates = SMSTemplateModel::all();
        $products = Product::where('status', 'active')->orWhereNull('status')->orderBy('id', 'desc')->get();
        
        return view("admin.sms.smsschedule.index", compact("schedules", "templates", "products"));
    }

    public function save(Request $r)
    {
        if($r->type == "day") {
            $selProd = Product::where('product_id', $r->product_id)->first();
            $set_date = Carbon::parse($selProd->date_from)->subDays($r->day_before);
           
            $set_time = $r->time_day;
            $day = $r->day_before;
            
        } elseif($r->type == "datetime")  {
            $set_date = $r->date;
            $set_time = $r->time;
            $day = "NULL";
             
        }

        SMSSchedule::create([
            "name"          => $r->name,
			"product_id"	=> $r->product_id,
			"template_id"	=> $r->template_id,
			"date"		    => $set_date,
            "time"		    => $set_time,
            "day_before"	=> $day,
            "status"        => "In Progress"
		]);
		
		return redirect("smsschedule")->with('success', 'SMS scheduled has been saved successfully.');
    }

    public function edit($id)
    {
        $sched = SMSSchedule::where("id", $id);
        $templates = SMSTemplateModel::all();
        $prods = Product::where('status', 'active')->orWhereNull('status')->orderBy('id', 'desc')->get();
		
		return view("admin.sms.smsschedule.edit", compact("sched", "templates", "prods"));
    }

    public function update(Request $r, $id)
    {
		$sched = SMSSchedule::where("id", $id);

        if($r->type == "day") {
            $selProd = Product::where('product_id', $r->product_id)->first();

            $set_date = Carbon::parse($selProd->date_from)->subDays($r->day_before);
            $set_time = $r->time_day;
            $day = $r->day_before;
            
        } elseif($r->type == "datetime")  {
            $set_date = $r->date;
            $set_time = $r->time;
            $day = NULL;
             
        }
        
		if($sched->count() > 0){
			$sched = $sched->first();
			
            $sched->name        = $r->name;
			$sched->product_id  = $r->product_id;
			$sched->template_id = $r->template_id;
			$sched->date        = $set_date;
            $sched->time        = $set_time;
            $sched->day_before  = $day;
            
			$sched->save();
			
			return redirect("smsschedule/edit/" . $id)->with('success', 'Schedule information has been updated successfully.');
		}else{
			return redirect("smsschedule")->with('error', 'Schedule information cannot be updated due to selected data is not available in database.');
		}
		
    }

    public function del($id)
    {
        $x = SMSSchedule::where("id", $id);
		
		return view("admin.sms.smsschedule.delete", compact("x"));
    }

    public function remove($id)
    {
        $x = SMSSchedule::where("id", $id);
		
		if($x->count() > 0){
			$x = $x->first();
			$x->delete();
			
			return redirect("smsschedule")->with('success', 'Schedule information has been deleted successfully.');
		}else{
			return redirect("smsschedule/edit/" . $id)->with('error', 'Schedule information cannot be deleted due to selected data is not available in database.');
		}
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  