<?php

namespace App\Http\Middleware\Market;

use App\Models\Order;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class OrdersMiddleWare
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
           $orders = Order::where("user_id" , $user->id)->get();
           if($orders->count() > 0){
                return $next($request);
           }else{
            return response()->json(null);
           }
        } else {
            return response()->json(null);
        }
    }
}
