<?php

namespace App\Http\Requests\Market;

use App\Rules\NumberValidation;
use Illuminate\Foundation\Http\FormRequest;

class LoginRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        if (request()->routeIs('market.loginRegister')) {
            return [
                'id' => ["required" , new NumberValidation],
            ];
        } else if (request()->routeIs('market.loginConfirm')) {
            return [
                'token'=> ["required", 'string'],
                'otp'  => ["required", new NumberValidation],
            ];
        } elseif (request()->routeIs('market.login-resend-otp')) {
            return [
                'token' => ['required' , "string"],
            ];
        }
    }
}
