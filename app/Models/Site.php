<?php

namespace App\Models;

use App\Models\Environment;
use App\Models\Group;
use App\Scopes\SiteScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Jetstream\Jetstream;

class Site extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'team_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['deleted_at', 'created_at', 'updated_at'];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['environments', 'groups'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['storage', 'bandwidth', 'visits'];

    /**
     * Get the team that the invitation belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo(Jetstream::teamModel());
    }

    /**
     * The Groups that belong to the Site.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class);
    }

    /**
     * Get all of the Environments for the Site.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function environments(): HasMany
    {
        return $this->hasMany(Environment::class);
    }

    /**
     * Get total Bandwidth.
     *
     * @param  string  $value
     * @return string
     */
    public function getBandwidthAttribute($value)
    {
        $bandwidth = 0;
        foreach ($this->environments as $environment) {
            $bandwidth += $environment->bandwidth;
        }

        return $bandwidth;
    }

    /**
     * Get total Storage.
     *
     * @param  string  $value
     * @return string
     */
    public function getStorageAttribute($value)
    {
        $storage = 0;
        foreach ($this->environments as $environment) {
            $storage += $environment->storage;
        }

        return $storage;
    }

    /**
     * Get total Visits.
     *
     * @param  string  $value
     * @return string
     */
    public function getVisitsAttribute($value)
    {
        $visit = 0;
        foreach ($this->environments as $environment) {
            $visit += $environment->visits;
        }

        return $visit;
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new SiteScope);
    }
}
