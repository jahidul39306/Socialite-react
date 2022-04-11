<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function changeStatus(Request $req)
    {
        // $userId = $req->userId;
        $userId = 15;
        $user = User::where('id', $userId)->first();
        if($user->status == 0)
        {
            $user->status = 1;
            if($user->save())
            {
                return response()->json(['msg' => 'user activated']);
            }
            return response()->json(['msg' => 'failed to change status']);
        }
        $user->status = 0;
        if($user->save())
        {
            return response()->json(['msg' => 'user blocked']);
        }
        return response()->json(['msg' => 'failed to change status']);
    }
}
