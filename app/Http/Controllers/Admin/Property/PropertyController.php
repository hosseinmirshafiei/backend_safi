<?php

namespace App\Http\Controllers\Admin\Property;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PropertyRequest;
use App\Models\Category;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index(PropertyRequest $request){
        $category_id = $request["category_id"];
        $category = Category::find($category_id);
        $properties = Property::where("category_id" , $category_id)
        ->where("property_id" , null)
        ->with("values")
        ->get();
        $response = ["properties"=> $properties , "category"=>$category];
        return response()->json($response);
    }

    public function create(PropertyRequest $request){
       $category_id = $request["category_id"];
       $properties = $request["properties"];
       if($request->has("property_id")){
            $property_id = $request["property_id"];
       }else{
            $property_id = null;
       }
       foreach($properties as $property){
        if($property["name"] != null){
         Property::create([
            "category_id"=>$category_id ,
            "property_id" => $property_id,
            "name"=>$property["name"],
        ]);
        }
       }
        $properties_updated = Property::where("category_id", $category_id)
            ->where("property_id", null)
            ->with("values")
            ->get();
        $response = ["properties"=> $properties_updated];  
        return response()->json($response);
    }

    public function delete(PropertyRequest $request){

        $id = $request["id"];
        $property = Property::find($id);
        $property->delete();
        return response()->json("success");
    }
    public function update(PropertyRequest $request)
    {

        $id   = $request["id"];
        $name = $request["name"];
        $property = Property::find($id);
        $property->update(["name"=>$name]);
        return response()->json("success");
    }
}
