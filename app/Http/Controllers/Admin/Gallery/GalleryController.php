<?php

namespace App\Http\Controllers\Admin\Gallery;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GalleryRequest;
use App\Http\Services\ImageUpload\ImageUploadService;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class GalleryController extends Controller
{

    public function index(GalleryRequest $request){

        $req =$request->all();
        $gallery = Gallery::where("product_id" , $req["product_id"])->get()->first();
        if(empty($gallery)){
            $gallery = [];
        }else{
           $gallery = json_decode($gallery->images);
        }
        return response()->json(["images"=> $gallery]);
   }

    public function uploadImage(GalleryRequest $request){

        $path = 'images/gallery_product/';
        $response_key = "image";
        $request_key = "image";
        $response = ImageUploadService::UploadImage($path, $request, $request_key, $response_key);
        return response()->json([$response_key => $response]);
    }

    public function create(GalleryRequest $request){

        $req = $request->all();
        $images = $req['images'];
        if(empty($images)){
           $images = null;
        }
        else{
           $images = json_encode($images);
        }
        $product_id = $req["product_id"];
        $gallery = Gallery::where("product_id" , $product_id)->get()->first();
        if(empty($gallery)){
            Gallery::create(["images" => $images, "product_id" => $product_id]);
        }
        else{
            $gallery->update(["images" => $images]);
        }
        $gallery_res = Gallery::where("product_id", $product_id)->get()->first();
        $gallery_res = json_decode($gallery_res->images);
        return response()->json(["images" => $gallery_res]);
    }
}
