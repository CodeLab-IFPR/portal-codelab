<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DemandSubmission extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('seu-email@hotmail.com', config('app.name'))
                    ->to('carloseduardomarianogarciapereira@hotmail.com')
                    ->view('emails.demand_submission')
                    ->with('data', $this->data)
                    ->subject('Nova Submissão de Demanda');
    }
}