<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Domain.
 *
 * @property int $id
 * @property int $install_id
 * @property string $name
 * @property string|null $redirect_to
 * @property bool $primary
 * @property int|null $verified_at
 * @property bool $verification_failed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\Install $install
 * @method static \Database\Factories\DomainFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Domain newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Domain query()
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereInstallId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain wherePrimary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereRedirectTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereVerificationFailed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereVerifiedAt($value)
 * @mixin \Eloquent
 */
class Domain extends Model
{
    use HasFactory, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'install_id',
        'name',
        'primary',
        'verified_at',
        'verification_failed',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'primary' => 'boolean',
        'verified_at' => 'timestamp',
        'verification_failed' => 'boolean',
    ];

    /**
     * Get the install that owns the Domain.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function install(): BelongsTo
    {
        return $this->belongsTo(Install::class);
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
            ->setDescriptionForEvent(fn (string $eventName) => __(':domain :action to :install', ['domain' => $this->name, 'action' => $eventName, 'install' => $this->install->name]));
    }

    /**
     * Check if this domain is the built-in domain.
     *
     * @return  \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function isBuiltIn(): Attribute
    {
        return new Attribute(
            /* @phpstan-ignore-next-line */
            get: fn () => ($this->name === $this->install->cname),
        );
    }

    public function redirect()
    {
        $this->fireModelEvent('redirected');
    }

    public function makePrimary()
    {
        $this->fireModelEvent('makePrimary');
    }
}
