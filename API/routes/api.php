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
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\MailController;

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

//registration
Route::post('/registration/submit',[RegistrationController::class, 'registrationSubmit'])->name('registration.submit');

//registration google
Route::get('/registration/google',[RegistrationController::class, 'registrationGoogle'])->name('registration.google');
Route::get('/registration/google/submit',[RegistrationController::class, 'registrationGoogleSubmit'])->name('registration.google.submit');

//Login
Route::post('/login/submit',[LoginController::class, 'loginSubmit'])->name('login.submit');

//login google
Route::get('/login/google/submit',[LoginController::class, 'loginGoogleSubmit'])->name('login.google.submit');

//Email
Route::get('/send/mail/{userId}/{email}', [MailController::class, 'sendMail'])->name('send.mail');
Route::get('/verify/mail/{userId}', [UserController::class, 'verifyMail']);


//home
Route::get('/home',[HomeController::class, 'home'])->name('home');

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

//like
Route::get('/like/create/{postId}', [LikeController::class, 'likeCreate'])->name('like');

//follower
Route::get('/follower/create/{userId}',[FollowerController::class,'followerCreate'])->name('follower.create');
Route::get('/follower/show',[FollowerController::class,'followerShow'])->name('follower.show');
Route::get('/following/show',[FollowerController::class,'followingShow'])->name('following.show');

//notification
Route::get('/notification',[NotificationController::class,'notificationShow'])->name('notification.show');

//Profile
    Route::get('/profile/{id}',[ProfileController::class,'getProfileData'])->name('profile');
//edit profile 
    Route::get('/editProfile/{id}',[ProfileController::class,'editProfileData'])->name('editProfile');
    Route::post('/editProfile/{id}',[ProfileController::class,'editProfileDataSubmit'])->name('editProfileSubmit');

//work Profile
    Route::get('/workProfile/{id}',[ProfileController::class, 'getWorkProfile'])->name('workProfile');
    Route::post('/addWorkProfile/{id}',[ProfileController::class,'addWorkProfileSubmit'])->name('addWorkProfileSubmit');
    Route::post('/deleteWorkProfile/{id}',[ProfileController::class,'deleteWorkProfile'])->name('deleteWorkProfile');
    Route::get('/editWorkProfile/{w_id}',[ProfileController::class,'editWorkProfile'])->name('editWorkProfile');
    Route::post('/editWorkProfile/{w_id}',[ProfileController::class,'editWorkProfileSubmit'])->name('editWorkProfileSubmit');
//Report generate
    Route::get('/invoice/{id}',[ProfileController::class,'invoice'])->name('invoice');
//graph 
    Route::get('/graph/{id}',[ProfileController::class,'graph'])->name('graph');
//Change Password
    Route::post('/changePassword/{id}',[ChangePasswordController::class,'changePassword'])->name('changePassword');
//Page
    Route::post('/createPage/{id}',[PagesController::class,'create'])->name('createPage');
    Route::post('/deletePage/{p_id}',[PagesController::class,'delete'])->name('deletePage');
    Route::get('/editPage/{p_id}',[PagesController::class,'edit'])->name('editPage');
    Route::post('/editPage/{p_id}',[PagesController::class,'editSubmit'])->name('editPageSubmit');


//admin
//user
Route::get('/changestatus/{userId}',[UserController::class,'changeStatus'])->name('user.changeStatus');



Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/users', [AdminController::class, 'usersInfo'])->name('admin.users');
Route::get('/admin/comments', [AdminController::class, 'postsInfo'])->name('admin.posts');
Route::get('/admin/likes', [AdminController::class, 'commentsInfo'])->name('admin.comments');