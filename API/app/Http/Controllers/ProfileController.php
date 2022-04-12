<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User;
use App\Models\Work_profile;
use PDF;
use App\Models\Follower;


class ProfileController extends Controller
{
    
    public function graph(Request $req)
    {
        $userId=$req->id;
        $data="";
        $result=Work_profile::where('fk_users_id','=',$userId)->select('institution','startYear','endYear')->get();
        foreach($result as $a)
        {
            $startDate = strtotime($a->startYear) ;
            $endDate=strtotime($a->endYear);
            $d=($endDate-$startDate)/(60*60*24);
            $data.="['".$a->institution."',   ".$d."],";
        }
        // dd($data);
        $chartData=$data;
        
        return response()->json(["chartData"=>$chartData]);
    }
    public function invoice(Request $req)
    {
        $userId=$req->id;
        $profileData=Profile::where('fk_users_id','=',$userId)->first();
        $workProfiles=Work_profile::where('fk_users_id','=',$userId)->get();
        $user=User::where('id','=',$userId)->first();
        if($user)
        {
            $pdf=PDF::loadView('Profile.invoice',compact('workProfiles','user','profileData'));
        
            if($pdf->download('invoice.pdf'))
            {
                return response()->json(["msg"=>"Invoice download successful"]);
            }
            else
            {
                return response()->json(["msg"=>"Invoice download successful"]);
            }
        }
        else
        {
            return response()->json(["msg"=>"User not found"]);
        }

        
    }
    public function getWorkProfile(Request $req)
    {
        //$userId=session()->get('id');
        $userId=$req->id;
        $profileData=Profile::where('fk_users_id','=',$userId)->first();
        $profileName=User::where('id','=',$userId)->select('name')->first();

        $workProfiles=Work_profile::where('fk_users_id','=',$userId)->get();
        //return view('Profile.workProfile')->with('profileData',$profileData)->with('profileName',$profileName)->with('workProfiles',$workProfiles);
        return response()->json(["profileData"=>$profileData,"profileName"=>$profileName,"workProfiles"=>$workProfiles]);
    }
    
    public function addWorkProfileSubmit(Request $req)
    {
        //$userId=session()->get('id');
        $userId=$req->id;
        $req->validate(
            [
                'institution'=>'required',
                'startYear'=>'required',
                'endYear'=>'required',
                'position'=>'required|regex: /^[A-Z a-z]+$/',

            ]
            );
        
        $workProfile=new Work_profile();
        $workProfile->institution=$req->institution;
        $workProfile->startYear=$req->startYear;
        $workProfile->endYear=$req->endYear;
        $workProfile->position=$req->position;
        $workProfile->fk_users_id=$userId;
        
        if($workProfile->save())
        {
            return response()->json(["msg"=>"Work Profile added"]);
        }
        else
        {
            return response()->json(["msg"=>"Work Profile added failed"]);
        }

    }

    public function deleteWorkProfile(Request $req)
    {
        $delete=Work_profile::where('id','=',$req->id)->delete();
        if($delete)
        {
            return response()->json(["msg"=>"Work Profile delete successful"]);
        }
        else
        {
            return response()->json(["msg"=>"Work Profile delete failed"]);
        }
    }
    public function editWorkProfile(Request $req)
    {
        $workProfile=Work_profile::where('id','=',$req->w_id)->first();
        return response()->json(["workProfile"=>$workProfile]);
    }
    public function editWorkProfileSubmit(Request $req)
    {
        $req->validate(
            [
                'institution'=>'required',
                'startYear'=>'required',
                'endYear'=>'required',
                'position'=>'required|regex: /^[A-Z a-z]+$/',

            ]
            );
        $workProfile=Work_profile::where('id','=',$req->w_id)->first();
        $workProfile->institution=$req->institution;
        $workProfile->startYear=$req->startYear;
        $workProfile->endYear=$req->endYear;
        $workProfile->position=$req->position;
        
        if($workProfile->save())
        {
            return response()->json(["msg"=>"Work Profile update successful"]);
        }
        else
        {
            return response()->json(["msg"=>"Work Profile update failed"]);
        }
        
    }
    public function editProfileData(Request $req)
    {
            $userId=$req->id;
            $profileData=Profile::where('fk_users_id','=',$userId)->first();
            $profileName=User::where('id','=',$userId)->select('name')->first();
            return response()->json(["profileData"=>$profileData,"profileName"=>$profileName]);
    }
    public function editProfileDataSubmit(Request $req)
    {
        //$userId=session()->get('id');
        //without session
        $userId=$req->id;
        
        $req->validate(
            [
                'name'=>'required|regex: /^[A-Z a-z]+$/',
                'address'=>'required',
                'dob'=>'required',
                'gender'=>'required',
                'religion'=>'required',
                'relationship'=>'required',
                
            ]
            );
        
        $profile=Profile::where('fk_users_id','=',$userId)->first();
        $user=User::where('id','=',$userId)->first();
        if($req->file('profileImage')=='')
        {
            $filename=$profile->profileImage;
            $profile->address=$req->address;
            $profile->dob=$req->dob;
            $profile->gender=$req->gender;
            $profile->religion=$req->religion;
            $profile->relationship=$req->relationship;
            $profile->fk_users_id=$userId;
            //$profile->save();
            $user->name=$req->name;
            //$user->save();

            if($profile->save() && $user->save())
            {
                return response()->json(["msg"=>"Profile Updated"]);
            }
            else
            {
                return response()->json(["msg"=>"Profile Updated failed"]);
            }
            
        }
        else{
            $filename=$req->name.'.'.$req->file('profileImage')->getClientOriginalExtension();
        //  return $filename;
            $req->file('profileImage')->storeAs('public/images',$filename);
            $profile->address=$req->address;
            $profile->dob=$req->dob;
            $profile->gender=$req->gender;
            $profile->religion=$req->religion;
            $profile->relationship=$req->relationship;
            $profile->profileImage="storage/images/".$filename;
            $profile->fk_users_id=$userId;
            //$profile->save();
            $user->name=$req->name;
            // $user->save();
            if($profile->save() && $user->save())
            {
                return response()->json(["msg"=>"Profile Updated"]);
            }
            else
            {
                return response()->json(["msg"=>"Profile Updated failed"]);
            }
        }
        
        // Session::flash('message', 'Profile upload successful');
        // return redirect()->route('profile');
    }
 
    public function getProfileData(Request $req)
    {
        
        //without session
            $userId=$req->id;
            $profileData=Profile::where('fk_users_id','=',$userId)->first();
            $profileName=User::where('id','=',$userId)->select('name')->first();
            
            //return $profileData->profileImage;
            return response()->json(["profileData"=>$profileData,"profileName"=>$profileName]);
            
        
        
    }

    public function getProfileByID(Request $req)
    {
        $userId = decrypt($req->userId);
        $profileData=Profile::where('fk_users_id','=',$userId)->first();
        $profileName=User::where('id','=',$userId)->select('name')->first();
        $result = Follower::select('*')->where([
            ['fk_follower_users_id', '=', Session::get('id')],
            ['fk_users_id', '=', $userId]
        ])->first();
        return view('Profile.profile')->with('profileData',$profileData)->with('profileName',$profileName)->with('result', $result);
    }

}