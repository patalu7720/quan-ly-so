<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class XacNhanDonHangMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    public $soPhieu, $status, $username, $time;

    public function __construct($status, $soPhieu, $username, $time)
    {
        $this->status = $status;
        $this->soPhieu = $soPhieu;
        $this->username = $username;
        $this->time = $time;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        if($this->status == 'New'){

            return new Envelope(
                subject: 'Mail tự động thông báo về việc " Phiếu XNĐH " vừa được tạo.',
            );

        }elseif($this->status == 'Approved 1'){

            return new Envelope(
                subject: 'Mail tự động thông báo về việc " Phiếu XNĐH " vừa được Trợ lý cấp 1 DUYỆT.',
            );

        }elseif($this->status == 'Approved 2'){

            return new Envelope(
                subject: 'Mail tự động thông báo về việc " Phiếu XNĐH " vừa được Phó phòng DUYỆT.',
            );

        }elseif($this->status == 'Finish'){

            return new Envelope(
                subject: 'Mail tự động thông báo về việc " Phiếu XNĐH " vừa được SM DUYỆT.',
            );

        }elseif($this->status == 'Rollback'){

            return new Envelope(
                subject: 'Mail tự động thông báo về việc " Phiếu XNĐH " đã bị từ chối.',
            );

        }
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.xac-nhan-don-hang-mail',
            with:[

                'soPhieuOutlook' => 'Số phiếu : ' . $this->soPhieu,
                'usernameOutlook' => 'Người thao tác : ' . $this->username,
                'timeOutlook' => 'Thời gian thao tác : ' . $this->time

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
