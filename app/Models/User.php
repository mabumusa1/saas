<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Lab404\Impersonate\Models\Impersonate;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use Impersonate;

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
     * The Accounts that belong to the User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function Accounts(): BelongsToMany
    {
        return $this->belongsToMany(Account::class)->withTimestamps()->withPivot('role');
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
        return $account->users()->where('users.id', $this->id)->first()->pivot->role;
    }

    /**
     * @return bool
     */
    public function canImpersonate()
    {
        // For example
        return $this->accounts()->first()->pivot->role === 'admin';
    }
}
