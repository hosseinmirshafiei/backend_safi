<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SlideRequest extends FormRequest
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
        if (request()->routeIs('admin.slide.index')) {
            return [
                'group' => ['required', 'integer'],
            ];
        } else if (request()->routeIs('admin.slide.upload-image')) {
            return [
                'image' => ['required', 'image', "mimes:jpeg,png,jpg"],
            ];
        } else if (request()->routeIs('admin.slide.create')) {
            return [
                'slides' => ['array'],
                'group' => ['required', 'integer'],
            ];
        }
    }
}
