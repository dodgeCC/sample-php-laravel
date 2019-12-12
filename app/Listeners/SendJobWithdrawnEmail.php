<?php

namespace App\Listeners;

use App\Events\JobWithdrawn;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\JobWithdrawn as JobWithdrawnMail;

class SendJobWithdrawnEmail implements ShouldQueue
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
     * @param  JobWithdrawn  $event
     * @return void
     */
    public function handle(JobWithdrawn $event)
    {
        $job_application = $event->job_application;
        Mail::to($job_application->job->user)->send(new JobWithdrawnMail($job_application));
    }
}
