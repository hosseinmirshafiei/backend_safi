<?php

namespace App\Http\Controllers\Admin\Slide;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SlideRequest;
use App\Http\Services\ImageUpload\ImageUploadService;
use App\Models\Slide;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SlideController extends Controller
{

    public function index(SlideRequest $request)
    {
        $req = $request->all();
        $slides = Slide::where("group", $req["group"])->get()->first();
        if (empty($slides)) {
            $slides = [];
        } else {
            $slides = json_decode($slides->slide);
        }
        return response()->json(["slides" => $slides]);
    }

    public function uploadImage(SlideRequest $request)
    {
        $path = 'images/slides/';
        $response_key = "image";
        $request_key = "image";
        $response = ImageUploadService::UploadImage($path, $request, $request_key, $response_key);
        return response()->json([$response_key => $response]);
    }

    public function create(SlideRequest $request)
    {
        $req = $request->all();
        $slide = $req['slide'];
        if (empty($slide)) {
            $slide = null;
        } else {
            $slide = json_encode($slide);
        }
        $group = $req["group"];
        $slider = Slide::where("group", $group)->get()->first();
        if (empty($slider)) {
            Slide::create(["slide" => $slide, "group" => $group]);
        } else {
            $slider->update(["slide" => $slide]);
        }
        $slider_res = Slide::where("group", $group)->get()->first();
        $slider_res = json_decode($slider_res->slide);
        return response()->json(["slides" => $slider_res]);
    }
}
