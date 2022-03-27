<?php

namespace App\Classes;

use App\Resolvers\AccountResolver;
use Illuminate\Contracts\Config\Repository;
use Spatie\Activitylog\ActivityLogger as SpatieActivityLogger;
use Spatie\Activitylog\ActivitylogServiceProvider;
use Spatie\Activitylog\ActivityLogStatus;
use Spatie\Activitylog\CauserResolver;
use Spatie\Activitylog\Contracts\Activity as ActivityContract;
use Spatie\Activitylog\LogBatch;

class ActivityLogger extends SpatieActivityLogger
{
    protected AccountResolver $accountResolver;

    public function __construct(Repository $config, ActivityLogStatus $logStatus, LogBatch $batch, CauserResolver $causerResolver, AccountResolver $accountResolver)
    {
        $this->causerResolver = $causerResolver;

        $this->accountResolver = $accountResolver;

        $this->batch = $batch;

        $this->defaultLogName = $config['activitylog']['default_log_name'];

        $this->logStatus = $logStatus;
    }

    protected function getActivity(): ActivityContract
    {
        if (! $this->activity instanceof ActivityContract) {
            $this->activity = ActivitylogServiceProvider::getActivityModelInstance();
            $this
                ->useLog($this->defaultLogName)
                ->withProperties([])
                ->onAccount($this->accountResolver->resolve())
                ->causedBy($this->causerResolver->resolve());

            /* @phpstan-ignore-next-line */
            $this->activity->batch_uuid = $this->batch->getUuid();
        }

        return $this->activity;
    }
}
