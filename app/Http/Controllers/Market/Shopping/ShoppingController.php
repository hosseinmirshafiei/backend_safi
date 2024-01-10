<?php

namespace App\Http\Controllers\Market\Shopping;

use App\Http\Controllers\Controller;
use App\Http\Requests\Market\ShoppingRequest;
use App\Http\Services\Payment\ManagePayment;
use App\Http\Services\Payment\PaymentService;
use App\Models\Address;
use App\Models\Cart;
use App\Models\City;
use App\Models\Delivery;
use App\Models\GeneralDiscount;
use App\Models\OnlinePayment;
use App\Models\Order;
use App\Models\ProductAttribute;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\PriceTotalOrder\PriceTotalOrder;


class ShoppingController extends Controller
{
    public function index(Request $request)
    {

        $user = User::checkLogin();
        $address = [];
        $cart    = [];
        $address_active = null;

        if (!empty($user)) {
            $cart = Cart::where("user_id", $user->id)->with("attribute.color", "attribute.size", "product.discount")->orderBy("id", "desc")->get();
            $address = Address::where("user_id", $user->id)->orderBy("active", "desc")->get();
            if ($cart && $cart->count() > 0 && $address && $address->count() > 0) {
                if ($address[0]["active"] == 1) {
                    $address_active = $address[0];
                }
            }
        }

        $new = new PriceTotalOrder();
        $price_total_order = $new->price($cart);
        $cart_count = $price_total_order["cart_count"];
        $delivery_price = $price_total_order["delivery_price"];
        $total_price = $price_total_order["total_price"];

        $province_cities = City::all();
        $response = ["cart" => $cart, "address" => $address, "cart_count" => $cart_count, "total_price" => $total_price, "delivery_price" => $delivery_price, "address_active" => $address_active, "province_cities" => $province_cities];
        return response()->json($response);
    }

    public function submit(ShoppingRequest $request)
    {
        $user = User::checkLogin();
        $login_State = false;
        $cart = [];
        $error_number = false;
        $payment_price = 0;
        $authority_code = null;
        $payment_way = $request["payment_way"];

        if (!empty($user)) {
            $login_State = true;
            $user_id = $user->id;
            $cart = Cart::where("user_id", $user_id)
            ->where("number", ">", 0)
            ->with("attribute.color", "attribute.size", "product.discount")
            ->get();
            foreach ($cart as $cart_item) {
                if (($cart_item->attribute->number < $cart_item->number) && $cart_item->number <= 0) {
                    $error_number = true;
                }
            }

            if ($error_number == false) {
                foreach ($cart as $cart_item) {
                    if (($cart_item->attribute->number >= $cart_item->number) && $cart_item->number > 0) {
                        $number_updated = $cart_item->attribute->number - $cart_item->number;
                        $cart_item->attribute->update(["number" => $number_updated]);
                        $cart_item->delete();
                    }
                }
                ////////
                $new = new PriceTotalOrder();
                $price_total_order = $new->price($cart);
                $payment_price =  $price_total_order["payment_price"];
                $general_discount = $price_total_order["general_discount"];
                $delivery_price = $price_total_order["delivery_price"];
                ////////
                $address_active = Address::where("user_id", $user_id)
                ->where("active", 1)
                ->get()
                ->first();
                ///////
                $order = Order::create([
                    "user_id" => $user_id,
                    "address_id" => $address_active->id,
                    "price" => $payment_price,
                    "payment" => 0,
                    "checked" => 0,
                    "cart" => json_encode($cart),
                    "general_discount" => json_encode($general_discount),
                    "delivery_price" => $delivery_price,
                ]);

                if ($payment_way == 1) {
                    $payment = new ManagePayment();
                    $authority_code = $payment->payWithInternet($payment_price, $user_id, $order);
                } 
                else if ($payment_way == 2) {
                    $payment = new ManagePayment();
                    $authority_code = $payment->payByWallet($user_id, $payment_price, $order);  
                }
            }
            $wallet_updated = Wallet::where("user_id", $user_id)->get()->first();
            if(empty($wallet_updated)){
                $wallet_amount_updated = 0;
            }else{
                $wallet_amount_updated = $wallet_updated->amount;
            }
        }
        /////////////
        $response = ["authority_code" => $authority_code, "login_state" => $login_State, "cart" => $cart, "error_number" => $error_number, "payment_price" => $payment_price, "wallet_amount" => $wallet_amount_updated];
        return response()->json($response);
    }
}
