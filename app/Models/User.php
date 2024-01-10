<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'is_admin',
        'password',
        'image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setNameAttribute($value)
    {
        $converted = convertPersianToEnglish($value);
        $value = convertArabicToEnglish($converted);
        $this->attributes["name"] = $value;
    }

    public static function checkLogin()
    {
        $user = null;
        if (isset($_COOKIE["token"])) {
            $token = $_COOKIE["token"];
            $otp = Otp::where("token", $token)->where("used", 1)->get()->first();
            if(!empty($otp)){
                $user_select = User::where("id", $otp->user_id)->get()->first();
                if (!empty($user_select)) {
                    $user = $user_select;
                }
            }
        }
        return $user;
    }
}
