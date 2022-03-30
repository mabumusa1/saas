<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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

    public function prepareForValidation()
    {
        $this->merge([
            'installname' => "https://{$this->name}.steercampaign.com",
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'installname' => 'required|url|min:3|unique:installs,name',
            'type' => 'required_if:isValidation,null|in:stg,dev,prd',
            'isValidation' => 'sometimes|boolean',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->site->hasInstallType($this->input('type'))) {
                $validator->errors()->add('type', __('This install type already exists.'));
            }
        });
    }
}
