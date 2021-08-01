<?php

namespace App\Http\Requests;

class CommentRequest extends BaseRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if($this->user()->can('comment on articles')){
            return true;
        }
        $this->exceptionMessage = "Only reader's can comment on post.";
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
