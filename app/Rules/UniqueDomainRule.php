<?php

namespace App\Rules;

use App\Models\Account;
use App\Models\Domain;
use App\Models\Install;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\Dns\Dns;

class UniqueDomainRule implements Rule
{
    private $installs;

    private $install;

    private $message;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Account $account, Install $install)
    {
        $this->installs = $account->installs->pluck('id');
        $this->install = $install;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            $domain = Domain::where('name', $value)->firstOrFail();
            if ($this->installs->contains($domain->install_id)) {
                // This user has the domain
                $install = Install::find($domain->install_id);
                $this->message = __('Domain name is already configured as a domain on the install :name. Please choose a unique name.', ['name' => $install->name]);

                return false;
            } else {
                $dns = new Dns();
                $records = $dns->useNameserver('8.8.8.8')->getRecords($value, 'TXT');
                foreach ($records as $record) {
                    // the user managed to verify the domain, they own it
                    if ($record->txt() === "sc-verification={$this->install->name}") {
                        //delete the existing domain, to add the new one
                        $domain->delete();

                        return true;
                    } else {
                        //someone else has the domain, we check DNS TXT records
                        $this->message = __('Domain name has already been taken');

                        return false;
                    }
                }
            }
        } catch (ModelNotFoundException $e) {
            return true;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
