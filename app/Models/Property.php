<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory , SoftDeletes;

    protected $table = "properties";
    protected $fillable = ["name" , "category_id" , "property_id" , "property_parent_id"];

    
    public function values(){
        return $this->hasMany(Property::class , "property_id");
    }

    public function property_product(){
        return $this->hasOne(PropertyProduct::class);
    }
    public function parent(){
        return $this->belongsTo(Property::class , "property_id");
    }
}
