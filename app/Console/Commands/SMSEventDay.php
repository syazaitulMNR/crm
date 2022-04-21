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

class SMSEventDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:byday';

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
            if($sms->class != NULL && $sms->day != NULL) {
                $oneday = Carbon::now('Asia/Kuala_Lumpur')->addDays($sms->day)->format('d-m-Y');

                $byday = Product::select('product_id', 'name', 'date_from', 'time_from')->where('class', $sms->class)->where('date_from', $oneday)->get();

                foreach($byday as $event) {
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
       


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // public function handle()
    // {
    //     $oneday = Carbon::now('Asia/Kuala_Lumpur')->addDays(1)->format('d-m-Y');
    //     $twohour = Carbon::now('Asia/Kuala_Lumpur')->addHours(2)->format('H:i');
    //     $onehour = Carbon::now('Asia/Kuala_Lumpur')->addHours(1)->format('H:i');
    //     // $now = Carbon::now('Asia/Kuala_Lumpur')->format('H:i');
    //     // dd($now);
        
    //     //blasting one day before classes
    //     $byday = Product::select('product_id', 'name', 'date_from', 'time_from')->where('class','CUBA')->where('date_from', $oneday)->get();
    //     if($byday){
    //         $sms = SMSTemplateModel::where('id',2)->first();

    //         foreach($byday as $event) {
    //             $lists = Payment::select('stud_id')->where('product_id', $event->product_id)->where('status', 'paid')->orderBy('product_id','asc')->get();
        
    //             foreach($lists as $key) {
    //                 $details = Student::where('stud_id', $key->stud_id)->get(); 
    
    //                 foreach($details as $value) {
    //                     Http::get('http://cloudsms.trio-mobile.com/index.php/api/bulk_mt?api_key=NUC130101000036249535fb5accab169524b40e5468bd1de5&action=send&to='. $value->phoneno .'&msg='. $sms->content .'&sender_id=CLOUDSMS&content_type=1&mode=shortcode');
    //                     SMSBulkModel::create([
    //                         "phone"		=> $value->phoneno,
    //                         "message"	=> $sms->content,
    //                         "user_id"	=> 1,
    //                         "template_id" => $sms->id
    //                     ]);
    //                 }
    //             }    
    //         }
    //     }
    //     //blasting 2 hours before class
    //     $bytime = Product::select('product_id', 'name', 'date_from', 'time_from')->where('time_from', '>=', $onehour)->where('time_from', '<=', $twohour)->where('class','CUBA')->where('date_from', Carbon::now('Asia/Kuala_Lumpur')->format('d-m-Y'))->get();
       
    //     if($bytime){
    //         $sms = SMSTemplateModel::where('id',3)->first();

    //         foreach($bytime as $event) {
    //             $lists = Payment::select('stud_id')->where('product_id', $event->product_id)->where('status', 'paid')->orderBy('product_id','asc')->get();
        
    //             foreach($lists as $key) {
    //                 $details = Student::where('stud_id', $key->stud_id)->get(); 
    
    //                 foreach($details as $value) {
    //                     Http::get('http://cloudsms.trio-mobile.com/index.php/api/bulk_mt?api_key=NUC130101000036249535fb5accab169524b40e5468bd1de5&action=send&to='. $value->phoneno .'&msg='. $sms->content .'&sender_id=CLOUDSMS&content_type=1&mode=shortcode');
    //                     SMSBulkModel::create([
    //                         "phone"		=> $value->phoneno,
    //                         "message"	=> $sms->content,
    //                         "user_id"	=> 1,
    //                         "template_id" => $sms->id
    //                     ]);
    //                 }
    //             }    
    //         }
    //     }
        
    //     // // Http::get('http://cloudsms.trio-mobile.com/index.php/api/bulk_mt?api_key='. env("TRIO_KEY") .'&action=send&to='. $request->phone .'&msg='. $request->message .'&sender_id=CLOUDSMS&content_type=1&mode=shortcode');
	// 	// Http::get('http://cloudsms.trio-mobile.com/index.php/api/bulk_mt?api_key=NUC130101000036249535fb5accab169524b40e5468bd1de5&action=send&to=60145292249&msg=Tahniah&sender_id=CLOUDSMS&content_type=1&mode=shortcode');
		
	// 	// SMSBulkModel::create([
	// 	// 	"phone"		=> "60145292249",
	// 	// 	"message"	=> "Tahniah",
	// 	// 	"user_id"	=> 1,
	// 	// 	"template_id" => 1
	// 	// ]);
		
    // }
}
