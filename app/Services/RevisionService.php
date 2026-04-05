<?php

namespace App\Services;

use App\Models\Revision;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class RevisionService
{
    /**
     * Create a revision record for a model.
     */
    public function createRevision(Model $model, array $oldValues, array $newValues, User $user): Revision
    {
        return $model->revisions()->create([
            'user_id' => $user->id,
            'action' => $this->determineAction($oldValues, $newValues),
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'created_at' => now(),
        ]);
    }

    /**
     * Get revision history for a model, ordered by most recent first.
     */
    public function getRevisionHistory(Model $model): Collection
    {
        return $model->revisions()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Restore a model to a previous revision state.
     * Creates a new revision to track the restoration.
     */
    public function restoreRevision(Revision $revision, User $user): Model
    {
        $model = $revision->revisionable;
        
        // Capture current values before restoration
        $currentValues = $model->toArray();
        
        // Get the old values from the revision to restore
        $restoreValues = $revision->old_values;
        
        // Filter out non-fillable attributes and timestamps
        $fillableValues = array_intersect_key(
            $restoreValues,
            array_flip($model->getFillable())
        );
        
        // Update the model with restored values
        $model->update($fillableValues);
        $model->refresh();
        
        // Create a new revision to track the restoration
        $this->createRevision($model, $currentValues, $model->toArray(), $user);
        
        return $model;
    }

    /**
     * Compare two revisions and return the differences.
     * Returns an array with 'added', 'removed', and 'changed' keys.
     */
    public function compareRevisions(Revision $revision1, Revision $revision2): array
    {
        $values1 = $revision1->new_values;
        $values2 = $revision2->new_values;
        
        $diff = [
            'added' => [],
            'removed' => [],
            'changed' => [],
        ];
        
        // Find added and changed fields
        foreach ($values2 as $key => $value) {
            if (!array_key_exists($key, $values1)) {
                $diff['added'][$key] = $value;
            } elseif ($values1[$key] !== $value) {
                $diff['changed'][$key] = [
                    'old' => $values1[$key],
                    'new' => $value,
                ];
            }
        }
        
        // Find removed fields
        foreach ($values1 as $key => $value) {
            if (!array_key_exists($key, $values2)) {
                $diff['removed'][$key] = $value;
            }
        }
        
        return $diff;
    }

    /**
     * Determine the action type based on old and new values.
     */
    protected function determineAction(array $oldValues, array $newValues): string
    {
        if (empty($oldValues) && !empty($newValues)) {
            return 'created';
        }
        
        if (!empty($oldValues) && empty($newValues)) {
            return 'deleted';
        }
        
        return 'updated';
    }
}
