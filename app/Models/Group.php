<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Group extends Model
{
    use HasFactory, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = ['name', 'notes'];

    /**
     * Get all of the sites for the Group.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sites(): BelongsToMany
    {
        return $this->belongsToMany(Site::class);
    }

    /**
     * Check if the site belongs to this group.
     *
     * @return bool
     */
    public function hasSite($site): bool
    {
        return $this->Sites->contains($site);
    }

    /**
     * Get the Account that owns the Group.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
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
        ->setDescriptionForEvent(fn (string $eventName) =>  __('Group :Action', ['action' => $eventName]));
    }
}
