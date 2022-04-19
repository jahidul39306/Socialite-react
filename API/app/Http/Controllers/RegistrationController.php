<?php

namespace App\Http\Controllers;
use App\Models\Profile;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\Work_profile;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\MailController;

class RegistrationController extends Controller
{
    public function registration()
    {
        return view('Authenticate.registration');
    }

    public function registrationGoogle()
    {
        session(['from' => 'registration']);
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function registrationSubmit(Request $req)
    {
        $req->validate(
            [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required'
            ]
        );
        $user = User::where('email', $req->email)->first();
        if($user)
        {
            return response()->json(['msg' => "Email is already taken, choose another email", 'color' => "red", 'result' => false]);
        }
        
        $us = new User();
        $us->name = $req->name;
        $us->email = $req->email;
        $us->password = Hash::make($req->password);
        $us->type = 'General';
        $us->status = 1;
        $us->emailVerified = 0;
        if($us->save())
        {
            // redirect()->route('send.mail', ["userId" => $us->id, "email" => $us->email]);
            $mailCon = new MailController;
            $mailCon->sendMail($us->id, $us->email);
            return response()->json(['msg' => "Registration successfull, Please verify email to login", 'color' => "green", 'result' => true]);
            
        }
        return response()->json(['msg' => "Registartion failed", 'color' => "red", 'result' => false]);
        
        $profile=new Profile();
        $profile->fk_users_id=$us->id;
        $profile->save();

        $work_Profile=new Work_profile();
        $work_Profile->fk_users_id=$us->id;
        $work_Profile->save();

        Session::flash('message', 'Registration successful!, Please login');
        return redirect()->route('login');
    }

    public function registrationGoogleSubmit(Request $user)
    {
        $findUser = User::where('google_id', $user->googleId)->first();
        if($findUser)
        {
            return response()->json(['msg' => "Email already taken, choose another email", 'color' => "red", 'result' => false]);
        }
        else
        {
            $newUser = new User();
            $newUser->email = $user->email;
            $newUser->name = $user->name;
            $newUser->type = 'General';
            $newUser->status = 1;
            $newUser->emailVerified = 0;
            $newUser->google_id = $user->googleId;
            if($newUser->save())
            {
                $mailCon = new MailController;
                $mailCon->sendMail($newUser->id, $newUser->email);
                return response()->json(['msg' => "Registration successful!, Please login", 'color' => "green", 'result' => true]);
            }
            return response()->json(['msg' => "Registration failed!", 'color' => "red", 'result' => false]);
            $profile=new Profile();
            $profile->fk_users_id = $newUser->id;
            $profile->save();

            $work_Profile=new Work_profile();
            $work_Profile->fk_users_id=$newUser->id;
            $work_Profile->save();

            Session::flash('message', 'Registration successful!, Please login');
            return redirect()->route('login');
        }
    }
}
