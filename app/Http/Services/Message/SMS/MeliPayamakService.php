<?php

namespace App\Http\Services\Message\SMS;

use Illuminate\Support\Facades\Config;


class MeliPayamakService
{

    public function send($to , $otpCode , $bodyId = 171372)
    {
        $user = Config::get("userPassMeliPayamak.user");
        $password = Config::get("userPassMeliPayamak.password");

        $data = array('username' => "19382804657", 'password' =>"1gdba",'text' => " $otpCode" ,'to' =>$to ,"bodyId"=>$bodyId);
        $post_data = http_build_query($data);
        $handle = curl_init('https://rest.payamak-panel.com/api/SendSMS/BaseServiceNumber');
        curl_setopt($handle, CURLOPT_HTTPHEADER, array(
            'content-type' => 'application/x-www-form-urlencoded'
        ));
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($handle, CURLOPT_POST, true);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
        $response = curl_exec($handle);
    }
}
