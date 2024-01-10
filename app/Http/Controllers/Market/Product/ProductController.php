<?php

namespace App\Http\Controllers\Market\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Market\ProductRequest;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\Category;
use App\Models\CategoryBrands;
use App\Models\Comment;
use App\Models\Delivery;
use App\Models\Gallery;
use App\Models\GeneralDiscount;
use App\Models\Product;
use App\Models\Property;
use App\Models\User;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function index(ProductRequest $request)
    {
        // $slug = $request["slug"];
        $sortType = 1;
        // $filters = $request["filters"];
        // $available = $request["available"];
        // $brands_selected = $request["brands_selected"];
        $products_id_list = $request["products_id_list"];
        // $filter_ids = [];
        // $propertyIds = [];
        // $categoriesId = [];
        // $brands = null;
        // $properties = null;
        
        ///category and category childs n-level
        // $categories = Category::where("slug", $slug)->with("childes")->get();
        // if($categories && $categories->count() > 0){
        // foreach ($categories as $category) {
        //     $categoriesId = Category::categoryChilds($category , $categoriesId);
        // }
        ////// get category brands for filters
        // $brands  = CategoryBrands::where("category_id" , $categories[0]->id)->with("brand")->get();
        //////get properties for filters
        // $category_id = $categories[0]->id;
        // $properties = Category::where("id", $category_id)
        //     ->with(["parents", "property"])
        //     ->get();
        // }
        //////get products
        $products = Product::Products()
        ->SortProducts($sortType)
        ->PaginationProducts($products_id_list)
        ->GetProducts();
         ////////
        $general_discount = GeneralDiscount::generalDiscount();
        $delivery = Delivery::Delivery();
        return response()->json(["products"=>$products , "delivery"=>$delivery , "general_discount"=>$general_discount]);
    }

    public function show(ProductRequest $request)
    {
        $req = $request->all();
        $slug = $req["slug"];
        $product = Product::where("slug", $slug)->with("discount", "attribute.color" , "attribute.size")->get()->first();
        if (!empty($product)) {
            $now_timestamp = Carbon::now()->timestamp;
            $brand = Brand::where("id", $product->brand_id)->get()->first();
            $gallery = Gallery::where("product_id", $product->id)->get()->first();
            if (!empty($gallery)) {
                $gallery = json_decode($gallery->images);
            }
            /////
            $general_discount = GeneralDiscount::generalDiscount();
            $properties = Property::whereHas("property_product" , function($query) use($product){
                $query->where("product_id" , $product->id);
            })->with("parent")->with("property_product" , function($query) use ($product){
                $query->where("product_id" , $product->id);
            })->get();

            /////cart product

            $user = User::checkLogin();
            $cart_product = Cart::
            where("product_id", $product->id)
            ->where(function($query) use($user){
                if ($user != null) {
                    $query->where("user_id" , $user->id);
                } else if (isset($_COOKIE['session_id'])) {
                    $session_id = $_COOKIE["session_id"];
                    $query->where("session_id", $session_id);
                }else{
                    $query->where("session_id", "no");
                }
            })
            ->get();
            //// comments
            $comments = Comment::where(function ($query) use ($product) {
                $query->where("product_id", $product->id)
                    ->where("comment_id", null);
            })
            ->where(function ($query) use ($user){
                $query->where("status", 1)
                ->when($user != null , function($query) use($user){
                $query->orWhere("user_id" , $user->id);
                });
            })
            ->where("id" , ">" , 0)->take(20)
            ->with("childs", "user")->orderBy("id", "desc")->get();

            //////
            $response = ["product" => $product, "brand" => $brand, "gallery" => $gallery, "comments" => $comments, "general_discount" => $general_discount, "nowDate" => $now_timestamp, "properties" => $properties , "cart_product" => $cart_product];
            return response()->json($response);
        }
    }
}
