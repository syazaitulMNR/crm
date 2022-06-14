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

class UpdatePendaftaran4 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:update4';

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
        $date_today = '01-06-2022';
        $date_end = Carbon::now('Asia/Kuala_Lumpur')->format('d-m-Y');
        $start_times = date($date_today.'00:00:00');
        $end_times = date($date_end.'00:00:00');

        $start_time = Carbon::parse($start_times)->toDateTimeString();
        $end_time = Carbon::parse($end_times)->toDateTimeString();

        $product1 = Product::where('product_id','PRD0039')->first();
        $package1 = Payment::where('product_id',$product1->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $packages1 = Payment::where('product_id',$product1->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();

        $product2 = Product::where('product_id','PRD0040')->first();
        $package2 = Payment::where('product_id',$product2->product_id)->whereBetween('created_at', [ $start_times, $end_time ])->where('status','paid')->count();
        $packages2 = Payment::where('product_id',$product2->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $totalsale2 = Payment::where('product_id',$product2->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->sum('totalprice');

        $product3 = Product::where('product_id','PRD0041')->first();
        $package3 = Payment::where('product_id',$product3->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $packages3 = Payment::where('product_id',$product3->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();

        $product4 = Product::where('product_id','PRD0042')->first();
        $package4 = Payment::where('product_id',$product4->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $packages4 = Payment::where('product_id',$product4->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $totalsale4 = Payment::where('product_id',$product4->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->sum('totalprice');

        $product5 = Product::where('product_id','PRD0043')->first();
        $package5 = Payment::where('product_id',$product5->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $packages5 = Payment::where('product_id',$product5->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();

        $product6 = Product::where('product_id','PRD0044')->first();
        $package6 = Payment::where('product_id',$product6->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $packages6 = Payment::where('product_id',$product6->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $totalsale6 = Payment::where('product_id',$product6->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->sum('totalprice');

        $product7 = Product::where('product_id','PRD0047')->first();
        $package7 = Payment::where('product_id',$product7->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $packages7 = Payment::where('product_id',$product7->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();

        $product8 = Product::where('product_id','PRD0048')->first();
        $package8 = Payment::where('product_id',$product8->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $packages8 = Payment::where('product_id',$product8->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $totalsale8 = Payment::where('product_id',$product8->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->sum('totalprice');

        $product9 = Product::where('product_id','PRD0049')->first();
        $package9 = Payment::where('product_id',$product9->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $packages9 = Payment::where('product_id',$product9->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();

        $product10 = Product::where('product_id','PRD0050')->first();
        $package10 = Payment::where('product_id',$product10->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $packages10 = Payment::where('product_id',$product10->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $totalsale10 = Payment::where('product_id',$product10->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->sum('totalprice');

        $product11 = Product::where('product_id','PRD0051')->first();
        $package11 = Payment::where('product_id',$product11->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $packages11 = Payment::where('product_id',$product11->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();

        $product12 = Product::where('product_id','PRD0052')->first();
        $package12 = Payment::where('product_id',$product12->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $packages12 = Payment::where('product_id',$product12->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $totalsale12 = Payment::where('product_id',$product12->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->sum('totalprice');

        $product13 = Product::where('product_id','PRD0053')->first();
        $package13 = Payment::where('product_id',$product13->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $packages13 = Payment::where('product_id',$product13->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();

        $product14 = Product::where('product_id','PRD0054')->first();
        $package14 = Payment::where('product_id',$product14->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $packages14 = Payment::where('product_id',$product14->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $totalsale14 = Payment::where('product_id',$product14->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->sum('totalprice');

        $product15 = Product::where('product_id','PRD0055')->first();
        $package15 = Payment::where('product_id',$product15->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $packages15 = Payment::where('product_id',$product15->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();

        $product16 = Product::where('product_id','PRD0056')->first();
        $package16 = Payment::where('product_id',$product16->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $packages16 = Payment::where('product_id',$product16->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $totalsale16 = Payment::where('product_id',$product16->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->sum('totalprice');
        
        $product17 = Product::where('product_id','PRD0057')->first();
        $package17 = Payment::where('product_id',$product17->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $packages17 = Payment::where('product_id',$product17->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();

        $product18 = Product::where('product_id','PRD0058')->first();
        $package18 = Payment::where('product_id',$product18->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $packages18 = Payment::where('product_id',$product18->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $totalsale18 = Payment::where('product_id',$product18->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->sum('totalprice');

        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // XCESS //

        $product19 = Product::where('product_id','PRD0068')->first();
        $package19 = Payment::where('product_id',$product18->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $packages19 = Payment::where('product_id',$product18->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $totalsale19 = Payment::where('product_id',$product18->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->sum('totalprice');

        $product20 = Product::where('product_id','PRD0069')->first();
        $package20 = Payment::where('product_id',$product20->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $packages20 = Payment::where('product_id',$product20->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $totalsale20 = Payment::where('product_id',$product20->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->sum('totalprice');

        $product21 = Product::where('product_id','PRD0070')->first();
        $package21 = Payment::where('product_id',$product21->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $packages21 = Payment::where('product_id',$product21->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $totalsale21 = Payment::where('product_id',$product21->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->sum('totalprice');

        $product22 = Product::where('product_id','PRD0071')->first();
        $package22 = Payment::where('product_id',$product22->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $packages22 = Payment::where('product_id',$product22->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $totalsale22 = Payment::where('product_id',$product22->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->sum('totalprice');

        $product23 = Product::where('product_id','PRD0072')->first();
        $package23 = Payment::where('product_id',$product23->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $packages23 = Payment::where('product_id',$product23->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $totalsale23 = Payment::where('product_id',$product23->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->sum('totalprice');

        $product24 = Product::where('product_id','PRD0073')->first();
        $package24 = Payment::where('product_id',$product24->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $packages24 = Payment::where('product_id',$product24->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $totalsale24 = Payment::where('product_id',$product24->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->sum('totalprice');

        $product25 = Product::where('product_id','PRD0074')->first();
        $package25 = Payment::where('product_id',$product25->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $packages25 = Payment::where('product_id',$product25->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $totalsale25 = Payment::where('product_id',$product25->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->sum('totalprice');

        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $product26 = Product::where('product_id','PRD0077')->first();
        $package26 = Payment::where('product_id',$product26->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $packages26 = Payment::where('product_id',$product26->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $totalsale26 = Payment::where('product_id',$product26->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->sum('totalprice');

        $product27 = Product::where('product_id','PRD0078')->first();
        $package27 = Payment::where('product_id',$product27->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $packages27 = Payment::where('product_id',$product27->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $totalsale27 = Payment::where('product_id',$product27->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->sum('totalprice');

        $product28 = Product::where('product_id','PRD0079')->first();
        $package28 = Payment::where('product_id',$product28->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $packages28 = Payment::where('product_id',$product28->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->count();
        $totalsale28 = Payment::where('product_id',$product28->product_id)->whereBetween('created_at', [ $start_time , $end_time ])->where('status','paid')->sum('totalprice');
                
        $textes = strtoupper("MOMENTUM BISNES 2022 (1/6 - 14/6)")."\n"."\n"."Today Registration : ".($package15+$package16+$package24+$package17+$package18+$package25+$package26+$package27+$package28+$package13+$package23+$package14)." ( RM".($totalsale16+$totalsale24+$totalsale18+$totalsale25+$totalsale27+$totalsale28+$totalsale14+$totalsale23)." )"."\n"."General : ".($package15+$package17+$package26+$package13)."\n"."Xcess : ".($package24+$package25+$package27+$package23)."\n"."Diamond : ".($package16+$package18+$package28+$package14)."\n\n"
                    ."<b>".strtoupper('Momentum Bisnes Sabah')."</b>"."\n"."General : "." (+".$package13.")"."\n"."Xcess : "." (+".$package23.")"."\n"."Diamond : "." (+".$package14.")"."\n"."Total Collection : RM".($totalsale14+$totalsale23)."\n\n"
                    ."<b>".strtoupper('Momentum Bisnes Melaka')."</b>"."\n"."General : "." (+".$package15.")"."\n"."Xcess : "." (+".$package24.")"."\n"."Diamond : "." (+".$package16.")"."\n"."Total Collection : RM".($totalsale16+$totalsale24)."\n\n"
                    ."<b>".strtoupper('Momentum Bisnes Johor')."</b>"."\n"."General : "." (+".$package17.")"."\n"."Xcess : "." (+".$package25.")"."\n"."Diamond : "." (+".$package18.")"."\n"."Total Collection : RM".($totalsale18+$totalsale25)."\n\n"
                    ."<b>".strtoupper('Momentum Bisnes Kuala Lumpur')."</b>"."\n"."General : "." (+".$package26.")"."\n"."Xcess : "." (+".$package27.")"."\n"."Diamond : "." (+".$package28.")"."\n"."Total Collection : RM".($totalsale27+$totalsale28)."\n";
        Telegram::sendMessage([
            "chat_id" => env('TELEGRAM_CHAT_ID', ''),
            "parse_mode" => "HTML",
            "text" => $textes
        ]);

    }
}
