<?php

use Illuminate\Support\Facades\Broadcast;

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

Broadcast::channel('public.channel.1', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

/////

Broadcast::channel('channel-name.38', function ($user) {
    // return (int) $user->id === (int) $id;
    return $user;
});
