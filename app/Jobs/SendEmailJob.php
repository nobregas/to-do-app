<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Queueable;

    protected $mailable;
    protected $recipient;

    /**
     * Create a new job instance.
     */
    public function __construct(string $mailable, Mailable $recipient)
    {
        $this->mailable = $mailable;
        $this->recipient = $recipient;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->recipient)->send($this->mailable);
    }
}
