<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Install.
 *
 * @property int $id
 * @property int $site_id
 * @property string $name
 * @property string $type
 * @property string $owner
 * @property string $status
 * @property string|null $transfer_key
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\Contact|null $contact
 * @property-read \App\Models\Site $site
 * @method static \Database\Factories\InstallFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Install newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Install newQuery()
 * @method static \Illuminate\Database\Query\Builder|Install onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Install query()
 * @method static \Illuminate\Database\Eloquent\Builder|Install whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Install whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Install whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Install whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Install whereOwner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Install whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Install whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Install whereTransferKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Install whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Install whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Install withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Install withoutTrashed()
 * @mixin \Eloquent
 */
class Install extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'site_id',
        'account_id',
        'name',
        'type',
        'status',
    ];

    /**
     * Get the contact associated with the Install.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function contact(): HasOne
    {
        return $this->hasOne(Contact::class);
    }

    /**
     * Get the Site that owns the Install.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    /**
     * The the logs of this model.
     *
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->useLogName('account')
        ->setDescriptionForEvent(fn (string $eventName) =>  __('Install :Action', ['action' => $eventName]));
    }
}
