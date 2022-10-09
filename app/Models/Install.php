<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
 * @property string $size
 * @property string $domain
 * @property string $region
 * @property string|null $transfer_key
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|array<\App\Models\Activity> $activities
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
 * @property bool $locked
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Backup[] $backups
 * @property-read int|null $backups_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Domain[] $domains
 * @property-read int|null $domains_count
 * @property-read \App\Models\Transfer|null $transfer
 * @method static \Illuminate\Database\Eloquent\Builder|Install whereLocked($value)
 */
class Install extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $observables = ['copied', 'locked'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'site_id',
        'name',
        'type',
        'locked',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'locked' => 'boolean',
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
     * Get the transfer associated with the Install.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function transfer(): HasOne
    {
        return $this->hasOne(Transfer::class);
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
            ->setDescriptionForEvent(fn (string $eventName) => __(':Name Install :Action', ['name' => $this->name, 'action' => $eventName]));
    }

    /**
     * Get all of the domain for the Install.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function domains(): HasMany
    {
        return $this->hasMany(Domain::class);
    }

    /**
     * Get all of the backups for the install.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function backups(): HasMany
    {
        return $this->hasMany(Backup::class);
    }

    /**
     * Get Install CNAME.
     *
     * @return  \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function cname(): Attribute
    {
        return new Attribute(
            get: fn () => "{$this->name}.".env('CNAME_DOMAIN'),
        );
    }

    /**
     * Get Install IP.
     *
     * @return  \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function ip(): Attribute
    {
        return new Attribute(
            get: fn () => '127.0.0.1',
        );
    }

    /**
     * Get Primary Domain.
     *
     * @return  \App\Models\Domain
     */
    public function primaryDomain(): Domain
    {
        return $this->domains->where('primary', true)->first();
    }

    /**
     * Get subscription size assoicated
     * with this install.
     *
     * @return  \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function size(): Attribute
    {
        return new Attribute(
            get: function () {
                dd($this->site->subscription);
                if ($this->site->subscription()->exists()) {
                    return $this->site->subscription->name;
                }

                return 's0';
            },
        );
    }

    /**
     * Get install region.
     *
     * @return  \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function region(): Attribute
    {
        return new Attribute(
            get: function () {
                return $this->site->account->dataCenter->region;
            },
        );
    }

    public function lock()
    {
        $this->update(['locked' => true, 'owner' => 'transferable']);
        $this->fireModelEvent('locked');
    }

    public function copy()
    {
        $this->fireModelEvent('copied');
    }
}
