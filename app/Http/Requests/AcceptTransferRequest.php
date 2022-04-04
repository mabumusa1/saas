<?php

namespace App\Http\Requests;

use App\Models\Transfer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AcceptTransferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('accept', Transfer::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'transfer_way' => 'required|in:existing,new',
            'site_name' => 'required_if:transfer_way,new',
            'site_id' => ['required_if:transfer_way,existing',
                Rule::exists('sites', 'id')->whereIn('id', $this->account->sites->pluck('id')),
            ],
        ];
    }

    public function messages()
    {
        return [
            'site_name.required_if' => 'Site name is required',
        ];
    }
}
