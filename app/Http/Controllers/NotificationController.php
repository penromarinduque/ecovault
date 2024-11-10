<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class NotificationController extends Controller
{
    public function getNotifications()
    {


        $user = User::first();
        $notifications = $user()->user->unreadNotifications;
        return response()->json($notifications);

    }
}
