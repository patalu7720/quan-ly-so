<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PhieuMHDTY extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    public $type, $soPhieu, $username, $time;

    public function __construct($type, $soPhieu, $username, $time)
    {
        $this->type = $type;
        $this->soPhieu = $soPhieu;
        $this->username = $username;
        $this->time = $time;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        if($this->type == 'New'){
            
            return new Envelope(
                subject: 'Mail tự động thông báo về việc " Phiếu thay đổi mã hàng DTY " vừa được tạo.',
            );

        }elseif($this->type == 'QA APPROVED'){

            return new Envelope(
                subject: 'Mail tự động thông báo về việc " Phiếu thay đổi mã hàng DTY " vừa được QA duyệt.',
            );

        }elseif($this->type == 'Sale APPROVED'){

            return new Envelope(
                subject: 'Mail tự động thông báo về việc " Phiếu thay đổi mã hàng DTY " vừa được Sale duyệt.',
            );

        }
        elseif($this->type == 'DTY APPROVED'){

            return new Envelope(
                subject: 'Mail tự động thông báo về việc " Phiếu thay đổi mã hàng DTY " vừa được DTY duyệt.',
            );

        }
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.phieu-mhdty',
            with: [
    
                'type' => $this->type,
                'soPhieuOutlook' => $this->soPhieu,
                'usernameOutlook' => $this->username,
                'timeOutlook' => $this->time
                
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
