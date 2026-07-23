<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMessage extends Mailable
{
    use Queueable, SerializesModels;

    public array $contactData;

    public function __construct(array $contactData)
    {
        $this->contactData = $contactData;
    }

    public function build()
    {
        return $this->subject('New Contact Form Submission from ' . $this->contactData['name'] . ' - EzProperty')
            ->replyTo($this->contactData['email'], $this->contactData['name'])
            ->view('emails.contact_message')
            ->with('contactData', $this->contactData);
    }
}