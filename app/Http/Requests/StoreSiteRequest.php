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
            'owner' => 'required|in:mine,transferable',
            'planId' => 'required_if:owner,mine|exists:plans,id',
            'period' => 'required_if:owner,mine|in:year,month',
            'start' => 'required|in:blank,copyEnv,moveEnv',
            'sitename' => 'required|min:1|max:40',
            'installname' => ['required', 'min:3', 'unique:installs,name', function ($attribute, $value, $fail) {
                $rules = ['installname' => 'url'];
                $input = ['installname' => "https://{$value}.".env('CNAME_DOMAIN')];
                if (! Validator::make($input, $rules)->passes()) {
                    $fail(__('Invalid Install Name'));
                }
            },
            ],
            'type' => 'required|in:dev,prd',
            'install_id' => ['sometimes',
                Rule::exists('installs', 'id')->whereIn('id', $this->account->installs->pluck('id')),
            ],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->has('type')) {
                if ($this->input('type') === 'dev') {
                    if ($this->account->availableQuota === 0) {
                        $validator->errors()->add('type', __('You have already consumed free quota. Please subscribe.'));
                    }
                }
            }

            if ($this->has('owner')) {
                if ($this->input('owner') === 'transferable' && $this->input('type') === 'prd') {
                    $validator->errors()->add('type', __('Only Dev installation types are allowed with transferable sites.'));
                }
            }
        });
    }
}
