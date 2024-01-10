<?php

namespace App\Http\Middleware\Market;

use App\Models\Address;
use App\Models\Cart;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class ShoppSubmit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = User::checkLogin();
        if($user != null){
            $cart = Cart::where("user_id" , $user->id)->get();
            if($cart->count() > 0){
                $address_active = Address::where("user_id" , $user->id)->where("active" , 1)->get()->first();
                if(!empty($address_active)){
                    return $next($request);
                }else{
                    return response()->json(null);
                }
            }else{
                return response()->json(null);
            }
        }else{
            return response()->json(null);
        }
    }
}
