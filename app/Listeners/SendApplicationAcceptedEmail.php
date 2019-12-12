<?php

namespace App\Listeners;

use App\Events\ApplicationAccepted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApplicationAccepted as ApplicationAcceptedMail;

class SendApplicationAcceptedEmail implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ApplicationAccepted  $event
     * @return void
     */
    public function handle(ApplicationAccepted $event)
    {
        $job_application = $event->job_application;
        Mail::to($job_application->user)->send(new ApplicationAcceptedMail($job_application));
    }
}
