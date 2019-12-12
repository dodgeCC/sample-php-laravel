<?php

namespace App\Listeners;

use App\Events\ApplicationShortlisted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApplicationShortlisted as ApplicationShortlistedMail;

class SendApplicationShortlistedEmail implements ShouldQueue
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
     * @param  ApplicationShortlisted  $event
     * @return void
     */
    public function handle(ApplicationShortlisted $event)
    {
        $job_application = $event->job_application;
        Mail::to($job_application->user)->send(new ApplicationShortlistedMail($job_application));
    }
}
