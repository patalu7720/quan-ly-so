<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PhieuXXDH extends Mailable
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
                subject: 'Mail tự động thông báo về việc " Phiếu xem xét đơn hàng " vừa được tạo.',
            );

        }elseif($this->type == 'Sale APPROVED'){

            return new Envelope(
                subject: 'Mail tự động thông báo về việc " Phiếu xem xét đơn hàng " vừa được Sale DUYỆT.',
            );

        }elseif($this->type == 'SM APPROVED'){

            return new Envelope(
                subject: 'Mail tự động thông báo về việc " Phiếu xem xét đơn hàng " vừa được SM Sale DUYỆT.',
            );

        }elseif($this->type == 'KHST APPROVED'){

            return new Envelope(
                subject: 'Mail tự động thông báo về việc " Phiếu xem xét đơn hàng " vừa được KHST DUYỆT.',
            );

        }elseif($this->type == 'ADMIN APPROVED'){

            return new Envelope(
                subject: 'Mail tự động thông báo về việc " Phiếu xem xét đơn hàng " vừa được ADMIN cập nhật SO.',
            );

        }elseif($this->type == 'QA APPROVED'){

            return new Envelope(
                subject: 'Mail tự động thông báo về việc " Phiếu xem xét đơn hàng " vừa được QA DUYỆT.',
            );

        }elseif($this->type == 'Finish'){

            return new Envelope(
                subject: 'Mail tự động thông báo về việc " Phiếu xem xét đơn hàng " đã được xác nhận hoàn tất.',
            );

        }elseif($this->type == 'Rollback'){

            return new Envelope(
                subject: 'Mail tự động thông báo về việc " Phiếu xem xét đơn hàng " đã bị từ chối.',
            );

        }
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        if($this->type == 'New'){

            return new Content(
                view: 'emails.phieu-xxdh',
                with: [
    
                    'type' => $this->type,
                    'soPhieuOutlook' => 'Số phiếu : ' . $this->soPhieu,
                    'usernameOutlook' => 'Người tạo : ' . $this->username,
                    'timeOutlook' => 'Thời gian tạo : ' . $this->time,
                    'lyDoRollbackOutlook' => ''
                ],
            );

        }elseif($this->type == 'Sale APPROVED' || $this->type == 'SM APPROVED' || $this->type == 'KHST APPROVED' || $this->type == 'ADMIN APPROVED' || $this->type == 'QA APPROVED' || $this->type == 'Finish'){

            return new Content(
                view: 'emails.phieu-xxdh',
                with: [
    
                    'type' => $this->type,
                    'soPhieuOutlook' => 'Số phiếu : ' . $this->soPhieu,
                    'usernameOutlook' => 'Người duyệt : ' . $this->username,
                    'timeOutlook' => 'Thời gian duyệt : ' . $this->time,
                    'lyDoRollbackOutlook' => ''
                ],
            );

        }elseif($this->type == 'Rollback'){

            return new Content(
                view: 'emails.phieu-xxdh',
                with: [
    
                    'type' => $this->type,
                    'soPhieuOutlook' => 'Số phiếu : ' . $this->soPhieu,
                    'usernameOutlook' => 'Người từ chối : ' . $this->username,
                    'timeOutlook' => 'Thời gian : ' . $this->time,
                    'lyDoRollbackOutlook' => 'Lý do từ chối : ' . $this->lyDoRollback
                    
                ],
            );

        }
        
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
