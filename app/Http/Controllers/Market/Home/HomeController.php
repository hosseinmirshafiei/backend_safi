<?php

namespace App\Http\Controllers\Market\Home;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Delivery;
use App\Models\GeneralDiscount;
use App\Models\Product;
use App\Models\ProductDiscount;
use App\Models\Setting;
use App\Models\Slide;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index(){
        $products = Product::WhereHas("colorEnought")->with("discount", "attribute.color" , "attribute.size")->orderBy("id", "desc")->get();
        /////////////get products discounted
        $productsDiscounted = Product::WhereHas("colorEnought")->whereHas("discount")->with("discount", "attribute.color" , "attribute.size")->orderBy("id", "desc")->limit(20)->get();
        ///////////////
        $delivery = Delivery::Delivery();
        $now_timestamp = Carbon::now()->timestamp;
        $general_discount= GeneralDiscount::GeneralDiscount();
        $slider = Slide::where("group", 1)->get();
        $slider = json_decode($slider[0]->slide);
        $menu = Category::where("status" , 1)->get();
        $response = ["products"=>$products , "productsDiscounted"=> $productsDiscounted ,"delivery"=>$delivery ,"general_discount"=>$general_discount , "menu"=>$menu , "slider"=>$slider , "date_now"=> $now_timestamp];
        return response()->json($response);
    }
}
