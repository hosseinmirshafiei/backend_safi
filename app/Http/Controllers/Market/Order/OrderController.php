<?php

namespace App\Http\Controllers\Market\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Market\OrderRequest;
use App\Http\Services\Payment\PaymentService;
use App\Models\OnlinePayment;
use App\Models\Order;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $user = User::checkLogin();
        $user_id = $user->id;
        $orders = Order::where("user_id", $user_id)->with("address")->orderBy("id", "desc")->get();
        $response = ["orders" => $orders];
        return response()->json($response);
    }

    public function payment(OrderRequest $request)
    {
        $user = User::checkLogin();
        $login_State = false;
        $authority_code = null;
        $order_id = $request["id"];
        $payment_able = false;
        $payment_way = (int)$request["payment_way"];

        if (!empty($user)) {
            $login_State = true;
            $user_id = $user->id;
            $paymented = OnlinePayment::where("user_id", $user_id)->where("order_id", $order_id)->get()->first();
            $order = Order::where("id", $order_id)->where("user_id", $user_id)->where("payment", 0)->get()->first();
            if (!empty($paymented) && !empty($order)) {
                $payment_able = true;
                $payment_price = $order->price;
                if ($payment_way == 1) {
                    $paymentService = new PaymentService;
                    $amount = $order->price * 10;
                    $type_payment = "shopping";
                    $wallet_payment = "false";
                    $authority_code = $paymentService->zarinpal($amount, $paymented, $type_payment, $wallet_payment);
                } else if ($payment_way == 2) {
                    $wallet = Wallet::where("user_id", $user_id)->get()->first();
                    $wallet_amount = 0;
                    if (empty($wallet)) {
                        Wallet::create(["user_id" => $user_id, "amount" => 0]);
                        $wallet_amount = 0;
                    } else {
                        $wallet_amount = $wallet->amount;
                    }
                    if ($wallet_amount >= $payment_price) {
                        $order->update(["payment" => 1]);
                        $new_amount = $wallet_amount - $payment_price;
                        $wallet->update(["amount" => $new_amount]);
                    } else {
                        $payment_price = $payment_price - $wallet_amount;
                        $paymentService = new PaymentService;
                        $amount = $payment_price * 10;
                        $type_payment = "shopping";
                        $wallet_payment = true;
                        $authority_code = $paymentService->zarinpal($amount, $paymented, $type_payment, $wallet_payment);
                    }
                }
            }
            $wallet_amount_updated = 0;
            $wallet_updated = Wallet::where("user_id", $user_id)->get()->first();
            if(!empty($wallet_updated)){
                $wallet_amount_updated = $wallet_updated->amount;
            }
        }
        /////////////

        $response = ["authority_code" => $authority_code, "login_state" => $login_State, "payment_able" => $payment_able, "wallet_amount" => $wallet_amount_updated];
        return response()->json($response);
    }
}
