<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SocialiteMail;

class MailController extends Controller
{
    //
    public function sendMail($userId, $email)
    {
        $details = [
            'title' => 'Verify your email',
            'body' => 'Please verify your email.',
            'userId' => $userId,
        ];
        Mail::to($email)->send(new SocialiteMail($details));
        return;
    }
    
}
