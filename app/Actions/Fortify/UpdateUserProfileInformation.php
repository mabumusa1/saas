<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        Validator::make($input, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            'phone' => ['nullable', 'string', 'max:255'],
            'job_title' => ['nullable', Rule::in(['Developer', 'Marketer', 'Designer', 'Project Manager', 'Billing Manager', 'IT Professional', 'Executive', 'None of these'])],
            'employer' => ['nullable', Rule::in(['Myself, freelance', 'Myself, full-time', 'Agency', 'Business/In-house'])],
            'experince' => ['nullable', Rule::in(['I am a beginner', 'I have some experience', 'I feel comfortable with most Mautic-related tasks', 'I am an expert'])],
            'company_name' => ['nullable', 'string', 'max:255'],

        ])->validateWithBag('updateProfileInformation');

        $user->forceFill([
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'email' => $input['email'],
            'phone' => $input['phone'],
            'job_title' => $input['job_title'],
            'employer' => $input['employer'],
            'experince' => $input['experince'],
            'company_name' => $input['company_name'],
        ])->save();
    }
}
