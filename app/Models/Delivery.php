<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;
    protected $table="delivery";
    protected $fillable =['sefareshiBase','pishtazBase','sefareshiWeight','pishtazWeight','status'];

    ///scope
    public function scopeDelivery($query)
    {
        return $query->where("status", 1)->where("sefareshiBase", ">", 0)->get()->first();
    }

    protected $casts = [
        'sefareshiBase' => 'integer',
        'pishtazBase' => 'integer',
        'sefareshiWeight' => 'integer',
        'pishtazWeight'=>'integer',
    ];
}
