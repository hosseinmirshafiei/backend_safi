<?php

namespace App\Http\Controllers\Admin\Size;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SizeRequest;
use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
  public function index()
  {
    $size_types = Size::where("size_id", null)
      ->with("sizes", function ($query) {
        $query->orderBy("id", "desc");
      })
      ->orderBy("id", "desc")
      ->get();
    return response()->json($size_types);
  }
  public function create(SizeRequest $request){
   $size = $request["size"];
   $type = $request["type"];
   $new_size = Size::create(["size"=>$size , "size_id"=>$type]);
   return response()->json($new_size);
  }

    public function update(SizeRequest $request)
    {
        $id = $request["id"];
        $size = $request["size"];
        $type = $request["type"];
        $size_updated= Size::findOrFail($id)->update(["size" => $size, "size_id" => $type]);
        return response()->json($size_updated);
    }
    public function updateTypeSize(SizeRequest $request){
      $size_type = $request["size"];
      $id = $request["id"];
      $size = Size::find($id);
      $size->update(["size"=>$size_type]);
      return response()->json("success");
    }
    public function createTypeSize(SizeRequest $request){
      $size_type = $request["size"];
      $new = Size::create(['size'=>$size_type , "size_id"=>null]);
      return response()->json(["new_type_size"=>$new]);
    }
}
