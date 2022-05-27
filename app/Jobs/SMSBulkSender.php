<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use App\SMSTemplateModel;
use App\SMSBulkModel;
use Carbon\Carbon;

use Auth;

class SMSBulkSender implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $_rows = [], $_templateId = 0, $_regexData = [], $_message = "", $_title = "";
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($rows, $title, $templateId, $regexData)
    {
        $this->_rows = $rows;
        $this->_title = $title;
        $this->_templateId = $templateId;
        $this->_regexData = $regexData;
		
		$t =  SMSTemplateModel::where("id", $templateId);
		$this->_message = $t->first()->content;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach($this->_rows as $row){
            $message = $this->_message;
			
			foreach($this->_regexData as $rd){
				if(isset($row[strtolower($rd)])){
					$message = str_replace("{". $rd ."}", $row[strtolower($rd)], $message);
				}
			}
			
			if(isset($row["phone_no"])){
				$phone_no = $row["phone_no"];
			
				Http::get('http://cloudsms.trio-mobile.com/index.php/api/bulk_mt?api_key='. env("TRIO_KEY") .'&action=send&to='. $phone_no .'&msg='. $message .'&sender_id=CLOUDSMS&content_type=1&mode=shortcode');
				if (SMSBulkModel::where('template_id', $this->_templateId)->where('schedule_id', NULL)->where('title', $this->_title)->count() == 0) 
                {
                    $send = SMSBulkModel::create([
                        "type"          => "Bulk Excel",
                        "phone"		    => $phone_no,
                        "user_id"	    => (isset(Auth::user()->id) ? Auth::user()->id : 0),
                        "title"         => $this->_title,
                        "template_id"   => $this->_templateId,
                        "message"	    => $message,
                        "created_at"    => Carbon::now('Asia/Kuala_Lumpur'),
                        "updated_at"    => Carbon::now('Asia/Kuala_Lumpur'),
                    ]);

                    $newId = $send->id;

                    SMSBulkModel::find($newId)->update([
                        'group_id'=> $newId
                    ]);
                } else {
                    SMSBulkModel::create([
                        "type"          => "Bulk Excel",
                        "phone"		    => $phone_no,
                        "user_id"	    => (isset(Auth::user()->id) ? Auth::user()->id : 0),
                        "title"         => $this->_title,
                        "template_id"   => $this->_templateId,
                        "message"	    => $message,
                        "created_at"    => Carbon::now('Asia/Kuala_Lumpur'),
                        "updated_at"    => Carbon::now('Asia/Kuala_Lumpur'),
                        "group_id"      => $newId
                    ]);
                } 

			}else{
				return false;
			}
        }
    }
}




























