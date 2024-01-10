<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Http\Services\ImageUpload\ImageUploadService;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{

    public function index(CategoryRequest $request){
        $req = $request->all();
        $name = $req['name'];
        $lastId = $req["last_id"];
        $page = $req["page"];

        $categories = Category::when($name != null, function ($query) use ($name) {
            $query->where('name', 'LIKE', "%$name%");
        })
            ->when($page == 1, function ($query) {
                $query->where('id', ">", 0);
            })
            ->when($page != 1, function ($query) use ($lastId) {
                $query->where('id', "<", $lastId);
            })
            ->with("parent", "child")
            ->orderBy('id', 'desc')
            ->limit(20)
            ->get();

        return response()->json($categories);
    }

    public function delete(CategoryRequest $request){
        $req = $request->all();
        $id_category=$req["id"];
        $category = Category::where('id' , $id_category)->get()->first();
        if(!empty($category)){
        $category->delete();
        return response()->json("delete");
        }

    }

    public function allCategory(){

        $categories = Category::all();
        return response()->json(["success", "categories"=>$categories]);
    }

    public function create(CategoryRequest $request){

        $req = $request->all();
        $category = Category::create($req);
        $new_category = Category::where("id" , $category->id)->with("parent" , "child")->get()->first();
        $categories = Category::all();
        return response()->json(["success" , "categories"=>$categories , "new_category" => $new_category]);
    }

    public function edit(CategoryRequest $request){

        $req= $request->all();
        $id= $req['id'];
        $category = Category::where('id' , $id)->get()->first();
        if(!empty($category)){
            $categories = Category::where("id" , "!=" , $id)->get();
            $response = ["category"=>$category , "all_category"=>$categories];
            return response()->json($response);
        }
    }

    public function update(CategoryRequest $request){

        $req = $request->all();
        $id = $req['id'];
        $category_id = $req['category_id'];

        $category = Category::where('id', $id)->where("id" , "!=" , $category_id)->get()->first();
        if (!empty($category)) {
            $category->update($req);
            $updated_category = Category::where("id", $category->id)->with("parent", "child")->get()->first();
            return response()->json(["success" , "updated"=> $updated_category]);
        }
    }

    public function upload(CategoryRequest $request)
    {
        $path = 'images/category/';
        $response_key = "image";
        $request_key = "image";
        $response = ImageUploadService::UploadImage($path, $request, $request_key, $response_key);
        return response()->json([$response_key => $response]);
    }

    public function status(CategoryRequest $request){
        $req = $request->all();
        $id = $req["id"];
        $category= Category::where("id" , $id)->get()->first();
        if(!empty($category)){
        if($category->status == 1){
             $status = 0;
        }else{
             $status = 1;
        }
        $category->update(["status"=>$status]);
        return response()->json(["status" => $status]);
       }
    }
}
