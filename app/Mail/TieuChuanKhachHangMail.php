<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TieuChuanKhachHangMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $arrayMail;

    public function __construct($arrayMail)
    {
        $this->arrayMail = $arrayMail;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        if($this->arrayMail[0] == 'Mới'){

            return new Envelope(
                subject: 'Thông báo phiếu Tiêu Chuẩn Khách Hàng vừa được QA tạo.',
            );

        }elseif($this->arrayMail[0] == 'Sale đã duyệt'){

            return new Envelope(
                subject: 'Thông báo phiếu Tiêu Chuẩn Khách Hàng vừa được Sale duyệt.',
            );

        }elseif($this->arrayMail[0] == 'QA đã duyệt'){

            return new Envelope(
                subject: 'Thông báo phiếu Tiêu Chuẩn Khách Hàng vừa được QA duyệt.',
            );

        }

    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.tieu-chuan-khach-hang',
            with: [

                'soPhieuMail' => $this->arrayMail[1],
                'khachHangMail' => $this->arrayMail[2]

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
