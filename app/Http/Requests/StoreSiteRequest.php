<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StoreSiteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->account->availableQuota > 0 || $this->account->availableSubscriptions > 0;
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
            'subscription_id' => ['sometimes', 'required_if:type,mine',
                Rule::exists('subscriptions', 'id')->whereIn('id', $this->account->subscriptions->pluck('id')),
            ],
            'start' => 'required_if:isValidation,null|in:blank,copyEnv,moveEnv',
            'install_id' => ['sometimes',
                Rule::exists('installs', 'id')->whereIn('id', $this->account->installs->pluck('id')),
            ],
            'isValidation' => 'sometimes|boolean',
        ];
    }
}
