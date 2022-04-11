<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Like;
class AdminController extends Controller
{
    public function dashboard()
    {
        $info = [
            'totalUsers' => User::select('id')->get()->count(),
            'totalPosts' => Post::select('id')->get()->count(),
            'totalLikes' => Like::select('id')->get()->count(),
            'totalComments' => Comment::select('id')->get()->count(),
        ]; 
        return response()->json($info);
    }

    public function usersInfo()
    {
        $users = User::select('*')->get();
        return response()->json($users);
    }

    public function postsInfo()
    {
        $posts = Post::select('*')->get();
        return response()->json($posts);
    }

    public function commentsInfo()
    {
        $comments = Comment::select('*')->get();
        return response()->json($comments);
    }
}
