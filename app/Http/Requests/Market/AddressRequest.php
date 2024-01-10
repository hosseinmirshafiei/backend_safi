<?php

namespace App\Http\Requests\Market;

use App\Rules\NumberValidation;
use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
        if (request()->routeIs('market.address.create')) {
            return [
                'first_name' => ['required', 'max:50' , "string"],
                'last_name' => ['required', 'max:50' , "string"],
                'mobile' => ['required', 'min:11', 'max:11' , new NumberValidation],
                'phone' => ['required', 'max:30' , new NumberValidation],
                'postal_code' => ['required', 'max:10' , 'min:10', new NumberValidation],
                'address' => ['required', 'max:2000' , "string"],
                'province' => ['required', "integer", "min:1" , "max:31"],
                'city' => ['required', "integer"],

            ];
        } else if (request()->routeIs('market.address.update')) {

            return [
                'first_name' => ['required', 'max:50'],
                'last_name' => ['required', 'max:50'],
                'mobile' => ['required',  'min:11', 'max:11', new NumberValidation],
                'phone' => ['required',  'max:30', new NumberValidation],
                'postal_code' => ['required', 'max:10', 'min:10', new NumberValidation],
                'address' => ['required', 'max:2000'],
                'province' => ['required',"integer" , "min:1", "max:31"],
                'city' => ['required' ,"integer"],

            ];
        } else if (request()->routeIs('market.address.switch')) {

            return [
                'id' => ['required', 'integer'],
            ];
        }
    }
}
