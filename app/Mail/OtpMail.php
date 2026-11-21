<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class OtpMail extends Mailable
{
    public function __construct(
        public User $user,
        public string $code,
        public int $ttl,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Kode Verifikasi NesaThrift');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.otp');
    }
}