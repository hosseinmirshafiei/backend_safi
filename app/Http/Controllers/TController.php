<?php

namespace App\Http\Controllers;

use App\Events\TestEvent;
use App\Http\Requests\Admin\CommentRequest;
use App\Http\Services\Serrr;
use App\Mail\MailTest;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\PropertyProduct;
use App\Models\User;
use App\Notifications\NotifyTestMail;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use PhpParser\Node\Stmt\Foreach_;
use Termwind\Components\Raw;

class TController extends Controller
{

    public function index()
    {

    // $categories = Category::where("id", 165)->with("childes")->get();
    // $categoriesId = [];
    // foreach ($categories as $category) {
    //     array_push($categoriesId, $category->id);
    //     for ($i = 0; $i <br $category->count() ; $i++) {
    //         foreach ($category->childes as $category) {
    //             array_push($categoriesId, $category->id);
    //         }
    //     }
    // }
    // $products=Product::whereIn("category_id" , $categoriesId)
    // ->with("discount" ,"color.color")
    // ->orderBy("id" , "desc")->get();
    // dd($products);


    ///////////////get discounted products 
    // $products = Product::has('discount')->with("discount")->take(20)->get();
    // dd($products);

    /////////////get discounted products 
    // $products = Product::where(function($query){
    //     $query->where("number", ">", 0)->doesntHave("color");
    // })->orWhereHas("colorEnought")->get();
    /////////////////
    // $products = Product::where("number" , ">" , 0)->doesntHave("color")->orWhereHas("colorEnought")->with("color")->limit(20)->get();
    // dd($products);
    //////////////////
    // $productsDiscounted = Product::where(function($query){
    //     $query->where("number", ">", 0)->doesntHave("color")->orWhereHas("colorEnought");
    // })->whereHas("discount")->with("discount", "color.color")->orderBy("id" , "desc")->limit(20)->get();
    // dd($productsDiscounted);

    /////
    // $products = Product::leftJoin('product_color', function ($join) {
    //     $join->on('products.id', '=', 'product_color.product_id')
    //     ->where("product_color.number" ,">" , 0)
    //     ->where("product_color.deleted_at" , null);
    // })->with("color")->orderBy("products.id" , "desc")->groupBy('products.id')->get(['products.*' , 'product_color.price']);
    // dd($products);

    /// orderBy product_id
    // $products = Product::leftJoin('product_color', function ($join) {
    //     $join->on('products.id', '=', 'product_color.product_id')
    //     ->where("product_color.deleted_at" , null)
    //     ->where("product_color.status" , 1)
    //     ->where("number", ">", 0);
    // })->with("color")
    // ->orderBy("product_color.product_id" , "desc")
    // ->orderBy("products.id", "desc")
    // ->groupBy('products.id')->get(['products.*' , 'product_color.price' , 'product_color.number' , 'product_color.product_id']);

    ///orderBy price
    // $products = Product::leftJoin('product_attributes', function ($join) {
    //     $join->on('products.id', '=', 'product_attributes.product_id')
    //     ->where("product_attributes.deleted_at" , null)
    //     ->where("product_attributes.status" , 1)
    //     ->where("product_attributes.number", ">", 0);
    // })->with("attribute")
    // ->orderByRaw('product_attributes.number > 0 desc , products.price + product_attributes.price_increase desc')
    // ->groupBy('products.id')
    // ->get(['products.*', 'product_attributes.price_increase', 'product_attributes.number']);

    // foreach ($products as $key => $product) {
    //     echo $product->id."  price : ". $product->price + $product->price_increase . "  number : " . $product->number."//////";
    // }

    // $orders = Order::whereHas("user" , function($query){
    //      $query->where("mobile" , "09222222222");
    // })->get();
    // dd($orders);

    // $user = User::checkLogin();
    //
    // dd("hello");

    /////notify email send
    // $user=User::where("id" , 20)->get()->first();
    // Notification::send($user, new NotifyTestMail());
    //////
    ///////mail send 
    // $data = ["title"=>"test" , "body"=>"sdsdsdsdsdsdsd"];
    // Mail::to('hossein.mirshafiei97@gmail.com')->send(new MailTest($data));

    // return view("welcome");

    // $cahe = Cache::has("users");
    // if($cahe){
    //    $users = Cache::get("users");
    //    dd($users);
    // }else{
    //   $users = User::all();
    //   Cache::put('users', $users, now()->addMinutes(10));
    // }
    event(new \App\Events\TestEvent("mm" , "jkj"));
  }
}
