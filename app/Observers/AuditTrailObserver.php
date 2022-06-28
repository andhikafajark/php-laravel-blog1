<?php

namespace App\Observers;

use App\Helpers\LogHelper;
use App\Models\AuditTrail;
use Illuminate\Support\Str;

class AuditTrailObserver
{
    /**
     * Listen to the AuditTrail "creating" event.
     *
     * @param AuditTrail $auditTrail
     * @return void
     */
    public function creating(AuditTrail $auditTrail): void
    {
        $auditTrail->id = Str::uuid()->toString();
    }

    /**
     * Handle the AuditTrail "created" event.
     *
     * @param AuditTrail $auditTrail
     * @return void
     */
    public function created(AuditTrail $auditTrail): void
    {
        LogHelper::$auditTrailId = $auditTrail->id;
    }
}
