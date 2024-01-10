<?php

namespace App\Http\Controllers\Admin\ProductColor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductColorRequest;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductColor;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductColorController extends Controller
{
    public function index(ProductColorRequest $request)
    {
        $req = $request->all();
        $id = $req["product_id"];
        $product = Product::where("id", $id)->get()->first();
        $colors = Color::all();
        $sizes = Size::all();
        $product_attributes = ProductAttribute::where("product_id", $id)->with('color','size')->get();
        if (!empty($product)) {
            return response()->json(["product" => $product, "colors" => $colors, "sizes"=>$sizes, "product_attributes" => $product_attributes]);
        }
    }

    public function update(ProductColorRequest $request)
    {
        $req = $request->all();
        $id = $req["product_id"];
        $product_colors = ProductAttribute::where("product_id", $id)->get();
        if($request->has("number")){
            $product_color_number = ProductAttribute::where("product_id", $id)->where("color_id" , null)->where("size_id" , null)->get()->first();
            if (empty($product_color_number)) {
                ProductAttribute::create(["number" => $req["number"], "status" => 1, "product_id" => $id]);
            }
            foreach($product_colors as $product){
               if($product->color_id == null && $product->size_id == null){
                   if(!empty($product_color_number)){
                      $product->update(["status" => 1 , "number"=>$req["number"]]);
                   }
               }else{
                  $product->update(["status" => 0]);
               }
        }
        }

        if ($request->has('colors')) {
            $colors = $req["colors"];
            foreach ($colors as $color) {
                $find = false;
                foreach ($product_colors as $productColor) {
                    if ($color["id"] == $productColor->id) {
                        $productColor->update(["color_id"=>$color["color_id"], "size_id" => $color["size_id"] , "price_increase" => $color["price_increase"], "number" => $color["number"] , "status"=>1]);
                        $find = true;
                    }
                }
                if ($find == false) {
                    $product_color = ProductAttribute::where("product_id", $id)->where('color_id', $color["id"])->get()->first();
                    if (empty($product_color)) {
                        ProductAttribute::create(["color_id" => $color["color_id"],"size_id"=>$color["size_id"], "product_id" => $id, "price_increase" => $color["price_increase"], "number" => $color["number"]]);
                    }
                }
            }
            foreach ($product_colors as $product_color) {
                $find = false;
                foreach ($colors as $color) {
                    if ($color["id"] == $product_color->id || $product_color->color_id == null) {
                        $find = true;
                    }
                }
                if ($find == false) {
                    $product_color->delete();
                }
                if($product_color->color_id == null && $product_color->size_id == null){
                    $product_color->update(["status"=>0]);
                }
            }
        }
        $product_colors = ProductAttribute::where("product_id", $id)->where("status" , 1)->with('color' , 'size')->get();
        return response()->json(["product_colors"=>$product_colors]);
    }
}
