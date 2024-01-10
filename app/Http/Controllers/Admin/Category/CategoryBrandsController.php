<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryBrandsRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CategoryBrands;
use Illuminate\Http\Request;

class CategoryBrandsController extends Controller
{
    public function index(CategoryBrandsRequest $request){
        $category_id = $request["category_id"];
        $category_brands = CategoryBrands::where("category_id",$category_id)->with("brand")->get();
        $all_brands = Brand::all();
        $category = Category::find($category_id);
        $response = ["category"=>$category , "category_brands"=> $category_brands , "brands"=>$all_brands];
        return response()->json($response);
    }
    public function update(CategoryBrandsRequest $request){
        $category_id = $request["category_id"];
        $category_brands = $request["category_brands"];
        CategoryBrands::where("category_id" , $category_id)->delete();
        foreach($category_brands as $brand){
        CategoryBrands::create(["category_id"=>$category_id , "brand_id"=>$brand["id"]]);
        }
        return response()->json("success");
    }
}
