<?php

namespace App\Http\Controllers\Market\Offers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Market\OffersRequest;
use App\Models\Delivery;
use App\Models\GeneralDiscount;
use App\Models\Product;
use Illuminate\Http\Request;

class OffersController extends Controller
{
    public function index(OffersRequest $request){

        $sortType = $request["sort_type"];
        $products_id_list = $request["products_id_list"];

        $products = Product::Products()
        ->SortProducts($sortType)
        ->PaginationProducts($products_id_list)
        ->Discounted()
        ->GetProducts();
 
        $general_discount = GeneralDiscount::generalDiscount();
        $delivery = Delivery::Delivery();
        return response()->json(["products" => $products, "delivery" => $delivery, "general_discount" => $general_discount]);

    }
}
