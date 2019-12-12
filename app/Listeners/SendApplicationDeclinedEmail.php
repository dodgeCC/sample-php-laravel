<?php

namespace App\Listeners;

use App\Events\ApplicationDeclined;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApplicationDeclined as ApplicationDeclinedMail;

class SendApplicationDeclinedEmail implements ShouldQueue
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
     * @param  ApplicationDeclined  $event
     * @return void
     */
    public function handle(ApplicationDeclined $event)
    {
        $job_application = $event->job_application;
        Mail::to($job_application->user)->send(new ApplicationDeclinedMail($job_application));
    }
}
