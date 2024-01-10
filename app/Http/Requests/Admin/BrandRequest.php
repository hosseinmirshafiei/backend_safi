<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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
        if (request()->routeIs('admin.brand.index')) {
            return [
                'page' => ['integer'],
                'last_id' => ['integer'],
            ];
        } else if (request()->routeIs('admin.brand.create')) {
            return [
                'original_name' => ['required', 'max:250', 'regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.؟!"،()}{»«:_*%#@+ـ?,><\/;؛\n\r& ]+$/u'],
                'persian_name' => ['required', 'max:250', 'regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.؟!"،()}{»«:_*%#@+ـ?,><\/;؛\n\r& ]+$/u'],
                'logo' => ['nullable', 'string'],
            ];
        } else if (request()->routeIs('admin.brand.delete')) {
            return [
                'id' => ['required', 'integer'],
            ];
        } else if (request()->routeIs('admin.brand.edit')) {
            return [
                'id' => ['required', 'integer'],
            ];
        } else if (request()->routeIs('admin.brand.update')) {

            return [
                'id' => ['required', 'integer'],
                'original_name' => ['required', 'max:250', 'regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.؟!"،()}{»«:_*%#@+ـ?,><\/;؛\n\r& ]+$/u'],
                'persian_name' => ['required', 'max:250', 'regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.؟!"،()}{»«:_*%#@+ـ?,><\/;؛\n\r& ]+$/u'],
                'logo' => ['nullable', 'string'],
            ];
        } 
        else if (request()->routeIs('admin.brand.uploadimage')) {
            return [
                'logo' => ['required', 'image', "mimes:jpeg,png,jpg"],
            ];
        } 
    }
}
