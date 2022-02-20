<?php

namespace App\Casts;

use App\Models\AccountUser;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Arr;

class RoleCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function get($model, string $key, $value, array $attributes)
    {
        $label = '';
        switch ($attributes['role']) {
            case 'owner':
                $label = 'Owner';
                break;
            case 'fb':
                $label = 'Full (with Billing)';
                break;
            case 'fnb':
                $label = 'Full (without Billing)';
                break;
            case 'pb':
                $label = 'Partial (with Billing)';
                break;
            case 'pnb':
                $label = 'Partial (without Billing)';
                break;
        }

        return  $label;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function set($model, string $key, $value, array $attributes)
    {
        $roles = ['owner', 'fb', 'fnb', 'pb', 'pnb'];
        if (in_array($value, $roles)) {
            return [
                'role' => $value,
            ];
        } else {
            throw new \InvalidArgumentException('Invalid Role Provided.');
        }
    }
}
