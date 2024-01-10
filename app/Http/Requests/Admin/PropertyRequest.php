<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PropertyRequest extends FormRequest
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
        if (request()->routeIs('admin.property.index')) {
            return [
                'category_id' => ['required', 'integer'],
            ];
        }
        else if (request()->routeIs('admin.property.create')) {
            return [
                'category_id' => ['required', 'integer'],
                'property_id' => ['sometimes', 'integer'],
                'properties' =>  ['required', 'array'],
                'properties.*.id' => ['required' , "integer"],
                'properties.*.name' => ['required', "string"],
            ];
        } else if (request()->routeIs('admin.property.delete')) {
            return [
                'id' => ['required', 'integer'],
            ];
        } else if (request()->routeIs('admin.property.update')) {
            return [
                'id'   => ['required', 'integer'],
                'name' => ['required', 'string'],
            ];
        } else if (request()->routeIs('admin.property.multiple')) {
            return [
                'id'   => ['required', 'integer'],
            ];
        }
        
        
    }
}
