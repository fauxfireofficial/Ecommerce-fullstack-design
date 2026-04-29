<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OTPSendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $purpose;

    /**
     * Create a new message instance.
     */
    public function __construct($otp, $purpose)
    {
        $this->otp = $otp;
        $this->purpose = $purpose;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = 'OTP Code';
        if ($this->purpose == 'registration') $subject = 'Verify Your Account';
        elseif ($this->purpose == 'admin_registration') $subject = 'Admin Portal Verification';
        elseif ($this->purpose == 'password_reset') $subject = 'Reset Your Password';

        return new Envelope(
            subject: $subject . ' - Brand Store',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $view = 'emails.otp'; // Default
        
        if ($this->purpose == 'password_reset') {
            $view = 'emails.reset-otp';
        }
        
        return new Content(
            view: $view,
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
