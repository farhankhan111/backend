<?php

namespace App\Http\Controllers;

use App\Http\Requests\VoteRequest;
use App\Http\Responses\ApiSuccessResponse;
use App\Models\Vote;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function store(VoteRequest $request)
    {
        $vote = Vote::create($request->validated());

        return new ApiSuccessResponse($vote);

    }
}
