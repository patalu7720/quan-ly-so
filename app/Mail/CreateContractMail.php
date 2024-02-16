<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CreateContractMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $loaihopdong, $sohd, $username, $created_at;

    public function __construct($loaihopdong, $sohd, $username, $created_at)
    {
        $this->loaihopdong = $loaihopdong;
        $this->sohd = $sohd;
        $this->username = $username;
        $this->created_at = $created_at;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Automated mail notification that a contract has been created.',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.create-contract-mail',
            with : [

                'loaihopdong' => $this->loaihopdong,
                'sohd' => $this->sohd,
                'username' => $this->username,
                'created_at' => $this->created_at

            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
