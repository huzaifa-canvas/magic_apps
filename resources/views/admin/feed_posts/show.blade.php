@extends('layouts.admin')

@section('title', 'Feed Post')

@section('content')
    @php
        $author = $feedPost->user;
        $authorName = $author
            ? (trim(($author->first_name ?? '') . ' ' . ($author->last_name ?? '')) ?: $author->email)
            : '—';
        $privacyColor = [
            'public' => 'success',
            'friends' => 'info',
            'only_me' => 'secondary',
        ][$feedPost->privacy] ?? 'secondary';
    @endphp

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><span class="text-body-secondary fw-light">Moderation / Feed Posts /</span> #{{ $feedPost->id }}</h4>
        <div class="d-flex gap-2">
            <form action="{{ route('admin.feed-posts.toggle-publish', $feedPost->id) }}" method="POST">
                @csrf
                <button type="submit"
                    class="btn btn-sm {{ $feedPost->is_published ? 'btn-outline-warning' : 'btn-outline-success' }}">
                    {{ $feedPost->is_published ? 'Unpublish' : 'Publish' }}
                </button>
            </form>
            <a href="{{ route('admin.feed-posts.index') }}" class="btn btn-outline-secondary">
                <i class="icon-base ti tabler-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header border-bottom"><h5 class="card-title mb-0">Content</h5></div>
                <div class="card-body">
                    <p class="mb-0" style="white-space: pre-wrap;">{{ $feedPost->content ?: '—' }}</p>
                </div>
            </div>

            <div class="card">
                <div class="card-header border-bottom"><h5 class="card-title mb-0">Attachments</h5></div>
                <div class="card-body">
                    @if ($feedPost->attachments->isEmpty())
                        <p class="text-body-secondary mb-0">No attachments.</p>
                    @else
                        <div class="row g-3">
                            @foreach ($feedPost->attachments as $attachment)
                                <div class="col-md-4">
                                    @if (\Illuminate\Support\Str::startsWith($attachment->mime_type ?? '', 'image'))
                                        <img src="{{ $attachment->attachment_url }}" alt="Attachment"
                                            class="img-fluid rounded border">
                                    @else
                                        <a href="{{ $attachment->attachment_url }}" target="_blank"
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
                        <dt class="col-sm-5 text-body-secondary fw-normal">Author</dt>
                        <dd class="col-sm-7">{{ $authorName }}</dd>

                        <dt class="col-sm-5 text-body-secondary fw-normal">Privacy</dt>
                        <dd class="col-sm-7">
                            <span class="badge bg-label-{{ $privacyColor }}">
                                {{ ucfirst(str_replace('_', ' ', $feedPost->privacy)) }}
                            </span>
                        </dd>

                        <dt class="col-sm-5 text-body-secondary fw-normal">Published</dt>
                        <dd class="col-sm-7">
                            <span class="badge bg-label-{{ $feedPost->is_published ? 'success' : 'secondary' }}">
                                {{ $feedPost->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </dd>

                        <dt class="col-sm-5 text-body-secondary fw-normal">Comments</dt>
                        <dd class="col-sm-7">{{ $commentCount }}</dd>

                        <dt class="col-sm-5 text-body-secondary fw-normal">Created</dt>
                        <dd class="col-sm-7">{{ optional($feedPost->created_at)->format('M d, Y H:i') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection
