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
        // SABAH

        $gensp = Product::where('product_id','PRD0053')->first();
        $diasp = Product::where('product_id','PRD0054')->first();
        $xcesssp = Product::where('product_id','PRD0072')->first();

        // Ticket
        $gsptdisahkan = Ticket::where('attendance','kehadiran disahkan')->where('product_id', $gensp->product_id)->count();
        $gspthadir = Ticket::where('attendance','hadir')->where('product_id', $gensp->product_id)->count();
        $gsptth = Ticket::where('attendance','tidak hadir')->where('product_id', $gensp->product_id)->count();
        $gsptlain = Ticket::whereNull('attendance')->where('product_id', $gensp->product_id)->count();

        // Payment
        $gsppdisahkan = Payment::where('attendance','kehadiran disahkan')->where('product_id',$gensp->product_id)->count();
        $gspphadir = Payment::where('attendance','hadir')->where('product_id', $gensp->product_id)->count();
        $gsppth = Payment::where('attendance','tidak hadir')->where('product_id', $gensp->product_id)->count();
        $gspplain = Payment::whereNull('attendance')->where('product_id', $gensp->product_id)->count();

        // Ticket
        $dsptdisahkan = Ticket::where('attendance','kehadiran disahkan')->where('product_id', $diasp->product_id)->count();
        $dspthadir = Ticket::where('attendance','hadir')->where('product_id', $diasp->product_id)->count();
        $dsptth = Ticket::where('attendance','tidak hadir')->where('product_id', $diasp->product_id)->count();
        $dsptlain = Ticket::whereNull('attendance')->where('product_id', $diasp->product_id)->count();

        // Payment
        $dsppdisahkan = Payment::where('attendance','kehadiran disahkan')->where('product_id',$diasp->product_id)->count();
        $dspphadir = Payment::where('attendance','hadir')->where('product_id', $diasp->product_id)->count();
        $dsppth = Payment::where('attendance','tidak hadir')->where('product_id', $diasp->product_id)->count();
        $dspplain = Payment::whereNull('attendance')->where('product_id', $diasp->product_id)->count();

        // Ticket
        $xsptdisahkan = Ticket::where('attendance','kehadiran disahkan')->where('product_id', $xcesssp->product_id)->count();
        $xspthadir = Ticket::where('attendance','hadir')->where('product_id', $xcesssp->product_id)->count();
        $xsptth = Ticket::where('attendance','tidak hadir')->where('product_id', $xcesssp->product_id)->count();
        $xsptlain = Ticket::whereNull('attendance')->where('product_id', $xcesssp->product_id)->count();

        // Payment
        $xsppdisahkan = Payment::where('attendance','kehadiran disahkan')->where('product_id',$xcesssp->product_id)->count();
        $xspphadir = Payment::where('attendance','hadir')->where('product_id', $xcesssp->product_id)->count();
        $xsppth = Payment::where('attendance','tidak hadir')->where('product_id', $xcesssp->product_id)->count();
        $xspplain = Payment::whereNull('attendance')->where('product_id', $xcesssp->product_id)->count();

        ///////////////////////////////////////////////////////////////////////////

        ///////////////////////////////////////////////////////////////////////////
        // MELAKA

        $gensa = Product::where('product_id','PRD0055')->first();
        $diasa = Product::where('product_id','PRD0056')->first();
        $xcesssa = Product::where('product_id','PRD0073')->first();

        // Ticket
        $gsatdisahkan = Ticket::where('attendance','kehadiran disahkan')->where('product_id', $gensa->product_id)->count();
        $gsathadir = Ticket::where('attendance','hadir')->where('product_id', $gensa->product_id)->count();
        $gsatth = Ticket::where('attendance','tidak hadir')->where('product_id', $gensa->product_id)->count();
        $gsatlain = Ticket::whereNull('attendance')->where('product_id', $gensa->product_id)->count();

        // Payment
        $gsapdisahkan = Payment::where('attendance','kehadiran disahkan')->where('product_id',$gensa->product_id)->count();
        $gsaphadir = Payment::where('attendance','hadir')->where('product_id', $gensa->product_id)->count();
        $gsapth = Payment::where('attendance','tidak hadir')->where('product_id', $gensa->product_id)->count();
        $gsaplain = Payment::whereNull('attendance')->where('product_id', $gensa->product_id)->count();

        // Ticket
        $dsatdisahkan = Ticket::where('attendance','kehadiran disahkan')->where('product_id', $diasa->product_id)->count();
        $dsathadir = Ticket::where('attendance','hadir')->where('product_id', $diasa->product_id)->count();
        $dsatth = Ticket::where('attendance','tidak hadir')->where('product_id', $diasa->product_id)->count();
        $dsatlain = Ticket::whereNull('attendance')->where('product_id', $diasa->product_id)->count();

        // Payment
        $dsapdisahkan = Payment::where('attendance','kehadiran disahkan')->where('product_id',$diasa->product_id)->count();
        $dsaphadir = Payment::where('attendance','hadir')->where('product_id', $diasa->product_id)->count();
        $dsapth = Payment::where('attendance','tidak hadir')->where('product_id', $diasa->product_id)->count();
        $dsaplain = Payment::whereNull('attendance')->where('product_id', $diasa->product_id)->count();

        // Ticket
        $xsatdisahkan = Ticket::where('attendance','kehadiran disahkan')->where('product_id', $xcesssa->product_id)->count();
        $xsathadir = Ticket::where('attendance','hadir')->where('product_id', $xcesssa->product_id)->count();
        $xsatth = Ticket::where('attendance','tidak hadir')->where('product_id', $xcesssa->product_id)->count();
        $xsatlain = Ticket::whereNull('attendance')->where('product_id', $xcesssa->product_id)->count();

        // Payment
        $xsapdisahkan = Payment::where('attendance','kehadiran disahkan')->where('product_id',$xcesssa->product_id)->count();
        $xsaphadir = Payment::where('attendance','hadir')->where('product_id', $xcesssa->product_id)->count();
        $xsapth = Payment::where('attendance','tidak hadir')->where('product_id', $xcesssa->product_id)->count();
        $xsaplain = Payment::whereNull('attendance')->where('product_id', $xcesssa->product_id)->count();

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
        
        $textes = strtoupper("KEHADIRAN MOMENTUM BISNES 2022")."\n"."Date : ".$date_today."\n"."\n"
                    .strtoupper('Momentum Bisnes Sabah')."\n"."GENERAL"."\n"."Hadir : ".($gspthadir+$gspphadir)."\n"."Tidak Hadir : ".($gsptth+$gsppth)."\n\n"
                    ."XCESS"."\n"."Hadir : ".($xspthadir+$xspphadir)."\n"."Tidak Hadir : ".($xsptth+$xsppth)."\n\n"
                    ."DIAMOND"."\n"."Hadir : ".($dspthadir+$dspphadir)."\n"."Tidak Hadir : ".($dsptth+$dsppth)."\n\n"
                    .strtoupper('Momentum Bisnes Melaka')."\n"."GENERAL"."\n"."Hadir : ".($gsathadir+$gsaphadir)."\n"."Tidak Hadir : ".($gsatth+$gsppth)."\n\n"
                    ."XCESS"."\n"."Hadir : ".($xsathadir+$xsaphadir)."\n"."Tidak Hadir : ".($xsatth+$xsapth)."\n\n"
                    ."DIAMOND"."\n"."Hadir : ".($dsathadir+$dsaphadir)."\n"."Tidak Hadir : ".($dsatth+$dsapth);
        Telegram::sendMessage([
            "chat_id" => env('TELEGRAM_CHAT_ID', '-1001581181483'),
            "parse_mode" => "HTML",
            "text" => $textes
        ]);

    }
}
