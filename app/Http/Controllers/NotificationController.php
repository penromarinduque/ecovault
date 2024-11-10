<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function getNotifications()
    {
        // Get unread notifications for the authenticated user
        $notifications = auth()->user()->unreadNotifications;

        // Return notifications as JSON
        return response()->json($notifications);
    }
}
