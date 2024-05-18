<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmailNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $formData;
    /**
     * Create a new job instance.
     */
    public function __construct(array $formData)
    {
        $this->formData = $formData;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $recipientEmail = $this->formData['email'];
        $subject = $this->formData['subject'];
        $data = ['name' => $this->formData['name']];

        \Mail::to($recipientEmail)->send(new \App\Mail\FormSubmissionNotification($subject, $data));
    }
}
