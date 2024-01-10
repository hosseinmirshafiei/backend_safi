<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class GalleryRequest extends FormRequest
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
       if (request()->routeIs('admin.gallery.index')) {
            return [
                'product_id' => ['required', 'integer'],
            ];
       }
       else if (request()->routeIs('admin.gallery.upload-image')) {
            return [
                'image' => ['required', 'image', "mimes:jpeg,png,jpg"],
                'product_id'=>['required', 'integer'],
            ];
        }
        else if (request()->routeIs('admin.gallery.create')) {
            return [
                'images' => ['array'],
                'product_id' => ['required', 'integer'],
            ];
        }
    }
}
