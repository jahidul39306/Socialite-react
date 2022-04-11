<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Follower;
use Illuminate\Support\Facades\Session;

class FollowerController extends Controller
{
    public function followerCreate(Request $req)
    {
        $userId = $req->userId;
        $result = Follower::select('*')->where([
            // ['fk_follower_users_id', '=', Session::get('id')],
            ['fk_follower_users_id', '=', 15],
            ['fk_users_id', '=', $userId]
        ])->first();

        if($result != null)
        {
            if($result->delete())
            {
                return response()->json(['msg' => 'follower delted']);
            }
            return response()->json(['msg' => 'failed to delete follower']);
        }

        $result = new Follower();
        // $result->fk_follower_users_id = Session::get('id');
        $result->fk_follower_users_id = 15;
        $result->fk_users_id = $userId;
        
        if($result->save())
        {
            return response()->json(['msg' => 'follower created']);
        }
        return response()->json(['msg' => 'failed to create follower']);
    }

    public function checkFollowing(Request $req)
    {
        $userId = decrypt($req->userId);
        $result = Follower::select('*')->where([
            ['fk_follower_users_id', '=', Session::get('id')],
            ['fk_users_id', '=', $userId]
        ])->first();
        return $result;
    }

    public function followerShow()
    {
        $followers = Follower::where('fk_users_id', Session::get('id'))->get();
        return response()->json($followers);
    }

    public function followingShow()
    {
        $followings = Follower::where('fk_follower_users_id', Session::get('id'))->get();
        return response()->json($followings);
    }
}
