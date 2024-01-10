<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SizeRequest extends FormRequest
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
        if (request()->routeIs('admin.size.create')) {
            return [
                'size' => ['required', 'string'],
                'type' => ['required', 'integer'],
            ];
        }
         else if (request()->routeIs('admin.size.update')) {
            return [
                'id' =>   ['required', 'integer'],
                'size' => ['required','string'],
                'type' => ['required','integer'],
            ];
        } else if (request()->routeIs('admin.size.updateTypeSize')) {
            return [
                'id' =>   ['required', 'integer'],
                'size' => ['required' ,'string'],
            ];
        } else if (request()->routeIs('admin.size.createTypeSize')) {
            return [
                'size' => ['required', 'string'],
            ];
        }
    }
}
