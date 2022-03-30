<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sitename' => 'required_if:isValidation,null|min:1|max:40',
            'installname' => ['required', 'min:3', 'unique:installs,name', function ($attribute, $value, $fail) {
                $rules = ['name' => 'url'];
                $input = ['name' => "https://{$attribute}.steercampaign.com"];
                if (! Validator::make($input, $rules)->passes()) {
                    $fail(__('Invalid Install Name'));
                }
            }],
            'type' => 'required_if:isValidation,null|in:dev,stg,prd',
            'owner' => 'required_if:isValidation,null|in:mine,transferable',
            'subscription_id' => 'sometimes|required_if:type,mine|exists:subscriptions,id',
            'start' => 'required_if:isValidation,null|in:blank,copyEnv,moveEnv',
            'install_id' => 'sometimes|exists:installs,id',
            'isValidation' => 'sometimes|boolean',
        ];
    }
}
