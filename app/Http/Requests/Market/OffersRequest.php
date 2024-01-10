<?php

namespace App\Http\Requests\Market;

use Illuminate\Foundation\Http\FormRequest;

class OffersRequest extends FormRequest
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
        if (request()->routeIs('market.offers-products.index')) {
            return [
                'page' => ["required", 'numeric'],
                'sort_type' => ["required", 'integer'],
                'products_id_list'=>['array' , 'nullable'],
                'products_id_list.*' => ['integer', 'nullable'],
            ];
        }
    }
}
