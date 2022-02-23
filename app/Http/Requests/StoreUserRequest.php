<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'first_name'  => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users',
            'role'  => 'required',
        ];
    }

    public function messages()
    {
        return [
            'role.required' => 'The account access field is required.',
        ];
    }
}
