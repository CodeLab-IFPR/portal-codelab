<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactMessage;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function sendMessage(Request $request)
    {
        $data = $request->all();

        // Enviar e-mail
        Mail::send(new ContactMessage($data));

        return redirect()->back()->with('success', 'Mensagem enviada com sucesso!');
    }
}