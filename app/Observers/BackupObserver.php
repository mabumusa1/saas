<?php

namespace App\Observers;

use App\Models\Backup;

class BackupObserver
{
    public function created(Backup $backup)
    {
    }

    public function restored(Backup $backup)
    {
    }
}
