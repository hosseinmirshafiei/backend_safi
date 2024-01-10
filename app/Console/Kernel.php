<?php

namespace App\Console;

use App\Models\Cart;
use App\Models\Order;
use App\Models\ProductAttribute;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $orders = Order::where("created_at", "<=", Carbon::now()->subHour(1))
                ->where("payment", 0)
                ->get();
            if ($orders->count() > 0) {
                foreach ($orders as $order) {
                    $order_cart = json_decode($order->cart);
                    foreach ($order_cart as $cart) {
                        /// add to product 
                        $product_attribute = ProductAttribute::where("id", $cart->product_attribute_id)->get()->first();
                        $number_updated = $product_attribute->number + $cart->number;
                        $product_attribute->update(["number" => $number_updated]);
                        /// add to cart
                        $cart_id = $cart->id;
                        $cart_exist = Cart::where("user_id" , $order->user_id)->where("product_id" , $cart->product_id)->where("product_attribute_id" , $cart->product_attribute_id)->get();
                        if($cart_exist->count() == 0){
                          Cart::withTrashed()->where("id", $cart_id)->get()->first()->restore();
                        }
                    }
                    $order->delete();  // delete order
                }
            }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
