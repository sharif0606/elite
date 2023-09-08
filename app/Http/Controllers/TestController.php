<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(){
        \Mail::send('mail.reply_body', [], function ($message) {
            $message->from('info@icarjapan.com', 'Icarjapan')
                    ->to('tawhid102@gmail.com')/*dev@icarjapan.com*/
                    ->subject('Test');
        });
        
    }
}
