<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class ProductAttribute extends Model
{
    use HasFactory , SoftDeletes;
    protected $table = "product_attributes";
    protected $fillable= ["product_id" , "color_id" , "size_id" ,"price_increase", "number" , "status"];

    protected $casts = [
        'price_increase' => 'integer',
        'number' => 'integer',
        'size_id' => 'integer',
        'color_id' => 'integer',
    ];

    public function color(){
        return $this->belongsTo(Color::class , "color_id");
    }
    public function size()
    {
        return $this->belongsTo(Size::class, "size_id");
    }

}
