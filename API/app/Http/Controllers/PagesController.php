<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class PagesController extends Controller
{
    public function create(Request $req)
    {
        $userId=$req->id;
        $req->validate(
            [
                'p_name'=>'required|unique:pages,p_name',
                'p_contact_number'=>'required|regex: /^[0-9]{11,11}+$/',
                'p_details'=>'required',

            ]
            );
        $page=new Page();
        $page->p_name=$req->p_name;
        $page->p_contact_number=$req->p_contact_number;
        $page->p_details=$req->p_details;
        $page->fk_users_id=$userId;
        if($page->save())
        {
            return response()->json(["msg"=>"Page Created"]);
        }
        else
        {
            return response()->json(["msg"=>"Page creation failed"]);
        }
    }
    public function delete(Request $req)
    {
        $delete=Page::where('id','=',$req->p_id)->delete();
        if($delete)
        {
            return response()->json(["msg"=>"Page delete successful"]);
        }
        else
        {
            return response()->json(["msg"=>"Page delete failed"]);
        }
    }
    public function edit(Request $req)
    {
        $page=Page::where('id','=',$req->p_id)->first();
        return response()->json(["page"=>$page]);
    }
    public function editSubmit(Request $req)
    {
        $req->validate(
            [
                'p_name'=>'required|unique:pages,p_name',
                'p_contact_number'=>'required|regex: /^[0-9]{11,11}+$/',
                'p_details'=>'required',

            ]
            );
        
        $page=Page::where('id','=',$req->p_id)->first();
        $page->p_name=$req->p_name;
        $page->p_contact_number=$req->p_contact_number;
        $page->p_details=$req->p_details;
        if($page->save())
        {
            return response()->json(["msg"=>"Page updated"]);
        }
        else
        {
            return response()->json(["msg"=>"Page update failed"]);
        }
    }
}
