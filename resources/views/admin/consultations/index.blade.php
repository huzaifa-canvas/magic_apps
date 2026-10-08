@extends('layouts.admin')

@section('title', 'Consultations')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><span class="text-body-secondary fw-light">Moderation /</span> Consultations</h4>
    </div>

    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="card-title mb-0">All Consultations</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover border-top">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($consultations as $consultation)
                        @php
                            $owner = $consultation->user;
                            $ownerName = $owner
                                ? (trim(($owner->first_name ?? '') . ' ' . ($owner->last_name ?? '')) ?: $owner->email)
                                : '—';
                        @endphp
                        <tr>
                            <td><span class="text-body-secondary">#{{ $consultation->id }}</span></td>
                            <td>{{ $ownerName }}</td>
                            <td>{{ $consultation->title ?: '—' }}</td>
                            <td>{{ $consultation->category->name ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-label-{{ $consultation->status === 'active' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($consultation->status) }}
                                </span>
                            </td>
                            <td>
                                <span class="text-nowrap">{{ optional($consultation->created_at)->format('M d, Y') }}</span>
                                <small class="d-block text-body-secondary">{{ optional($consultation->created_at)->format('g:i A') }}</small>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.consultations.show', $consultation->id) }}"
                                    class="btn btn-sm btn-outline-secondary">View</a>
                                <form action="{{ route('admin.consultations.toggle-status', $consultation->id) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit"
                                        class="btn btn-sm {{ $consultation->status === 'active' ? 'btn-outline-warning' : 'btn-outline-success' }}">
                                        {{ $consultation->status === 'active' ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.consultations.destroy', $consultation->id) }}"
                                    method="POST" class="d-inline" onsubmit="return confirm('Delete this consultation?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-body-secondary py-5">No consultations found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($consultations->hasPages())
            <div class="card-footer">{{ $consultations->links() }}</div>
        @endif
    </div>
@endsection
