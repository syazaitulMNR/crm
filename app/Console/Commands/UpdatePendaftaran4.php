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
        $date_today = Carbon::now('Asia/Kuala_Lumpur')->format('d-m-Y');
        $date_tomorrow = Carbon::tomorrow('Asia/Kuala_Lumpur')->format('d-m-Y');
        $start_times = date($date_today.'00:00:00');
        $end_times = date($date_tomorrow.'16:00:00');

        $start_time = Carbon::parse($start_times)->toDateTimeString();
        $end_time = Carbon::parse($end_times)->toDateTimeString();

        $product1 = Product::where('product_id','PRD0039')->first();
        $package1 = Payment::where('product_id',$product1->product_id)->where('status','paid')->count();
        $packages1 = Payment::where('product_id',$product1->product_id)->where('status','paid')->count();

        $product2 = Product::where('product_id','PRD0040')->first();
        $package2 = Payment::where('product_id',$product2->product_id)->where('status','paid')->count();
        $packages2 = Payment::where('product_id',$product2->product_id)->where('status','paid')->count();
        $totalsale2 = Payment::where('product_id',$product2->product_id)->where('status','paid')->sum('totalprice');

        $product3 = Product::where('product_id','PRD0041')->first();
        $package3 = Payment::where('product_id',$product3->product_id)->where('status','paid')->count();
        $packages3 = Payment::where('product_id',$product3->product_id)->where('status','paid')->count();

        $product4 = Product::where('product_id','PRD0042')->first();
        $package4 = Payment::where('product_id',$product4->product_id)->where('status','paid')->count();
        $packages4 = Payment::where('product_id',$product4->product_id)->where('status','paid')->count();
        $totalsale4 = Payment::where('product_id',$product4->product_id)->where('status','paid')->sum('totalprice');

        $product5 = Product::where('product_id','PRD0043')->first();
        $package5 = Payment::where('product_id',$product5->product_id)->where('status','paid')->count();
        $packages5 = Payment::where('product_id',$product5->product_id)->where('status','paid')->count();

        $product6 = Product::where('product_id','PRD0044')->first();
        $package6 = Payment::where('product_id',$product6->product_id)->where('status','paid')->count();
        $packages6 = Payment::where('product_id',$product6->product_id)->where('status','paid')->count();
        $totalsale6 = Payment::where('product_id',$product6->product_id)->where('status','paid')->sum('totalprice');

        $product7 = Product::where('product_id','PRD0047')->first();
        $package7 = Payment::where('product_id',$product7->product_id)->where('status','paid')->count();
        $packages7 = Payment::where('product_id',$product7->product_id)->where('status','paid')->count();

        $product8 = Product::where('product_id','PRD0048')->first();
        $package8 = Payment::where('product_id',$product8->product_id)->where('status','paid')->count();
        $packages8 = Payment::where('product_id',$product8->product_id)->where('status','paid')->count();
        $totalsale8 = Payment::where('product_id',$product8->product_id)->where('status','paid')->sum('totalprice');

        $product9 = Product::where('product_id','PRD0049')->first();
        $package9 = Payment::where('product_id',$product9->product_id)->where('status','paid')->count();
        $packages9 = Payment::where('product_id',$product9->product_id)->where('status','paid')->count();

        $product10 = Product::where('product_id','PRD0050')->first();
        $package10 = Payment::where('product_id',$product10->product_id)->where('status','paid')->count();
        $packages10 = Payment::where('product_id',$product10->product_id)->where('status','paid')->count();
        $totalsale10 = Payment::where('product_id',$product10->product_id)->where('status','paid')->sum('totalprice');

        $product11 = Product::where('product_id','PRD0051')->first();
        $package11 = Payment::where('product_id',$product11->product_id)->where('status','paid')->count();
        $packages11 = Payment::where('product_id',$product11->product_id)->where('status','paid')->count();

        $product12 = Product::where('product_id','PRD0052')->first();
        $package12 = Payment::where('product_id',$product12->product_id)->where('status','paid')->count();
        $packages12 = Payment::where('product_id',$product12->product_id)->where('status','paid')->count();
        $totalsale12 = Payment::where('product_id',$product12->product_id)->where('status','paid')->sum('totalprice');

        $product13 = Product::where('product_id','PRD0053')->first();
        $package13 = Payment::where('product_id',$product13->product_id)->where('status','paid')->count();
        $packages13 = Payment::where('product_id',$product13->product_id)->where('status','paid')->count();

        $product14 = Product::where('product_id','PRD0054')->first();
        $package14 = Payment::where('product_id',$product14->product_id)->where('status','paid')->count();
        $packages14 = Payment::where('product_id',$product14->product_id)->where('status','paid')->count();
        $totalsale14 = Payment::where('product_id',$product14->product_id)->where('status','paid')->sum('totalprice');

        $product15 = Product::where('product_id','PRD0055')->first();
        $package15 = Payment::where('product_id',$product15->product_id)->where('status','paid')->count();
        $packages15 = Payment::where('product_id',$product15->product_id)->where('status','paid')->count();

        $product16 = Product::where('product_id','PRD0056')->first();
        $package16 = Payment::where('product_id',$product16->product_id)->where('status','paid')->count();
        $packages16 = Payment::where('product_id',$product16->product_id)->where('status','paid')->count();
        $totalsale16 = Payment::where('product_id',$product16->product_id)->where('status','paid')->sum('totalprice');
        
        $product17 = Product::where('product_id','PRD0057')->first();
        $package17 = Payment::where('product_id',$product17->product_id)->where('status','paid')->count();
        $packages17 = Payment::where('product_id',$product17->product_id)->where('status','paid')->count();

        $product18 = Product::where('product_id','PRD0058')->first();
        $package18 = Payment::where('product_id',$product18->product_id)->where('status','paid')->count();
        $packages18 = Payment::where('product_id',$product18->product_id)->where('status','paid')->count();
        $totalsale18 = Payment::where('product_id',$product18->product_id)->where('status','paid')->sum('totalprice');
        
        $textes = strtoupper("MOMENTUM BISNES 2022 (ALL TIME)")."\n"."\n\n"."Today Registration : ".($package1+$package2+$package3+$package4+$package5+$package6+$package7+$package8+$package9+$package10+$package11+$package12+$package13+$package14+$package15+$package16)." ( RM".($totalsale2+$totalsale4+$totalsale6+$totalsale8+$totalsale10+$totalsale12+$totalsale14+$totalsale16)." )"."\n"."General : ".($package1+$package3+$package5+$package7+$package9+$package11+$package13+$package15+$package17)."\n"."Diamond : ".($package2+$package4+$package6+$package8+$package10+$package12+$package14+$package16+$package18)."\n\n"
                    ."<b>".strtoupper('Momentum Bisnes Johor')."</b>"."\n"."General : "." (+".$package1.")"."\n"."Diamond : "." (+".$package2.")"."\n"."Total Collection : RM".$totalsale2."\n\n"
                    ."<b>".strtoupper('Momentum Bisnes Kuala Lumpur')."</b>"."\n"."General : "." (+".$package3.")"."\n"."Diamond : "." (+".$package4.")"."\n"."Total Collection : RM".$totalsale4."\n\n"
                    ."<b>".strtoupper('Momentum Bisnes Kedah')."</b>"."\n"."General : "." (+".$package5.")"."\n"."Diamond : "." (+".$package6.")"."\n"."Total Collection : RM".$totalsale6."\n\n"
                    ."<b>".strtoupper('Momentum Bisnes Shah Alam')."</b>"."\n"."General : "." (+".$package7.")"."\n"."Diamond : "." (+".$package8.")"."\n"."Total Collection : RM".$totalsale8."\n\n"
                    ."<b>".strtoupper('Momentum Bisnes Kota Bahru')."</b>"."\n"."General : "." (+".$package9.")"."\n"."Diamond : "." (+".$package10.")"."\n"."Total Collection : RM".$totalsale10."\n\n"
                    ."<b>".strtoupper('Momentum Bisnes Kuantan')."</b>"."\n"."General : "." (+".$package11.")"."\n"."Diamond : "." (+".$package12.")"."\n"."Total Collection : RM".$totalsale12."\n\n"
                    ."<b>".strtoupper('Momentum Bisnes Sabah')."</b>"."\n"."General : "." (+".$package13.")"."\n"."Diamond : "." (+".$package14.")"."\n"."Total Collection : RM".$totalsale14."\n\n"
                    ."<b>".strtoupper('Momentum Bisnes Melaka')."</b>"."\n"."General : "." (+".$package15.")"."\n"."Diamond : "." (+".$package16.")"."\n"."Total Collection : RM".$totalsale16."\n";
        Telegram::sendMessage([
            "chat_id" => env('TELEGRAM_CHAT_ID', ''),
            "parse_mode" => "HTML",
            "text" => $textes
        ]);

    }
}
