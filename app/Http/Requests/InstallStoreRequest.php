<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstallStoreRequest extends FormRequest
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
            'site_id' => ['required', 'integer', 'exists:sites,id'],
            'name' => ['required', 'string', 'unique:installs,name'],
            'type' => ['required', 'in:dev,stg,prd'],
            'tech_contact_first_name' => ['required', 'string'],
            'tech_contact_last_name' => ['required', 'string'],
            'tech_contact_email' => ['required', 'string'],
            'tech_contact_phone' => ['required', 'string'],
        ];
    }
}
