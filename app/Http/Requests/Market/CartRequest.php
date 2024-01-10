<?php

namespace App\Http\Requests\Market;

use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
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
        if (request()->routeIs('market.cart.create')) {
            return [
                'product_id'           => ["required", 'integer'],
                'product_attribute_id' => ["required", 'integer'],
                'number'               => ["required", 'integer' ,"min:1"],
            ];
        } else if (request()->routeIs('market.cart.submit')) {
            return [
                'cart'           => ["required", 'array'],
                'cart.*.id'        =>["required", 'integer'],
                'cart.*.count'    => ["required", 'integer' , "min:1"]
            ];
        }
        else if(request()->routeIs('market.cart.delete')){
            return [
                'id'           => ["required", 'integer'],
            ];
        }
    }
}
