<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class DataCenter extends Model
{
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = ['label', 'region'];

    /**
     * Get all of the Accounts for the Data Center.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class);
    }

    /**
     * The the logs of this model.
     *
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('system')
            ->setDescriptionForEvent(fn (string $eventName) =>  __('Data Center :Action', ['action' => $eventName]));
    }
}
