<?php

namespace App\Helpers;

use App\Models\AuditTrail;
use App\Models\AuditTrailDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Jenssegers\Agent\Agent;

class LogHelper
{
    public static ?string $auditTrailId = null;
    public static ?array $oldData = null;

    /**
     * Store error in the log file.
     *
     * @param string $error
     * @param string $method
     * @return void
     */
    public static function error(string $error, string $method = ""): void
    {
        Log::error("Error At : $method");
        Log::error("Error : " . $error);
    }

    /**
     * Store exception in the log file.
     *
     * @param Exception $e
     * @param string $method
     * @return void
     */
    public static function exception(Exception $e, string $method = ""): void
    {
        Log::error("Error At : $method");
        Log::error("Message : " . $e->getMessage());
        Log::error("Stack Trace : \n" . $e->getTraceAsString());
    }

    /**
     * Add audit trail to the database.
     *
     * @param Request $request
     * @param string $description
     * @return void
     */
    public static function auditTrail(Request $request, string $description = ''): void
    {
        $agent = new Agent();

        $data = [
            'user_id' => $user->id ?? null,
            'description' => $description,
            'url' => $request->url(),
            'ip_address' => $request->ip(),
            'browser' => $agent->browser() ? $agent->browser() . ' ' . $agent->version($agent->browser()) : null,
            'operating_system' => $agent->platform() ?? null,
            'user_agent' => $request->userAgent(),
        ];

        AuditTrail::create($data);
    }

    /**
     * Add audit trail detail to the database.
     *
     * @param string $category
     * @param string $action
     * @param array|null $oldData
     * @param array|null $newData
     * @return void
     */
    public static function auditTrailDetail(string $category = '', string $action = '', ?array $oldData = null, ?array $newData = null): void
    {
        $data = [
            'audit_trail_id' => self::$auditTrailId,
            'category' => $category,
            'action' => $action,
            'old_data' => $oldData ? json_encode($oldData) : null,
            'new_data' => $newData ? json_encode($newData) : null
        ];

        AuditTrailDetail::create($data);
    }
}
