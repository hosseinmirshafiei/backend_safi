<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory , SoftDeletes;
    protected $table = "orders";
    protected $fillable = ['user_id', 'address_id', 'price', 'payment', 'cart', 'checked' , "general_discount" , "delivery_price"];

    protected $casts = [
        'payment' => 'integer',
        'price' => 'integer',
        'checked' => 'integer',
        'general_discount' => 'integer',
        'delivery_price' => 'integer',
    ];
    
    public function address(){
        return $this->belongsTo(Address::class , "address_id");
    }
    public function user(){
        return $this->belongsTo(User::class , "user_id");
    }
}
