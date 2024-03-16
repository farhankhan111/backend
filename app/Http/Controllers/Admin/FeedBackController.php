<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateFeedbackRequest;
use App\Http\Resources\FeedBackResource;
use App\Http\Responses\ApiSuccessResponse;
use App\Models\FeedBack;
use App\Services\LogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class FeedBackController extends Controller
{
    public function __construct(private LogService $logService){}
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

        return FeedBackResource::collection($feedBacks);

    }

    public function show($id)
    {
        $feedBack = FeedBack::findOrFail($id);

        return new ApiSuccessResponse($feedBack);
    }

    public function edit($id)
    {
        return new FeedBackResource(FeedBack::findOrFail($id));
    }

    public function update(UpdateFeedbackRequest $request, Feedback $feedback)
    {
        $feedback->update($request->validated());

        return new ApiSuccessResponse($feedback,['message' => 'Feedback update successfully']);
    }

    public function destroy($id)
    {
        $this->authorize('delete-feedback');
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();
        $this->logService->createLog('feedback_deleted', 'feedback deleted', $feedback);

        return new ApiSuccessResponse([],['message' => 'Feedback deleted successfully']);
    }

}
