<?php

namespace App\Mail;

use http\Client\Curl\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RecetaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = "Receta Medica";

    /**
     * Create a new message instance.
     */
    public $name;
    public function __construct()
    {

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(

//            from: new Address('raulalba2099@gmail.com', 'Raúl Alba'),
            subject:'Receta Medica',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'paginas.receta_mail',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments($archivo): array

    {

        return [

            Attachment::fromPath($this->attach($this->$archivo)->getRealPath())

                ->as($this->attach($this->$archivo)->getClientOriginalName())

                ->withMime($this->$archivo->getMimeType()),

        ];

    }
}
