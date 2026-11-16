<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordBaruMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public string $password
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Password Baru Akun AKTIVIA',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.password-baru',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
