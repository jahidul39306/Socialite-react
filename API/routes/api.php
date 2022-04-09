<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\SaveController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//post
Route::post('/post/create',[PostController::class, 'postCreate'])->name('post.create');
Route::get('/post/allposts',[PostController::class, 'allPosts'])->name('all.posts');
Route::get('/post/myposts',[PostController::class, 'myPosts'])->name('my.posts');
Route::get('/post/editposts/{id}',[PostController::class, 'postEdit'])->name('post.edit');
Route::post('/post/editposts/submit/{id}',[PostController::class, 'postEditSubmit'])->name('post.edit.submit');
Route::get('/post/delete/{id}',[PostController::class, 'postDelete'])->name('post.delete');

//comment
Route::get('/comment/view/{postId}', [CommentController::class, 'commentView'])->name('comment.view');
Route::post('/comment/create/{postId}',[CommentController::class, 'commentCreate'])->name('comment.create');
Route::get('/comment/edit/{commentId}', [CommentController::class, 'commentEdit'])->name('comment.edit');
Route::post('/comment/edit/submit/{commentId}', [CommentController::class, 'commentEditSubmit'])->name('comment.edit.submit');
Route::get('/comment/delete/{commentId}', [CommentController::class, 'commentDelete'])->name('comment.delete');

//save
Route::get('/save/create/{postId}', [SaveController::class, 'saveCreate'])->name('save');
Route::get('/save/show', [SaveController::class, 'saveShow'])->name('save.show');