<?php

namespace App\Http\Controllers\Admin\Biography;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BiographyRequest;
use App\Models\Biography;
use Illuminate\Http\Request;

class BiographyController extends Controller
{
    public function edit(){
        $response = Biography::first();
        return response()->json($response);
    }
    public function update(BiographyRequest $request){

        $req = $request->all();
        $biography = Biography::first();
        $biography->update(['title' => $req["title"] , 'description'=>$req["description"]]);
        return response()->json("success");
    }
}
