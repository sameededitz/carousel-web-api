<?php

namespace App\Notifications;

use App\Mail\CustomPasswordReset;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CustomResetPassword extends Notification
{
    use Queueable;

    protected $token;

    /**
     * Create a new notification instance.
     *
     * @param string $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $resetUrl = $this->resetUrl($notifiable);
        return (new CustomPasswordReset($notifiable, $resetUrl));
    }

    /**
     * Generate the reset URL.
     */
    protected function resetUrl($notifiable)
    {
        return config('app.frontend_url') . '/en/affiliate-reset-password?token=' . $this->token . '&email=' . urlencode(encrypt($notifiable->getEmailForPasswordReset()));
    }
}
