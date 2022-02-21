<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DataCenter extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'label',
        'region',
    ];

    /**
     * Get all of the Accounts for the Data Center.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Accounts(): HasMany
    {
        return $this->hasMany(Account::class);
    }
}
