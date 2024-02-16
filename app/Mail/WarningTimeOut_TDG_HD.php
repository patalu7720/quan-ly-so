<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WarningTimeOut_TDG_HD extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    public $soPhieu, $nguoiTao;

    public function __construct($soPhieu, $nguoiTao)
    {
        $this->soPhieu = $soPhieu;
        $this->nguoiTao = $nguoiTao;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Cảnh báo quá thời gian tạo Hợp đồng của phiếu TDG.',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.warning-timeout-tdg-hd',
            with:[

                'soPhieu' => $this->soPhieu,
                'nguoiTao' => $this->nguoiTao

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
