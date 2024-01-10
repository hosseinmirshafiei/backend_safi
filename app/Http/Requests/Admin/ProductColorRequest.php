<?php

namespace App\Http\Requests\Admin;

use App\Rules\NumberValidation;
use Illuminate\Foundation\Http\FormRequest;

class ProductColorRequest extends FormRequest
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
        if (request()->routeIs('admin.productColor.index')) {
            return [
                'product_id' => ['required','integer'],
            ];
        }
        else if (request()->routeIs('admin.productColor.update')) {
            return [
                'product_id' => ['required', 'integer'],
                'number' => ['sometimes', new NumberValidation],
                'colors' => ['sometimes', 'array', 'min:1'],
                'colors.*.color_id' => ["required_without:colors.*.size_id" , 'integer' , 'nullable'],
                'colors.*.size_id' => ["required_without:colors.*.color_id", 'integer', 'nullable'],
                'colors.*.price_increase' => [new NumberValidation , 'nullable'],
                'colors.*.number' => [new NumberValidation],
            ];
        }
    }
}
