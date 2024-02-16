<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TheoDoiThuMauMail extends Mailable
{
    use Queueable, SerializesModels;

    public $arrayMail;

    public function __construct($arrayMail)
    {
        $this->arrayMail = $arrayMail;
    }

    public function envelope(): Envelope
    {
        if($this->arrayMail[0] == 'Mới'){

            return new Envelope(
                subject: 'Thông báo phiếu Theo Dõi Thử Mẫu vừa được SALE tạo.',
            );

        }elseif($this->arrayMail[0] == 'SM đã duyệt'){

            return new Envelope(
                subject: 'Thông báo phiếu Theo Dõi Thử Mẫu vừa được SM duyệt.',
            );

        }elseif($this->arrayMail[0] == 'QA đã duyệt'){

            return new Envelope(
                subject: 'Thông báo phiếu Theo Dõi Thử Mẫu vừa được QA duyệt.',
            );

        }elseif($this->arrayMail[0] == 'KHST đã duyệt'){

            return new Envelope(
                subject: 'Thông báo phiếu Theo Dõi Thử Mẫu vừa được QA duyệt.',
            );

        }elseif($this->arrayMail[0] == 'Finish'){

            return new Envelope(
                subject: 'Thông báo phiếu Theo Dõi Thử Mẫu vừa được xác nhận Hoàn Tất.',
            );

        }
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.theo-doi-thu-mau',
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
