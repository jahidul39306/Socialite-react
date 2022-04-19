<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login()
    {
        return view('Authenticate.login');
    }

    public function loginGoogle()
    {
        session(['from' => 'login']);
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function loginSubmit(Request $req)
    {
        $req->validate(
            [
                'email' => 'required|email',
                'password' => 'required'
            ],
        );
        $findUser = User::where('email', $req->email)->first();
        if(Hash::check($req->password, $findUser->password))
        {
            if($findUser->status == 0)
            {
                // Session::flash('message', 'You are blocked');
                // return redirect()->route('login');
                return response()->json(['msg' => "You are blocked", 'color' => "red"]);
            }
            if($findUser->emailVerified == 0)
            {
                // Session::flash('message', 'You are blocked');
                // return redirect()->route('login');
                return response()->json(['msg' => "Please verify your email", 'color' => "red"]);
            }
            Session::put('id', $findUser->id);
            Session::put('email', $findUser->email);
            Session::put('name', $findUser->name);
            Session::put('type', $findUser->type);
            Session::put('status', $findUser->status);
            $userData = [
                "userId" => $findUser->id,
                "email" => $findUser->email,
                "name" => $findUser->name,
                "type" => $findUser->type,
                "status" => $findUser->status,
                'msg' => "Login successful!",
                'color' => "green",
                'result' => true
            ];
            return response()->json($userData);
        }
        return response()->json(['msg' => "Wrong credentials", 'color' => "red"]);
    }

    public function loginGoogleSubmit(Request $user)
    {
        $findUser = User::where('google_id', $user->googleId)->first();
        if($findUser)
        {
            if($findUser->status == 0)
            {
                return response()->json(['msg' => "Login failed, you are blocked", 'color' => "red", 'result' => false]);
            }
            if($findUser->emailVerified == 0)
            {
                return response()->json(['msg' => "Please verify your email to login", 'color' => "red", 'result' => false]);
            }
            Session::put('id', $findUser->id);
            Session::put('email', $findUser->email);
            Session::put('name', $findUser->name);
            Session::put('type', $findUser->type);
            Session::put('status', $findUser->status);
            $userData = [
                "userId" => $findUser->id,
                "email" => $findUser->email,
                "name" => $findUser->name,
                "type" => $findUser->type,
                "status" => $findUser->status,
                'msg' => "Login successful!",
                'color' => "green",
                'result' => true
            ];
            return response()->json($userData);
           
        }
        else
        {
            return response()->json(['msg' => "You have no account with this email", 'color' => "red", 'result' => false]);
        }
    }
}
