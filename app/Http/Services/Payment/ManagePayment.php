<?php

namespace App\Http\Services\Payment;

use App\Http\Services\Payment\PaymentService;
use App\Models\OnlinePayment;
use App\Models\Wallet;

class ManagePayment{

    public function payWithInternet($payment_price , $user_id , $order){
        $online_payment = OnlinePayment::where('order_id', $order->id)->get()->first();
        if (empty($online_payment)) {
            $paymented = OnlinePayment::create([
                'amount' => $payment_price,
                'user_id' => $user_id,
                'order_id' => $order->id,
                'status' => 1,
            ]);
        } else {
            $paymented = $online_payment;
        }
        $paymentService = new PaymentService;
        $amount = $payment_price * 10;
        $type_payment = "shopping";
        $wallet_payment = "false";
        $authority_code = $paymentService->zarinpal($amount, $paymented, $type_payment, $wallet_payment);
        return $authority_code;
    }

    public function payByWallet($user_id , $payment_price , $order){
        $wallet = Wallet::where("user_id", $user_id)->get()->first();
        $wallet_amount = $wallet->amount;
        if (empty($wallet)) {
            Wallet::create(["user_id" => $user_id, "amount" => 0]);
            $wallet_amount = 0;
        } else {
            $wallet_amount = $wallet->amount;
        }
        ///pay by wallet without internet pay
        if ($wallet_amount >= $payment_price) {
            $this->payByWalletWithOutInternet($order, $wallet_amount, $payment_price, $wallet);
              
        } else {
              $authority_code = $this->payByWalletWithInternet($user_id, $payment_price, $wallet_amount, $order);
              return $authority_code;
        }
    }
    public function payByWalletWithOutInternet($order, $wallet_amount, $payment_price, $wallet)
    {
        $order->update(["payment" => 1]);
        $new_amount = $wallet_amount - $payment_price;
        $wallet->update(["amount" => $new_amount]);
    }
    public function payByWalletWithInternet($user_id , $payment_price , $wallet_amount , $order)
    {
        $payment_price = $payment_price - $wallet_amount;
        $online_payment = OnlinePayment::where('order_id', $order->id)->get()->first();
        if (empty($online_payment)) {
            $paymented = OnlinePayment::create([
                'amount' => $payment_price,
                'user_id' => $user_id,
                'order_id' => $order->id,
                'status' => 1,
            ]);
        } else {
            $paymented = $online_payment;
        }
        $paymentService = new PaymentService;
        $amount = $payment_price * 10;
        $type_payment = "shopping";
        $wallet_payment = true;
        $authority_code = $paymentService->zarinpal($amount, $paymented, $type_payment, $wallet_payment);
        return $authority_code;
    }
}
