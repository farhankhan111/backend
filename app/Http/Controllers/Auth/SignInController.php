<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignInRequest;
use App\Http\Responses\ApiErrorResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SignInController extends Controller
{
    public function SignIn(SignInRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $token = auth()->user()->createToken('MyApp')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return new ApiErrorResponse('Unauthorised','',401);
        }
    }
}
