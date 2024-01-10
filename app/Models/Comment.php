<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "comments";
    protected $fillable = ['body', 'product_id', 'user_id', 'comment_id', 'status'];

    public function child()
    {
        return $this->hasMany(Comment::class);
    }
    public function parent()
    {
        return $this->belongsTo(Comment::class, "comment_id");
    }
    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function childs()
    {
        $user = User::checkLogin();
        return $this->hasMany(Comment::class)
            ->where(function ($query) use ($user) {
                $query->where("status", 1)
                    ->when($user != null, function ($query) use ($user) {
                        $query->orWhere("user_id" , $user->id);
                    });
            })
            ->with("user")
            ->with("childs");
    }
}
