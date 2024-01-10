<?php

namespace App\Http\Requests\Market;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        if (request()->routeIs('market.product.index')) {
            return [
                // 'slug'    => ["required", 'string'],
                'page' => ["required", 'numeric'],
                // 'sort_type' => ["required", 'integer'],
                // 'filters'=>['array'],
                // 'filters.*.id'=>["nullable","integer"],
                // 'filters.*.property_id' => ["nullable", "integer"],
                // 'available'=>["integer" , "between:0,1"],
                // 'brands_selected'=>["array"],
                // 'brands_selected.*' => ["integer"],
                // 'filters.*.id'=>["integer"],
                'products_id_list' =>['nullable','array'],
                'products_id_list.*' =>['nullable','integer']
            ];
        }
        else if (request()->routeIs('market.product.show')) {
            return [
                'slug' => ["required", 'string'],
            ];
        } 

    }
}
