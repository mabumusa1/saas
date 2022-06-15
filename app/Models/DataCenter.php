<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\DataCenter.
 *
 * @property int $id
 * @property string $label
 * @property string $region
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|array<\App\Models\Account> $accounts
 * @property-read int|null $accounts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|array<\App\Models\Activity> $activities
 * @property-read int|null $activities_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|DataCenter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DataCenter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DataCenter query()
 * @method static \Illuminate\Database\Eloquent\Builder|DataCenter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataCenter whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataCenter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataCenter whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataCenter whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataCenter whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
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
            ->setDescriptionForEvent(fn (string $eventName) => __('Data Center :Action', ['action' => $eventName]));
    }
}
