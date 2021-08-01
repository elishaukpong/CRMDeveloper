<?php

namespace App\Http\Requests;

class PostRequest extends BaseRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if($this->user()->can('create articles')){
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
            'title' => 'required | string',
            'content' => 'required | string',
            'user_id' => 'required | integer | exists:users,id'
        ];
    }

}
