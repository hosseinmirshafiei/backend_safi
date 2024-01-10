<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class AdminInfoRequest extends FormRequest
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
         if (request()->routeIs('admin.admin-info.edit')) {
            $user = User::checkLogin();
            return [
                'name' =>  ['required', 'string', "min:4", "max:30", 'unique:users,name,' . $user->id, 'regex:/^[a-zA-Z0-9۰-۹._]+$/u'],
                'image' => ['sometimes', 'string'],
            ];
        }
         else if (request()->routeIs('admin.admin-info.uploadImage')) {
            return [
                'image' => ['required', 'image', "mimes:jpeg,png,jpg"],
            ];
        } 
    }
}
