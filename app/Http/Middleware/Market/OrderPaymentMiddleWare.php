<?php

namespace App\Http\Middleware\Market;

use App\Models\Order;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class OrderPaymentMiddleWare
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
        $order_id = $request["id"];
        if ($user != null) {
            $order = Order::where("user_id", $user->id)->where("id" , $order_id)->where("payment" , 0)->get()->first();
            if (!empty($order)) {
                return $next($request);
            } else {
                return response()->json(null);
            }
        } else {
            return response()->json(null);
        }
    }
}
