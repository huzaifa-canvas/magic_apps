@extends('layouts.admin')

@section('title', 'Consultation')

@section('content')
    @php
        $owner = $consultation->user;
        $ownerName = $owner
            ? (trim(($owner->first_name ?? '') . ' ' . ($owner->last_name ?? '')) ?: $owner->email)
            : '—';
        $tags = is_array($consultation->tags) ? $consultation->tags : [];
    @endphp

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><span class="text-body-secondary fw-light">Moderation / Consultations /</span> #{{ $consultation->id }}</h4>
        <div class="d-flex gap-2">
            <form action="{{ route('admin.consultations.toggle-status', $consultation->id) }}" method="POST">
                @csrf
                <button type="submit"
                    class="btn btn-sm {{ $consultation->status === 'active' ? 'btn-outline-warning' : 'btn-outline-success' }}">
                    {{ $consultation->status === 'active' ? 'Deactivate' : 'Activate' }}
                </button>
            </form>
            <a href="{{ route('admin.consultations.index') }}" class="btn btn-outline-secondary">
                <i class="icon-base ti tabler-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header border-bottom"><h5 class="card-title mb-0">{{ $consultation->title ?: '—' }}</h5></div>
                <div class="card-body">
                    <p class="mb-4" style="white-space: pre-wrap;">{{ $consultation->description ?: '—' }}</p>

                    <h6 class="mb-2">Tags</h6>
                    @if (empty($tags))
                        <p class="text-body-secondary mb-0">No tags.</p>
                    @else
                        @foreach ($tags as $tag)
                            <span class="badge bg-label-primary me-1">{{ $tag }}</span>
                        @endforeach
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

                        <dt class="col-sm-5 text-body-secondary fw-normal">Category</dt>
                        <dd class="col-sm-7">{{ $consultation->category->name ?? 'N/A' }}</dd>

                        <dt class="col-sm-5 text-body-secondary fw-normal">Status</dt>
                        <dd class="col-sm-7">
                            <span class="badge bg-label-{{ $consultation->status === 'active' ? 'success' : 'secondary' }}">
                                {{ ucfirst($consultation->status) }}
                            </span>
                        </dd>

                        <dt class="col-sm-5 text-body-secondary fw-normal">Created</dt>
                        <dd class="col-sm-7">{{ optional($consultation->created_at)->format('M d, Y H:i') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection
