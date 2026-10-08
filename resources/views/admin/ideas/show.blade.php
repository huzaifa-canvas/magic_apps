@extends('layouts.admin')

@section('title', 'Idea')

@section('content')
    @php
        $owner = $idea->user;
        $ownerName = $owner
            ? (trim(($owner->first_name ?? '') . ' ' . ($owner->last_name ?? '')) ?: $owner->email)
            : '—';
    @endphp

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><span class="text-body-secondary fw-light">Moderation / Ideas /</span> #{{ $idea->id }}</h4>
        <div class="d-flex gap-2">
            <form action="{{ route('admin.ideas.toggle-publish', $idea->id) }}" method="POST">
                @csrf
                <button type="submit"
                    class="btn btn-sm {{ $idea->is_published ? 'btn-outline-warning' : 'btn-outline-success' }}">
                    {{ $idea->is_published ? 'Unpublish' : 'Publish' }}
                </button>
            </form>
            <form action="{{ route('admin.ideas.toggle-featured', $idea->id) }}" method="POST">
                @csrf
                <button type="submit"
                    class="btn btn-sm {{ $idea->is_featured ? 'btn-outline-secondary' : 'btn-outline-primary' }}">
                    {{ $idea->is_featured ? 'Unfeature' : 'Feature' }}
                </button>
            </form>
            <a href="{{ route('admin.ideas.index') }}" class="btn btn-outline-secondary">
                <i class="icon-base ti tabler-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header border-bottom">
                    <h5 class="card-title mb-0">
                        {{ $idea->title ?: '—' }}
                        @if ($idea->is_featured)
                            <span class="badge bg-label-warning ms-2">⭐ Featured</span>
                        @endif
                    </h5>
                </div>
                <div class="card-body">
                    <h6 class="mb-2">Description</h6>
                    <p class="mb-4" style="white-space: pre-wrap;">{{ $idea->description ?: '—' }}</p>

                    <h6 class="mb-2">Improvement</h6>
                    <p class="mb-4" style="white-space: pre-wrap;">{{ $idea->improvement ?: '—' }}</p>

                    <h6 class="mb-2">Benefits</h6>
                    <p class="mb-0" style="white-space: pre-wrap;">{{ $idea->benefits ?: '—' }}</p>
                </div>
            </div>

            <div class="card">
                <div class="card-header border-bottom"><h5 class="card-title mb-0">Attachments</h5></div>
                <div class="card-body">
                    @if ($idea->attachments->isEmpty())
                        <p class="text-body-secondary mb-0">No attachments.</p>
                    @else
                        <div class="row g-3">
                            @foreach ($idea->attachments as $attachment)
                                <div class="col-md-4">
                                    @if (\Illuminate\Support\Str::startsWith($attachment->mime_type ?? '', 'image'))
                                        <img src="{{ $attachment->file_path }}" alt="Attachment"
                                            class="img-fluid rounded border">
                                    @else
                                        <a href="{{ $attachment->file_path }}" target="_blank"
                                            class="btn btn-outline-primary w-100">
                                            <i class="icon-base ti tabler-paperclip me-1"></i>
                                            {{ $attachment->mime_type ?: 'View attachment' }}
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header border-bottom"><h5 class="card-title mb-0">Details</h5></div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-5 text-body-secondary fw-normal">User</dt>
                        <dd class="col-sm-7">{{ $ownerName }}</dd>

                        <dt class="col-sm-5 text-body-secondary fw-normal">Published</dt>
                        <dd class="col-sm-7">
                            <span class="badge bg-label-{{ $idea->is_published ? 'success' : 'secondary' }}">
                                {{ $idea->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </dd>

                        <dt class="col-sm-5 text-body-secondary fw-normal">Featured</dt>
                        <dd class="col-sm-7">
                            <span class="badge bg-label-{{ $idea->is_featured ? 'warning' : 'secondary' }}">
                                {{ $idea->is_featured ? 'Yes' : 'No' }}
                            </span>
                        </dd>

                        <dt class="col-sm-5 text-body-secondary fw-normal">Featured at</dt>
                        <dd class="col-sm-7">{{ optional($idea->featured_at)->format('M d, Y H:i') ?: '—' }}</dd>

                        <dt class="col-sm-5 text-body-secondary fw-normal">Created</dt>
                        <dd class="col-sm-7">{{ optional($idea->created_at)->format('M d, Y H:i') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection
