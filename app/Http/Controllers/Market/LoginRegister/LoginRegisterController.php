<?php

namespace App\Http\Controllers\Market\LoginRegister;

use App\Http\Controllers\Controller;
use App\Http\Requests\Market\LoginRegisterRequest;
use App\Http\Services\Message\SMS\MeliPayamakService;
use App\Models\Cart;
use App\Models\Otp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class LoginRegisterController extends Controller
{


    public function loginRegister(LoginRegisterRequest $request)
    {
        $inputs = $request->all();

        $phone = convertPersianToEnglish($inputs['id']);
        $phone = convertArabicToEnglish($phone);
        $inputs['id'] = $phone;

        //check id is email or not
        if (filter_var($inputs['id'], FILTER_VALIDATE_EMAIL)) {
            $type = 1; // 1 => email
            $user = User::where('email', $inputs['id'])->first();
            if (empty($user)) {
                $newUser['email'] = $inputs['id'];
            }
        }

        //check id is mobile or not
        elseif (preg_match('/^(\+98|98|0)9\d{9}$/', $inputs['id'])) {
            $type = 0; // 0 => mobile;


            // all mobile numbers are in on format 9** *** ***
            // $inputs['id'] = ltrim($inputs['id'], '0');
            $inputs['id'] = substr($inputs['id'], 0, 2) === '98' ? substr($inputs['id'], 2) : $inputs['id'];
            $inputs['id'] = str_replace('+98', '', $inputs['id']);

            $user = User::where('mobile', $inputs['id'])->first();
            if (empty($user)) {
                $newUser['mobile'] = $inputs['id'];
            }
        } else {
            $errorText = ['error' => 'شماره تلفن وارد شده صحیح نیست.'];
            return response()->json($errorText);
        }

        if (empty($user)) {
            $newUser['password'] = '98355154';
            $user = User::create($newUser);
        }

        //create otp code
        $otpCode = rand(11111, 99999);
        $token = Str::random(60);
        $otpInputs = [
            'token' => $token,
            'user_id' => $user->id,
            'otp_code' => $otpCode,
            'login_id' => $inputs['id'],
            'type' => $type,
        ];

        Otp::create($otpInputs);

        //send sms or email

        if ($type == 0) {
            // $sms = new MeliPayamakService;
            // $sms->send($phone , $otpCode);
        }

        $otp = Otp::where('token', $token)->get(['created_at'])->first();
        $timer = ((new \Carbon\Carbon($otp->created_at))->addMinutes(1)->timestamp - \Carbon\Carbon::now()->timestamp);
        $res = ["token" => $token, "timer" => $timer];
        return response()->json($res);
    }


    public function loginConfirm(LoginRegisterRequest $request)
    {

        $inputs = $request->all();
        $token = $inputs['token'];

        $o = convertPersianToEnglish($inputs['otp']);
        $o = convertArabicToEnglish($o);
        $inputs['otp'] = $o;

        $otp = Otp::where('token', $token)->where('used', 0)->where('created_at', '>=', Carbon::now()->subMinute(1)->toDateTimeString())->first();
        if (empty($otp)) {
            $error = ['error' => 'کد وارد شده صحیح نیست.'];
            return response()->json($error);
        }

        //if otp not match
        if ($otp->otp_code !== $inputs['otp']) {
            $error = ['error' => 'کد وارد شده صحیح نیست.'];
            return response()->json($error);
        } else {
            // if everything is ok :
            $otp->update(['used' => 1]);
            $user = $otp->user()->first();
            $name = "user_" . $user->id + 1000;
            if ($otp->type == 0 && empty($user->mobile_verified_at)) {
                $user->update(['mobile_verified_at' => Carbon::now() , "name"=>$name]);
            } elseif ($otp->type == 1 && empty($user->email_verified_at)) {
                $user->update(['email_verified_at' => Carbon::now() , "name" => $name]);
            }

            //set cookie for 1 year
            setcookie("token", $token, time() + 31556926, "/", "127.0.0.1", NULL, TRUE);  //http only bayad true bashad baraye amniat

            /////////// update cart from sesseion_id to user_id for market website

            $user_id = $user->id;
            $update_cart_after_login = Cart::updateCartAfterLogin($user_id);
            $cart = Cart::where("user_id", $user_id)->with("product.discount", "attribute.color", "attribute.size")->orderBy("id" , "desc")->get();
            $res = ["success" => "success", "cart" => $cart, "user" => $user];
            return response()->json($res);
        }
    }


    public function loginResendOtp(LoginRegisterRequest $request)
    {

        $inputs = $request->all();

        $t = convertPersianToEnglish($inputs['token']);
        $t = convertArabicToEnglish($t);
        $inputs['token'] = $t;

        $token = $inputs['token'];
        $otp = Otp::where('token', $token)->where('created_at', '<=', Carbon::now()->subMinutes(1)->toDateTimeString())->first();

        if (empty($otp)) {
            $error = ['error' => 'آدرس وارد شده صحیح نمی باشد.'];
            return response()->json($error);
        }

        $user = $otp->user()->first();
        //create otp code
        $otpCode = rand(11111, 99999);
        $token = Str::random(60);
        $otpInputs = [
            'token' => $token,
            'user_id' => $user->id,
            'otp_code' => $otpCode,
            'login_id' => $otp->login_id,
            'type' => $otp->type,
        ];

        Otp::create($otpInputs);

        //send sms or email

        if ($otp->type == 0) {
            $user_otp = Otp::where('token', $token)->with('user:id,mobile')->get()->first();
            $mobile = $user_otp->user->mobile;

              $sms = new MeliPayamakService;
              $sms->send($mobile , $otpCode);

        }


        $otp = Otp::where('token', $token)->get(['created_at'])->first();
        $timer = ((new \Carbon\Carbon($otp->created_at))->addMinutes(1)->timestamp - \Carbon\Carbon::now()->timestamp);
        $res = ["token" => $token, "timer" => $timer];
        return response()->json($res);
    }

    public function logout()
    {
        //remove cookie for logout
        setcookie("token", "", 0, '/', "127.0.0.1", NULL, TRUE);  //http only bayad true bashad baraye amniat
        $session_id = Str::random(60);
        setcookie("session_id", $session_id, time() + 31556926, "/", "127.0.0.1", NULL, TRUE);
        return response()->json("logout");
    }
}
