<?php

namespace App\Http\Controllers\Admin\AdminInfo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminInfoRequest;
use App\Http\Services\ImageUpload\ImageUploadService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminInfoController extends Controller
{
    public function index(){
    
        $user = User::checkLogin();
        $response  = ["user"=>$user];
        return response()->json($response);
    }

    public function uploadImage(AdminInfoRequest $request)
    {
        $path = 'images/profile/';
        $response_key = "image";
        $request_key = "image";
        $response = ImageUploadService::UploadImage($path, $request, $request_key, $response_key);
        return response()->json([$response_key => $response]);
    }
    public function edit(AdminInfoRequest $request){

        $name = $request["name"];
        $image = $request["image"];
        $user = User::checkLogin();
        $user->update(["image"=>$image , "name"=>$name]);
        $response = ["user"=> $user];
        return response()->json($response);
    }
}
