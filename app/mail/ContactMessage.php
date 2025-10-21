<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMessage extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $email = $this->view('emails.contact_message')
                     ->with('data', $this->data)
                     ->subject('Nova Mensagem de Contato');

        // Anexar arquivos, se houver
        if (isset($this->data['attachments'])) {
            $attachments = json_decode($this->data['attachments'], true);
            foreach ($attachments as $filePath) {
                $email->attach(public_path($filePath));
            }
        }
        
        return $email;
    }
}