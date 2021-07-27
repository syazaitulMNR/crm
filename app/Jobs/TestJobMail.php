<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\TestMail;
use App\Email;
use Mail;

class TestJobMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $rows, $email_id, $regex_content, $message;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($rows, $email_id, $regex_content)
    {
        $this->rows = $rows;
        $this->email_id = $email_id;
        $this->regex_content = $regex_content;

        $email = Email::where('id', $email_id)->first();
        $this->message = $email->content;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Mail::to($this->email)->send(new Testmail("ttt"));
        $rows = $this->rows;

        foreach($rows as $row){
            $message = $this->message;

            foreach($this->regex_content as $rc){
				if(isset($row[strtolower($rc)])){
					$message = str_replace("{". $rc ."}", $row[strtolower($rc)], $message);
				}
            }

            if(isset($row["email"])){
				$email = $row["email"];
            
                Mail::to($email)->send(new Testmail($message));
                
			}else{
				return false;
			}
            
        }
    }
}
