@extends('admin.layouts.app')

@section('title', 'Contact Submissions')
@section('page-title', 'Contact Submissions')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Contact Form Submissions</h5>
        </div>
        <div class="card-body">
            <!-- Filters -->
            <form method="GET" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-3">
                        <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <select name="is_read" class="form-select">
                            <option value="">All Status</option>
                            <option value="0" {{ request('is_read') === '0' ? 'selected' : '' }}>Unread</option>
                            <option value="1" {{ request('is_read') === '1' ? 'selected' : '' }}>Read</option>
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

            @if($submissions->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($submissions as $submission)
                        <tr class="{{ !$submission->is_read ? 'table-primary' : '' }}">
                            <td>
                                @if($submission->is_read)
                                <i class="fas fa-envelope-open text-secondary"></i>
                                @else
                                <i class="fas fa-envelope text-primary"></i>
                                @endif
                            </td>
                            <td><strong>{{ $submission->name }}</strong></td>
                            <td>{{ $submission->email }}</td>
                            <td>{{ Str::limit($submission->subject, 40) }}</td>
                            <td><small>{{ $submission->created_at->diffForHumans() }}</small></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.contacts.show', $submission) }}" class="btn btn-outline-primary">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <form action="{{ route('admin.contacts.destroy', $submission) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $submissions->links() }}
            @else
            <p class="text-center text-muted py-5">No contact submissions found.</p>
            @endif
        </div>
    </div>
</div>
@endsection
