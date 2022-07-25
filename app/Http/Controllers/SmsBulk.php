<?php

namespace App\Http\Controllers;
use DB;
use App\SMSBulkModel;
use App\SMSTemplateModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SMSBulkImport;
use App\Exports\SMSTemplate;
use App\Product;

use Auth;

class SmsBulk extends Controller
{
    public function index(Request $request)
    {
		$y = SMSTemplateModel::orderBy("id", "desc")->get();
		$search = $request->query('search');
		
		if($search) {
			$x = SMSBulkModel::where('message', 'LIKE', '%'.$search.'%')
			->orWhere('title', 'LIKE', '%'.$search.'%')
			->orWhere('type', 'LIKE', '%'.$search.'%')
			->orderByRaw('CONVERT(group_id, SIGNED) desc')->get()
			->groupBy("group_id");
				
			return view("admin.sms.smsbulk.index", compact("x", "y"));

        } else {
            $x = SMSBulkModel::orderByRaw('CONVERT(group_id, SIGNED) desc')->get()->groupBy("group_id");
			
			return view("admin.sms.smsbulk.index", compact("x", "y"));
		}
    }

    public function export()
    {
        return Excel::download(new SMSTemplate, 'Phone_No.xlsx');
    }

    public function create(Request $request)
    {
		Http::get('http://cloudsms.trio-mobile.com/index.php/api/bulk_mt?api_key='. env("TRIO_KEY") .'&action=send&to='. $request->phone .'&msg='. $request->message .'&sender_id=CLOUDSMS&content_type=1&mode=shortcode');

		$bulk = SMSBulkModel::create([
			"type"          => "Bulk",
			"phone"		    => $request->phone,
			"user_id"	    => Auth::user()->id,
			"title"         => $request->title,
			"message"	    => $request->message,
			"template_id"	=> 0
		]);

		$newId = $bulk->id;

		SMSBulkModel::find($newId)->update([
			'group_id'=> $newId
		]);
		
		return redirect("smsblast")->with('success', 'Message has been sent to '. $request->phone .'.');
    }
	
	public function create_bulk(Request $request)
    {
        $t = SMSTemplateModel::where("id", $request->template);
		$check = SMSBulkModel::where("title", $request->title)->where("type", "Bulk Excel");
		
		if ($check->exists())
		{
			return redirect("smsblast")->with('error', 'Title already exist. Please use different name.');

		} else {
			$n = $request->title;
		
			if($t->count() > 0){
				$t = $t->first();
				
				preg_match_all("/(?<={).*?(?=})/", $t->content, $m);
				
				if(count($m) > 0){
					if(count($m[0]) > 0){
						$m = $m[0];
					}else{
						$m = [];
					}
				}else{
					$m = [];
				}
				
				$x = Excel::import(new SMSBulkImport($n, $t->id, $m), request()->file('file'));
				
				return redirect("smsblast")->with('success', 'Messages has been qued for sending with template '. $t->title .'.');
			} else {
				return redirect("smsblast")->with('error', 'Selected template is not available.');
			}
		}
    }

    public function show($group_id, Request $request)
    {
		$products = Product::all();
		$search = $request->query('search');
		
		if($search) {
			$x = SMSBulkModel::where('group_id', $group_id)->where('phone', 'LIKE', '%'.$search.'%')->paginate(15);
		} else {
        	$x = SMSBulkModel::where('group_id', $group_id)->paginate(15);
        }

        return view("admin.sms.smsbulk.view", compact("x", "group_id", "products"));
    }
}
