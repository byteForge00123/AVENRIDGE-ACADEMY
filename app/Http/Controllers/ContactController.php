<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:160'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
        ]);

        Mail::raw($data['message'], function ($mail) use ($data) {
            $mail->to(config('avenridge.contact_email'))
                ->replyTo($data['email'], $data['name'])
                ->subject('Avenridge website: '.$data['subject']);
        });

        return back()->with('success', 'Your message has been sent to the school office.');
    }
}