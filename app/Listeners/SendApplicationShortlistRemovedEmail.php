<?php

namespace App\Listeners;

use App\Events\ApplicationShortlistRemoved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApplicationShortlistRemoved as ApplicationShortlistRemovedMail;

class SendApplicationShortlistRemovedEmail implements ShouldQueue
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
     * @param  ApplicationShortlistRemoved  $event
     * @return void
     */
    public function handle(ApplicationShortlistRemoved $event)
    {
        $job_application = $event->job_application;
        Mail::to($job_application->user)->send(new ApplicationShortlistRemovedMail($job_application));
    }
}
