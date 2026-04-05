@extends('admin.layouts.app')

@section('title', 'Compare Revisions')
@section('page-title', 'Compare Revisions')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Revision Comparison</h5>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="card-title">Revision #{{ $revision1->id }}</h6>
                            <p class="card-text small mb-1">
                                <strong>Date:</strong> {{ $revision1->created_at->format('M d, Y H:i:s') }}<br>
                                <strong>User:</strong> {{ $revision1->user->name }}<br>
                                <strong>Action:</strong> {{ ucfirst($revision1->action) }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="card-title">Revision #{{ $revision2->id }}</h6>
                            <p class="card-text small mb-1">
                                <strong>Date:</strong> {{ $revision2->created_at->format('M d, Y H:i:s') }}<br>
                                <strong>User:</strong> {{ $revision2->user->name }}<br>
                                <strong>Action:</strong> {{ ucfirst($revision2->action) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <h6 class="mb-3">Changes</h6>

            @if(count($diff['changed']) > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Field</th>
                            <th class="bg-danger bg-opacity-10">Old Value (Revision #{{ $revision1->id }})</th>
                            <th class="bg-success bg-opacity-10">New Value (Revision #{{ $revision2->id }})</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($diff['changed'] as $field => $values)
                        <tr>
                            <td><strong>{{ ucfirst(str_replace('_', ' ', $field)) }}</strong></td>
                            <td class="bg-danger bg-opacity-10">
                                <pre class="mb-0">{{ is_array($values['old']) ? json_encode($values['old'], JSON_PRETTY_PRINT) : $values['old'] }}</pre>
                            </td>
                            <td class="bg-success bg-opacity-10">
                                <pre class="mb-0">{{ is_array($values['new']) ? json_encode($values['new'], JSON_PRETTY_PRINT) : $values['new'] }}</pre>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            @if(count($diff['added']) > 0)
            <h6 class="mt-4 mb-3">Added Fields</h6>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Field</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($diff['added'] as $field => $value)
                        <tr class="bg-success bg-opacity-10">
                            <td><strong>{{ ucfirst(str_replace('_', ' ', $field)) }}</strong></td>
                            <td><pre class="mb-0">{{ is_array($value) ? json_encode($value, JSON_PRETTY_PRINT) : $value }}</pre></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            @if(count($diff['removed']) > 0)
            <h6 class="mt-4 mb-3">Removed Fields</h6>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Field</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($diff['removed'] as $field => $value)
                        <tr class="bg-danger bg-opacity-10">
                            <td><strong>{{ ucfirst(str_replace('_', ' ', $field)) }}</strong></td>
                            <td><pre class="mb-0">{{ is_array($value) ? json_encode($value, JSON_PRETTY_PRINT) : $value }}</pre></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            @if(count($diff['changed']) === 0 && count($diff['added']) === 0 && count($diff['removed']) === 0)
            <p class="text-center text-muted py-4">No differences found between these revisions.</p>
            @endif

            <div class="mt-4">
                <a href="{{ route('admin.revisions.index', ['revisionable_type' => get_class($revision1->revisionable), 'revisionable_id' => $revision1->revisionable_id]) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Revisions
                </a>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    pre {
        white-space: pre-wrap;
        word-wrap: break-word;
        font-size: 0.875rem;
    }
</style>
@endpush
@endsection
