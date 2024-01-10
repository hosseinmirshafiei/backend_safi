<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PropertyProductRequest extends FormRequest
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
        if (request()->routeIs('admin.property-product.index')) {
            return [
                'product_id'   => ['required','integer'],
            ];
        }
        else if (request()->routeIs('admin.property-product.submit')) {
            return [
                'product_id'   => ['required', 'integer'],
                'property_product'   => ['nullable', 'array'],
                'property_product.*.id'   => ['required', 'integer'],
                'property_product.*.custom'   => ['nullable', 'string'],
            ];
        }
    }
}
