@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row">
        <!-- Total Pages -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Pages
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\Page::count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <small class="text-success">
                            <i class="fas fa-check-circle"></i>
                            {{ \App\Models\Page::where('status', 'published')->count() }} Published
                        </small>
                        <small class="text-warning ms-2">
                            <i class="fas fa-clock"></i>
                            {{ \App\Models\Page::where('status', 'draft')->count() }} Drafts
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Media Files -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Media Files
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\Media::count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-images fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <small class="text-muted">
                            {{ number_format(\App\Models\Media::sum('size') / 1024 / 1024, 2) }} MB Total
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Events -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Events
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\Event::count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <small class="text-info">
                            <i class="fas fa-arrow-up"></i>
                            {{ \App\Models\Event::where('start_date', '>=', now())->count() }} Upcoming
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total News Articles -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                News Articles
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\News::count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-newspaper fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <small class="text-warning">
                            <i class="fas fa-star"></i>
                            {{ \App\Models\News::where('is_featured', true)->count() }} Featured
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Pages -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold">Recent Pages</h6>
                    <a href="{{ route('admin.pages.index') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body">
                    @php
                        $recentPages = \App\Models\Page::with('creator')
                            ->orderBy('updated_at', 'desc')
                            ->limit(5)
                            ->get();
                    @endphp

                    @if($recentPages->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Updated</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentPages as $page)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.pages.edit', $page) }}">
                                            {{ Str::limit($page->title, 30) }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $page->status === 'published' ? 'success' : ($page->status === 'draft' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($page->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <small>{{ $page->updated_at->diffForHumans() }}</small>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-muted text-center py-4">No pages yet. <a href="{{ route('admin.pages.create') }}">Create your first page</a></p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Contact Submissions -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold">Recent Contact Submissions</h6>
                    <a href="{{ route('admin.contacts.index') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body">
                    @php
                        $recentContacts = \App\Models\ContactSubmission::orderBy('created_at', 'desc')
                            ->limit(5)
                            ->get();
                    @endphp

                    @if($recentContacts->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Subject</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentContacts as $contact)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.contacts.show', $contact) }}">
                                            {{ Str::limit($contact->name, 20) }}
                                        </a>
                                    </td>
                                    <td>{{ Str::limit($contact->subject, 25) }}</td>
                                    <td>
                                        @if($contact->is_read)
                                        <span class="badge bg-secondary">Read</span>
                                        @else
                                        <span class="badge bg-primary">Unread</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>{{ $contact->created_at->diffForHumans() }}</small>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-muted text-center py-4">No contact submissions yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.pages.create') }}" class="btn btn-primary btn-block w-100">
                                <i class="fas fa-plus-circle"></i> Create New Page
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.media.create') }}" class="btn btn-success btn-block w-100">
                                <i class="fas fa-upload"></i> Upload Media
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.events.create') }}" class="btn btn-info btn-block w-100">
                                <i class="fas fa-calendar-plus"></i> Add Event
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.news.create') }}" class="btn btn-warning btn-block w-100">
                                <i class="fas fa-newspaper"></i> Create News
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(auth()->user()->role === 'super_admin')
    <!-- System Information (Super Admin Only) -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">System Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <p><strong>Total Users:</strong> {{ \App\Models\User::count() }}</p>
                            <p><strong>Content Editors:</strong> {{ \App\Models\User::where('role', 'content_editor')->count() }}</p>
                            <p><strong>Faculty Admins:</strong> {{ \App\Models\User::where('role', 'faculty_admin')->count() }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Total Revisions:</strong> {{ \App\Models\Revision::count() }}</p>
                            <p><strong>Audit Logs:</strong> {{ \App\Models\AuditLog::count() }}</p>
                            <p><strong>Content Blocks:</strong> {{ \App\Models\ContentBlock::count() }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Laravel Version:</strong> {{ app()->version() }}</p>
                            <p><strong>PHP Version:</strong> {{ phpversion() }}</p>
                            <p><strong>Environment:</strong> {{ app()->environment() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@push('styles')
<style>
    .border-left-primary {
        border-left: 4px solid var(--primary) !important;
    }
    .border-left-success {
        border-left: 4px solid var(--success) !important;
    }
    .border-left-info {
        border-left: 4px solid var(--info) !important;
    }
    .border-left-warning {
        border-left: 4px solid var(--warning) !important;
    }
</style>
@endpush
@endsection
