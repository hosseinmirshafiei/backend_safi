<?php

namespace App\Http\Controllers\Web\Payment;

use App\Http\Controllers\Controller;
use App\Http\Services\Payment\PaymentCallBack;
use App\Http\Services\Payment\PaymentService;
use App\Models\OnlinePayment;
use App\Models\Order;
use App\Models\Otp;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Events\TransactionBeginning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PaymentCallBackController extends Controller
{

    public function paymentCallback(OnlinePayment $onlinePayment, $type_payment, $wallet_payment)
    {
        return DB::transaction(function () use($onlinePayment, $type_payment, $wallet_payment){

             $callBack = new PaymentCallBack;
             $callBack->paymentCallBack($onlinePayment, $type_payment, $wallet_payment);
        });
    }

    public function paymentResult($id)
    {
        if (isset($_COOKIE['token'])) {
            
            $token = $_COOKIE['token'];
            $user = Otp::where('token', $token)->where('used', 1)->get()->first();
            $user_id = $user->user_id;
            $find_user = ['user_id' => $user_id];


            $onlinePayment = OnlinePayment::where($find_user)->where("id", $id)->get()->first();

            if (!empty($onlinePayment)) {
                $bank_second_response = json_decode($onlinePayment->bank_second_response);
                if ($bank_second_response->data == null) {
                    //error payment
                    $result = "error";
                    $date = \Morilog\Jalali\Jalalian::fromCarbon($onlinePayment->updated_at)->format('Y/m/d');
                    return view("weblayouts.payment_result",  compact('result', 'date', 'onlinePayment', 'bank_second_response'));
                } else {
                    //succes payment
                    $result = "success";
                    $date = \Morilog\Jalali\Jalalian::fromCarbon($onlinePayment->updated_at)->format('Y/m/d');
                    return view("weblayouts.payment_result", compact('result', 'date', 'onlinePayment', 'bank_second_response'));
                }
            }
        }
    }
}
