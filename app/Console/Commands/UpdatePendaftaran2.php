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


        /////////////////////////////////////////////////////////////////////
        // get product id
        // $listprd = ['PRD0039','PRD0040','PRD0041','PRD0042','PRD0043','PRD0044','PRD0047','PRD0048','PRD0049','PRD0050','PRD0051','PRD0052','PRD0053','PRD0054','PRD0055','PRD0056','PRD0057','PRD0058'];
        // $listprd = Product::where('class','MMB')->orderBy('id','asc')->get();
        // $count_product = count($listprd);

        // foreach ($listprd as $keyprd => $dataprd){
        //     $product = Product::where('product_id', $dataprd->product_id)->get();
        //     $package = Package::where('product_id', $product->product_id)->first();
        // }

        // foreach ($product as $keyprod => $dataprod){
        // for ($i = 0; $i < $count_product; $i++)
        // {
        //     // get report by 2 hours
        //     $registration[$i] = Payment::where('status','paid')->where('product_id', $product[$i]->product_id)->whereBetween('created_at', [ $from , $to ])->count();
            
        //     // get total registration
        //     $totalpackage[$i] = Payment::where('status','paid')->where('product_id', $product[$i]->product_id)->count();

        //     // get total collection
        //     $collection[$i] = Payment::where('status','paid')->where('product_id', $product[$i]->product_id)->sum('totalprice');
        // }
        // }

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

            $text = "<b>".strtoupper('Momentum Bisnes Johor')."</b>"."\n"."General : ".$packages1." (+".$package1.")"."\n"."Diamond : ".$packages2." (+".$package2.")"."\n\n"
                    ."<b>".strtoupper('Momentum Bisnes Kuala Lumpur')."</b>"."\n"."General : ".$packages3." (+".$package3.")"."\n"."Diamond : ".$packages4." (+".$package4.")"."\n\n"
                    ."<b>".strtoupper('Momentum Bisnes Kedah')."</b>"."\n"."General : ".$packages5." (+".$package5.")"."\n"."Diamond : ".$packages6." (+".$package6.")"."\n\n"
                    ."<b>".strtoupper('Momentum Bisnes Shah Alam')."</b>"."\n"."General : ".$packages7." (+".$package7.")"."\n"."Diamond : ".$packages8." (+".$package8.")"."\n\n"
                    ."<b>".strtoupper('Momentum Bisnes Kota Bahru')."</b>"."\n"."General : ".$packages9." (+".$package9.")"."\n"."Diamond : ".$packages10." (+".$package10.")"."\n\n"
                    ."<b>".strtoupper('Momentum Bisnes Kuantan')."</b>"."\n"."General : ".$packages11." (+".$package11.")"."\n"."Diamond : ".$packages12." (+".$package12.")"."\n\n"
                    ."<b>".strtoupper('Momentum Bisnes Sabah')."</b>"."\n"."General : ".$packages13." (+".$package13.")"."\n"."Diamond : ".$packages14." (+".$package14.")"."\n\n"
                    ."<b>".strtoupper('Momentum Bisnes Melaka')."</b>"."\n"."General : ".$packages15." (+".$package15.")"."\n"."Diamond : ".$packages16." (+".$package16.")"."\n";
            Telegram::sendMessage([
                "chat_id" => env('TELEGRAM_CHAT_ID', ''),
                "parse_mode" => "HTML",
                "text" => $text
            ]);
        return 0;

        // PENTINGGGGGGGGG //
        /////////////////////////////////////////////////////////////////////
        // $product = Product::where('product_id', 'PRD0037')->first();
        // $product_id = $product->product_id;

        // // get package
        // $package = Package::where('product_id', $product_id)->get();
        // $count_package = Package::where('product_id', $product_id)->count();

        // for ($i = 0; $i < $count_package; $i++)
        // {

        //     // get report by 2 hours
        //     $registration[$i] = Payment::where('status','paid')->where('product_id', $product_id)->where('package_id', $package[$i]->package_id)->whereBetween('created_at', [ $from , $to ])->count();
        //     $paidticket[$i] = Ticket::where('ticket_type', 'paid')->where('product_id', $product_id)->where('package_id', $package[$i]->package_id)->whereBetween('created_at', [ $from , $to ])->count();
        //     $freeticket[$i] = Ticket::where('ticket_type', 'free')->where('product_id', $product_id)->where('package_id', $package[$i]->package_id)->whereBetween('created_at', [ $from , $to ])->count();
            
        //     // get total registration
        //     $totalpackage[$i] = Payment::where('status','paid')->where('product_id', $product_id)->where('package_id', $package[$i]->package_id)->count();

        //     // get total collection
        //     $collection[$i] = Payment::where('status','paid')->where('product_id', $product_id)->where('package_id', $package[$i]->package_id)->sum('totalprice');

            
        // }
        
        // $total_now = Payment::where('product_id', $product_id)->where('status', 'paid')->whereBetween('created_at', [ date('Y-m-d 00:00:00') , date('Y-m-d H:i:s') ])->count();
        
        // $totalregister = Payment::where('status','paid')->where('product_id', $product_id)->count();

        // for ($i = 0; $i < $count_package; $i++){
        //     $text = "<b>".strtoupper($package[$i]->name)."</b>"."\n\n"."Total Ticket : ".$totalpackage[$i]."\n"."Current Registration (Hours)"." : +".number_format($registration[$i])."\n";
        //     Telegram::sendMessage([
        //         "chat_id" => env('TELEGRAM_CHAT_ID', ''),
        //         "parse_mode" => "HTML",
        //         "text" => $text
        //     ]);
        // }
        // return 0;
    }
}
