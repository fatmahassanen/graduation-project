@extends('admin.layouts.app')

@section('title', 'Contact Submission')
@section('page-title', 'Contact Submission Details')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Contact Submission #{{ $contact->id }}</h5>
                    @if(!$contact->is_read)
                    <span class="badge bg-primary">Unread</span>
                    @else
                    <span class="badge bg-secondary">Read</span>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Name:</strong> {{ $contact->name }}</p>
                            <p class="mb-2"><strong>Email:</strong> <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></p>
                            @if($contact->phone)
                            <p class="mb-2"><strong>Phone:</strong> {{ $contact->phone }}</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Submitted:</strong> {{ $contact->created_at->format('M d, Y H:i') }}</p>
                            <p class="mb-2"><strong>IP Address:</strong> {{ $contact->ip_address }}</p>
                            @if($contact->is_read && $contact->reader)
                            <p class="mb-2"><strong>Read by:</strong> {{ $contact->reader->name }}</p>
                            <p class="mb-2"><strong>Read at:</strong> {{ $contact->read_at->format('M d, Y H:i') }}</p>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <h6>Subject:</h6>
                        <p>{{ $contact->subject }}</p>
                    </div>

                    <div class="mb-3">
                        <h6>Message:</h6>
                        <div class="bg-light p-3 rounded">
                            <p class="mb-0" style="white-space: pre-wrap;">{{ $contact->message }}</p>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex gap-2">
                        <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}" class="btn btn-primary">
                            <i class="fas fa-reply"></i> Reply via Email
                        </a>
                        
                        @if(!$contact->is_read)
                        <form action="{{ route('admin.contacts.mark-as-read', $contact) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check"></i> Mark as Read
                            </button>
                        </form>
                        @endif

                        <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this submission?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>

                        <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary ms-auto">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
