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

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('midimeet.{room}', function($user, $room) {
    return in_array($room, $user->rooms());
});

Broadcast::channel('midimeetpr.{room}', function($user, $room) {
  if(in_array($room, $user->rooms())) {
    return ['id' => $user->id, 'name' => $user->name, 'avatar' => $user->avatar, 'status' => 'online'];
  }
});