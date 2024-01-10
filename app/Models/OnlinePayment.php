<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OnlinePayment extends Model
{
    use HasFactory , SoftDeletes;
    protected $table = "online_payment";
    protected $fillable = ['user_id', 'order_id', 'amount', 'bank_first_response', 'bank_second_response', 'transaction_id', '	gateway', 'status'];
    
}
