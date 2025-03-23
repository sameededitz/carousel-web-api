<?php

namespace App\Jobs;

use Throwable;
use App\Mail\UserNotificationMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendUserNotification implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    public $tries = 3;
    public $timeout = 120;
    public $deleteWhenMissingModels = true;

    public $email;
    public $name;
    public $subject;
    public $message;
    public $buttonText;
    public $buttonUrl;

    /**
     * Create a new job instance.
     */
    public function __construct($email, $name, $subject, $message, $buttonText = null, $buttonUrl = null)
    {
        $this->email = $email;
        $this->name = $name;
        $this->subject = $subject;
        $this->message = $message;
        $this->buttonText = $buttonText;
        $this->buttonUrl = $buttonUrl;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Mail::to($this->email)->send(new UserNotificationMail(
            $this->name, $this->subject, $this->message, $this->buttonText, $this->buttonUrl
        ));
    }

    public function backoff(): array
    {
        return [3, 6, 10];
    }

    public function retryUntil()
    {
        return now()->addMinutes(5);
    }

    public function failed(?Throwable $exception)
    {
        Log::error('Failed to Send user notification: ' . $exception->getMessage());
    }
}
