<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CategoryBrandsRequest extends FormRequest
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
        if (request()->routeIs('admin.category-brands.index')) {
            return [
                'category_id' => ['integer'],
            ];
        }else if(request()->routeIs('admin.category-brands.update')){
            return [
                'category_id' => ['integer'],
                'category_brands' =>["nullable",'array'],
            ]; 
        }
    }
}
