<?php

namespace App\Http\Controllers\Market\Wallet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Market\WalletRequest;
use App\Http\Services\Payment\PaymentService;
use App\Models\Cart;
use App\Models\OnlinePayment;
use App\Models\Order;
use App\Models\User;
use App\Models\Wallet;
use App\PriceTotalOrder\PriceTotalOrder;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Ramsey\Uuid\Type\Integer;

class WalletController extends Controller
{
    public function charge(WalletRequest $request)
    {
        $amount = $request["amount"];
        $user = User::checkLogin();
        $login_state = false;
        ///convert amount to english number
        $converted = convertPersianToEnglish($amount);
        $amount = convertArabicToEnglish($converted);
        //// payment process
        if (!empty($user)) {
            $login_state = true;
            $user_id = $user->id;
            //success
            $paymented = OnlinePayment::create([
                'amount' => $amount,
                'user_id' => $user_id,
                'order_id' => null,
                'status' => 1,
            ]);
            $paymentService = new PaymentService;
            $amount = $amount * 10;
            $type_payment = "charge_wallet";
            $wallet_payment = "false";
            $authority_code = $paymentService->zarinpal($amount, $paymented, $type_payment, $wallet_payment);
        }

        $response = ["authority_code" => $authority_code, "login_state" => $login_state];
        return response()->json($response);
    }

    public function walletState()
    {
        $user = User::checkLogin();
        $user_id = $user->id;
        $cart = Cart::where("user_id", $user_id)->where("number", ">", 0)->with("attribute.color", "attribute.size", "product.discount")->get();
        $new = new PriceTotalOrder();
        $price_total_order = $new->price($cart);
        $payment_price =  $price_total_order["payment_price"];
        $wallet = Wallet::where("user_id", $user_id)->get()->first();
        if (!empty($wallet)) {
            $amount_wallet = $wallet->amount;
            if ($payment_price <= $amount_wallet) {
                $wallet_state = true;
            } else {
                $wallet_state = false;
            }
        } else {
            Wallet::create(["user_id"=>$user_id , "amount"=>0]);
            $wallet_state = false;
        }
        return response()->json(["wallet_state" => $wallet_state, "wallet" => $wallet , "payment_price"=>$payment_price]);
    }

    public function walletStateOrder(WalletRequest $request){
        $user = User::checkLogin();
        $user_id = $user->id;
        $order_id = $request["order_id"];
        $wallet = Wallet::where("user_id", $user_id)->get()->first();
        if (!empty($wallet)) {
            $amount_wallet = $wallet->amount;
            $order = Order::where("user_id", $user_id)->where("id" , $order_id)->get()->first();
            $payment_price =  $order->price;
            if ($payment_price <= $amount_wallet) {
                $wallet_state = true;
            } else {
                $wallet_state = false;
            }
        } else {
            $wallet_state = false;
        }
        return response()->json(["wallet_state" => $wallet_state, "wallet" => $wallet, "payment_price" => $payment_price]);
    }
}
