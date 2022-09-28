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
                $rules = ['installname' => 'url'];
                $input = ['installname' => "https://{$value}.".env('CNAME_DOMAIN')];
                if (! Validator::make($input, $rules)->passes()) {
                    $fail(__('Invalid Install Name'));
                }
            },
            ],
            'type' => 'required_if:isValidation,null|in:dev,prd',
            'owner' => 'required_if:isValidation,null|in:mine,transferable',
            'subscription_id' => ['required_if:owner,mine',
                Rule::exists('subscriptions', 'id')->whereIn('id', $this->account->subscriptions->pluck('id')),
            ],
            'start' => 'required_if:isValidation,null|in:blank,copyEnv,moveEnv',
            'install_id' => ['sometimes',
                Rule::exists('installs', 'id')->whereIn('id', $this->account->installs->pluck('id')),
            ],
            'isValidation' => 'sometimes|boolean',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->has('type')) {
                switch ($this->input('type')) {
                    case 'prd':
                        if ($this->account->activeSubscriptions === 0) {
                            $validator->errors()->add('type', __('Please add a new subsription.'));
                        }
                        break;
                    case 'dev':
                        if ($this->account->availableQuota === 0) {
                            $validator->errors()->add('type', __('You have already consumed free quota. Please subscribe.'));
                        }
                        break;
                }
            }

            if ($this->has('owner')) {
                if ($this->input('owner') === 'transfezrable' && $this->input('type') === 'prd') {
                    $validator->errors()->add('type', __('Only Dev installation types are allowed with transferable sites.'));
                }
            }
        });
    }
}
