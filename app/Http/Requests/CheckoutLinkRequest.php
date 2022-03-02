<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
use App\Models\Account;

class CheckoutLinkRequest extends FormRequest
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
                $allowedRoles = ['owner', 'fb', 'pb'];
                $account = Account::find($this->account);
                return $this->user()->belongToRoles($account, $allowedRoles);
            } catch (\Throwable $th) {
                return false;
            }
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
            'account' => 'sometimes|exists:App\Models\Plan,id',
            'plan' => 'bail|required|exists:App\Models\Plan,id',
            'options' => 'array|required',
            'options.annual' => 'boolean',
            'options.quantity' => 'integer|between:1,100',
        ];
    }
}
