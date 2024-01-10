<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class GeneralDiscount extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "general_discount";
    protected $fillable = ['name_discount', 'percent_discount', 'maximum_discount','start_discount','finish_discount', 'status'];

    ///scope
    public function scopeGeneralDiscount($query)
    {
        $now_timestamp = Carbon::now()->timestamp;
        return $query->where("status", 1)->where("percent_discount", ">", 0)->where("start_discount", "<", $now_timestamp)->where("finish_discount", ">", $now_timestamp)->get()->first();
    }
    protected $casts = [
        'percent_discount' => 'integer',
        'maximum_discount' => 'integer',
        'start_discount' => 'integer',
        'finish_discount' => 'integer',
    ];
}
