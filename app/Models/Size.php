<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;
    protected $table= "sizes";
    protected $fillable = ["size" , "size_id"];
    
    public function setSizeAttribute($value)
    {
        $converted = convertPersianToEnglish($value);
        $value = convertArabicToEnglish($converted);
        $this->attributes["size"] = $value;
    }
    public function type(){
        return $this->belongsTo(Size::class , "size_id");
    }
    public function sizes()
    {
        return $this->hasMany(Size::class);
    }
}
