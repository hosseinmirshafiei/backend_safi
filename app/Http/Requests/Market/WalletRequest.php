<?php

namespace App\Http\Requests\Market;

use App\Rules\NumberValidation;
use Illuminate\Foundation\Http\FormRequest;

class WalletRequest extends FormRequest
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
        if (request()->routeIs('market.wallet.charge')) {
            return [
                'amount' => ['required' , new NumberValidation ],
            ];
        }
        else if (request()->routeIs('market.wallet.walletStateOrder')) {
            return [
                'order_id' => ['required', "integer"],
            ];
        } 
    }
}
