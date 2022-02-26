<?php

namespace App\Http\Requests;

use App\Models\Account;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class makePayLinkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::check()) {
            try {
                $account = Account::findOrFail($this->input('account'));
                $allowedRoles = ['owner', 'fb', 'pb'];

                return $this->user()->belongToRoles($account, $allowedRoles);
            } catch (\Throwable $th) {
                return false;
            }
        } else {
            return true;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'account' => 'sometimes|exists:App\Models\Plan,id',
            'plan' => 'bail|required|exists:App\Models\Plan,id',
            'options' => 'array|required',
            'options.annual' => 'boolean',
            'options.quantity' => 'integer|between:1,100',
        ];
    }
}
