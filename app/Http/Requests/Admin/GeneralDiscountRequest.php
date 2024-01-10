<?php

namespace App\Http\Requests\Admin;

use App\Rules\PercentValidation;
use App\Rules\NumberValidation;
use Illuminate\Foundation\Http\FormRequest;

class GeneralDiscountRequest extends FormRequest
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
        if (request()->routeIs('admin.general-discount.create')) {
            return [
                'name_discount'        => ['nullable','regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.؟!"،()}{»«:_*%#@+ـ?,><\/;؛\n\r& ]+$/u'],
                'percent_discount'     => ['required', new NumberValidation , new PercentValidation],
                'maximum_discount'     => ['nullable', new NumberValidation],
                'start_discount'       => ['required','integer'],
                'finish_discount'      => ['required', 'integer'],
            ];
        }
    }
}
