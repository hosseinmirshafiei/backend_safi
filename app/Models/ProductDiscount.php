<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class ProductDiscount extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "product_discount";
    protected $fillable = ['product_id','percent_discount', 'maximum_discount', 'start_discount', 'finish_discount', 'status'];

    protected $casts = [
        'percent_discount' => 'integer',
        'maximum_discount' => 'integer',
        'start_discount' => 'integer',
        'finish_discount' => 'integer',
    ];

    //relation
    public function product(){
        return $this->belongsTo(Product::class , "product_id");
    }
}
