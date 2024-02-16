<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Mail\Attachment;
use Illuminate\Support\Facades\Storage;
use Svg\Gradient\Stop;

class TTDHMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $soPhieu, $status, $customer, $contentMail, $time;

    public function __construct($soPhieu, $status, $customer, $contentMail, $time)
    {
        $this->soPhieu = $soPhieu;
        $this->status = $status;
        $this->customer = $customer;
        $this->contentMail = $contentMail;
        $this->time = $time;
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        if($this->status == 'Approve 1'){

            return new Envelope(
                subject: 'TTDH ' . $this->customer . ' duyệt cấp 1',
            );

        }if($this->status == 'Approve 2'){

            return new Envelope(
                subject: 'TTDH ' . $this->customer . ' duyệt cấp 2',
            );

        }if($this->status == 'Approve 3'){

            return new Envelope(
                subject: 'TTDH ' . $this->customer . ' duyệt cấp 3',
            );

        }elseif($this->status == 'Finish'){

            return new Envelope(
                subject: 'TTDH ' . $this->customer . ' đã duyệt thành công.',
            );

        }elseif($this->status == 'Reject'){

            return new Envelope(
                subject: 'TTDH ' . $this->customer . ' đã bị từ chối.',
            );

        }
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        if ($this->status == 'Reject') {
            
            $phieuTDG = DB::table('phieu_ttdh')
            ->where('so_phieu', $this->soPhieu)
            ->first();

            return new Content(
                view: 'emails.ttdh',
                with: [
                    'soPhieuOutlook' => $this->soPhieu,
                    'statusOutlook' => $this->status,
                    'contentOutlook' => $this->contentMail,
                    'reasonRejectOutlook' => $phieuTDG->reason_for_reject,
                    'levelRejectOutlook' => $phieuTDG->status,
                ],
            );

        }else{

            return new Content(
                view: 'emails.ttdh',
                with: [
                    'soPhieuOutlook' => $this->soPhieu,
                    'statusOutlook' => $this->status,
                    'contentOutlook' => $this->contentMail
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
        $array = [];

        $danhsachfile = Storage::disk('ftp')->allFiles('TTDH/' . $this->soPhieu);

        foreach ($danhsachfile as $item) {
            
            $array = array_merge($array, [Attachment::fromStorageDisk('ftp', $item)]);

        }

        return $array;
    }
}
