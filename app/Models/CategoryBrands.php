<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryBrands extends Model
{
    use HasFactory;
    protected $table = "category_brands";
    protected $fillable = ["brand_id" , "category_id"];

    public function brand(){
        return $this->belongsTo(Brand::class , "brand_id");
    }
}
