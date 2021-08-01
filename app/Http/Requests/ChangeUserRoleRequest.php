<?php

namespace App\Http\Requests;

class ChangeUserRoleRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(! $this->user()->hasRole('Admin')){
            return false;
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required | integer | exists:users,id',
            'role' => 'required | string | exists:roles,name'
        ];
    }
}
