<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\User;

Broadcast::channel('user.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id; // Check if the user is authorized to listen to the channel
});

Broadcast::channel('admin.notifications', function (User $user) {
    return $user->isAdmin; // Only admins can access this channel
});
