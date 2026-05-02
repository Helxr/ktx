<?php

namespace App\Mail;

use App\Models\Hoadon;
use App\Models\Hopdong;
use App\Models\Phong;
use App\Models\Sinhvien;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DangkyDaDuyetMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public Sinhvien $sinhvien,
        public Phong $phong,
        public Hopdong $hopdong,
        public Hoadon $hoadon
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Dang ky phong da duoc duyet',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.dangky-da-duyet',
        );
    }
}
