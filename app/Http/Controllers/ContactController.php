<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactMessage;
use Illuminate\Support\Facades\Mail;
use App\Models\Contact;

class ContactController extends Controller
{
    public function sendMessage(Request $request)
    {
        $data = $request->all();

        // Salvar a mensagem de contato no banco de dados
        $contact = Contact::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'message' => $data['message'],
        ]);

        // Enviar e-mail
        Mail::send(new ContactMessage($data));

        return redirect()->back()->with('success', 'Mensagem enviada com sucesso!');
    }
}