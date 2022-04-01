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

class UpdatePendaftaran3 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:update3';

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
        $start_time = date($date_today.' 16:00:00');
        $end_time = date($date_today.' 08:59:59');

        $product1 = Product::where('product_id','PRD0039')->first();
        $package1 = Payment::where('product_id',$product1->product_id)->where('status','paid')->whereBetween('created_at', [ $start_time , $end_time ])->count();
        $packages1 = Payment::where('product_id',$product1->product_id)->where('status','paid')->count();

        $product2 = Product::where('product_id','PRD0040')->first();
        $package2 = Payment::where('product_id',$product2->product_id)->where('status','paid')->whereBetween('created_at', [ $start_time , $end_time  ])->count();
        $packages2 = Payment::where('product_id',$product2->product_id)->where('status','paid')->count();

        $product3 = Product::where('product_id','PRD0041')->first();
        $package3 = Payment::where('product_id',$product3->product_id)->where('status','paid')->whereBetween('created_at', [ $start_time , $end_time  ])->count();
        $packages3 = Payment::where('product_id',$product3->product_id)->where('status','paid')->count();

        $product4 = Product::where('product_id','PRD0042')->first();
        $package4 = Payment::where('product_id',$product4->product_id)->where('status','paid')->whereBetween('created_at', [ $start_time , $end_time  ])->count();
        $packages4 = Payment::where('product_id',$product4->product_id)->where('status','paid')->count();

        $product5 = Product::where('product_id','PRD0043')->first();
        $package5 = Payment::where('product_id',$product5->product_id)->where('status','paid')->whereBetween('created_at', [ $start_time , $end_time  ])->count();
        $packages5 = Payment::where('product_id',$product5->product_id)->where('status','paid')->count();

        $product6 = Product::where('product_id','PRD0044')->first();
        $package6 = Payment::where('product_id',$product6->product_id)->where('status','paid')->whereBetween('created_at', [ $start_time , $end_time  ])->count();
        $packages6 = Payment::where('product_id',$product6->product_id)->where('status','paid')->count();

        $product7 = Product::where('product_id','PRD0047')->first();
        $package7 = Payment::where('product_id',$product7->product_id)->where('status','paid')->whereBetween('created_at', [ $start_time , $end_time  ])->count();
        $packages7 = Payment::where('product_id',$product7->product_id)->where('status','paid')->count();

        $product8 = Product::where('product_id','PRD0048')->first();
        $package8 = Payment::where('product_id',$product8->product_id)->where('status','paid')->whereBetween('created_at', [ $start_time , $end_time  ])->count();
        $packages8 = Payment::where('product_id',$product8->product_id)->where('status','paid')->count();

        $product9 = Product::where('product_id','PRD0049')->first();
        $package9 = Payment::where('product_id',$product9->product_id)->where('status','paid')->whereBetween('created_at', [ $start_time , $end_time  ])->count();
        $packages9 = Payment::where('product_id',$product9->product_id)->where('status','paid')->count();

        $product10 = Product::where('product_id','PRD0050')->first();
        $package10 = Payment::where('product_id',$product10->product_id)->where('status','paid')->whereBetween('created_at', [ $start_time , $end_time  ])->count();
        $packages10 = Payment::where('product_id',$product10->product_id)->where('status','paid')->count();

        $product11 = Product::where('product_id','PRD0051')->first();
        $package11 = Payment::where('product_id',$product11->product_id)->where('status','paid')->whereBetween('created_at', [ $start_time , $end_time  ])->count();
        $packages11 = Payment::where('product_id',$product11->product_id)->where('status','paid')->count();

        $product12 = Product::where('product_id','PRD0052')->first();
        $package12 = Payment::where('product_id',$product12->product_id)->where('status','paid')->whereBetween('created_at', [ $start_time , $end_time  ])->count();
        $packages12 = Payment::where('product_id',$product12->product_id)->where('status','paid')->count();

        $product13 = Product::where('product_id','PRD0053')->first();
        $package13 = Payment::where('product_id',$product13->product_id)->where('status','paid')->whereBetween('created_at', [ $start_time , $end_time  ])->count();
        $packages13 = Payment::where('product_id',$product13->product_id)->where('status','paid')->count();

        $product14 = Product::where('product_id','PRD0054')->first();
        $package14 = Payment::where('product_id',$product14->product_id)->where('status','paid')->whereBetween('created_at', [ $start_time , $end_time  ])->count();
        $packages14 = Payment::where('product_id',$product14->product_id)->where('status','paid')->count();

        $product15 = Product::where('product_id','PRD0055')->first();
        $package15 = Payment::where('product_id',$product15->product_id)->where('status','paid')->whereBetween('created_at', [ $start_time , $end_time  ])->count();
        $packages15 = Payment::where('product_id',$product15->product_id)->where('status','paid')->count();

        $product16 = Product::where('product_id','PRD0056')->first();
        $package16 = Payment::where('product_id',$product16->product_id)->where('status','paid')->whereBetween('created_at', [ $start_time , $end_time  ])->count();
        $packages16 = Payment::where('product_id',$product16->product_id)->where('status','paid')->count();
        
        $product17 = Product::where('product_id','PRD0057')->first();
        $package17 = Payment::where('product_id',$product17->product_id)->where('status','paid')->whereBetween('created_at', [ $start_time , $end_time  ])->count();
        $packages17 = Payment::where('product_id',$product17->product_id)->where('status','paid')->count();

        $product18 = Product::where('product_id','PRD0058')->first();
        $package18 = Payment::where('product_id',$product18->product_id)->where('status','paid')->whereBetween('created_at', [ $start_time , $end_time  ])->count();
        $packages18 = Payment::where('product_id',$product18->product_id)->where('status','paid')->count();
        
        $textes = strtoupper("MOMENTUM BISNES 2022 (TODAY)")."\n"."Date : ".$date_today."\n\n"."Today Registration : ".($package1+$package2+$package3+$package4+$package5+$package6+$package7+$package8+$package9+$package10+$package11+$package12+$package13+$package14+$package15+$package16)."\n"."General : ".($package1+$package3+$package5+$package7+$package9+$package11+$package13+$package15+$package17)."\n"."Diamond : ".($package2+$package4+$package6+$package8+$package10+$package12+$package14+$package16+$package18);
        Telegram::sendMessage([
            "chat_id" => env('TELEGRAM_CHAT_ID', ''),
            "parse_mode" => "HTML",
            "text" => $textes
        ]);

    }
}
