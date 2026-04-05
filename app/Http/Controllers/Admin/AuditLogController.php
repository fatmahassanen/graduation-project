<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuditLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin');
    }

    /**
     * Display a listing of audit logs.
     */
    public function index(Request $request): View
    {
        $query = AuditLog::with('user');

        // Apply filters
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('model_type')) {
            $query->where('model_type', $request->model_type);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Order by most recent first
        $logs = $query->orderBy('created_at', 'desc')->paginate(50);

        return view('admin.audit-logs.index', compact('logs'));
    }

    /**
     * Display the specified audit log entry.
     */
    public function show(AuditLog $auditLog): View
    {
        $auditLog->load('user');

        // Calculate diff between old and new values
        $diff = $this->calculateDiff($auditLog->old_values ?? [], $auditLog->new_values ?? []);

        return view('admin.audit-logs.show', compact('auditLog', 'diff'));
    }

    /**
     * Calculate the difference between old and new values.
     */
    protected function calculateDiff(array $oldValues, array $newValues): array
    {
        $diff = [
            'added' => [],
            'removed' => [],
            'changed' => [],
        ];

        // Find added and changed fields
        foreach ($newValues as $key => $value) {
            if (!array_key_exists($key, $oldValues)) {
                $diff['added'][$key] = $value;
            } elseif ($oldValues[$key] !== $value) {
                $diff['changed'][$key] = [
                    'old' => $oldValues[$key],
                    'new' => $value,
                ];
            }
        }

        // Find removed fields
        foreach ($oldValues as $key => $value) {
            if (!array_key_exists($key, $newValues)) {
                $diff['removed'][$key] = $value;
            }
        }

        return $diff;
    }
}
