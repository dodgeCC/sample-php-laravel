<?php

use App\JobApplication;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('messaging.{application_id}', function ($user, $application_id) {
    $application = JobApplication::find($application_id);
    if($application){
        return $user->id === $application->user_id || $user->id === $application->job->user_id || $user->isAdmin();
    }
    return false;
});
