<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\InvoiceRemindEmail;
use App\Mail\InvoiceRemindTerminateEmail;
use App\Email;
use App\Student;
use App\Membership_Level;
use Mail;
use Carbon\Carbon;
use App\Invoice;

class InvoiceJobMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $students;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($students)
    {
       $this->students = $students;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $students = $this->students;

        $now = Carbon::now();

        $current_date = $now->month.'/'.$now->year;

        foreach($students as $student){

            $invoiceCreate = Invoice::where('student_id', $student->id)->where('status', 'not paid')->get();
            $invoiceId = null;

            if(count($invoiceCreate) < 3){
                $lvl = Membership_Level::where('level_id', $student->level_id)->first();

                $now = Carbon::now();

                $for_date = $now->month.'/'.$now->year;

                $newInvoice = new Invoice();
                $newInvoice->invoice_id = 'INV'.uniqid();
                $newInvoice->price = $lvl->price;
                $newInvoice->for_date = $for_date;
                $newInvoice->status = 'not paid';

                $invoiceId = $student->invoices()->save($newInvoice);
            }

            $invoiceFirst = Invoice::where('student_id', $student->id)->where('status', 'not paid')->first();
            $invoiceLatest = Invoice::where('student_id', $student->id)->where('status', 'not paid')->get()->last();

            $lvl = Membership_Level::where('level_id', $student->level_id)->first();

            $last_date = $invoiceFirst->for_date;

            $months = array();
            $years = array();

            $current = explode("/",$current_date);
            $last = explode("/",$last_date);

            $difference_year = $current[1] - $last[1];
            $difference_month = $current[0] - $last[0];

            if(isset($student->email)){
                
                $email = $student->email;

                if($difference_year == 0){

                    //remind
                    if($difference_month < 3){
                        
                        Mail::to($email)->send(new InvoiceRemindEmail($lvl, $student, $invoiceLatest));

                    //terminate
                    }elseif($difference_month == 3){

                        $student->status = 'Deactive';

                        $student->save();
                        
                        Mail::to($email)->send(new InvoiceRemindTerminateEmail($lvl, $student));

                    }
                }
            }
            
        }
    }
}
