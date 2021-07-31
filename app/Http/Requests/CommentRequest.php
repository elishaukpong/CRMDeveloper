<?php

namespace App\Http\Requests;

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
        if($this->user()->hasRole('Admin') || $this->user()->hasRole('Viewer')){
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'post_id' => 'required | integer | exists:posts,id',
            'user_id' => 'required | integer | exists:users,id',
            'message' => 'required  | string'
        ];
    }
}
