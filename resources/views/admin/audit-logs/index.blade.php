@extends('admin.layouts.app')

@section('title', 'Audit Logs')
@section('page-title', 'Audit Logs')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">System Audit Logs</h5>
        </div>
        <div class="card-body">
            <!-- Filters -->
            <form method="GET" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-2">
                        <select name="user_id" class="form-select">
                            <option value="">All Users</option>
                            @foreach(\App\Models\User::orderBy('name')->get() as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="action" class="form-select">
                            <option value="">All Actions</option>
                            <option value="created">Created</option>
                            <option value="updated">Updated</option>
                            <option value="deleted">Deleted</option>
                            <option value="published">Published</option>
                            <option value="unpublished">Unpublished</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="model_type" class="form-select">
                            <option value="">All Models</option>
                            <option value="App\Models\Page">Pages</option>
                            <option value="App\Models\ContentBlock">Content Blocks</option>
                            <option value="App\Models\Media">Media</option>
                            <option value="App\Models\Event">Events</option>
                            <option value="App\Models\News">News</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-secondary w-100">Filter</button>
                    </div>
                </div>
            </form>

            @if($logs->count() > 0)
            <div class="table-responsive">
                <table class="table table-sm table-hover">
                    <thead>
                        <tr>
                            <th>Date/Time</th>
                            <th>User</th>
                            <th>Action</th>
                            <th>Model</th>
                            <th>IP Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $log)
                        <tr>
                            <td><small>{{ $log->created_at->format('M d, Y H:i:s') }}</small></td>
                            <td>{{ $log->user->name }}</td>
                            <td>
                                <span class="badge bg-{{ $log->action === 'created' ? 'success' : ($log->action === 'deleted' ? 'danger' : 'info') }}">
                                    {{ ucfirst($log->action) }}
                                </span>
                            </td>
                            <td><small>{{ class_basename($log->model_type) }} #{{ $log->model_id }}</small></td>
                            <td><small>{{ $log->ip_address }}</small></td>
                            <td>
                                <a href="{{ route('admin.audit-logs.show', $log) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $logs->links() }}
            @else
            <p class="text-center text-muted py-5">No audit logs found.</p>
            @endif
        </div>
    </div>
</div>
@endsection
