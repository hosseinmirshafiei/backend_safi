<?php
namespace App\Http\Services\Payment;

use App\Http\Services\Message\SMS\MeliPayamakService;
use App\Http\Services\Payment\PaymentService;
use App\Models\Order;
use App\Models\User;
use App\Models\Wallet;

class PaymentCallBack
{

    public function paymentCallBack($onlinePayment, $type_payment, $wallet_payment)
    {

        $paymentService = new PaymentService;
        $price = $onlinePayment->amount;
        $amount = (int)$price * 10;
        $result = $paymentService->zarinpalVerify($amount, $onlinePayment);
        if ($result['success']) {
            
            ///find user
            $user = User::checkLogin();
            $user_id = $user->id;
            if ($type_payment == "charge_wallet") {
                $this->chargeWallet($user_id, $price);
            } else if ($type_payment == "shopping") {
                $this->paymentOrder($user_id, $onlinePayment, $wallet_payment, $price);
            }

            return redirect()->route("payment-result", [$onlinePayment->id])->send();
        } 
        else {
            return redirect()->route("payment-result" , [$onlinePayment->id])->send();
        }
    }
    public function chargeWallet($user_id, $price)
    {
        $wallet = Wallet::where("user_id", $user_id)->get()->first();
        if (empty($wallet)) {
            $amount_updated = $price;
            Wallet::create(["user_id" => $user_id, "amount" => $price]);
        } else {
            $amount_updated = $wallet->amount + $price;
            $wallet->update(["amount" => $amount_updated]);
        }
    }
    public function paymentOrder($user_id, $onlinePayment, $wallet_payment, $price)
    {
        $order = Order::where("user_id", $user_id)->where('id', $onlinePayment->order_id)->where('payment', 0)->get()->first();
        if (!empty($order)) {

            //sms to darvishai...
            $sms = new MeliPayamakService;
            $sms->send('09126521474' , 1 , 171652);
            
            if ($wallet_payment == true) {
                $wallet = Wallet::where("user_id", $user_id)->get()->first();
                if (!empty($wallet)) {
                    $total_wallet = $price + $wallet->amount;
                    if ($order->price <= $total_wallet) {
                        $wallet_updated = $total_wallet - $order->price;
                        $wallet->update(["amount" => $wallet_updated]);
                        $order->update(['payment' => 1, "updated_at" => now()]);
                    } else {
                        $wallet->update(["amount" => $total_wallet]);
                    }
                }
            } else {
                $order->update(['payment' => 1, "updated_at" => now()]);
            }
        }
    }
}
