<?php

namespace App\Resolvers;

use Closure;
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Database\Eloquent\Model;

class AccountResolver
{
    protected AuthManager $authManager;

    protected string $authDriver;

    protected Model | null $accountOverride = null;

    protected Closure | null $resolverOverride = null;

    public function __construct(Repository $config, AuthManager $authManager)
    {
        $this->authManager = $authManager;

        $this->authDriver = $config['activitylog']['default_auth_driver'] ?? $this->authManager->getDefaultDriver();
    }

    public function setAccount(?Model $account): static
    {
        $this->accountOverride = $account;

        return $this;
    }

    public function resolve(Model | int | string | null $subject = null): ?Model
    {
        if ($this->accountOverride !== null) {
            return $this->accountOverride;
        }

        if ($this->resolverOverride !== null) {
            return ($this->resolverOverride)($subject);
        }

        return $this->getAccount($subject);
    }

    protected function getDefaultAccount(): ?Model
    {
        return $this->authManager->guard($this->authDriver)->check() ? $this->authManager->guard($this->authDriver)->user()->accounts()->first() : null;
    }

    protected function getAccount(Model | int | string | null $subject = null): ?Model
    {
        if (is_null($subject)) {
            return $this->getDefaultAccount();
        }

        return $subject;
    }
}
