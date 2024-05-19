<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FormSubmissionNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $submissionData;
    /**
     * Create a new message instance.
     */


    public function build()
    {

        return $this->from(config('mail.from.address'), config('mail.from.name'))
        ->subject('New Dynamic Form Created')
        ->view('emails.form_submission_notification')
        ->with(['submissionData' => $this->submissionData]);

    }
}
