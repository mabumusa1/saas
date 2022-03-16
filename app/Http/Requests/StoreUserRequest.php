<?php

namespace App\Http\Requests;

use App\Models\Invite;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255'],
            'role'  => 'required',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (Invite::where('email', $this->input('email'))->where('account_id', $this->account->id)->exists()) {
                $validator->errors()->add('email', __('There exists an invite with this email!'));
            }
            if (User::where('email', $this->input('email'))->whereHas('accounts', fn ($query) => $query->where('accounts.id', $this->account->id))->exists()) {
                $validator->errors()->add('email', __('There exists a user with this email!'));
            }
        });
    }

    public function messages()
    {
        return [
            'role.required' => 'The account access field is required.',
        ];
    }
}
