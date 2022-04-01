<?php

namespace App\Http\Requests;

use App\Rules\UniqueDomainRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class StoreDomainRequest extends FormRequest
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
            'name' => ['required', function ($attribute, $value, $fail) {
                $rules = ['name' => 'url'];
                $input = ['name' => "https://{$attribute}"];
                if (! Validator::make($input, $rules)->passes()) {
                    $fail(__('Invalid Domain Name'));
                }
            }, new UniqueDomainRule($this->account, $this->install)],
            'isValidation' => 'sometimes|boolean',

        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.unique' => __('Domain name is either used in another install or by someone else,
             you can verify your domain then add it, learn more on <a href=":url">this</a>', ['url' => 'https://steercampaign.com/']),
        ];
    }
}
