<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Http;
use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Product;
use App\Payment;
use App\Student;
use App\SMSBulkModel;
use App\SMSTemplateModel;
use App\SMSSchedule;

class smsBlast extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto blasting SMS based on schedule informations';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = Carbon::now('Asia/Kuala_Lumpur')->format('Y-m-d');
        $time = Carbon::now('Asia/Kuala_Lumpur')->format('H:i:00'); 
        
        $schedList = SMSSchedule::where('date', $today)->where('time', $time)->get();
        foreach ($schedList as $s) {
            $lists = Payment::select('stud_id')->where('product_id', $s->product_id)->where('status', 'paid')->orderBy('product_id','asc')->get();
    
            foreach($lists as $key) {
                $details = Student::where('stud_id', $key->stud_id)->get(); 

                foreach($details as $value) {
                    // Http::get('http://cloudsms.trio-mobile.com/index.php/api/bulk_mt?api_key=NUC130101000036249535fb5accab169524b40e5468bd1de5&action=send&to='. $value->phoneno .'&msg='. $s->smstemp->content .'&sender_id=CLOUDSMS&content_type=1&mode=shortcode');
        
                    // if ($details->first()) {
                    //     dump('if');
                    //     $send = SMSBulkModel::create([
                    //         "type"          => "Schedule",
                    //         "phone"		    => $value->phoneno,
                    //         "template_id"   => $s->template_id,
                    //         "schedule_id"   => $s->id,
                    //         "user_id"	    => 1,
                    //         "title"         => $s->name,
                    //         "message"	    => $s->smstemp->content,
                    //         "created_at"    => Carbon::now('Asia/Kuala_Lumpur')
                    //     ]);

                    //     $newId = $send->id;

                    //     SMSBulkModel::find($newId)->update([
                    //         'group_id'=> $newId
                    //     ]);
                    // } else {
                    //     dump('else');
                    //     SMSBulkModel::create([
                    //         "type"          => "Schedule",
                    //         "phone"		    => $value->phoneno,
                    //         "template_id"   => $s->template_id,
                    //         "schedule_id"   => $s->id,
                    //         "user_id"	    => 1,
                    //         "title"         => $s->name,
                    //         "message"	    => $s->smstemp->content,
                    //         "group_id"      => $newId,
                    //         "created_at"    => Carbon::now('Asia/Kuala_Lumpur')
                    //     ]);
                    // } 

                    if (SMSBulkModel::where('template_id', $s->template_id)->where('schedule_id', $s->id)->count() == 0) {
                        $send = SMSBulkModel::create([
                            "type"          => "Schedule",
                            "phone"		    => $value->phoneno,
                            "template_id"   => $s->template_id,
                            "schedule_id"   => $s->id,
                            "user_id"	    => 1,
                            "title"         => $s->name,
                            "message"	    => $s->smstemp->content,
                            "created_at"    => Carbon::now('Asia/Kuala_Lumpur')
                        ]);

                        $newId = $send->id;

                        SMSBulkModel::find($newId)->update([
                            'group_id'=> $newId
                        ]);
                    } else {
                        SMSBulkModel::create([
                            "type"          => "Schedule",
                            "phone"		    => $value->phoneno,
                            "template_id"   => $s->template_id,
                            "schedule_id"   => $s->id,
                            "user_id"	    => 1,
                            "title"         => $s->name,
                            "message"	    => $s->smstemp->content,
                            "group_id"      => $newId,
                            "created_at"    => Carbon::now('Asia/Kuala_Lumpur')
                        ]);
                    } 
                }
            } 
            $s->status  = "Sended";
        
            $s->save();
        }
    }
}
