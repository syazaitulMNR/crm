<?php

namespace App\Console\Commands;

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
use Telegram;

use Illuminate\Console\Command;

class UpdatePendaftaran2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:update2';

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
    public function handle(Request $request)
    {
        $date_today = Carbon::now('Asia/Kuala_Lumpur')->format('d-m-Y');
        $current_time = Carbon::now('Asia/Kuala_Lumpur')->format('h:i a');
        $time = Carbon::now('Asia/Kuala_Lumpur')->format('H:i');
        
        if ($time < "08:10") {

            $from = date('Y-m-d 16:00:00');
            $to = date('Y-m-d 23:59:59');
            $duration = "12 am - 8 am"; 
            $greetings = "Good Morning!";

        } elseif ($time >= "08:10" && $time < "09:10") {

            $from = date('Y-m-d 00:00:00');
            $to = date('Y-m-d 00:59:59');
            $duration = "8 am - 9 am"; 
            $greetings = "Good Morning!";

        } elseif ($time >= "09:10" && $time < "10:10") {

            $from = date('Y-m-d 01:00:00');
            $to = date('Y-m-d 01:59:59');
            $duration = "9 am - 10 am"; 
            $greetings = "Good Morning!";

        } elseif ($time >= "10:10" && $time < "11:10") {

            $from = date('Y-m-d 02:00:00');
            $to = date('Y-m-d 02:59:59');
            $duration = "10 am - 11 am"; 
            $greetings = "Good Morning!";

        } elseif ($time >= "11:10" && $time < "12:10") {

            $from = date('Y-m-d 03:00:00');
            $to = date('Y-m-d 03:59:59');
            $duration = "11 am - 12 pm"; 
            $greetings = "Good Morning!";

        } elseif ($time >= "12:10" && $time < "13:10") {

            $from = date('Y-m-d 04:00:00');
            $to = date('Y-m-d 04:59:59');
            $duration = "12 pm - 1 pm"; 
            $greetings = "Good Afternoon!";

        } elseif ($time >= "13:10" && $time < "14:10") {

            $from = date('Y-m-d 05:00:00');
            $to = date('Y-m-d 05:59:59');
            $duration = "1 pm - 2 pm"; 
            $greetings = "Good Afternoon!";

        } elseif ($time >= "14:10" && $time < "15:10") {

            $from = date('Y-m-d 06:00:00');
            $to = date('Y-m-d 06:59:59');
            $duration = "2 pm - 3 pm"; 
            $greetings = "Good Afternoon!";

        } elseif ($time >= "15:10" && $time < "16:10") {

            $from = date('Y-m-d 07:00:00');
            $to = date('Y-m-d 07:59:59');
            $duration = "3 pm - 4 pm"; 
            $greetings = "Good Evening!";

        } elseif ($time >= "16:10" && $time < "17:10") {

            $from = date('Y-m-d 08:00:00');
            $to = date('Y-m-d 08:59:59');
            $duration = "4 pm - 5 pm"; 
            $greetings = "Good Evening!";

        } elseif ($time >= "17:10" && $time < "18:10") {

            $from = date('Y-m-d 09:00:00');
            $to = date('Y-m-d 09:59:59');
            $duration = "5 pm - 6 pm"; 
            $greetings = "Good Evening!";

        } elseif ($time >= "18:10" && $time < "19:10") {

            $from = date('Y-m-d 10:00:00');
            $to = date('Y-m-d 10:59:59');
            $duration = "6 pm - 7 pm"; 
            $greetings = "Good Evening!";

        } elseif ($time >= "19:10" && $time < "20:10") {

            $from = date('Y-m-d 11:00:00');
            $to = date('Y-m-d 11:59:59');
            $duration = "7 pm - 8 pm"; 
            $greetings = "Good Evening!";
            
        } elseif ($time >= "20:10" && $time < "21:10") {

            $from = date('Y-m-d 12:00:00');
            $to = date('Y-m-d 12:59:59');
            $duration = "8 pm - 9 pm"; 
            $greetings = "Good Evening!";
            
        } elseif ($time >= "21:10" && $time < "22:10") {

            $from = date('Y-m-d 13:00:00');
            $to = date('Y-m-d 13:59:59');
            $duration = "9 pm - 10 pm"; 
            $greetings = "Good Evening!";

        } elseif ($time >= "22:10" && $time < "23:10") {

            $from = date('Y-m-d 14:00:00');
            $to = date('Y-m-d 14:59:59');
            $duration = "10 pm - 11 pm"; 
            $greetings = "Good Evening!";

        } elseif ($time >= "23:10" && $time <= "00:00") {

            $from = date('Y-m-d 15:00:00');
            $to = date('Y-m-d 15:59:59');
            $duration = "11 pm - 12 am";
            $greetings = "Good Evening!";

        } else {

            $from = date('Y-m-d 15:00:00');
            $to = date('Y-m-d 15:59:59');
            $duration = "11 pm - 12 am";
            $greetings = "Good Evening!";

        }

        $product1 = Product::where('product_id','PRD0039')->first();
        $package1 = Payment::where('product_id',$product1->product_id)->where('status','paid')->whereBetween('created_at', [ $from , $to ])->count();
        $packages1 = Payment::where('product_id',$product1->product_id)->where('status','paid')->count();

        $product2 = Product::where('product_id','PRD0040')->first();
        $package2 = Payment::where('product_id',$product2->product_id)->where('status','paid')->whereBetween('created_at', [ $from , $to ])->count();
        $packages2 = Payment::where('product_id',$product2->product_id)->where('status','paid')->count();

        $product3 = Product::where('product_id','PRD0041')->first();
        $package3 = Payment::where('product_id',$product3->product_id)->where('status','paid')->whereBetween('created_at', [ $from , $to ])->count();
        $packages3 = Payment::where('product_id',$product3->product_id)->where('status','paid')->count();

        $product4 = Product::where('product_id','PRD0042')->first();
        $package4 = Payment::where('product_id',$product4->product_id)->where('status','paid')->whereBetween('created_at', [ $from , $to ])->count();
        $packages4 = Payment::where('product_id',$product4->product_id)->where('status','paid')->count();

        $product5 = Product::where('product_id','PRD0043')->first();
        $package5 = Payment::where('product_id',$product5->product_id)->where('status','paid')->whereBetween('created_at', [ $from , $to ])->count();
        $packages5 = Payment::where('product_id',$product5->product_id)->where('status','paid')->count();

        $product6 = Product::where('product_id','PRD0044')->first();
        $package6 = Payment::where('product_id',$product6->product_id)->where('status','paid')->whereBetween('created_at', [ $from , $to ])->count();
        $packages6 = Payment::where('product_id',$product6->product_id)->where('status','paid')->count();

        $product7 = Product::where('product_id','PRD0047')->first();
        $package7 = Payment::where('product_id',$product7->product_id)->where('status','paid')->whereBetween('created_at', [ $from , $to ])->count();
        $packages7 = Payment::where('product_id',$product7->product_id)->where('status','paid')->count();

        $product8 = Product::where('product_id','PRD0048')->first();
        $package8 = Payment::where('product_id',$product8->product_id)->where('status','paid')->whereBetween('created_at', [ $from , $to ])->count();
        $packages8 = Payment::where('product_id',$product8->product_id)->where('status','paid')->count();

        $product9 = Product::where('product_id','PRD0049')->first();
        $package9 = Payment::where('product_id',$product9->product_id)->where('status','paid')->whereBetween('created_at', [ $from , $to ])->count();
        $packages9 = Payment::where('product_id',$product9->product_id)->where('status','paid')->count();

        $product10 = Product::where('product_id','PRD0050')->first();
        $package10 = Payment::where('product_id',$product10->product_id)->where('status','paid')->whereBetween('created_at', [ $from , $to ])->count();
        $packages10 = Payment::where('product_id',$product10->product_id)->where('status','paid')->count();

        $product11 = Product::where('product_id','PRD0051')->first();
        $package11 = Payment::where('product_id',$product11->product_id)->where('status','paid')->whereBetween('created_at', [ $from , $to ])->count();
        $packages11 = Payment::where('product_id',$product11->product_id)->where('status','paid')->count();

        $product12 = Product::where('product_id','PRD0052')->first();
        $package12 = Payment::where('product_id',$product12->product_id)->where('status','paid')->whereBetween('created_at', [ $from , $to ])->count();
        $packages12 = Payment::where('product_id',$product12->product_id)->where('status','paid')->count();

        $product13 = Product::where('product_id','PRD0053')->first();
        $package13 = Payment::where('product_id',$product13->product_id)->where('status','paid')->whereBetween('created_at', [ $from , $to ])->count();
        $packages13 = Payment::where('product_id',$product13->product_id)->where('status','paid')->count();

        $product14 = Product::where('product_id','PRD0054')->first();
        $package14 = Payment::where('product_id',$product14->product_id)->where('status','paid')->whereBetween('created_at', [ $from , $to ])->count();
        $packages14 = Payment::where('product_id',$product14->product_id)->where('status','paid')->count();

        $product15 = Product::where('product_id','PRD0055')->first();
        $package15 = Payment::where('product_id',$product15->product_id)->where('status','paid')->whereBetween('created_at', [ $from , $to ])->count();
        $packages15 = Payment::where('product_id',$product15->product_id)->where('status','paid')->count();

        $product16 = Product::where('product_id','PRD0056')->first();
        $package16 = Payment::where('product_id',$product16->product_id)->where('status','paid')->whereBetween('created_at', [ $from , $to ])->count();
        $packages16 = Payment::where('product_id',$product16->product_id)->where('status','paid')->count();
        
        $product17 = Product::where('product_id','PRD0057')->first();
        $package17 = Payment::where('product_id',$product17->product_id)->where('status','paid')->whereBetween('created_at', [ $from , $to ])->count();
        $packages17 = Payment::where('product_id',$product17->product_id)->where('status','paid')->count();

        $product18 = Product::where('product_id','PRD0058')->first();
        $package18 = Payment::where('product_id',$product18->product_id)->where('status','paid')->whereBetween('created_at', [ $from , $to ])->count();
        $packages18 = Payment::where('product_id',$product18->product_id)->where('status','paid')->count();

        // XCESS //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $product19 = Product::where('product_id','PRD0068')->first();
        $package19 = Payment::where('product_id',$product19->product_id)->where('status','paid')->whereBetween('created_at', [ $from , $to ])->count();
        $packages19 = Payment::where('product_id',$product19->product_id)->where('status','paid')->count();

        $product20 = Product::where('product_id','PRD0069')->first();
        $package20 = Payment::where('product_id',$product20->product_id)->where('status','paid')->whereBetween('created_at', [ $from , $to ])->count();
        $packages20 = Payment::where('product_id',$product20->product_id)->where('status','paid')->count();

        $product21 = Product::where('product_id','PRD0070')->first();
        $package21 = Payment::where('product_id',$product21->product_id)->where('status','paid')->whereBetween('created_at', [ $from , $to ])->count();
        $packages21 = Payment::where('product_id',$product21->product_id)->where('status','paid')->count();

        $product22 = Product::where('product_id','PRD0071')->first();
        $package22 = Payment::where('product_id',$product22->product_id)->where('status','paid')->whereBetween('created_at', [ $from , $to ])->count();
        $packages22 = Payment::where('product_id',$product22->product_id)->where('status','paid')->count();
        
        $product23 = Product::where('product_id','PRD0072')->first();
        $package23 = Payment::where('product_id',$product23->product_id)->where('status','paid')->whereBetween('created_at', [ $from , $to ])->count();
        $packages23 = Payment::where('product_id',$product23->product_id)->where('status','paid')->count();

        $product24 = Product::where('product_id','PRD0073')->first();
        $package24 = Payment::where('product_id',$product24->product_id)->where('status','paid')->whereBetween('created_at', [ $from , $to ])->count();
        $packages24 = Payment::where('product_id',$product24->product_id)->where('status','paid')->count();

        $product25 = Product::where('product_id','PRD0074')->first();
        $package25 = Payment::where('product_id',$product25->product_id)->where('status','paid')->whereBetween('created_at', [ $from , $to ])->count();
        $packages25 = Payment::where('product_id',$product25->product_id)->where('status','paid')->count();

        $product26 = Product::where('product_id','PRD0078')->first();
        $package26 = Payment::where('product_id',$product26->product_id)->where('status','paid')->whereBetween('created_at', [ $from , $to ])->count();
        $packages26 = Payment::where('product_id',$product26->product_id)->where('status','paid')->count();

        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $product27 = Product::where('product_id','PRD0077')->first();
        $package27 = Payment::where('product_id',$product27->product_id)->where('status','paid')->whereBetween('created_at', [ $from , $to ])->count();
        $packages27 = Payment::where('product_id',$product27->product_id)->where('status','paid')->count();
        
        $product28 = Product::where('product_id','PRD0079')->first();
        $package28 = Payment::where('product_id',$product28->product_id)->where('status','paid')->whereBetween('created_at', [ $from , $to ])->count();
        $packages28 = Payment::where('product_id',$product28->product_id)->where('status','paid')->count();

        $product29 = Product::where('product_id','PRD0080')->first();
        $package29 = Payment::where('product_id',$product29->product_id)->where('status','paid')->whereBetween('created_at', [ $from , $to ])->count();
        $packages29 = Payment::where('product_id',$product29->product_id)->where('status','paid')->count();

        $product30 = Product::where('product_id','PRD0081')->first();
        $package30 = Payment::where('product_id',$product30->product_id)->where('status','paid')->whereBetween('created_at', [ $from , $to ])->count();
        $packages30 = Payment::where('product_id',$product30->product_id)->where('status','paid')->count();

        $product31 = Product::where('product_id','PRD0086')->first();
        $package31 = Payment::where('product_id',$product31->product_id)->where('status','paid')->whereBetween('created_at', [ $from , $to ])->count();
        $packages31 = Payment::where('product_id',$product31->product_id)->where('status','paid')->count();

        $product32 = Product::where('product_id','PRD0083')->first();
        $package32 = Payment::where('product_id',$product32->product_id)->where('status','paid')->whereBetween('created_at', [ $from , $to ])->count();
        $packages32 = Payment::where('product_id',$product32->product_id)->where('status','paid')->count();

        $product33 = Product::where('product_id','PRD0085')->first();
        $package33 = Payment::where('product_id',$product33->product_id)->where('status','paid')->whereBetween('created_at', [ $from , $to ])->count();
        $packages33 = Payment::where('product_id',$product33->product_id)->where('status','paid')->count();

        $product34 = Product::where('product_id','PRD0084')->first();
        $package34 = Payment::where('product_id',$product34->product_id)->where('status','paid')->whereBetween('created_at', [ $from , $to ])->count();
        $packages34 = Payment::where('product_id',$product34->product_id)->where('status','paid')->count();
        
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // MMB Berjuang Gandakan Jualan
        $product88 = Product::where('product_id','PRD0088')->first();
        $packages137 = Payment::where('product_id','PRD0088')->where('package_id','PKD00137')->where('status','paid')->count();
        $package137 = Payment::where('product_id','PRD0088')->where('package_id','PKD00137')->where('status','paid')->whereBetween('created_at', [ $from , $to ])->count();
        
        $packages138 = Payment::where('product_id','PRD0088')->where('package_id','PKD00138')->where('status','paid')->count();
        $package138 = Payment::where('product_id','PRD0088')->where('package_id','PKD00138')->where('status','paid')->whereBetween('created_at', [ $from , $to ])->count();
        

            // $text = "<b>".strtoupper('Momentum Bisnes Melaka')."</b>"."\n"."General : ".$packages15." (+".$package15.")"."\n"."Xcess : ".$packages24." (+".$package24.")"."\n"."Diamond : ".$packages16." (+".$package16.")"."\n\n"
            //         ."<b>".strtoupper('Momentum Bisnes Johor')."</b>"."\n"."General : ".$packages17." (+".$package17.")"."\n"."Xcess : ".$packages25." (+".$package25.")"."\n"."Diamond : ".$packages18." (+".$package18.")"."\n\n"
            //         ."<b>".strtoupper('Momentum Bisnes Kuala Lumpur')."</b>"."\n"."General : ".$packages27." (+".$package27.")"."\n"."Xcess : ".$packages26." (+".$package26.")"."\n"."Diamond : ".$packages28." (+".$package28.")"."\n\n"
            //         ."<b>".strtoupper('Momentum Bisnes Kota Bahru')."</b>"."\n"."General : ".$packages29." (+".$package29.")"."\n"."Xcess : ".$packages30." (+".$package30.")"."\n"."Diamond : ".$packages31." (+".$package31.")"."\n\n"
            //         ."<b>".strtoupper('Momentum Bisnes Penang')."</b>"."\n"."General : ".$packages32." (+".$package32.")"."\n"."Xcess : ".$packages33." (+".$package33.")"."\n"."Diamond : ".$packages34." (+".$package34.")"."\n\n";

            $text =  "<b>".strtoupper('MMB Berjuang Gandakan Jualan')."</b>"."\n"
            ."Date : ".$date_today."\n"."Duration : ".$duration."\n\n"
            ."( ARB Alumni + General )"."\n"."Total Registration : ".($packages137+$packages138)."\n\n"
            ."ARB Alumni : ".$packages137." (+".$package137.")"."\n"."General : ".$packages138." (+".$package138.")"."\n\n";
            Telegram::sendMessage([
                "chat_id" => env('TELEGRAM_CHAT_ID', '-1001581181483'), //group campaign
                "parse_mode" => "HTML",
                "text" => $text
            ]);
        return 0;

    }
}
