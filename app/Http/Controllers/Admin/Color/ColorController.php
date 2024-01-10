<?php

namespace App\Http\Controllers\Admin\Color;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ColorRequest;
use App\Models\Color;
use App\Models\Product;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index(ColorRequest $request)
    {

        $req = $request->all();
        $name = $req['name'];
        $lastId = $req["last_id"];
        $page = $req["page"];

        $colors = Color::when($name != null, function ($query) use ($name) {
            $query->where('name', 'LIKE', "%$name%");
        })
            ->when($page == 1, function ($query) {
                $query->where('id', ">", 0);
            })
            ->when($page != 1, function ($query) use ($lastId) {
                $query->where('id', "<", $lastId);
            })
            ->withTrashed()
            ->orderBy('id', 'desc')
            ->limit(100)
            ->get();
        return response()->json($colors);
    }

    public function create(ColorRequest $request)
    {
        $req = $request->all();
        $color = Color::create($req);
        return response()->json($color);
    }

    public function delete(ColorRequest $request)
    {

        $req = $request->all();
        $id = $req["id"];
        $color = Color::where('id', $id)->withTrashed()->get()->first();
        if (!empty($color)) {
            if ($color->deleted_at == null) {
                $color->delete();
                return response()->json("delete");
            } else {
                $color->restore();
                return response()->json("restore");
            }
        }
    }

    public function edit(ColorRequest $request){
        $req = $request->all();
        $id = $req['id'];
        $color = Color::find($id);
        return response()->json($color);
    }
    public function update(ColorRequest $request){
        $req=$request->all();
        $id=$req["id"];
        $color = Color::find($id);
        if(!empty($color)){
            $color->update($req);
            return response()->json("success");
        }
    }
}
