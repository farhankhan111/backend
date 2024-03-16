<?php

use App\Http\Controllers\Auth\MeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignOutController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Roles\RolePermissionController;
use App\Http\Controllers\Roles\RolesController;
use App\Http\Controllers\UploadFilesController;
use App\Http\Controllers\VoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\FeedBackController as AdminFeedBackController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Broadcast::routes(['middleware' => ['auth:api']]);


Route::prefix('auth')->group(function (){
    Route::post('signup', [RegisterController::class, 'SignUp']);
    Route::post('signin', [SignInController::class, 'SignIn']);

    Route::middleware(['auth:api'])->group(function () {
        Route::get('me', [MeController::class, 'index']);
        Route::post('signout', [SignOutController::class, 'SignOut']);
    });

});

Route::middleware(['auth:api'])->group(function () {
    Route::resource('feedbacks', FeedbackController::class);
    Route::get('user-feedbacks', [FeedbackController::class, 'getUserFeedbacks']);
    Route::Resource('admin/comments', AdminCommentController::class);
    Route::put('admin/comments/{comment}/moderate', [AdminCommentController::class, 'moderate'])
        ->middleware('can:moderate-comment');
    Route::Resource('admin/feedbacks', AdminFeedBackController::class);
    Route::resource('votes', VoteController::class);


    Route::prefix('feedbacks/{feedback}')->group(function () {
        Route::apiResource('comments', CommentController::class);
    });

    Route::resource('notifications', NotificationController::class);

});

Route::resource('roles', RolesController::class);
Route::post('/roles/{role}/permissions', [RolePermissionController::class, 'assignPermissionsToRole']);
Route::post('/roles/assign-roles-to-user', [RolesController::class, 'assignRole']);

Route::resource('permissions', \App\Http\Controllers\Roles\PermissionController::class);


Route::post('upload-csv', [UploadFilesController::class, 'uploadCsv']);






