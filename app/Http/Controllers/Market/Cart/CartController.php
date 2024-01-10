<?php

namespace App\Http\Controllers\Market\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\Market\CartRequest;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Delivery;
use App\Models\GeneralDiscount;
use App\Models\ProductAttribute;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CartController extends Controller
{
  public function index()
  {

    $user = User::checkLogin();
    $is_login = false;
    $cart = [];
    if ($user != null) {
      $cart = Cart::where("user_id", $user->id)->with("product.discount", "attribute.color", "attribute.size")->orderBy("id", "desc")->get();
      $is_login = true;
    } else {
      if (isset($_COOKIE['session_id'])) {
        $session_id = $_COOKIE["session_id"];
        $cart = Cart::where("session_id", $session_id)->with("product.discount", "attribute.color", "attribute.size")->get();
      }
    }
    $general_discount = GeneralDiscount::generalDiscount();
    $delivery = Delivery::Delivery();
    return response()->json(["cart" => $cart, "general_discount" => $general_discount, "delivery" => $delivery, "is_login" => $is_login]);
  }

  public function create(CartRequest $request)
  {
    $user_id = null;
    $session_id = null;
    $user = User::checkLogin();
    if ($user != null) {
      $user_id = $user->id;
      $condition = ["user_id" => $user->id];
    } else {
      if (isset($_COOKIE['session_id'])) {
        $session_id = $_COOKIE["session_id"];
        $condition = ["session_id" => $session_id];
      } else {
        $session_id = Str::random(60);
        $condition = ["session_id" => $session_id];
        setcookie("session_id", $session_id, time() + 31556926, "/", "127.0.0.1" , false, true);
      }
    }
    $number = $request["number"];
    $product_id = $request["product_id"];
    $product_attribute_id = $request["product_attribute_id"];
   ///
    $product_attribute = ProductAttribute::where("id", $product_attribute_id)->get()->first();
    ///
    $cart_pre = Cart::where($condition)->where("product_id", $product_id)->where("product_attribute_id", $product_attribute->id)->orderBy("id", "desc")->get()->first();
    ///
    if ($product_attribute->number >= $number) {
      if (empty($cart_pre)) {
        Cart::create([
          "user_id" => $user_id,
          "session_id" => $session_id,
          "number" => $number,
          "product_id" => $product_id,
          "product_attribute_id" => $product_attribute->id,
        ]);
      } else {
        $cart_pre->update(["number" => $number]);
      }
    }
    $cart = Cart::where($condition)->with("product.discount", "attribute.color", "attribute.size")->orderBy("id", "desc")->get();
    return response()->json(["cart" => $cart]);
  }

  public function delete(CartRequest $request)
  {
    $id = $request["id"];
    $condition = ["session_id" => "no"];
    $user = User::checkLogin();
    if ($user != null) {
      $condition = ["user_id" => $user->id];
    } else if (isset($_COOKIE["session_id"])) {
      $session_id = $_COOKIE["session_id"];
      $condition = ["session_id" => $session_id];
    }
    Cart::where($condition)->where("id", $id)->get()->first()->delete();
    $cart = Cart::where($condition)->with("product.discount", "attribute.color", "attribute.size")->orderBy("id", "desc")->get();
    return response()->json($cart);
  }

  public function submit(CartRequest $request)
  {
    $cart_request = $request["cart"];
    $user = User::checkLogin();
    $user_state = null;
    if (!empty($user)) {
      $user_id = $user->id;
      $condition = ["user_id" => $user_id];
      $user_state = "token";
    } else {
      $condition = ["user_id"=> "no_id"];
      $user_state = null;
    }
    $cart = Cart::where($condition)->with("attribute")->orderBy("id" , "desc")->get();
    $error_enough = [];
    foreach ($cart as $cart_item) {
      foreach ($cart_request as $cart_req_item) {
        if ($cart_item->id == $cart_req_item["id"]) {
          if($cart_item->attribute->number < $cart_req_item["count"]){
             array_push($error_enough,$cart_item);
            //  if($cart_item->attribute->number <= 0){
            //   $cart_item->delete();
            //  }
          }
        }
      }
    }

    if(empty($error_enough)){
      $result_submit = "success";
      foreach ($cart as $cart_item) {
        foreach ($cart_request as $cart_req_item) {
          if ($cart_item->id == $cart_req_item["id"]) {
            if ($cart_item->attribute->number >= $cart_req_item["count"]) {
              $number = $cart_req_item["count"];
              $cart_item->update(["number" => $number]);
            }
          }
        }
      }
    }else{
      $result_submit = "not_success";
    }
    $address = Address::where("user_id" , $user_id)->get();
    $cart_updated = Cart::where($condition)->with("product.discount", "attribute.color", "attribute.size")->orderBy("id" , "desc")->get();
    return response()->json(["result_submit"=>$result_submit,"cart"=>$cart_updated , "user_state"=>$user_state , "address"=>$address]);
  }
}
