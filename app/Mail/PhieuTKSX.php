<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PhieuTKSX extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $type, $soPhieu, $username, $time, $lyDoRollback;

    public function __construct($type, $soPhieu, $username, $time, $lyDoRollback)
    {
        $this->type = $type;
        $this->soPhieu = $soPhieu;
        $this->username = $username;
        $this->time = $time;
        $this->lyDoRollback = $lyDoRollback;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {

        if($this->type == 'New'){
            
            return new Envelope(
                subject: 'Mail tự động thông báo về việc " Phiếu thay TKSX " đã được tạo.',
            );

        }elseif($this->type == 'KHST APPROVED'){

            return new Envelope(
                subject: 'Mail tự động thông báo về việc " Phiếu thay TKSX " đã được KHST phê duyệt.',
            );

        }elseif($this->type == 'QA APPROVED'){

            return new Envelope(
                subject: 'Mail tự động thông báo về việc " Phiếu thay TKSX " đã được QA duyệt.',
            );

        }elseif($this->type == 'Sale APPROVED'){

            return new Envelope(
                subject: 'Mail tự động thông báo về việc " Phiếu thay TKSX " đã được Sale duyệt.',
            );

        }elseif($this->type == 'SM APPROVED'){

            return new Envelope(
                subject: 'Mail tự động thông báo về việc " Phiếu thay TKSX " đã được SM Sale duyệt.',
            );

        }elseif($this->type == 'Finish'){

            return new Envelope(
                subject: 'Mail tự động thông báo về việc " Phiếu thay TKSX " đã được KHST xác nhận hoàn tất.',
            );

        }elseif($this->type == 'Rollback'){

            return new Envelope(
                subject: 'Mail tự động thông báo về việc " Phiếu thay TKSX " đã bị từ chối.',
            );

        }
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.phieu-tksx',
            with: [
    
                'type' => $this->type,
                'soPhieuOutlook' => $this->soPhieu,
                'usernameOutlook' => $this->username,
                'timeOutlook' => $this->time,
                'lyDoRollbackOutlook' => $this->lyDoRollback
                
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
