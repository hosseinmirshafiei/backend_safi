<?php

namespace App\Http\Requests\Admin;

use App\Rules\NumberValidation;
use Illuminate\Foundation\Http\FormRequest;

class DeliveryRequest extends FormRequest
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
        if (request()->routeIs('admin.delivery.create')) {
            return [
                'sefareshiBase'   => ['required', new NumberValidation],
                'pishtazBase'     => ['required', new NumberValidation],
                'sefareshiWeight' => ['required', new NumberValidation],
                'pishtazWeight'   => ['required', new NumberValidation],
            ];
        } 
    }
}
