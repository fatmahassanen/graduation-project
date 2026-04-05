@extends('admin.layouts.app')

@section('title', 'Revisions')
@section('page-title', 'Revision History')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                Revision History for {{ class_basename($model) }} #{{ $model->id }}
                @if(method_exists($model, 'title'))
                - {{ $model->title }}
                @endif
            </h5>
        </div>
        <div class="card-body">
            @if($revisions->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Date/Time</th>
                            <th>User</th>
                            <th>Action</th>
                            <th>Changes</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($revisions as $revision)
                        <tr>
                            <td><small>{{ $revision->created_at->format('M d, Y H:i:s') }}</small></td>
                            <td>{{ $revision->user->name }}</td>
                            <td>
                                <span class="badge bg-{{ $revision->action === 'created' ? 'success' : ($revision->action === 'deleted' ? 'danger' : 'info') }}">
                                    {{ ucfirst($revision->action) }}
                                </span>
                            </td>
                            <td>
                                <small>
                                    @if($revision->new_values)
                                    {{ count($revision->new_values) }} field(s) changed
                                    @else
                                    No changes recorded
                                    @endif
                                </small>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.revisions.show', $revision) }}" class="btn btn-outline-primary">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    @if($revision->action !== 'deleted')
                                    <form action="{{ route('admin.revisions.restore', $revision) }}" method="POST" class="d-inline" onsubmit="return confirm('Restore this revision?');">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-success">
                                            <i class="fas fa-undo"></i> Restore
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-center text-muted py-5">No revisions found.</p>
            @endif
        </div>
    </div>
</div>
@endsection
