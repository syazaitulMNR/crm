<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\TestMail;
use App\Email;
use App\Student;
use Mail;
use Illuminate\Support\Facades\Schema;

class TestJobMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $request, $message, $regex_content;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request, $regex_content)
    {
        $this->request = $request;
        $this->regex_content = $regex_content;

        // \Log::info($request['emailId']);
        $email = Email::where('id', $request['emailId'])->first();

        // \Log::info($email['content']);
        $this->message = $email['content'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $request = $this->request;
        $emails = $request['emailList'];

        // $column_name = Schema::getColumnListing($table);

        // \Log::info($this->emails);

        $columns = Schema::getColumnListing('student');
        

        foreach($emails as $email){
            $message = $this->message;
           
            
            $student = Student::where('email', $email)->first();

            // \Log::info($student->$nameEmail);

            foreach($this->regex_content as $rc){
                if (in_array(strtolower($rc), $columns)){
					$message = str_replace("{". $rc ."}", $student->$rc, $message);
				}
            }

            if($student->email !== (null || "")){
				$email = $student->email;
                \Log::info('ada');

                
                Mail::to($email)->send(new Testmail($message));
                
			}else{
				return false;
			}
            
        }
    }
}
