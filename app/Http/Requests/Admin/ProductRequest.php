<?php

namespace App\Http\Requests\Admin;

use App\Rules\NumberValidation;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        if (request()->routeIs('admin.product.index')) {
            return [
                'page'   => ['integer'],
                'last_id'=> ['integer'],
                'name' => ['nullable', 'max:250', 'string'],
            ];
        }
         else if (request()->routeIs('admin.product.store')) {
            return [
                'name' => ['required', 'max:250', 'string'],
                'entesharat' => ['nullable', 'max:300', 'string'],
                'category_id' => ['required', 'integer'],
                'brand_id' => ['nullable','integer'],
                'image' => ['string' , 'nullable'],
                'number' => ['sometimes', new NumberValidation],
                'price' => ['required', new NumberValidation],
                'weight' => ['required', new NumberValidation],
                'description' => ['string' , 'nullable'],
                'colors' => ['sometimes','array'],
                'colors.*.color_id' => ['nullable','integer'],
                'colors.*.price_increase' => ["required_without:colors.*.size_id",new NumberValidation, 'nullable'],
                'colors.*.size_id' => ["required_without:colors.*.color_id", 'integer', 'nullable'],
                'colors.*.number' => ['sometimes' , new NumberValidation],
                
            ];
        }
         else if (request()->routeIs('admin.product.delete')) {
            return [
                'id' => ['required', 'integer'],
            ];
        }
        else if (request()->routeIs('admin.product.edit')) {
            return [
                'id' => ['required', 'integer'],
            ];
         } 
         else if (request()->routeIs('admin.product.update')) {

            return [
                'id' => ['required', 'integer'],
                'name' => ['required', 'max:250', 'string'],
                'entesharat' => ['nullable', 'max:300', 'string'],
                'category_id' => ['required', 'integer'],
                'brand_id' => ['nullable','integer'],
                'image' => ['string' , 'nullable'],
                'weight' => ['required', new NumberValidation],
                'price' => ['required', new NumberValidation],
                'description' => ['string' , 'nullable'],
            ];
        }
        else if (request()->routeIs('admin.product.ckeditor')) {
            return [
                'upload' => ['required','image',"mimes:jpeg,png,jpg,gif,svg,webp" ,"max:2048"],
            ];
        } 
        else if (request()->routeIs('admin.product.uploadimage')) {
            return [
                'image' => ['required', 'image', "mimes:jpeg,png,jpg,webp"],
            ];
        } 
    }
}
