<?php

namespace App\Http\Controllers\Admin\PropertyProduct;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PropertyProductRequest;
use App\Http\Requests\Admin\PropertyRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Property;
use App\Models\PropertyProduct;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\PropertyProperty;

class PropertyProductController extends Controller
{
    public function index(PropertyProductRequest $request){

        $product_id = $request["product_id"];
        $product = Product::where("id" , $product_id)->get()->first();
        $category_id = $product->category_id;
        $properties_categories = Category::where("id", $category_id)
            ->with(["parents","property"])
            ->get();
        $property_product = PropertyProduct::where("product_id" , $product_id)->whereHas("property")->get();
        $response = ["properties_categories"=>$properties_categories , "product"=>$product , "property_product"=> $property_product];
        return response()->json($response);
    }

    public function submit(PropertyProductRequest $request){

        $product_id = $request["product_id"];
        $property_product = $request["property_product"];
        //delete properties previous
        PropertyProduct::where("product_id" , $product_id)->delete();

        foreach($property_product as $property){
         PropertyProduct::create(
            [
            "property_id"=>$property["id"],
             "product_id"=>$product_id,
             "custom"=>$property["custom"],
            ]
        );
        }
    
        return response()->json("success");

    }
}
