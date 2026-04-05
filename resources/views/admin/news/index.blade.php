@extends('admin.layouts.app')

@section('title', 'News')
@section('page-title', 'News Management')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All News Articles</h5>
            <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Create News
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
                            <option value="announcement">Announcement</option>
                            <option value="achievement">Achievement</option>
                            <option value="research">Research</option>
                            <option value="partnership">Partnership</option>
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

            @if($news->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Featured</th>
                            <th>Published</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($news as $article)
                        <tr>
                            <td><strong>{{ Str::limit($article->title, 50) }}</strong></td>
                            <td><span class="badge bg-info">{{ ucfirst($article->category) }}</span></td>
                            <td><span class="badge bg-{{ $article->status === 'published' ? 'success' : 'warning' }}">{{ ucfirst($article->status) }}</span></td>
                            <td>
                                @if($article->is_featured)
                                <i class="fas fa-star text-warning"></i>
                                @endif
                            </td>
                            <td><small>{{ $article->published_at ? $article->published_at->format('M d, Y') : 'Not published' }}</small></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.news.edit', $article) }}" class="btn btn-outline-primary"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('admin.news.destroy', $article) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?');">
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
            {{ $news->links() }}
            @else
            <p class="text-center text-muted py-5">No news articles found.</p>
            @endif
        </div>
    </div>
</div>
@endsection
