<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Carbon\Carbon;
use App\Models\Post;
use App\Models\Notification;
use Illuminate\Support\Facades\Session;

class CommentController extends Controller
{
    public function commentView(Request $req)
    {
        $postId = $req->postId;
        // $post = Post::where('id', $postId)->first();
        $comments = Comment::select('*')->where('fk_posts_id', $postId)->get();
        return response()->json($comments);
    }

    public function commentCreate(Request $req)
    {
        $req->validate(
            [
                'comment' => 'required',
            ]
        );
        $postId = $req->postId;
        $c = new Comment();
        $c->text = $req->comment;
        $c->createdAt = Carbon::now();
        $c->fk_users_id = Session::get('id');
        // $c->fk_users_id = 14;
        $c->fk_posts_id = $postId;
        if($c->save())
        {
            return response()->json(['msg' => 'comment created']);
        }
        return response()->json(['msg' => 'failed to create comment']);

        $notification = new Notification();
        $notification->fk_users_id = $c->post->user->id;
        $notification->fk_notifier_users_id = Session::get('id');
        $notification->createdAt = Carbon::now();
        $notification->fk_posts_id = $postId;
        $notification->msg = "commented on your post";
        $notification->save();
        return redirect()->back();
    }

    public function commentEdit(Request $req)
    {
        $commentId = $req->commentId;
        $comment = Comment::where('id', $commentId)->first();
        return response()->json($comment);
    }

    public function commentEditSubmit(Request $req)
    {
        $req->validate(
            [
                'comment' => 'required',
            ]
        );
        $commentId = $req->commentId;
        $c = Comment::where('id', $commentId)->first();
        $c->text = $req->comment;
        if($c->save())
        {
            return response()->json(['msg' => 'comment edited']);
        }
        return response()->json(['msg' => 'failed to edit comment']);
        
        $postId = encrypt($c->fk_posts_id);
        return redirect()->route('comment.view', ['postId' =>$postId]);
    }

    public function commentDelete(Request $req)
    {
        $commentId = $req->commentId;
        
        if(Comment::where('id', $commentId)->delete())
        {
            return response()->json(['msg' => 'comment delted']);
        }
        return response()->json(['msg' => 'failed to delete comment']);
    }
}
