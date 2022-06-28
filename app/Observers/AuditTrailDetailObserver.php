<?php

namespace App\Observers;

use App\Models\AuditTrailDetail;
use Illuminate\Support\Str;

class AuditTrailDetailObserver
{
    /**
     * Listen to the AuditTrailDetail "creating" event.
     *
     * @param AuditTrailDetail $auditTrailDetail
     * @return void
     */
    public function creating(AuditTrailDetail $auditTrailDetail): void
    {
        $auditTrailDetail->id = Str::uuid()->toString();
    }
}
