<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyProduct extends Model
{
    use HasFactory;
    protected $table="property_product";
    protected $fillable = ["property_id" , "product_id" , "custom"];

    public function property(){
        return $this->belongsTo(Property::class , "property_id");
    }
}
