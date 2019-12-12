<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Job;

class JobExpired extends Mailable
{
    use Queueable, SerializesModels;

    public $company;
    public $job;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Job $job)
    {
        $this->company = $job->user;
        $this->job = $job;
        $this->subject('Job expired at '.config('app.name'));
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.jobs.expired');
    }
}
