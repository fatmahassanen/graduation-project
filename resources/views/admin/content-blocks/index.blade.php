@extends('admin.layouts.app')

@section('title', 'Content Blocks')
@section('page-title', 'Content Blocks')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Content Blocks for: {{ $page->title }}</h5>
            <a href="{{ route('admin.content-blocks.create', ['page_id' => $page->id]) }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Block
            </a>
        </div>
        <div class="card-body">
            @if($contentBlocks->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Type</th>
                            <th>Content Preview</th>
                            <th>Updated</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contentBlocks as $block)
                        <tr>
                            <td><span class="badge bg-secondary">{{ $block->display_order }}</span></td>
                            <td><span class="badge bg-info">{{ ucfirst($block->type) }}</span></td>
                            <td>
                                <small>
                                    @if($block->type === 'hero')
                                        {{ Str::limit($block->content['title'] ?? 'No title', 40) }}
                                    @elseif($block->type === 'text')
                                        {{ Str::limit(strip_tags($block->content['body'] ?? ''), 50) }}
                                    @elseif($block->type === 'card_grid')
                                        {{ count($block->content['cards'] ?? []) }} cards
                                    @elseif($block->type === 'faq')
                                        {{ count($block->content['items'] ?? []) }} FAQ items
                                    @else
                                        {{ ucfirst($block->type) }} block
                                    @endif
                                </small>
                            </td>
                            <td><small>{{ $block->updated_at->diffForHumans() }}</small></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.content-blocks.edit', $block) }}" class="btn btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.content-blocks.destroy', $block) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?');">
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
            @else
            <p class="text-center text-muted py-5">No content blocks yet. <a href="{{ route('admin.content-blocks.create', ['page_id' => $page->id]) }}">Add your first block</a></p>
            @endif

            <div class="mt-3">
                <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Page
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
