<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class NotificationController extends Controller
{
    public function getNotifications()
    {

        $notifications = Auth::user()->notifications()->latest()->take(10)->get();
        return response()->json($notifications);

    }
}
