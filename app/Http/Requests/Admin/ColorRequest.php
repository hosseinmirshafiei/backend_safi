<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ColorRequest extends FormRequest
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
        if (request()->routeIs('admin.colors.index')) {
            return [
                'page'   => ['integer'],
                'last_id' => ['integer'],
                'name' => ['nullable', 'max:250', 'string'],
            ];
        }
        else if (request()->routeIs('admin.colors.create')) {
            return [
                'name' => ['required', 'max:250', 'string'],
                'color' => ['required', 'max:250', 'string'],
            ];
        } else if (request()->routeIs('admin.colors.delete')) {
            return [
                'id' => ['required', 'integer'],
            ];
        } else if (request()->routeIs('admin.colors.edit')) {
            return [
                'id' => ['required', 'integer'],
            ];
        } else if (request()->routeIs('admin.colors.update')) {
            return [
                'id' => ['required', 'integer'],
                'name' => ['max:250', 'string'],
                'color' => ['max:250', 'string'],
            ];
        }
        
    }
}
