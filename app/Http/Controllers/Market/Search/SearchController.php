<?php

namespace App\Http\Controllers\Market\Search;

use App\Http\Controllers\Controller;
use App\Http\Requests\Market\SearchRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchProducts(SearchRequest $request){
        $req = $request->all();
        $name = $req["search"];
        $response = Product::where('name', 'LIKE', "%$name%")->take(10)->orderBy("id" , "desc")->get();
        return response()->json($response);
    }
}
