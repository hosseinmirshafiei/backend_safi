<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasFactory , SoftDeletes;
    protected $table = "cart";
    protected $fillable = ["session_id","user_id","number" , "product_id" , "product_attribute_id"];
    protected $hidden = [
        'session_id',
        'user_id',
    ];
    public function product(){
        return $this->belongsTo(Product::class , "product_id");
    }
    public function attribute()
    {
        return $this->belongsTo(ProductAttribute::class, "product_attribute_id")->where("status", 1);
    }

    protected static function booted()
    {
        static::addGlobalScope('published', function (Builder $builder) {
            $builder->wherehas("product")->whereHas("attribute");
        });
    }

    protected $casts = [
        'number' => 'integer',
        'product_id' => 'integer',
        'product_attribute_id' => 'integer',
    ];

    
    public static function updateCartAfterLogin($id){
        
        if (isset($_COOKIE['session_id'])) {
            $session_id = $_COOKIE['session_id'];

            $cart_session = Cart::where('session_id', $session_id)->get();
            $cart_user = Cart::where('user_id', $id)->with("product")->get();

            if ($cart_user->count() > 0) {

                foreach ($cart_user as $cart_user_item) {
                    foreach ($cart_session as $cart_session_item) {

                        if (
                            $cart_user_item->product_id == $cart_session_item->product_id &&
                            $cart_user_item->product_attribute_id == $cart_session_item->product_attribute_id &&
                            $cart_user_item->session_id != $cart_session_item->session_id
                        ) {
                            $cart_user_item->delete();
                        }
                    }
                }
            }

            if ($cart_session->count() > 0) {
                foreach ($cart_session as $cart) {
                    $cart->update(['user_id' => $id]);
                }
            }
        }
    }
}
