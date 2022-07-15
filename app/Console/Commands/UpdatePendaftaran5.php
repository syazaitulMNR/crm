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

class UpdatePendaftaran5 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:update5';

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

        ///////////////////////////////////////////////////////////////////////////
        // JB

        // $genjb = Product::where('product_id','PRD0057')->first();
        // $diajb = Product::where('product_id','PRD0058')->first();
        // $xcessjb = Product::where('product_id','PRD0074')->first();

        // // Ticket
        // $gjbtdisahkan = Ticket::where('attendance','kehadiran disahkan')->where('product_id', $genjb->product_id)->count();
        // $gjbthadir = Ticket::where('attendance','hadir')->where('product_id', $genjb->product_id)->count();
        // $gjbtth = Ticket::where('attendance','tidak hadir')->where('product_id', $genjb->product_id)->count();
        // $gjbtlain = Ticket::whereNull('attendance')->where('product_id', $genjb->product_id)->count();

        // // Payment
        // $gjbpdisahkan = Payment::where('attendance','kehadiran disahkan')->where('product_id',$genjb->product_id)->count();
        // $gjbphadir = Payment::where('attendance','hadir')->where('product_id', $genjb->product_id)->count();
        // $gjbpth = Payment::where('attendance','tidak hadir')->where('product_id', $genjb->product_id)->count();
        // $gjbplain = Payment::whereNull('attendance')->where('product_id', $genjb->product_id)->count();

        // // Ticket
        // $djbtdisahkan = Ticket::where('attendance','kehadiran disahkan')->where('product_id', $diajb->product_id)->count();
        // $djbthadir = Ticket::where('attendance','hadir')->where('product_id', $diajb->product_id)->count();
        // $djbtth = Ticket::where('attendance','tidak hadir')->where('product_id', $diajb->product_id)->count();
        // $djbtlain = Ticket::whereNull('attendance')->where('product_id', $diajb->product_id)->count();

        // // Payment
        // $djbpdisahkan = Payment::where('attendance','kehadiran disahkan')->where('product_id',$diajb->product_id)->count();
        // $djbphadir = Payment::where('attendance','hadir')->where('product_id', $diajb->product_id)->count();
        // $djbpth = Payment::where('attendance','tidak hadir')->where('product_id', $diajb->product_id)->count();
        // $djbplain = Payment::whereNull('attendance')->where('product_id', $diajb->product_id)->count();

        // // Ticket
        // $xjbtdisahkan = Ticket::where('attendance','kehadiran disahkan')->where('product_id', $xcessjb->product_id)->count();
        // $xjbthadir = Ticket::where('attendance','hadir')->where('product_id', $xcessjb->product_id)->count();
        // $xjbtth = Ticket::where('attendance','tidak hadir')->where('product_id', $xcessjb->product_id)->count();
        // $xjbtlain = Ticket::whereNull('attendance')->where('product_id', $xcessjb->product_id)->count();

        // // Payment
        // $xjbpdisahkan = Payment::where('attendance','kehadiran disahkan')->where('product_id',$xcessjb->product_id)->count();
        // $xjbphadir = Payment::where('attendance','hadir')->where('product_id', $xcessjb->product_id)->count();
        // $xjbpth = Payment::where('attendance','tidak hadir')->where('product_id', $xcessjb->product_id)->count();
        // $xjbplain = Payment::whereNull('attendance')->where('product_id', $xcessjb->product_id)->count();

        // ///////////////////////////////////////////////////////////////////////////

        // ///////////////////////////////////////////////////////////////////////////
        // // KL

        // $genkl = Product::where('product_id','PRD0077')->first();
        // $diakl = Product::where('product_id','PRD0079')->first();
        // $xcesskl = Product::where('product_id','PRD0078')->first();

        // // Ticket
        // $gkltdisahkan = Ticket::where('attendance','kehadiran disahkan')->where('product_id', $genkl->product_id)->count();
        // $gklthadir = Ticket::where('attendance','hadir')->where('product_id', $genkl->product_id)->count();
        // $gkltth = Ticket::where('attendance','tidak hadir')->where('product_id', $genkl->product_id)->count();
        // $gkltlain = Ticket::whereNull('attendance')->where('product_id', $genkl->product_id)->count();

        // // Payment
        // $gklpdisahkan = Payment::where('attendance','kehadiran disahkan')->where('product_id',$genkl->product_id)->count();
        // $gklphadir = Payment::where('attendance','hadir')->where('product_id', $genkl->product_id)->count();
        // $gklpth = Payment::where('attendance','tidak hadir')->where('product_id', $genkl->product_id)->count();
        // $gklplain = Payment::whereNull('attendance')->where('product_id', $genkl->product_id)->count();

        // // Ticket
        // $dkltdisahkan = Ticket::where('attendance','kehadiran disahkan')->where('product_id', $diakl->product_id)->count();
        // $dklthadir = Ticket::where('attendance','hadir')->where('product_id', $diakl->product_id)->count();
        // $dkltth = Ticket::where('attendance','tidak hadir')->where('product_id', $diakl->product_id)->count();
        // $dkltlain = Ticket::whereNull('attendance')->where('product_id', $diakl->product_id)->count();

        // // Payment
        // $dklpdisahkan = Payment::where('attendance','kehadiran disahkan')->where('product_id',$diakl->product_id)->count();
        // $dklphadir = Payment::where('attendance','hadir')->where('product_id', $diakl->product_id)->count();
        // $dklpth = Payment::where('attendance','tidak hadir')->where('product_id', $diakl->product_id)->count();
        // $dklplain = Payment::whereNull('attendance')->where('product_id', $diakl->product_id)->count();

        // // Ticket
        // $xkltdisahkan = Ticket::where('attendance','kehadiran disahkan')->where('product_id', $xcesskl->product_id)->count();
        // $xklthadir = Ticket::where('attendance','hadir')->where('product_id', $xcesskl->product_id)->count();
        // $xkltth = Ticket::where('attendance','tidak hadir')->where('product_id', $xcesskl->product_id)->count();
        // $xkltlain = Ticket::whereNull('attendance')->where('product_id', $xcesskl->product_id)->count();

        // // Payment
        // $xklpdisahkan = Payment::where('attendance','kehadiran disahkan')->where('product_id',$xcesskl->product_id)->count();
        // $xklphadir = Payment::where('attendance','hadir')->where('product_id', $xcesskl->product_id)->count();
        // $xklpth = Payment::where('attendance','tidak hadir')->where('product_id', $xcesskl->product_id)->count();
        // $xklplain = Payment::whereNull('attendance')->where('product_id', $xcesskl->product_id)->count();

        // ///////////////////////////////////////////////////////////////////////////

        ///////////////////////////////////////////////////////////////////////////
        // KOTA BAHRU

        $genkb = Product::where('product_id','PRD0080')->first();
        $diakb = Product::where('product_id','PRD0086')->first();
        $xcesskb = Product::where('product_id','PRD0081')->first();

        // Ticket
        $gkbtdisahkan = Ticket::where('attendance','kehadiran disahkan')->where('product_id', $genkb->product_id)->count();
        $gkbthadir = Ticket::where('attendance','hadir')->where('product_id', $genkb->product_id)->count();
        $gkbtth = Ticket::where('attendance','tidak hadir')->where('product_id', $genkb->product_id)->count();
        $gkbtlain = Ticket::whereNull('attendance')->where('product_id', $genkb->product_id)->count();

        // Payment
        $gkbpdisahkan = Payment::where('attendance','kehadiran disahkan')->where('product_id',$genkb->product_id)->count();
        $gkbphadir = Payment::where('attendance','hadir')->where('product_id', $genkb->product_id)->count();
        $gkbpth = Payment::where('attendance','tidak hadir')->where('product_id', $genkb->product_id)->count();
        $gkbplain = Payment::whereNull('attendance')->where('product_id', $genkb->product_id)->count();

        // Ticket
        $dkbtdisahkan = Ticket::where('attendance','kehadiran disahkan')->where('product_id', $diakb->product_id)->count();
        $dkbthadir = Ticket::where('attendance','hadir')->where('product_id', $diakb->product_id)->count();
        $dkbtth = Ticket::where('attendance','tidak hadir')->where('product_id', $diakb->product_id)->count();
        $dkblain = Ticket::whereNull('attendance')->where('product_id', $diakb->product_id)->count();

        // Payment
        $dkbpdisahkan = Payment::where('attendance','kehadiran disahkan')->where('product_id',$diakb->product_id)->count();
        $dkbphadir = Payment::where('attendance','hadir')->where('product_id', $diakb->product_id)->count();
        $dkbpth = Payment::where('attendance','tidak hadir')->where('product_id', $diakb->product_id)->count();
        $dkbplain = Payment::whereNull('attendance')->where('product_id', $diakb->product_id)->count();

        // Ticket
        $xkbtdisahkan = Ticket::where('attendance','kehadiran disahkan')->where('product_id', $xcesskb->product_id)->count();
        $xkbthadir = Ticket::where('attendance','hadir')->where('product_id', $xcesskb->product_id)->count();
        $xkbtth = Ticket::where('attendance','tidak hadir')->where('product_id', $xcesskb->product_id)->count();
        $xkbtlain = Ticket::whereNull('attendance')->where('product_id', $xcesskb->product_id)->count();

        // Payment
        $xkbpdisahkan = Payment::where('attendance','kehadiran disahkan')->where('product_id',$xcesskb->product_id)->count();
        $xkbphadir = Payment::where('attendance','hadir')->where('product_id', $xcesskb->product_id)->count();
        $xkbpth = Payment::where('attendance','tidak hadir')->where('product_id', $xcesskb->product_id)->count();
        $xkbplain = Payment::whereNull('attendance')->where('product_id', $xcesskb->product_id)->count();

        ///////////////////////////////////////////////////////////////////////////

        ///////////////////////////////////////////////////////////////////////////
        // PENANG

        $genp = Product::where('product_id','PRD0083')->first();
        $diap = Product::where('product_id','PRD0084')->first();
        $xcessp = Product::where('product_id','PRD0085')->first();

        // Ticket
        $gptdisahkan = Ticket::where('attendance','kehadiran disahkan')->where('product_id', $genp->product_id)->count();
        $gpthadir = Ticket::where('attendance','hadir')->where('product_id', $genp->product_id)->count();
        $gptth = Ticket::where('attendance','tidak hadir')->where('product_id', $genp->product_id)->count();
        $gptlain = Ticket::whereNull('attendance')->where('product_id', $genp->product_id)->count();

        // Payment
        $gppdisahkan = Payment::where('attendance','kehadiran disahkan')->where('product_id',$genp->product_id)->count();
        $gpphadir = Payment::where('attendance','hadir')->where('product_id', $genp->product_id)->count();
        $gppth = Payment::where('attendance','tidak hadir')->where('product_id', $genp->product_id)->count();
        $gpplain = Payment::whereNull('attendance')->where('product_id', $genp->product_id)->count();

        // Ticket
        $dptdisahkan = Ticket::where('attendance','kehadiran disahkan')->where('product_id', $diap->product_id)->count();
        $dpthadir = Ticket::where('attendance','hadir')->where('product_id', $diap->product_id)->count();
        $dptth = Ticket::where('attendance','tidak hadir')->where('product_id', $diap->product_id)->count();
        $dptlain = Ticket::whereNull('attendance')->where('product_id', $diap->product_id)->count();

        // Payment
        $dppdisahkan = Payment::where('attendance','kehadiran disahkan')->where('product_id',$diap->product_id)->count();
        $dpphadir = Payment::where('attendance','hadir')->where('product_id', $diap->product_id)->count();
        $dppth = Payment::where('attendance','tidak hadir')->where('product_id', $diap->product_id)->count();
        $dpplain = Payment::whereNull('attendance')->where('product_id', $diap->product_id)->count();

        // Ticket
        $xptdisahkan = Ticket::where('attendance','kehadiran disahkan')->where('product_id', $xcessp->product_id)->count();
        $xpthadir = Ticket::where('attendance','hadir')->where('product_id', $xcessp->product_id)->count();
        $xptth = Ticket::where('attendance','tidak hadir')->where('product_id', $xcessp->product_id)->count();
        $xptlain = Ticket::whereNull('attendance')->where('product_id', $xcessp->product_id)->count();

        // Payment
        $xppdisahkan = Payment::where('attendance','kehadiran disahkan')->where('product_id',$xcessp->product_id)->count();
        $xpphadir = Payment::where('attendance','hadir')->where('product_id', $xcessp->product_id)->count();
        $xppth = Payment::where('attendance','tidak hadir')->where('product_id', $xcessp->product_id)->count();
        $xplain = Payment::whereNull('attendance')->where('product_id', $xcessp->product_id)->count();

        ///////////////////////////////////////////////////////////////////////////



        // // Ticket
        // $tdisahkan = Ticket::where('attendance','kehadiran disahkan')->where('product_id', $product_id)->count();
        // $thadir = Ticket::where('attendance','hadir')->where('product_id', $product_id)->count();
        // $tth = Ticket::where('attendance','tidak hadir')->where('product_id', $product_id)->count();
        // $tlain = Ticket::whereNull('attendance')->where('product_id', $product_id)->count();

        // // Payment
        // $pdisahkan = Payment::where('attendance','kehadiran disahkan')->where('product_id',$product_id)->count();
        // $phadir = Payment::where('attendance','hadir')->where('product_id', $product_id)->count();
        // $pth = Payment::where('attendance','tidak hadir')->where('product_id', $product_id)->count();
        // $plain = Payment::whereNull('attendance')->where('product_id', $product_id)->count();

        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        
        // $textes = strtoupper("KEHADIRAN MOMENTUM BISNES 2022")."\n"."Date : ".$date_today."\n"."\n"
        //             // .strtoupper('Momentum Bisnes Johor')."\n"."GENERAL"."\n"."Hadir : ".($gjbthadir+$gjbphadir)."\n"."Tidak Hadir : ".($gjbtth+$gjbpth)."\n\n"
        //             // ."XCESS"."\n"."Hadir : ".($xjbthadir+$xjbphadir)."\n"."Tidak Hadir : ".($xjbtth+$xjbpth)."\n\n"
        //             // ."DIAMOND"."\n"."Hadir : ".($djbthadir+$djbphadir)."\n"."Tidak Hadir : ".($djbtth+$djbpth)."\n\n"
        //             // .strtoupper('Momentum Bisnes Kuala Lumpur')."\n"."GENERAL"."\n"."Hadir : ".($gklthadir+$gklphadir)."\n"."Tidak Hadir : ".($gkltth+$gklpth)."\n\n"
        //             // ."XCESS"."\n"."Hadir : ".($xklthadir+$xklphadir)."\n"."Tidak Hadir : ".($xkltth+$xklpth)."\n\n"
        //             // ."DIAMOND"."\n"."Hadir : ".($dklthadir+$dklphadir)."\n"."Tidak Hadir : ".($dkltth+$dklpth)."\n\n"
        //             .strtoupper('Momentum Bisnes Kota Bahru')."\n"."GENERAL"."\n"."Hadir : ".($gkbthadir+$gkbphadir)."\n"."Tidak Hadir : ".($gkbtth+$gkbpth)."\n\n"
        //             ."XCESS"."\n"."Hadir : ".($xkbthadir+$xkbphadir)."\n"."Tidak Hadir : ".($xkbtth+$xkbpth)."\n\n"
        //             ."DIAMOND"."\n"."Hadir : ".($dkbthadir+$dkbphadir)."\n"."Tidak Hadir : ".($dkbtth+$dkbpth)."\n\n"
        //             .strtoupper('Momentum Bisnes Penang')."\n"."GENERAL"."\n"."Hadir : ".($gpthadir+$gpphadir)."\n"."Tidak Hadir : ".($gptth+$gppth)."\n\n"
        //             ."XCESS"."\n"."Hadir : ".($xpthadir+$xpphadir)."\n"."Tidak Hadir : ".($xptth+$xppth)."\n\n"
        //             ."DIAMOND"."\n"."Hadir : ".($dpthadir+$dpphadir)."\n"."Tidak Hadir : ".($dptth+$dppth);
        // Telegram::sendMessage([
        //     "chat_id" => env('TELEGRAM_CHAT_ID', '-1001581181483'),
        //     "parse_mode" => "HTML",
        //     "text" => $textes
        // ]);

    }
}
