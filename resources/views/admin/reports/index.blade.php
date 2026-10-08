@extends('layouts.admin')

@section('title', 'User Reports')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><span class="text-body-secondary fw-light">Moderation /</span> User Reports</h4>
    </div>

    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="card-title mb-0">All Reports</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover border-top">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Reporter</th>
                        <th>Reported User</th>
                        <th>Reason</th>
                        <th>Created</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reports as $report)
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
                        <tr>
                            <td><span class="text-body-secondary">#{{ $report->id }}</span></td>
                            <td>{{ $reporterName }}</td>
                            <td>{{ $reportedName }}</td>
                            <td>{{ $report->reason ?: '—' }}</td>
                            <td>
                                <span class="text-nowrap">{{ optional($report->created_at)->format('M d, Y') }}</span>
                                <small class="d-block text-body-secondary">{{ optional($report->created_at)->format('g:i A') }}</small>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.reports.show', $report->id) }}"
                                    class="btn btn-sm btn-outline-secondary">View</a>
                                <form action="{{ route('admin.reports.destroy', $report->id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Delete this report?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-body-secondary py-5">No reports found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($reports->hasPages())
            <div class="card-footer">{{ $reports->links() }}</div>
        @endif
    </div>
@endsection
