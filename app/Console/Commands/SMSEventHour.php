<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\SMSBulkModel;
use App\SMSTemplateModel;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SMSBulkImport;
use App\Exports\SMSTemplate;
use App\Student;
use App\Product;
use App\Package;
use App\Payment;

class SMSEventHour extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:byhour';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $startcron = SMSTemplateModel::all();
        
        foreach ($startcron as $sms) {
            if($sms->class != NULL && $sms->hour != NULL) {
                $twohour = Carbon::now('Asia/Kuala_Lumpur')->addHours($sms->hour)->format('H:i');
                // $onehour = Carbon::now('Asia/Kuala_Lumpur')->addHours(($sms->hour)-1)->format('H:i');

                // $bytime = Product::select('product_id', 'name', 'date_from', 'time_from')->where('time_from', '>=', $onehour)->where('time_from', '<=', $twohour)->where('class', $sms->class)->where('date_from', Carbon::now('Asia/Kuala_Lumpur')->format('d-m-Y'))->get();
                $bytime = Product::select('product_id', 'name', 'date_from', 'time_from')->where('time_from', $twohour)->where('class', $sms->class)->where('date_from', Carbon::now('Asia/Kuala_Lumpur')->format('d-m-Y'))->get();
                foreach($bytime as $event) {
                    $lists = Payment::select('stud_id')->where('product_id', $event->product_id)->where('status', 'paid')->orderBy('product_id','asc')->get();
            
                    foreach($lists as $key) {
                        $details = Student::where('stud_id', $key->stud_id)->get(); 
        
                        foreach($details as $value) {
                            Http::get('http://cloudsms.trio-mobile.com/index.php/api/bulk_mt?api_key=NUC130101000036249535fb5accab169524b40e5468bd1de5&action=send&to='. $value->phoneno .'&msg='. $sms->content .'&sender_id=CLOUDSMS&content_type=1&mode=shortcode');
                            SMSBulkModel::create([
                                "phone"		=> $value->phoneno,
                                "message"	=> $sms->content,
                                "user_id"	=> 1,
                                "template_id" => $sms->id
                            ]);
                        }
                    }    
                }
            }
        }
    }
}
