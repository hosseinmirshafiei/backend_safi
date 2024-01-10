<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        if(request()->routeIs('admin.category.index')){
          return [
               'page' => ['integer'],
               'name' => ['nullable','max:250', 'regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.؟!"،()}{»«:_*%#@+ـ?,><\/;؛\n\r& ]+$/u'],
               'last_id' => ['integer'],
           ];
        }
        else if(request()->routeIs('admin.category.create')){
            return [
                'name' => ['required', 'max:250', 'regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.؟!"،()}{»«:_*%#@+ـ?,><\/;؛\n\r& ]+$/u'],
                'category_id' => ['required', 'integer'],
            ];
        } 
        else if (request()->routeIs('admin.category.delete')) {
            return [
                'id' => ['required', 'integer'],
            ];
        } 
        else if (request()->routeIs('admin.category.edit')) {
            return [
                'id' => ['required','integer'],
            ];
        }
        else if (request()->routeIs('admin.category.update')) {
          
            return [
                'id' => ['required', 'integer'],
                'name' => ['required' , 'max:250', 'regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.؟!"،()}{»«:_*%#@+ـ?,><\/;؛\n\r& ]+$/u'],
                'category_id' => ['required', 'integer'],
            ];
        }
         else if (request()->routeIs('admin.category.upload')) {

            return [
                'image' => ['required', 'image', "mimes:jpeg,png,jpg"],
            ];
        } else if (request()->routeIs('admin.category.status')) {

            return [
                'id' => ['required', 'integer'],
            ];
        }

    }
}
