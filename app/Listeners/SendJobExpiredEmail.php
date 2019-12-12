<?php

namespace App\Listeners;

use App\Events\JobExpired;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\JobExpired as JobExpiredMail;

class SendJobExpiredEmail implements ShouldQueue
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
     * @param  JobExpired  $event
     * @return void
     */
    public function handle(JobExpired $event)
    {
        $job = $event->job;
        Mail::to($job->user)->send(new JobExpiredMail($job));
    }
}
