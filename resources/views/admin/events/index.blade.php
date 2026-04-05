@extends('admin.layouts.app')

@section('title', 'Events')
@section('page-title', 'Events Management')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Events</h5>
            <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Create Event
            </a>
        </div>
        <div class="card-body">
            <!-- Filters -->
            <form method="GET" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-3">
                        <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <select name="category" class="form-select">
                            <option value="">All Categories</option>
                            <option value="competition">Competition</option>
                            <option value="conference">Conference</option>
                            <option value="exhibition">Exhibition</option>
                            <option value="workshop">Workshop</option>
                            <option value="seminar">Seminar</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-secondary">Filter</button>
                    </div>
                </div>
            </form>

            @if($events->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($events as $event)
                        <tr>
                            <td><strong>{{ $event->title }}</strong></td>
                            <td><span class="badge bg-info">{{ ucfirst($event->category) }}</span></td>
                            <td>{{ $event->start_date->format('M d, Y') }}</td>
                            <td><span class="badge bg-{{ $event->status === 'published' ? 'success' : 'warning' }}">{{ ucfirst($event->status) }}</span></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-outline-primary"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $events->links() }}
            @else
            <p class="text-center text-muted py-5">No events found.</p>
            @endif
        </div>
    </div>
</div>
@endsection
