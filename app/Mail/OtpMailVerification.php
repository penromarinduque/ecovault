<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpMailVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $otp; // Declare the OTP property

    /**
     * Create a new message instance.
     *
     * @param int $otp
     */
    public function __construct($otp)
    {
        $this->otp = $otp; // Assign the OTP to the property
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'OTP Mail Verification', // Fixed the subject casing
        );
    }

    /**
     * Get the message content definition.
     */
    public function build() // Use the build method instead of content
    {
        return $this->view('email.otpMail') // Ensure this matches the path
            ->with(['otp' => $this->otp]);
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
