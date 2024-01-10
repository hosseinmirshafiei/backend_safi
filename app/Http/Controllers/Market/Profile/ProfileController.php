<?php

namespace App\Http\Controllers\Market\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Market\ProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Services\ImageUpload\ImageUploadService;

class ProfileController extends Controller
{
    public function index(){
        $user = User::checkLogin();
        $response = ["user"=>$user];
        return response()->json($response);
    }
    public function edit(ProfileRequest $request){

        $name = $request["name"];
        $image = $request["image"];
        $user = User::checkLogin();
        $user_id = $user->id;
        $user->update(["image"=>$image , "name"=>$name]);
        $user_updated = User::find($user_id);
        $response = ["user"=>$user_updated];
        return response()->json($response);
    }
    public function uploadImage(ProfileRequest $request)
    {
        $path = 'images/profile/';
        $response_key = "image";
        $request_key = "image";
        $response = ImageUploadService::UploadImage($path , $request , $request_key , $response_key);
        return response()->json([$response_key => $response]);
    }
}
