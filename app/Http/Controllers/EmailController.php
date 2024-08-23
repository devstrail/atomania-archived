<?php

namespace App\Http\Controllers;

use App\Mail\BaseEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendMail(Request $request) {
        $validated = $request->validate([
            'from' => 'required|email',
            'to' => 'required|email',
            'subject' => 'required|string',
            'body' => 'required|string',
        ]);

        Mail::to($validated['to'])->send(new BaseEmail($validated));
//        Mail::to($validated['to'])->queue(new BaseEmail($validated)); // TODO: probably test later

        return response()->json(['message' => 'Email sent successfully'], 200);
    }
}
