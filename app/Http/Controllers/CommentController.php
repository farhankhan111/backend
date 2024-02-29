<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Responses\ApiSuccessResponse;
use App\Models\Comment;
use App\Models\FeedBack;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index($feedbackId)
    {
        $comments = Comment::where('feedback_id', $feedbackId)->get();

        return new ApiSuccessResponse($comments);
    }

    public function store(CommentRequest $request, Feedback $feedback)//: JsonResponse
    {

        $comment = $feedback->comments()->create($request->validated());

        $comment->load('user');

        return new ApiSuccessResponse($comment,[],201);

    }
}

