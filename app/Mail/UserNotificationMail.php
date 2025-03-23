<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $subject;
    public $body;
    public $buttonText;
    public $buttonUrl;

    /**
     * Create a new message instance.
     */
    public function __construct($name, $subject, $body, $buttonText = null, $buttonUrl = null)
    {
        $this->name = $name;
        $this->subject = $subject;
        $this->body = $body;
        $this->buttonText = $buttonText;
        $this->buttonUrl = $buttonUrl;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject($this->subject)
            ->view('email.user-notification')
            ->with([
                'name' => $this->name,
                'subject' => $this->subject,
                'body' => $this->body,
                'buttonText' => $this->buttonText,
                'buttonUrl' => $this->buttonUrl,
            ]);
    }
}
