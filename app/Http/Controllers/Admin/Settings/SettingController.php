<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingRequest;
use App\Http\Services\ImageUpload\ImageUploadService;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    public function index(){
        $settings = Setting::first();
        return response()->json($settings);
    }

    public function create(SettingRequest $request){
      $req= $request->all();
      $settings = Setting::first();
      if(empty($settings)){
        Setting::create($req);
      }else{
        $settings->update($req);
      }
      $settings_updated = Setting::first();
      return response()->json($settings_updated);
    }

    public function upload(SettingRequest $request){
       $path = 'images/settings/';
       $response_key = "image";
       $request_key = "image";
       $response = ImageUploadService::UploadImage($path, $request, $request_key, $response_key);
       return response()->json([$response_key => $response]);
    }
}
