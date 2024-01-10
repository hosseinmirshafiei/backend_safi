<?php

namespace App\Http\Requests\Admin;

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
        if (request()->routeIs('admin.comment.index')) {
            return [
                'page' => ['integer'],
                'last_id' => ['integer'],
            ];
        }
        else if (request()->routeIs('admin.comment.status')) {
            return [
                'id' => ['required','integer'],
            ];
        } else if (request()->routeIs('admin.comment.show')) {
            return [
                'id' => ['required','integer'],
            ];
        } else if (request()->routeIs('admin.comment.create')) {
            return [
                'comment_id' => ['required', 'integer'],
                'body' => ['required'],
            ];
        } 
    }
}
