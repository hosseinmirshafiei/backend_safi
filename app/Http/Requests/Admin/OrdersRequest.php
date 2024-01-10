<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class OrdersRequest extends FormRequest
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
    public function rules(){
        if(request()->routeIs('admin.orders.index')) {
            return [
                'page'   => ['integer'],
                'last_id' => ['integer'],
                'mobile' => ['nullable', 'max:250', 'string'],
            ];
        } else if (request()->routeIs('admin.orders.checked')) {
            return [
                'order_id'   => ['required','integer'],
            ];
        } else if (request()->routeIs('admin.orders.ordersUser')) {
            return [
                'user_id'   => ['required', 'integer'],
            ];
        }
    }
}
