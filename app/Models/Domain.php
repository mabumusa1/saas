<?php

namespace App\Models;

use App\Models\Install;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

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
                    ->setDescriptionForEvent(fn (string $eventName) =>  __(':domain :action to :install', ['domain' => $this->name, 'action' => $eventName, 'install' => $this->install->name]));
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
}
