<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class HopDong extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    public $type ,$loaihopdong, $sohd, $username, $time, $lydo;
    
    public function __construct($type ,$loaihopdong, $sohd, $username, $time, $lydo)
    {
        $this->type = $type;
        $this->loaihopdong = $loaihopdong;
        $this->sohd = $sohd;
        $this->username = $username;
        $this->time = $time;
        $this->lydo = $lydo;

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        if($this->type == 'created'){

            return new Envelope(
                subject: 'Automated mail notification that a contract has been created.',
            );

        }elseif($this->type == 'processing'){

            return new Envelope(
                subject: 'Mail tự động thông báo về việc hợp đồng đã được duyệt cấp 1.',
            );

        }elseif($this->type == 'approved'){

            return new Envelope(
                subject: 'Mail tự động thông báo về việc hợp đồng đã được duyệt hoàn tất.',
            );

        }elseif($this->type == 'rejected'){

            return new Envelope(
                subject: 'Mail tự động thông báo về việc hợp đồng đã bị từ chối.',
            );

        }
        
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        if($this->type == 'created'){

            return new Content(
                view: 'emails.hop-dong',
                with : [
    
                    'typeOutlook' => $this->type,
                    'loaihopdongOutlook' => $this->loaihopdong,
                    'sohdOutlook' => $this->sohd,
                    'usernameOutlook' => $this->username,
                    'timeOutlook' => $this->time
    
                ],
            );

        }elseif($this->type == 'processing'){

            return new Content(
                view: 'emails.hop-dong',
                with : [
    
                    'typeOutlook' => $this->type,
                    'loaihopdongOutlook' => $this->loaihopdong,
                    'sohdOutlook' => $this->sohd,
                    'usernameOutlook' => $this->username,
                    'timeOutlook' => $this->time
    
                ],
            );

        }elseif($this->type == 'approved'){

            return new Content(
                view: 'emails.hop-dong',
                with : [
    
                    'typeOutlook' => $this->type,
                    'loaihopdongOutlook' => $this->loaihopdong,
                    'sohdOutlook' => $this->sohd,
                    'usernameOutlook' => $this->username,
                    'timeOutlook' => $this->time
    
                ],
            );

        }elseif($this->type == 'rejected'){

            return new Content(
                view: 'emails.hop-dong',
                with : [
    
                    'typeOutlook' => $this->type,
                    'loaihopdongOutlook' => $this->loaihopdong,
                    'sohdOutlook' => $this->sohd,
                    'usernameOutlook' => $this->username,
                    'timeOutlook' => $this->time,
                    'lydoOutlook' => $this->lydo
    
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
