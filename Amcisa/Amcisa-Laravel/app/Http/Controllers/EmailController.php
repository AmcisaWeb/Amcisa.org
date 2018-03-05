<?php

namespace App\Http\Controllers;

use App\Mail\ResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller{
    public function sendemail(){
        Mail::raw('Mail Content', function ($message){
            $message->from('amcisa@amcisa.com', 'Learning Laravel');
            $message->to('kimyong95@gmail.com')->subject('Learning Laravel test email');
        });
    }
}