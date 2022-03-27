<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Lab404\Impersonate\Models\Impersonate;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable, Impersonate, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'password',
        'job_title',
        'employer',
        'experince',
        'company_name',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
        'role',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array <string,string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The Accounts that belong to the User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function accounts(): BelongsToMany
    {
        return $this->belongsToMany(Account::class)->using(AccountUser::class)->withPivot('role');
    }

    /**
     * Get User Full Name.
     *
     * @return  \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function fullName(): Attribute
    {
        return new Attribute(
            get: fn () => ucfirst("{$this->first_name} {$this->last_name}"),
        );
    }

    /**
     * Check if the user has one of the roles.
     *
     * @return  bool
     */
    public function belongToRoles(Account $account, array $roles): bool
    {
        return in_array(
            $this->accounts()->get()->where('id', $account->id)->first()->pivot->role,  /* @phpstan-ignore-line */
            $roles
        );
    }

    /**
     * Return the role of the user.
     *
     * @return  string
     */
    public function role(Account $account)
    {
        /* @phpstan-ignore-next-line */
        return $account->users()->where('users.id', $this->id)->first()->pivot->role;
    }

    /**
     * @return bool
     */
    public function canImpersonate()
    {
        /* @phpstan-ignore-next-line */
        return $this->accounts()->first()->pivot->role === 'admin';
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
            ->setDescriptionForEvent(fn (string $eventName) =>  __('User :Action', ['action' => $eventName]));
    }
}
