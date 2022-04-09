<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Save;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class SaveController extends Controller
{
    public function saveCreate(Request $req)
    {
        
        $postId = $req->postId; 
        $fav = Save::select('*')->where(
            [
                ['fk_posts_id', '=', $postId],
                ['fk_users_id', '=', Session::get('id')]
                // ['fk_users_id', '=', 14]
            ]
        )->first();
        if($fav != null)
        {
            if($fav->delete())
            {
                return response()->json(['msg' => 'save delted']);
            }
            return response()->json(['msg' => 'failed to delete save']);
        }
        $fav = new Save();
        $fav->fk_posts_id = $postId;
        $fav->fk_users_id = Session::get('id');
        // $fav->fk_users_id = 14;
        
        if($fav->save())
        {
            return response()->json(['msg' => 'save created']);
        }
        return response()->json(['msg' => 'failed to create save']);

        $notification = new Notification();
        $notification->fk_users_id = $fav->post->user->id;
        $notification->fk_notifier_users_id = Session::get('id');
        $notification->createdAt = Carbon::now();
        $notification->fk_posts_id = $postId;
        $notification->msg = "favourited your post";
        $notification->save();
        return redirect()->back();
    }

    public function saveShow()
    {
        // 14
        $saves = Save::where('fk_users_id', Session::get('id'))->get();
        return response()->json($saves);
    }
}
