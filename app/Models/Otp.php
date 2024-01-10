<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Otp extends Model
{
    use HasFactory , SoftDeletes;
    protected $table = "otps";
    protected $fillable = ['token', 'user_id',    'otp_code',    'login_id',    'type',    'used',    'status'];
    protected $hidden = [
        'id',
        'token',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
