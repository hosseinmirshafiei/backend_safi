<?php

namespace App\Http\Requests\Admin;

use App\Rules\NumberValidation;
use App\Rules\PercentValidation;
use Illuminate\Foundation\Http\FormRequest;

class ProductDiscountRequest extends FormRequest
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
        if (request()->routeIs('admin.product-discount.index')) {
            return [
                'page' => ['integer'],
                'last_id' => ['integer'],
            ];
        }
        else if (request()->routeIs('admin.product-discount.show')) {
            return [
                'product_id'     => ['required', "integer"],
            ];
        }
        else if (request()->routeIs('admin.product-discount.create')) {
            return [
                'product_id'           => ['required', 'integer'],
                'percent_discount'     => ['required', new NumberValidation, new PercentValidation],
                'maximum_discount'     => ['nullable', new NumberValidation],
                'start_discount'       => ['required', 'integer'],
                'finish_discount'      => ['required', 'integer'],
            ];
        }
        else if (request()->routeIs('admin.product-discount.status')) {
            return [
                'product_id'     => ['required', "integer"],
            ];
        }

    }
}
