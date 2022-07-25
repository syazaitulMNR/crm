<?php

namespace App\Http\Controllers;

use App\SMSTemplateModel;
use App\Product;
use Illuminate\Http\Request;

use Auth;

class SmsTemplate extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
		$x = SMSTemplateModel::orderBy("id", "desc")->paginate(15);
        $prods = Product::select("class")->groupBy("class")->whereNotNull("class")->get();
		
		return view("admin.sms.smstemplate.index", compact("x", "prods"));
    }

    public function create(Request $r)
    {
		SMSTemplateModel::create([
			"title"			=> $r->get("title"),
			"description"	=> $r->get("description"),
			"content"		=> $r->get("content"),
            "class"		    => $r->get("class"),
            "day"		    => $r->get("day"),
            "hour"		    => $r->get("hour"),
			"user_id"		=> Auth::user()->id
		]);
		
		return redirect("smstemplate")->with('success', 'Template information has been saved successfully.');
    }

    public function del($id)
    {
        $x = SMSTemplateModel::where("id", $id);
		
		return view("admin.sms.smstemplate.delete", compact("x"));
    }

    public function edit($id)
    {
        $x = SMSTemplateModel::where("id", $id);
        $prods = Product::select("class")->groupBy("class")->whereNotNull("class")->get();
		
		return view("admin.sms.smstemplate.edit", compact("x", "prods"));
    }

    public function update(Request $r, $id)
    {
		$x = SMSTemplateModel::where("id", $id);
		
		if($x->count() > 0){
			$x = $x->first();
			
			$x->title = $r->get("title");
			$x->description = $r->get("description");
			$x->content = $r->get("content");
            $x->class = $r->get("class");
            $x->day = $r->get("day");
            $x->hour = $r->get("hour");
            
			$x->save();
			
			return redirect("smstemplate/edit/" . $id)->with('success', 'Template information has been saved successfully.');
		}else{
			return redirect("smstemplate")->with('error', 'Template information cannot be saved due to selected template is not available in database.');
		}
		
    }

    public function remove($id)
    {
        $x = SMSTemplateModel::where("id", $id);
		
		if($x->count() > 0){
			$x = $x->first();
			$x->delete();
			
			return redirect("smstemplate")->with('success', 'Template information has been saved successfully.');

		}else{
			return redirect("smstemplate/edit/" . $id)->with('error', 'Template information cannot be saved due to selected template is not available in database.');
		}
    }
}
