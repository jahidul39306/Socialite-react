<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class LikeController extends Controller
{
    public function likeCreate(Request $req)
    {
        $postId = $req->postId; 
        $like = Like::select('*')->where(
            [
                ['fk_posts_id', '=', $postId],
                ['fk_users_id', '=', Session::get('id')]
                // ['fk_users_id', '=', 14]
            ]
        )->first();
        if($like != null)
        {
            if($like->delete())
            {
                return response()->json(['msg' => 'like delted']);
            }
            return response()->json(['msg' => 'failed to delete like']);
        }
        $like = new Like();
        $like->fk_posts_id = $postId;
        $like->fk_users_id = Session::get('id');
        // $like->fk_users_id = 14;
        if($like->save())
        {
            return response()->json(['msg' => 'like created']);
        }
        return response()->json(['msg' => 'failed to create like']);

        $notification = new Notification();
        $notification->fk_users_id = $like->post->user->id;
        $notification->fk_notifier_users_id = Session::get('id');
        $notification->createdAt = Carbon::now();
        $notification->fk_posts_id = $postId;
        $notification->msg = "liked your post";
        $notification->save();
        return redirect()->back();
    }
}
