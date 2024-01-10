<?php

namespace App\Http\Controllers\Market\InfoWebSite;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Otp;
use App\Models\Setting;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;

class InfoWebSiteController extends Controller
{
  public function index(){
    $menu = Category::orderBy("id", "asc")->with("childes")->get();
    $settings = Setting::first();
    $contact = Contact::first();
    ///
    $user = User::checkLogin();
    $is_login=false;
    $cart= [];
    $wallet_amount = 0;
    if($user != null){
      $cart = Cart::where("user_id", $user->id)->with("product.discount", "attribute.color", "attribute.size")->orderBy("id", "desc")->get();
      $wallet = Wallet::where("user_id" , $user->id)->get()->first();
      if(!empty($wallet)){
        $wallet_amount = $wallet->amount;
      }
      $is_login= true;
    }else{
      if (isset($_COOKIE['session_id'])) {
        $session_id = $_COOKIE["session_id"];
        $cart = Cart::where("session_id", $session_id)->with("product.discount", "attribute.color", "attribute.size")->orderBy("id" , "desc")->get();
      }
    }
    ///
    return response()->json(["menu"=>$menu , "settings"=> $settings , "cart"=>$cart ,"is_login"=>$is_login , "user"=>$user , "wallet_amount"=>$wallet_amount , "contact"=>$contact]);
  }
}
