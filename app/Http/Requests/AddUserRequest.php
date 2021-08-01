<?php

namespace App\Http\Requests;

class AddUserRequest extends BaseRequest
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
            'name' => 'required | string | max:255',
            'email' => 'required | string | email | unique:users',
            'password' => 'required | string | min:8',
            'role' => 'required | string | exists:roles,name',
        ];
    }
}
