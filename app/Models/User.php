<?php

namespace App\Models;

use App\Models\AccountUser;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use TwoFactorAuthenticatable;

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
     * @var array
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
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<string>
     */
    protected $appends = [
    ];

    /**
     * The Accounts that belong to the User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function Accounts(): BelongsToMany
    {
        return $this->belongsToMany(Account::class)->using(AccountUser::class)->withTimestamps()->withPivot('role');
    }

    public function accountUser()
    {
        return $this->hasOne(AccountUser::class);
    }

    /**
     * Get User Full Name.
     *
     * @return  \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function fullName(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ucfirst("{$this->first_name} {$this->last_name}"),
        );
    }

    /**
     * Check if the user has a specific role.
     *
     * @return  \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function hasRole(Account $account, String $role): bool
    {
        return $this->accounts()->get()->where('id', $account->id)->first()->pivot->role === $role;
    }

    /**
     * Check if the user has many roles.
     *
     * @return  \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function belongToRoles(Account $account, array $roles): bool
    {
        return in_array(
            $this->accounts()->get()->where('id', $account->id)->first()->pivot->role,
            $roles
        );
    }
}
