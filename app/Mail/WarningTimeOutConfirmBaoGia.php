<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WarningTimeOutConfirmBaoGia extends Mailable
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
            subject: 'Cảnh báo quá thời gian nhận Phản hồi Phiếu Báo Giá từ khách hàng - quá 3 ngày',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.warning-timeout-confirm-bao-gia',
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