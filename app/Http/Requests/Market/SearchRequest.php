<?php

namespace App\Http\Requests\Market;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
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
        if (request()->routeIs('market.search.products')) {
            return [
                'search' => ["required", 'regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.؟!"،()}{»«:_*%#@+ـ?,><\/;؛\n\r& ]+$/u'],
            ];
        } 
    }
}
