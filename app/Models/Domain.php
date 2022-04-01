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
        'verified',
        'verified_at',
        'attempts',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'primary' => 'boolean',
        'verified' => 'boolean',
        'verified_at' => 'timestamp',
        'attempts' => 'integer',
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
                    ->setDescriptionForEvent(fn (string $eventName) =>  __(':email :Action as technical contact for :install', ['email' => $this->email, 'action' => $eventName, 'install' => $this->install->name]));
    }

    /**
     * Check if this domain is the built-in domain.
     *
     * @return  \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function isBuiltIn(): Attribute
    {
        return new Attribute(
            get: fn () => ($this->name === $this->install->cname),
        );
    }

    /**
     * Check if we tried to verifiy the domain but failed.
     *
     * @return  \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function isFailedVerification(): Attribute
    {
        return new Attribute(
            get: fn () => ($this->verification_attempts >= 5),
        );
    }
}
