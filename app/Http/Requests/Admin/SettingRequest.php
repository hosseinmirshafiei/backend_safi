<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
        if (request()->routeIs('admin.settings.create')) {
            return [
                'image' => ['nullable','string'],
                'title' => ['nullable','max:250', 'regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.؟!"،()}{»«:_*%#@+ـ?,><\/;؛\n\r& ]+$/u'],
                'meta_description' => ['nullable','max:250', 'regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.؟!"،()}{»«:_*%#@+ـ?,><\/;؛\n\r& ]+$/u'],
            ];
        } else if (request()->routeIs('admin.settings.upload')) {
            return [
                'image' => ['required', 'image', "mimes:jpeg,png,jpg"],
            ];
        } 
    }
}
