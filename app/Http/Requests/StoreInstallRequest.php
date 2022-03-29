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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'type' => 'required|in:stg,dev,prd',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $envs = array_unique($this->install->site->installs->pluck('type')->toArray());
            if (in_array($this->input('type'), $envs)) {
                $validator->errors()->add('type', 'This environment already exists.');
            }
        });
    }
}
