<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wallet extends Model
{
    use HasFactory ,SoftDeletes;

    protected $table= "wallet";
    protected $fillable = ["amount" , "user_id"];

    public function setAmountAttribute($value){
        $converted = convertPersianToEnglish($value);
        $value = convertArabicToEnglish($converted);
        $this->attributes["amount"] = $value;
    }

    protected $casts = [
        'amount' => 'integer',
    ];
}
