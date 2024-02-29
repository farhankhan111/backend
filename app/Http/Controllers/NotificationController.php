<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiSuccessResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $notifications = $user->unreadNotifications;

        return new ApiSuccessResponse($notifications);

    }

}
