<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CancelRevisedSOEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $array;

    /**
     * Create a new message instance.
     */
    public function __construct($array)
    {
        $this->array = $array;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        if($this->array[0] == 'New'){
            return new Envelope(
                subject: 'CANCEL-REVISED S/O vừa được tạo mới.',
            );
        }elseif($this->array[0] == 'Sale Approved'){
            return new Envelope(
                subject: 'CANCEL-REVISED S/O vừa được Sale duyệt.',
            );
        }elseif($this->array[0] == 'SM Approved'){
            return new Envelope(
                subject: 'CANCEL-REVISED S/O vừa được Sale Manager duyệt.',
            );
        }elseif($this->array[0] == 'KHST Approved'){
            return new Envelope(
                subject: 'CANCEL-REVISED S/O vừa được KHST duyệt.',
            );
        }elseif($this->array[0] == 'MD Approved'){
            return new Envelope(
                subject: 'CANCEL-REVISED S/O vừa được MD duyệt.',
            );
        }

    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.cancel-revised-so',
            with: [
                'tenKhachHang' => $this->array[1],
                'maKhachHang' => $this->array[2],
                'SO' => $this->array[3],
            ]
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
