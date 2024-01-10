<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory , SoftDeletes;
    protected $table = "address";
    protected $fillable = ["address","postal_code" , "mobile" ,"phone","active", "first_name" , "last_name" , "city" , "province" , "user_id"];
    ///mutators convert to english columns in database
    public function setMobileAttribute($value)
    {
        $converted = convertPersianToEnglish($value);
        $value = convertArabicToEnglish($converted);
        $this->attributes["mobile"] = $value;
    }
    public function setPhoneAttribute($value)
    {
        $converted = convertPersianToEnglish($value);
        $value = convertArabicToEnglish($converted);
        $this->attributes["phone"] = $value;
    }
    public function setPostalCodeAttribute($value)
    {
        $converted = convertPersianToEnglish($value);
        $value = convertArabicToEnglish($converted);
        $this->attributes["postal_code"] = $value;
    }
}
