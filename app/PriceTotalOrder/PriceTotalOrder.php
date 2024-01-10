<?php

namespace App\PriceTotalOrder;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Delivery;
use App\Models\GeneralDiscount;
use App\Models\User;

class PriceTotalOrder{

   public function price($cart){
        $cart_count = 0;
        $delivery_price = 0;
        $total_price = 0;

        $general_discount = GeneralDiscount::generalDiscount();
        $delivery = Delivery::delivery()->first();
        if (!empty($delivery)) {
            $delivery_price_base = $delivery->sefareshiBase;
            if ($delivery_price_base >= 0) {
                $delivery_price = $delivery_price_base;
            }
        }
        if ($cart && $cart->count() > 0) {
            foreach ($cart as $cart_item) {
                $number = $cart_item->number;
                $cart_count = $cart_count + $number;
                //price delivery handle
                if (!empty($delivery)) {

                    $delivery_price = $delivery_price + (($cart_item->product->weight / 1000) * $delivery->sefareshiWeight) * $number;
                }
                //price handle
                $price = $cart_item->attribute->price_increase + $cart_item->product->price;
                $product_discount = $cart_item->product->discount;
                if (!empty($product_discount)) {
                    $percent = $product_discount->percent_discount;
                    $max = $product_discount->maximum_discount;
                    $price_discounted = $price * ($percent / 100);
                    if ($max >= $price_discounted || $max <= 0) {
                        $price = ($price - $price_discounted) * $number;
                    } else if ($max > 0) {
                        $price = ($price - $max) * $number;
                    }
                } else if ($general_discount->count() > 0) {
                    $percent = $general_discount->percent_discount;
                    $max     = $general_discount->maximum_discount;
                    $price_discounted = $price * ($percent / 100);
                    if ($max >= $price_discounted || $max <= 0) {
                        $price = ($price - $price_discounted)  * $number;
                    } else if ($max > 0) {
                        $price = ($price - $max)  * $number;
                    }
                } else {
                    $price = $price * $number;
                }
                $total_price = $total_price + $price;
            }
        }
        if($total_price > 0){
            $payment_price = $total_price + $delivery_price;
        }else{
            $payment_price = 0;
        }
        $res = ["payment_price"=> $payment_price , "total_price" => $total_price, "delivery_price" => $delivery_price , "cart_count" => $cart_count , "general_discount"=>$general_discount];
        return $res;
   }
}
