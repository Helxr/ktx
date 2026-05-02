<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DangkyKhachThanhCongMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly string $hoTen,
        public readonly string $phongTen,
        public readonly string $token,
        public readonly string $lookupUrl
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Đăng ký KTX thành công - Mã tra cứu của bạn',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.dangky-khach-thanh-cong',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
