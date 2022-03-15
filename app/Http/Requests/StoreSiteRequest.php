<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSiteRequest extends FormRequest
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
            'environmentname' => "https://{$this->environmentname}.steercampaign.com",
        ]);
    }

    /* public function withValidator($validator){
        $validator->after(function ($validator) {
            if($validator->errors()->any() && $this->has('isValidation')){

            }
        });
    } */
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sitename' => 'required|min:1|max:40',
            'environmentname' => 'required|url|min:3|unique:installs,name',
            'type' => 'required|in:mine,transferable',
            'isValidation' => 'sometimes|boolean',
        ];
    }
}
