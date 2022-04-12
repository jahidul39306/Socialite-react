<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function changePassword(Request $req)
    {
        $userId=$req->id;
        
        $req->validate(
            [
                'currentPassword'=>'required',
                'newPassword'=>'required|min:3|max:8|regex:/^[A-Za-z0-9]+$/',
                'conf_newPassword'=>'required'
                

            ]
            );
        $user = User::where('id', $userId)->first();
        
        if(Hash::check($req->currentPassword, $user->password))
        {
            if($req->newPassword == $req->conf_newPassword)
            {
                $user->password = Hash::make($req->newPassword);
                if($user->save())
                {
                    return response()->json(["msg"=>"Password update successful"]);
                }
                else
                {
                    return response()->json(["msg"=>"Password update failed"]);
                }
            }
            else
            {
                return response()->json(["msg"=>"new password and confirm password doesnot match"]);
            }
        }
        else{
            return response()->json(["msg"=>"Wrong current password"]);
        }

        
    }
}
