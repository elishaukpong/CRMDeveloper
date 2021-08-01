<?php

namespace App\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{

    protected $exceptionMessage = 'This action is unauthorized.';
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

    /**
     * Handle a failed authorization attempt.
     *
     * @return void
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    protected function failedAuthorization()
    {
        throw new AuthorizationException($this->exceptionMessage);
    }
}
