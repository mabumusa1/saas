<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


class DataCenter extends Model
{
    use LogsActivity;
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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->useLogName('system');
    }        
}
