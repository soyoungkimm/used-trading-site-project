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

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

Broadcast::channel('my-channel', function () {
    return true;
});

// 로그인 구현되면 사용
// Broadcast::channel('my-channel', function ($user, $id) {
//     return auth()->check(); // 로그인 되면 true, 로그인 안되면 false
// });