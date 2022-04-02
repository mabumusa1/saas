<?php

namespace App\Http\Requests;

use App\Models\Transfer;
use Illuminate\Foundation\Http\FormRequest;

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
            'site.name' => 'required_if:transfer_way,new',
            'site.owner' => 'required_if:transfer_way,new',
            'site_id' => 'required_if:transfer_way,existing|exists:sites,id',
        ];
    }

    public function messages()
    {
        return [
            'site.name.required_if' => 'Site name is required',
        ];
    }
}
