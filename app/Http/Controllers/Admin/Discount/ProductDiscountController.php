<?php

namespace App\Http\Controllers\Admin\Discount;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductDiscountRequest;
use App\Models\Product;
use App\Models\ProductDiscount;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductDiscountController extends Controller
{

    public function index(ProductDiscountRequest $request)
    {
        $req = $request->all();
        $lastId = $req["last_id"];
        if ($req['page'] == 1) {
            $operator = ">";
            $skip = 0;
        } else {
            $operator = "<";
            $skip = $req['page'] * 100 - 100;
        }
        $now_timestamp = Carbon::now()->timestamp;
        $products_discount = ProductDiscount::where('id', $operator, $lastId)->where("status", 1)->where("percent_discount" , ">" , 0)->where("finish_discount", ">", $now_timestamp)->with("product.category")->orderBy('id', 'desc')->limit(100)->get();

        return response()->json($products_discount);
    }


    public function show(ProductDiscountRequest $request)
    {
        $req = $request->all();
        $productDiscount =  ProductDiscount::where('product_id', $req["product_id"])->get()->first();
        $product = Product::where("id", $req["product_id"])->with("attribute.color")->first();
        $response = ["discount"=>$productDiscount == null ? [] : $productDiscount , "product"=>$product];
        return response()->json($response);
    }

    public function create(ProductDiscountRequest $request)
    {
        $req = $request->all();
        $product_id = $req["product_id"];
        ///
        $convert_list = ['percent_discount', 'maximum_discount'];
        foreach ($convert_list as $item) {
            if ($req[$item] == null) {
                break;
            } else {
                $converted = convertPersianToEnglish($req[$item]);
                $req[$item] = convertArabicToEnglish($converted);
            }
        }
        ////
        if ($req['start_discount'] < $req['finish_discount']) {
            $discount = ProductDiscount::where('product_id', $product_id)->get()->first();
            if (empty($discount)) {
                ProductDiscount::create($req);
            } else {
                $discount->update($req);
            }
            $discount_updated = ProductDiscount::where('product_id', $product_id)->get()->first();
            $product = Product::find($req["product_id"]);
            $response = ["discount" => $discount_updated, "product" => $product];
            return response()->json($response);
        }
    }

    public function status(ProductDiscountRequest $request)
    {
        $req = $request->all();
        $product_id = $req["product_id"];
        $productDiscount =  ProductDiscount::where('product_id', $product_id)->get()->first();
        if (empty($productDiscount)) {
            ProductDiscount::create(["status" => 1, "product_id" => $product_id]);
        } else {
            $status = $productDiscount->status;
            if ($status == 0) {
                $productDiscount->update(["status" => 1]);
            } else {
                $productDiscount->update(["status" => 0]);
            }
        }
        $productDiscount_updated =  ProductDiscount::where('product_id', $product_id)->get()->first();
        $product = Product::find($req["product_id"]);
        $response = ["discount" => $productDiscount_updated, "product" => $product];
        return response()->json($response);
    }
}
