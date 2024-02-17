<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SignOutController extends Controller
{
    public function SignOut(): void
    {
        $user = Auth::user()->token();
        $user->revoke();
    }

}
