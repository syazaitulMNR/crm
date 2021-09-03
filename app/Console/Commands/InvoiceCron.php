<?php

namespace App\Console\Commands;

use App\Payment;
use App\Student;
use App\Jobs\TestJobMail;
use App\Jobs\InvoiceJobMail;
use Illuminate\Console\Command;

class InvoiceCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:cron';

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
        //M1981113016705iqbal1
        
        //the real one
        $student_ids = Payment::where('pay_price', '!=', 0)->where('pay_price', '!=', null)->get()->unique('stud_id');

        //testing purpose
        // $student_ids = Payment::whereIn('stud_id',['M1981113016705iqbal1', 'M1981113016705iqbal2'])->get();

        dispatch(new InvoiceJobMail($student_ids));
    }
}
