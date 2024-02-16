<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AlertRejectMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $sohd, $loaihopdong, $reject;

    public function __construct($sohd, $loaihopdong, $reject)
    {
        $this->sohd = $sohd;
        $this->loaihopdong = $loaihopdong;
        $this->reject = $reject;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Mail tự động thông báo về việc hợp đồng đã bị từ chối.',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.alertRejectMail',
            with: [
                'sohd' => $this->sohd,
                'loaihopdong' => $this->loaihopdong,
                'lydo' => $this->reject
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
