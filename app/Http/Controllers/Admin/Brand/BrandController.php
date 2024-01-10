<?php

namespace App\Http\Controllers\Admin\Brand;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BrandRequest;
use App\Http\Services\ImageUpload\ImageUploadService;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class BrandController extends Controller
{
    public function index(BrandRequest $request)
    {

        $req = $request->all();
        $lastId = $req["last_id"];
        $page = $req["page"];

        $brands = Brand::
            when($page == 1, function ($query) {
                $query->where('id', ">", 0);
            })
            ->when($page != 1, function ($query) use ($lastId) {
                $query->where('id', "<", $lastId);
            })
            ->withTrashed()
            ->orderBy('id', 'desc')
            ->limit(20)
            ->get();
        return response()->json($brands);
    }

    public function create(BrandRequest $request)
    {
        $req = $request->all();
        $req["tags"] = "yy";
        $brand = Brand::create($req);
        $new_brand = Brand::find($brand->id);
        return response()->json(["success" , "new_brand" => $new_brand]);
    }
    public function uploadImage(BrandRequest $request)
    {
        $path = 'images/brands/';
        $response_key = "logo";
        $request_key = "logo";
        $response = ImageUploadService::UploadImage($path, $request, $request_key, $response_key);
        return response()->json([$response_key => $response]);
    }

    public function delete(BrandRequest $request)
    {
        $req = $request->all();
        $id_brand = $req["id"];
        $brand = Brand::where('id', $id_brand)->withTrashed()->get()->first();
        if (!empty($brand)) {
            if($brand->deleted_at == null){
                $brand->delete();
                return response()->json("delete");
            }else{
                $brand->restore();
                return response()->json("restore");
            }
        }
    }

    public function edit(BrandRequest $request)
    {

        $req = $request->all();
        $brand = Brand::where("id", $req['id'])->get()->first();
        if (!empty($brand)) {
            return response()->json(["brand" => $brand]);
        }
    }

    public function update(BrandRequest $request)
    {

        $req = $request->all();
        $brand = Brand::where("id", $req['id'])->get()->first();
        if (!empty($brand)) {
            $brand->update($req);
            $updated_brand = Brand::find($brand->id);
            return response()->json(["success" , "updated" => $updated_brand]);
        }
    }
}
