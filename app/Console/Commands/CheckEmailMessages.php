<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Webklex\IMAP\Facades\Client;
use App\Models\Contact;
use Illuminate\Support\Facades\Log;

class CheckEmailMessages extends Command
{
    protected $signature = 'email:check';
    protected $description = 'Check email messages and save them to the database';

    public function handle()
    {
        try {
            $client = Client::account('gmail'); // Use o identificador da conta configurada
            $client->connect();

            Log::info('Conectado ao servidor IMAP com sucesso.');

            $folder = $client->getFolder('INBOX');
            $messages = $folder->messages()->unseen()->get();

            Log::info('Número de mensagens não lidas: ' . $messages->count());

            foreach ($messages as $message) {
                Contact::create([
                    'name' => $message->getFrom()[0]->personal,
                    'email' => $message->getFrom()[0]->mail,
                    'message' => $message->getTextBody(),
                    'read' => false,
                ]);

                // Marcar a mensagem como lida
                $message->setFlag('Seen');

                Log::info('Mensagem de ' . $message->getFrom()[0]->mail . ' salva no banco de dados.');
            }

            $this->info('Email messages checked and saved to the database.');
        } catch (\Exception $e) {
            Log::error('Erro ao conectar ou ler e-mails: ' . $e->getMessage());
            $this->error('Erro ao conectar ou ler e-mails: ' . $e->getMessage());
        }

        return 0;
    }
}