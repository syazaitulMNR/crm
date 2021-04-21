<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;

class TestController extends Controller
{
    public function basic_email() {
        $data = array('name'=>"Virat Gandhi");
     
        Mail::send('test', $data, function($message) {
           $message->to('zarina4.11@gmail.com', 'Tutorials Point')->subject
              ('Laravel Basic Testing Mail');
           $message->from('noreply@momentuminternet.my','Virat Gandhi');
        });
        echo "Basic Email Sent. Check your inbox.";
     }
}
