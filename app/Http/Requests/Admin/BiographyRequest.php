<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BiographyRequest extends FormRequest
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
         if (request()->routeIs('admin.biography.update')) {
            return [
                'title' => ['nullable', 'max:250', 'string'],
                'description' => ['nullable', 'string'],
            ];
        }
    }
}
