<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateFeedbackRequest;
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
            ->orderby('id','desc')
            ->cursorPaginate(3);

        return response()->json(['feedbacks' => $feedBacks]);
    }

    public function show($id)
    {
        $feedBack = FeedBack::findOrFail($id);

        return response()->json(['feedback' => $feedBack],200);
    }

    public function edit($id)
    {
        $feedBack = FeedBack::findOrFail($id);

        return response()->json(['feedback' => $feedBack],200);
    }

    public function update(UpdateFeedbackRequest $request, Feedback $feedback)
    {
        $feedback->update($request->validated());

        return response()->json(['message' => 'Feedback update successfully'],200);

    }

    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);

        $feedback->delete();

        return response()->json(['message' => 'Feedback deleted successfully']);

    }
}
