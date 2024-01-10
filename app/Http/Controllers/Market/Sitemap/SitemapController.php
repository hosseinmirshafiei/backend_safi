<?php

namespace App\Http\Controllers\Market\Sitemap;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function products(){
        $products = Product::all();
        return response()->json($products);
    }
}
