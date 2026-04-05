<?php

namespace App\Observers;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;

class AuditLogObserver
{
    /**
     * Handle the model "created" event.
     */
    public function created(Model $model): void
    {
        $this->logAction($model, 'created', [], $model->toArray());
    }

    /**
     * Handle the model "updated" event.
     */
    public function updated(Model $model): void
    {
        $oldValues = $model->getOriginal();
        $newValues = $model->getAttributes();

        // Only log if there are actual changes
        // Use serialize for comparison to handle nested arrays
        if ($this->hasChanges($oldValues, $newValues)) {
            $this->logAction($model, 'updated', $oldValues, $newValues);
        }
    }

    /**
     * Check if there are changes between old and new values.
     * Handles nested arrays properly.
     */
    protected function hasChanges(array $oldValues, array $newValues): bool
    {
        // Serialize both arrays for comparison to handle nested arrays
        return serialize($oldValues) !== serialize($newValues);
    }

    /**
     * Handle the model "deleted" event.
     */
    public function deleted(Model $model): void
    {
        $this->logAction($model, 'deleted', $model->toArray(), []);
    }

    /**
     * Log an action to the audit_logs table.
     */
    protected function logAction(Model $model, string $action, array $oldValues, array $newValues): void
    {
        // Skip logging if no authenticated user (e.g., during seeding or console commands)
        if (!auth()->check()) {
            return;
        }

        // Filter out sensitive fields
        $sensitiveFields = ['password', 'remember_token'];
        $oldValues = array_diff_key($oldValues, array_flip($sensitiveFields));
        $newValues = array_diff_key($newValues, array_flip($sensitiveFields));

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'model_type' => get_class($model),
            'model_id' => $model->id ?? null,
            'old_values' => !empty($oldValues) ? $oldValues : null,
            'new_values' => !empty($newValues) ? $newValues : null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
