<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductColor extends Model
{
    use HasFactory , SoftDeletes;
    protected $table = "product_color";
    protected $fillable = ['product_id' , "color_id" , "product_id" , "number" , "price" , "status"];

    public function setPriceAttribute($value)
    {
        $converted = convertPersianToEnglish($value);
        $value = convertArabicToEnglish($converted);
        $this->attributes["price"] = $value;
    }
    public function setNumberAttribute($value)
    {
        $converted = convertPersianToEnglish($value);
        $value = convertArabicToEnglish($converted);
        $this->attributes["number"] = $value;
    }
    
    public function color(){

        return $this->belongsTo(Color::class , "color_id");
    }
}
