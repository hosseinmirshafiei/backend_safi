<?php

namespace App\Http\Controllers\Admin\Attribute;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AttributeRequest;
use App\Models\Attribute;
use App\Models\Product;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function index(AttributeRequest $request){
       $req=$request->all();
       $product_id = $req["product_id"];
       $attributes = Attribute::where("product_id" , $product_id)->get(["id" , "key", "value"]);
       $product = Product::find($product_id);
       if($attributes->count() > 0){
            return response()->json(["attribute"=> $attributes, "product" => $product]);
       }else{
            $product = ["attribute"=>[] , "product" => $product];
            return response()->json($product);
       }
    }
    public function create(AttributeRequest $request)
    {
        $req = $request->all();
        $product_id = $req["product_id"];
        $attribute  = $req["attribute"];

        if(!empty($attribute)){
            Attribute::where("product_id", $product_id)->forceDelete();
            foreach($attribute as $el){
             Attribute::create([
                 "product_id" => $product_id,
                 "key" => $el["key"],
                 "value"=> $el["value"],
             ]);
           }
        }
        $new_attribute = Attribute::where("product_id" , $product_id)->get(["id" , "key" , "value"]);
        $product = Product::find($product_id);
        return response()->json(["attribute"=>$new_attribute , "product"=>$product]);
    }
}
