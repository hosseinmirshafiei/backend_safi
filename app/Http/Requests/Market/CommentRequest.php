<?php

namespace App\Http\Requests\Market;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
        if (request()->routeIs('market.comment.create')) {
            return [
                'product_id'           => ["required", 'integer'],
                'comment_id'           => ["nullable", 'integer'],
                'comment'               => ["required", 'string'],
            ];
        }else if(request()->routeIs('market.comment.loadMore')){
            return[
               'product_id'  => ["required", 'integer'],
               'last_id'  =>    ["required", 'integer'],
            ];
        }
    }
}
