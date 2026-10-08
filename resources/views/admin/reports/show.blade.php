@extends('layouts.admin')

@section('title', 'User Report')

@section('content')
    @php
        $reporter = $report->reporter;
        $reporterName = $reporter
            ? (trim(($reporter->first_name ?? '') . ' ' . ($reporter->last_name ?? '')) ?: $reporter->email)
            : '—';
        $reported = $report->reported;
        $reportedName = $reported
            ? (trim(($reported->first_name ?? '') . ' ' . ($reported->last_name ?? '')) ?: $reported->email)
            : '—';
    @endphp

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><span class="text-body-secondary fw-light">Moderation / User Reports /</span> #{{ $report->id }}</h4>
        <div class="d-flex gap-2">
            <form action="{{ route('admin.reports.destroy', $report->id) }}" method="POST"
                onsubmit="return confirm('Delete this report?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
            </form>
            <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-secondary">
                <i class="icon-base ti tabler-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header border-bottom"><h5 class="card-title mb-0">Reporter</h5></div>
                <div class="card-body">
                    <p class="mb-1 fw-medium">{{ $reporterName }}</p>
                    <p class="text-body-secondary mb-0">{{ $reporter->email ?? '—' }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header border-bottom"><h5 class="card-title mb-0">Reported User</h5></div>
                <div class="card-body">
                    <p class="mb-1 fw-medium">{{ $reportedName }}</p>
                    <p class="text-body-secondary mb-0">{{ $reported->email ?? '—' }}</p>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom"><h5 class="card-title mb-0">Report Details</h5></div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-3 text-body-secondary fw-normal">Reason</dt>
                        <dd class="col-sm-9">{{ $report->reason ?: '—' }}</dd>

                        <dt class="col-sm-3 text-body-secondary fw-normal">Description</dt>
                        <dd class="col-sm-9" style="white-space: pre-wrap;">{{ $report->description ?: '—' }}</dd>

                        <dt class="col-sm-3 text-body-secondary fw-normal">Created</dt>
                        <dd class="col-sm-9">{{ optional($report->created_at)->format('M d, Y H:i') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection
