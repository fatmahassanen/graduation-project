@extends('admin.layouts.app')

@section('title', 'Pages')
@section('page-title', 'Pages Management')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Pages</h5>
            <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Create New Page
            </a>
        </div>
        <div class="card-body">
            <!-- Filters -->
            <form method="GET" action="{{ route('admin.pages.index') }}" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-3">
                        <input type="text" name="search" class="form-control" placeholder="Search pages..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <select name="category" class="form-select">
                            <option value="">All Categories</option>
                            <option value="admissions" {{ request('category') === 'admissions' ? 'selected' : '' }}>Admissions</option>
                            <option value="faculties" {{ request('category') === 'faculties' ? 'selected' : '' }}>Faculties</option>
                            <option value="events" {{ request('category') === 'events' ? 'selected' : '' }}>Events</option>
                            <option value="about" {{ request('category') === 'about' ? 'selected' : '' }}>About</option>
                            <option value="quality" {{ request('category') === 'quality' ? 'selected' : '' }}>Quality</option>
                            <option value="media" {{ request('category') === 'media' ? 'selected' : '' }}>Media</option>
                            <option value="campus" {{ request('category') === 'campus' ? 'selected' : '' }}>Campus</option>
                            <option value="staff" {{ request('category') === 'staff' ? 'selected' : '' }}>Staff</option>
                            <option value="student_services" {{ request('category') === 'student_services' ? 'selected' : '' }}>Student Services</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                            <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Archived</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="language" class="form-select">
                            <option value="">All Languages</option>
                            <option value="en" {{ request('language') === 'en' ? 'selected' : '' }}>English</option>
                            <option value="ar" {{ request('language') === 'ar' ? 'selected' : '' }}>Arabic</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-secondary">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Clear
                        </a>
                    </div>
                </div>
            </form>

            <!-- Pages Table -->
            @if($pages->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Language</th>
                            <th>Updated</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pages as $page)
                        <tr>
                            <td>
                                <strong>{{ $page->title }}</strong>
                                <br>
                                <small class="text-muted">/{{ $page->slug }}</small>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $page->category)) }}</span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $page->status === 'published' ? 'success' : ($page->status === 'draft' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($page->status) }}
                                </span>
                            </td>
                            <td>{{ strtoupper($page->language) }}</td>
                            <td>
                                <small>{{ $page->updated_at->diffForHumans() }}</small>
                                <br>
                                <small class="text-muted">by {{ $page->updater->name ?? $page->creator->name }}</small>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    @if($page->status === 'draft')
                                    <form action="{{ route('admin.pages.publish', $page) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-outline-success" title="Publish">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    @elseif($page->status === 'published')
                                    <form action="{{ route('admin.pages.unpublish', $page) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-outline-warning" title="Unpublish">
                                            <i class="fas fa-pause"></i>
                                        </button>
                                    </form>
                                    @endif

                                    <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this page?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Delete">
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

            <!-- Pagination -->
            <div class="mt-3">
                {{ $pages->links() }}
            </div>
            @else
            <div class="text-center py-5">
                <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                <p class="text-muted">No pages found. <a href="{{ route('admin.pages.create') }}">Create your first page</a></p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
