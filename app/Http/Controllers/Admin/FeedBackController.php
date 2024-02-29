<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateFeedbackRequest;
use App\Http\Responses\ApiSuccessResponse;
use App\Models\FeedBack;
use Illuminate\Http\Request;

class FeedBackController extends Controller
{
    public function index()
    {
        $feedBacks = FeedBack::with('user')->withCount([
            'votes as upvotes' => function ($query) {
                $query->where('vote_type', 'upvote');
            },
            'votes as downvotes' => function ($query) {
                $query->where('vote_type', 'downvote');
            },
        ])
            ->orderby('id', 'desc')
            ->cursorPaginate(3);

        return new ApiSuccessResponse($feedBacks);

    }

    public function show($id)
    {
        $feedBack = FeedBack::findOrFail($id);

        return new ApiSuccessResponse($feedBack);
    }

    public function edit($id)
    {
        $feedBack = FeedBack::findOrFail($id);

        return response()->json(['feedback' => $feedBack], 200);
    }

    public function update(UpdateFeedbackRequest $request, Feedback $feedback)
    {
        $feedback->update($request->validated());

        return new ApiSuccessResponse($feedback,['message' => 'Feedback update successfully']);

    }

    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);

        $feedback->delete();

        $feedback->logs()->create([
            'type' => 'feedback_deleted',
            'message' => 'feedback deleted',
            'created_by' => Auth('api')->id()
        ]);

        return new ApiSuccessResponse($feedback,['message' => 'Feedback deleted successfully'],204);

    }

}
