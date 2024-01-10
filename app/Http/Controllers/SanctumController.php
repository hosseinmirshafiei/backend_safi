<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SanctumController extends Controller
{
    public function reg(){
      
        $user  = User::Create(["pasword"=>233223]);
        return response()->json([
            'status' => true,
            'message' => 'User Created Successfully',
        ], 200);

    }
    public function log(Request $request){
        

        return $request->user();
    }
    public function test()
    {
        $id = auth('sanctum')->user()->id;
        return response()->json($id);
    }
}
