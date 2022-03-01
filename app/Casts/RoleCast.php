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
        return $value;
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
        $roles = ['admin', 'owner', 'fb', 'fnb', 'pb', 'pnb'];
        if (in_array($value, $roles)) {
            return [
                'role' => $value,
            ];
        } else {
            throw new \Exception('Invalid Role Provided.');
        }
    }
}
