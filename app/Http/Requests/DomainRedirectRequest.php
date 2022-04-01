<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DomainRedirectRequest extends FormRequest
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
            'domain' => [
                'bail',
                'required',
                Rule::exists('domains', 'id')->whereIn('id', $this->install->domains->pluck('id'))
            ],
            'dest' => [
                'bail',
                'sometimes', 
                Rule::exists('domains', 'id')->whereIn('id', $this->install->domains->pluck('id')),
                'different:domain'
            ]
        ];
    }
}
