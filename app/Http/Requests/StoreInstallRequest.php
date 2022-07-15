<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class StoreInstallRequest extends FormRequest
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
            'name' => ['required', 'min:3', 'unique:installs,name', function ($attribute, $value, $fail) {
                $rules = ['name' => 'url'];
                $input = ['name' => "https://{$value}.".env('CNAME_DOMAIN')];
                if (! Validator::make($input, $rules)->passes()) {
                    $fail(__('Invalid Install Name'));
                }
            },
            ],
            'type' => 'required_if:isValidation,null|in:stg,dev,prd',
            'isValidation' => 'sometimes|boolean',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->has('type')) {
                if ($this->site->hasInstallType($this->input('type'))) {
                    $validator->errors()->add('type', __('This install type already exists.'));
                }
            }
        });
    }
}
