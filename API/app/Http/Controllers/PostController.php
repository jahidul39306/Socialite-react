<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    public function postCreate(Request $req)
    {
        $req->validate(
            [
                'postData' => 'required',
            ]
        );

        $p = new Post();
        $p->postText = $req->postData;
        $p->createdAt = Carbon::now();
        $p->status = 1;
        $p->fk_users_id = $req->id;
        // $p->fk_users_id = 14;
        if($p->save())
        {
            return response()->json(['msg' => 'post created']);
        }
        return response()->json(['msg' => 'failed to create post']);
    }

    public function allPosts()
    {
        $posts = Post::get();
        $data = [];
        foreach($posts as $post)
        {
            $temp = [
               "id" => $post->id,
               "postText" => $post->postText,
               "createdAt" => $post->createdAt,
               "status" => $post->status,
               "fk_users_id" => $post->fk_users_id,
               "postImage" => null,
               "userName" => $post->user->name,
            ];
            array_push($data, $temp);
        }
        return response()->json($data);
    }

    public function myPosts()
    {
        $posts = Post::where('fk_users_id', Session::get('id'))->get();
        // $posts = Post::where('fk_users_id', 14)->get();
   
        return response()->json($posts);
    }

    public function postEdit(Request $req)
    {
        $postId = $req->id;
        $post = Post::where('id', $postId)->first();
        return response()->json($post);
    }

    public function postEditSubmit(Request $req)
    {
        $req->validate(
            [
                'postData' => 'required',
            ]
        );
        $postId = $req->id;
        $p = Post::where('id', $postId)->first();
        $p->postText = $req->postData;
        if($p->save())
        {
            return response()->json(['msg' => 'post edited']);
        }
        return response()->json(['msg' => 'failed to edit post']);
    }

    public function postDelete(Request $req)
    {
        $postId = $req->id;
        
        if($p = Post::where('id', $postId)->delete())
        {
            return response()->json(['msg' => 'post delted']);
        }
        return response()->json(['msg' => 'failed to delete post']);
    }
}
